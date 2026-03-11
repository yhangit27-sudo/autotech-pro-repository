<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTech Pro - @yield('title', 'Sistema de Oficina')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 8px 15px; }
        .sidebar a:hover { background-color: #495057; color: #fff; }
        .sidebar .nav-section { color: #6c757d; font-size: 11px; text-transform: uppercase; padding: 15px 15px 5px; }
        .main-content { padding: 20px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <div class="p-3 border-bottom border-secondary">
                <h6 class="text-white mb-0">AutoTech Pro</h6>
                <small class="text-muted">
                    {{ session('user_name') }}
                    <br>
                    @switch(session('user_role'))
                        @case('manager') <span class="badge bg-dark">Gerente</span> @break
                        @case('attendant') <span class="badge bg-secondary">Atendente</span> @break
                        @case('mechanic') <span class="badge bg-secondary">Mecânico</span> @break
                        @case('customer') <span class="badge bg-secondary">Cliente</span> @break
                    @endswitch
                </small>
            </div>

            <nav class="mt-2">
                <span class="nav-section">Principal</span>
                <a href="{{ route('dashboard') }}"><img src="/icons/home.png" alt="Início" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Dashboard</a>

                <span class="nav-section">Operacional</span>
                <a href="{{ route('orders.index') }}"><img src="/icons/clipboard.png" alt="Ordens" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Ordens de Serviço</a>
                <a href="{{ route('vehicles.index') }}"><img src="/icons/car.png" alt="Veículos" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Veículos</a>

                @if(in_array(session('user_role'), ['mechanic', 'attendant', 'manager']))
                    <a href="{{ route('fipe.index') }}"><img src="/icons/money.png" alt="FIPE" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Consulta FIPE</a>
                @endif

                @if(session('user_role') !== 'customer')
                    <span class="nav-section">Estoque</span>
                    <a href="{{ route('parts.index') }}"><img src="/icons/wrench.png" alt="Peças" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Peças / Estoque</a>
                    <a href="{{ route('services.index') }}"><img src="/icons/edit.png" alt="Catálogo" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Catálogo de Serviços</a>
                @endif

                @if(session('user_role') === 'manager')
                    <span class="nav-section">Administração</span>
                    <a href="{{ route('users.index') }}"><img src="/icons/users.png" alt="Usuários" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Usuários</a>
                @endif

                <span class="nav-section">Conta</span>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #ff6b6b;"><img src="/icons/door.png" alt="Sair" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Sair</a>
                </form>
            </nav>
        </div>

        <div class="col-md-10 main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/autotech.js"></script>
@yield('scripts')
</body>
</html>