@extends('layouts.app')

@section('title', 'Novo Serviço')

@section('content')
<style>
    .create-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 12px; }
    .label-small { color: var(--cinza-medio); font-size: 0.7rem; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; }
    .form-control { background: #0a0a0a; border: 1px solid #333; color: white; padding: 0.7rem; transition: 0.3s; }
    .form-control:focus { background: #111; border-color: var(--vermelho-principal); color: white; box-shadow: none; }
    .btn-save { background: var(--vermelho-principal); color: white; font-weight: bold; border: none; text-transform: uppercase; letter-spacing: 1px; }
    .btn-save:hover { background: var(--vermelho-claro); color: white; transform: translateY(-1px); }
    .input-group-text { background: #1a1a1a; border: 1px solid #333; color: #3498db; font-weight: bold; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 text-white">
    <h2 class="mb-0 d-flex align-items-center gap-2">
        <i data-lucide="plus-square" class="text-danger"></i> Novo <span class="text-danger">Serviço</span>
    </h2>
    <a href="{{ route('services.index') }}" class="btn btn-outline-light btn-sm">← Voltar</a>
</div>

<div class="card create-card shadow-lg mx-auto" style="max-width: 550px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('services.store') }}">
            @csrf

            <div class="mb-4">
                <label class="label-small mb-2 d-block">Descrição do Serviço *</label>
                <input type="text" name="description" class="form-control" 
                       value="{{ old('description') }}" placeholder="Ex: Alinhamento e Balanceamento" required>
            </div>

            <div class="mb-4">
                <label class="label-small mb-2 d-block">Valor da Mão de Obra (por hora) *</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" name="hourly_rate" class="form-control" 
                           value="{{ old('hourly_rate') }}" step="0.01" min="0" required placeholder="0,00">
                    <span class="input-group-text text-muted font-monospace" style="font-size: 0.8rem;">/h</span>
                </div>
                <div class="small text-muted mt-2 italic">
                    <i data-lucide="info" class="size-3 me-1"></i> Este valor será a base para o cálculo de tempo nas OS.
                </div>
            </div>

            <hr class="my-4 opacity-25">

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-save py-3 shadow-sm">
                    <i data-lucide="check-circle" class="size-4 me-2"></i> Confirmar Cadastro
                </button>
                <a href="{{ route('services.index') }}" class="btn btn-link text-muted text-decoration-none small">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection