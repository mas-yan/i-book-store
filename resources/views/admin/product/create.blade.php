@extends('layouts.admin.master')
@section('title','Admin - Product')
@section('header')
<link rel="stylesheet" href="{{asset('/')}}plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('/')}}plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('content')
  <div class="container">
      <div class="card card-primary rounded border-0">
          <div class="card-header">
              <h3 class="card-title">Add Product</h3>
          </div>
          <div class="card-body card-primary">
            <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title')}}" id="title" placeholder="Title Product">
                  @error('title') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="author">Author</label>
                  <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{old('author')}}" id="author" placeholder="Author">
                  @error('author') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="category">category</label>
                  <select class="form-control select2 @error('category') is-invalid @enderror" name="category" id="cari" style="width: 100%;">
                    @foreach ($categories as $item)
                      <option value="{{old('category')}}" {{(old('category') == $item->id) ? 'selected':''}}>{{(old('category') == $item->id) ? $item->name : ''}}</option>
                    @endforeach
                  </select>
                  @error('category') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="jumlah_halaman">Jumlah Halaman</label>
                  <input type="number" class="form-control @error('jumlah_halaman') is-invalid @enderror" name="jumlah_halaman" value="{{old('jumlah_halaman')}}" id="jumlah_halaman" placeholder="Jumlah Halaman">
                  @error('jumlah_halaman') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="panjang">Panjang</label>
                  <input type="number" class="form-control @error('panjang') is-invalid @enderror" step=0.01 name="panjang" value="{{old('panjang')}}" id="panjang" placeholder="Panjang">
                  @error('panjang') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="bahasa">Bahasa</label>
                  <input type="text" class="form-control @error('bahasa') is-invalid @enderror" name="bahasa" value="{{old('bahasa')}}" id="bahasa" placeholder="Bahasa">
                  @error('bahasa') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="lebar">Lebar</label>
                  <input type="number" step=0.01 class="form-control @error('lebar') is-invalid @enderror" name="lebar" value="{{old('lebar')}}" id="lebar" placeholder="Lebar">
                  @error('lebar') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="berat">Berat</label>
                  <input type="number" step=any class="form-control @error('berat') is-invalid @enderror" name="berat" value="{{old('berat')}}" id="berat" placeholder="Berat">
                  @error('berat') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="tanggal_terbit">Tanggal Terbit</label>
                  <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror" name="tanggal_terbit" value="{{old('tanggal_terbit')}}" id="tanggal_terbit" placeholder="Tanggal Terbit">
                  @error('tanggal_terbit') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="penerbit">Penerbit</label>
                  <input type="text" class="form-control @error('penerbit') is-invalid @enderror" name="penerbit" value="{{old('penerbit')}}" id="penerbit" placeholder="Penerbit">
                  @error('penerbit') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price')}}" id="price" placeholder="Price">
                  @error('price') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="stok">Stok</label>
                  <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{old('stok')}}" id="stok" placeholder="Stok">
                  @error('stok') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="image">Image</label>
                  <div class="@error('image') is-invalid @enderror input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                      <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                  </div>
                  @error('image') 
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="detail">Desciption Product</label>
                  <textarea class="form-control @error('detail') is-invalid @enderror" name="detail" id="detail" placeholder="Detail Product" rows="5">{{old('detail')}}</textarea>
                  @error('detail') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
              </form>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="{{asset('/')}}plugins/select2/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.0/tinymce.min.js"></script>
<script>
    tinymce.init({selector:'textarea'});
  
    $('#cari').select2({
      placeholder: 'Category...',
      ajax: {
        url: '/productCategory',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
              console.log(item);
              return {
                text: item.name,
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
