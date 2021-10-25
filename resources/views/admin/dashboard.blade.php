@extends('layouts.admin.master')
@section('title','Dashboard')
@section('content')
<div class="row">
  <div class="col-lg-4 col-12">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{$order}}</h3>

        <p>New Orders</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="{{route('order.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-12">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{moneyFormat($income)}}</h3>

        <p>income this month</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-12">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{$customer}}</h3>

        <p>New Customer</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="{{route('customer.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- ./row -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-success"><i class="far fa-check-circle"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Success</span>
        <span class="info-box-number">{{$success}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-warning"><i class="fas fa-sync-alt fa-spin"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Pending</span>
        <span class="info-box-number">{{$pending}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-secondary"><i class="fas fa-exclamation-circle"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Expired</span>
        <span class="info-box-number">{{$expired}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-danger"><i class="far fa-times-circle"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Failed</span>
        <span class="info-box-number">{{$failed}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
  <div class="col">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Income this year</h3>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
  <!-- /.card -->
  </div>
</div>
@endsection

@section('script')
<!-- ChartJS -->
<script src="{{asset('/')}}plugins/chart.js/Chart.min.js"></script>
  <script>
    $(function () {
      var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

      var areaChartData = {
        labels  : [@foreach($montChart as $data)'{{$data->data}}',@endforeach],
        datasets: [
          {
            label               : 'Digital Goods',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.9)',
            pointRadius         : true,
            pointBorderWidth    : 7,
            pointHoverBorderWidth: 10,
            
            data                : [@foreach($chart as $data){{$data->data}},@endforeach]
          },
        ]
      }

      var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,

        legend: {
          display: false
        },
        
        scales: {
          xAxes: [{
            gridLines : {
              display : false,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            }
          }]
        }
      }

      // This will get the first returned node in the jQuery collection.
      var areaChart       = new Chart(areaChartCanvas, { 
        type: 'line',
        data: areaChartData, 
        options: areaChartOptions
      })
    })
  </script>
@endsection