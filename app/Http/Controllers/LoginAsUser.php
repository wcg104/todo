<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginAsUser extends Controller
{
    public function loginAs()
    {
        //get user id
        $id = request('user_id');

        //if session exists remove it and login as admin
        if (session()->get('hasClonedUser') == 1) {
            auth()->loginUsingId(session()->remove('hasClonedUser'));
            session()->remove('hasClonedUser');
            return redirect()->route('users.index');
        }

        //admin can login user account
        if (auth()->user()->id == 1) {
            session()->put('hasClonedUser', auth()->user()->id);
            auth()->loginUsingId($id);
            return redirect()->back();
        }
    }
}
