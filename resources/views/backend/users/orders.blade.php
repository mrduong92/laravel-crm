
@extends('layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Danh sách order</h3>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                    <th class="w-1">ID</th>
                    <th>User</th>
                    <th>App</th>
                    <th>License</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                        <td><span class="text-secondary">{{ $order->id }}</span></td>
                        <td><a href="{{ route('backend.users.edit', $order->user) }}" class="text-reset" tabindex="-1">{{ $order->user->name ?? '' }}</a></td>
                        <td><a href="{{ route('backend.apps.edit', $order->app) }}" class="text-reset" tabindex="-1">{{ $order->app->name ?? '' }}</a></td>
                        <td>{{ $order->license }}</td>
                        <td>
                            {{ $order->created_at }}
                        </td>
                        <td>
                            {{ $order->updated_at }}
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>

@endsection
