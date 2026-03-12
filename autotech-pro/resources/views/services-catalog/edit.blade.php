@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<style>
    .edit-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 12px; }
    .label-small { color: var(--cinza-medio); font-size: 0.7rem; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; }
    .form-control, .form-select { background: #0a0a0a; border: 1px solid #333; color: white; padding: 0.7rem; transition: 0.3s; }
    .form-control:focus, .form-select:focus { background: #111; border-color: var(--vermelho-principal); color: white; box-shadow: none; }
    .btn-update { background: var(--vermelho-principal); color: white; font-weight: bold; border: none; text-transform: uppercase; }
    .btn-update:hover { background: var(--vermelho-claro); color: white; transform: translateY(-1px); }
    .input-group-text { background: #1a1a1a; border: 1px solid #333; color: var(--cinza-medio); }
    .info-box { background: rgba(52, 152, 219, 0.1); border-left: 3px solid #3498db; color: #3498db; font-size: 0.85rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 text-white">
    <h2 class="mb-0 d-flex align-items-center gap-2">
        <i data-lucide="user-cog" class="text-danger"></i> Editar <span class="text-danger">Usuário</span>
    </h2>
    <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-sm">← Voltar</a>
</div>

<div class="card edit-card shadow-lg mx-auto" style="max-width: 650px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            {{-- Adicione @method('PUT') se o seu Controller exigir --}}

            <div class="mb-4">
                <label class="label-small mb-2 d-block">Nome Completo</label>
                <div class="input-group">
                    <span class="input-group-text"><i data-lucide="user" class="size-4"></i></span>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">E-mail de Acesso</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">Alterar Senha</label>
                    <input type="password" name="password" class="form-control" placeholder="Deixe em branco para manter">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">CPF / CNPJ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i data-lucide="fingerprint" class="size-4"></i></span>
                        <input type="text" name="tax_id" class="form-control" value="{{ old('tax_id', $user->tax_id) }}" maxlength="18" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">Nível de Acesso (Cargo)</label>
                    <select class="form-select" name="role" required>
                        <option value="manager"   {{ old('role', $user->role) == 'manager'   ? 'selected' : '' }}>Gerente</option>
                        <option value="attendant" {{ old('role', $user->role) == 'attendant' ? 'selected' : '' }}>Atendente</option>
                        <option value="mechanic"  {{ old('role', $user->role) == 'mechanic'  ? 'selected' : '' }}>Mecânico</option>
                        <option value="customer"  {{ old('role', $user->role) == 'customer'  ? 'selected' : '' }}>Cliente</option>
                    </select>
                </div>
            </div>

            <div class="p-3 mb-4 info-box rounded d-flex align-items-center gap-2">
                <i data-lucide="info" class="size-5"></i>
                <span>A senha só será atualizada se você preencher o campo correspondente.</span>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-update py-3 shadow-sm">
                    <i data-lucide="refresh-cw" class="size-4 me-2"></i> Atualizar Cadastro
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-link text-muted text-decoration-none small">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection