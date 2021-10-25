@extends('layouts.admin.master')
@section('title','Admin - Slider')
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Add Slider</h3>
            </div>
            <div class="card-body card-primary">
              <form action="{{route('slider.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{old('link')}}" id="link" placeholder="Link slider">
                    @error('link') 
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
                  <button type="submit" class="btn btn-primary">Add slider</button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
