@extends('layouts.app')

@section('title', 'Veículos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Veículos</h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('vehicles.create') }}" class="btn btn-dark">+ Novo Veículo</a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Placa</th>
                    <th>Marca / Modelo</th>
                    <th>Código FIPE</th>
                    <th>Proprietário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->id }}</td>
                    <td><strong>{{ $vehicle->license_plate }}</strong></td>
                    <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                    <td>{{ $vehicle->fipe_code ?? '-' }}</td>
                    <td>{{ $vehicle->customer_name }}</td>
                    <td>
                        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-outline-secondary">Ver histórico</a>
                        @if(in_array(session('user_role'), ['manager', 'attendant']))
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nenhum veículo cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
