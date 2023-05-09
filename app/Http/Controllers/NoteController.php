<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return user note list 
     * allow to filter note with start_date to End_date
     * allow user to search notes
     */
    public function index(Request $request)
    {
        // if request has start_date  or end_date and return data
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $notes = Note::whereBetween('created_at', [$start_date, $end_date])->where('archive', 0)->simplePaginate(10);
        }
        // user can search note then search in title and return match data
        elseif ($request->ajax()) {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $notes = User::find(Auth::user()->id)->note();
            $notes = $notes->where('title', 'like', '%' . $query . '%')->simplePaginate(10);
            return view('user.notebody', compact('notes'))->render();
        } else {
            $notes = User::with('note')->find(Auth::user()->id)->note()->simplePaginate(10);
        }
        return view('user.notes', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.addnote');
    }

    /**
     * Store a newly created Note .
     * take input note title , priority_level , tags , todos 
     * 
     */
    public function store(StoreNoteRequest $request)
    {

        $tags = [];
        // if tags are exits in request , tag are not in database then create new tag and all tag id push in one array 
        if ($request->tags) {
            foreach ($request->tags as $key => $value) {
                Tag::firstOrCreate(['title' => $value]);
                array_push($tags, Tag::where('title', $value)->first()->id);
            }
        }

        // create new note 
        $notes = new Note();
        $notes->user_id = Auth::user()->id;
        $notes->title = $request->input('title');
        $notes->priority_level = $request->input('Priority_level');
        $notes->save();
        $notes->tags()->attach($tags);

        // store todo 
        foreach ($request->todo_list as  $todoTitle) {
            Todo::create([
                'user_id' => Auth::user()->id,
                'note_id' => $notes->id,
                'title' => $todoTitle,
                'index_no' => Todo::max('index_no') + 1,
            ]);
        }

        return redirect('notes')->with('success', 'Note created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('notes.todos.index', ['note' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notes = Note::find($id);
        $todos = Todo::where('user_id', Auth::user()->id)->where('note_id', $id)->get();
        return view('user.editnote', ['notes' => $notes, 'todos' => $todos]);
    }

    /**
     * Update Note.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteRequest $request, $id)
    {

        $tags = [];
        if ($request->tags) {
            foreach ($request->tags as $key => $value) {
                Tag::firstOrCreate(['title' => $value]);
                array_push($tags, Tag::where('title', $value)->first()->id);
            }
        }


        // note title update

        $notes = Note::find($id);
        $notes->title = $request->title;
        $notes->priority_level = $request->Priority_level;
        $notes->save();
        $notes->tags()->sync($tags);





        //  all old todo are deleted
        if (!$request->todo_list) {
            Todo::where('note_id', $id)->delete();
        } else {
            // if todo is edited
            $oldTodo = [];
            foreach ($request->todo_list as $key => $value) {
                array_push($oldTodo, $key);

                Todo::find($key)->update(['title' => $value, 'updated_at' => now()]);
            }

            // delete old todo
            $oldTodoId = Todo::where('note_id', $id)->pluck('id');

            foreach ($oldTodoId as $key => $value) {
                if (!in_array($value, $oldTodo)) {
                    Todo::find($value)->delete();
                }
            }
        }


        // new todos
        if ($request->todo_list_new) {
            foreach ($request->todo_list_new as $key => $value) {
                Todo::create([
                    'user_id' => Auth::user()->id,
                    'note_id' => $id,
                    'title' => $value,
                    'index_no' => Todo::max('index_no') + 1,
                ]);
            }
        }


        return redirect('notes')->with('success', 'Note Updated successfully!');
    }

    /**
     * delete note and note todos. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notes = Note::find($id);
        $notes->delete();
        return response()->json(['type' => 'success', 'message' => 'Note Deleted successfully!']);
    }
}
