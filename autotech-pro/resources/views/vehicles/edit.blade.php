@extends('layouts.app')

@section('title', 'Editar Veículo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Veículo</h2>
    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('vehicles.update', $vehicle->id) }}">
            @csrf

            <div class="mb-3">
                <label for="customer_id" class="form-label">Proprietário (Cliente)</label>
                <select class="form-select" id="customer_id" name="customer_id" required>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $vehicle->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->full_name }} - {{ $customer->tax_id }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="license_plate" class="form-label">Placa</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate"
                       value="{{ old('license_plate', $vehicle->license_plate) }}" required>
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Marca</label>
                <input type="text" class="form-control" id="brand" name="brand"
                       value="{{ old('brand', $vehicle->brand) }}">
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="model" name="model"
                       value="{{ old('model', $vehicle->model) }}">
            </div>

            <div class="mb-3">
                <label for="fipe_code" class="form-label">Código FIPE</label>
                <input type="text" class="form-control" id="fipe_code" name="fipe_code"
                       value="{{ old('fipe_code', $vehicle->fipe_code) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Salvar Alterações</button>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
