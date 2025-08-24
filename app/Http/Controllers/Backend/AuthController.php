<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    public function displayChangePasswordForm()
    {
        return view('backend.users.password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        auth()->user()->password = $request->password;
        auth()->user()->save();

        $request->session()->flash('success', __('backend.updated', ['name' => 'user']));

        return redirect()->route('users.password');
    }
}
