@extends('layouts.app')

@section('title', 'Nova Ordem de Serviço')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Abrir Nova Ordem de Serviço</h2>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-body">
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            <div class="mb-3">
                <label for="vehicle_id" class="form-label">Veículo <span class="text-danger">*</span></label>
                <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                    <option value="">Selecione o veículo pela placa...</option>
                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                        {{ $vehicle->license_plate }} - {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->customer_name }})
                    </option>
                    @endforeach
                </select>
                <div class="form-text">
                    Não encontrou o veículo?
                    <a href="{{ route('vehicles.create') }}" target="_blank">Cadastrar novo veículo</a>
                </div>
            </div>

            <div class="mb-3">
                <label for="mechanic_id" class="form-label">Mecânico Responsável</label>
                <select class="form-select" id="mechanic_id" name="mechanic_id">
                    <option value="">Selecionar depois...</option>
                    @foreach($mechanics as $mechanic)
                    <option value="{{ $mechanic->id }}" {{ old('mechanic_id') == $mechanic->id ? 'selected' : '' }}>
                        {{ $mechanic->full_name }}
                    </option>
                    @endforeach
                </select>
                <div class="form-text">Pode ser atribuído depois se necessário.</div>
            </div>

            <div class="mb-3">
                <label for="customer_symptoms" class="form-label">Sintomas Relatados pelo Cliente <span class="text-danger">*</span></label>
                <textarea class="form-control" id="customer_symptoms" name="customer_symptoms"
                          rows="4" required
                          placeholder="Descreva o que o cliente relatou: barulhos, falhas, comportamentos estranhos...">{{ old('customer_symptoms') }}</textarea>
                <div class="form-text">Seja detalhado - este registro protege a oficina juridicamente.</div>
            </div>

            <div class="alert alert-info">
                <strong><img src="/icons/alert.png" alt="Atenção" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Lembrete:</strong> Após criar a OS, não esqueça de adicionar as <strong>fotos de entrada</strong> do veículo (exigido pela RN004).
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Abrir Ordem de Serviço</button>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
