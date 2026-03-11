@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Usuário</h2>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="full_name" name="full_name"
                       value="{{ old('full_name', $user->full_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha</label>
                {{-- o olho é injetado automaticamente pelo autotech.js --}}
                <input type="password" class="form-control" id="password" name="password">
                <div class="form-text text-muted">Deixe em branco para manter a senha atual.</div>
            </div>

            <div class="mb-3">
                <label for="tax_id" class="form-label">CPF / CNPJ <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tax_id" name="tax_id"
                       value="{{ old('tax_id', $user->tax_id) }}" maxlength="18" required>
                {{-- feedback de validação inserido pelo autotech.js --}}
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Cargo <span class="text-danger">*</span></label>
                <select class="form-select" id="role" name="role" required>
                    <option value="manager"   {{ $user->role == 'manager'   ? 'selected' : '' }}>Gerente</option>
                    <option value="attendant" {{ $user->role == 'attendant' ? 'selected' : '' }}>Atendente</option>
                    <option value="mechanic"  {{ $user->role == 'mechanic'  ? 'selected' : '' }}>Mecânico</option>
                    <option value="customer"  {{ $user->role == 'customer'  ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Salvar Alterações</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
