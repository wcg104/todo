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
    }

    public function noteArchive($id)
    {

        Note::find($id)->update(['archive' => 1]);
        return response()->json(['type' => 'success', 'message' => 'Note archive Success']);
    }

    public function archiveNote()
    {
        return view('user.archivenote', ['notes' => Note::where('user_id', Auth::user()->id)->where('archive', 1)->get()]);
    }

    public function noteUnarchive($id)
    {

        Note::find($id)->update(['archive' => 0]);
        return response()->json(['type' => 'success', 'message' => 'Note Unarchive Success']);
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


        $note_id = Note::findOrFail($id);
        $data = [
            'note' => $note_id,
            'todos' => Note::with('todo')->where('user_id', Auth::user()->id)->find($id)->todo,
        ];
        // dd($data);
        return view('user.pdf', $data);
        return PDF::loadView('user.pdf', $data)->download('print.pdf');
    }



    public function tagNotes($tag)
    {
        $notes = Tag::where('title', $tag)->with('notes')->first()->notes;
        $tags = Note::with('tags')->get();

        return view('user.tagnotes', ['notes' => $notes, 'tags' => $tags]);
    }
}
