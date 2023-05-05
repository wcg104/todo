@extends('layouts.dash')
@section('title')
    Notes
@endsection

@section('body')
    <div class="row">

        <a class="btn btn-secondary ml-5 mb-3" href="{{ route('notes.create') }}">
            <span>Add New Note</span>
        </a>

        <a class="btn btn-secondary ml-5 mb-3" href="{{ route('bulk.index') }}">
            <span>Bulk csv upload</span>
        </a>
        {{-- <button type="button" class="btn btn-secondary ml-5 mb-3">Add New Note</button> --}}
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow m-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary ">All Notes</h6>
                </div>



                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col-1">No</th>
                                <th scope="col-5">Title</th>
                                <th scope="col-1">Priority</th>
                                <th scope="col-2">Tags</th>
                                <th scope="col-1">Status</th>
                                <th scope="col-1">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($notes as $key => $note)
                                <tr class="fw-normal">
                                    {{-- <th class="align-middle">{{++$index}}</th> --}}
                                    {{-- <td>{{ $loop->index+1+((($notes->currentPage())-1)*15)}}</td> --}}

                                    <td class="align-middle">
                                        {{-- {{ ++$key }} --}}
                                        {{ ($notes->currentpage() - 1) * $notes->perpage() + $key + 1 }}
                                    </td>

                                    <td class="align-middle">
                                        <span>{{ $note->title }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @if ($note->priority_level == 1)
                                            <h6 class="mb-0"><span class="badge bg-danger text-light">High priority</span>
                                            </h6>
                                        @elseif ($note->priority_level == 2)
                                            <h6 class="mb-0"><span class="badge bg-warning text-light">Middle
                                                    priority</span></h6>
                                        @else
                                            <h6 class="mb-0"><span class="badge bg-success text-light">Low priority</span>
                                            </h6>
                                        @endif
                                    </td>
                                    <td class="align-middle">


                                        @foreach ($note->tags as $tag)
                                            <span class="badge badge-primary">{{ $tag->title }}</span>
                                        @endforeach

                                    </td>
                                    <td class="align-middle">
                                        <span>{{ $note->status }}</span>
                                    </td>

                                    <td class="align-middle">
                                        {{-- <a href="{{ route('notes.done', ['id' => $note->id]) }}" data-mdb-toggle="tooltip" title="Done"><i
                                                class="fas fa-check text-success me-3 mr-3"></i></a> --}}
                                        <a class="noteDone" data-id={{ $note->id }} title="Done"><i
                                                class="fas fa-check text-success me-3 mr-3"></i></a>

                                        <a title="Remove" data-id="{{ $note->id }}"
                                            data-action="{{ route('notes.destroy', $note->id) }}" class="deleteRecord"><i
                                                class="fas fa-trash-alt text-danger mr-3"></i></a>

                                        <a href="{{ route('notes.edit', ['note' => $note->id]) }}" data-mdb-toggle="tooltip"
                                            title="edit"><i class="fas fa-pencil-alt mr-3 text-secondary"
                                                aria-hidden="true"></i></a>
                                        <a href="{{ route('notes.show', ['note' => $note->id]) }}" data-mdb-toggle="tooltip"
                                            title="view"><i class="fa fa-eye mr-3" aria-hidden="true"></i></a>

                                        {{-- <a href="{{ route('notes.archive', ['id' => $note->id])}}" data-mdb-toggle="tooltip"
                                            title="archive"><i class="fa fa-archive text-secondary" aria-hidden="true"></i></a> --}}

                                        <a title="archive" data-id={{ $note->id }} class="archiveNote"><i
                                                class="fa fa-archive text-secondary"></i></a>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="m-2">

                        {{ $notes->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Delete Note  --}}
@endsection

@section('script')
    <script>
        $(".deleteRecord").click(function() {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");


            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).data("action"),
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function(res) {
                            if (res.type == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });

                            }
                        }
                        // location.reload();
                    });
                }
            })





        });

        $(".archiveNote").click(function() {
            var id = $(this).data("id");
            var archive = 1 ;
            var url = "{{ route('notes.archive', [':id',':archive']) }}";
            url = url.replace(':id', id);
            url = url.replace(':archive', archive);

            $.ajax({
                url: url,
                type: 'get',
                success: function(res) {
                    if (res.type == 'success') {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            height: 10,
                            width: 350,
                            title: 'Archive Note',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            location.reload();
                        });



                    }
                }
            });
        });

        $(".noteDone").click(function() {
            var id = $(this).data("id");
            var url = "{{ route('notes.done', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
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
    </script>
@endsection
