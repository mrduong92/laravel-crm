<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('owner');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/owner/dashboard';

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('owner.login');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'tenant_id';
    }

    public function dashboard()
    {
        return view('owner.dashboard');
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
