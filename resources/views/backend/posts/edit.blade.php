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
    <form action="{{ route('backend.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-9">
                <x-adminlte-card theme="info" title="{{ __('backend.post.edit') }}">
                    <x-adminlte-input name="title" label="{{ __('backend.label.title') }}" value="{{ old('title', $post->title) }}" required />
                    <x-adminlte-textarea name="excerpt" label="{{ __('backend.label.excerpt') }}" rows=3>
                        {{ old('excerpt', $post->excerpt) }}
                    </x-adminlte-textarea>
                    <x-adminlte-text-editor name="content" label="{{ __('backend.label.content') }}" :config="$config" enable-old-support>
                        {{ old('content', $post->content) }}
                    </x-adminlte-text-editor>
                </x-adminlte-card>
            </div>
            <div class="col-md-3">
                <x-adminlte-card theme="info" title="{{ __('backend.label.detail') }}">
                    <x-adminlte-select name="category_id" label="{{ __('backend.label.category') }}">
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" @if($id == old('category_id', $post->category_id)) selected @endif>{{ $name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input-file-krajee name="thumbnail" label="{{ __('backend.label.thumbnail') }}" preset-mode="avatar"/>
                    <div class="form-group" id="tag-it" data-tag="{{ $tags ?? '' }}">
                        <x-adminlte-input
                            name="tags"
                            label="{{ __('backend.label.tags') }}"
                            value="{{ old('tags', $tags ?? '') }}"
                            id="singleFieldTags2"
                            class="form-control"
                        />
                    </div>

                    <x-adminlte-select name="status" label="{{ __('backend.label.status') }}">
                        @foreach(config('common.statuses') as $key => $value)
                            <option value="{{ $value }}" @if($value == old('status', $post->status)) selected @endif>{{ __("backend.statuses.$key") }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-button type="submit" label="{{ __('backend.button.save') }}" theme="primary" class="btn-block mt-3"/>
                    <a href="{{ route('backend.posts.index') }}" class="btn btn-secondary btn-block">{{ __('backend.button.cancel') }}</a>
                </x-adminlte-card>
            </div>
        </div>
    </form>
@endsection

@section('adminlte_js')
    @parent
    <script>
        $(document).ready(function() {
            const tag = $('#tag-it').data('tag');
            const sampleTags = tag.split(',');

            $('#singleFieldTags2').tagit({
                availableTags: sampleTags || [],
                allowSpaces: true
            });
        });
    </script>
@endsection
