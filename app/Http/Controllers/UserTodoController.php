<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserTodoController extends Controller
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
    public function index($id, Request $request)
    {


        //end


        // dd(Note::with('todo')->where('user_id',Auth::user()->id)->find($id)->todo);
        if (Note::find($id)->user_id == Auth::user()->id) {
            # code...
            return view('user.todo', ['note' => $id, 'todos' => Note::with('todo')->where('user_id', Auth::user()->id)->find($id)->todo]);
        } else {
            return redirect(Route('user.dash'));
        }


        // dd(Note::find($id)->user_id);

        // if (Note::find($id)->user_id == Auth::user()->id) {
        //     # code...
        //     return view('user.todo',['note'=>$id,'todos'=>Todo::where('note_id',$id)->where('user_id',Auth::user()->id)->get()]);
        // }
        // else{
        //     return redirect(Route('user.dash'));
        // }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->note);

        // dd($request->title);
        $request->validate([
            'title' => 'required|max:255',

        ]);

        Todo::create([
            'user_id' => Auth::user()->id,
            'note_id' => $request->note,
            'title' => $request->title,
            // 'index_no' => $request->note,
            'index_no' => Todo::max('index_no') + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('notes.todos.index', ['note' => $request->note])->with('success', 'TODO created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        dd("show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $product = Todo::find($id);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->toArray());

        Todo::find($request->todo_id)->update(['title' => $request->name, 'updated_at' => now()]);

        return response()->json(['type' => 'success', 'message' => 'Todo Updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd("delete");
        Todo::find($id)->delete();
        return response()->json(['type' => 'success', 'message' => 'Todo Deleted successfully!']);
    }

    public function reorder(Request $request)
    {
        // dd($request->all());
        $posts = Todo::all();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['index_no' => $order['position']]);
                }
            }
        }
       
        return response()->json(['type' => 'success', 'message' => 'Todo Order Updated !']);



    }
}
