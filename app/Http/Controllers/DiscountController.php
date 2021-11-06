<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DiscountController extends Controller
{

    public function dataDiscount()
    {
        $product = Discount::leftJoin('products', 'products.id', '=', 'discounts.product_id')->select('discount', 'start', 'end', 'title', 'products.id', 'price', 'discounts.product_id')->orderBy('products.id', 'desc');
        return DataTables::of($product)
            ->addIndexColumn()
            ->addColumn('price_discount', function ($data) {
                $discount = ($data->discount / 100) * $data->price;
                return $discount;
            })
            ->addColumn('action', function ($data) {
                $action = '<div class="text-center"><a href="' . route("discount.edit", $data->id) . '" width="130" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a> | <button onclick="destroy(this.id)" id="' . $data->id . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>';
                return $action;
            })
            ->rawColumns(['action', 'price_discount'])
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
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
