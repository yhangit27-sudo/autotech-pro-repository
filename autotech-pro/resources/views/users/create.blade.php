@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Cadastrar Novo Usuário</h2>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="full_name" name="full_name"
                       value="{{ old('full_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha <span class="text-danger">*</span></label>
                {{-- o olho é injetado automaticamente pelo autotech.js --}}
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="form-text">Mínimo 6 caracteres recomendado.</div>
            </div>

            <div class="mb-3">
                <label for="tax_id" class="form-label">CPF / CNPJ <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tax_id" name="tax_id"
                       value="{{ old('tax_id') }}" placeholder="000.000.000-00" maxlength="18" required>
                {{-- feedback de validação inserido pelo autotech.js --}}
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Cargo <span class="text-danger">*</span></label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Selecione um cargo...</option>
                    <option value="manager"   {{ old('role') == 'manager'   ? 'selected' : '' }}>Gerente</option>
                    <option value="attendant" {{ old('role') == 'attendant' ? 'selected' : '' }}>Atendente</option>
                    <option value="mechanic"  {{ old('role') == 'mechanic'  ? 'selected' : '' }}>Mecânico</option>
                    <option value="customer"  {{ old('role') == 'customer'  ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Salvar Usuário</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
