
@extends('adminlte::page')

@section('content')
    <form action="{{ route('users.store') }}" method="post" class="card">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Thêm user</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 form-label required">Tên</label>
                <div class="col">
                    <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Email</label>
                <div class="col">
                    <input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Enter email">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Password</label>
                <div class="col">
                    <input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Enter password">
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
