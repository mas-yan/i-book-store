<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function orderTable()
    {
        $order = Order::with('customer')->latest();
        return DataTables::of($order)
            ->addIndexColumn()
            ->addColumn('amount', function ($amount) {
                return moneyFormat($amount->grand_total);
            })
            ->addColumn('customer', function ($data) {
                return $data->customer->name;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 'success') {
                    return '<div class="text-center"><span class="btn-success btn-sm"><i class="far fa-check-circle"></i>  ' . $data->status . '</span></div>';
                } elseif ($data->status == 'pending') {
                    return '<div class="text-center"><span class="btn-warning btn-sm"><i class="fas fa-sync-alt fa-spin"></i>  ' . $data->status . '</span></div>';
                } elseif ($data->status == 'expired') {
                    return '<div class="text-center"><span class="btn-secondary btn-sm"><i class="fas fa-exclamation-circle"></i>  ' . $data->status . '</span></div>';
                } elseif ($data->status == 'failed') {
                    return '<div class="text-center"><span class="btn-danger btn-sm"><i class="far fa-times-circle"></i>  ' . $data->status . '</span></div>';
                }
            })
            ->addColumn('action', function ($data) {
                $action = '<div class="text-center"><a href="' . route("order.show", $data->invoice) . '" width="130" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Detail</a></div>';
                return $action;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function index()
    {
        return view('admin.order.index');
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->first();
        return view('admin.order.detail', compact('order'));
    }
}
