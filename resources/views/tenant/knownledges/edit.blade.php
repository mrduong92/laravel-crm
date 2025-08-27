
@extends('adminlte::page')

@section('content')
    <form action="{{ route('users.update', $user) }}" method="post" class="card">
        @method('PUT')
        @csrf
        <div class="card-header">
            <h3 class="card-title">Sửa user {{ $user->id }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 form-label required">Tên <span class="text-danger">*</span></label>
                <div class="col">
                    <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name" value="{{ old('name', $user->name) }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Username <span class="text-danger">*</span></label>
                <div class="col">
                    <input type="text" class="form-control" name="username" aria-describedby="username" placeholder="Enter username" value="{{ old('username', $user->username) }}">
                </div>
            </div>
            @if ($user->id !== Auth::id())
                <div class="mb-3 row">
                    <label class="col-3 form-label required">Password</label>
                    <div class="col">
                        <input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Enter password">
                    </div>
                </div>
            @endif

            <div class="mb-3 row">
                <label class="col-3 form-label required">Email</label>
                <div class="col">
                    <input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Enter email" value="{{ old('email', $user->email) }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label">Phone</label>
                <div class="col">
                    <input type="text" class="form-control" name="phone" aria-describedby="phone" placeholder="Enter phone" value="{{ old('phone', $user->phone) }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 form-label">External ID</label>
                <div class="col">
                    <input type="text" class="form-control" name="external_id" aria-describedby="external_id" placeholder="Enter external ID" value="{{ old('external_id', $user->external_id) }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 form-label">Source</label>
                <div class="col">
                    <select class="form-control" name="source" aria-describedby="source">
                        <option value="normal" {{ old('source', $user->source) == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="zalo_oa" {{ old('source', $user->source) == 'zalo_oa' ? 'selected' : '' }}>Zalo OA</option>
                        <option value="zalo_user" {{ old('source', $user->source) == 'zalo_user' ? 'selected' : '' }}>Zalo User</option>
                        <option value="facebook" {{ old('source', $user->source) == 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="tiktok" {{ old('source', $user->source) == 'tiktok' ? 'selected' : '' }}>TikTok</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label">Status</label>
                <div class="col">
                    <select class="form-control" name="status" aria-describedby="status">
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a class="btn btn-default" href="{{ url()->previous() }}">Back</a>
            <button type="submit" class="btn btn-primary">
                Lưu
            </button>
        </div>
    </form>
@endsection
