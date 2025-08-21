<a class="btn btn-default" href="{{ route('backend.users.orders', $id) }}">Orders</a><br>
<a class="btn btn-default" href="{{ route('backend.users.transactions', $id) }}">Transactions</a><br>
<a class="btn btn-primary" href="{{ route('backend.users.edit-balance', $id) }}">Balances</a><br>
<a class="btn btn-info" href="{{ route('backend.users.edit', $id) }}">Info</a><br>
<form class="d-inline-block" action="{{ route('backend.users.destroy', $id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?')">
    @method('DELETE')
    @csrf
    <button class="btn btn-danger" type="submit">Delete</button>
</form>
