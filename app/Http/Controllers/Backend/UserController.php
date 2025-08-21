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
        $referers = User::whereRole('admin')->get();

        return view('backend.users.create', compact('referers'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'role',
            'referer_id',
            'coins',
        ]);

        $data['user_id'] = time();
        $data['referer_id'] = $data['referer_id'] ?: null;
        $data['refer_code'] = Str::random(10);

        User::create($data);
        $request->session()->flash('success', __('messages.created', ['name' => 'user']));

        return redirect(route('backend.users.index'));
    }

    public function edit(User $user)
    {
        $referers = User::whereNot('id', $user->id)->whereRole('admin')->get();

        return view('backend.users.edit', compact('user', 'referers'));
    }

    public function update($id, UserRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
            'role',
            'referer_id',
        ]);

        $data['referer_id'] = $data['referer_id'] ?: null;

        if (!empty($data['password'])) {
            unset($data['password']);
        }

        User::whereId($id)->update($data);
        $request->session()->flash('success', __('messages.updated', ['name' => 'user']));

        return redirect(route('backend.users.index'));
    }

    public function destroy(User $user, Request $request)
    {
        if ($user->role == config('common.super_role')) {
            abort(403);
        }

        $user->delete();
        $request->session()->flash('success', __('messages.deleted', ['name' => 'user']));

        return redirect(route('backend.users.index'));
    }

    public function displayChangePasswordForm()
    {
        return view('backend.users.password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        Auth()->user()->password = $request->password;
        Auth()->user()->save();

        $request->session()->flash('success', __('messages.updated', ['name' => 'user']));

        return redirect()->route('backend.users.index');
    }

    public function orders(User $user, Request $request)
    {
        $orders = $user->orders()->paginate(config('common.per_page'));

        return view('backend.orders.index', compact('orders'));
    }

    public function transactions(User $user, Request $request)
    {
        $transactions = $user->transactions()->paginate(config('common.per_page'));

        return view('backend.transactions.index', compact('transactions'));
    }

    public function editBalance(User $user)
    {
        return view('backend.users.edit-balance', compact('user'));
    }

    public function updateBalance(User $user, UpdateBalanceRequest $request)
    {
        $data = $request->only([
            'option',
            'coins',
        ]);

        $coins = $user->coins ?? 0;

        if ($data['option'] == 'plus') {
            $coins += $data['coins'] ?? 0;
        } else {
            $coins -= $data['coins'] ?? 0;
        }

        $user->coins = $coins;
        $user->save();
        $request->session()->flash('success', __('messages.updated', ['name' => 'user']));

        return redirect(route('backend.users.index'));
    }
}
