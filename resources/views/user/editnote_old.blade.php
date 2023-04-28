{{-- <form action={{ route('notes.update',['note'=>$notes->id])}} method="POST" id="addnotes">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="Title">Enter Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror;" name="title"
                                placeholder="Enter title" value="{{$notes->title}}">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Priority_level">Choose a Priority level:</label>

                            <select name="Priority_level" id="Priority_level">
                                <option value="3">Low</option>
                                <option value="2">Medium</option>
                                <option value="1">High</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tag">Enter Tag</label>
                            <input type="text" class="form-control" name="tag" placeholder="Enter Tag">
                        </div>





                    </form> --}}