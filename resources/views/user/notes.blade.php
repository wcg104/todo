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
                    <div class="row">
                        {{-- <form action="{{route('notes.index')}}" class="col-3" method="GET">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="start_date">
                                <input type="date" class="form-control" name="end_date">
                                <button class="btn btn-primary" type="submit">GET</button>
                            </div>
                        </form>
                        <form action="{{route('notes.index')}}" class="col-3" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form> --}}
                        <form action="{{route('notes.index')}}" class="col-3" method="GET">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="start_date">
                                <input type="date" class="form-control" name="end_date">
                                <button class="btn btn-primary" type="submit">GET</button>
                            </div>
                        </form>
                        <div class="form-group">
                            <input type="text" name="serach" id="serach" class="form-control" placeholder="serach"/>
                        </div>

                    </div>
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col-1">No</th>
                                <th scope="col-5" class="sorting" data-sorting_type="asc" data-column_name="title" style="cursor: pointer">Title <span id="title"></span></th>
                                <th scope="col-1">Priority</th>
                                <th scope="col-1" class="sorting" data-sorting_type="asc" data-column_name="created_at" style="cursor: pointer">Created Date <span id="created_at"></span></th>
                                <th scope="col-2">Tags</th>
                                <th scope="col-1">Status</th>
                                <th scope="col-1">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="tbody">
                            @include('user.notebody')
                            {{-- @foreach ($notes as $key => $note)
                                <tr class="fw-normal">
                               

                                    <td class="align-middle">
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
                                        <span>{{ $note->created_at->format('d/m/Y') }}</span>
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
                                        <a class="noteDone" data-id={{ $note->id }} data-action="{{route('notes.done', $note->id)}}" title="Done"><i
                                                class="fas fa-check text-success me-3 mr-3"></i></a>

                                        <a title="Remove" data-id="{{ $note->id }}"
                                            data-action="{{ route('notes.destroy', $note->id) }}" class="deleteRecord"><i
                                                class="fas fa-trash-alt text-danger mr-3"></i></a>

                                        <a href="{{ route('notes.edit', ['note' => $note->id]) }}" data-mdb-toggle="tooltip"
                                            title="edit"><i class="fas fa-pencil-alt mr-3 text-secondary"
                                                aria-hidden="true"></i></a>
                                        <a href="{{ route('notes.show', ['note' => $note->id]) }}" data-mdb-toggle="tooltip"
                                            title="view"><i class="fa fa-eye mr-3" aria-hidden="true"></i></a>

                                        <a title="archive" data-id={{ $note->id }} data-action="{{ route('notes.archive', [$note->id,'1']) }}" class="archiveNote"><i
                                                class="fa fa-archive text-secondary"></i></a>
                                    </td>
                            @endforeach --}}
                        </tbody>
                    </table>

                    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                    <div class="m-2">

                        {{-- {{ $notes->links() }} --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Delete Note  --}}
@endsection

@section('script')
    <script  src="{{ asset('/js/custom/user/notes.js') }}"></script>
    
@endsection
