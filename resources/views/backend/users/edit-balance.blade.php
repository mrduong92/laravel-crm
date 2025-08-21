
@extends('layouts.backend')

@section('content')
    <form action="{{ route('backend.users.update-balance', $user) }}" method="post" class="card">
        @method('PUT')
        @csrf
        <div class="card-header">
            <h3 class="card-title">Cập nhật số dư user {{ $user->name }} ({{ $user->coins }})</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 col-form-label required">Option</label>
                <div class="col">
                    <select class="form-select" name="option">
                        <option value="plus">Cộng</option>
                        <option value="minus">Trừ</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 col-form-label">Số coins</label>
                <div class="col">
                    <input type="number" class="form-control" name="coins" aria-describedby="coins" placeholder="Enter coins" value="{{ old('coins') }}">
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
