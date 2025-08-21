
@extends('layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Danh sách transaction</h3>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                    <th class="w-1">ID</th>
                    <th>User</th>
                    <th>Số tài khoản</th>
                    <th>Gateway</th>
                    <th>Số tiền nạp</th>
                    <th>Code</th>
                    <th>Nội dung</th>
                    <th>Mã tham chiếu</th>
                    <th>Số coin</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                        <td><span class="text-secondary">{{ $transaction->id }}</span></td>
                        <td><a href="{{ route('backend.users.edit', $transaction->user) }}" class="text-reset" tabindex="-1">{{ $transaction->user->name ?? '' }}</a></td>
                        <td>{{ $transaction->account_number }}</td>
                        <td>{{ $transaction->gateway }}</td>
                        <td>{{ number_format($transaction->amount_in) }}</td>
                        <td>{{ $transaction->code }}</td>
                        <td>{{ $transaction->content }}</td>
                        <td>{{ $transaction->reference_number }}</td>
                        <td>{{ $transaction->coins }}</td>
                        <td>
                            {{ $transaction->created_at }}
                        </td>
                        <td>
                            {{ $transaction->updated_at }}
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $transactions->links() }}
    </div>

@endsection
