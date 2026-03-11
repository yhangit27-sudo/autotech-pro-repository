@extends('layouts.app')

@section('title', 'Editar Serviço')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Serviço</h2>
    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 500px;">
    <div class="card-body">
        <form method="POST" action="{{ route('services.update', $service->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Descrição do Serviço</label>
                <input type="text" class="form-control" name="description"
                       value="{{ old('description', $service->description) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Valor por Hora (R$)</label>
                <input type="number" class="form-control" name="hourly_rate"
                       value="{{ old('hourly_rate', $service->hourly_rate) }}" step="0.01" min="0" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Salvar Alterações</button>
                <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
