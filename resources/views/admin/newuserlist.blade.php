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
                            <a href="javascript:void(0)" class="btn btn-primary" id="addUser">Add User</a>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 m-2">
                        <label for="selectStatus">Search:</label>
                        <select id="selectStatus">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table data-table">
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


                        </tbody>

                    </table>

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
                    <form id="userForm" name="userForm" class="form-horizontal">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required="" required>
                            </div>
                            <span class="text-danger error-text name_err ml-2"></span>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="" maxlength="50" required="">
                            </div>
                            <span class="text-danger error-text email_err ml-2"></span>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Number</label>
                            <div class="col-sm-12">
                                <input id="number" name="number" required="" placeholder="Enter Number"
                                    class="form-control" required="">
                            </div>
                            <span class="text-danger error-text number_err ml-2"></span>

                        </div>

                        <div class="form-group" id="newuserpassword" aria-hidden="true">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-12">
                                <input id="password" name="password" required="" placeholder="Enter Password"
                                    class="form-control" required="">
                            </div>
                            <span class="text-danger error-text password_err ml-2"></span>

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
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                'iDisplayLength': 50,
                stateSave: true,


                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'title',

                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {

                        data: 'active',
                        name: 'active'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],

                "columnDefs": [{
                    "targets": [4],
                    "render": function(data, type, row) {
                        if (data == '1') {
                            return 'Active';
                        } else {
                            return 'Blocked';
                        }
                    }
                }, ],

                // dropdown fliter 
                initComplete: function() {
                    this.api().columns([4]).every(function() {
                        var column = this;
                        var select = $('#selectStatus')
                            .on('change', function() {
                                var val = $(this).val();
                                column.search(val).draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            if (d == 0) {
                                select.append('<option value="' + d + '">' + "Blocked" +
                                    '</option>')
                            } else {
                                select.append('<option value="' + d + '">' + "Active" +
                                    '</option>')
                            }
                        });
                    });
                }
            });






            $('#addUser').click(function() {
                $('#saveBtn').val("create-product");
                $('#user_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
                $("#newuserpassword").show();
                $('.name_err').empty();
                $('.email_err').empty();
                $('.number_err').empty();



            });

            $('body').on('click', '.editUser', function() {
                var user_id = $(this).data('id');
                $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $("#newuserpassword").hide();
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#number').val(data.number);
                    $('.name_err').empty();
                    $('.email_err').empty();
                    $('.number_err').empty();
                })
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            // alert(data.success);
                            $('#userForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();

                        } else {
                            printErrorMsg(data.error);
                            $('#saveBtn').html('Save Changes');


                        }



                    },
                    error: function(data) {
                        console.log('Error:', data);

                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            function printErrorMsg(msg) {
                $.each(msg, function(key, value) {
                    console.log(key);
                    $('.' + key + '_err').text(value);
                });
            }

            $('body').on('click', '.deleteUser', function() {

                var id = $(this).data("id");
                // confirm("Are You sure want to delete this Post!");
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
                            type: "DELETE",
                            url: "{{ route('users.index') }}" + '/' + id,
                            success: function(data) {
                                table.draw();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });



                    }
                })



            });


            $('body').on('click', '.blockUser', function() {
                var id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    // icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Block User!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "" + 'user/ban/' + id,
                            success: function(data) {
                                table.draw();
                                Swal.fire(
                                    'Blocked!',
                                    'User are Blocked.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });



                    }
                })


            });

            $('body').on('click', '.unblockUser', function() {
                var id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    // icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Unblock User!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "" + 'user/unban/' + id,
                            success: function(data) {
                                table.draw();
                                Swal.fire(
                                    'Unblock!',
                                    'User are Unblock.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });



                    }
                })


            });


            // validate add user and update user

            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                    },



                },
                messages: {
                    name: {
                        required: "Please Enter Name",

                    },


                },


            })

        });
    </script>


    {{-- <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $('.addUser').click(function() {
                $('#saveBtn').val("create-product");
                $('#user_id').val('');
                $('#userForm').trigger("reset");
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
                    data: $('#userForm').serialize(),
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data, res) {

                        $('#userForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        location.reload();


                    },
                    error: function(data, res) {
                        // alert("all field are required");
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });



        });
    </script> --}}
@endsection
