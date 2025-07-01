
@extends('adminlte::page')

@section('content')
    <x-adminlte-card title="Thêm category" theme="primary" icon="fas fa-plus">
        <form action="{{ route('backend.categories.store') }}" method="POST">
            @csrf
            <x-adminlte-input name="name" label="{{ __('backend.label.name') }}" placeholder="Enter name" required />
            <x-slot name="footerSlot">
                <a class="btn btn-default" href="{{ route('backend.categories.index') }}">{{ __('backend.button.cancel') }}</a>
                <x-adminlte-button type="submit" label="{{ __('backend.button.save') }}" theme="primary" />
            </x-slot>
        </form>
    </x-adminlte-card>
@endsection
