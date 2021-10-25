@extends('layouts.admin.master')
@section('title','Admin - order')
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Data Order</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table id="order" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Invoice</th>
                                <th>order</th>
                                <th>Grand Total</th>
                                <th>Status Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    let table = $('#order').DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            "url" :'/orderTable',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'invoice',name: 'invoice'},
            { data: 'customer' ,name: 'customer'},
            { data: 'amount',name: 'amount'},
            { data: 'status',name: 'status'},
            { data: 'action',name: 'action'},
        ]
    })
</script>
@endsection