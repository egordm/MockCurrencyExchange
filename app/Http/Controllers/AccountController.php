<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('account');
    }

    public function update(AccountUpdateRequest $request)
    {
	    $user = Auth::user();
	    if(!empty($request->get('name'))) $user->name = $request->get('name');
	    if(!empty($request->get('new_password'))) $user->password = $request->get('new-password');
	    $user->save();

	    return redirect()->back()->with("success", "Account has been updated succesfully");
    }

}
