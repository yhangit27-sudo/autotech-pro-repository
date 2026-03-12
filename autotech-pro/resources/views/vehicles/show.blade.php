@extends('layouts.app')

@section('title', 'Detalhes do Veículo')

@section('content')
<style>
    .info-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 12px; }
    .label-muted { color: var(--cinza-medio); font-size: 0.7rem; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; display: block; }
    .info-value { color: var(--branco); font-size: 1.1rem; font-weight: 500; }
    
    /* Placa Preta no Detalhe */
    .placa-header {
        background-color: #050505;
        color: #e0e0e0;
        border: 2px solid #333;
        border-radius: 6px;
        padding: 5px 15px;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 1.4rem;
        letter-spacing: 3px;
        display: inline-block;
        box-shadow: inset 0 0 8px rgba(255,255,255,0.05);
    }

    .table-custom { --bs-table-bg: transparent; color: var(--branco); }
    .table-custom thead { background: rgba(255,255,255,0.03); font-size: 0.75rem; text-transform: uppercase; }
    .table-custom td { vertical-align: middle; border-color: #2a2a2a; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="placa-header shadow-sm">{{ $vehicle->license_plate }}</div>
        <h2 class="mb-0 text-white-50 fs-4">/ Dossiê do Veículo</h2>
    </div>
    <div class="d-flex gap-2">
        @if(in_array(session('user_role'), ['manager', 'attendant']))
        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
            <i data-lucide="edit-3" class="size-4"></i> Editar
        </a>
        @endif
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-sm">← Voltar</a>
    </div>
</div>

<div class="card info-card mb-4 shadow-lg">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-3 border-end border-secondary border-opacity-25">
                <span class="label-muted">Marca / Fabricante</span>
                <span class="info-value text-danger">{{ $vehicle->brand ?? 'Não informada' }}</span>
            </div>
            <div class="col-md-3 border-end border-secondary border-opacity-25">
                <span class="label-muted">Modelo / Versão</span>
                <span class="info-value">{{ $vehicle->model ?? 'Não informado' }}</span>
            </div>
            <div class="col-md-3 border-end border-secondary border-opacity-25">
                <span class="label-muted">Código FIPE</span>
                <span class="info-value font-monospace text-muted">{{ $vehicle->fipe_code ?? '---' }}</span>
            </div>
            <div class="col-md-3">
                <span class="label-muted">Proprietário</span>
                <span class="info-value d-flex align-items-center gap-2">
                    <i data-lucide="user" class="size-4 text-danger"></i>
                    {{ $vehicle->customer_name }}
                </span>
                <small class="text-muted d-block">{{ $vehicle->customer_email }}</small>
            </div>
        </div>
    </div>
</div>

<div class="card info-card shadow-lg">
    <div class="card-header border-bottom border-secondary border-opacity-25 py-3 bg-transparent">
        <h5 class="mb-0 d-flex align-items-center gap-2 text-white">
            <i data-lucide="history" class="text-danger"></i> Histórico de Manutenções
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 text-white">OS #</th>
                        <th class="text-white">Atendente</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">Abertura</th>
                        <th class="text-white">Garantia M.O.</th>
                        <th class="pe-4 text-end text-white">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold text-white">#{{ $order->id }}</td>
                        <td class="text-muted">{{ $order->attendant_name }}</td>
                        <td>
                            @php
                                $statusMap = [
                                    'received' => ['bg-secondary', 'Recebido'],
                                    'diagnostic' => ['bg-primary', 'Diagnóstico'],
                                    'awaiting_approval' => ['bg-warning text-dark', 'Aprovação'],
                                    'in_repair' => ['bg-info text-dark', 'Reparo'],
                                    'ready' => ['bg-success', 'Pronto'],
                                    'delivered' => ['bg-dark border border-secondary', 'Entregue']
                                ];
                                $st = $statusMap[$order->status] ?? ['bg-light', $order->status];
                            @endphp
                            <span class="badge {{ $st[0] }}">{{ $st[1] }}</span>
                        </td>
                        <td class="small text-muted">{{ date('d/m/Y', strtotime($order->opened_at)) }}</td>
                        <td>
                            @if($order->labor_warranty_expiry)
                                <span class="small">{{ date('d/m/Y', strtotime($order->labor_warranty_expiry)) }}</span>
                                @if(strtotime($order->labor_warranty_expiry) < time())
                                    <i data-lucide="shield-off" class="text-danger size-3 ms-1" title="Vencida"></i>
                                @else
                                    <i data-lucide="shield-check" class="text-success size-3 ms-1" title="Válida"></i>
                                @endif
                            @else
                                <span class="text-muted">---</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-link text-danger p-0 fw-bold text-decoration-none">
                                DETALHES
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i data-lucide="folder-open" class="size-8 opacity-25 mb-2"></i>
                            <p class="mb-0">Este veículo ainda não possui registros de serviço.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection