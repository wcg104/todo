@extends('layouts.dash')
@section('title')
    Dashboard
@endsection

@section('body')
    {{-- <div class="row">
        <a class="btn btn-secondary ml-5 mb-3" href="{{ route('notes.create') }}">
            <span>Add New Note</span>
        </a>
    </div> --}}
   
    <div class="row">

        <div class="col-lg-6">

            <!-- Circle Buttons -->
            <div class="card shadow ml-4 mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Priority Notes</h6>
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
                        @foreach ($notes as $key => $note)
                            <tbody>
                                <tr class="fw-normal">
                                    <th class="align-middle">{{ ++$key }}</th>
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
                                        {{-- <a href="#!" data-mdb-toggle="tooltip" title="Done"><i
                                                class="fas fa-check text-success me-3 mr-3"></i></a>
                                        <a href="#!" data-mdb-toggle="tooltip" title="Remove"><i
                                                class="fas fa-trash-alt text-danger mr-3"></i></a>
                                        <a href="#!" data-mdb-toggle="tooltip" title="edit"><i
                                                class="fas fa-pencil-alt mr-3 text-secondary" aria-hidden="true"></i></a> --}}
                                        <a href="{{ route('notes.show', ['note' => $note->id]) }}" data-mdb-toggle="tooltip" title="view"><i class="fa fa-eye mr-3"
                                                aria-hidden="true"></i></a>

                                    </td>
                                </tr>

                            </tbody>
                        @endforeach
                    </table>

                </div>
            </div>




        </div>

        <div class="col-lg-6">

            <div class="card shadow mt-4 mr-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rest Notes</h6>
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
                        
                        @foreach ($restnotes as $key => $restnote)
                            <tbody>
                                <tr class="fw-normal">
                                    <th class="align-middle">{{ ++$key }}</th>
                                    <td class="align-middle">
                                        <span>{{ $restnote->title }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @if ($restnote->priority_level == 1)
                                            <h6 class="mb-0"><span class="badge bg-danger text-light">High priority</span>
                                            </h6>
                                        @elseif ($restnote->priority_level == 2)
                                            <h6 class="mb-0"><span class="badge bg-warning text-light">Middle
                                                    priority</span></h6>
                                        @else
                                            <h6 class="mb-0"><span class="badge bg-success text-light">Low priority</span>
                                            </h6>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span>{{ $restnote->status }}</span>
                                    </td>

                                    <td class="align-middle">
                                        {{-- <a href="#!" data-mdb-toggle="tooltip" title="Done"><i
                                                class="fas fa-check text-success me-3 mr-3"></i></a>
                                        <a href="#!" data-mdb-toggle="tooltip" title="Remove"><i
                                                class="fas fa-trash-alt text-danger mr-3"></i></a>
                                        <a href="#!" data-mdb-toggle="tooltip" title="edit"><i
                                                class="fas fa-pencil-alt mr-3 text-secondary" aria-hidden="true"></i></a> --}}
                                        <a href="{{ route('notes.show', ['note' => $note->id]) }}" data-mdb-toggle="tooltip" title="view"><i class="fa fa-eye mr-3"
                                                aria-hidden="true"></i></a>

                                    </td>
                                </tr>

                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection
