<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Panel-Waras.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            padding: 3rem 2rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: #666;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        .login-btn {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .success-message {
            background: #efe;
            border: 1px solid #cfc;
            color: #3c3;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #666;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #ccc;
        }

        .divider span {
            background: white;
            padding: 0 0.5rem;
        }

        .demo-credentials {
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: 0.85rem;
        }

        .demo-credentials-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.75rem;
        }

        .demo-credential {
            margin-bottom: 0.5rem;
            color: #666;
        }

        .demo-credential strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">WARAS</div>
            <div class="login-title">Portal Cultural</div>
            <div class="login-subtitle">Sistema de Gestión Integrado</div>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <strong>Credenciales inválidas</strong><br>
                Usuario o contraseña incorrectos. Intenta de nuevo.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-input" 
                    placeholder="tu@email.com"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="••••••••"
                    required
                >
            </div>

            <button type="submit" class="login-btn">Iniciar Sesión</button>
        </form>

        <div class="demo-credentials">
            <div class="demo-credentials-title">📋 Credenciales de Prueba</div>
            <div class="demo-credential">
                <strong>Admin:</strong> admin@waras.local / Admin@2025
            </div>
            <div class="demo-credential">
                <strong>Biblioteca:</strong> biblioteca@waras.local / Biblioteca@2025
            </div>
            <div class="demo-credential">
                <strong>Fototeca:</strong> fototeca@waras.local / Fototeca@2025
            </div>
        </div>

        <div class="login-footer">
            © 2025 WARAS. Portal de Gestión Cultural
        </div>
    </div>
</body>
</html>
