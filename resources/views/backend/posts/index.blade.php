
@extends('adminlte::page')

@php
$heads = [
    'ID',
    'Title',
    ['label' => 'Created At'],
    ['label' => 'Updated At'],
    ['label' => 'Actions', 'no-export' => true],
];

$config = [
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, ['orderable' => false]],
];
@endphp

@section('content')
<div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ __('backend.post.title') }}</h3>
            <div class="card-tools">
                <a id="add-element" class="btn btn-warning btn-sm" href="{{ route('backend.posts.create') }}">
                    <i class="fas fa-plus"></i> {{ __('backend.button.add') }}
                </a>
            </div>
        </div>
        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" striped hoverable with-buttons>
            @foreach($posts as $post)
                <tr>
                <td><span class="text-secondary">{{ $post->id }}</span></td>
                <td><a href="{{ route('backend.posts.edit', $post) }}" class="text-reset" tabindex="-1">{{ $post->title }}</a></td>
                <td>
                    {{ $post->created_at }}
                </td>
                <td>
                    {{ $post->updated_at }}
                </td>
                <td class="text-end">
                    <a class="btn btn-xs btn-default text-primary mx-1 shadow" href="{{ route('backend.posts.edit', $post) }}">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>
                    <form class="d-inline-block" action="{{ route('backend.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?')">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-xs btn-default text-teal mx-1 shadow" type="submit">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </form>
                </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
@endsection
