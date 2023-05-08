@extends('layouts.dash')
@section('title')
    Add bulk data
@endsection
@section('head')
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="card shadow m-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add data </h6>
                </div>

                <div class="card-body">

                    <form method="post" id="form" data-action="{{ route('bulk.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="data" class="m-3 mb-0">Upload csv file</label> <br>
                        <input type="file" class="m-3" name="data" id="data" accept=".csv"
                            onchange="checkfile(this);" required> <br>
                        @error('data')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <button class="m-3">Submit</button>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/custom/user/bulk.js') }}"></script>
@endsection
