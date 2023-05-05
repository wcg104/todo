<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use PDF;


class UserDashController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect(Route('user.dash'));
    }
    // user dash home
    public function home()
    {
        return view('user.home', [
            'notes' => Note::where('user_id', Auth::user()->id)->orderBy('priority_level')->take(10)->get(),
            'restnotes' => Note::where('user_id', Auth::user()->id)->orderBy('priority_level')->skip(10)->take(10)->orderBy('id')->get()
        ]);
    }

    // change note status as completed
    public function noteDone($id)
    {
        Note::find($id)->update(['status' => 'completed ']);
        return response()->json(['type' => 'success', 'message' => 'Note  Successfully completed']);
    }

    // note archive , Unarchive
    public function noteArchiveUnarchive($id,$archive)
    {
        Note::find($id)->update(['archive' => $archive]);
        return response()->json(['type' => 'success']);
    }
    // archive note list
    public function archiveNote()
    {
        return view('user.archivenote', ['notes' => Note::where('user_id', Auth::user()->id)->where('archive', 1)->get()]);
    }

    // change todo status pending,completed
    public function todoStatusChange($id,$status)
    {
        Todo::find($id)->update(['status' => $status]);
        return response()->json(['type' => 'success', 'message' => "Task Status Update as a $status"]);
    }


    // generate notes pdf
    public function generatePDF($id)
    {
        $note_id = Note::findOrFail($id);
        $data = [
            'note' => $note_id,
            'todos' => Note::with('todo')->where('user_id', Auth::user()->id)->find($id)->todo,
        ];
        return PDF::loadView('user.pdf', $data)->download('print.pdf');
    }


    // get not list fliter by tags
    public function tagNotes($tag)
    {
        $notes = Tag::where('title', $tag)->with('notes')->first()->notes;
        $tags = Note::with('tags')->get();

        return view('user.tagnotes', ['notes' => $notes, 'tags' => $tags]);
    }
}
