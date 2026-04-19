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
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; background: #f5f7fa; }

        /* ── Header ── */
        .header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 1rem 0; transition: all .3s;
            background: linear-gradient(135deg, rgba(13,148,136,.97) 0%, rgba(22,78,99,.97) 100%);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 12px rgba(0,0,0,.15);
        }
        .nav-wrapper { max-width: 1200px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: .75rem; text-decoration: none; }
        .logo-icon { width: 38px; height: 38px; background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: white; font-size: 1rem; }
        .logo-text { font-size: 1.4rem; font-weight: 700; color: white; letter-spacing: .05em; }
        nav { display: flex; gap: 2.5rem; align-items: center; }
        .nav-link { color: rgba(255,255,255,.85); text-decoration: none; font-weight: 500; font-size: .95rem; transition: color .2s; }
        .nav-link:hover, .nav-link.active { color: #fbbf24; }
        .nav-buttons { display: flex; gap: .75rem; align-items: center; }
        .btn-phone { padding: .45rem 1rem; border-radius: 6px; background: #fbbf24; color: #1a1a1a; font-weight: 700; font-size: .85rem; text-decoration: none; transition: all .2s; }
        .btn-phone:hover { background: #f59e0b; transform: translateY(-1px); }
        .btn-admin { padding: .45rem 1rem; border-radius: 6px; border: 1.5px solid rgba(255,255,255,.5); color: white; font-weight: 600; font-size: .85rem; text-decoration: none; transition: all .2s; }
        .btn-admin:hover { background: rgba(255,255,255,.15); }

        /* ── Hero Banner ── */
        .page-hero {
            background: linear-gradient(135deg, #0d4a4a 0%, #164e63 50%, #1e3a5f 100%), url('/Fondo.png') center/cover no-repeat;
            background-blend-mode: multiply;
            padding: 8rem 2rem 5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute; inset: 0;
            background: url('/Fondo.png') center/cover no-repeat;
            opacity: .06;
        }
        .page-hero-inner { position: relative; max-width: 720px; margin: 0 auto; }
        .page-hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18);
            backdrop-filter: blur(8px); padding: .4rem 1rem; border-radius: 20px;
            color: #5eead4; font-size: .75rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            margin-bottom: 1.5rem;
        }
        .page-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem; font-weight: 800; color: white; line-height: 1.2;
            margin-bottom: 1rem; letter-spacing: -.5px;
        }
        .page-hero p { font-size: 1.05rem; color: rgba(255,255,255,.72); font-weight: 300; max-width: 560px; margin: 0 auto; line-height: 1.8; }
        .hero-deco { display: flex; justify-content: center; gap: .4rem; margin-bottom: 1.75rem; }
        .hero-deco span { border-radius: 2px; }

        /* ── Page Body ── */
        .page-body { max-width: 1000px; margin: 0 auto; padding: 3.5rem 1.5rem 5rem; }

        /* ── Cards ── */
        .card {
            background: white; border-radius: .875rem; border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0,0,0,.06); padding: 2.5rem; margin-bottom: 1.75rem;
        }
        .card-dark {
            background: linear-gradient(135deg, #0d4a4a 0%, #164e63 100%);
            border: none; color: white;
        }
        .card-header {
            display: flex; align-items: center; gap: .875rem;
            margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;
        }
        .card-dark .card-header { border-bottom-color: rgba(255,255,255,.12); }
        .card-icon {
            width: 40px; height: 40px; background: linear-gradient(135deg, #0d9488, #0891b2);
            border-radius: .5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .card-icon i { color: white; font-size: .9rem; }
        .card-dark .card-icon { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); }
        .card-dark .card-icon i { color: #5eead4; }
        .card-header h2 {
            font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700;
            color: #164e63;
        }
        .card-dark .card-header h2 { color: white; }
        .card p { font-size: .95rem; color: #4b5563; line-height: 1.9; margin-bottom: .875rem; }
        .card p:last-child { margin-bottom: 0; }
        .card-dark p { color: rgba(255,255,255,.78); }

        /* ── Two Column Grid ── */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.75rem; }
        @media (max-width: 640px) { .grid-2 { grid-template-columns: 1fr; } }
        .col-card { border-radius: .875rem; padding: 2rem; border: 1px solid #e2e8f0; }
        .col-card-light { background: white; }
        .col-card-dark { background: linear-gradient(135deg, #0d4a4a, #164e63); color: white; border: none; }
        .col-card-header { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.25rem; }
        .col-icon { width: 36px; height: 36px; border-radius: .5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .col-icon-light { background: linear-gradient(135deg, #0d9488, #0891b2); }
        .col-icon-dark { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); }
        .col-icon i { color: white; font-size: .8rem; }
        .col-icon-dark i { color: #5eead4; }
        .col-card-header h3 { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: #164e63; }
        .col-card-dark .col-card-header h3 { color: white; }
        .col-card p { font-size: .875rem; color: #4b5563; line-height: 1.85; }
        .col-card-dark p { color: rgba(255,255,255,.8); }
        .obj-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .75rem; }
        .obj-list li { display: flex; gap: .75rem; align-items: flex-start; font-size: .875rem; color: rgba(255,255,255,.82); line-height: 1.65; }
        .obj-list li i { color: #5eead4; margin-top: .2rem; flex-shrink: 0; font-size: .65rem; }

        /* ── Specific Objetivos Grid ── */
        .objectives-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .875rem; }
        @media (max-width: 640px) { .objectives-grid { grid-template-columns: 1fr; } }
        .obj-item {
            display: flex; gap: .75rem; align-items: flex-start;
            padding: .875rem; background: #f0f9ff; border-radius: .5rem; border: 1px solid #bae6fd;
        }
        .obj-item i { color: #0d9488; margin-top: .15rem; flex-shrink: 0; }
        .obj-item span { font-size: .875rem; color: #374151; line-height: 1.6; }

        /* ── Values Grid ── */
        .values-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; }
        .value-card {
            text-align: center; padding: 1.5rem .75rem; border-radius: .625rem;
            border: 1px solid #e2e8f0; cursor: default; transition: all .25s;
        }
        .value-card:hover { background: linear-gradient(135deg, #0d4a4a, #164e63); border-color: transparent; }
        .value-card:hover .value-icon { color: #5eead4; }
        .value-card:hover .value-name { color: white; }
        .value-icon { font-size: 1.75rem; color: #0d9488; margin-bottom: .75rem; display: block; transition: color .25s; }
        .value-name { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: #374151; transition: color .25s; }

        /* ── Beneficiaries ── */
        .ben-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: .75rem; }
        .ben-item {
            display: flex; gap: .75rem; align-items: flex-start;
            padding: .875rem; background: #f0fdf4; border-radius: .5rem; border: 1px solid #bbf7d0;
        }
        .ben-item i { color: #059669; margin-top: .15rem; flex-shrink: 0; }
        .ben-item span { font-size: .875rem; color: #374151; line-height: 1.5; }

        /* ── Contact block ── */
        .contact-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.25rem; }
        .contact-item { display: flex; gap: 1rem; align-items: flex-start; }
        .contact-icon {
            width: 44px; height: 44px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18);
            border-radius: .5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .contact-icon i { color: #5eead4; }
        .contact-label { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: rgba(255,255,255,.45); margin-bottom: .25rem; }
        .contact-value { font-size: .9rem; color: rgba(255,255,255,.85); line-height: 1.6; }

        /* ── Footer ── */
        .footer { background: linear-gradient(135deg, #164e63 0%, #0d4a4a 100%); color: white; padding: 3rem 2rem 2rem; }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2.5rem; margin-bottom: 2.5rem; }
        .footer-col h3 { font-family: 'Playfair Display', serif; font-size: 1.3rem; margin-bottom: .875rem; }
        .footer-col p { font-size: .9rem; color: rgba(255,255,255,.75); line-height: 1.8; }
        .footer-links { display: flex; flex-direction: column; gap: .6rem; }
        .footer-link { color: rgba(255,255,255,.75); text-decoration: none; font-size: .9rem; transition: all .2s; display: flex; align-items: center; gap: .4rem; }
        .footer-link:hover { color: #fbbf24; transform: translateX(4px); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding-top: 1.5rem; text-align: center; font-size: .85rem; color: rgba(255,255,255,.55); }

        @media (max-width: 768px) {
            .page-hero h1 { font-size: 2rem; }
            nav .nav-link { display: none; }
            .card { padding: 1.5rem; }
        }
    </style>
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
                    <p class="contact-value" style="font-style:italic;font-size:.85rem;">"Ama Llulla, Ama Quella, Ama Sua"</p>
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
