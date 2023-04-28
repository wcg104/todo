<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.home',['totalUser'=>User::count(),'totalNotes' => Note::count()]);
    }

    public function notes()
    {
        
        return view('admin.notes',['notes'=>Note::simplePaginate(15)]);
    }
    public function todos($id)
    {
        // dd(Note::find($id)->with('todo')->get());
        return view('admin.todos',['todos'=>Note::find($id)->with('todo')->get()]);
        
    }

    public function userBan($id)
    {
        User::where('id', $id)
            ->update(['active' => 0]);
        return  back()->withInput();
    }

    public function userActive($id)
    {
        User::where('id', $id)
            ->update(['active' => 1]);
        return  back()->withInput();
    }
}
