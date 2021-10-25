@extends('layouts.admin.master')
@section('title','Admin - Company')
@section('content')
    <div class="container">
      <div class="callout callout-info">
        <h5>Info !</h5>
        <p>Untuk mendapatkan titik koordinat (long dan lat), </p>
        <ol>
          <li>Di komputer, buka <a href="https://www.google.com/maps" rel="noopener" target="_blank">Google Maps</a>.&nbsp;</li>
          <li>Klik kanan tempat atau area pada peta.</li>
          <li>Untuk menyalin koordinat secara otomatis, pilih lintang dan bujur.</li>
        </ol>
      </div>
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Company</h3>
            </div>
            <div class="card-body card-primary">
              <form action="{{route('company.update',$company->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name',$company->name)}}" id="name" placeholder="name Company">
                    @error('name') 
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="address">address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address',$company->address)}}" id="address" placeholder="address">
                    @error('address') 
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="day_operational">Day Operational</label>
                    <input type="text" class="form-control @error('day_operational') is-invalid @enderror" name="day_operational" value="{{old('day_operational',$company->day_operational)}}" id="day_operational" placeholder="day_operational">
                    @error('day_operational') 
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="time_operational">Time Operational</label>
                    <textarea class="form-control @error('time_operational') is-invalid @enderror" name="time_operational" id="time_operational" placeholder="time_operational Company" rows="5">{{old('time_operational',$company->time_operational)}}</textarea>
                    @error('time_operational') 
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="logo">logo</label>
                    <div class="@error('logo') is-invalid @enderror input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" name="logo">
                        <label class="custom-file-label" for="logo">Choose file</label>
                      </div>
                    </div>
                    @error('logo') 
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="long">long</label>
                    <input type="text" class="form-control @error('long') is-invalid @enderror" name="long" value="{{old('long',$company->long)}}" id="long" placeholder="long">
                    @error('long') 
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="lat">lat</label>
                    <input type="text" class="form-control @error('lat') is-invalid @enderror" name="lat" value="{{old('lat',$company->lat)}}" id="lat" placeholder="lat">
                    @error('lat') 
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="detail">Description Company</label>
                    <textarea class="form-control @error('detail') is-invalid @enderror" name="detail" id="detail" placeholder="Detail Company" rows="5">{{old('detail',$company->about)}}</textarea>
                    @error('detail') 
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                  </div>
                  <button type="submit" class="btn btn-primary">Update Company</button>
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
