<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AccountController extends Controller
{
    public function overview()
    {
        return view('/account');
    }

    public function postChangeName(request $request)
    {

        if(strcmp(Auth::user()->name, $request->get('new-name')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Name cannot be same as your current password. Please choose a different name.");
        }

        //Change Password
        $user = Auth::user();
        $user->Name = $request->get('new-name');
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

    }
}
