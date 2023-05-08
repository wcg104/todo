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
                            <label for="select2Multiple">Tags</label>

                            <select class="select2-multiple form-control" name="tags[]" value="" multiple="multiple"
                                id="select2Multiple">
                                @foreach ($notes->tags as $selectedTag)
                                    <option value="{{ $selectedTag->title }}" selected>{{ $selectedTag->title }}</option>
                                @endforeach

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        var tagSearchUrl = "{{ route('search.tags') }}";
    </script>

    <script src="{{ asset('/js/custom/user/editnote.js') }}"></script>
@endsection
