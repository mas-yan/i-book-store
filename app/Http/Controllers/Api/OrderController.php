<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::where('customer_id', auth()->guard('api')->user()->id)->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Orders Customer',
            'data' => $order
        ]);
    }

    public function show(Order $invoice)
    {
        return response()->json([
            'success' => true,
            'message' => 'List Orders Customer',
            'data' => $invoice
        ]);
    }


    public function addCart(Product $product)
    {
        $customer = Customer::find(auth()->guard('api')->user()->id);
        $product->customer()->attach($customer, ['qty' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Add Cart',
            'data' => $product
        ]);
    }

    public function transaction()
    {
        try {
            DB::beginTransaction();
            $order = new Order;
            $order->customer_id = auth()->guard('api')->user()->id;
            $order->invoice = 'abc';
            $order->status = 'pending';
            $order->grand_total = 100;

            $order->save();

            $customer = Customer::find(auth()->guard('api')->user()->id);

            foreach ($customer->product as $item) {
                $order->product()->attach($item->id, ['qty' => $item->pivot->qty]);
            }

            $customer->product()->detach();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json([
            'success' => true,
            'message' => 'Checkout Success',
        ]);
    }

    // public function addQty(Product $product)
    // {
    //     foreach ($product->customer as $item) {
    //         $qty = $item->pivot->qty + 1;
    //     }
    //     $items = $product->customer->pluck('title', 'id')->toArray();
    //     foreach ($items as $key => $item) {
    //         $product->customer()->updateExistingPivot($key, ['qty' => $qty]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Add Qty',
    //         'data' => $qty
    //     ]);
    // }
    // public function subQty(Product $product)
    // {
    //     foreach ($product->customer as $item) {
    //         $qty = $item->pivot->qty - 1;
    //     }

    //     if ($qty >= 1) {
    //         $items = $product->customer->pluck('title', 'id')->toArray();
    //         foreach ($items as $key => $item) {
    //             $product->customer()->updateExistingPivot($key, ['qty' => $qty]);
    //         }
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Add Qty',
    //             'data' => $qty
    //         ]);
    //     } else {

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Add Qty',
    //             'data' => 1
    //         ]);
    //     }
    // }
}
