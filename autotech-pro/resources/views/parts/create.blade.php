@extends('layouts.app')

@section('title', 'Nova Peça')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Cadastrar Peça</h2>
    <a href="{{ route('parts.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('parts.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Peça <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name') }}" placeholder="Ex: Pastilha de freio dianteira" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cost_price" class="form-label">Preço de Custo (R$) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="cost_price" name="cost_price"
                           value="{{ old('cost_price') }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sale_price" class="form-label">Preço de Venda (R$) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="sale_price" name="sale_price"
                           value="{{ old('sale_price') }}" step="0.01" min="0" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock_quantity" class="form-label">Quantidade em Estoque <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity"
                           value="{{ old('stock_quantity') }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="manufacturer_warranty_months" class="form-label">Garantia Fabricante (meses)</label>
                    <input type="number" class="form-control" id="manufacturer_warranty_months"
                           name="manufacturer_warranty_months"
                           value="{{ old('manufacturer_warranty_months', 3) }}" min="0">
                    <div class="form-text">Padrão: 3 meses</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Cadastrar Peça</button>
                <a href="{{ route('parts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
