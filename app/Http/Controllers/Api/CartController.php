<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;

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
        $cart = Customer::with('product')->where('id', auth()->guard('api')->user()->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data cart',
            'data' => $cart
        ]);
    }
}
