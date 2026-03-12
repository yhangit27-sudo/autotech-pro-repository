@extends('layouts.app')

@section('title', 'Novo Veículo')

@section('content')
<style>
    .create-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 12px; }
    .form-label { color: var(--cinza-medio); font-size: 0.75rem; text-transform: uppercase; font-weight: bold; }
    .form-control, .form-select { background: #0a0a0a; border: 1px solid #333; color: white; padding: 0.6rem; }
    .form-control:focus, .form-select:focus { background: #111; border-color: var(--vermelho-principal); color: white; box-shadow: none; }
    .btn-save { background: var(--vermelho-principal); color: white; font-weight: bold; border: none; }
    .btn-save:hover { background: var(--vermelho-claro); color: white; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-white mb-0 d-flex align-items-center gap-2">
        <i data-lucide="car-front" class="text-danger"></i> Cadastrar <span class="text-danger">Veículo</span>
    </h2>
    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-light btn-sm">← Voltar</a>
</div>

<div class="card create-card shadow-lg mx-auto" style="max-width: 650px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('vehicles.store') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label">Proprietário (Cliente) *</label>
                <select class="form-select" name="customer_id" required>
                    <option value="">Selecione o cliente...</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->full_name }} — {{ $c->tax_id }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Placa *</label>
                    <input type="text" name="license_plate" class="form-control text-uppercase" 
                           value="{{ old('license_plate') }}" placeholder="ABC1D23" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Código FIPE</label>
                    <input type="text" name="fipe_code" class="form-control" 
                           value="{{ old('fipe_code') }}" placeholder="000000-0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Marca</label>
                    <input type="text" name="brand" class="form-control" 
                           value="{{ old('brand') }}" placeholder="Ex: BMW">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="model" class="form-control" 
                           value="{{ old('model') }}" placeholder="Ex: 320i Sport">
                </div>
            </div>

            <div class="alert bg-dark border-secondary border-opacity-25 small mb-4 d-flex align-items-center gap-2 text-muted">
                <i data-lucide="info" class="size-4 text-danger"></i>
                Consulte o código em <a href="{{ route('fipe.index') }}" target="_blank" class="text-danger text-decoration-none fw-bold">Tabela FIPE</a>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-save py-2">CADASTRAR VEÍCULO</button>
                <a href="{{ route('vehicles.index') }}" class="btn btn-link text-muted text-decoration-none small">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection