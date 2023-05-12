<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

    /**
     * Notes Todo view 
     * return note all todo
     */
    public function index($id)
    {

        if (Note::find($id)->user_id == Auth::user()->id) {
            return view('user.todo', ['note' => $id, 'todos' => Note::with('todo')->where('user_id', Auth::user()->id)->find($id)->todo]);
        } else {
            return redirect(Route('user.dash'));
        }
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
     * Store new todos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',

        ]);

        Todo::create([
            'user_id' => Auth::user()->id,
            'note_id' => $request->note,
            'title' => $request->title,
            'index_no' => Todo::max('index_no') + 1,
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
        Todo::find($request->todo_id)->update(['title' => $request->name, 'updated_at' => now()]);
        return response()->json(['type' => 'success', 'message' => 'Todo Updated successfully!']);
    }

    /**
     * Remove todos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Todo::find($id)->delete();
        return response()->json(['type' => 'success', 'message' => 'Todo Deleted successfully!']);
    }

    // change todo order using drag and drop
    public function reorder(Request $request)
    {
        $todos = Todo::where('note_id',$request->note_id)->get();
        foreach ($todos as $todo) {
            foreach ($request->order as $order) {
                if ($order['id'] == $todo->id) {
                    $todo->update(['index_no' => $order['position']]);
                }
            }
        }
        return response()->json(['type' => 'success', 'message' => 'Todo Order Updated !']);
    }
}
