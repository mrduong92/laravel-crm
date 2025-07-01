
@extends('adminlte::page')

@section('content')
    <form action="{{ route('backend.categories.update', $category) }}" method="post">
        @method('PUT')
        @csrf
        <x-adminlte-card title="Sửa category {{ $category->id }}" theme="primary" theme-mode="outline">
            <x-adminlte-input name="name" label="{{ __('backend.label.name') }}" placeholder="Enter name" value="{{ old('name', $category->name) }}" required />
            <x-slot name="footerSlot">
                <a class="btn btn-default" href="{{ route('backend.categories.index') }}">Back</a>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </x-slot>
        </x-adminlte-card>
    </form>
@endsection
