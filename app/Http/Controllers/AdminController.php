<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Todo;
use App\Models\User;
use App\Notifications\adduser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    public function index(Request $request)
    {
        // return view('admin.userlists', ['userlist' => User::simplePaginate(15)]);


        if ($request->ajax()) {
            $user = User::where('role','user')->get();
            
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" class="editUser" title="Edit"> <i data-id="{{ $user->id }}" class="fas fa-pencil-alt mr-3 text-secondary editProduct" aria-hidden="true"></i></a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="' . $row->id . '" class="unblockUser" title="active"> <i class="fas fa-check text-success me-3 mr-3"></i></a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="' . $row->id . '" class="blockUser" title="ban"> <i class="fa fa-ban mr-3 text-danger" aria-hidden="true"></i>';
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" class="deleteUser"  data-id="' . $row->id . '" title="Delete"> <i class="fas fa-trash-alt text-danger mr-3" aria-hidden="true"></i></a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" class="loginAs"  data-id="' . $row->id . '" title="Login as"> <i class="fa fa-sign-in-alt text-secondary mr-3" aria-hidden="true"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.newuserlist');
        // return view('admin.newuserlist', ['userlist' => User::simplePaginate(15)]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("heat");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => "required|email|unique:users,email,$request->user_id",
            'number' => 'required',

        ]);
        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()]);
            
        }

        if ($request->user_id) {
            User::find($request->user_id)->update(['name' => $request->name, 'email' => $request->email, 'number' => $request->number]);

            return response()->json(['type' => 'success', 'message' => ' User Data Updated successfully!']);
        } else {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'password' => Hash::make($request->password),
                'email_verified_at'=>now()
            ]);
            $user->newpass = $request->password;
            // send mail
            // $user->notify(new adduser("New User Created "));

            return response()->json(['type' => 'success', 'message' => 'New User Created successfully!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::find($id);
        return response()->json($users);
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
        dd("update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::find($id)->delete();
        Note::where('user_id', $id)->delete();
        Todo::where('user_id', $id)->delete();

        return response()->json(['type' => 'success', 'message' => 'User Data Deleted successfully!']);
    }
}
