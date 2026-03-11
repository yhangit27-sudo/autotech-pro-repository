@extends('layouts.app')

@section('title', 'Peças / Estoque')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Peças / Estoque</h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('parts.create') }}" class="btn btn-dark">+ Nova Peça</a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nome da Peça</th>
                    <th>Preço de Custo</th>
                    <th>Preço de Venda</th>
                    <th>Margem</th>
                    <th>Qtd. Estoque</th>
                    <th>Garantia Fabricante</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($parts as $part)
                <tr>
                    <td>{{ $part->id }}</td>
                    <td>{{ $part->name }}</td>
                    <td>R$ {{ number_format($part->cost_price, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($part->sale_price, 2, ',', '.') }}</td>
                    <td>
                        
                        @php
                            $margem = (($part->sale_price - $part->cost_price) / $part->cost_price) * 100;
                        @endphp
                        {{ number_format($margem, 1) }}%
                    </td>
                    <td>
                        
                        @if($part->stock_quantity < 5)
                            <span class="badge bg-danger">{{ $part->stock_quantity }}</span>
                        @elseif($part->stock_quantity < 10)
                            <span class="badge bg-warning text-dark">{{ $part->stock_quantity }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $part->stock_quantity }}</span>
                        @endif
                    </td>
                    <td>{{ $part->manufacturer_warranty_months }} meses</td>
                    <td>
                        @if(in_array(session('user_role'), ['manager', 'attendant']))
                        <a href="{{ route('parts.edit', $part->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        @endif
                        @if(session('user_role') === 'manager')
                        <form method="POST" action="{{ route('parts.destroy', $part->id) }}" style="display:inline;"
                              onsubmit="return confirm('Remover esta peça do estoque?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Nenhuma peça cadastrada no estoque.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
