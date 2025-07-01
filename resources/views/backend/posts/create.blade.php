@extends('adminlte::page')

@section('plugins.summernote', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.KrajeeFileinput', true)

@php
$config = [
    "height" => "200",
    "toolbar" => [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']],
    ],
]
@endphp

@section('content')
<form method="POST" action="{{ route('backend.posts.store') }}">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-9">
            <x-adminlte-card title="{{ __('backend.post.create') }}" theme="info" theme-mode="outline">
                <x-adminlte-input name="title" label="{{ __('backend.label.title') }}" placeholder="{{ __('backend.label.title') }}" value="{{ old('title') }}" />
                <x-adminlte-textarea name="excerpt" label="{{ __('backend.label.excerpt') }}" rows=3>
                    {{ old('excerpt') }}
                </x-adminlte-textarea>
                <x-adminlte-text-editor name="content" label="{{ __('backend.label.content') }}" enable-old-support :config="$config">
                    {{ old('content') }}
                </x-adminlte-text-editor>
            </x-adminlte-card>
        </div>
        <div class="col-md-3">
            <x-adminlte-card title="{{ __('backend.label.detail') }}" theme="info" theme-mode="outline">
                <x-adminlte-select name="category_id" label="{{ __('backend.label.category') }}">
                    <option value="">{{ __('backend.label.category') }}</option>
                    @foreach($categories as $id => $cat)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-input-file-krajee name="thumbnail" label="{{ __('backend.label.thumbnail') }}" preset-mode="avatar"/>
                <x-adminlte-input name="tags" label="{{ __('backend.label.tags') }}" value="{{ old('tags') }}" placeholder="{{ __('backend.label.tags') }}" />
                <x-adminlte-select name="status" label="{{ __('backend.label.status') }}">
                    @foreach(config('common.statuses') as $key => $value)
                        <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>{{ __("backend.statuses.$key") }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-button label="{{ __('backend.button.save') }}" type="submit" theme="primary" class="btn-block mt-3" />
                <a href="{{ route('backend.posts.index') }}" class="btn btn-secondary btn-block">{{ __('backend.button.cancel') }}</a>
            </x-adminlte-card>
        </div>
    </div>
</form>
@endsection
