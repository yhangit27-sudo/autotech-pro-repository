<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AutoTech Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --preto-abs: #050505;
            --vermelho-principal: #e63946;
            --cinza-dark: #121212;
        }

        body { 
            background: radial-gradient(circle at center, #1a1a1a 0%, #050505 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: rgba(18, 18, 18, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-icon {
            background: var(--vermelho-principal);
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 0 20px rgba(230, 57, 70, 0.4);
        }

        .form-label {
            color: #888;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid #2a2a2a !important;
            color: white !important;
            padding: 12px 15px;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: var(--vermelho-principal) !important;
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1) !important;
        }

        .btn-login {
            background: var(--vermelho-principal);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #f14654;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(230, 57, 70, 0.3);
        }

        .input-group-text {
            background: transparent;
            border: 1px solid #2a2a2a;
            border-left: none;
            color: #555;
            cursor: pointer;
        }

        .brand-text { font-weight: 800; font-size: 1.5rem; letter-spacing: -1px; }
        .brand-dot { color: var(--vermelho-principal); }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo-area">
        <div class="logo-icon">
            <i data-lucide="gauge" size="30" color="white"></i>
        </div>
        <div class="brand-text">AUTOTECH<span class="brand-dot">PRO</span></div>
        <p class="text-mauve-600 small">Acelere sua produtividade.</p>
    </div>

    <div class="login-card">
        @if(session('error'))
            <div class="alert alert-danger py-2 small border-0 bg-danger bg-opacity-10 text-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Acesso via E-mail</label>
                <input type="email" class="form-control" id="email" name="email" 
                       placeholder="nome@oficina.com" required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Senha de Segurança</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="••••••••" required>
                    <span class="input-group-text" id="btnTogglePwd">
                        <i data-lucide="eye" id="iconEye" class="size-5"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-login btn-danger w-100">
                Iniciar Sessão
            </button>
        </form>
    </div>

    <p class="text-center mt-4 text-muted small">
        &copy; 2026 AutoTech Pro. Todos os direitos reservados.
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Inicializar ícones
    lucide.createIcons();

    // Lógica do Toggle Password (Simplificada e usando Lucide)
    const pwdInput = document.getElementById('password');
    const btnToggle = document.getElementById('btnTogglePwd');
    const iconEye = document.getElementById('iconEye');

    btnToggle.addEventListener('click', function () {
        const isText = pwdInput.type === 'text';
        pwdInput.type = isText ? 'password' : 'text';
        
        // Trocar ícone via Lucide
        const newIcon = isText ? 'eye' : 'eye-off';
        iconEye.setAttribute('data-lucide', newIcon);
        lucide.createIcons();
        
        pwdInput.focus();
    });
</script>
</body>
</html>