<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        if (Note::find($id)->user_id == Auth::user()->id) return view('user.todo', ['note' => $id, 'todos' => Todo::where('note_id', $id)->orderBy('index_no')->simplePaginate(50)]);

        return redirect(Route('user.dash'));
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
        return response()->json(Todo::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
        // dd(Todo::find($id)->note_id);
        $todo = Todo::find($id);

        if (Todo::where('note_id', $todo->note_id)->count() === 1)  return response()->json(['type' => 'error', 'message' => 'minimum 1 todo required !']);

        $todo->delete();
        return response()->json(['type' => 'success', 'message' => 'Todo Deleted successfully!']);
    }

    // change todo order using drag and drop
    public function reorder(Request $request)
    {
        // $start = microtime(true);

        foreach ($request->order as $order) {
            Todo::findOrFail($order['id'])->update(['index_no' => $order['position']]);
        }

        // $time = microtime(true) - $start;
        // Log::info($time);
        return response()->json(['type' => 'success', 'message' => 'Todo Order Updated !']);
    }
}
