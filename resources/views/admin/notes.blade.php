@extends('layouts.admindash')
@section('title')
    Notes List
@endsection

@section('body')

<div class="row m-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="m-0 font-weight-bold text-primary">All Notes</h2>

                    </div>
                    <div class="col-md-3 float-right">
                        <input class="form-control" id="myInput" type="text" placeholder="Search..">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    @foreach ($notes as $key =>$note)
                        <tbody>
                            <tr class="fw-normal">
                                <th class="align-middle">{{++$key}}</th>
                                <td class="align-middle">
                                    <span>{{$note->user_id}}</span>
                                </td>
                                <td class="align-middle">
                                    <span>{{$note->title}}</span>
                                </td>
                                <td class="align-middle">
                                    @if ($note->priority_level ==1)
                                    <h6 class="mb-0"><span class="badge bg-danger text-light">High priority</span></h6>
                                    @elseif ($note->priority_level ==2)
                                        <h6 class="mb-0"><span class="badge bg-warning text-light">Middle priority</span></h6>
                                        
                                    @else
                                    <h6 class="mb-0"><span class="badge bg-success text-light">Low priority</span></h6>
                                        
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span>{{$note->status}}</span>
                                </td>

                                <td class="align-middle">
                                    {{-- <a href="#!" data-mdb-toggle="tooltip" title="Done"><i
                                            class="fas fa-check text-success me-3 mr-3"></i></a>
                                    <a href="#!" data-mdb-toggle="tooltip" title="Remove"><i
                                            class="fas fa-trash-alt text-danger mr-3"></i></a>
                                    <a href="#!" data-mdb-toggle="tooltip" title="edit"><i
                                            class="fas fa-pencil-alt mr-3 text-secondary" aria-hidden="true"></i></a> --}}
                                    <a href="{{route('admin.todos',['id'=>$note->id])}}" data-mdb-toggle="tooltip" title="view"><i class="fa fa-eye mr-3"
                                            aria-hidden="true"></i></a>

                                </td>
                            </tr>
                            
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
            {{ $notes->links() }}
    </div>
    
</div>

@endsection

@section('script')
<script type="">
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>
@endsection