<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $cart = Customer::find(auth()->guard('api')->user()->id);
        $total = $cart->product()->sum('qty');
        $data = $cart->product()->leftjoin('discounts', function ($join) {
            $join->on('discounts.product_id', '=', 'products.id')
                ->where('discounts.start', '<=', Carbon::now()->toDateString())
                ->where('discounts.end', '>', Carbon::now()->toDateString());
        })->select('products.id', 'title', 'price', 'image', 'discount', 'price_discount')->orderby('products.created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data cart',
            'data' => $data,
            'total' => $total,
        ]);
    }
}
