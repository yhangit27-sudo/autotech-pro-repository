@extends('layouts.app')

@section('title', 'Editar OS')

@section('content')
<style>
    .edit-card {
        background-color: var(--preto-secundario);
        border: 1px solid #2a2a2a;
        color: var(--branco);
        border-radius: 12px;
    }
    .form-label {
        color: var(--cinza-medio);
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        background-color: #0a0a0a;
        border: 1px solid #333;
        color: white;
        padding: 0.75rem;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        background-color: #111;
        border-color: var(--vermelho-principal);
        box-shadow: 0 0 0 0.25rem rgba(196, 0, 0, 0.15);
        color: white;
    }
    .btn-submit {
        background-color: var(--vermelho-principal);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        font-weight: bold;
    }
    .btn-submit:hover {
        background-color: var(--vermelho-claro);
        color: white;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="edit-3" class="text-danger"></i>
        Editar Diagnóstico <span class="text-danger">OS #{{ $order->id }}</span>
    </h2>
    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
        <i data-lucide="arrow-left" class="size-4"></i> Voltar
    </a>
</div>

<div class="card edit-card shadow-lg mx-auto" style="max-width: 700px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('orders.update', $order->id) }}">
            @csrf

            <div class="mb-4">
                <label class="form-label">
                    <i data-lucide="user-cog" class="size-3 me-1"></i> Mecânico Responsável
                </label>
                <select class="form-select" name="mechanic_id">
                    <option value="">Sem mecânico atribuído</option>
                    @foreach($mechanics as $m)
                    <option value="{{ $m->id }}" {{ $order->mechanic_id == $m->id ? 'selected' : '' }}>
                        {{ $m->full_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label class="form-label">
                    <i data-lucide="clipboard-check" class="size-3 me-1"></i> Diagnóstico Técnico
                </label>
                <textarea class="form-control" name="mechanic_diagnosis" rows="8" 
                          placeholder="Descreva detalhadamente as falhas encontradas, peças que precisam de troca e o serviço a ser executado...">{{ old('mechanic_diagnosis', $order->mechanic_diagnosis) }}</textarea>
                <div class="mt-2 p-2 bg-dark bg-opacity-50 rounded border border-secondary border-opacity-25">
                    <small class="text-muted d-flex align-items-center gap-2">
                        <i data-lucide="info" class="size-3"></i> 
                        Este diagnóstico será visível para o cliente na aprovação.
                    </small>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-3">
                <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center gap-2 shadow-sm">
                    <i data-lucide="save" class="size-5"></i>
                    SALVAR ALTERAÇÕES
                </button>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection