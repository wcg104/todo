<?php

namespace App\Http\Controllers;

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
    public function changePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|confirmed|string|min:8',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function updateProfile()
    {
        $user = Auth::user();
        // dd($user);
        return view('user.profileedit',['user'=>$user]);
    }

    public function updateProfileStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'image' => 'image',
            'name' =>'required',
            'email' =>'required|email',
            'number' => 'required',
        ]);
      
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        if ($request->image) {
            $imageName = $user->id . '.' . $request->image->getClientOriginalExtension();           
            $image_path = "image/".$imageName;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $request->image->move(public_path('images'), $imageName);
            $user->image = $imageName;
        }

        $user->save();


        // Auth::user()->update(['image' => $imageName]);

        return back()->with('success', 'image updated successfully.');
        // return redirect('/')->with('success', 'Note Updated successfully!');
        
    }
}




