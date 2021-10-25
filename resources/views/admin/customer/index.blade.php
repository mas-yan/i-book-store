@extends('layouts.admin.master')
@section('title','Admin - Customer')
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Data customer</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table id="customer" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer Name</th>
                                <th>Email Address</th>
                                <th>Joined</th>
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
    let table = $('#customer').DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            "url" :'/customerTable',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'name',name: 'name'},
            { data: 'email',name: 'email'},
            { data: 'created_at',name: 'created_at'},
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
                    url: `customer/${id}`,
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