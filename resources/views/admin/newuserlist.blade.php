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
                        <label for="selectStatus">Status:</label>
                        <select id="selectStatus">
                            <option value="">ALL</option>
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
                    <form id="userForm" name="userForm" class="form-horizontal" data-action="{{ route('users.store') }}">
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        var indexDataRoute = "{{ route('users.index') }}";
    </script>

    <script src="{{ asset('/js/custom/admin/newuserlist.js') }}"></script>
@endsection
