@extends('layouts.dash')
@section('title')
    Add Note
@endsection
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error {
            color: #FF0000;
            font-size: 1rem;
        }
    </style>
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="card shadow m-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add New Notes</h6>
                </div>
                <div class="card-body">
                    <form action={{ route('notes.store') }} method="POST" id="addnotes" class="addnotes">
                        @csrf
                        <div class="form-group">
                            <label for="Title">Enter Title</label>
                            <input type="text" class="@error('title') is-invalid @enderror form-control" name="title"
                                placeholder="Enter title" id="title">
                            @error('title')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Priority_level">Choose a Priority level:</label>

                            <select name="Priority_level" id="Priority_level">
                                <option value="3">Low</option>
                                <option value="2">Medium</option>
                                <option value="1">High</option>
                            </select>
                        </div>

                        <div class="form-group">


                            <label for="select2Multiple">Tags</label>
                            <select class="select2-multiple form-control " name="tags[]" multiple="multiple"
                                id="select2Multiple">

                                <option value=""></option>
                                {{-- @foreach ($tags as $tag)
                                    <option value="{{ $tag->title }}">{{ $tag->title }}</option>
                                @endforeach --}}

                            </select>

                        </div>
                        <hr>

                        <div id="myDIV" class="header">
                            <h2 class="d-inline">To Do List</h2>
                            <a href="javascript:void(0);" class="add_button ml-5" title="Add field"><i
                                    class="fa fa-plus ml-3 mb-3" style="font-size:20px;color:rgb(0, 255, 21)"
                                    aria-hidden="true"></i></a>

                        </div>
                        {{-- @if ($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif --}}

                        @error('todo_list.0')
                            <span class="alert-danger ml-4">All field is required.</span>
                        @enderror

                        <div id="newtask" class="form-group ml-3 mb-3 field_wrapper">
                            {{-- <input type="text" class="ml-3 form-outline " name="todo_list[0]" class="todo_input"
                                id="todo_list" value="" placeholder="task.." />
                            <a href="javascript:void(0);" class="add_button" title="Add field"><i
                                    class="fa fa-plus ml-3 mb-3" style="font-size:20px;color:rgb(0, 255, 21)"
                                    aria-hidden="true"></i></a>
                            <br> --}}
                        </div>



                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('notes') }}" class="btn btn-secondary ml-3">Back</a>


                    </form>

                    {{-- <a class='btn btn-primary addNewNote'
                        onclick="event.preventDefault();  document.getElementById('addnotes').submit();">Submit</a> --}}
                    {{-- <a href="{{ url('notes') }}" class="btn btn-secondary ml-3">Back</a> --}}

                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var counter = 1;
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper


            // var fieldHTML =
            //     '<div class="ml-3 mb-3"><input type="text" name="todo_list[' +counter  +
            //     ']" value="" class="todo_input" placeholder="task.." /><a href="javascript:void(0);" class="remove_button"><i class="far fa-trash-alt ml-3"></i></a></div>'; //New input field html 

            var numberIncr = 1; // used to change name
            function addInput() {
                $(wrapper).append('<div class="ml-3 mb-3"><input type="text" name="todo_list[' + numberIncr +
                    ']" value="" class="todo_input"  placeholder="task.." /><a href="javascript:void(0);" class="remove_button"><i class="far fa-trash-alt ml-3"></i></a> </div>'
                );


                numberIncr++;
            }

            removeButton();

            // todo box remove button 
            function removeButton() {
                // console.log($('.todolist').length);
                if ($('.todo_input').length == 1) {
                    $('.remove_button').hide();
                }
                if ($('.todo_input').length > 1) {
                    $('.remove_button').show();
                }

            }


            // 4 box onload
            $(window).on("load", function() {
                for (let index = 0; index < 5; index++) {
                    addInput(); //Add field html
                }

            });


            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    addInput(); //Add field html
                    removeButton();

                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
                removeButton();
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $("form").on('submit', function(e) {

                $(".todo_input").each(function() {
                    $(this).rules("add", "required");
                    $(this).rules('add', {
                        required: true,
                        messages: {
                            required: "Enter Todo"
                        }
                    });
                });
                //stop form submission
                // e.preventDefault();
            });


            $('#addnotes').validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 150,
                        minlength: 2,
                        letterswithbasicpunc: true,
                        // textonly: true,

                    },
                    // 'todo_list[0]': {
                    //     required: true,
                    // },


                },
                messages: {
                    title: {
                        required: "Please Enter Title",
                        maxlength: "Max 150 Word title allowed",
                        minlength: "min 2 Word title Required",
                        letterswithbasicpunc: "Alphabet and Number Not Allowd",
                    },
                    // 'todo_list[0]': {
                    //     required: "Enter Todo",
                    // },

                },

                errorPlacement: function(error, element) {

                    if (element.attr("name") == "title") {
                        error.insertAfter(element);
                    }
                    // error.appendTo(element.nextUntil("div"));
                    error.insertAfter(element.nextUntil("div"));


                }
            })





        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('.select2-multiple').select2({
                    ajax: {
                        url: "{{ route('search.tags') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: function(params) {
                            return {
                                tag: params.term // search term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data.message, function(tag) {
                                    return {
                                        text: tag.title,
                                        id: tag.title
                                    }
                                })
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Search Tag',
                    tags: true,
                    minimumInputLength: 2,
                    allowClear: true,
                });
            });
       
    </script>
@endsection
