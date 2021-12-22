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
        // get username customer login
        $cart = Customer::find(auth()->guard('api')->user()->id);
        // sum qty
        $total = $cart->product()->sum('qty');
        // get cart
        $data = $cart->product()->leftjoin('discounts', function ($join) {
            $join->on('discounts.product_id', '=', 'products.id')
                ->where('discounts.start', '<=', Carbon::now()->toDateString())
                ->where('discounts.end', '>', Carbon::now()->toDateString());
        })->select('products.id', 'stok', 'berat', 'title', 'slug', 'price', 'image', 'discount', 'price_discount')->orderby('products.created_at', 'desc')->get();
        // return response json
        return response()->json([
            'success' => true,
            'message' => 'Data cart',
            'data' => $data,
            'total' => $total,
        ]);
    }

    public function store(Product $product)
    {
        // get username customer login
        $customer = Customer::find(auth()->guard('api')->user()->id);
        // get product in cart
        $cart = $product->customer()->where('id', auth()->guard('api')->user()->id)->first();
        // jika sudah ada produk di cart
        if ($cart) {
            // add qty +1
            $cart->pivot->qty += 1;
            $cart->pivot->save();
        } else {
            // jika belum maka akan menambahkan produk ke cart
            $product->customer()->attach($customer, ['qty' => 1]);
        }

        // return response json
        return response()->json([
            'success' => true,
            'message' => 'Add Cart',
            'data' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        // get username customer login
        $customer = Customer::find(auth()->guard('api')->user()->id);
        // delete product in cart
        $customer->product()->detach($product->id);
        // return response json
        return response()->json([
            'success' => true,
            'message' => 'Delete Cart',
            'data' => $product
        ]);
    }

    public function addQty(Product $product)
    {
        // get username customer login
        $cart = $product->customer()->where('id', auth()->guard('api')->user()->id)->first();
        // add qty +1
        $cart->pivot->qty += 1;
        $cart->pivot->save();

        // response json
        return response()->json([
            'success' => true,
            'message' => 'Add qty',
            'data' => $cart->pivot->qty
        ]);
    }
    public function subtQty(Product $product)
    {
        // get username customer login
        $cart = $product->customer()->where('id', auth()->guard('api')->user()->id)->first();
        // sub qty -1
        $cart->pivot->qty -= 1;
        $cart->pivot->save();
        // return response json
        return response()->json([
            'success' => true,
            'message' => 'Add qty',
            'data' => $cart->pivot->qty
        ]);
    }

    public function delete(Request $request)
    {
        // explode request id
        $product = explode(",", $request->id);
        // get username customer login
        $user = Customer::find(auth()->guard('api')->user()->id);
        $user->product()->detach($product);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Delete Cart',
            'data' => $product
        ]);
    }
}
