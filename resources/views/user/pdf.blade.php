<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card shadow m-4">
                {{-- <div class="card-header py-3">
                    <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Task List</h5>

                </div>
                <div class="card-footer text-end p-3">
                    <button class="me-2 btn btn-link">Cancel</button>
                    <button class="btn btn-primary">Add Task</button>
                </div> --}}
                <div class="card-body">
                    <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                        <i class="fas fa-check-square me-1"></i>
                        <u>Todo-s</u>
                    </p>

                    <div class="row m-2">
                        <span>Title : {{$note->title}}</span>

                    </div>
                    <div class="row m-2">
                        <span>status : {{$note->status}}</span>
                    </div>
                    <div class="row m-2">
                        <span>Total Task : {{$todos->count() }}</span>
                    </div>
                    
                    <table class="table m-3 " id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">Task</th>
                                {{-- <th scope="col">Priority</th> --}}
                                <th scope="col">Status</th>
                          
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($todos as $todo)
                                <tr class="fw-normal">
                                
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
</body>
</html>