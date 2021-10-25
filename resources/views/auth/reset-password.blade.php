@extends('layouts.auth.index')
@section('title','Login')
@section('content')
<div class="card">
  <div class="card-body login-card-body">
    <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

    <form action="/reset-password" method="post">
      @csrf
      @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
      @endif
      <input type="hidden" name="token" value="{{ $request->route('token') }}">
      <div class="input-group @error('email') is-invalid @enderror">
        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $request->email ?? old('email') }}" name="email" placeholder="Email">
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
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      @error('password') 
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
      <div class="input-group mt-3">
        <input type="password" class="form-control" name="password_confirmation" placeholder="password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block mt-3">Request new password</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <p class="mt-3 mb-1">
      <a href="login.html">Login</a>
    </p>
  </div>
  <!-- /.login-card-body -->
</div>
@endsection