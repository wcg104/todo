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
                    <form method="POST" action="{{ route('update-profile-store') }}" enctype="multipart/form-data">
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Name" value="{{ $user->name }}">
                                @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email" value="{{ $user->email }}">
                                @error('email')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="number" class="col-sm-2 col-form-label">Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('number') is-invalid @enderror"
                                    id="number" name="number" placeholder="number" value="{{ $user->number }}">
                                @error('number')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">Profile Image</label>

                            <div class="col-sm-10">
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" id="image" value="/images/{{ Auth::user()->image }}"
                                    autocomplete="image" accept="image/png, image/jpeg">

                                @if (Auth::user()->image)
                                    <div class="m-2">

                                        <a class="btn btn-secondary" id="imageRe">remove image</a>
                                    </div>
                                    <img src="/images/{{ Auth::user()->image }}" style="width:150px;margin-top: 10px;"
                                        id="userImage">
                                    <input type="hidden" name="imageRemove" id="imageRemove" value="false">
                                @endif

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
    <script src="{{ asset('/js/custom/user/profileedit.js') }}"></script>
@endsection
