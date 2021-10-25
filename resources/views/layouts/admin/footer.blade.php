<footer class="main-footer">
    <strong>Copyright &copy; Riyan Alfian
      <div class="float-right d-none d-sm-block">
        <b>{{$name}}</b>
      </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/')}}plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/')}}plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('/')}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/')}}plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('/')}}dist/js/adminlte.js"></script>

<!-- DataTables -->
<script src="{{asset('/')}}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $("#datatable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  @if(session()->has('success'))

    Swal.fire({
        icon: 'success',
        title: 'BERHASIL!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000
    })

    @elseif(session()->has('error'))

    Swal.fire({
        icon: 'error',
        text: 'GAGAL!',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 3000
    })

    @endif
</script>
@yield('script')
</body>
</html>