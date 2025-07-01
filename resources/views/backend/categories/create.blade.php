
@extends('adminlte::page')

@section('content')
    <form action="{{ route('backend.categories.store') }}" method="post" class="card">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Thêm category</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label required">Tên</label>
                <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name">
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
