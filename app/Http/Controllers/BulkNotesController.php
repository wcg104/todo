<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Rules\Csv;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BulkNotesController extends Controller
{
    public function index()
    {
        return view('user.bulk');
    }

    public function dataStore(Request $request)
    {
        // dd($request->all());
        $rules = [
            '0' => 'required|string',
            '1' => 'required|regex:/^\S*$/u',
            '2' => 'numeric|min:1|max:3',
            '3' => 'string',
            '4' => 'required|string',
            '5' => 'url',
        ];

        $file = $request->file('data');
        $csvData = array_map('str_getcsv', file($file));
        $validator = Validator::make([], []);
        $validRows = [];
        $errors = [];

        foreach ($csvData as $rowIndex => $row) {
            if (!$rowIndex) {
                if (!(count($row)==6)) {
                    // return back()->with('error', 'invalid format ');
                    return response()->json(['type' => 'error', 'message' => 'invalid file format']);

                }
                $rowValidator = Validator::make($row, [
                    '0' => 'required',
                    '1' => 'required',
                    '2' => 'required',
                    '3' => 'required',
                    '4' => 'required',
                    '5' => 'required',
                ]);
                
            } else {
                $rowValidator = Validator::make($row, $rules);
            }
            if ($rowValidator->fails()) {
                $errors[$rowIndex] = $rowValidator->errors();
            } else {
                $validRows[] = $row;
                // dd($validRows);
                if ($rowIndex && count($row) > 1 && count($validRows)>0) {
                    if (!Note::where('uid', $row[1])->exists()) {
                        // create new note
                        $notes = new Note;
                        $notes->title = $row[0];
                        $notes->user_id = Auth::user()->id;
                        $notes->priority_level = $row[2];
                        $notes->uid = $row[1];
                        $notes->save();
                        // tag store
                        if ($row[3]) {
                            $tags = explode(',', $row[3]);
                            foreach ($tags as $tag) {
                                $tag = Tag::firstOrCreate(['title' => trim($tag)]);
                                $notes->tags()->attach($tag->id);
                            }
                        }
                    }
                    $todos = new Todo;
                    $todos->note_id = Note::where('uid', $row[1])->first()->id;
                    $todos->user_id = Auth::user()->id;
                    $todos->index_no = Todo::max('index_no') + 1;
                    $todos->title = $row[4];
                    // file move 
                    $image_name = null;
                    if ($row[5]) {
                        $image = @file_get_contents("$row[5]");
                        if ($image) {
                            Log::info(getimagesize($row[5]));
                            $b64image = base64_encode($image);
                            $image = base64_decode($b64image);
                            $image_name = time().".png";
                            Storage::disk('public')->put('todoImage/'.$image_name,$image);
                            
                        }
                    }
                    $todos->file =  $image_name;
                    $todos->save();
                }
             
            }
        }
        // dd( $validRows);
        $TotalRows = count($csvData);
        $ValidRows = count($validRows);
        $InvalidRows = count($errors);
        // dd($errors);
        return response()->json(['type' => 'success', 'message' => 'file updated successfully','TotalRows'=>$TotalRows,'ValidRows'=>$ValidRows,'InvalidRows'=>$InvalidRows]);

        // return view('user.bulkreport',['TotalRows'=>$TotalRows,'ValidRows'=>$ValidRows,'InvalidRows'=>$InvalidRows])->with('success', 'file updated successfully.');

    }
}
