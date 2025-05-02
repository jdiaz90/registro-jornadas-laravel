@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registro de Jornadas</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form action="{{ route('work_logs.check_in') }}" method="POST">
        @csrf
        <button type="submit">Registrar entrada</button>
    </form>

    <form action="{{ route('work_logs.check_out') }}" method="POST" style="margin-top: 10px;">
        @csrf
        <button type="submit">Registrar salida</button>
    </form>

    <h2 style="margin-top: 20px;">Mis registros</h2>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Hash</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->check_in }}</td>
                <td>{{ $log->check_out ?? 'En curso' }}</td>
                <td>{{ $log->hash ?? 'Pendiente' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
