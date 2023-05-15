<?php

namespace App\Http\Controllers;

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

        // get all user list in admin dash
        if ($request->ajax()) {
            $user = User::where('role','user')->get();
            // pass all user data to DataTables and add action button edit,delete,block,unblock 
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-action="'.route('users.edit', $row->id ).'" class="editUser" title="Edit"> <i data-id="{{ $user->id }}" class="fas fa-pencil-alt mr-3 text-secondary editProduct" aria-hidden="true"></i></a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="' . $row->id . '" data-action="'.route('user.status',[$row->id,1]  ).'" class="unblockUser" title="active"> <i class="fas fa-check text-success me-3 mr-3"></i></a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="' . $row->id . '" data-action="'.route('user.status',[$row->id,0]  ).'" class="blockUser" title="ban"> <i class="fa fa-ban mr-3 text-danger" aria-hidden="true"></i>';
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" class="deleteUser"  data-id="' . $row->id . '" data-action="'.route('users.destroy', $row->id ).'" title="Delete"> <i class="fas fa-trash-alt text-danger mr-3" aria-hidden="true"></i></a>';
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
     * Store a newly created User data and updated user data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => "required|email|unique:users,email,$request->user_id",
            'number' => 'required|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',

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
            $user->newPassword = $request->password;
            // send mail with user email password and login url
            $user->notify(new adduser("New User Created "));
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
        return response()->json(User::find($id));
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
     * Remove User account With all user data.
     * Soft Delete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['type' => 'success', 'message' => 'User Data Deleted successfully!']);
    }
}
