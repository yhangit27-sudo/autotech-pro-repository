<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTech Pro - <?php echo $__env->yieldContent('title', 'Sistema de Oficina'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --preto-principal: #0A0A0A;
            --preto-secundario: #141414;
            --vermelho-principal: #C40000;
            --vermelho-claro: #FF1A1A;
            --branco: #FFFFFF;
            --cinza-medio: #A6A6A6;
        }

        body { 
            background-color: var(--preto-principal); 
            color: var(--branco);
        }
        .text-muted {
            color: var(--cinza-medio) !important;
        }
        .sidebar, .offcanvas { 
            background-color: var(--preto-secundario); 
        }
        .offcanvas {
            color: var(--branco);
        }
        .sidebar a, .offcanvas a { 
            color: var(--cinza-medio); 
            text-decoration: none; 
            display: block; 
            padding: 10px 15px; 
            margin: 2px 10px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .sidebar a:hover, .offcanvas a:hover { 
            background-color: var(--vermelho-principal); 
            color: var(--branco); 
        }
        .sidebar .nav-section, .offcanvas .nav-section { 
            color: var(--cinza-medio); 
            font-size: 11px; 
            text-transform: uppercase; 
            padding: 20px 15px 5px; 
            display: block;
        }
        .main-content { 
            padding: 20px; 
        }
        .border-secondary {
            border-color: #2a2a2a !important;
        }
        .btn-sair {
            color: var(--vermelho-claro) !important;
        }
        .btn-sair:hover {
            background-color: rgba(255, 26, 26, 0.1) !important;
            color: var(--vermelho-claro) !important;
        }
        /* Botão de menu mobile */
        .navbar-toggler {
            border-color: var(--cinza-medio);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.75)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>

<nav class="navbar d-md-none bg-dark border-bottom border-secondary px-3 py-2">
    <div class="container-fluid">
        <span class="navbar-brand text-white">AutoTech Pro</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title text-white" id="offcanvasMenuLabel">AutoTech Pro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="p-3 border-bottom border-secondary">
            <h6 class="text-white mb-0">Olá, <?php echo e(session('user_name')); ?></h6>
            <small class="text-muted">
                <?php switch(session('user_role')):
                    case ('manager'): ?> <span class="badge bg-dark">Gerente</span> <?php break; ?>
                    <?php case ('attendant'): ?> <span class="badge bg-secondary">Atendente</span> <?php break; ?>
                    <?php case ('mechanic'): ?> <span class="badge bg-secondary">Mecânico</span> <?php break; ?>
                    <?php case ('customer'): ?> <span class="badge bg-secondary">Cliente</span> <?php break; ?>
                <?php endswitch; ?>
            </small>
        </div>

        <nav class="mt-2">
            <span class="nav-section">Principal</span>
            <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('dashboard')); ?>"> 
                <i data-lucide="layout-dashboard" class="size-4"></i>
                Dashboard
            </a>

            <span class="nav-section">Operacional</span>
            <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('orders.index')); ?>">
                <i data-lucide="wrench" class="size-4"></i> 
                Ordens de Serviço
            </a>
            <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('vehicles.index')); ?>">
                <i data-lucide="car" class="size-4"></i> 
                Veículos
            </a>

            <?php if(in_array(session('user_role'), ['mechanic', 'attendant', 'manager'])): ?>
                <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('fipe.index')); ?>">
                    <i data-lucide="search-code" class="size-4"></i> 
                    Consulta FIPE
                </a>
            <?php endif; ?>

            <?php if(session('user_role') !== 'customer'): ?>
                <span class="nav-section mt-3">Estoque</span>
                <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('parts.index')); ?>"> 
                    <i data-lucide="package" class="size-4"></i>
                    Peças / Estoque
                </a>
                <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('services.index')); ?>"> 
                    <i data-lucide="briefcase" class="size-4"></i>
                    Catálogo de Serviços
                </a>
            <?php endif; ?>

            <?php if(session('user_role') === 'manager'): ?>
                <span class="nav-section mt-3">Administração</span>
                <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('users.index')); ?>"> 
                    <i data-lucide="users" class="size-4"></i>
                    Usuários
                </a>
            <?php endif; ?>

            <span class="nav-section mt-3">Conta</span>
            <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form-mobile">
                <?php echo csrf_field(); ?>
                <a href="#" class="nav-link d-flex align-items-center gap-2 btn-sair" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"> 
                    <i data-lucide="log-out" class="size-4"></i>
                    Sair
                </a>
            </form>
        </nav>
    </div>
</div>

<div class="container-fluid p-0">
    <div class="row min-vh-100 g-0">
        
        <div class="col-md-2 sidebar p-0 d-none d-md-block border-end border-secondary">
            <div class="p-3 border-bottom border-secondary">
                <h6 class="text-white mb-0">AutoTech Pro</h6>
                <small class="text-muted">
                    <?php echo e(session('user_name')); ?>

                    <br>
                    <?php switch(session('user_role')):
                        case ('manager'): ?> <span class="badge bg-dark mt-1">Gerente</span> <?php break; ?>
                        <?php case ('attendant'): ?> <span class="badge bg-secondary mt-1">Atendente</span> <?php break; ?>
                        <?php case ('mechanic'): ?> <span class="badge bg-secondary mt-1">Mecânico</span> <?php break; ?>
                        <?php case ('customer'): ?> <span class="badge bg-secondary mt-1">Cliente</span> <?php break; ?>
                    <?php endswitch; ?>
                </small>
            </div>

            <nav class="mt-2">
                <span class="nav-section">Principal</span>
                <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('dashboard')); ?>"> 
                    <i data-lucide="layout-dashboard" class="size-4"></i>
                    Dashboard
                </a>

                <span class="nav-section">Operacional</span>
                <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('orders.index')); ?>">
                    <i data-lucide="wrench" class="size-4"></i> 
                    Ordens de Serviço
                </a>
                <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('vehicles.index')); ?>">
                    <i data-lucide="car" class="size-4"></i> 
                    Veículos
                </a>

                <?php if(in_array(session('user_role'), ['mechanic', 'attendant', 'manager'])): ?>
                    <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('fipe.index')); ?>">
                        <i data-lucide="search-code" class="size-4"></i> 
                        Consulta FIPE
                    </a>
                <?php endif; ?>

                <?php if(session('user_role') !== 'customer'): ?>
                    <span class="nav-section mt-3">Estoque</span>
                    <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('parts.index')); ?>"> 
                        <i data-lucide="package" class="size-4"></i>
                        Peças / Estoque
                    </a>
                    <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('services.index')); ?>"> 
                        <i data-lucide="briefcase" class="size-4"></i>
                        Catálogo de Serviços
                    </a>
                <?php endif; ?>

                <?php if(session('user_role') === 'manager'): ?>
                    <span class="nav-section mt-3">Administração</span>
                    <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('users.index')); ?>"> 
                        <i data-lucide="users" class="size-4"></i>
                        Usuários
                    </a>
                <?php endif; ?>

                <span class="nav-section mt-3">Conta</span>
                <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form-desktop">
                    <?php echo csrf_field(); ?>
                    <a href="#" class="nav-link d-flex align-items-center gap-2 btn-sair" onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();"> 
                        <i data-lucide="log-out" class="size-4"></i>
                        Sair
                    </a>
                </form>
            </nav>
        </div>

        <div class="col-md-10 main-content">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/autotech.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const offcanvasLinks = document.querySelectorAll('#offcanvasMenu a.nav-link:not([onclick])');
    const offcanvasElement = document.getElementById('offcanvasMenu');
    
    if (offcanvasElement) {
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasElement) || new bootstrap.Offcanvas(offcanvasElement);
        
        offcanvasLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                
                offcanvasInstance.hide();
                
                setTimeout(() => {
                    if (href && href !== '#') {
                        window.location.href = href;
                    }
                }, 300);
            });
        });
    }
});
</script>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/layouts/app.blade.php ENDPATH**/ ?>