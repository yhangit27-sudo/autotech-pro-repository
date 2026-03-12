@extends('layouts.app')

@section('title', 'Catálogo de Serviços')

@section('content')
<style>
    .service-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden; }
    .table-dark { --bs-table-bg: transparent; --bs-table-color: var(--branco); --bs-table-border-color: #2a2a2a; }
    .thead-custom { background: #1a1a1a; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: var(--cinza-medio); }
    .btn-marca { background: var(--vermelho-principal); color: white; border: none; }
    .btn-marca:hover { background: var(--vermelho-claro); color: white; }
    .text-rate { color: #3498db; font-weight: bold; font-family: 'Inter', sans-serif; } /* Azul para serviços/taxas */
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="wrench" class="text-danger"></i> Catálogo de <span class="text-danger">Serviços</span>
    </h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('services.create') }}" class="btn btn-marca d-inline-flex align-items-center gap-2 px-3 shadow-sm">
        <i data-lucide="plus-circle" class="size-5"></i> Novo Serviço
    </a>
    @endif
</div>

<div class="card service-card shadow-lg">
    <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="ps-4 py-3 border-0" style="width: 80px;">#</th>
                    <th class="py-3 border-0">Descrição do Serviço</th>
                    <th class="py-3 border-0 text-center ">Valor por Hora</th>
                    <th class="pe-4 py-3 border-0 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $s)
                <tr>
                    <td class="ps-4 text-muted small">#{{ $s->id }}</td>
                    <td>
                        <div class="text-white fw-bold">{{ $s->description }}</div>
                    </td>
                    <td class="text-center">
                        <span class="text-lime-500 drop-shadow-lime-400">
                            R$ {{ number_format($s->hourly_rate, 2, ',', '.') }}
                        </span>
                        <small class="text-muted">/h</small>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-1">
                            @if(in_array(session('user_role'), ['manager', 'attendant']))
                            <a href="{{ route('services.edit', $s->id) }}" class="btn btn-sm btn-outline-light border-0" title="Editar">
                                <i data-lucide="edit-3" class="size-4"></i>
                            </a>
                            @endif
                            
                            @if(session('user_role') === 'manager')
                            <form method="POST" action="{{ route('services.destroy', $s->id) }}" class="d-inline" onsubmit="return confirm('Remover este serviço do catálogo?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Excluir">
                                    <i data-lucide="trash-2" class="size-4"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        <i data-lucide="clipboard-x" class="size-10 opacity-25 mb-2"></i>
                        <p>O catálogo de serviços está vazio.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection