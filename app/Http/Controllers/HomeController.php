<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // Show the change password dashboard dashboard
    public function changePassword()
    {
        return view('auth.change-password');
    }

    // update user password to new password 
    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|confirmed|string|min:8',
        ]);


        //Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        //Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
    // Show Update user Profile  dashboard
    public function updateProfile()
    {
        $user = Auth::user();
        return view('user.profileedit',['user'=>$user]);
    }

    /**
     * update user profile to new user information
     * update user name , email, number , profile images 
     */
    public function updateProfileStore(Request $request)
    {
        $request->validate([
            'image' => 'image',
            'name' =>'required',
            'email' =>"required|email|unique:users,email, $request->id",
            'number' => 'required',
        ]);
      
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        $oldImage = "images/".Auth::user()->image;
        if ($request->image) {
            $imageName = $user->id . time() . '.' . $request->image->getClientOriginalExtension();           
            $request->image->move(public_path('images'), $imageName);
            $user->image = $imageName;
        }
        if ($request->imageRemove == "true") {
            if (file_exists(public_path($oldImage))) {
                @unlink(public_path($oldImage));
            } 
            $user->image = null;
        }
        
        $user->save();

        if ($request->imageRemove == "true" && file_exists(public_path($oldImage))) {
            @unlink(public_path($oldImage));
        }

        return back()->with('success', 'image updated successfully.');
        
    }

    // get all tags list  
    public function getTags(Request $request)
    {
        $tags = Tag::where('title', 'LIKE', ''.$request->tag.'%') ->get();
        return response()->json(['type' => 'success', 'message' => $tags]);
    }
}




