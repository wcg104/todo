<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\NoteTag;
use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


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
    public function index()
    {
        // dd(User::with('note')->find(Auth::user()->id)->note);

        return view('user.notes', ['notes' => User::with('note')->find(Auth::user()->id)->note]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        return view('user.addnote', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

// old 
    // public function store(StoreNoteRequest $request)
    // {
    //     // dd($request->input('Priority_level'));

    //     // dd($request->all());
    //     $tags = [];
    //     if ($request->tags) {
    //         foreach ($request->tags as $key => $value) {
    //             Tag::firstOrCreate(['title' => $value]);
    //             array_push($tags,Tag::where('title', $value)->first()->id);
               
    //         }
    //     }
  
    //     $notes = new Note();
    //     $notes->user_id=Auth::user()->id;
    //     $notes->title = $request->input('title');
    //     $notes->priority_level = $request->input('Priority_level');
    //     $notes->created_at = now();
    //     $notes->updated_at = now();
    //     $notes->save();
    //     $notes->tags()->attach($tags);

      

    //     foreach ($request->todo_list as $key => $value) {
    //         Todo::create([
    //             'user_id' => Auth::user()->id,
    //             'note_id' => Note::latest()->first()->id,
    //             'title' => $value,
    //             'index_no' => Todo::max('index_no') + 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     }

    //     return redirect('notes')->with('success', 'Note created successfully!');
    //     // return back()->with('success', 'Note created successfully!');

    // }

    //end

    public function store(StoreNoteRequest $request)
    {
        // dd($request->input('Priority_level'));

        // dd($request->all());
        $tags = [];
        if ($request->tags) {
            foreach ($request->tags as $key => $value) {
                Tag::firstOrCreate(['title' => $value]);
                array_push($tags,Tag::where('title', $value)->first()->id);
               
            }
        }
  
        $notes = new Note();
        $notes->user_id=Auth::user()->id;
        $notes->title = $request->input('title');
        $notes->priority_level = $request->input('Priority_level');
        $notes->created_at = now();
        $notes->updated_at = now();
        $notes->save();
        $notes->tags()->attach($tags);

      

        foreach ($request->todo_list as $key => $value) {
            Todo::create([
                'user_id' => Auth::user()->id,
                'note_id' => Note::latest()->first()->id,
                'title' => $value,
                'index_no' => Todo::max('index_no') + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('notes')->with('success', 'Note created successfully!');
        // return back()->with('success', 'Note created successfully!');

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
        $tags = Tag::all();
        $todos = Todo::where('user_id', Auth::user()->id)->where('note_id', $id)->get();

        return view('user.editnote', ['notes' => $notes, 'tags' => $tags, 'todos' => $todos]);
        // return response()->json($notes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteRequest $request, $id)
    {
        // dd($request->all());

        $tags = [];
        if ($request->tags) {
            foreach ($request->tags as $key => $value) {
                Tag::firstOrCreate(['title' => $value]);
                array_push($tags,Tag::where('title', $value)->first()->id);
               
            }
        }


        // note title update

        $notes = Note::find($id);
        $notes->title = $request->title;
        $notes->priority_level = $request->Priority_level;
        $notes->updated_at = now();
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
            $oldTodoId = Todo::where('note_id',$id)->pluck('id');
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
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }




        // foreach ($request->todo_list as $key => $value) {
        //     $key = explode('_', $key);
        //     // echo $key[0] . "=>" . $value;
        //     // // echo count($key);

        //     // echo "<br>";
        //     if (count($key) == 2 && $value != "") {
        //         Todo::find($key[0])->update(['title' => $value, 'updated_at' => now()]);
        //     } elseif (count($key) == 2 && $value == "") {
        //         Todo::find($key[0])->delete();
        //     } elseif (count($key) == 1 && $value != "") {
        //         Todo::create([
        //             'user_id' => Auth::user()->id,
        //             'note_id' => $id,
        //             'title' => $value,
        //             'index_no' => Todo::max('index_no') + 1,
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);
        //     }
        // }



        return redirect('notes')->with('success', 'Note Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notes = Note::find($id);
        $notes->tags()->detach();
        $notes->delete();
        Todo::where('note_id', $id)->delete();
        // return redirect('notes')->with('success', 'Note Deleted successfully!');
        // Todo::where('note_id',$id)->delete();
        return response()->json(['type' => 'success', 'message' => 'Note Deleted successfully!']);
    }
}