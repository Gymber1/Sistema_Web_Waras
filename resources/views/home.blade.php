<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARAS EDITORIAL</title>
    <link rel="icon" type="image/png" href="/Logo-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    @vite('resources/css/home.css')
    <script>history.scrollRestoration = 'manual'; window.scrollTo(0, 0);</script>
</head>
<body>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <button class="mobile-menu-close" onclick="closeMobileMenu()">&#10005;</button>
        <a href="{{ route('home') }}" class="mobile-nav-link" onclick="showView('inicio');closeMobileMenu();return false;">Inicio</a>
        <button onclick="showView('inicio');closeMobileMenu();setTimeout(()=>{document.getElementById('colecciones')?.scrollIntoView({behavior:'smooth'})},50);" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Patrimonio Cultural</button>
        <button onclick="showView('organizacion');closeMobileMenu();" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Organización</button>
        <button onclick="showView('aportantes');closeMobileMenu();" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Aportantes</button>
        <button onclick="closeMobileMenu(); openContactModal();" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Contacto</button>
        @if(auth()->check() && (auth()->user()->is_admin_global || auth()->user()->modules()->exists()))
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-btn">Panel Admin</a>
        @else
            <a href="{{ route('login') }}" class="mobile-nav-btn">Ingresar</a>
        @endif
    </div>

    <!-- Navbar -->
    <header class="header" id="header">
        <div class="nav-wrapper">
            <a href="{{ route('home') }}" class="logo">
                @php $navLogo = \App\Models\SiteSetting::get('nav_logo_portal'); @endphp
                @if($navLogo)
                    <img src="{{ asset('storage/' . $navLogo) }}" alt="Logo" class="logo-icon">
                @endif
                Portal Waras
            </a>
            <nav class="desktop-nav">
                <a href="{{ route('home') }}" class="nav-link" onclick="showView('inicio');return false;">Inicio</a>
                <a href="#colecciones" class="nav-link" onclick="showView('inicio');setTimeout(()=>{document.getElementById('colecciones')?.scrollIntoView({behavior:'smooth'})},50);return false;" style="white-space:nowrap;">Patrimonio Cultural</a>
                <button onclick="showView('organizacion')" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:'Poppins',sans-serif;">Organización</button>
                <button onclick="showView('aportantes')" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:'Poppins',sans-serif;">Aportantes</button>
                <button onclick="openContactModal()" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:'Poppins',sans-serif;">Contacto</button>
                @if(auth()->check() && (auth()->user()->is_admin_global || auth()->user()->modules()->exists()))
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin">Panel Admin</a>
                    <a href="{{ route('logout') }}" class="btn-login"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
                @endif
            </nav>
            <button class="hamburger-btn" onclick="openMobileMenu()" aria-label="Abrir menú">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </header>

    <!-- ===== VISTA: INICIO ===== -->
    <div id="view-inicio" class="page-view">

    <!-- Hero Slider -->
    <section class="hero-section" id="inicio">
        <div class="hero-slide-bg" style="background-image: url('{{ $heroBg }}');"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <p class="hero-eyebrow">{{ \App\Models\SiteSetting::get('hero_portal_eyebrow', 'Asociación de Ciencia y Cultura') }}</p>
            <h1 class="hero-title">{{ \App\Models\SiteSetting::get('hero_portal_title', 'Portal de la Ciencia y la Cultura Ancashina') }}</h1>
            <p class="hero-subtitle">"Descubre nuestras colecciones de libros, fotos, música, artes y eventos históricos que preservan la memoria de nuestra región."</p>
            <a href="#colecciones" class="hero-cta">{{ \App\Models\SiteSetting::get('hero_portal_cta', 'Explorar Servicios') }}</a>
        </div>
        <div class="scroll-indicator">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 9l7 7 7-7"/></svg>
        </div>
    </section>



    <!-- Collections -->
    <section class="collections-section" id="colecciones">
        <div class="section-header">
            <p class="section-eyebrow">Patrimonio Cultural</p>
            <h2 class="section-title">Patrimonio Cultural Ancashino</h2>
        </div>
        <div class="collections-wrapper">
            <div class="collections-carousel-container">
                <div class="collections-carousel" id="collectionsCarousel">
                    <!-- Biblioteca -->
                    <div class="collection-card" data-url="{{ route('biblioteca.dashboard') }}">
                        <img class="collection-img" src="{{ $heroBgBiblioteca }}" alt="Biblioteca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Operativo</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Biblioteca</h3>
                            <p class="collection-type">Acceso Libre</p>
                        </div>
                    </div>
                    <!-- Fototeca -->
                    <div class="collection-card" data-url="{{ route('fototeca.inicio') }}">
                        <img class="collection-img" src="{{ $heroBgFototeca }}" alt="Fototeca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Operativo</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Fototeca</h3>
                            <p class="collection-type">Acceso Libre</p>
                        </div>
                    </div>
                    <!-- Efemérides -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=900&q=80" alt="Efemérides">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Efemérides</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                    <!-- Catálogo KOHA -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=900&q=80" alt="Catálogo KOHA">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Catálogo KOHA</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                    <!-- Musicoteca -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=900&q=80" alt="Musicoteca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Musicoteca</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                    <!-- Pinacoteca -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1578301978162-7aae4d755744?auto=format&fit=crop&w=900&q=80" alt="Pinacoteca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Pinacoteca</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-controls">
                <div class="carousel-controls-row">
                    <button class="carousel-btn" id="prevBtn" onclick="scrollCarousel('prev')">‹</button>
                    <div class="carousel-dots" id="carouselDots"></div>
                    <button class="carousel-btn" id="nextBtn" onclick="scrollCarousel('next')">›</button>
                </div>
            </div>
        </div>
    </section>

    </div><!-- /view-inicio -->

    <!-- ===== VISTA: ORGANIZACIÓN ===== -->
    <div id="view-organizacion" class="page-view" style="display:none;">

    <!-- Hero Banner -->
    <section class="subview-hero">
        <div class="subview-hero-bg" style="background-image:url('{{ $heroBg }}');"></div>
        <div class="subview-hero-overlay"></div>
        <div class="subview-hero-content">
            <h1 class="subview-hero-title">Nuestra Organización</h1>
            <p class="subview-hero-sub">Conoce la misión, visión y los valores que impulsan la preservación del patrimonio regional.</p>
        </div>
    </section>

    <!-- ORGANIZACIÓN: Quiénes Somos -->
    <section class="org-section" id="organizacion">
        <div class="org-inner">
            <div class="org-img-wrap">
                <div class="org-img-shadow"></div>
                <div class="org-img-clip">
                    <img class="org-img"
                         src="/Fundadores.jpg"
                         alt="Fundadores Asociación Waras">
                </div>
                <span class="org-img-label">Fundadores de WARAS</span>
            </div>
            <div>
                <div class="org-eyebrow">
                    <span class="org-eyebrow-text">Quiénes Somos</span>
                </div>
                <h2 class="org-title">Asociación Waras:<br><em>Ciencia y Cultura</em></h2>
                <p class="org-text">La <strong>Asociación Waras: Ciencia y Cultura</strong> nació ante el vacío estructural e histórico del Estado en la protección de la identidad cultural.</p>
                <p class="org-text">Un grupo de ciudadanos conscientes de que la protección del Medio Ambiente, la Educación, la Cultura y la Investigación son el germen para un sólido Desarrollo Económico y Social decidió aportar para viabilizar el progreso sostenido de Áncash.</p>
                <p class="org-text">Áncash es una región privilegiada, con una profunda tradición cultural que subsiste a través del tiempo y una diversidad de recursos naturales únicos. Este portal digital es uno de los espacios que construimos para sistematizar, preservar y difundir el conocimiento.</p>
            </div>
        </div>
    </section>

    <!-- ORGANIZACIÓN: Finalidad + Objetivos -->
    <section class="org-cards-section">
        <div class="org-cards-inner">
            <div class="org-card org-card-light">
                <div class="">
                    <img src="/Nuestra_Finalidad.png" alt="Nuestra Finalidad" style="width:100px;height:50px;object-fit:contain;">
                </div>
                <h3 class="org-card-title">Nuestra Finalidad</h3>
                <p class="org-card-text">Promover estudios, investigaciones, capacitaciones, propuestas y espacios que aporten al desarrollo económico, social, ambiental, cultural, educacional, científico, tecnológico, y ciudadanía en el departamento de Áncash para la mejora de la calidad de vida de sus ciudadanos.</p>
            </div>
            <div class="org-card org-card-dark">
                <div class="">
                    <img src="/Objetivo_General.png" alt="Objetivo General" style="width:100px;height:50px;object-fit:contain;">
                </div>
                <h3 class="org-card-title">Objetivo General</h3>
                <ul class="org-card-list">
                    <li><span class="org-card-list-arrow">›</span> Contribuir al Desarrollo Económico y Social del Departamento de Ancash.</li>
                    <li><span class="org-card-list-arrow">›</span> Preservar y Difundir la Cultura Ancashina al mundo a través de plataformas digitales.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ORGANIZACIÓN: Líneas de trabajo + Beneficiarios -->
    <section class="org-lines-section">
        <div class="org-lines-inner">
            <div class="org-lines-header">
                <h2 class="org-lines-title">Líneas de Trabajo y Alcance</h2>
                <p class="org-lines-sub">Estrategias específicas orientadas a la investigación, desarrollo y preservación del acervo ancashino.</p>
            </div>
            <div class="org-lines-grid">
                <div>
                    <p class="org-lines-col-label">Objetivos Específicos</p>
                    <ul class="org-lines-list">
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Promover e impulsar las ciencias, arte, identidad, ciudadanía y cultura.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Promover la investigación y capacitación educativa, artística y ambiental.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Promover y ejecutar proyectos y programas que desarrollen capacidades científicas.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Lograr el desarrollo de nuestros fines en alianza y convenios con instituciones.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Desarrollar un Sistema y Portal de Información de alcance regional.</li>
                    </ul>
                </div>
                <div>
                    <p class="org-lines-col-label">Nuestros Beneficiarios</p>
                    <div class="org-beneficiaries-grid">
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Estudiantes de primaria y secundaria</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Estudiantes de nivel superior</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Docentes de nivel básico y superior</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Autoridades y partidos políticos</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Empresarios e inversores regionales</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Turistas nacionales e internacionales</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Población con interés en ciencia</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Investigadores culturales</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PREMIOS (movido desde vista-premios a organización) -->
    <section id="premios">
        <div class="premios-video-wrap">
            <div class="premios-video">
                <iframe
                    src="https://www.youtube.com/embed/DPZWSG2LZ_8?rel=0&modestbranding=1"
                    title="Giber García Álamo — Director del Proyecto WARAS"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                    style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:inherit;">
                </iframe>
            </div>
        </div>

        <div class="premios-reconocimiento">
            <div class="premios-rec-card">
                <p class="premios-rec-label">Beneficiario de las Líneas de Apoyo Económico para el Sector Cultura</p>
                <div class="premios-ministerio">
                    <div class="premios-ministerio-peru">
                        <div class="premios-ministerio-escudo">
                            <div class="premios-ministerio-escudo-inner">PERÚ</div>
                        </div>
                        <span class="premios-ministerio-peru-text">PERÚ</span>
                    </div>
                    <div class="premios-ministerio-nombre">Ministerio de Cultura</div>
                </div>
                <div class="premios-director">
                    <img class="premios-director-avatar"
                         src="/giber.png"
                         alt="Giber García Álamo">
                    <div>
                        <p class="premios-director-label">Director del Proyecto</p>
                        <p class="premios-director-name">Giber García Álamo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </div><!-- /view-organizacion -->

    <!-- ===== VISTA: APORTANTES ===== -->
    <div id="view-aportantes" class="page-view" style="display:none;">

        {{-- Hero Banner (mismo patrón que Organización y Premios) --}}
        <section class="subview-hero">
            <div class="subview-hero-bg" style="background-image:url('{{ $heroBg }}');"></div>
            <div class="subview-hero-overlay"></div>
            <div class="subview-hero-content">
                <h1 class="subview-hero-title">Aportantes y Aliados</h1>
                <p class="subview-hero-sub">Un grupo de ciudadanos, empresas e instituciones que hacen posible la preservación de nuestro legado cultural.</p>
            </div>
        </section>

        {{-- Sección principal: categorías + director --}}
        <section style="padding:6rem 2rem;background:#f9f8f6;">
            <div style="max-width:1200px;margin:0 auto;">

                {{-- Encabezado de sección --}}
                <div class="section-header" style="margin-bottom:4rem;">
                    <p class="section-eyebrow">Red de Colaboración Cultural</p>
                    <h2 class="section-title">Nuestros Aportantes</h2>
                </div>

                <div style="max-width:860px;margin:0 auto;">
                    <div style="display:flex;flex-direction:column;gap:3.5rem;">
                        @foreach($aportantes['categorias'] as $cat)
                        <div>
                            {{-- Título de categoría --}}
                            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem;">
                                <div style="width:36px;height:36px;background:rgba(205,162,116,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @php
                                        $slugs = ['building','heart','landmark','star','users','book','globe','leaf','award','briefcase'];
                                        $isImg = $cat['icono'] && !in_array($cat['icono'], $slugs);
                                    @endphp
                                    @if($isImg)
                                        <img src="{{ $cat['icono'] }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                                    @elseif($cat['icono'] === 'building')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    @elseif($cat['icono'] === 'heart')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                    @elseif($cat['icono'] === 'star')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    @elseif($cat['icono'] === 'users')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    @elseif($cat['icono'] === 'book')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                    @elseif($cat['icono'] === 'globe')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    @elseif($cat['icono'] === 'leaf')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 19.23A2 2 0 0 0 5.59 22c5.26-1.34 9.29-4.28 11.41-8.67C18 11 17.63 8.63 17 8z"/><path d="M3.82 19.23C3 20.23 2 21 2 21s0-6 5-10c1.35-1.08 3-1.67 5-2"/></svg>
                                    @elseif($cat['icono'] === 'award')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                                    @elseif($cat['icono'] === 'briefcase')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                    @else
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="22" x2="21" y2="22"/><line x1="6" y1="18" x2="6" y2="11"/><line x1="10" y1="18" x2="10" y2="11"/><line x1="14" y1="18" x2="14" y2="11"/><line x1="18" y1="18" x2="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p style="font-size:.65rem;font-weight:700;color:#cda274;text-transform:uppercase;letter-spacing:.2em;margin-bottom:.2rem;">Categoría</p>
                                    <h3 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:#111;font-weight:700;">{{ $cat['titulo'] }}</h3>
                                </div>
                            </div>
                            <div style="height:1px;background:#e5e7eb;margin-bottom:1.5rem;"></div>

                            {{-- Items --}}
                            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                                @foreach($cat['items'] as $item)
                                <div class="about-box" style="display:flex;gap:1.5rem;align-items:flex-start;padding:1.75rem;cursor:default;">
                                    @if($item['foto'])
                                        <img src="{{ $item['foto'] }}" alt="{{ $item['nombre'] }}" loading="lazy"
                                             style="width:80px;height:80px;object-fit:cover;flex-shrink:0;border:1px solid #e5e7eb;">
                                    @else
                                        <div style="width:80px;height:80px;flex-shrink:0;border:1px solid #e5e7eb;background:#f9f8f6;display:flex;align-items:center;justify-content:center;">
                                            <svg width="32" height="32" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 style="font-family:'Playfair Display',serif;font-size:1.05rem;color:#111;margin-bottom:.5rem;">{{ $item['nombre'] }}</h4>
                                        <p class="about-text" style="margin:0;font-size:.875rem;">{{ $item['descripcion'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

    </div><!-- /view-aportantes -->

    <!-- Footer -->
    <footer class="footer" id="contacto-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <!-- Logo & desc -->
                <div>
                    <span class="footer-logo">WARAS</span>
                    <p class="footer-desc">Portal integrado de acceso a colecciones de ciencia, cultura y patrimonio. Preservando la memoria de nuestra región.</p>
                    <div class="footer-social">
                        <a href="#" class="social-btn" aria-label="Facebook">f</a>
                        <a href="#" class="social-btn" aria-label="Twitter">t</a>
                        <a href="#" class="social-btn" aria-label="Instagram">in</a>
                    </div>
                </div>
                <!-- Links -->
                <div>
                    <h4 class="footer-heading">Explorar</h4>
                    <div class="footer-links">
                        <a href="#colecciones" class="footer-link" onclick="showView('inicio');setTimeout(()=>{document.getElementById('colecciones')?.scrollIntoView({behavior:'smooth'})},50);return false;">› Servicios</a>
                        <a href="#" class="footer-link" onclick="showView('organizacion');return false;">› Organización</a>
                        <a href="#" class="footer-link" onclick="showView('premios');return false;">› Premios</a>
                        <a href="{{ route('biblioteca.dashboard') }}" class="footer-link">› Biblioteca</a>
                        <a href="{{ route('fototeca.inicio') }}" class="footer-link">› Fototeca</a>
                    </div>
                </div>
                <!-- Contact -->
                <div>
                    <h4 class="footer-heading">Contacto</h4>
                    <div class="footer-contact-item">
                        <div class="">
                            <img src="/Direccion.png" alt="Dirección" style="width:30px;height:30px;object-fit:contain;">
                        </div>
                        <span>{!! nl2br(e($contact_direccion)) !!}</span>
                    </div>
                    <div class="footer-contact-item">
                        <div class="">
                            <img src="/Telefono.png" alt="Teléfonos" style="width:30px;height:30px;object-fit:contain;">
                        </div>
                        <span>{{ $contact_telefono }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <div class="">
                            <img src="/Email.png" alt="Correo Electrónico" style="width:30px;height:30px;object-fit:contain;">
                        </div>
                        <span>{{ $contact_email }}</span>
                    </div>
                </div>
                <!-- Newsletter -->
                <div>
                    <h4 class="footer-heading">Principios Incas</h4>
                    <blockquote class="footer-quote">
                        "Ama Llulla"<br>
                        "Ama Quella"<br>
                        "Ama Sua"
                    </blockquote>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copy">Copyright © 2024 WARAS - Asociación de Ciencia y Cultura Ancashina.</p>
                <div class="footer-legal">
                    <a href="#">Política de Privacidad</a>
                    <a href="#">Términos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div class="modal-overlay" id="contactModal">
        <div class="modal-inner">
            <button class="modal-close" onclick="closeContactModal()">&#10005;</button>
            <!-- Left info -->
            <div class="modal-left">
                <span class="modal-badge">Contacto Directo</span>
                <h2 class="modal-title">Si está interesado en nuestra labor, <em>póngase en contacto.</em></h2>
                <p class="modal-desc">El proceso es simple, solo tiene que llenar el formulario y enviar. También cuenta con información más específica como correos y números telefónicos a continuación.</p>
                <div class="modal-contact-cards">
                    <div class="modal-contact-card full">
                        <div class="modal-contact-icon-wrap">
                            <img src="{{ $contact_icon_direccion ? asset('storage/' . $contact_icon_direccion) : '/Direccion.png' }}" alt="Dirección" style="width:50px;height:50px;object-fit:contain;">
                        </div>
                        <div>
                            <p class="modal-contact-label">Dirección</p>
                            <p class="modal-contact-value">{!! nl2br(e($contact_direccion)) !!}</p>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                        <div class="modal-contact-card">
                            <div class="modal-contact-icon-wrap">
                                <img src="{{ $contact_icon_telefono ? asset('storage/' . $contact_icon_telefono) : '/Telefono.png' }}" alt="Teléfonos" style="width:50px;height:50px;object-fit:contain;">
                            </div>
                            <div>
                                <p class="modal-contact-label">Teléfonos</p>
                                <p class="modal-contact-value">{{ $contact_telefono }}</p>
                            </div>
                        </div>
                        <div class="modal-contact-card">
                            <div class="modal-contact-icon-wrap">
                                <img src="{{ $contact_icon_email ? asset('storage/' . $contact_icon_email) : '/Email.png' }}" alt="Email" style="width:50px;height:50px;object-fit:contain;">
                            </div>
                            <div>
                                <p class="modal-contact-label">Email</p>
                                <p class="modal-contact-value" style="word-break:break-all;">{{ $contact_email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right form -->
            <div class="modal-right">
                <div class="modal-form-wrap">
                    <h3 class="modal-form-title">Envíenos un mensaje</h3>
                    <p class="modal-form-sub">Responderemos lo más pronto posible.</p>
                    <form id="modalContactForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nombres Completos</label>
                            <input type="text" id="modal-nombres" class="form-input" placeholder="Ej. Juan Pérez" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" id="modal-email" class="form-input" placeholder="ejemplo@correo.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mensaje</label>
                            <textarea id="modal-mensaje" class="form-textarea" rows="4" placeholder="Escriba su consulta o comentario aquí..." required></textarea>
                        </div>
                        <button type="submit" class="form-submit">Enviar por WhatsApp &#10148;</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navbar — oscurecer al hacer scroll
        const _header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                _header.classList.add('scrolled');
            } else {
                _header.classList.remove('scrolled');
            }
        }, { passive: true });

        // Mobile menu
        function openMobileMenu()  { document.getElementById('mobileMenu').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeMobileMenu() { document.getElementById('mobileMenu').classList.remove('open'); document.body.style.overflow = ''; }

        // ── VISTAS (Inicio / Organización / Premios) ──
        function showView(name) {
            // Detener video de YouTube si se sale de Premios
            if (name !== 'premios') {
                const iframe = document.querySelector('#view-premios iframe');
                if (iframe) { const src = iframe.src; iframe.src = ''; iframe.src = src; }
            }
            ['inicio','organizacion','premios','aportantes'].forEach(v => {
                const el = document.getElementById('view-' + v);
                if (el) el.style.display = (v === name) ? '' : 'none';
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (name === 'inicio') {
                // Recalcular posición del carousel al volver a Inicio
                window.dispatchEvent(new Event('resize'));
            }
        }
        window.openMobileMenu  = openMobileMenu;
        window.closeMobileMenu = closeMobileMenu;

        // Contact modal
        function openContactModal()  { document.getElementById('contactModal').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeContactModal() { document.getElementById('contactModal').classList.remove('open'); document.body.style.overflow = ''; }
        window.openContactModal  = openContactModal;
        window.closeContactModal = closeContactModal;
        document.getElementById('contactModal').addEventListener('click', function(e) {
            if (e.target === this) closeContactModal();
        });

        // Modal contact form → WhatsApp
        const _waNumber = '{{ $whatsapp_number ?? "" }}';
        document.getElementById('modalContactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            if (!_waNumber) {
                const orig = btn.innerHTML;
                btn.innerHTML = '⚠ Por el momento no es posible contactar';
                btn.style.opacity = '0.7';
                btn.disabled = true;
                setTimeout(() => { btn.innerHTML = orig; btn.style.opacity = ''; btn.disabled = false; }, 4000);
                return;
            }
            const nombres = document.getElementById('modal-nombres').value.trim();
            const email   = document.getElementById('modal-email').value.trim();
            const mensaje = document.getElementById('modal-mensaje').value.trim();
            const texto   = `Hola, le escribo desde el portal WARAS EDITORIAL.\n\n*Nombre:* ${nombres}\n*Correo:* ${email}\n\n*Mensaje:*\n${mensaje}`;
            window.open(`https://wa.me/${_waNumber}?text=${encodeURIComponent(texto)}`, '_blank');
            const orig = btn.innerHTML;
            btn.innerHTML = '✓ ¡Redirigiendo a WhatsApp!';
            btn.style.background = '#059669';
            setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; this.reset(); }, 3000);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                const id = this.getAttribute('href').slice(1);
                const el = document.getElementById(id);
                if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
            });
        });

        // ========== CAROUSEL SLIDER - BUCLE INFINITO ==========
        (function() {
            const carousel     = document.getElementById('collectionsCarousel');
            const carouselWrap = carousel.closest('.collections-carousel-container');
            const origCards    = Array.from(carousel.querySelectorAll('.collection-card'));
            const n            = origCards.length;
            const ANIM_MS      = 700;
            const AUTO_DELAY   = 10000;

            let CARD_W = window.innerWidth < 768 ? 300 : 420;
            let GAP    = window.innerWidth < 768 ? 16  : 32;
            let SHIFT  = CARD_W + GAP;

            // Triplicar para bucle infinito
            carousel.innerHTML = '';
            [...origCards, ...origCards, ...origCards].forEach(c => carousel.appendChild(c.cloneNode(true)));
            carousel.style.gap = GAP + 'px';

            let current  = n;
            let busy     = false;
            let autoTimer;

            const allCards = () => carousel.querySelectorAll('.collection-card');

            // Calcula el offset usando el ancho real del contenedor (no 50vw)
            function getOffset() {
                const containerW = carouselWrap.getBoundingClientRect().width;
                return (containerW / 2) - (CARD_W / 2);
            }

            function applyTransform(animated) {
                carousel.style.transition = animated ? `transform ${ANIM_MS}ms ease-in-out` : 'none';
                carousel.style.transform  = `translateX(${getOffset() - current * SHIFT}px)`;
            }

            // Recalcular en resize
            window.addEventListener('resize', () => {
                CARD_W = window.innerWidth < 768 ? 300 : 420;
                GAP    = window.innerWidth < 768 ? 16  : 32;
                SHIFT  = CARD_W + GAP;
                carousel.style.gap = GAP + 'px';
                applyTransform(false);
            }, { passive: true });

            function updateStates() {
                allCards().forEach((card, i) => {
                    card.classList.toggle('active',   i === current);
                    card.classList.toggle('inactive', i !== current);
                });
            }

            function updateDots() {
                document.querySelectorAll('.carousel-dot').forEach((dot, i) => {
                    dot.classList.toggle('active', i === (current % n));
                });
            }

            function teleportIfNeeded() {
                // Al llegar al tercer bloque, salta silenciosamente al segundo (central)
                if (current >= n * 2) {
                    current = current - n;
                    applyTransform(false);
                } else if (current < n) {
                    current = current + n;
                    applyTransform(false);
                }
            }

            function go(newCurrent) {
                if (busy) return;
                busy = true;
                current = newCurrent;
                applyTransform(true);
                updateStates();
                updateDots();
                setTimeout(() => {
                    teleportIfNeeded();
                    updateStates();
                    updateDots();
                    busy = false;
                }, ANIM_MS + 20);
            }

            function initDots() {
                const container = document.getElementById('carouselDots');
                container.innerHTML = '';
                for (let i = 0; i < n; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
                    dot.addEventListener('click', () => {
                        if (busy) return;
                        clearInterval(autoTimer);
                        go(n + i);
                        startAuto();
                    });
                    container.appendChild(dot);
                }
            }

            function startAuto() {
                clearInterval(autoTimer);
                autoTimer = setInterval(() => {
                    if (busy) return;
                    go(current + 1);
                }, AUTO_DELAY);
            }

            window.scrollCarousel = function(dir) {
                if (busy) return;
                clearInterval(autoTimer);
                go(current + (dir === 'next' ? 1 : -1));
                startAuto();
            };

            // Click en tarjeta activa → navegar; click en inactiva → centrar
            carousel.addEventListener('click', function(e) {
                const card = e.target.closest('.collection-card');
                if (!card) return;
                const idx = Array.from(allCards()).indexOf(card);
                if (idx === current) {
                    const url = card.dataset.url;
                    if (url) window.location.href = url;
                } else {
                    if (busy) return;
                    clearInterval(autoTimer);
                    go(idx);
                    startAuto();
                }
            });

            initDots();
            applyTransform(false);
            updateStates();
            updateDots();
            startAuto();
        })();
    </script>
    <x-floating-buttons />
</body>
</html>
