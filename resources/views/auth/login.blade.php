@extends('layouts.auth.index')
@section('title','Login')
@section('content')
<div class="card">
  <div class="card-body login-card-body">
    <p class="login-box-msg">Sign in to start your session</p>

    @if (session('status'))
      <div class="alert-success alert">
          {{ session('status') }}
      </div>
    @endif
    <form action="/login" method="post">
      @csrf
      <div class="input-group @error('email') is-invalid @enderror">
        <input type="email" value="{{old('email')}}" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
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
      <div class="input-group @error('password') is-invalid @enderror mt-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      @error('email')
      <div class="invalid-feedback">
        {{$message}}
      </div>
      @enderror
      <div class="row mt-3">
        <div class="col-8">
          <div class="icheck-primary">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">
              Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-4">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <p class="mb-1">
      <a href="/forgot-password">I forgot my password</a>
    </p>
    <p class="mb-0">
      {{-- <a href="register.html" class="text-center">Register a new membership</a> --}}
    </p>
  </div>
  <!-- /.login-card-body -->
</div>
@endsection