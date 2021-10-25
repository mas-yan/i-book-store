<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{

    public function customerTable()
    {
        $customer = Customer::select('name', 'email', 'created_at')->latest();

        return DataTables::of($customer)
            ->addIndexColumn()
            ->addColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d-M-Y');
            })
            ->rawColumns(['created_at'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customer.index');
    }
}
