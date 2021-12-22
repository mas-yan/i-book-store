@extends('layouts.admin.master')
@section('title','Admin - Product')
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Data Product</h3>
            </div>
            <div class="card-body">
                <a href="{{route('product.create')}}" class="mb-3 btn btn-primary">Add Data</a>
                <div class="table-responsive">

                    <table id="product" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stok</th>
                                <th width="250px">action</th>
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
    let table = $('#product').DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            "url" :'/dataProducts',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'image',name: 'image'},
            { data: 'title',name: 'title',searchable: true},
            { data: 'category',name: 'category',searchable: true},
            { data: 'price',name: 'price',searchable: true },
            { data: 'stok',name: 'stok'},
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
                    url: `product/${id}`,
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