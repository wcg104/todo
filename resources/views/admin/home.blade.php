@extends('layouts.admindash')
@section('title')
    Admin Dashboard
@endsection

@section('body')
<div class="row m-4">

    <div class="col-lg-6">

        <!-- Circle Buttons -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Total User</h6>
            </div>
            <div class="card-body">
               {{$totalUser}}

            </div>
        </div>




    </div>

    <div class="col-lg-6">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Total Notes</h6>
            </div>
            <div class="card-body">
                {{$totalNotes}}
            </div>
        </div>

    </div>

</div>
@endsection
