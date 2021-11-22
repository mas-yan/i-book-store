@extends('layouts.admin.master')
@section('title','Admin - Add Discount')
@section('header')
<link rel="stylesheet" href="{{asset('/')}}plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('/')}}plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Add Discount Product</h3>
            </div>
            <div class="card-body">
              <form action="{{route('discount.store')}}" method="post">
                @csrf
                <div class="form-group">
                  <label for="cari">Produk</label>
                  <select class="form-control select2 @error('product') is-invalid @enderror" name="product" id="cari" style="width: 100%;"></select>
                  @error('product') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <label for="disokon">Discount</label>
                <div class="input-group mb-3">
                  <input type="number" id="disokon" max="100" min="0" name="discount" value="{{old('discount')}}"placeholder="doscount Product" class="form-control @error('discount') is-invalid @enderror">
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                  @error('discount') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="start">Start Discount Date</label>
                  <input class="form-control @error('start') is-invalid @enderror" name="start" type="date" id="start" value="{{old('start')}}">
                  @error('start') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="end">end Discount Date</label>
                  <input class="form-control @error('end') is-invalid @enderror" name="end" type="date" id="end" value="{{old('end')}}">
                  @error('end') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <button class="btn btn-primary" type="submit">Add Discount</button>
              </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="{{asset('/')}}plugins/select2/js/select2.full.min.js"></script>
<script>
  $('#cari').select2({
    placeholder: 'Produk...',
    ajax: {
      url: '/discountProduk',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.title,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });
</script>
@endsection