@if (session('success'))
    <x-adminlte-alert theme="success" icon="" dismissable>
        <i class="far fa-check-circle pr-2"></i>{{ session('success') }}
    </x-adminlte-alert>
@elseif (session('message'))
    <x-adminlte-alert theme="info" icon="" dismissable>
        <i class="fas fa-exclamation-triangle pr-2"></i>{{ session('message') }}
    </x-adminlte-alert>
@elseif (session('error'))
    <x-adminlte-alert theme="danger" icon="" dismissable>
        <i class="fas fa-exclamation-triangle pr-2"></i>{{ session('error') }}
    </x-adminlte-alert>
@endif
@if ($errors->any())
    <x-adminlte-alert theme="danger" icon="" dismissable>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-triangle pr-2"></i>{{ $error }}</li>
            @endforeach
        </ul>
    </x-adminlte-alert>
@endif
