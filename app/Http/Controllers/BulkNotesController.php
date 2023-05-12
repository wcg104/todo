<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BulkNotesController extends Controller
{
    // upload csv file home page
    public function index()
    {
        return view('user.bulk');
    }

    /**
     * Take csv file as a input and insert record in database.
     * User can upload one csv file to given format.
     * if user not follow given format the show error "invalided format"
     * if format is right then data upload to database and return total row , uploaded row and invalided row.
     * file formate
     * 
     * col A: Note_title (type->string) Required
     * col B: Note_uid (type->string|space not allow|unica foe all different notes) Required
     * col C: priority_level (type->number|min-1,max-3 | default 3) 1 is high , 2 is medium , 3 is low
     * col D: Tag (type->string) comma sprat value Optional
     * col E: Todo_Title (type->string) required
     * col F: File (type->url) Optional
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataStore(Request $request)
    {
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
                if (!(count($row) == 6)) {

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
                if ($rowIndex && count($row) > 1 && count($validRows) > 0) {
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
                    } else {
                        if ((Note::where('uid', $row[1])->first()->user_id) != Auth::user()->id) {
                            return response()->json(['type' => 'error', 'message' => 'try diffrent uid']);
                        }
                    }
                    // create new todo 
                    $todos = new Todo;
                    $todos->note_id = Note::where('uid', $row[1])->first()->id;
                    $todos->user_id = Auth::user()->id;
                    $todos->index_no = Todo::max('index_no') + 1;
                    $todos->title = $row[4];
                    // file move 
                    $image_name = null;
                    if ($row[5]) {
                        // if file is exits then download and move to todoImage Folder
                        $image = @file_get_contents("$row[5]");
                        if ($image) {
                            Log::info(getimagesize($row[5]));
                            $b64image = base64_encode($image);
                            $image = base64_decode($b64image);
                            $image_name = time() . ".png";
                            Storage::disk('public')->put('todoImage/' . $image_name, $image);
                        }
                    }
                    $todos->file =  $image_name;
                    $todos->save();
                }
            }
        }
        $TotalRows = count($csvData);
        $ValidRows = count($validRows);
        $InvalidRows = count($errors);
        return response()->json(['type' => 'success', 'message' => 'file updated successfully', 'TotalRows' => $TotalRows, 'ValidRows' => $ValidRows, 'InvalidRows' => $InvalidRows]);
    }
}
