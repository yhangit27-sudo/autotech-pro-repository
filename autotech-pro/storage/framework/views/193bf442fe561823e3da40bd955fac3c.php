<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AutoTech Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-box { max-width: 400px; margin: 80px auto; }
    </style>
</head>
<body>

<div class="login-box">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
            <h4 class="mb-0">AutoTech Pro</h4>
            <small class="text-muted">Sistema de Gestão de Oficina</small>
        </div>
        <div class="card-body p-4">

            
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            
            
            
            <form method="POST" action="<?php echo e(route('login.post')); ?>">
                
                
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="seu@email.com"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Sua senha"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-dark w-100">
                    Entrar no Sistema
                </button>
            </form>

        </div>
        <div class="card-footer text-muted text-center">
            <small>AutoTech Pro v1.0</small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php  ?>