@extends('layouts.app')

@section('title', 'Novo Veículo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Cadastrar Veículo</h2>
    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('vehicles.store') }}">
            @csrf

            <div class="mb-3">
                <label for="customer_id" class="form-label">Proprietário (Cliente) <span class="text-danger">*</span></label>
                <select class="form-select" id="customer_id" name="customer_id" required>
                    <option value="">Selecione o cliente...</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->full_name }} - {{ $customer->tax_id }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="license_plate" class="form-label">Placa <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="license_plate" name="license_plate"
                       value="{{ old('license_plate') }}" placeholder="ABC1234 ou ABC1D23" required>
                <div class="form-text">Formato antigo (ABC1234) ou Mercosul (ABC1D23)</div>
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Marca</label>
                <input type="text" class="form-control" id="brand" name="brand"
                       value="{{ old('brand') }}" placeholder="Ex: Volkswagen, Chevrolet...">
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="model" name="model"
                       value="{{ old('model') }}" placeholder="Ex: Gol, Onix...">
            </div>

            <div class="mb-3">
                <label for="fipe_code" class="form-label">Código FIPE</label>
                <input type="text" class="form-control" id="fipe_code" name="fipe_code"
                       value="{{ old('fipe_code') }}" placeholder="Ex: 005340-6">
                <div class="form-text">
                    Use a <a href="{{ route('fipe.index') }}" target="_blank">Consulta FIPE</a> para encontrar o código.
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Cadastrar Veículo</button>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
