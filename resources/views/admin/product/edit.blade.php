@extends('layouts.admin.master')
@section('title','Admin - Product')
@section('content')
    
<div class="card card-primary rounded border-0">
  <div class="card-header">
      <h3 class="card-title">Update Product</h3>
  </div>
  <div class="card-body card-primary">
    <form action="{{route('product.update',$product->slug)}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="card-body">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title',$product->title)}}" id="title" placeholder="Title Product">
          @error('title') 
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="category">category</label>
          <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
            <option value="">--PILIIH--</option>
            @foreach ($category as $item)
              <option value="{{$item->id}}" {{(old('category',$product->category_id) == $item->id) ? 'selected':''}}>{{$item->name}}</option>
            @endforeach
          </select>
          @error('category') 
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price',$product->price)}}" id="price" placeholder="Price">
          @error('price') 
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="stok">Stok</label>
          <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{old('stok',$product->stok)}}" id="stok" placeholder="Stok">
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
          <textarea class="form-control @error('detail') is-invalid @enderror" name="detail" id="detail" placeholder="Detail Product" rows="5">{{old('detail',$product->detail_product)}}</textarea>
          @error('detail') 
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.0/tinymce.min.js"></script>
<script>
    tinymce.init({selector:'textarea'});
</script>
@endsection