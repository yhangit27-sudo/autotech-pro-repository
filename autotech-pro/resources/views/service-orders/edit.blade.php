@extends('layouts.app')

@section('title', 'Editar OS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Diagnóstico - OS #{{ $order->id }}</h2>
    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-body">
        <form method="POST" action="{{ route('orders.update', $order->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Mecânico Responsável</label>
                <select class="form-select" name="mechanic_id">
                    <option value="">Sem mecânico</option>
                    @foreach($mechanics as $mechanic)
                    <option value="{{ $mechanic->id }}" {{ $order->mechanic_id == $mechanic->id ? 'selected' : '' }}>
                        {{ $mechanic->full_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Diagnóstico Técnico do Mecânico</label>
                <textarea class="form-control" name="mechanic_diagnosis" rows="6"
                          placeholder="Descreva o que foi encontrado tecnicamente no veículo...">{{ old('mechanic_diagnosis', $order->mechanic_diagnosis) }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Salvar Diagnóstico</button>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
