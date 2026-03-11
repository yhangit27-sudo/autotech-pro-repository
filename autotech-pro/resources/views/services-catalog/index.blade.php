@extends('layouts.app')

@section('title', 'Catálogo de Serviços')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Catálogo de Serviços</h2>
    @if(in_array(session('user_role'), ['manager', 'attendant']))
    <a href="{{ route('services.create') }}" class="btn btn-dark">+ Novo Serviço</a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Descrição do Serviço</th>
                    <th>Valor por Hora (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->description }}</td>
                    <td>R$ {{ number_format($service->hourly_rate, 2, ',', '.') }}/h</td>
                    <td>
                        @if(in_array(session('user_role'), ['manager', 'attendant']))
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        @endif
                        @if(session('user_role') === 'manager')
                        <form method="POST" action="{{ route('services.destroy', $service->id) }}" style="display:inline;"
                              onsubmit="return confirm('Remover este serviço?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Nenhum serviço cadastrado no catálogo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
