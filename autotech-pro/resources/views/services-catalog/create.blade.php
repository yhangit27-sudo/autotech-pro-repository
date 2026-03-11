@extends('layouts.app')

@section('title', 'Novo Serviço')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Cadastrar Serviço</h2>
    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 500px;">
    <div class="card-body">
        <form method="POST" action="{{ route('services.store') }}">
            @csrf

            <div class="mb-3">
                <label for="description" class="form-label">Descrição do Serviço <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="description" name="description"
                       value="{{ old('description') }}" placeholder="Ex: Troca de óleo e filtro" required>
            </div>

            <div class="mb-3">
                <label for="hourly_rate" class="form-label">Valor por Hora (R$) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="hourly_rate" name="hourly_rate"
                       value="{{ old('hourly_rate') }}" step="0.01" min="0" required>
                <div class="form-text">Valor cobrado por hora de trabalho neste tipo de serviço.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Cadastrar Serviço</button>
                <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
