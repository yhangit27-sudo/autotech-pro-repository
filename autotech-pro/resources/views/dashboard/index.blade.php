@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Estilos específicos do Dashboard para o Tema Escuro */
    .dashboard-card {
        background-color: var(--preto-secundario);
        border-color: #2a2a2a;
        color: var(--branco);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.3) !important;
    }
    .card-header, .card-footer {
        background-color: transparent !important;
        border-color: #2a2a2a !important;
    }
    /* Deixando a tabela perfeitamente integrada ao fundo escuro */
    .table-dark {
        --bs-table-bg: transparent;
        --bs-table-color: var(--branco);
        --bs-table-border-color: #2a2a2a;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
        --bs-table-hover-color: var(--branco);
    }
    /* Customizando o destaque para a cor principal da marca */
    .text-marca {
        color: var(--vermelho-principal) !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0">
        <i data-lucide="layout-dashboard" class="text-marca"></i>
        Dashboard
    </h2>
    <small class="text-muted">Bem-vindo, {{ session('user_name') }}</small>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card dashboard-card shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <i data-lucide="clipboard-list" class="text-muted mb-2 mx-auto"></i>
                <h1 class="display-5 fw-bold">{{ $totalOrders->total }}</h1>
                <p class="text-muted mb-0">Total de OS</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card dashboard-card shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <i data-lucide="clock" class="text-warning mb-2 mx-auto"></i>
                <h1 class="display-5 fw-bold text-warning">{{ $ordersAwaitingApproval->total }}</h1>
                <p class="text-muted mb-0">Aguardando Aprovação</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card dashboard-card shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <i data-lucide="wrench" class="text-info mb-2 mx-auto"></i>
                <h1 class="display-5 fw-bold text-info">{{ $ordersInRepair->total }}</h1>
                <p class="text-muted mb-0">Em Reparo</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card dashboard-card shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <i data-lucide="check-circle" class="text-success mb-2 mx-auto"></i>
                <h1 class="display-5 fw-bold text-success">{{ $ordersReady->total }}</h1>
                <p class="text-muted mb-0">Prontos para Entrega</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card dashboard-card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div class="text-start">
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Clientes Cadastrados</p>
                    <h2 class="mb-0 fw-bold">{{ $totalCustomers->total }}</h2>
                </div>
                <div class="p-3 rounded" style="background-color: rgba(255,255,255,0.05);">
                    <i data-lucide="users" class="text-muted size-6"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card dashboard-card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div class="text-start">
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Veículos Cadastrados</p>
                    <h2 class="mb-0 fw-bold">{{ $totalVehicles->total }}</h2>
                </div>
                <div class="p-3 rounded" style="background-color: rgba(255,255,255,0.05);">
                    <i data-lucide="car" class="text-muted size-6"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-header d-flex align-items-center gap-2 p-3">
                <i data-lucide="list-ordered" class="text-marca size-5"></i>
                <strong class="text-white">Últimas Ordens de Serviço</strong>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-dark table-sm table-hover mb-0 align-middle">
                    <thead style="background-color: #1a1a1a;">
                        <tr>
                            <th class="ps-3 py-2 border-0">OS #</th>
                            <th class="py-2 border-0">Veículo</th>
                            <th class="py-2 border-0">Cliente</th>
                            <th class="py-2 border-0">Status</th>
                            <th class="py-2 border-0">Data</th>
                            <th class="pe-3 py-2 border-0 text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="fw-bold ps-3 text-white">#{{ $order->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i data-lucide="car" class="size-3 text-muted"></i> 
                                    <span>{{ $order->license_plate }}<br><small class="text-muted">{{ $order->brand }} {{ $order->model }}</small></span>
                                </div>
                            </td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                @switch($order->status)
                                    @case('received') <span class="badge bg-secondary">Recebido</span> @break
                                    @case('diagnostic') <span class="badge bg-primary">Diagnóstico</span> @break
                                    @case('awaiting_approval') <span class="badge bg-warning text-dark"><i data-lucide="timer" class="size-3"></i> Aguard. Aprovação</span> @break
                                    @case('in_repair') <span class="badge bg-info text-dark"><i data-lucide="hammer" class="size-3"></i> Em Reparo</span> @break
                                    @case('ready') <span class="badge bg-success"><i data-lucide="check" class="size-3"></i> Pronto</span> @break
                                    @case('delivered') <span class="badge bg-dark border border-secondary">Entregue</span> @break
                                @endswitch
                            </td>
                            <td>{{ date('d/m/Y', strtotime($order->opened_at)) }}</td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1 border-0">
                                    <i data-lucide="eye" class="size-4"></i> Ver
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Nenhuma ordem de serviço cadastrada ainda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer p-3">
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-2">
                    <i data-lucide="arrow-right-circle" class="size-4"></i>
                    Ver todas as OS
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card dashboard-card border-danger h-100">
            <div class="card-header d-flex align-items-center gap-2 p-3" style="background-color: rgba(255, 26, 26, 0.1) !important;">
                <i data-lucide="triangle-alert" class="text-danger" style="width: 18px;"></i>
                <strong class="text-danger">Estoque Baixo</strong>
                <small class="text-muted ms-auto">(< 5 un.)</small>
            </div>
            <div class="card-body p-0">
                @forelse($lowStockParts as $part)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="border-color: #2a2a2a !important;">
                    <span class="small d-flex align-items-center gap-2">
                        <i data-lucide="package-minus" class="text-muted size-4"></i>
                        {{ $part->name }}
                    </span>
                    <span class="badge bg-danger rounded-pill">{{ $part->stock_quantity }} un.</span>
                </div>
                @empty
                <div class="p-4 text-center text-muted d-flex flex-column align-items-center">
                    <i data-lucide="check-circle-2" class="text-success mb-2 size-6"></i>
                    <span>Estoque OK.<br>Nenhum item crítico.</span>
                </div>
                @endforelse
            </div>
            @if(count($lowStockParts) > 0)
            <div class="card-footer p-3 text-center border-0">
                <a href="{{ route('parts.index') }}" class="btn btn-sm btn-link text-danger text-decoration-none fw-bold d-inline-flex align-items-center gap-1">
                    Ver estoque completo <i data-lucide="chevron-right" class="size-4"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection