@extends('layouts.admin.master')
@section('title','Admin - Slider')
@section('content')
    <div class="container">
      <div class="card card-primary rounded border-0">
          <div class="card-header">
              <h3 class="card-title">Edit Profile</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('user-profile-information.update') }}" method="POST">
              @method('PUT')
              @csrf
              <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{auth()->user()->name}}">
                @error('name') 
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{auth()->user()->email}}">
                @error('email') 
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              <button class="btn-primary btn">Update Profile</button>
            </form>
          </div>
      </div>
      <div class="card card-primary rounded border-0">
          <div class="card-header">
              <h3 class="card-title">Update Password</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('user-password.update') }}" method="POST">
              @method('PUT')
              @csrf
              <div class="form-group">
                <label for="current_password">Old Password</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" placeholder="Old Password" name="current_password">
                @error('current_password') 
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="New Password" name="password">
                @error('password') 
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Password Confirmation" name="password_confirmation">
                @error('password_confirmation') 
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              <button class="btn-primary btn">Update Profile</button>
            </form>
          </div>
      </div>
    </div>
@endsection
@section('script')
<script>
  @if (session('status')=='profile-information-updated')
    Swal.fire({
      icon: 'success',
      title: 'BERHASIL!',
      text: 'Profile has been updated.',
      showConfirmButton: false,
      timer: 3000
    })
  @endif
  @if (session('status')=='password-updated')
    Swal.fire({
      icon: 'success',
      title: 'BERHASIL!',
      text: 'Password has been updated..',
      showConfirmButton: false,
      timer: 3000
    })
  @endif
</script>
@endsection