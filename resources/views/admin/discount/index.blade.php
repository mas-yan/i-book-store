@extends('layouts.admin.master')
@section('title','Admin - Discount')
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Discount Product</h3>
            </div>
            <div class="card-body">
                <a href="{{route('discount.create')}}" class="mb-3 btn btn-primary">Add Discount</a>
                <div class="table-responsive">

                    <table id="discount" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Diskon</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Harga Awal</th>
                                <th>Harga Diskon</th>
                                <th>action</th>
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
    let table = $('#discount').DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            "url" :'/dataDiscount',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'title',name: 'title'},
            { data: 'discount',name: 'discount'},
            { data: 'start',name: 'start'},
            { data: 'end',name: 'end' },
            { data: 'price',name: 'price' },
            { data: 'price_discount',name: 'price_discount' },
            { data: 'action',name: 'action' },
        ]
    })
    
    function destroy(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be delete this data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: `discount/${id}`,
                    data:{
                        "id": id,
                        "_token": token
                    },
                    type: 'Delete',
                    success: function resp(response) {
                        if (response.status == "success") {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            .then(function () {
                                location.reload()
                            })
                        }else{
                            Swal.fire(
                                'Failed!',
                                'Your file failed to deleted.',
                                'error'
                            )
                        }
                    }
                })
            }
        })
    }
</script>
@endsection