@extends('layouts.dash')
@section('title')
    Notes
@endsection

@section('body')
    <div class="row">

        {{-- <a class="btn btn-secondary ml-5 mb-3" href="{{ route('notes.create') }}">
            <span>Add New Note</span>
        </a> --}}
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
                                <th scope="col">No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($notes as $key => $note)
                                <tr class="fw-normal">
                                    {{-- <th class="align-middle">{{++$index}}</th> --}}
                                    {{-- <td>{{ $loop->index+1+((($notes->currentPage())-1)*15)}}</td> --}}

                                    <td class="align-middle">
                                        {{ ++$key }}
                                        {{-- {{ ($notes->currentpage() - 1) * $notes->perpage() + $key + 1 }} --}}
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
                                        <span>{{ $note->status }}</span>
                                    </td>

                                    <td class="align-middle">
                                        {{-- <a href="{{ route('notes.unarchive', ['id' => $note->id]) }}"
                                            data-mdb-toggle="tooltip" title="unarchive"><i
                                                class="fa fa-archive text-secondary" aria-hidden="true"></i></a> --}}


                                        <a title="unarchive" data-id={{ $note->id }} class="unarchiveNote"><i
                                                class="fa fa-archive text-secondary"></i></a>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- {{ $notes->links() }} --}}

    </div>
@endsection

@section('script')
    <script>
        $(".unarchiveNote").click(function() {
            var id = $(this).data("id");
            var archive = 0 ;
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
                            title: "Unarchive Note",
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
