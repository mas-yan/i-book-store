@inject('pending', 'App\Models\Order')
@inject('company', 'App\Models\Company')
@php
$asset = asset('storage/Company/');
($company->first()->logo != $asset || $company->first()->logo == '') ? $logo = $company->first()->logo : $logo = asset('/dist/img/AdminLTELogo.png');
(isset($company->first()->name)) ? $name = $company->first()->name : $name = 'MyStore';
@endphp
@include('layouts.admin.header')
@include('layouts.admin.navbar')
@include('layouts.admin.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @yield('content')
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.admin.footer')