
@extends('adminlte::page')

@section('content')
    @if ($type === 'file')
        <x-livewire-filemanager />
    @else
        <form action="{{ route('knowledges.store') }}" method="post" class="card">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Thêm văn bản</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-3 form-label required">Title <span class="text-danger">*</span></label>
                    <div class="col">
                        <input type="text" class="form-control" name="title" aria-describedby="title" placeholder="Enter title">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 form-label required">Content <span class="text-danger">*</span></label>
                    <div class="col">
                        <textarea class="form-control" name="content" rows="10" aria-describedby="content" placeholder="Enter content"></textarea>
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
    @endif
@endsection
