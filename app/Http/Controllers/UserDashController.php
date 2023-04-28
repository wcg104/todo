<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
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
        // User::onlyTrashed()->where('id', 4)->restore();
        return redirect(Route('user.dash'));
    }

    public function home()
    {

        return view('user.home', [
            'notes' => Note::where('user_id', Auth::user()->id)->orderBy('priority_level')->take(10)->get(),
            'restnotes' => Note::where('user_id', Auth::user()->id)->orderBy('priority_level')->skip(10)->take(10)->orderBy('id')->get()
        ]);
    }

    public function noteDone($id)
    {
        Note::find($id)->update(['status' => 'completed ']);
        return response()->json(['type' => 'success', 'message' => 'Note  Successfully completed']);

        // return back();
    }

    public function noteArchive($id)
    {

        Note::find($id)->update(['archive' => 1]);
        return response()->json(['type' => 'success', 'message' => 'Note archive Success']);

        // return back();
    }

    public function archiveNote()
    {
        return view('user.archivenote', ['notes' => Note::where('user_id', Auth::user()->id)->where('archive', 1)->get()]);
    }

    public function noteUnarchive($id)
    {

        // dd($id);
        Note::find($id)->update(['archive' => 0]);
        return response()->json(['type' => 'success', 'message' => 'Note Unarchive Success']);
        // return back();
    }

    public function todoDone($id)
    {
        Todo::find($id)->update(['status' => 'completed']);
        return response()->json(['type' => 'success', 'message' => 'Task Status Update as a Completed']);
    }

    public function todoPending($id)
    {
        Todo::find($id)->update(['status' => 'pending']);
        return response()->json(['type' => 'success', 'message' => 'Task Status Update as a Pending']);
    }

    public function generatePDF($id)
    {
        // dd(Note::find($id)->with('todo')->first());
        // dd(Note::find($id)->with('todo')->where('user_id', Auth::user()->id)->first()->todo);
        $data = [
            'note' => $id,
            'todos' => Note::find($id)->with('todo')->where('user_id', Auth::user()->id)->first()->todo,
            // 'title' => Note::find($id)->with('todo')->first()->title,
            // 'tag' => Note::find($id)->with('todo')->first()->priority_level,
            // 'tag' => Note::find($id)->with('todo')->first()->tag_id,
            // 'status' => Note::find($id)->with('todo')->first()->status,
        ];
        
        $note_id = Note::findOrFail($id);
        $data = [
            'note' => $note_id,
            'todos' => Note::with('todo')->where('user_id', Auth::user()->id)->find($id)->todo,
        ];
        // return view('user.pdf',$data);
        return PDF::loadView('user.pdf', $data)->download('print.pdf');
    }



    public function tagNotes($tag)
    {
        $notes = Tag::where('title',$tag)->with('notes')->first()->notes;
        $tags = Note::with('tags')->get();
        
        return view('user.tagnotes', ['notes' => $notes,'tags'=>$tags]);
        
    }
}
