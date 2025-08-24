
@extends('adminlte::page')

@section('content')
    <form action="{{ route('tenants.store') }}" method="post" class="card">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Thêm tenant</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 form-label required">ID</label>
                <div class="col">
                    <input type="text" class="form-control" name="id" aria-describedby="id" placeholder="Enter ID">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 form-label required">Domain</label>
                <div class="col">
                    <input type="text" class="form-control" name="domain" aria-describedby="domain" placeholder="Enter Domain">
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
