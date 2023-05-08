@extends('layouts.expendtag')
@section('title')
    Notes
@endsection

@section('body')
    <div class="row">

        <a class="btn btn-secondary ml-5 mb-3" href="{{ route('notes.create') }}">
            <span>Add New Note</span>
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
                                        {{-- @php
                                        use App\Models\Note;

                                            $tags = Note::find($note->id)->tags;
                                        @endphp --}}
                                        @if ($tags->find($note->id)->tags)
                                            @foreach ($tags->find($note->id)->tags as $tag)
                                                <span class="badge badge-primary">{{ $tag->title }}</span>
                                            @endforeach
                                        @endif



                                    </td>
                                    <td class="align-middle">
                                        <span>{{ $note->status }}</span>
                                    </td>

                                    <td class="align-middle">
                                        {{-- <a href="{{ route('notes.done', ['id' => $note->id]) }}" data-mdb-toggle="tooltip" title="Done"><i
                                                class="fas fa-check text-success me-3 mr-3"></i></a> --}}
                                        <a class="noteDone" data-id={{ $note->id }} data-action={{route('notes.done', $note->id)}} title="Done"><i
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

                                        <a title="archive" data-id="{{ $note->id }}" data-action="{{ route('notes.archive', [$note->id,'1']) }}" class="archiveNote"><i
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
    {{-- Delete Note  --}}
@endsection

@section('script')
    <script src="{{ asset('/js/custom/user/notes.js') }}"></script>
@endsection
