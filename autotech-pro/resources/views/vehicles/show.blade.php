@extends('layouts.app')

@section('title', 'Detalhes do Veículo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Veículo: {{ $vehicle->license_plate }}</h2>
    <div>
        @if(in_array(session('user_role'), ['manager', 'attendant']))
        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
        @endif
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-sm">← Voltar</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light"><strong>Informações do Veículo</strong></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Placa:</strong><br>{{ $vehicle->license_plate }}</div>
            <div class="col-md-3"><strong>Marca:</strong><br>{{ $vehicle->brand ?? '-' }}</div>
            <div class="col-md-3"><strong>Modelo:</strong><br>{{ $vehicle->model ?? '-' }}</div>
            <div class="col-md-3"><strong>Código FIPE:</strong><br>{{ $vehicle->fipe_code ?? '-' }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6"><strong>Proprietário:</strong><br>{{ $vehicle->customer_name }}</div>
            <div class="col-md-6"><strong>E-mail:</strong><br>{{ $vehicle->customer_email }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <strong>Histórico de Ordens de Serviço</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>OS #</th>
                    <th>Atendente</th>
                    <th>Status</th>
                    <th>Abertura</th>
                    <th>Garantia Mão de Obra</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->attendant_name }}</td>
                    <td>
                        @switch($order->status)
                            @case('received') <span class="badge bg-secondary">Recebido</span> @break
                            @case('diagnostic') <span class="badge bg-primary">Diagnóstico</span> @break
                            @case('awaiting_approval') <span class="badge bg-warning text-dark">Aguard. Aprovação</span> @break
                            @case('in_repair') <span class="badge bg-warning text-dark">Em Reparo</span> @break
                            @case('ready') <span class="badge bg-success">Pronto</span> @break
                            @case('delivered') <span class="badge bg-dark">Entregue</span> @break
                        @endswitch
                    </td>
                    <td>{{ date('d/m/Y', strtotime($order->opened_at)) }}</td>
                    <td>
                        @if($order->labor_warranty_expiry)
                            {{ date('d/m/Y', strtotime($order->labor_warranty_expiry)) }}
                            
                            @if(strtotime($order->labor_warranty_expiry) < time())
                                <span class="badge bg-secondary">Vencida</span>
                            @else
                                <span class="badge bg-success">Válida</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Ver OS</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">Nenhuma ordem de serviço para este veículo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
