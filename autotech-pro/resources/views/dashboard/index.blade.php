@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard</h2>
    <small class="text-muted">Bem-vindo, {{ session('user_name') }}</small>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5">{{ $totalOrders->total }}</h1>
                <p class="text-muted mb-0">Total de OS</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5 text-warning">{{ $ordersAwaitingApproval->total }}</h1>
                <p class="text-muted mb-0">Aguardando Aprovação</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5 text-primary">{{ $ordersInRepair->total }}</h1>
                <p class="text-muted mb-0">Em Reparo</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5 text-success">{{ $ordersReady->total }}</h1>
                <p class="text-muted mb-0">Prontos para Entrega</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h2>{{ $totalCustomers->total }}</h2>
                <p class="text-muted mb-0">Clientes Cadastrados</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h2>{{ $totalVehicles->total }}</h2>
                <p class="text-muted mb-0">Veículos Cadastrados</p>
            </div>
        </div>
    </div>
</div>

<div class="row">

    
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Últimas Ordens de Serviço</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>OS #</th>
                            <th>Veículo</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->license_plate }} - {{ $order->brand }} {{ $order->model }}</td>
                            <td>{{ $order->customer_name }}</td>
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
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Nenhuma ordem de serviço cadastrada ainda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-dark">Ver todas as OS</a>
            </div>
        </div>
    </div>

    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <strong><img src="/icons/alert.png" alt="Atenção" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Estoque Baixo</strong>
                <small class="text-muted">(menos de 5 unidades)</small>
            </div>
            <div class="card-body p-0">
                @forelse($lowStockParts as $part)
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                    <span class="small">{{ $part->name }}</span>
                    <span class="badge bg-danger">{{ $part->stock_quantity }} un.</span>
                </div>
                @empty
                <div class="p-3 text-center text-muted">
                    <small>Estoque OK - Nenhum item crítico.</small>
                </div>
                @endforelse
            </div>
            @if(count($lowStockParts) > 0)
            <div class="card-footer bg-white">
                <a href="{{ route('parts.index') }}" class="btn btn-sm btn-outline-danger">Ver estoque</a>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
