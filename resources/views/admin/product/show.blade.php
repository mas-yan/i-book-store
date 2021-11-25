@extends('layouts.admin.master')
@section('title','Admin - Product')
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Data Product</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="col-12">
                    <img src="{{$product->image}}" class="product-image rounded" alt="Product Image">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <h3 class="my-3 my-lg-auto">{{$product->title}}</h3>
                  {{-- <p>{!!$product->deskripsi_product!!}</p> --}}
                  <hr>
                  <h4 class="mt-3">Stok : <small>{{$product->stok}}</small></h4>
                  <h4 class="mt-3">Berat : <small>{{$product->berat}}</small></h4>
                  <h4 class="mt-3">Jumlah Halman : <small>{{$product->jumlah_halman}}</small></h4>
                  <h4 class="mt-3">Tanggal Terbit : <small>{{$product->tanggal_terbit}}</small></h4>
                  <h4 class="mt-3">Lebar : <small>{{$product->lebar}}</small></h4>
                  <h4 class="mt-3">Bahasa : <small>{{$product->bahasa}}</small></h4>
                  <h4 class="mt-3">Panjang : <small>{{$product->panjang}}</small></h4>
                  <div class="bg-gray py-2 px-3 mt-4">
                    <h2 class="mb-0">
                      {{moneyFormat($product->price)}}
                    </h2>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Deskripsi</h3>
            </div>
            <div class="card-body">
              <p>{!!$product->deskripsi_product!!}</p>
            </div>
        </div>
    </div>
@endsection