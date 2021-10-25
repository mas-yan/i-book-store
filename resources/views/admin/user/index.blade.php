@extends('layouts.admin.master')
@section('title','Admin - User')
@section('content')
    <div class="container">
        <div class="card card-primary rounded border-0">
            <div class="card-header">
                <h3 class="card-title">Data User</h3>
            </div>
            <div class="card-body">
                <a href="{{route('user.create')}}" class="mb-3 btn btn-primary">Add Data</a>
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="text-center">
                                {{$user->name}}
                            </td>
                            <td class="text-center">
                                {{$user->email}}
                            </td>
                            <td class="text-center">
                                <button onclick="destroy(this.id)" id='{{$user->id}}' class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
                        url: `user/${id}`,
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