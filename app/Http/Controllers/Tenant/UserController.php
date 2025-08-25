<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateBalanceRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use App\DataTables\UsersDataTable;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('tenant.users.index');
    }

    public function create()
    {
        return view('tenant.users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->only([
            'name',
            'username',
            'email',
            'phone',
            'password',
            'external_id',
            'source',
            'role',
            'status',
        ]);

        User::create($data);
        $request->session()->flash('success', __('tenant.created', ['name' => 'user']));

        return redirect(route('users.index'));
    }

    public function edit(User $user)
    {
        return view('tenant.users.edit', compact('user'));
    }

    public function update($id, UserRequest $request)
    {
        $data = $request->only([
            'name',
            'username',
            'email',
            'phone',
            'password',
            'external_id',
            'source',
            'role',
            'status',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        User::whereId($id)->update($data);
        $request->session()->flash('success', __('tenant.updated', ['name' => 'user']));

        return redirect(route('users.index'));
    }

    public function destroy(User $user, Request $request)
    {
        $user->delete();
        $request->session()->flash('success', __('tenant.deleted', ['name' => 'user']));

        return redirect(route('users.index'));
    }
}
