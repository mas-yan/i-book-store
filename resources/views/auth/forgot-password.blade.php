@extends('layouts.auth.index')
@section('title','Login')
@section('content')
<div class="card">
  <div class="card-body login-card-body">
    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

    <form action="/forgot-password" method="post">
      @csrf
      @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
      @endif
      <div class="input-group @error('email') is-invalid @enderror">
        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="Email">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      @error('email') 
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block mt-3">Request new password</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <p class="mt-3 mb-1">
      <a href="/login">Login</a>
    </p>
  </div>
  <!-- /.login-card-body -->
</div>
@endsection