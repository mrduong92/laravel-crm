@extends('layouts.backend')

@section('content')
    {!! Form::model($post, [
        'class' => 'form-horizontal',
        'method' => 'PUT',
        'route' => ['backend.posts.update', $post],
    ]) !!}
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('backend.text.post.edit') }}</h3>
                </div>
                <div class="card-body p-0">

                    <div class="card-body">
                        @include('backend.components.input', [
                            'name' => 'title'
                        ])
                        @include('backend.components.text-area', [
                            'name' => 'excerpt'
                        ])
                        @include('backend.components.editor', [
                            'name' => 'content',
                        ])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('backend.text.detail') }}</h3>
                </div>
                <div class="card-body p-0">
                    <div class="card-body">
                        @include('backend.components.select-box', [
                            'name' => 'category_id',
                            'items' => $categories,
                        ])
                        @include('backend.components.file-manager', [
                            'name' => 'thumbnail',
                            'value' => $post->thumbnail,
                        ])
                        @include('backend.components.tag-it', [
                            'data' => $tags,
                            'name' => 'tags',
                        ])
                        <div class="form-group">
                            {!! Form::label('status', __('backend.label.status')) !!}
                            <select class="form-control" id="status" name="status">
                                @foreach(config('common.statuses') as $key => $value)
                                    <option value="{{ $value }}" @if($value == $post->status) selected @endif>{{ __("backend.statuses.$key") }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @include('backend.components.submit', [
                        'route' => route('backend.posts.index'),
                    ])
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
