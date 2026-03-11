@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Usuários do Sistema</h2>
    <a href="{{ route('users.create') }}" class="btn btn-dark">+ Novo Usuário</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nome Completo</th>
                    <th>E-mail</th>
                    <th>CPF/CNPJ</th>
                    <th>Cargo</th>
                    <th>Cadastrado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->tax_id }}</td>
                    <td>
                        @switch($user->role)
                            @case('manager') <span class="badge bg-dark">Gerente</span> @break
                            @case('attendant') <span class="badge bg-secondary">Atendente</span> @break
                            @case('mechanic') <span class="badge bg-secondary">Mecânico</span> @break
                            @case('customer') <span class="badge bg-light text-dark border">Cliente</span> @break
                        @endswitch
                    </td>
                    <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>

                        
                        @if($user->id != session('user_id'))
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline;"
                              onsubmit="return confirm('Tem certeza que deseja remover este usuário?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Nenhum usuário cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
