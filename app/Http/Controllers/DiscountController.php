<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DiscountController extends Controller
{

    public function dataDiscount()
    {
        $product = Discount::leftJoin('products', 'products.id', '=', 'discounts.product_id')->select('discount', 'start', 'end', 'title', 'products.id', 'price', 'price_discount', 'discounts.product_id', 'discounts.id as diskon_id')->orderBy('products.id', 'desc');
        return DataTables::of($product)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $action = '<div class="text-center"><a href="' . route("discount.edit", $data->diskon_id) . '" width="130" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a> | <button onclick="destroy(this.id)" id="' . $data->diskon_id . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>';
                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.discount.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discount.create');
    }

    public function loadData(Request $request)
    {
        if ($request->has('q')) {
            $cari = $request->q;
            $data = DB::table('products')->select('id', 'title')->where('title', 'LIKE', '%' . $cari . '%')->get();
            return response()->json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'discount' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);
        $product = Product::find($request->product);
        $disc = Discount::where('product_id', $product->id)->get();
        $date = Carbon::now()->toDateString();

        if ($request->end < $request->start) {
            return redirect()->route('discount.create')->with('error', "Tentukan awal dan akhir diskon dengan benar");
        }

        // cek apakah sudah ada diskon yang masih berjalan
        if ($disc) {
            foreach ($disc as $value) {
                if ($value->end > $date) {
                    return redirect()->route('discount.create')->with('error', "sudah ada diskon yang masih berjalan pada produk ini");
                }
            }
        }

        $price = ($request->discount / 100) * $product->price;

        $discount = Discount::create([
            'product_id' => $request->product,
            'discount' => $request->discount,
            'price_discount' => $product->price - $price,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        if ($discount) {
            return redirect()->route('discount.index')->with('success', "Discount Successfully Added");
        } else {
            return redirect()->route('discount.index')->with('error', "Discount Failed To Added");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diskon = Discount::find($id);
        $product = Product::find($diskon->product_id);
        return view('admin.discount.edit', ['discount' => $diskon, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'discount' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $diskon = Discount::find($id);
        $product = Product::find($diskon->product_id);
        $disc = Discount::where('product_id', $product->id)->get();

        $price = ($request->discount / 100) * $product->price;

        $date = Carbon::now()->toDateString();

        if ($request->end < $request->start) {
            return redirect()->route('discount.edit', $id)->with('error', "Tentukan awal dan akhir diskon dengan benar");
        }

        // cek apakah sudah ada diskon yang masih berjalan
        if ($disc) {
            foreach ($disc as $value) {
                if ($value->end > $date) {
                    return redirect()->route('discount.edit', $id)->with('error', "sudah ada diskon yang masih berjalan pada produk ini");
                }
            }
        }

        $diskon->update([
            'discount' => $request->discount,
            'price_discount' => $product->price - $price,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        if ($diskon) {
            return redirect()->route('discount.index')->with('success', "Discount Successfully Updated");
        } else {
            return redirect()->route('discount.index')->with('error', "Discount Failed To Updated");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $diskon = Discount::find($id);
        $diskon->delete();

        if ($diskon) {
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}
