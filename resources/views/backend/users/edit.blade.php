
@extends('adminlte::page')

@section('content')
    <form action="{{ route('users.update', $user) }}" method="post" class="card">
        @method('PUT')
        @csrf
        <div class="card-header">
            <h3 class="card-title">Sửa user {{ $user->username }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 form-label required">Tên</label>
                <div class="col">
                    <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name" value="{{ old('name', $user->name) }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Email</label>
                <div class="col">
                    <input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Enter email" value="{{ old('email', $user->email) }}">
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
        </div>
        <div class="card-footer text-end">
            <a class="btn btn-default" href="{{ url()->previous() }}">Back</a>
            <button type="submit" class="btn btn-primary">
                Lưu
            </button>
        </div>
    </form>
@endsection
