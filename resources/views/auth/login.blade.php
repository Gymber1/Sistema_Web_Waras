<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Panel-Waras.png">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Fondo inmersivo */
        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .bg-overlay {
            position: fixed;
            inset: 0;
            z-index: 1;
            background: rgba(11, 17, 32, 0.78);
            backdrop-filter: blur(2px);
        }

        /* Wrapper central */
        .wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            animation: fadeIn .45s ease both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(.97) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* Logo */
        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }
        .logo-bars {
            display: flex;
            align-items: flex-end;
            gap: 5px;
            margin-bottom: .75rem;
        }
        .bar { width: 10px; border-radius: 3px; }
        .bar-1 { height: 28px; background: #60a5fa; }
        .bar-2 { height: 34px; background: #f87171; }
        .bar-3 { height: 40px; background: #f59e0b; }
        .logo-name {
            font-size: 2.4rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: .18em;
            margin-left: .5rem;
            line-height: 1;
        }
        .logo-row {
            display: flex;
            align-items: center;
            gap: .25rem;
        }
        .logo-sub {
            font-size: .75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .3em;
            margin-top: .25rem;
        }

        /* Card glassmorphism */
        .card {
            background: rgba(255,255,255,.09);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.16);
            border-radius: 2rem;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 32px 64px rgba(0,0,0,.55);
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 120px;
            background: linear-gradient(to bottom, rgba(255,255,255,.06), transparent);
            pointer-events: none;
        }

        .card-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: #fff;
            text-align: center;
            margin-bottom: .5rem;
        }
        .card-sub {
            font-size: .85rem;
            color: #94a3b8;
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Alerta de error */
        .alert-error {
            background: rgba(239,68,68,.15);
            border: 1px solid rgba(239,68,68,.35);
            color: #fca5a5;
            border-radius: .75rem;
            padding: .75rem 1rem;
            font-size: .85rem;
            margin-bottom: 1.5rem;
        }

        /* Campos */
        .field { margin-bottom: 1.25rem; }
        .field-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: .5rem;
        }
        .field-label {
            font-size: .7rem;
            font-weight: 700;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: .1em;
        }
        .forgot-link {
            font-size: .75rem;
            font-weight: 600;
            color: #818cf8;
            text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: #a5b4fc; }

        .input-wrap {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
            transition: color .2s;
            width: 18px; height: 18px;
        }
        .field-input {
            width: 100%;
            padding: .875rem 1rem .875rem 2.75rem;
            background: rgba(0,0,0,.22);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: .75rem;
            color: #fff;
            font-size: .95rem;
            font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .field-input::placeholder { color: #475569; }
        .field-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99,102,241,.25);
        }
        .field-input:focus + .input-icon,
        .input-wrap:focus-within .input-icon { color: #818cf8; }

        .pwd-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            padding: 0;
            transition: color .2s;
            line-height: 0;
        }
        .pwd-toggle:hover { color: #fff; }

        /* Botón submit */
        .btn-submit {
            width: 100%;
            padding: .95rem 1.5rem;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: .75rem;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            margin-top: 1.75rem;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 8px 24px rgba(79,70,229,.35);
        }
        .btn-submit:hover {
            background: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(79,70,229,.45);
        }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit svg { width: 18px; height: 18px; }
        .btn-chevron { opacity: .55; width: 16px !important; height: 16px !important; }

        /* Spinner */
        .spinner {
            display: none;
            width: 20px; height: 20px;
            border: 2px solid rgba(255,255,255,.25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-submit.loading .btn-inner { display: none; }
        .btn-submit.loading .spinner { display: block; }

        /* Footer */
        .login-footer {
            text-align: center;
            color: #475569;
            font-size: .75rem;
            font-weight: 500;
            letter-spacing: .05em;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="bg-layer"></div>
    <div class="bg-overlay"></div>

    <div class="wrapper">
        <!-- Logo -->
        <div class="logo-area">
            <div class="logo-row">
                <div class="logo-bars">
                    <div class="bar bar-1"></div>
                    <div class="bar bar-2"></div>
                    <div class="bar bar-3"></div>
                </div>
                <span class="logo-name">WARAS</span>
            </div>
            <span class="logo-sub">Portal Cultural</span>
        </div>

        <!-- Card -->
        <div class="card">
            <h1 class="card-title">Bienvenido de nuevo</h1>
            <p class="card-sub">Ingrese sus credenciales para acceder al<br>sistema de gestión integrado.</p>

            @if($errors->any())
            <div class="alert-error">
                <strong>Credenciales inválidas.</strong> Usuario o contraseña incorrectos.
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="field">
                    <div class="field-header">
                        <label class="field-label" for="email">Correo Electrónico</label>
                    </div>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" id="email" name="email" class="field-input"
                               placeholder="ejemplo@ejemplo.com"
                               value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>

                <!-- Password -->
                <div class="field">
                    <div class="field-header">
                        <label class="field-label" for="password">Contraseña</label>
                        <a href="#" class="forgot-link">¿Olvidó su clave?</a>
                    </div>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" id="password" name="password" class="field-input"
                               placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="pwd-toggle" id="pwdToggle" onclick="togglePwd()">
                            <svg id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <div class="spinner"></div>
                    <span class="btn-inner" style="display:flex;align-items:center;gap:.5rem;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Iniciar Sesión
                        <svg class="btn-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        <p class="login-footer">&copy; 2026 WARAS. Todos los derechos reservados.</p>
    </div>

    <script>
        function togglePwd() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eyeIcon');
            const show  = input.type === 'password';
            input.type  = show ? 'text' : 'password';
            icon.innerHTML = show
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>
