@extends('layouts.admin.master')
@section('title','Admin - Category')
@section('content')
  <div class="container">
      <div class="card card-primary rounded border-0">
          <div class="card-header">
              <h3 class="card-title">Add Category</h3>
          </div>
          <div class="card-body card-primary">
            <form action="{{route('categories.update',$category->slug)}}" method="POST" enctype="multipart/form-data">
              @method('PUT')
              @csrf
              <div class="card-body">
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
                  <label for="title">Title</label>
                  <input type="text" value="{{old('title',$category->name)}}" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title Category">
                  @error('title') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update Category</button>
              </form>
              </div>
          </div>
      </div>
  </div>
@endsection
