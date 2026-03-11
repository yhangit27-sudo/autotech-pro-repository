@extends('layouts.app')

@section('title', 'Ordens de Serviço')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Ordens de Serviço</h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('orders.create') }}" class="btn btn-dark">+ Abrir Nova OS</a>
    @endif
</div>

<div class="mb-3">
    <small class="text-muted">Filtrar por status:</small>
    <a href="{{ route('orders.index') }}" class="badge bg-secondary text-decoration-none ms-1">Todos</a>
    <a href="{{ route('orders.index') }}?status=received" class="badge bg-secondary text-decoration-none ms-1">Recebidos</a>
    <a href="{{ route('orders.index') }}?status=diagnostic" class="badge bg-primary text-decoration-none ms-1">Diagnóstico</a>
    <a href="{{ route('orders.index') }}?status=awaiting_approval" class="badge bg-warning text-dark text-decoration-none ms-1">Aguard. Aprovação</a>
    <a href="{{ route('orders.index') }}?status=in_repair" class="badge bg-warning text-dark text-decoration-none ms-1">Em Reparo</a>
    <a href="{{ route('orders.index') }}?status=ready" class="badge bg-success text-decoration-none ms-1">Prontos</a>
    <a href="{{ route('orders.index') }}?status=delivered" class="badge bg-dark text-decoration-none ms-1">Entregues</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>OS #</th>
                    <th>Veículo</th>
                    <th>Cliente</th>
                    <th>Atendente</th>
                    <th>Status</th>
                    <th>Abertura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->license_plate }}<br><small class="text-muted">{{ $order->brand }} {{ $order->model }}</small></td>
                    <td>{{ $order->customer_name }}</td>
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
                    <td>{{ date('d/m/Y H:i', strtotime($order->opened_at)) }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Nenhuma ordem de serviço encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
