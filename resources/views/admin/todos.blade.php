@extends('layouts.admindash')
@section('title')
    Notes List
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="card shadow m-4">
              
                <div class="card-body">
                    <div class="row ">
                        <div class="col-5 justify-content-start">
                            <a href="{{ route('admin.notes') }}" class=" btn btn-secondary mt-3 mb-4 ">Back</a>
                        </div>
                        <div class="col-7  ">
                            <a class="h1 text-center mt-3 mb-4 pb-3 text-primary ">
                                <i class="fas fa-check-square me-1"></i>
                                <u>Todo-s</u>
                            </a>
                        </div>
                       
                      </div>


                    {{-- <div class="text-center justify-content-center">
                        <a class="h1 text-center mt-3 mb-4 pb-3 text-primary ">
                            <i class="fas fa-check-square me-1"></i>
                            <u>Todo-s</u>
                        </a>
                    </div>
                    <div class="justify-content-start">

                        <a href="{{ route('admin.notes') }}" class="mr-4 btn btn-secondary   mt-3 mb-4 ">Back</a>
                    </div> --}}



                    <div class="row">
                        <div class="col-3 card-footer"></div>
                        <div class="col-6">

                            <table class="table mb-0 "  id="myTable">
                                <thead>
                                    <tr>
                                   
                                        <div class="row">
                                            <div class="col-6 col-sm-3"><th scope="col">Task</th></div>
                                            <div class="col-6 col-sm-3"><th scope="col">Status</th></div>
                                          
                                            <!-- Force next columns to break to new line -->
                                            
                                          </div>
                                        {{-- <th scope="col"></th> --}}
                                        {{-- <th scope="col">Task</th> --}}
                                        {{-- <th scope="col">Priority</th> --}}
                                        {{-- <th scope="col">Status</th> --}}
                         
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
        
                                    @foreach ($todos as $todo)
                                        <tr class="fw-normal row1" data-id="{{ $todo->id }}">
                                           
        
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
                           
        
                                        </tr>
                                    @endforeach
                                
        
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3 card-footer"></div>
                    </div>

                </div>

            </div>
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
