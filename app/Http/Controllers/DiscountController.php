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
        $product = Discount::leftJoin('products', 'products.id', '=', 'discounts.product_id')->select('discount', 'start', 'end', 'title', 'products.id', 'price', 'price_discount', 'discounts.product_id')->orderBy('products.id', 'desc');
        return DataTables::of($product)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $action = '<div class="text-center"><a href="' . route("discount.edit", $data->id) . '" width="130" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a> | <button onclick="destroy(this.id)" id="' . $data->id . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>';
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
        $product = Product::find($request->product);
        $disc = Discount::where('product_id', $product->id)->first();
        $date = Carbon::now()->toDateString();

        // cek apakah sudah ada diskon yang masih berjalan
        if ($disc) {
            if ($disc->end > $date) {
                return redirect()->route('discount.create')->with('error', "sudah ada diskon yang masih berjalan pada produk ini");
            }
        }

        $this->validate($request, [
            'product' => 'required',
            'discount' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
