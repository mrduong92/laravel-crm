<?php

namespace App\Http\Controllers\Backend;

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
        return $dataTable->render('backend.users.index');
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
        ]);

        User::create($data);
        $request->session()->flash('success', __('backend.created', ['name' => 'user']));

        return redirect(route('users.index'));
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update($id, UserRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
        ]);

        if (!empty($data['password'])) {
            unset($data['password']);
        }

        User::whereId($id)->update($data);
        $request->session()->flash('success', __('backend.updated', ['name' => 'user']));

        return redirect(route('users.index'));
    }

    public function destroy(User $user, Request $request)
    {
        if ($user->id == auth()->user()->id) {
            abort(403);
        }

        $user->delete();
        $request->session()->flash('success', __('backend.deleted', ['name' => 'user']));

        return redirect(route('users.index'));
    }
}
