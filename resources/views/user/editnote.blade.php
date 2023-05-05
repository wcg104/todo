@extends('layouts.dash')
@section('title')
    Edit Note
@endsection

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                    <h6 class="m-0 font-weight-bold text-primary">Edit Notes</h6>
                </div>

                <div class="card-body">

                    <form action={{ route('notes.update', ['note' => $notes->id]) }} method="POST" id="addnotes"
                        class="was-validated">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="Title">Enter Title</label>
                            <input type="text" class="@error('title') is-invalid @enderror form-control" name="title"
                                value="{{ $notes->title }}" placeholder="Enter title" required>
                            @error('title')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Priority_level">Choose a Priority level:</label>

                            <select name="Priority_level" value="" id="Priority_level">
                                <option value="3">Low</option>
                                <option value="2">Medium</option>
                                <option value="1">High</option>
                            </select>
                        </div>

                        <div class="form-group">

                            {{-- tag sysytem   --}}
                            {{--  <label for="tag">Enter Tag</label>
                            <input type="text" class="form-control @error('tag') is-invalid @enderror" name="tag"
                                placeholder="Enter Tag">

                            @error('tag')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror --}}


                            <label for="select2Multiple">Tags</label>
                            {{-- @php $noteTags = explode(',', $notes->tag_id); @endphp --}}
                            {{-- @php
                                $noteTags = [];
                                foreach ($notes->tags as $selectedTag) {
                                    array_push($noteTags, $selectedTag->title);
                                }
                            @endphp --}}

                            <select class="select2-multiple form-control" name="tags[]" value="" multiple="multiple"
                                id="select2Multiple">
                                @foreach ($notes->tags as $selectedTag)
                                    <option value="{{ $selectedTag->title }}" selected>{{ $selectedTag->title }}</option>
                                @endforeach
                                {{-- @foreach ($tags as $tag)
                                    <option value="{{ $tag->title }}" {{ in_array($tag->title, $noteTags) ? 'selected' : '' }}>{{ $tag->title }}</option>
                                @endforeach --}}
                            </select>

                        </div>
                        <hr>

                        <div id="myDIV " class="header ">
                            <h2 class="d-inline">To Do List</h2>
                            <a href="javascript:void(0);" class="add_button ml-5" title="Add field"><i
                                    class="fa fa-plus ml-3 mb-3" style="font-size:20px;color:rgb(0, 255, 21)"
                                    aria-hidden="true"></i></a>
                        </div>



                        <div id="newtask" class="form-group ml-3 mb-3 field_wrapper">




                            @foreach ($todos as $todo)
                                <div class="ml-3 mb-3 todolist"><input type="text" class="todolistInput"
                                        name="todo_list[{{ $todo->id }}]" id="{{ $todo->id }}"
                                        value="{{ $todo->title }}" placeholder="task.."><a href="javascript:void(0);"
                                        class="remove_button"><i class="far fa-trash-alt ml-3"></i></a></div>
                            @endforeach
                            {{-- <div class="ml-3 mb-3"><input type="text" name="todo_list[]" value=""
                                    placeholder="task.."><a href="javascript:void(0);" class="remove_button"><i
                                        class="far fa-trash-alt ml-3"></i></a></div> --}}
                            {{-- <input type="text" class="ml-3 form-outline" name="todo_list[0]" id="todo_list"
                                value="" placeholder="task.." /> --}}
                            {{-- <a href="javascript:void(0);" class="add_button" title="Add field"><i
                                    class="fa fa-plus ml-3 mb-3" style="font-size:20px;color:rgb(0, 255, 21)"
                                    aria-hidden="true"></i></a> --}}

                        </div>



                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('notes') }}" class="btn btn-secondary ml-3">Back</a>


                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#Priority_level').val({{ $notes->priority_level }});
            removeButton();

            // todo box remove button 
            function removeButton() {
                // console.log($('.todolist').length);
                if ($('.todolist').length == 1) {
                    $('.remove_button').hide();
                }
                if ($('.todolist').length > 1) {
                    $('.remove_button').show();
                }

            }

            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            // var fieldHTML =
            //     '<div class="ml-3 mb-3"><input type="text" name="todo_list[]" value="" placeholder="task.."/><a href="javascript:void(0);" class="remove_button"><i class="far fa-trash-alt ml-3"></i></a></div>'; //New input field html 
            var x = 1; //Initial field counter is 1
            var numberIncr = 1; // used to change name
            function addInput() {
                $(wrapper).append('<div class="ml-3 mb-3 todolist"><input type="text" name="todo_list_new[' +
                    numberIncr +
                    ']" value="" class="todolistInput"    placeholder="task.." /><a href="javascript:void(0);" class="remove_button"><i class="far fa-trash-alt ml-3"></i></a></div>'
                );
                numberIncr++;
            }
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


    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").on('submit', function(e) {

                $(".todolistInput").each(function() {
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
                    error.appendTo(element.parent());

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
