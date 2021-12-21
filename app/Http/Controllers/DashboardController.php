<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        // new member
        $customer = Customer::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        // new order
        $order = Order::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        // income per month
        $income = Order::where('status', 'success')->whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('grand_total');

        // success
        $success = Order::where('status', 'success')->count();
        // pending
        $pending = Order::where('status', 'pending')->count();
        // expired
        $expired = Order::where('status', 'expired')->count();
        // failed
        $failed = Order::where('status', 'failed')->count();

        $chart = Order::select(DB::raw('sum(grand_total) as data'), DB::raw('MONTH(created_at) as month'))
            ->where('status', 'success')
            ->groupby('month')
            ->whereYear('created_at', $year)
            ->get();

        $montChart = Order::select(DB::raw('MONTH(created_at) month'), DB::raw('MONTHNAME(created_at) data'))
            ->where('status', 'success')
            ->groupby('data')
            ->groupby('month')
            ->orderby('month')
            ->whereYear('created_at', $year)
            ->get();
        return view('admin.dashboard', compact('customer', 'order', 'income', 'success', 'pending', 'expired', 'failed', 'chart', 'montChart'));
    }
}
