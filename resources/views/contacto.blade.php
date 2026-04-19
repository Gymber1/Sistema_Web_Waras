<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto — WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; min-height: 100vh; }

        /* ── Immersive Background ── */
        .bg-layer {
            position: fixed; inset: 0; z-index: 0;
            background: url('/Fondo.png') center/cover no-repeat;
        }
        .bg-overlay {
            position: absolute; inset: 0;
            background: rgba(6, 30, 36, 0.82);
            backdrop-filter: blur(2px);
        }

        /* ── Header ── */
        .header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 1.25rem 0;
        }
        .nav-wrapper { max-width: 1200px; margin: 0 auto; padding: 0 3rem; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: .75rem; text-decoration: none; }
        .logo-bars { display: flex; gap: 3px; align-items: flex-end; }
        .logo-bar { width: 5px; border-radius: 2px; }
        .logo-text { font-size: 1.3rem; font-weight: 800; color: white; letter-spacing: .18em; }
        nav { display: flex; gap: 2.5rem; align-items: center; }
        .nav-link { color: rgba(255,255,255,.8); text-decoration: none; font-size: .875rem; font-weight: 500; transition: color .2s; }
        .nav-link:hover { color: white; }
        .nav-link.active { color: white; border-bottom: 2px solid #fbbf24; padding-bottom: 2px; }
        .nav-buttons { display: flex; gap: .75rem; align-items: center; }
        .btn-yellow {
            background: #fbbf24; color: #1a1a1a; padding: .5rem 1.125rem;
            border-radius: .5rem; font-size: .85rem; font-weight: 700;
            text-decoration: none; transition: all .2s; white-space: nowrap;
        }
        .btn-yellow:hover { background: #f59e0b; transform: translateY(-1px); }
        .btn-outline {
            border: 1.5px solid rgba(255,255,255,.35); color: white; padding: .5rem 1.125rem;
            border-radius: .5rem; font-size: .85rem; font-weight: 600; text-decoration: none;
            backdrop-filter: blur(4px); transition: all .2s; background: transparent; cursor: pointer;
            font-family: inherit;
        }
        .btn-outline:hover { background: rgba(255,255,255,.12); }

        /* ── Main Content ── */
        .main {
            position: relative; z-index: 10;
            min-height: 100vh;
            max-width: 1200px; margin: 0 auto;
            padding: 7rem 3rem 4rem;
            display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
        }
        @media (max-width: 900px) {
            .main { grid-template-columns: 1fr; gap: 3rem; padding: 7rem 1.5rem 4rem; }
            .col-right { order: -1; }
        }

        /* ── Left Column ── */
        .contact-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.15);
            backdrop-filter: blur(8px); padding: .4rem 1rem; border-radius: 20px;
            color: #5eead4; font-size: .7rem; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; margin-bottom: 1.5rem;
        }
        .contact-badge i { font-size: .65rem; }
        .col-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.75rem; font-weight: 800; color: white; line-height: 1.25;
            margin-bottom: 1.25rem; letter-spacing: -.5px;
        }
        .col-left h1 span { color: #5eead4; font-weight: 400; font-style: italic; }
        .col-left > p { font-size: 1rem; color: rgba(255,255,255,.68); line-height: 1.85; margin-bottom: 2.25rem; font-weight: 300; max-width: 440px; }

        /* ── Contact Info Cards ── */
        .info-cards { display: flex; flex-direction: column; gap: 1rem; }
        .info-card {
            display: flex; align-items: flex-start; gap: 1rem; padding: 1.125rem 1.25rem;
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
            border-radius: 1rem; backdrop-filter: blur(4px); transition: background .2s; cursor: default;
        }
        .info-card:hover { background: rgba(255,255,255,.11); }
        .info-card-icon {
            width: 48px; height: 48px; border-radius: .75rem; flex-shrink: 0;
            background: rgba(94,234,212,.15); border: 1px solid rgba(94,234,212,.2);
            display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        .info-card:hover .info-card-icon { background: #0d9488; border-color: #0d9488; }
        .info-card-icon i { color: #5eead4; font-size: 1.1rem; transition: color .2s; }
        .info-card:hover .info-card-icon i { color: white; }
        .info-card-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.45); margin-bottom: .25rem; }
        .info-card-value { font-size: .9rem; color: rgba(255,255,255,.82); line-height: 1.55; }

        /* ── Right Column: Form ── */
        .glass-card {
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 50px rgba(0,0,0,.45);
            position: relative; overflow: hidden;
        }
        .glass-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 50%;
            background: linear-gradient(to bottom, rgba(255,255,255,.08), transparent);
            pointer-events: none;
        }
        .glass-card h2 { font-size: 1.4rem; font-weight: 700; color: white; margin-bottom: .375rem; position: relative; }
        .glass-card > p { font-size: .875rem; color: rgba(255,255,255,.55); margin-bottom: 2rem; position: relative; }

        .form-group { margin-bottom: 1.375rem; position: relative; }
        .form-label { display: block; font-size: .7rem; font-weight: 700; color: rgba(255,255,255,.75); text-transform: uppercase; letter-spacing: .1em; margin-bottom: .5rem; margin-left: .25rem; }
        .form-input {
            width: 100%; padding: .875rem 1.125rem;
            background: rgba(0,0,0,.22); border: 1px solid rgba(255,255,255,.1); border-radius: .75rem;
            color: white; font-family: inherit; font-size: .9rem;
            transition: border-color .2s, box-shadow .2s; outline: none;
        }
        .form-input::placeholder { color: rgba(255,255,255,.28); }
        .form-input:focus { border-color: #5eead4; box-shadow: 0 0 0 2px rgba(94,234,212,.18); }
        textarea.form-input { resize: none; }

        .btn-submit {
            width: 100%; background: #0d9488; color: white;
            padding: 1rem; border-radius: .75rem; border: none;
            font-family: inherit; font-size: .95rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center; gap: .625rem;
            cursor: pointer; transition: all .25s;
            box-shadow: 0 4px 15px rgba(13,148,136,.3);
        }
        .btn-submit:hover { background: #0f766e; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(13,148,136,.4); }
        .btn-submit i { transition: transform .25s; }
        .btn-submit:hover i { transform: translate(3px, -3px); }

        /* ── Scroll indicator ── */
        .scroll-hint {
            position: fixed; bottom: 1.75rem; left: 50%; transform: translateX(-50%);
            z-index: 20; animation: bounce 2s infinite;
        }
        .scroll-hint i { color: rgba(255,255,255,.4); font-size: 1.2rem; }
        @keyframes bounce {
            0%,100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(8px); }
        }

        @media (max-width: 768px) {
            .col-left h1 { font-size: 2rem; }
            nav .nav-link { display: none; }
            .glass-card { padding: 1.75rem; }
        }
    </style>
</head>
<body>

<!-- ── Background ── -->
<div class="bg-layer">
    <div class="bg-overlay"></div>
</div>

<!-- ── Header ── -->
<header class="header">
    <div class="nav-wrapper">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-bars">
                <div class="logo-bar" style="height:16px;background:#5eead4;"></div>
                <div class="logo-bar" style="height:20px;background:#0d9488;"></div>
                <div class="logo-bar" style="height:24px;background:#0f766e;"></div>
            </div>
            <span class="logo-text">WARAS</span>
        </a>
        <nav>
            <a href="{{ route('home') }}" class="nav-link">Inicio</a>
            <a href="{{ route('home') }}#servicios" class="nav-link">Servicios</a>
            <a href="{{ route('nosotros') }}" class="nav-link">Acerca de</a>
            <a href="{{ route('contacto') }}" class="nav-link active">Contacto</a>
            <div class="nav-buttons">
                <a href="tel:+51952845942" class="btn-yellow">Llamar: +51 952-845-942</a>
                @if(auth()->check() && (auth()->user()->is_admin_global || auth()->user()->modules()->exists()))
                    <a href="{{ route('admin.dashboard') }}" class="btn-outline">Panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline">Ingresar</a>
                @endif
            </div>
        </nav>
    </div>
</header>

<!-- ── Main ── -->
<main class="main">

    <!-- Left: Info -->
    <div class="col-left">
        <div class="contact-badge">
            <i class="fas fa-globe"></i>
            Contacto Directo
        </div>

        <h1>Si está interesado en nuestra labor, <span>póngase en contacto.</span></h1>

        <p>El proceso es simple, solo tiene que llenar el formulario y enviar. También cuenta con información más específica como correos y números telefónicos a continuación.</p>

        <div class="info-cards">
            <!-- Dirección -->
            <div class="info-card">
                <div class="info-card-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <p class="info-card-label">Dirección</p>
                    <p class="info-card-value">Esq. Av. Luzuriaga con Av. 28 de Julio<br>Huaraz, Áncash, Perú</p>
                </div>
            </div>
            <!-- Teléfono + Email -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="info-card" style="grid-column:1">
                    <div class="info-card-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <p class="info-card-label">Teléfonos</p>
                        <p class="info-card-value">952 845 942</p>
                    </div>
                </div>
                <div class="info-card" style="grid-column:2">
                    <div class="info-card-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <p class="info-card-label">Email</p>
                        <p class="info-card-value" style="word-break:break-all;">giber.garcia@pcca.org</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Glassmorphism Form -->
    <div class="col-right">
        <div class="glass-card">
            <h2>Envíenos un mensaje</h2>
            <p>Responderemos lo más pronto posible.</p>

            <form id="contactForm">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="nombres">Nombres Completos</label>
                    <input type="text" id="nombres" name="nombres" required placeholder="Ej. Juan Pérez" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required placeholder="ejemplo@correo.com" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label" for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" required rows="4" placeholder="Escriba su consulta o comentario aquí..." class="form-input"></textarea>
                </div>
                <button type="submit" class="btn-submit">
                    <span>Enviar Mensaje</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

</main>

<!-- Scroll hint -->
<div class="scroll-hint">
    <i class="fas fa-chevron-down"></i>
</div>

<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.btn-submit');
        btn.innerHTML = '<i class="fas fa-check"></i> <span>¡Mensaje enviado!</span>';
        btn.style.background = '#059669';
        setTimeout(() => {
            btn.innerHTML = '<span>Enviar Mensaje</span><i class="fas fa-paper-plane"></i>';
            btn.style.background = '';
            this.reset();
        }, 3000);
    });
</script>
</body>
</html>
