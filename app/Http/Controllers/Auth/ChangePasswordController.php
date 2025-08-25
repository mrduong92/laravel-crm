<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    public function displayChangePasswordForm()
    {
        return view('tenant.users.password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->guard()->user()->password = $request->password;
        $this->guard()->user()->save();

        $request->session()->flash('success', __('tenant.updated', ['name' => 'user']));

        return redirect()->route('users.password');
    }
}
