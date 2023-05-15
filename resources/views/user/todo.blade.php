@extends('layouts.dash')
@section('title')
    TODO
@endsection

{{-- @section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
@endsection --}}


@section('body')
    <div class="row">
        <div class="col-12">
            <div class="card shadow m-4">
                <div class="card-body">
                    <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                        <i class="fas fa-check-square me-1"></i>
                        <u>Todo-s</u>
                    </p>

                    <div class="card-footer text-end p-3 row">
                        {{-- <button class="mr-4 btn btn-secondary col-1">Back</button> --}}
                        <a href="{{ route('notes.index') }}" class="mr-4 btn btn-secondary">Back</a>
                        <form class="col-10 row" action={{ route('notes.todos.store', ['note' => $note]) }} method="POST">
                            @csrf
                            <input type="text" id="title" name="title"
                                class="form-control col-5 @error('title') is-invalid @enderror;" />
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <button class="btn btn-primary col-1 ml-3" type="submit">Add Task</button>
                        </form>


                        <a class="btn btn-primary" href="{{ route('note.pdf', ['id' => $note]) }}"> Export to PDF </a>
                        {{-- <a class="btn btn-primary col-1 Print-table"> Export to PDF </a> --}}



                    </div>
                    <table class="table mb-0 " id="myTable">
                        <thead>
                            <tr>
                                <th scope="col"></th>

                                {{-- <th scope="col"></th> --}}
                                <th scope="col">Task</th>
                                {{-- <th scope="col">Priority</th> --}}
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tablecontents">

                            @foreach ($todos as $todo)
                                <tr class="fw-normal row1" data-id="{{ $todo->id }}">
                                    <td class="align-middle">
                                        <div class="row ">
                                            {{-- <i class="fas fa-arrows-alt mr-3 ml-3 text-secondary changeOrder"></i> --}}
                                            <i class="fas fa-bars mr-3 ml-3 text-secondary changeOrder"></i>

                                            @if ($todo->status == 'pending')
                                                <input class="form-check-input ml-5 mr-3 mt-0 checkbox"
                                                    data-id="{{ $todo->id }}"
                                                    data-action="{{ route('todo.status', [$todo->id, 'completed']) }}"
                                                    type="checkbox" value="" id="flexCheckChecked2"
                                                    aria-label="..." />
                                            @else
                                                <input class="form-check-input ml-5 mr-3 mt-0 checkbox"
                                                    data-id="{{ $todo->id }}"
                                                    data-action="{{ route('todo.status', [$todo->id, 'pending']) }}"
                                                    type="checkbox" value="" id="flexCheckChecked2" aria-label="..."
                                                    checked />
                                            @endif

                                        </div>
                                    </td>

                                    <td class="align-middle">
                                        <span id="maintitle">{{ $todo->title }}</span>
                                    </td>
                                    @if ($todo->status == 'pending')
                                        <td class="align-middle">
                                            <h6 class="mb-0"><span class="badge bg-danger text-light">Pending</span></h6>
                                        </td>
                                    @else
                                        <td class="align-middle">
                                            <h6 class="mb-0"><span class="badge bg-success text-light">Completed</span>
                                            </h6>
                                        </td>
                                    @endif

                                    <td class="align-middle">

                                        <a title="edit" data-id={{ $todo->id }}
                                            data-action="{{ route('todos.edit', ['todo' => $todo->id]) }}"
                                            class="edittodo"><i class="fas fa-pencil-alt mr-3 text-secondary"></i></a>
                                        <a data-id={{ $todo->id }}
                                            data-action="{{ route('todos.destroy', ['todo' => $todo->id]) }}"
                                            class="deleteTodo" title="Remove"><i
                                                class="fas fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @php
                                $note_id = $todos[0]->note_id;
                            @endphp
                            <tr>
                                <td colspan="3">{{ $todos->links() }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    {{-- pop edit --}}
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="todo_id" id="todo_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">TODO</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter TODO" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" data-id="{{ $todo->id }}"
                                data-action="{{ route('todos.update', $todo->id) }}" id="saveBtn" value="create">Save
                                changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- end pop edit --}}
@endsection

@section('script')
 
    {{-- re order todos --}}
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var ChangeOrderRoute = "{{ route('todos.reorder') }}";
        var note_id = {{$note}};
        </script>
    <script src="{{asset('/js/custom/user/todo.js')}}"></script>
@endsection
