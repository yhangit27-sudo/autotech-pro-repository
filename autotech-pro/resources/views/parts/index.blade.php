@extends('layouts.app')

@section('title', 'Peças / Estoque')

@section('content')
<style>
    .stock-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden; }
    .table-dark { --bs-table-bg: transparent; --bs-table-color: var(--branco); --bs-table-border-color: #2a2a2a; }
    .thead-custom { background: #1a1a1a; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: var(--cinza-medio); }
    .btn-marca { background: var(--vermelho-principal); color: white; border: none; }
    .btn-marca:hover { background: var(--vermelho-claro); color: white; }
    .text-money { color: #2ecc71; font-weight: bold; } /* Verde para dinheiro/venda */
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="package" class="text-danger"></i> Peças / <span class="text-danger">Estoque</span>
    </h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('parts.create') }}" class="btn btn-marca d-inline-flex align-items-center gap-2 px-3">
        <i data-lucide="plus-circle" class="size-5"></i> Nova Peça
    </a>
    @endif
</div>

<div class="card stock-card shadow-lg">
    <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="ps-4 py-3 border-0">Peça</th>
                    <th class="py-3 border-0 text-center">Custo</th>
                    <th class="py-3 border-0 text-center">Venda</th>
                    <th class="py-3 border-0 text-center">Margem</th>
                    <th class="py-3 border-0 text-center">Estoque</th>
                    <th class="py-3 border-0 text-center">Garantia</th>
                    <th class="pe-4 py-3 border-0 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($parts as $part)
                <tr>
                    <td class="ps-4">
                        <div class="text-white fw-bold">{{ $part->name }}</div>
                        <small class="text-muted">ID: #{{ $part->id }}</small>
                    </td>
                    <td class="text-center text-muted small">
                        R$ {{ number_format($part->cost_price, 2, ',', '.') }}
                    </td>
                    <td class="text-center text-money">
                        R$ {{ number_format($part->sale_price, 2, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @php
                            $margem = (($part->sale_price - $part->cost_price) / $part->cost_price) * 100;
                        @endphp
                        <span class="badge bg-dark border border-secondary text-white-50">
                            {{ number_format($margem, 0) }}%
                        </span>
                    </td>
                    <td class="text-center">
                        @if($part->stock_quantity < 5)
                            <span class="badge bg-danger shadow-sm px-3" title="Estoque Crítico">{{ $part->stock_quantity }} un</span>
                        @elseif($part->stock_quantity < 10)
                            <span class="badge bg-warning text-dark px-3">{{ $part->stock_quantity }} un</span>
                        @else
                            <span class="badge bg-secondary px-3">{{ $part->stock_quantity }} un</span>
                        @endif
                    </td>
                    <td class="text-center small text-muted">
                        <i data-lucide="shield" class="size-3 me-1"></i>{{ $part->manufacturer_warranty_months }} meses
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            @if(in_array(session('user_role'), ['manager', 'attendant']))
                            <a href="{{ route('parts.edit', $part->id) }}" class="btn btn-sm btn-outline-light border-0">
                                <i data-lucide="edit-2" class="size-4"></i>
                            </a>
                            @endif
                            
                            @if(session('user_role') === 'manager')
                            <form method="POST" action="{{ route('parts.destroy', $part->id) }}" class="d-inline" onsubmit="return confirm('Remover esta peça do estoque?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                    <i data-lucide="trash-2" class="size-4"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i data-lucide="package-x" class="size-10 opacity-25 mb-2"></i>
                        <p>Nenhuma peça em estoque.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection