<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;


class AdminDashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // Return Total user count and total notes too show admin dash.
    public function index()
    {
        return view('admin.home', ['totalUser' => User::count(), 'totalNotes' => Note::count()]);
    }

    // return all notes list 
    public function notes()
    {
        return view('admin.notes', ['notes' => Note::simplePaginate(15)]);
    }

    // return notes todos, if admin view note 1 then return note 1 all todos. 
    public function todos($id)
    {
        return view('admin.todos', ['todos' => Note::find($id)->with('todo')->get()]);
    }

    // change user status block and unblock
    public function changeUserStatus($id, $status)
    {
        User::where('id', $id)
            ->update(['active' => $status]);
        return  back()->withInput();
    }
}
