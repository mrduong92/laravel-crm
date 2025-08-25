
@extends('adminlte::page')

@section('content')
    <form action="{{ route('users.store') }}" method="post" class="card">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Thêm {{ $targetRole }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 form-label required">Tên <span class="text-danger">*</span></label>
                <div class="col">
                    <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Username <span class="text-danger">*</span></label>
                <div class="col">
                    <input type="text" class="form-control" name="username" aria-describedby="username" placeholder="Enter username">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Password <span class="text-danger">*</span></label>
                <div class="col">
                    <input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Enter password">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label required">Email</label>
                <div class="col">
                    <input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Enter email">
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label">Phone</label>
                <div class="col">
                    <input type="text" class="form-control" name="phone" aria-describedby="phone" placeholder="Enter phone">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 form-label">External ID</label>
                <div class="col">
                    <input type="text" class="form-control" name="external_id" aria-describedby="external_id" placeholder="Enter external ID">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 form-label">Source</label>
                <div class="col">
                    <select class="form-control" name="source" aria-describedby="source">
                        <option value="normal">Normal</option>
                        <option value="zalo_oa">Zalo OA</option>
                        <option value="zalo_user">Zalo User</option>
                        <option value="facebook">Facebook</option>
                        <option value="tiktok">TikTok</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-3 form-label">Status</label>
                <div class="col">
                    <select class="form-control" name="status" aria-describedby="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
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
