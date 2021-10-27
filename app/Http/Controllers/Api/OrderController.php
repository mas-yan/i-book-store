<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
}
