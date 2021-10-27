@extends('layouts.admin.master')
@section('title','Admin - order')
@section('content')
  <div class="container">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><h6 class="font-weight-bold"><i class="nav-icon fas fa-shopping-cart"></i> Detail Order</h6></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td style="width: 20%">No Invoice</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{$order->invoice}}</td>
            </tr>
            <tr>
              <td style="width: 20%">Full Name</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{$order->full_name}}</td>
            </tr>
            <tr>
              <td style="width: 20%">Phone</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{$order->phone}}</td>
            </tr>
            <tr>
              <td style="width: 20%">Courir/Service/Cost</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{$order->courir}}/{{$order->service}}/{{moneyFormat($order->cost)}}</td>
            </tr>
            <tr>
              <td style="width: 20%">city</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{$order->city}}</td>
            </tr>
            <tr>
              <td style="width: 20%">Province</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{$order->province}}</td>
            </tr>
            <tr>
              <td style="width: 20%">Address</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{$order->address}}</td>
            </tr>
            <tr>
              <td style="width: 20%">Grand total</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">{{moneyFormat($order->grand_total)}}</td>
            </tr>
            <tr>
              <td style="width: 20%">Status</td>
              <td style="width: 3%" class="text-center">:</td>
              <td style="widows: 77%">
                @if ($order->status == 'success')
                <span class="btn-success btn-sm"><i class="far fa-check-circle"></i> &nbsp; {{$order->status}}</span>
                @elseif($order->status == 'pending')
                <span class="btn-warning btn-sm"><i class="fas fa-sync-alt fa-spin"></i> &nbsp; {{$order->status}}</span>
                @elseif($order->status == 'expired')
                <span class="btn-secondary btn-sm"><i class="fas fa-exclamation-circle"></i> &nbsp; {{$order->status}}</span>
                @elseif($order->status == 'failed')
                <span class="btn-danger btn-sm"><i class="far fa-times-circle"></i> &nbsp; {{$order->status}}</span>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><h6 class="font-weight-bold"><i class="nav-icon fas fa-shopping-cart"></i> Detail Items</h6></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @foreach ($order->product as $item)
          <div class="row mb-3 rounded shadow">
            <div class="col p-3">
              <img class="img-fluid rounded" style="height: 200px" src="{{$item->image}}" alt="Photo">
            </div>
            <div class="col">
              <p class="lead mt-3">{{$item->title}}</p>
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Harga:</th>
                    <td>{{moneyFormat($item->price)}}</td>
                  </tr>
                  <tr>
                    <th>qty:</th>
                    <td>{{$item->pivot->qty}}</td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td>{{moneyFormat($item->price * $item->pivot->qty)}}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection