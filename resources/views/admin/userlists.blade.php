@extends('layouts.admindash')
@section('title')
    User List
@endsection

@section('body')
    <div class="row m-4">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-10">
                            <h2 class="m-0 font-weight-bold text-primary">User List</h2>

                        </div>
                        <div class="col-md-2 float-right">
                            {{-- <a href="{{ route('users.create') }}" class="btn btn-primary addUser">Add User</a> --}}
                            <a href="javascript:void(0)" class="btn btn-primary addUser">Add User</a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Number</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userlist as $user)
                                <tr class="fw-normal">
                                    <th class="align-middle">
                                        {{ $userlist->currentPage() * $userlist->perPage() - $userlist->perPage() + 1 + $loop->index }}
                                    </th>
                                    <td class="align-middle">
                                        <span>{{ $user->name }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="mb-0"><span class="badge">{{ $user->number }}</span></h6>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="mb-0"><span class="badge">{{ $user->email }}</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="mb-0"><span class="badge">
                                                @if ($user->active == 1)
                                                    Active
                                                @else
                                                    Blocked
                                                @endif
                                            </span>
                                        </h6>
                                    </td>
                                    <td class="align-middle">
                                        {{-- <a href="#!" data-mdb-toggle="tooltip" title="edit"><i
                                                class="fas fa-pencil-alt mr-3 text-secondary" aria-hidden="true"></i></a> --}}

                                        <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $user->id }}"
                                            title="Edit"> <i data-id="{{ $user->id }}"
                                                class="fas fa-pencil-alt mr-3 text-secondary editProduct"
                                                aria-hidden="true"></i></a>

                                        <a href="{{ route('user.status', ['id' => $user->id,'status'=>1]) }}" data-mdb-toggle="tooltip"
                                            title="active"><i class="fas fa-check text-success me-3 mr-3"></i></a>
                                        <a href="{{ route('user.status', ['id' => $user->id,'status'=>0]) }}" data-mdb-toggle="tooltip"
                                            title="Ban"><i class="fa fa-ban mr-3 text-danger" aria-hidden="true"></i></a>





                                        <a href="#!" data-mdb-toggle="tooltip" title="view"><i class="fa fa-eye mr-3"
                                                aria-hidden="true"></i></a>

                                        <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $user->id }}"
                                            data-action="{{ route('users.destroy', ['user' => $user->id]) }}" title="Delete"
                                            class="deleteProduct"> <i class="fas fa-trash-alt text-danger mr-3"
                                                aria-hidden="true"></i></a>
                                        {{-- <form action={{ route('users.destroy', ['user' => $user->id]) }} method="post"
                                            style="display:inline!important;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" style="border:none; outline:none; background: none; "><i
                                                    class="fas fa-trash-alt text-danger mr-3"></i></button>


                                        </form> --}}

                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    {{ $userlist->links() }}
                </div>
            </div>
        </div>

    </div>



    {{-- ajax  New User --}}

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required="">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Number</label>
                            <div class="col-sm-12">
                                <input id="number" name="number" required="" placeholder="Enter Number"
                                    class="form-control" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-12">
                                <input id="password" name="password" required="" placeholder="Enter Password"
                                    class="form-control" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $('.addUser').click(function() {
                $('#saveBtn').val("create-product");
                $('#user_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
            });



            $('body').on('click', '.editProduct', function() {
                var user_id = $(this).data('id');
                console.log(user_id);
                $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#number').val(data.number);
                })
            });


            $('body').on('click', '.deleteProduct', function() {

                var id = $(this).data("id");
                // var conf = confirm("Are You sure want to delete !");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).data("action"),
                            type: 'DELETE',
                            data: {
                                "id": id,
                                // "_token": token,
                            },
                            success: function(res) {
                                if (res.type == 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    ).then(function() {
                                        location.reload();
                                    });

                                }
                            }
                            // location.reload();
                        });
                    }
                })



            });



            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data, res) {

                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        location.reload();


                    },
                    error: function(data, res) {
                        // alert("all field are required");
                        
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'all field are required!',
                            
                        })
                    }
                });
            });



        });
    </script>
@endsection
