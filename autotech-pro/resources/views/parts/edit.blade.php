@extends('layouts.app')

@section('title', 'Editar Peça')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Peça</h2>
    <a href="{{ route('parts.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('parts.update', $part->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nome da Peça</label>
                <input type="text" class="form-control" name="name"
                       value="{{ old('name', $part->name) }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Preço de Custo (R$)</label>
                    <input type="number" class="form-control" name="cost_price"
                           value="{{ old('cost_price', $part->cost_price) }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Preço de Venda (R$)</label>
                    <input type="number" class="form-control" name="sale_price"
                           value="{{ old('sale_price', $part->sale_price) }}" step="0.01" min="0" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Quantidade em Estoque</label>
                    <input type="number" class="form-control" name="stock_quantity"
                           value="{{ old('stock_quantity', $part->stock_quantity) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Garantia Fabricante (meses)</label>
                    <input type="number" class="form-control" name="manufacturer_warranty_months"
                           value="{{ old('manufacturer_warranty_months', $part->manufacturer_warranty_months) }}" min="0">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Salvar Alterações</button>
                <a href="{{ route('parts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
