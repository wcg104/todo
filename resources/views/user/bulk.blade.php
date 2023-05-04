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

                    <form method="post" id="form" enctype="multipart/form-data">
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
    <script type="text/javascript" language="javascript">
        function checkfile(sender) {
            var validExts = new Array(".xlsx", ".xls", ".csv");
            var fileExt = sender.value;
            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
            if (validExts.indexOf(fileExt) < 0) {
                alert("Invalid file selected,Upload only csv file");
                $(sender).val("");
                return false;
            } else return true;
        }

        $('form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            Swal.fire({
                title: 'Please Wait !',
                html: 'from is submitting',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },

            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('bulk.store') }}",
                type: 'POST',
                // data: formData,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {

                    if (result.type == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.message,
                        })
                        $("#form")[0].reset();

                    }
                    if (result.type == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Report',
                            html: "TotalRows :" + result.TotalRows + " <br> ValidRows : " +
                                result.ValidRows + " <br> InvalidRows : " + result.InvalidRows +
                                "",
                        })
                        $("#form")[0].reset();
                    }
                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data,
                    })
                    $("#form")[0].reset();
                }
            });

        });

        // $("#form").submit(function(e) {

        //     e.preventDefault(); // avoid to execute the actual submit of the form.

        //     var form = $(this);
        //     var actionUrl = form.attr('action');

        //     $.ajax({
        //         type: "POST",
        //         url: {{ route('bulk.store') }},
        //         data: form.serialize(), // serializes the form's elements.
        //         success: function(data) {
        //             alert(data); // show response from the php script.
        //         }
        //     });

        // });
    </script>
@endsection
