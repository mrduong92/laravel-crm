
@extends('layouts.backend')

@section('content')
    <form action="{{ route('backend.users.change-password') }}" method="post" class="card">
        @method('PUT')
        @csrf
        <div class="card-header">
            <h3 class="card-title">Sửa password {{ auth()->user()->email }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 form-label required">Password</label>
                <div class="col">
                    <input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Enter password">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Password confirmation</label>
                <div class="col">
                    <input type="password" class="form-control" name="password_confirmation" aria-describedby="password_confirmation" placeholder="Enter password confirmation">
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
