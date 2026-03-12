@extends('layouts.app')

@section('title', 'Veículos')

@section('content')
<style>
    .vehicle-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden; }
    .table-dark { --bs-table-bg: transparent; --bs-table-color: var(--branco); --bs-table-border-color: #2a2a2a; }
    .thead-custom { background: #1a1a1a; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
    
    /* Simulação da Placa Preta de Colecionador */
    .placa-preta {
        background-color: #050505;
        color: #e0e0e0;
        border: 2px solid #333;
        border-radius: 4px;
        padding: 2px 10px;
        font-family: 'Courier New', Courier, monospace; /* Fonte que lembra impacto de metal */
        font-weight: bold;
        font-size: 0.9rem;
        letter-spacing: 2px;
        display: inline-block;
        box-shadow: inset 0 0 5px rgba(255,255,255,0.05), 0 2px 4px rgba(0,0,0,0.5);
        text-transform: uppercase;
    }

    .btn-marca { background: var(--vermelho-principal); color: white; border: none; }
    .btn-marca:hover { background: var(--vermelho-claro); color: white; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="car" class="text-danger"></i> Veículos
    </h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('vehicles.create') }}" class="btn btn-marca d-inline-flex align-items-center gap-2 px-3 shadow-sm">
        <i data-lucide="plus-circle" class="size-5"></i> Novo Veículo
    </a>
    @endif
</div>

<div class="card vehicle-card shadow-lg">
    <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="ps-4 py-3 border-0">Placa</th>
                    <th class="py-3 border-0">Marca / Modelo</th>
                    <th class="py-3 border-0">FIPE</th>
                    <th class="py-3 border-0">Proprietário</th>
                    <th class="pe-4 py-3 border-0 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $v)
                <tr>
                    <td class="ps-4">
                        <div class="placa-preta">{{ $v->license_plate }}</div>
                    </td>
                    <td>
                        <div class="text-white fw-bold">{{ $v->brand }}</div>
                        <div class="text-muted small">{{ $v->model }}</div>
                    </td>
                    <td class="text-muted small font-monospace">{{ $v->fipe_code ?? '---' }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="user" class="size-3 text-muted"></i>
                            <span class="small">{{ $v->customer_name }}</span>
                        </div>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="{{ route('vehicles.show', $v->id) }}" class="btn btn-sm btn-outline-light border-0" title="Ver Histórico">
                                <i data-lucide="history" class="size-4"></i>
                            </a>
                            @if(in_array(session('user_role'), ['manager', 'attendant']))
                            <a href="{{ route('vehicles.edit', $v->id) }}" class="btn btn-sm btn-outline-light border-0" title="Editar">
                                <i data-lucide="edit-2" class="size-4"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i data-lucide="search-x" class="size-10 opacity-25 mb-2"></i>
                        <p>Nenhum veículo cadastrado na base.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection