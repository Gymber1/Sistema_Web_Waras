<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de WARAS — Asociación Waras</title>
    <link rel="icon" type="image/png" href="/Logo-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/nosotros.css')
</head>
<body>

<!-- ── Header ── -->
<header class="header">
    <div class="nav-wrapper">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">W</div>
            <span class="logo-text">WARAS</span>
        </a>
        <nav>
            <a href="{{ route('home') }}" class="nav-link">Inicio</a>
            <a href="{{ route('home') }}#servicios" class="nav-link">Servicios</a>
            <a href="{{ route('nosotros') }}" class="nav-link active">Acerca de</a>
            <a href="{{ route('contacto') }}" class="nav-link">Contacto</a>
            <div class="nav-buttons">
                <a href="tel:+51952845942" class="btn-phone">+51 952-845-942</a>
                @if(auth()->check() && (auth()->user()->is_admin_global || auth()->user()->modules()->exists()))
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin">Panel</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-admin" style="cursor:pointer;background:none;font-family:inherit;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-admin">Ingresar</a>
                @endif
            </div>
        </nav>
    </div>
</header>

<!-- ── Hero ── -->
<section class="page-hero">
    <div class="page-hero-inner">
        <div class="hero-deco">
            <span style="width:10px;height:28px;background:#60a5fa;display:block;"></span>
            <span style="width:10px;height:22px;background:#f87171;display:block;margin-top:6px;"></span>
            <span style="width:10px;height:16px;background:#fbbf24;display:block;margin-top:12px;"></span>
        </div>
        <div class="page-hero-badge">
            <i class="fas fa-landmark" style="font-size:.7rem;"></i>
            Acerca de Nosotros
        </div>
        <h1>Asociación Waras<br><span style="font-weight:400;font-style:italic;font-size:.85em;">Ciencia y Cultura</span></h1>
        <p>Un grupo de ciudadanos comprometidos con el desarrollo económico, social, científico y cultural del Departamento de Áncash.</p>
    </div>
</section>

<!-- ── Body ── -->
<div class="page-body">

    <!-- Quiénes Somos -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-landmark"></i></div>
            <h2>Quiénes Somos</h2>
        </div>
        <p>La <strong style="color:#164e63;">Asociación Waras: Ciencia y Cultura</strong> nació ante el vacío estructural e histórico del Estado en la protección de la identidad cultural. Un grupo de ciudadanos conscientes de que la protección del Medio Ambiente, la Educación, la Cultura y la Investigación son el germen para un sólido Desarrollo Económico y Social decidió aportar para viabilizar el progreso sostenido de Áncash.</p>
        <p>Áncash es una región privilegiada, con una profunda tradición cultural que subsiste a través del tiempo y una diversidad de recursos naturales únicos. Este portal digital es uno de los espacios que construimos para sistematizar, preservar y difundir el conocimiento y la cultura ancashina.</p>
    </div>

    <!-- Finalidad + Objetivos Generales -->
    <div class="grid-2">
        <div class="col-card col-card-light">
            <div class="col-card-header">
                <div class="col-icon col-icon-light"><i class="fas fa-bullseye"></i></div>
                <h3>Finalidad</h3>
            </div>
            <p>Promover estudios, investigaciones, capacitaciones y espacios que aporten al desarrollo económico, social, ambiental, cultural y científico del Departamento de Áncash para la mejora de la calidad de vida de sus ciudadanos.</p>
        </div>
        <div class="col-card col-card-dark">
            <div class="col-card-header">
                <div class="col-icon col-icon-dark"><i class="fas fa-flag"></i></div>
                <h3>Objetivos Generales</h3>
            </div>
            <ul class="obj-list">
                <li><i class="fas fa-chevron-right"></i>Contribuir al Desarrollo Económico y Social del Departamento de Ancash.</li>
                <li><i class="fas fa-chevron-right"></i>Preservar y Difundir la Cultura Ancashina.</li>
            </ul>
        </div>
    </div>

    <!-- Objetivos Específicos -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-list-check"></i></div>
            <h2>Objetivos Específicos</h2>
        </div>
        <div class="objectives-grid">
            @foreach([
                'Promover e impulsar las ciencias, arte, identidad y cultura en Áncash.',
                'Fomentar la investigación y capacitación educativa, artística y cultural.',
                'Ejecutar proyectos que desarrollen capacidades científicas y tecnológicas.',
                'Desarrollar alianzas con instituciones públicas y privadas a todo nivel.',
                'Promover la ciudadanía activa y la participación cívica.',
                'Impulsar iniciativas que contribuyan al desarrollo sostenible de Áncash.',
                'Promover la educación comunitaria en toda la región.',
                'Desarrollar un portal para la difusión de la ciencia y cultura ancashina.',
            ] as $obj)
            <div class="obj-item">
                <i class="fas fa-check-circle"></i>
                <span>{{ $obj }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Valores -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-heart"></i></div>
            <h2>Nuestros Valores</h2>
        </div>
        <div class="values-grid">
            @foreach([
                ['fa-balance-scale','Equidad'],
                ['fa-hands-helping','Fraternidad'],
                ['fa-hand-holding-heart','Solidaridad'],
                ['fa-leaf','Armonía'],
                ['fa-dove','Libertad'],
            ] as [$icon, $valor])
            <div class="value-card">
                <i class="fas {{ $icon }} value-icon"></i>
                <span class="value-name">{{ $valor }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Beneficiarios -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-users"></i></div>
            <h2>Beneficiarios</h2>
        </div>
        <div class="ben-grid">
            @foreach([
                'Estudiantes de primaria y secundaria de Áncash',
                'Estudiantes de nivel superior de Áncash',
                'Docentes de nivel básico y superior',
                'Autoridades, partidos políticos y sociedad civil',
                'Empresarios e inversores regionales y nacionales',
                'Turistas nacionales e internacionales',
                'Población con interés en la ciencia y cultura ancashina',
            ] as $ben)
            <div class="ben-item">
                <i class="fas fa-check-circle"></i>
                <span>{{ $ben }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Contacto -->
    <div class="card card-dark">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-envelope"></i></div>
            <h2>Contáctanos</h2>
        </div>
        <div class="contact-grid">
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <p class="contact-label">Ubicación</p>
                    <p class="contact-value">Esq. Av. Luzuriaga con Av. 28 de Julio<br>Huaraz, Áncash, Perú</p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-phone"></i></div>
                <div>
                    <p class="contact-label">Teléfono</p>
                    <p class="contact-value">952 845 942</p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <p class="contact-label">Correo Electrónico</p>
                    <p class="contact-value">giber.garcia@pcca.org</p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-quote-left"></i></div>
                <div>
                    <p class="contact-label">Principios Incas</p>
                    <p class="contact-value" style="font-style:italic;font-size:.85rem;line-height:1.8;">"Ama Llulla"<br>"Ama Quella"<br>"Ama Sua"</p>
                </div>
            </div>
        </div>
        <div style="margin-top:1.75rem;padding-top:1.25rem;border-top:1px solid rgba(255,255,255,.12);text-align:center;">
            <a href="{{ route('contacto') }}" style="display:inline-flex;align-items:center;gap:.6rem;background:#0d9488;color:white;padding:.75rem 2rem;border-radius:.5rem;font-weight:700;font-size:.9rem;text-decoration:none;transition:all .2s;">
                <i class="fas fa-paper-plane"></i>
                Envíanos un mensaje
            </a>
        </div>
    </div>

</div>

<!-- ── Footer ── -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>WARAS</h3>
                <p>Portal integrado de acceso a colecciones de ciencia, cultura y patrimonio. Preservando la memoria de nuestra región.</p>
            </div>
            <div class="footer-col">
                <h3>Explorar</h3>
                <div class="footer-links">
                    <a href="{{ route('home') }}#servicios" class="footer-link"><i class="fas fa-chevron-right" style="font-size:.65rem;"></i> Servicios</a>
                    <a href="{{ route('nosotros') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:.65rem;"></i> Acerca de</a>
                    <a href="{{ route('contacto') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:.65rem;"></i> Contacto</a>
                    <a href="/biblioteca" class="footer-link"><i class="fas fa-chevron-right" style="font-size:.65rem;"></i> Biblioteca</a>
                    <a href="/fototeca" class="footer-link"><i class="fas fa-chevron-right" style="font-size:.65rem;"></i> Fototeca</a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Contacto</h3>
                <div class="footer-links">
                    <a href="tel:+51952845942" class="footer-link"><i class="fas fa-phone" style="font-size:.75rem;"></i> +51 952-845-942</a>
                    <a href="mailto:giber.garcia@pcca.org" class="footer-link"><i class="fas fa-envelope" style="font-size:.75rem;"></i> giber.garcia@pcca.org</a>
                    <a href="#" class="footer-link"><i class="fas fa-map-marker-alt" style="font-size:.75rem;"></i> Huaraz, Áncash, Perú</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">&copy; 2024 WARAS — Asociación de Ciencia y Cultura Ancashina. Todos los derechos reservados.</div>
    </div>
</footer>
    <x-floating-buttons />
</body>
</html>
