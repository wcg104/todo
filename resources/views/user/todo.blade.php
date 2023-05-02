@extends('layouts.dash')
@section('title')
    TODO
@endsection

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
@endsection


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


                        <a class="btn btn-primary col-1" href="{{ route('note.pdf', ['id' => $note]) }}"> Export to PDF </a>
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
                                                <input class="form-check-input ml-5 mr-3 mt-0 checkbox" data-id={{ $todo->id }}
                                                    type="checkbox" value="" id="flexCheckChecked2"
                                                    aria-label="..." />
                                            @else
                                                <input class="form-check-input ml-5 mr-3 mt-0 checkbox" data-id={{ $todo->id }}
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
                                // dd($todos[0]->note_id);
                                $note_id = $todos[0]->note_id;
                            @endphp

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
                            <button type="submit" class="btn btn-primary" data-id={{ $todo->id }} id="saveBtn"
                                value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- end pop edit --}}
    {{-- {{ $notes->links() }} --}}
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // $('.Print-table').click(function() {
            //     window.print();
            // });

            //table to pdf 

            $('.Print-table').click(function() {
                // Get the table HTML
                var table = $('#myTable');
                var html = table.outerHTML;

                // Create a new jsPDF instance
                var doc = new jsPDF();

                // Add the table to the PDF document
                doc.autoTable({
                    html: html
                });

                // Download the PDF document
                doc.save('table.pdf');
            });

        });
    </script>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script type="text/javascript">
        // end table 


        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('body').on('click', '.edittodo', function() {

                var todo_id = $(this).data('id');


                $.get("" + '/todos/' + todo_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit Todo");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#todo_id').val(data.id);
                    $('#name').val(data.title);

                })
            });

            $("#saveBtn").click(function(e) {
                var id = $(this).data("id");
                console.log(id);
                var url = "{{ route('todos.update', ':id') }}";
                url = url.replace(':id', id);
                // var token = $("meta[name='csrf-token']").attr("content");
                e.preventDefault();
                $(this).html('Sending..');
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: $('#productForm').serialize(),
                    dataType: 'json',
                    success: function(data) {

                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        location.reload();
                        // table.draw();

                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                    // location.reload();
                });
            });


            $(".deleteTodo").click(function() {
                var id = $(this).data("id");
                var url = $(this).data("action");
                // url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(res) {
                        if (res.type == 'success') {
                            Swal.fire({
                                // position: 'top-end',
                                icon: 'success',
                                height: 10,
                                width: 350,
                                title: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                location.reload();
                            });



                        }
                    }
                });
            });


            // check box task 

            $('.checkbox').change(function() {
                if (this.checked) {
                    // console.log("check");
                    var id = $(this).data("id");
                    var url = "{{ route('todo.done', ':id') }}";
                    url = url.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(res) {
                            if (res.type == 'success') {
                                Swal.fire({
                                    // position: 'top-end',
                                    icon: 'success',
                                    height: 10,
                                    width: 350,
                                    title: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    location.reload();
                                });



                            }
                        }
                    });
                } else {
                    // console.log("uncheck");
                    var id = $(this).data("id");
                    var url = "{{ route('todo.pending', ':id') }}";
                    url = url.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(res) {
                            if (res.type == 'success') {
                                Swal.fire({
                                    // position: 'top-end',
                                    icon: 'success',
                                    height: 10,
                                    width: 350,
                                    title: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    location.reload();
                                });



                            }
                        }
                    });

                }
                // $('#textbox1').val(this.checked);
            });

        });
    </script>

    {{-- re order todos --}}
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Datatables Js-->
    {{-- <script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> --}}

    <script type="text/javascript">
        $(function() {
            // $("#myTable").DataTable();

            $("#tablecontents").sortable({
                // items: "tr",
                handle: '.changeOrder',
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {

                var order = [];
                $('tr.row1').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('todos.reorder') }}",
                    data: {
                        order: order,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.type == 'success') {

                            // Swal.fire({
                            //     // position: 'top-end',
                            //     icon: 'success',
                            //     // height: 10,
                            //     width: 350,
                            //     title: res.message,
                            //     showConfirmButton: false,
                            //     timer: 1500
                            // })



                        }
                    }
                });

            }
        });
    </script>
@endsection
