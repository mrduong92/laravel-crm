
@extends('adminlte::page')

@section('content')
    <form action="{{ route('tenants.update', $tenant) }}" method="post" class="card">
        @method('PUT')
        @csrf
        <div class="card-header">
            <h3 class="card-title">Xem tenant {{ $tenant->id }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 form-label required">ID</label>
                <div class="col">
                    <input type="text" class="form-control" name="id" aria-describedby="id" placeholder="Enter ID" value="{{ old('id', $tenant->id) }}" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 form-label required">Tên</label>
                <div class="col">
                    <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name" value="{{ old('name', $name) }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 form-label required">Domain</label>
                <div class="col">
                    <input type="text" class="form-control" name="domain" aria-describedby="domain" placeholder="Enter Domain" value="{{ old('domain', $domain) }}">
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
