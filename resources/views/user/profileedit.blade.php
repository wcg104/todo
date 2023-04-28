@extends('layouts.dash')
@section('title')
    Edit Profile
@endsection
@section('head')
@endsection

@section('body')
    <div class="row">
        <div class="col-12">

            <div class="card shadow m-4">
                <div class="card-header py-3">
                    <h2 class="m-0 font-weight-bold text-primary text-center">Edit Profile</h2>
                </div>
                <div class="card-body">
                    {{-- <form>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="number" class="col-sm-2 col-form-label">Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="number" placeholder="number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form> --}}

                    <form method="POST" action="{{ route('update-profile-store') }}" enctype="multipart/form-data">
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$user->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="number" class="col-sm-2 col-form-label" >Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="number" name="number" placeholder="number" value="{{$user->number}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">Profile Image</label>

                            <div class="col-sm-10">
                                <input id="image" type="file"
                                    class="form-control @error('image') is-invalid @enderror" name="image" id="image"
                                    value="{{ old('image') }}"  autocomplete="image">

                                <img src="/images/{{ Auth::user()->image }}" style="width:150px;margin-top: 10px;"
                                    id="userImage">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Upadate Profile
                                </button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            /* This function will call when onchange event fired */
            $("#image").on("change", function() {
                /* Current this object refer to input element */
                var $input = $(this);
                var reader = new FileReader();
                reader.onload = function() {
                    $("#userImage").attr("src", reader.result);
                }
                reader.readAsDataURL($input[0].files[0]);
            });



        });
    </script>
@endsection
