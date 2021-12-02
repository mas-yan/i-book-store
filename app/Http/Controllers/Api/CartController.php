<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Customer::find(auth()->guard('api')->user()->id);
        $total = $cart->product()->sum('qty');
        $data = $cart->product()->leftjoin('discounts', function ($join) {
            $join->on('discounts.product_id', '=', 'products.id')
                ->where('discounts.start', '<=', Carbon::now()->toDateString())
                ->where('discounts.end', '>', Carbon::now()->toDateString());
        })->select('products.id', 'stok', 'berat', 'title', 'slug', 'price', 'image', 'discount', 'price_discount')->orderby('products.created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data cart',
            'data' => $data,
            'total' => $total,
        ]);
    }

    public function store(Product $product)
    {
        $customer = Customer::find(auth()->guard('api')->user()->id);
        $cart = $product->customer()->where('id', auth()->guard('api')->user()->id)->first();
        if ($cart) {
            $cart->pivot->qty += 1;
            $cart->pivot->save();
        } else {
            $product->customer()->attach($customer, ['qty' => 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Add Cart',
            'data' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        $customer = Customer::find(auth()->guard('api')->user()->id);
        $customer->product()->detach($product->id);
        return response()->json([
            'success' => true,
            'message' => 'Delete Cart',
            'data' => $product
        ]);
    }

    public function addQty(Product $product)
    {
        $cart = $product->customer()->where('id', auth()->guard('api')->user()->id)->first();
        $cart->pivot->qty += 1;
        $cart->pivot->save();

        return response()->json([
            'success' => true,
            'message' => 'Add qty',
            'data' => $cart->pivot->qty
        ]);
    }
    public function subtQty(Product $product)
    {
        $cart = $product->customer()->where('id', auth()->guard('api')->user()->id)->first();
        $cart->pivot->qty -= 1;
        $cart->pivot->save();

        return response()->json([
            'success' => true,
            'message' => 'Add qty',
            'data' => $cart->pivot->qty
        ]);
    }

    public function delete(Request $request)
    {
        $product = explode(",", $request->id);
        $user = Customer::find(auth()->guard('api')->user()->id);
        $user->product()->detach($product);

        return response()->json([
            'success' => true,
            'message' => 'Delete Cart',
            'data' => $product
        ]);
    }
}
