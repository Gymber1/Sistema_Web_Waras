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
    @vite('resources/css/contacto.css')
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
                <div class="info-card-icon">
                    <img src="{{ $contact_icon_direccion ? asset('storage/' . $contact_icon_direccion) : '/Direccion.png' }}" alt="Dirección" style="width:30px;height:30px;object-fit:contain;">
                </div>
                <div>
                    <p class="info-card-label">Dirección</p>
                    <p class="info-card-value">{!! nl2br(e($contact_direccion)) !!}</p>
                </div>
            </div>
            <!-- Teléfono + Email -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="info-card" style="grid-column:1">
                    <div class="info-card-icon">
                        <img src="{{ $contact_icon_telefono ? asset('storage/' . $contact_icon_telefono) : '/Telefono.png' }}" alt="Teléfonos" style="width:30px;height:30px;object-fit:contain;">
                    </div>
                    <div>
                        <p class="info-card-label">Teléfonos</p>
                        <p class="info-card-value">{{ $contact_telefono }}</p>
                    </div>
                </div>
                <div class="info-card" style="grid-column:2">
                    <div class="info-card-icon">
                        <img src="{{ $contact_icon_email ? asset('storage/' . $contact_icon_email) : '/Email.png' }}" alt="Email" style="width:30px;height:30px;object-fit:contain;">
                    </div>
                    <div>
                        <p class="info-card-label">Email</p>
                        <p class="info-card-value" style="word-break:break-all;">{{ $contact_email }}</p>
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
                    <span>Enviar por WhatsApp</span>
                    <i class="fab fa-whatsapp"></i>
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
    const waNumber = '{{ $whatsapp_number ?? "" }}';

    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!waNumber) {
            // Sin número configurado
            const btn = this.querySelector('.btn-submit');
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>Por el momento no es posible contactar</span>';
            btn.style.background = '#64748b';
            btn.disabled = true;
            setTimeout(() => {
                btn.innerHTML = original;
                btn.style.background = '';
                btn.disabled = false;
            }, 4000);
            return;
        }

        const nombres  = document.getElementById('nombres').value.trim();
        const email    = document.getElementById('email').value.trim();
        const mensaje  = document.getElementById('mensaje').value.trim();

        const texto = `Hola, le escribo desde el portal WARAS EDITORIAL.\n\n*Nombre:* ${nombres}\n*Correo:* ${email}\n\n*Mensaje:*\n${mensaje}`;
        const url   = `https://wa.me/${waNumber}?text=${encodeURIComponent(texto)}`;

        window.open(url, '_blank');

        const btn = this.querySelector('.btn-submit');
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> <span>¡Redirigiendo a WhatsApp!</span>';
        btn.style.background = '#059669';
        setTimeout(() => {
            btn.innerHTML = original;
            btn.style.background = '';
            this.reset();
        }, 3000);
    });
</script>
    <x-floating-buttons />
</body>
</html>
