@extends('layouts.app')

@section('title', 'Ordens de Serviço')

@section('content')
<style>
    /* Estilos para a página de listagem */
    .index-card {
        background-color: var(--preto-secundario);
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        overflow: hidden;
    }
    .table-dark {
        --bs-table-bg: transparent;
        --bs-table-color: var(--branco);
        --bs-table-border-color: #2a2a2a;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
    }
    .thead-custom {
        background-color: #1a1a1a;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
    /* Estilização dos filtros */
    .filter-link {
        transition: all 0.2s;
        border: 1px solid #333;
        color: var(--cinza-medio) !important;
        background: #1a1a1a;
    }
    .filter-link:hover {
        border-color: var(--vermelho-principal);
        color: var(--branco) !important;
        transform: translateY(-2px);
    }
    .btn-marca {
        background-color: var(--vermelho-principal);
        color: white;
        border: none;
    }
    .btn-marca:hover {
        background-color: var(--vermelho-claro);
        color: white;
    }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0">
        <i data-lucide="clipboard-list" class="text-danger"></i>
        Ordens de Serviço
    </h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('orders.create') }}" class="btn btn-marca d-inline-flex align-items-center gap-2 px-4 shadow-sm">
        <i data-lucide="plus-circle" class="size-5"></i>
        Abrir Nova OS
    </a>
    @endif
</div>

<div class="mb-4 overflow-auto pb-2" style="white-space: nowrap;">
    <small class="text-muted d-block mb-2 text-uppercase fw-bold" style="font-size: 0.7rem;">Filtrar por status:</small>
    <a href="{{ route('orders.index') }}" class="badge filter-link text-decoration-none p-2 px-3 rounded-pill me-1">Todos</a>
    <a href="{{ route('orders.index') }}?status=received" class="badge filter-link text-decoration-none p-2 px-3 rounded-pill me-1">Recebidos</a>
    <a href="{{ route('orders.index') }}?status=diagnostic" class="badge filter-link text-decoration-none p-2 px-3 rounded-pill me-1">Diagnóstico</a>
    <a href="{{ route('orders.index') }}?status=awaiting_approval" class="badge filter-link text-decoration-none p-2 px-3 rounded-pill me-1">Aguard. Aprovação</a>
    <a href="{{ route('orders.index') }}?status=in_repair" class="badge filter-link text-decoration-none p-2 px-3 rounded-pill me-1">Em Reparo</a>
    <a href="{{ route('orders.index') }}?status=ready" class="badge filter-link text-decoration-none p-2 px-3 rounded-pill me-1">Prontos</a>
    <a href="{{ route('orders.index') }}?status=delivered" class="badge filter-link text-decoration-none p-2 px-3 rounded-pill me-1">Entregues</a>
</div>

<div class="card index-card shadow-lg">
    <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="ps-4 py-3 border-0">OS #</th>
                    <th class="py-3 border-0">Veículo</th>
                    <th class="py-3 border-0">Cliente</th>
                    <th class="py-3 border-0">Atendente</th>
                    <th class="py-3 border-0">Status</th>
                    <th class="py-3 border-0">Abertura</th>
                    <th class="pe-4 py-3 border-0 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="ps-4 fw-bold text-white">#{{ $order->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="car" class="size-4 text-muted"></i>
                            <span>{{ $order->license_plate }}<br><small class="text-muted">{{ $order->brand }} {{ $order->model }}</small></span>
                        </div>
                    </td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <i data-lucide="user-cog" class="size-3 text-muted"></i>
                            <small>{{ $order->attendant_name }}</small>
                        </div>
                    </td>
                    <td>
                        @switch($order->status)
                            @case('received') <span class="badge bg-secondary opacity-75">Recebido</span> @break
                            @case('diagnostic') <span class="badge bg-primary">Diagnóstico</span> @break
                            @case('awaiting_approval') <span class="badge bg-warning text-dark"><i data-lucide="timer" class="size-3"></i> Aguard.</span> @break
                            @case('in_repair') <span class="badge bg-info text-dark"><i data-lucide="wrench" class="size-3"></i> Reparo</span> @break
                            @case('ready') <span class="badge bg-success"><i data-lucide="check" class="size-3"></i> Pronto</span> @break
                            @case('delivered') <span class="badge bg-dark border border-secondary text-muted">Entregue</span> @break
                        @endswitch
                    </td>
                    <td class="small text-muted">{{ date('d/m/Y H:i', strtotime($order->opened_at)) }}</td>
                    <td class="pe-4 text-end">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-light border-0 d-inline-flex align-items-center gap-1 hover-danger">
                            <i data-lucide="eye" class="size-4"></i>
                            Ver Detalhes
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i data-lucide="search-x" class="size-10 opacity-25 mb-2"></i>
                        <p>Nenhuma ordem de serviço encontrada com esses filtros.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection