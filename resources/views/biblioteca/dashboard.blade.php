<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Digital - WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/biblioteca.css')
    <style>
        .mobile-nav-overlay { display: none !important; position: fixed; inset: 0; z-index: 1999; background: rgba(0,0,0,0.45); }
        .mobile-nav-overlay.open { display: block !important; }
        .mobile-nav {
            display: none !important; visibility: hidden;
            position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important;
            bottom: auto !important; height: auto !important; min-height: 0 !important;
            z-index: 2000; flex-direction: column;
            background: rgba(15,20,35,0.98) !important;
            backdrop-filter: blur(14px);
            flex: none !important; align-self: flex-start !important;
        }
        .mobile-nav.open { display: flex !important; visibility: visible; }
        .mobile-nav-header {
            display: flex !important; align-items: center; justify-content: space-between;
            padding: 0 1.25rem; height: 64px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }
        .mobile-nav-close { background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.3rem; }
        .mobile-nav-links { display: block !important; width: 100%; }
        .mobile-nav-item {
            display: block !important; padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            color: #ccc; text-decoration: none;
            font-size: 0.72rem; font-weight: 600;
            letter-spacing: 0.18em; text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
            transition: color 0.2s, background 0.2s;
            height: auto !important; min-height: 0 !important;
            text-align: left !important;
            width: 100% !important; box-sizing: border-box !important;
            margin: 0 !important; float: none !important;
        }
        .mobile-nav-item:hover { color: #fff; background: rgba(255,255,255,0.04); }
        .mobile-nav-portal { color: #aaa !important; opacity: 0.75; }
    </style>
</head>
<body>
    <div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="closeMobileNav()"></div>
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-header">
            <a href="javascript:void(0)" class="logo" id="logoBtnMobile">
                @php $navLogoMob = \App\Models\SiteSetting::get('nav_logo_biblioteca'); @endphp
                @if($navLogoMob)
                    <img src="{{ asset('storage/' . $navLogoMob) }}" alt="Logo" class="logo-icon">
                @else
                    <div class="logo-squares">
                        <div class="logo-square logo-square-1"></div>
                        <div class="logo-square logo-square-2"></div>
                        <div class="logo-square logo-square-3"></div>
                    </div>
                @endif
                <div class="logo-brand">
                    <span class="logo-text">BIBLIOTECA</span>
                    <span class="logo-text-sub">Digital Ancashina</span>
                </div>
            </a>
            <button class="mobile-nav-close" onclick="closeMobileNav()">✕</button>
        </div>
        <nav class="mobile-nav-links">
            <a href="{{ route('biblioteca.inicio') }}" class="mobile-nav-item" onclick="closeMobileNav()">Inicio</a>
            <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item" onclick="closeMobileNav()">Biblioteca Digital</a>
            <a href="{{ route('biblioteca.editorial.index') }}" class="mobile-nav-item" onclick="closeMobileNav()">Waras Editorial</a>
            <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item" onclick="closeMobileNav()">Revistas</a>
            <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item" onclick="closeMobileNav()">Autores</a>
            <a href="{{ route('biblioteca.especiales.index') }}" class="mobile-nav-item" onclick="closeMobileNav()">Especiales</a>
            <a href="{{ route('home') }}" class="mobile-nav-item mobile-nav-portal" onclick="closeMobileNav()">Portal Principal</a>
            @auth
                @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item" style="color:#c5a66d;" onclick="closeMobileNav()">Panel Admin</a>
                @endif
            @endauth
        </nav>
    </div>

    <!-- Header -->
    <header class="header" id="header">
        <div class="header-container">
            <a href="javascript:void(0)" class="logo" id="logoBtn">
                @php $navLogo = \App\Models\SiteSetting::get('nav_logo_biblioteca'); @endphp
                @if($navLogo)
                    <img src="{{ asset('storage/' . $navLogo) }}" alt="Logo" class="logo-icon">
                @else
                    <div class="logo-squares">
                        <div class="logo-square logo-square-1"></div>
                        <div class="logo-square logo-square-2"></div>
                        <div class="logo-square logo-square-3"></div>
                    </div>
                @endif
                <div class="logo-brand">
                    <span class="logo-text">BIBLIOTECA</span>
                    <span class="logo-text-sub">Digital Ancashina</span>
                </div>
            </a>

            <nav class="nav-menu" id="navMenu">
                <a href="{{ route('biblioteca.inicio') }}" data-tab="Inicio" class="nav-item">Inicio</a>
                <span class="nav-sep-bib">|</span>
                <a href="{{ route('biblioteca.libros.index') }}" data-tab="Libros" class="nav-item">Biblioteca Digital</a>
                <a href="{{ route('biblioteca.revistas.index') }}" data-tab="Revistas" class="nav-item">Revistas</a>
                <a href="{{ route('biblioteca.autores.index') }}" data-tab="Autores" class="nav-item">Autores</a>
                <span class="nav-sep-bib">|</span>
                <a href="{{ route('biblioteca.especiales.index') }}" data-tab="Especiales" class="nav-item">Especiales</a>
                <span class="nav-sep-bib">|</span>
                <a href="{{ route('biblioteca.editorial.index') }}" data-tab="Waras Editorial" class="nav-item">Waras Editorial</a>
            </nav>
            <div class="header-actions">
                <a href="{{ route('home') }}" class="header-btn header-btn-outline">
                    <i class="fas fa-home"></i> Portal Principal
                </a>
                @auth
                    @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
                    <a href="{{ route('admin.dashboard') }}" class="header-btn header-btn-solid">
                        <i class="fas fa-th-large"></i> Panel
                    </a>
                    @endif
                @endauth
            </div>
            <button class="hamburger-btn" onclick="openMobileNav()" aria-label="Abrir menú">
                <i class="fas fa-bars" style="font-size:1.3rem"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="heroSection" style="background: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)), url('{{ $heroBg ?? 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}') center/cover no-repeat; background-attachment: fixed;">
        <div class="hero-content">
            <h1 class="hero-title">{{ \App\Models\SiteSetting::get('hero_biblioteca_title', 'Biblioteca Digital Ancashina') }}</h1>
            <p class="hero-subtitle">{{ \App\Models\SiteSetting::get('hero_biblioteca_subtitle', '"Conocimiento e historia accesible para todos"') }}</p>
            <div class="hero-search-container">
                <div class="search-wrapper">
                    <div class="search-wrapper-inner">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="heroSearchInput" class="search-input" placeholder="Buscar por título, autor, materia o palabra clave..." autocomplete="off">
                    </div>
                    <button class="search-btn" id="heroSearchBtn">Buscar</button>
                </div>
                <div class="hero-search-dropdown" id="heroDropdown"></div>
            </div>
        </div>
    </section>

    <!-- INICIO SECTION -->
    <div class="inicio-section hidden" id="inicioSection">

        <!-- Contadores -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-num" id="statLibros">{{ $booksData['Libros'] ? count($booksData['Libros']) : 0 }}</span>
                <span class="stat-label">Libros</span>
            </div>
            <div class="stat-item">
                <span class="stat-num" id="statRevistas">{{ $booksData['Revistas'] ? count($booksData['Revistas']) : 0 }}</span>
                <span class="stat-label">Revistas</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $totalAuthors }}</span>
                <span class="stat-label">Autores</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $totalPublishers }}</span>
                <span class="stat-label">Editoriales</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $booksData['Especiales'] ? count($booksData['Especiales']) : 0 }}</span>
                <span class="stat-label">Especiales</span>
            </div>
        </div>

        <!-- Carrusel: Libros -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Libros</h2>
                <span class="inicio-carousel-count">{{ count($booksData['Libros']) }} títulos</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackLibros"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveCarousel('libros',-1)">‹</button>
                <div class="ico-dots" id="dotsLibros"></div>
                <button class="ico-btn" onclick="moveCarousel('libros',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Libros')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Carrusel: Autores -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Autores</h2>
                <span class="inicio-carousel-count">{{ $totalAuthors }} registrados</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackAutores"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveCarousel('autores',-1)">‹</button>
                <div class="ico-dots" id="dotsAutores"></div>
                <button class="ico-btn" onclick="moveCarousel('autores',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Autores')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Carrusel: Revistas -->
        <div class="inicio-carousel-section" style="padding-bottom:4rem;">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Revistas</h2>
                <span class="inicio-carousel-count">{{ count($booksData['Revistas']) }} títulos</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackRevistas"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveCarousel('revistas',-1)">‹</button>
                <div class="ico-dots" id="dotsRevistas"></div>
                <button class="ico-btn" onclick="moveCarousel('revistas',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Revistas')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

    </div>

    <!-- Mobile sidebar overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <!-- Main Content -->
    <div class="main-wrapper hidden" id="mainWrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="mobileSidebar">
            <div class="sidebar-header" style="justify-content:space-between">
                <div style="display:flex;align-items:center;gap:0.75rem">
                    <i class="fas fa-filter"></i>
                    <span class="sidebar-title">Explorar Catálogo</span>
                </div>
                <button onclick="closeMobileSidebar()" id="sidebarCloseBtn" style="background:none;border:none;color:#1b2a47;font-size:1.25rem;cursor:pointer;display:none;padding:0"><i class="fas fa-times"></i></button>
            </div>

            <div class="categories-section">
                <div class="categories-label">Materias</div>
                <ul class="categories-list" id="categoriesList"></ul>
            </div>

        </aside>

        <!-- Content Area -->
        <main class="content">
            <button class="sidebar-toggle-btn" onclick="openMobileSidebar()"><i class="fas fa-filter"></i>&nbsp; Filtrar por materia</button>
            <div class="breadcrumbs">
                <a id="breadcrumbHome">Catálogo</a>
                <span class="separator">›</span>
                <span class="current" id="breadcrumbCategory">Historia Y Geografía</span>
            </div>

            <!-- Search Box -->
            <div class="content-search" style="position:relative;">
                <i class="fas fa-search content-search-icon"></i>
                <input type="text" class="content-search-input" id="contentSearchInput" placeholder="Buscar libros, autores o temas en Historia Y Geografía..." autocomplete="off">
                <div id="descriptorSuggestions" style="display:none;position:absolute;top:100%;left:0;right:0;z-index:200;background:#fff;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px;box-shadow:0 8px 24px rgba(0,0,0,0.1);max-height:220px;overflow-y:auto;"></div>
            </div>

            <!-- Descriptor chips (filtros rápidos) -->
            <div id="descriptorChipsBar" style="display:none;margin:0.75rem 0 0.25rem;"></div>

            <div class="section-header">
                <h2 class="section-title" id="sectionTitle">Historia Y Geografía</h2>
                <p class="section-subtitle">Mostrando resultados del catálogo digital.</p>
            </div>

            <div class="toolbar">
                <span class="results-count" id="resourceCount"><strong id="resourceNumber">0</strong> recursos encontrados</span>
                <div class="sort-controls">
                    <i class="fas fa-sliders-h" style="color: #9ca3af;"></i>
                    <span>Ordenar por:</span>
                    <select class="sort-select" id="sortSelect">
                        <option value="az">Ordenar A-Z</option>
                        <option value="recent">Más recientes</option>
                        <option value="old">Más antiguos</option>
                        <option value="year_asc">Por año ↑</option>
                        <option value="year_desc">Por año ↓</option>
                    </select>
                </div>
            </div>

            <div class="books-grid" id="booksGrid"></div>
            <div id="booksPagination"></div>
        </main>
    </div>

    <!-- Detail View -->
    <div class="detail-view hidden" id="detailView">
        <div style="max-width:900px; margin:0 auto;">
        <button class="detail-back-btn" id="backBtn">
            <i class="fas fa-arrow-left"></i> Atrás
        </button>

        <div class="detail-breadcrumbs" id="detailBreadcrumbs">
            <span class="breadcrumb-item">Inicio</span>
            <span class="breadcrumb-separator">›</span>
            <span class="breadcrumb-item" id="breadcrumb-category">Categoría</span>
            <span class="breadcrumb-separator">›</span>
            <span class="breadcrumb-item active" id="breadcrumb-title">Título</span>
        </div>

        <div class="detail-container">
            <!-- Left: Book Cover -->
            <div class="detail-cover-section">
                <div class="detail-cover" id="detailCover" style="background-color: #5c4033;">
                    <span class="detail-cover-icon" id="detailCoverIcon">📚</span>
                </div>
            </div>

            <!-- Right: Book Info -->
            <div class="detail-info-section">
                <h1 class="detail-title" id="detailTitle">Título del Libro</h1>
                
                <div class="detail-author">
                    <i class="fas fa-user"></i>
                    <span id="detailAuthor">Autor</span>
                </div>

                <div class="detail-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span id="detailYear">2023</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-book"></i>
                        <span id="detailPages">0</span> páginas
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-globe"></i>
                        <span id="detailLanguage">Español</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-barcode"></i>
                        ISBN: <span id="detailRating">N/A</span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>SINOPSIS / DESCRIPCIÓN</h3>
                    <p id="detailSynopsis">Descripción del contenido aquí.</p>
                </div>

                <div class="detail-section">
                    <h3>EDITORIAL</h3>
                    <p id="detailPublisher">Editorial aquí</p>
                </div>

                <div class="detail-actions">
                    <a id="btnLeerLinea" href="#" target="_blank" rel="noopener"
                       class="detail-btn detail-btn-primary" style="text-decoration:none;">
                        <i class="fas fa-book-open"></i> Leer en línea
                    </a>
                    <button id="btnCompartir" class="detail-btn detail-btn-icon" title="Copiar enlace">
                        <i class="fas fa-share-alt"></i>
                    </button>
                </div>
                <div id="shareToast" style="display:none;margin-top:0.75rem;font-size:0.8rem;color:#6b7280;text-align:center;">
                    ✓ Enlace copiado al portapapeles
                </div>
            </div>
        </div>

        <!-- Related Materials -->
        <div class="related-section">
            <h2>Materiales Relacionados</h2>
            <div class="related-grid" id="relatedGrid"></div>
        </div>
        </div><!-- end max-width wrapper -->
    </div>

    <!-- ===== SECCIÓN NOSOTROS / APORTANTES (eliminada del nav) ===== -->
    <div id="aportantesSection" style="display:none;background:#f1f5f9;margin-top:72px;padding:0 0 4rem;">

        <!-- Hero Banner -->
        <div style="background:var(--primary);color:white;padding:5rem 2rem;text-align:center;position:relative;overflow:hidden;">
            <div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=2000&q=30') center/cover;opacity:.08;"></div>
            <div style="position:absolute;inset:0;background:linear-gradient(to bottom,rgba(27,42,71,.8),rgba(27,42,71,1));"></div>
            <div style="position:relative;z-index:1;max-width:800px;margin:0 auto;display:flex;flex-direction:column;align-items:center;">
                <div style="display:flex;align-items:flex-end;gap:.35rem;margin-bottom:1.5rem;">
                    <div style="width:8px;height:18px;background:#60a5fa;border-radius:2px;"></div>
                    <div style="width:8px;height:24px;background:#f87171;border-radius:2px;"></div>
                    <div style="width:8px;height:13px;background:var(--accent);border-radius:2px;"></div>
                </div>
                <h1 style="font-family:'Playfair Display',serif;font-size:2.75rem;font-weight:800;margin-bottom:.75rem;">Aportantes y Aliados</h1>
                <p style="font-size:.75rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:1.5rem;">Red de Colaboración Cultural</p>
                <p style="font-size:1rem;font-weight:300;color:rgba(255,255,255,.8);line-height:1.85;max-width:620px;">
                    Un grupo de ciudadanos, empresas e instituciones comprometidos con el desarrollo económico, social, científico y cultural, que hacen posible la preservación de nuestro legado.
                </p>
            </div>
        </div>

        <!-- Contenido principal -->
        <div style="max-width:1400px;margin:-2.5rem auto 0;padding:0 2rem 3rem;position:relative;z-index:10;">
            <div style="background:white;border-radius:1rem;box-shadow:0 8px 30px rgba(0,0,0,.08);border:1px solid #e2e8f0;padding:2.5rem 3.5rem;">

                <div style="display:grid;grid-template-columns:1fr minmax(0,380px);gap:3.5rem;align-items:start;">

                    <!-- Columna izquierda: aportantes -->
                    <div>
                        <!-- Título sección -->
                        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:2rem;padding-bottom:1rem;border-bottom:1px solid #e5e7eb;">
                            <div style="background:var(--primary);padding:.5rem;border-radius:.4rem;line-height:0;">
                                <svg width="22" height="22" fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            </div>
                            <h3 style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--primary);">Nuestros Aportantes</h3>
                        </div>

                        <!-- Categoría: Empresas Auspiciadoras -->
                        <div style="margin-bottom:2.5rem;">
                            <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:1.25rem;padding-bottom:.6rem;border-bottom:2px solid #f1f5f9;">
                                <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <h4 style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#1e293b;">Empresas Auspiciadoras</h4>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.875rem;">
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=200&q=80" alt="Minera Antamina" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Minera Antamina S.A.</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Auspiciador Platino. Su apoyo financiero ha sido fundamental para mantener nuestra infraestructura tecnológica y adquirir los servidores principales de la plataforma.</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Constructora Andes" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Constructora Andes EIRL</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Aportes directos para la viabilidad, contratación del equipo de digitalización inicial y adquisición de escáneres planetarios.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categoría: Donantes de Colecciones -->
                        <div style="margin-bottom:2.5rem;">
                            <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:1.25rem;padding-bottom:.6rem;border-bottom:2px solid #f1f5f9;">
                                <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                <h4 style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#1e293b;">Donantes de Colecciones y Libros</h4>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.875rem;">
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=200&q=80" alt="Familia Alba" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Familia Alba</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Cedieron temporalmente su invaluable colección privada de Historia Ancashina, permitiendo la digitalización de más de 120 volúmenes únicos.</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=200&q=80" alt="Dr. Carlos Ramirez" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Dr. Carlos Ramirez</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Aportó de forma desinteresada su hemeroteca completa de revistas literarias y recortes periodísticos publicados entre 1950 y 1980.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categoría: Instituciones Aliadas -->
                        <div>
                            <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:1.25rem;padding-bottom:.6rem;border-bottom:2px solid #f1f5f9;">
                                <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="22" x2="21" y2="22"/><line x1="6" y1="18" x2="6" y2="11"/><line x1="10" y1="18" x2="10" y2="11"/><line x1="14" y1="18" x2="14" y2="11"/><line x1="18" y1="18" x2="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg>
                                <h4 style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#1e293b;">Instituciones Aliadas</h4>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.875rem;">
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=200&q=80" alt="UNASAM" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Universidad Nacional Santiago Antúnez de Mayolo (UNASAM)</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Brinda soporte académico, valida la veracidad de los documentos históricos y facilita la participación de estudiantes voluntarios.</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1568667256549-094345857637?auto=format&fit=crop&w=200&q=80" alt="Biblioteca Pública Municipal de Huaraz" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Biblioteca Pública Municipal de Huaraz</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Aliado estratégico en el rescate de la identidad. Fueron los primeros en acoger la idea de fortalecer el patrimonio digital ancashino.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna derecha: Director -->
                    <div>
                        <!-- Título Director -->
                        <div style="display:flex;align-items:center;margin-bottom:1.75rem;padding-top:.25rem;">
                            <h4 style="font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:600;color:var(--primary);white-space:nowrap;">Director</h4>
                            <div style="margin-left:1rem;height:1px;flex:1;background:#e2e8f0;position:relative;">
                                <div style="position:absolute;left:0;top:0;height:100%;width:3rem;background:var(--accent);"></div>
                            </div>
                        </div>

                        <!-- Tarjeta director -->
                        <div style="background:#f8fafc;border-radius:.75rem;border:1px solid #e5e7eb;padding:2rem;display:flex;flex-direction:column;align-items:center;text-align:center;">
                            <!-- Foto circular -->
                            <div style="position:relative;width:160px;height:160px;margin-bottom:1.5rem;">
                                <div style="position:absolute;inset:0;border-radius:50%;border:4px solid #e2e8f0;"></div>
                                <div style="position:absolute;inset:-4px;border-radius:50%;border:1px solid var(--accent);opacity:.5;"></div>
                                <img src="/giber.png" alt="Giber Garcia Alamo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;padding:4px;">
                            </div>
                            <!-- Datos -->
                            <h5 style="font-size:.9rem;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.35rem;">Giber Garcia Alamo</h5>
                            <p style="font-family:'Playfair Display',serif;font-style:italic;font-size:1rem;color:var(--accent);margin-bottom:1rem;">Bibliotecólogo</p>
                            <p style="font-size:.82rem;color:#64748b;line-height:1.75;margin-bottom:1.5rem;">
                                Promotor inicial de la recopilación histórica. Asumió la dirección para rescatar, catalogar y promover la Identidad Ancashina a través de esta plataforma digital.
                            </p>
                            <button style="padding:.55rem 1.5rem;background:white;border:1.5px solid var(--primary);color:var(--primary);font-size:.8rem;font-weight:700;border-radius:.375rem;cursor:pointer;transition:all .2s;font-family:inherit;"
                                onmouseover="this.style.background='var(--primary)';this.style.color='white'"
                                onmouseout="this.style.background='white';this.style.color='var(--primary)'">
                                Ver Perfil Completo
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p class="footer-text">© 2024 WARAS - Asociación de Ciencia y Cultura Ancashina</p>
        <p class="footer-subtext">Preservando la memoria cultural de nuestra región</p>
    </footer>

    <script>
        // ========== CATEGORÍAS DINÁMICAS DESDE LARAVEL ==========
        const categoriesFromDatabase = @json($categoriesForFilters ?? []);

        // Flat list of {id, name} objects from DB (parents + children)
        const allDbCategories = [];
        categoriesFromDatabase.forEach(parent => {
            allDbCategories.push({ id: parent.id, name: parent.name });
            (parent.children || []).forEach(child => {
                allDbCategories.push({ id: child.id, name: child.name });
            });
        });

        // categoriesBySection stores arrays of {id, name} objects
        // Books/Revistas use DB categories; others use label-only items (no filtering)
        const categoriesBySection = {
            'Libros':          allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Revistas':        allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Waras Editorial': allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Especiales':      [{ id: null, name: 'Todos' }],
            'Autores':         [{ id: null, name: 'Todos' }],
        };


        // ========== DATOS DINÁMICOS DESDE LARAVEL ==========
        const booksDataFromServer = @json($booksData ?? []);
        const topDescriptorsData  = @json($topDescriptors ?? []);
        
        // ========== DATOS POR SECCIÓN ==========
        const COVER_COLORS = ['#5c4033','#2d4a6e','#3a5a40','#6b3a2a','#1a3a5c','#4a3a6b'];
        const ICONS = { 'Libro': '📚', 'Revista': '📰', 'Artículo': '📄', 'Tesis': '🎓' };

        function mapBook(book, idx) {
            const authors = book.authors || [];
            return {
                id:           book.id,
                title:        book.title,
                author:       authors.length > 0 ? authors[0].name : 'Anónimo',
                authorId:     authors.length > 0 ? authors[0].id : null,
                authorNames:  authors.map(a => a.name),
                year:         book.publication_year || (book.publication_date ? book.publication_date.split('T')[0].split('-')[0] : null),
                created_at:   book.created_at || '',
                type:         book.document_type || 'Libro',
                description:  book.summary || 'Sin descripción disponible',
                publisher:    book.publisher ? book.publisher.name : 'Sin editorial',
                pages:        book.pages || 'N/A',
                language:     book.language || 'Español',
                isbn:         book.isbn || 'N/A',
                color:        COVER_COLORS[idx % COVER_COLORS.length],
                icon:         ICONS[book.document_type] || '📚',
                cover_url:    book.cover_image_path ? '/storage/' + book.cover_image_path : null,
                source_type:  book.source_type || 'none',
                external_url: book.external_url || '',
                pdf_path:     book.pdf_file_path || '',
                categoryIds:    (book.categories  || []).map(c => c.id),
                descriptorIds:  (book.descriptors || []).map(d => d.id),
                descriptorNames:(book.descriptors || []).map(d => d.name),
                detail_url:   book.document_type === 'Revista'
                                ? '/biblioteca/revistas/' + book.id
                                : '/biblioteca/libros/' + book.id,
                read_url:     book.source_type === 'external' && book.external_url
                                ? book.external_url
                                : (book.source_type === 'pdf' && book.pdf_file_path
                                    ? '/storage/' + book.pdf_file_path
                                    : null),
            };
        }

        const dataBySectionAndCategory = {
            'Libros': {
                'default': (booksDataFromServer['Libros'] || []).map((book, idx) => mapBook(book, idx))
            },
            'Revistas': {
                'default': (booksDataFromServer['Revistas'] || []).map((book, idx) => mapBook(book, idx))
            },
            'Especiales': {
                'default': (booksDataFromServer['Especiales'] || []).map(s => ({
                    id:          s.id,
                    title:       s.title,
                    type:        s.type,
                    cover_url:   s.cover_image_path ? '/storage/' + s.cover_image_path : null,
                    books_count: s.books_count ?? (s.books ? s.books.length : 0),
                    slug:        s.slug || '',
                }))
            },
            'Waras Editorial': { 'default': (booksDataFromServer['Waras Editorial'] || []).map((book, idx) => mapBook(book, idx)) },
            'Autores': {
                'default': (booksDataFromServer['Autores'] || []).map(author => ({
                    id:          author.id,
                    name:        author.name,
                    biography:   author.biography || 'Sin biografía',
                    nationality: author.nationality || 'Desconocida',
                    photo_url:   author.photo_path ? '/storage/' + author.photo_path : null,
                }))
            },
        };

        const serverActiveSection = @json($activeSection ?? 'Inicio');

        let activeDescriptorId = null;
        const ITEMS_PER_PAGE = 12;

        let state = {
            activeTab: 'Inicio',
            activeCategory: null, // {id, name} or null
            currentPage: 1,
            isScrolled: false,
            openAccordions:   new Set(),  // ids abiertos manualmente
            closedAccordions: new Set()   // ids cerrados manualmente (tienen prioridad sobre ancestro activo)
        };

        // ========== OBTENER DATOS según TAB y CATEGORÍA ==========
        function getDataForSection() {
            const tab = state.activeTab;
            const allItems = dataBySectionAndCategory[tab]?.['default'] || [];

            // For Libros/Revistas filter by category id if one is selected
            if (['Libros', 'Revistas', 'Waras Editorial'].includes(tab) && state.activeCategory && state.activeCategory.id !== null) {
                const catId = state.activeCategory.id;
                return allItems.filter(item => item.categoryIds && item.categoryIds.includes(catId));
            }
            return allItems;
        }

        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            const heroSection = document.getElementById('heroSection');
            const isHome = state.activeTab === 'Inicio' && !heroSection.classList.contains('hidden');
            
            if (isHome) {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                    header.classList.remove('scrolled-content');
                } else {
                    header.classList.remove('scrolled', 'scrolled-content');
                }
            } else {
                header.classList.add('scrolled-content');
                header.classList.remove('scrolled');
            }
        }, { passive: true });

        // Recursivo: construye HTML de un nodo del árbol de categorías (Biblioteca)
        function buildCatNodeHtml(node, depth) {
            const hasChildren = node.children && node.children.length > 0;
            const manuallyClosed = state.closedAccordions.has(node.id);
            const isOpen = !manuallyClosed && (
                state.openAccordions.has(node.id) ||
                bibIsAncestorOfActive(node, state.activeCategory ? state.activeCategory.id : null)
            );
            const isActive = state.activeCategory && state.activeCategory.id === node.id;
            const pl = `${1.5 + depth * 0.875}rem`;

            if (hasChildren) {
                const childrenHtml = node.children.map(c => buildCatNodeHtml(c, depth + 1)).join('');
                return `<li>
                    <button class="acc-parent-btn ${isOpen ? 'open' : ''}"
                            data-parent-id="${node.id}" style="padding-left:${pl};">
                        <span>${node.name}</span>
                        <i class="fas fa-chevron-right acc-chevron"></i>
                    </button>
                    <div class="acc-children ${isOpen ? 'open' : ''}">
                        <ul style="list-style:none;padding:0;margin:0;">${childrenHtml}</ul>
                    </div>
                </li>`;
            } else {
                const rootStyle = depth === 0 ? 'font-weight:700;color:#374151;' : '';
                return `<li>
                    <button class="acc-child-btn ${isActive ? 'active' : ''}"
                            data-category-id="${node.id}" data-category-name="${node.name}"
                            style="padding-left:${pl};${rootStyle}">
                        <span>${node.name}</span>
                        <i class="fas fa-chevron-right category-icon" style="font-size:0.65rem;flex-shrink:0;"></i>
                    </button>
                </li>`;
            }
        }

        function bibIsAncestorOfActive(node, activeId) {
            if (!activeId || !node.children) return false;
            for (const child of node.children) {
                if (child.id === activeId) return true;
                if (bibIsAncestorOfActive(child, activeId)) return true;
            }
            return false;
        }

        function renderCategories() {
            const list = document.getElementById('categoriesList');
            const useAccordion = ['Libros', 'Revistas', 'Waras Editorial'].includes(state.activeTab) && categoriesFromDatabase.length > 0;

            if (useAccordion) {
                const allActive = state.activeCategory && state.activeCategory.id === null;
                const todosItem = `<li>
                    <button class="category-btn ${allActive ? 'active' : ''}" data-category-id="" data-category-name="Todos">
                        <span>Todos</span>
                        <i class="fas fa-chevron-right category-icon"></i>
                    </button>
                </li>`;

                list.innerHTML = todosItem + categoriesFromDatabase.map(node => buildCatNodeHtml(node, 0)).join('');

                // "Todos" button
                const todosBtn = list.querySelector('.category-btn');
                if (todosBtn) {
                    todosBtn.addEventListener('click', () => {
                        state.activeCategory = { id: null, name: 'Todos' };
                        state.currentPage = 1;
                        state.openAccordions.clear();
                        state.closedAccordions.clear();
                        document.getElementById('sectionTitle').textContent = state.activeTab;
                        document.getElementById('breadcrumbCategory').textContent = state.activeTab;
                        document.getElementById('contentSearchInput').placeholder = `Buscar en ${state.activeTab}...`;
                        renderCategories();
                        renderBooks();
                        closeMobileSidebar();
                    });
                }

                // Parent toggle (cualquier profundidad) — Set-based para multinivel
                list.querySelectorAll('.acc-parent-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const pid = parseInt(btn.getAttribute('data-parent-id'));
                        const isCurrentlyOpen = btn.classList.contains('open');
                        if (isCurrentlyOpen) {
                            state.openAccordions.delete(pid);
                            state.closedAccordions.add(pid);
                        } else {
                            state.closedAccordions.delete(pid);
                            state.openAccordions.add(pid);
                        }
                        renderCategories();
                    });
                });

                // Leaf select (cualquier profundidad)
                list.querySelectorAll('.acc-child-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id   = parseInt(btn.getAttribute('data-category-id'));
                        const name = btn.getAttribute('data-category-name');
                        state.activeCategory = { id, name };
                        state.currentPage = 1;
                        document.getElementById('sectionTitle').textContent = name;
                        document.getElementById('breadcrumbCategory').textContent = name;
                        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${name}...`;
                        renderCategories();
                        renderBooks();
                        closeMobileSidebar();
                    });
                });

            } else {
                // Flat list for other tabs
                const currentCategories = categoriesBySection[state.activeTab] || categoriesBySection['Libros'];
                list.innerHTML = currentCategories.map(cat => {
                    const isActive = state.activeCategory && state.activeCategory.id === cat.id && state.activeCategory.name === cat.name;
                    return `<li>
                        <button class="category-btn ${isActive ? 'active' : ''}" data-category-id="${cat.id ?? ''}" data-category-name="${cat.name}">
                            <span>${cat.name}</span>
                            <i class="fas fa-chevron-right category-icon"></i>
                        </button>
                    </li>`;
                }).join('');

                list.querySelectorAll('.category-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-category-id');
                        const name = btn.getAttribute('data-category-name');
                        state.activeCategory = { id: id ? parseInt(id) : null, name };
                        state.currentPage = 1;
                        document.getElementById('sectionTitle').textContent = name;
                        document.getElementById('breadcrumbCategory').textContent = name;
                        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${name}...`;
                        list.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        renderBooks();
                        closeMobileSidebar();
                    });
                });
            }
        }

        function getSortedItems(items) {
            const sortVal = document.getElementById('sortSelect')?.value ?? 'az';
            const arr = [...items];
            if (sortVal === 'az') {
                arr.sort((a, b) => (a.title || a.name || '').localeCompare(b.title || b.name || '', 'es'));
            } else if (sortVal === 'recent') {
                // Más recientes = mayor created_at primero
                arr.sort((a, b) => (b.created_at || '').localeCompare(a.created_at || ''));
            } else if (sortVal === 'old') {
                // Más antiguos = menor created_at primero
                arr.sort((a, b) => (a.created_at || '').localeCompare(b.created_at || ''));
            } else if (sortVal === 'year_asc') {
                arr.sort((a, b) => (parseInt(a.year) || 0) - (parseInt(b.year) || 0));
            } else if (sortVal === 'year_desc') {
                arr.sort((a, b) => (parseInt(b.year) || 0) - (parseInt(a.year) || 0));
            }
            return arr;
        }

        function renderPagination(containerId, totalItems, currentPage, onPageChange) {
            const container = document.getElementById(containerId);
            if (!container) return;
            const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
            if (totalPages <= 1) { container.innerHTML = ''; return; }

            const maxVisible = 7;
            let pages = [];
            if (totalPages <= maxVisible) {
                pages = Array.from({length: totalPages}, (_, i) => i + 1);
            } else {
                pages = [1];
                let start = Math.max(2, currentPage - 2);
                let end   = Math.min(totalPages - 1, currentPage + 2);
                if (start > 2)              pages.push('…');
                for (let i = start; i <= end; i++) pages.push(i);
                if (end < totalPages - 1)   pages.push('…');
                pages.push(totalPages);
            }

            container.innerHTML = `
            <nav class="bib-pagination" aria-label="Paginación">
                <button class="bib-page-btn bib-page-prev" ${currentPage === 1 ? 'disabled' : ''} onclick="(${onPageChange})(${currentPage - 1})">
                    <i class="fas fa-chevron-left"></i>
                </button>
                ${pages.map(p => p === '…'
                    ? `<span class="bib-page-ellipsis">…</span>`
                    : `<button class="bib-page-btn ${p === currentPage ? 'bib-page-active' : ''}" onclick="(${onPageChange})(${p})">${p}</button>`
                ).join('')}
                <button class="bib-page-btn bib-page-next" ${currentPage === totalPages ? 'disabled' : ''} onclick="(${onPageChange})(${currentPage + 1})">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </nav>`;
        }

        function renderBooks() {
            const grid = document.getElementById('booksGrid');
            const allItems = getSortedItems(getDataForSection());

            // Actualizar contador de recursos
            document.getElementById('resourceNumber').textContent = allItems.length;

            // Detectar tipo de sección
            const isAuthorsSection     = state.activeTab === 'Autores';
            const isEditorialesSection = false;
            const isEspecialesSection  = state.activeTab === 'Especiales';

            // Gestionar visibilidad de descriptor chips
            const chipsBar = document.getElementById('descriptorChipsBar');
            const hasDescriptors = ['Libros','Revistas','Waras Editorial'].includes(state.activeTab);
            if (hasDescriptors && topDescriptorsData.length > 0) {
                chipsBar.style.display = 'block';
                renderDescriptorChips();
            } else {
                chipsBar.style.display = 'none';
            }

            // ESPECIALES → galería de colecciones (sin paginación)
            if (isEspecialesSection) {
                const SPECIALS_PER_PAGE = 6;
                if (!state._specialsPage) state._specialsPage = 1;

                document.getElementById('resourceNumber').textContent = allItems.length;

                if (allItems.length === 0) {
                    grid.className = 'specials-gallery';
                    grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;"><i class="fas fa-star" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>No hay colecciones especiales disponibles.</div>`;
                    document.getElementById('booksPagination').innerHTML = '';
                    return;
                }

                const totalSpecialsPages = Math.ceil(allItems.length / SPECIALS_PER_PAGE);
                if (state._specialsPage > totalSpecialsPages) state._specialsPage = totalSpecialsPages;
                const sStart = (state._specialsPage - 1) * SPECIALS_PER_PAGE;
                const pageItems = allItems.slice(sStart, sStart + SPECIALS_PER_PAGE);

                grid.className = 'specials-gallery';
                grid.innerHTML = pageItems.map(s => {
                    const isRev = s.type === 'revista';
                    const label = isRev ? 'Revistas' : 'Libros';
                    const count = s.books_count;
                    const countLabel = count + ' ' + (isRev ? (count === 1 ? 'revista' : 'revistas') : (count === 1 ? 'libro' : 'libros'));
                    const typeColor = isRev ? 'background:#2563eb;color:#fff' : 'background:#059669;color:#fff';
                    const coverHtml = s.cover_url
                        ? `<img src="${s.cover_url}" alt="${s.title}" onerror="this.style.display='none'">`
                        : `<i class="fas fa-star" style="font-size:2.5rem;color:rgba(255,255,255,0.3);position:relative;z-index:1;"></i>`;
                    return `
                    <div class="special-card">
                        <div class="special-card-cover">
                            ${coverHtml}
                            <span class="special-card-type" style="${typeColor}">${label}</span>
                        </div>
                        <div class="special-card-body">
                            <div class="special-card-title">${s.title}</div>
                            <div class="special-card-count"><i class="fas fa-book" style="margin-right:0.3rem;opacity:0.5;"></i>${countLabel} asignados</div>
                            <a href="/biblioteca/especiales/${s.id}" class="special-card-btn">Ver colección →</a>
                        </div>
                    </div>`;
                }).join('');

                // Paginación numérica
                const pag = document.getElementById('booksPagination');
                if (totalSpecialsPages <= 1) {
                    pag.innerHTML = '';
                } else {
                    let pagHtml = '<div class="specials-pagination">';
                    pagHtml += `<button ${state._specialsPage === 1 ? 'disabled' : ''} onclick="goSpecialsPage(${state._specialsPage - 1})"><i class="fas fa-chevron-left"></i></button>`;
                    for (let p = 1; p <= totalSpecialsPages; p++) {
                        pagHtml += `<button class="${p === state._specialsPage ? 'active' : ''}" onclick="goSpecialsPage(${p})">${p}</button>`;
                    }
                    pagHtml += `<button ${state._specialsPage === totalSpecialsPages ? 'disabled' : ''} onclick="goSpecialsPage(${state._specialsPage + 1})"><i class="fas fa-chevron-right"></i></button>`;
                    pagHtml += '</div>';
                    pag.innerHTML = pagHtml;
                }
                return;
            }

            // Paginación
            const totalItems = allItems.length;
            const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE) || 1;
            if (state.currentPage > totalPages) state.currentPage = totalPages;
            const start = (state.currentPage - 1) * ITEMS_PER_PAGE;
            const items = allItems.slice(start, start + ITEMS_PER_PAGE);

            // Restaurar grid normal si veníamos de especiales
            grid.className = 'books-grid';

            if (isAuthorsSection) {
                // Template para AUTORES
                grid.innerHTML = items.map((item, index) => `
                    <div class="book-card">
                        <div class="book-cover" style="background:linear-gradient(135deg,#2d3436 0%,#636e72 100%);">
                            ${item.photo_url
                                ? `<img src="${item.photo_url}" alt="${item.name}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" onerror="this.style.display='none'">`
                                : `<i class="fas fa-user" style="font-size:3rem;color:white;opacity:0.6;position:relative;z-index:1;"></i>`}
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${item.name || 'Sin nombre'}</h3>
                            <p class="book-author" style="color:#888; font-size:0.875rem;">${item.nationality || 'Desconocida'}</p>
                            <p class="book-year" style="margin-top:0.4rem; color:#666; font-size:0.8rem; display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${item.biography || 'Sin biografía disponible'}</p>
                            <div class="book-footer">
                                <a href="/biblioteca/autores/${item.id}" class="book-read-link">Más información →</a>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                // Template para LIBROS Y REVISTAS
                grid.innerHTML = items.map((item, index) => `
                    <div class="book-card">
                        <div class="book-cover book-cover-clickable" data-item-id="book-${index}" style="background:linear-gradient(135deg,${item.color} 0%,${item.color}cc 100%);cursor:pointer;">
                            <span class="book-badge">${item.type}</span>
                            ${item.cover_url
                                ? `<img src="${item.cover_url}" alt="${item.title}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
                                : `<span class="book-cover-icon">${item.icon}</span>`}
                            <div class="book-cover-overlay">
                                <button class="book-detail-btn">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </button>
                            </div>
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${item.title}</h3>
                            <p class="book-author">${item.author}</p>
                            <p class="book-year">Publicación: ${item.year}</p>
                            <div class="book-footer">
                                <span style="font-size:0.75rem;color:#9ca3af;">${item.pages} págs.</span>
                                ${item.read_url
                                    ? `<a href="${item.read_url}" target="_blank" rel="noopener" class="book-read-link">Leer →</a>`
                                    : `<span class="book-read-link" style="opacity:0.35;cursor:default;">Sin acceso</span>`}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            renderPagination('booksPagination', totalItems, state.currentPage, function(page) {
                state.currentPage = page;
                renderBooks();
                document.getElementById('booksGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });

            // Agregar event listeners a los botones
            document.querySelectorAll('.book-cover-clickable').forEach((btn, index) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    closeMobileSidebar();
                    const item = items[index];
                    showDetailView(item);
                });
            });
        }

        function hideAllSections() {
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('inicioSection').classList.add('hidden');
            document.getElementById('mainWrapper').classList.add('hidden');
            document.getElementById('detailView').classList.add('hidden');
        }

        function showSection(tab) {
            state.activeTab = tab;
            state.currentPage = 1;
            state._specialsPage = 1;
            state.openAccordions.clear();
            state.closedAccordions.clear();

            hideAllSections();

            const useAccordion = ['Libros', 'Revistas', 'Waras Editorial'].includes(tab) && categoriesFromDatabase.length > 0;
            if (useAccordion) {
                state.activeCategory = { id: null, name: 'Todos' };
            } else {
                const firstCat = (categoriesBySection[tab] || categoriesBySection['Libros'])[0] || { id: null, name: tab };
                state.activeCategory = firstCat;
            }

            const TABS_NO_SIDEBAR = new Set(['Especiales', 'Autores']);
            const wrapper = document.getElementById('mainWrapper');
            wrapper.classList.remove('hidden');
            wrapper.classList.toggle('no-sidebar', TABS_NO_SIDEBAR.has(tab));
            document.getElementById('sectionTitle').textContent = tab;
            document.getElementById('breadcrumbCategory').textContent = tab;
            document.getElementById('contentSearchInput').placeholder = `Buscar en ${tab}...`;

            renderCategories();
            renderBooks();
            updateNavigation();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function showHero() {
            state.activeTab = 'Inicio';
            state.activeCategory = null;

            hideAllSections();
            document.getElementById('heroSection').classList.remove('hidden');
            document.getElementById('inicioSection').classList.remove('hidden');

            updateNavigation();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function updateNavigation() {
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.toggle('active', item.getAttribute('data-tab') === state.activeTab);
            });
            // Update browser URL without reload (history state)
            const tabUrlMap = {
                'Inicio':          '{{ route('biblioteca.dashboard') }}',
                'Libros':          '{{ route('biblioteca.libros.index') }}',
                'Revistas':        '{{ route('biblioteca.revistas.index') }}',
                'Waras Editorial': '{{ route('biblioteca.editorial.index') }}',
                'Especiales':      '{{ route('biblioteca.especiales.index') }}',
                'Autores':         '{{ route('biblioteca.autores.index') }}',
            };
            if (tabUrlMap[state.activeTab]) {
                history.replaceState(null, '', tabUrlMap[state.activeTab]);
            }
        }

        document.getElementById('logoBtn').addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = '{{ route('biblioteca.dashboard') }}';
        });
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = btn.getAttribute('href');
            });
        });

        // ========== FUNCIONES PARA VISTA DE DETALLE ==========
        let currentMaterial = null;

        function showDetailView(item) {
            if (item.detail_url) {
                sessionStorage.setItem('biblioteca_tab', state.activeTab);
                window.location.href = item.detail_url;
                return;
            }
            currentMaterial = item;

            // Llenar información
            document.getElementById('detailTitle').textContent    = item.title;
            document.getElementById('detailAuthor').textContent   = item.author;
            document.getElementById('detailYear').textContent     = item.year;
            document.getElementById('detailPages').textContent    = item.pages || 'N/A';
            document.getElementById('detailLanguage').textContent = item.language || 'Español';
            document.getElementById('detailRating').textContent   = item.isbn || 'N/A';
            document.getElementById('detailSynopsis').textContent = item.description;
            document.getElementById('detailPublisher').textContent= item.publisher;
            document.getElementById('breadcrumb-category').textContent = state.activeCategory ? state.activeCategory.name : '';
            document.getElementById('breadcrumb-title').textContent    = item.title;

            // Cover info
            const detailCover = document.getElementById('detailCover');
            detailCover.style.background = item.cover_url
                ? `url('${item.cover_url}') center/cover no-repeat`
                : `linear-gradient(135deg, ${item.color || '#5c4033'} 0%, ${item.color || '#5c4033'}cc 100%)`;
            document.getElementById('detailCoverIcon').textContent = item.cover_url ? '' : item.icon;

            // Materiales relacionados
            renderRelatedMaterials(item);

            // Botón "Leer en línea"
            const btnLeer = document.getElementById('btnLeerLinea');
            if (item.source_type === 'external' && item.external_url) {
                btnLeer.href = item.external_url;
                btnLeer.style.display = '';
                btnLeer.style.opacity = '1';
                btnLeer.style.pointerEvents = '';
            } else if (item.source_type === 'pdf' && item.pdf_path) {
                btnLeer.href = '/storage/' + item.pdf_path;
                btnLeer.style.display = '';
                btnLeer.style.opacity = '1';
                btnLeer.style.pointerEvents = '';
            } else {
                btnLeer.href = '#';
                btnLeer.style.opacity = '0.4';
                btnLeer.style.pointerEvents = 'none';
            }

            // Botón compartir — copia URL con hash para identificar el libro
            const btnCompartir = document.getElementById('btnCompartir');
            const shareToast   = document.getElementById('shareToast');
            btnCompartir.onclick = () => {
                const shareUrl = window.location.origin + window.location.pathname + '?libro=' + item.id;
                navigator.clipboard.writeText(shareUrl).then(() => {
                    shareToast.style.display = 'block';
                    setTimeout(() => { shareToast.style.display = 'none'; }, 2500);
                }).catch(() => {
                    // Fallback para navegadores sin clipboard API
                    const ta = document.createElement('textarea');
                    ta.value = shareUrl;
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                    shareToast.style.display = 'block';
                    setTimeout(() => { shareToast.style.display = 'none'; }, 2500);
                });
            };

            // Mostrar vista de detalle, ocultar otros
            document.getElementById('mainWrapper').classList.add('hidden');
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('detailView').classList.remove('hidden');

            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function goBackToCatalog() {
            document.getElementById('detailView').classList.add('hidden');
            document.getElementById('mainWrapper').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function renderRelatedMaterials(currentItem) {
            const grid = document.getElementById('relatedGrid');
            const allItems = getDataForSection();
            
            // Obtener 3 items relacionados (excluyendo el actual)
            const related = allItems.filter(item => item.id !== currentItem.id).slice(0, 3);

            grid.innerHTML = related.map((item, index) => `
                <div class="related-card" data-related-index="${index}">
                    <div class="related-cover" style="background:${item.cover_url ? `url('${item.cover_url}') center/cover no-repeat` : `linear-gradient(135deg,${item.color || '#5c4033'} 0%,${item.color || '#5c4033'}cc 100%)`};">
                        <span class="related-badge">${item.type}</span>
                        ${item.cover_url ? '' : `<span class="related-icon">${item.icon}</span>`}
                    </div>
                    <div class="related-info">
                        <div class="related-title">${item.title}</div>
                        <div class="related-author">${item.author}</div>
                    </div>
                </div>`
            ).join('');

            // Agregar event listeners a las tarjetas relacionadas
            document.querySelectorAll('.related-card').forEach((card, index) => {
                card.addEventListener('click', () => {
                    const item = related[index];
                    showDetailView(item);
                });
            });
        }

        renderCategories();
        renderBooks();

        // Back button event listener
        document.getElementById('backBtn').addEventListener('click', goBackToCatalog);

        // Inicializar placeholder del search
        const initCatName = state.activeCategory ? state.activeCategory.name : '';
        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${initCatName}...`;

        // Activar sección según la ruta visitada (definida por el servidor)
        const validTabs = ['Inicio','Libros','Revistas','Waras Editorial','Especiales','Autores'];

        // serverActiveSection tiene prioridad cuando la URL apunta a una sección concreta.
        // sessionStorage solo aplica cuando se llega al dashboard raíz (/biblioteca o /biblioteca/inicio).
        const sectionTab = validTabs.includes(serverActiveSection) ? serverActiveSection : 'Inicio';
        if (sectionTab !== 'Inicio') {
            sessionStorage.removeItem('biblioteca_tab');
            showSection(sectionTab);
        } else {
            const pendingTab = sessionStorage.getItem('biblioteca_tab');
            if (pendingTab && validTabs.includes(pendingTab)) {
                sessionStorage.removeItem('biblioteca_tab');
                if (pendingTab === 'Inicio') showHero(); else showSection(pendingTab);
            } else {
                showHero();
            }
        }

        // ========== BÚSQUEDA ==========

        // Fuente de datos plana para búsqueda global
        function getAllSearchableItems() {
            const books   = dataBySectionAndCategory['Libros']['default']   || [];
            const mags    = dataBySectionAndCategory['Revistas']['default'] || [];
            const authors = dataBySectionAndCategory['Autores']['default']  || [];
            return { books, mags, authors };
        }

        function normalizeStr(s) {
            return (s || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }

        // ---- HERO DROPDOWN ----
        const heroInput    = document.getElementById('heroSearchInput');
        const heroDropdown = document.getElementById('heroDropdown');
        const heroBtn      = document.getElementById('heroSearchBtn');

        function renderHeroDropdown(q) {
            if (!q) { heroDropdown.classList.remove('open'); return; }
            const nq = normalizeStr(q);
            const { books, mags, authors } = getAllSearchableItems();

            const matchBooks = books.filter(b =>
                normalizeStr(b.title).includes(nq) ||
                (b.authorNames || []).some(n => normalizeStr(n).includes(nq)) ||
                (b.descriptorNames || []).some(d => normalizeStr(d).includes(nq)) ||
                normalizeStr(b.description).includes(nq)
            ).slice(0, 4);

            const matchMags = mags.filter(b =>
                normalizeStr(b.title).includes(nq) ||
                normalizeStr(b.author).includes(nq)
            ).slice(0, 3);

            const matchAuthors = authors.filter(a =>
                normalizeStr(a.name).includes(nq) ||
                normalizeStr(a.nationality).includes(nq) ||
                normalizeStr(a.biography).includes(nq)
            ).slice(0, 3);

            const total = matchBooks.length + matchMags.length + matchAuthors.length;

            if (total === 0) {
                heroDropdown.innerHTML = `<div class="hsd-empty">Sin resultados para "<strong>${q}</strong>"</div>`;
                heroDropdown.classList.add('open');
                return;
            }

            let html = '';

            if (matchBooks.length) {
                html += `<div class="hsd-section-label">Libros</div>`;
                html += matchBooks.map(b => `
                    <div class="hsd-item" data-action="book-detail" data-tab="Libros" data-id="${b.id}">
                        <div class="hsd-thumb" style="background:${b.cover_url ? 'none' : `linear-gradient(135deg,${b.color},${b.color}cc)`};">
                            ${b.cover_url ? `<img src="${b.cover_url}" alt="">` : b.icon}
                        </div>
                        <div class="hsd-info">
                            <div class="hsd-title">${b.title}</div>
                            <div class="hsd-sub">${b.author} · ${b.year}</div>
                        </div>
                        <span class="hsd-badge">Libro</span>
                    </div>`).join('');
            }

            if (matchMags.length) {
                html += `<div class="hsd-section-label">Revistas</div>`;
                html += matchMags.map(b => `
                    <div class="hsd-item" data-action="book-detail" data-tab="Revistas" data-id="${b.id}">
                        <div class="hsd-thumb" style="background:linear-gradient(135deg,${b.color},${b.color}cc);">
                            ${b.cover_url ? `<img src="${b.cover_url}" alt="">` : b.icon}
                        </div>
                        <div class="hsd-info">
                            <div class="hsd-title">${b.title}</div>
                            <div class="hsd-sub">${b.author} · ${b.year}</div>
                        </div>
                        <span class="hsd-badge">Revista</span>
                    </div>`).join('');
            }

            if (matchAuthors.length) {
                html += `<div class="hsd-section-label">Autores</div>`;
                html += matchAuthors.map(a => `
                    <a class="hsd-item" href="/biblioteca/autores/${a.id}">
                        <div class="hsd-thumb">
                            ${a.photo_url ? `<img src="${a.photo_url}" alt="">` : '<i class="fas fa-user" style="color:rgba(255,255,255,0.6);font-size:1rem;"></i>'}
                        </div>
                        <div class="hsd-info">
                            <div class="hsd-title">${a.name}</div>
                            <div class="hsd-sub">${a.nationality}</div>
                        </div>
                        <span class="hsd-badge">Autor</span>
                    </a>`).join('');
            }

            html += `<button class="hsd-all-btn" id="hsdAllBtn">Ver todos los resultados para "${q}" →</button>`;

            heroDropdown.innerHTML = html;
            heroDropdown.classList.add('open');

            // Clic en resultado libro/revista → abrir detalle
            heroDropdown.querySelectorAll('.hsd-item[data-action="book-detail"]').forEach(el => {
                el.addEventListener('click', () => {
                    const tab = el.dataset.tab;
                    const id  = parseInt(el.dataset.id);
                    const allItems = dataBySectionAndCategory[tab]['default'];
                    const item = allItems.find(i => i.id === id);
                    if (!item) return;
                    heroDropdown.classList.remove('open');
                    heroInput.value = '';
                    closeMobileSidebar();
                    showSection(tab);
                    showDetailView(item);
                });
            });

            // "Ver todos" → ir a Libros con búsqueda activa
            document.getElementById('hsdAllBtn')?.addEventListener('click', () => {
                heroDropdown.classList.remove('open');
                showSection('Libros');
                const ci = document.getElementById('contentSearchInput');
                ci.value = q;
                ci.dispatchEvent(new Event('input'));
            });
        }

        heroInput.addEventListener('input', () => renderHeroDropdown(heroInput.value.trim()));

        heroBtn.addEventListener('click', () => {
            const q = heroInput.value.trim();
            if (!q) return;
            heroDropdown.classList.remove('open');
            closeMobileSidebar();
            showSection('Libros');
            const ci = document.getElementById('contentSearchInput');
            ci.value = q;
            ci.dispatchEvent(new Event('input'));
        });

        heroInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') heroBtn.click();
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('.hero-search-container')) {
                heroDropdown.classList.remove('open');
            }
        });


        // ========== DESCRIPTOR CHIPS ==========

        function renderDescriptorChips() {
            const bar = document.getElementById('descriptorChipsBar');
            const chips = topDescriptorsData.map(d => {
                const isActive = activeDescriptorId === d.id;
                return `<button class="descriptor-chip${isActive ? ' active' : ''}" data-id="${d.id}" data-name="${d.name}" onclick="toggleDescriptorChip(${d.id}, '${d.name.replace(/'/g,"\\'")}')">
                    ${d.name} <span class="chip-count">${d.books_count}</span>
                </button>`;
            }).join('');
            bar.innerHTML = `<div class="descriptor-chips-wrap">${chips}</div>`;
        }

        function toggleDescriptorChip(id, name) {
            if (activeDescriptorId === id) {
                activeDescriptorId = null;
                document.getElementById('contentSearchInput').value = '';
                renderBooks();
            } else {
                activeDescriptorId = id;
                document.getElementById('contentSearchInput').value = name;
                filterByDescriptor(id);
            }
            renderDescriptorChips();
        }

        function filterByDescriptor(descriptorId) {
            const tab = state.activeTab;
            const allItems = dataBySectionAndCategory[tab]?.['default'] || [];
            const filtered = allItems.filter(item =>
                item.descriptorIds && item.descriptorIds.includes(descriptorId)
            );
            searchFilteredItems = filtered;
            state.currentPage = 1;
            const grid = document.getElementById('booksGrid');
            grid.className = 'books-grid';
            document.getElementById('resourceNumber').textContent = filtered.length;
            if (filtered.length === 0) {
                document.getElementById('booksPagination').innerHTML = '';
                grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;">
                    <i class="fas fa-tag" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>
                    Sin resultados para el descriptor "<strong style="color:#6b7280;">${document.getElementById('contentSearchInput').value}</strong>"
                </div>`;
                return;
            }
            function renderDescPage(p) {
                state.currentPage = p;
                const start = (p - 1) * ITEMS_PER_PAGE;
                renderBookItems(grid, filtered.slice(start, start + ITEMS_PER_PAGE));
                renderPagination('booksPagination', filtered.length, p, renderDescPage);
                if (p > 1) grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            renderDescPage(1);
        }

        function renderBookItems(grid, items) {
            grid.innerHTML = items.map((item, index) => `
                <div class="book-card">
                    <div class="book-cover book-cover-clickable" data-item-idx="${index}" style="background:linear-gradient(135deg,${item.color} 0%,${item.color}cc 100%);cursor:pointer;">
                        <span class="book-badge">${item.type}</span>
                        ${item.cover_url
                            ? `<img src="${item.cover_url}" alt="${item.title}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
                            : `<span class="book-cover-icon">${item.icon}</span>`}
                        <div class="book-cover-overlay">
                            <button class="book-detail-btn">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </button>
                        </div>
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">${item.title}</h3>
                        <p class="book-author">${item.author}</p>
                        <p class="book-year">Publicación: ${item.year}</p>
                        <div class="book-footer">
                            <span style="font-size:0.75rem;color:#9ca3af;">${item.pages} págs.</span>
                            ${item.read_url
                                ? `<a href="${item.read_url}" target="_blank" rel="noopener" class="book-read-link">Leer →</a>`
                                : `<span class="book-read-link" style="opacity:0.35;cursor:default;">Sin acceso</span>`}
                        </div>
                    </div>
                </div>
            `).join('');
            grid.querySelectorAll('.book-cover-clickable').forEach((btn, idx) => {
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    closeMobileSidebar();
                    showDetailView(items[parseInt(btn.dataset.itemIdx)]);
                });
            });
        }

        // ========== SUGERENCIAS DE DESCRIPTORES EN BUSCADOR ==========
        const descriptorSuggestions = document.getElementById('descriptorSuggestions');

        function showDescriptorSuggestions(q) {
            if (!q || q.length < 2) { descriptorSuggestions.style.display = 'none'; return; }
            const nq = q.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g,'');
            const matches = topDescriptorsData.filter(d =>
                d.name.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g,'').includes(nq)
            ).slice(0, 6);
            if (!matches.length) { descriptorSuggestions.style.display = 'none'; return; }
            descriptorSuggestions.innerHTML = matches.map(d => `
                <div class="descriptor-suggestion-item" onclick="applyDescriptorSuggestion(${d.id}, '${d.name.replace(/'/g,"\\'")}')">
                    <span><i class="fas fa-tag" style="margin-right:0.4rem;color:#c5a059;font-size:0.75rem;"></i>${d.name}</span>
                    <span class="ds-count">${d.books_count} recursos</span>
                </div>`).join('');
            descriptorSuggestions.style.display = 'block';
        }

        function applyDescriptorSuggestion(id, name) {
            descriptorSuggestions.style.display = 'none';
            activeDescriptorId = id;
            document.getElementById('contentSearchInput').value = name;
            filterByDescriptor(id);
            renderDescriptorChips();
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('.content-search')) descriptorSuggestions.style.display = 'none';
        });

        // ---- BÚSQUEDA EN CATÁLOGO (filtra tarjetas visibles) ----
        document.getElementById('sortSelect').addEventListener('change', function() {
            closeMobileSidebar();
            state.currentPage = 1;
            searchFilteredItems = null;
            document.getElementById('contentSearchInput').value = '';
            renderBooks();
        });

        let searchFilteredItems = null; // null = not in search mode

        document.getElementById('contentSearchInput').addEventListener('input', function() {
            closeMobileSidebar();
            const rawQ = this.value.trim();
            const q    = normalizeStr(rawQ);
            const isAuthors    = state.activeTab === 'Autores';
            const isEspeciales = state.activeTab === 'Especiales';

            // Mostrar sugerencias de descriptores
            showDescriptorSuggestions(rawQ);

            if (!q) {
                activeDescriptorId = null;
                searchFilteredItems = null;
                state.currentPage = 1;
                state._specialsPage = 1;
                renderDescriptorChips();
                renderBooks();
                return;
            }

            // Búsqueda dentro de Especiales: filtrar colecciones por nombre
            if (isEspeciales) {
                const allSpecials = getDataForSection();
                const filtered = allSpecials.filter(s => normalizeStr(s.title).includes(q));
                const grid = document.getElementById('booksGrid');
                grid.className = 'specials-gallery';
                document.getElementById('resourceNumber').textContent = filtered.length;
                document.getElementById('booksPagination').innerHTML = '';
                if (filtered.length === 0) {
                    grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;">
                        <i class="fas fa-search" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>
                        Sin resultados para "<strong style="color:#6b7280;">${rawQ}</strong>"
                    </div>`;
                } else {
                    grid.innerHTML = filtered.map(s => {
                        const isRev = s.type === 'revista';
                        const label = isRev ? 'Revistas' : 'Libros';
                        const count = s.books_count;
                        const countLabel = count + ' ' + (isRev ? (count === 1 ? 'revista' : 'revistas') : (count === 1 ? 'libro' : 'libros'));
                        const typeColor = isRev ? 'background:#2563eb;color:#fff' : 'background:#059669;color:#fff';
                        const coverHtml = s.cover_url
                            ? `<img src="${s.cover_url}" alt="${s.title}" onerror="this.style.display='none'">`
                            : `<i class="fas fa-star" style="font-size:2.5rem;color:rgba(255,255,255,0.3);position:relative;z-index:1;"></i>`;
                        return `<div class="special-card">
                            <div class="special-card-cover">${coverHtml}<span class="special-card-type" style="${typeColor}">${label}</span></div>
                            <div class="special-card-body">
                                <div class="special-card-title">${s.title}</div>
                                <div class="special-card-count"><i class="fas fa-book" style="margin-right:0.3rem;opacity:0.5;"></i>${countLabel} asignados</div>
                                <a href="/biblioteca/especiales/${s.id}" class="special-card-btn">Ver colección →</a>
                            </div>
                        </div>`;
                    }).join('');
                }
                return;
            }

            // Si no hay descriptor activo, limpiar selección de chip
            if (activeDescriptorId !== null) {
                activeDescriptorId = null;
                renderDescriptorChips();
            }

            const baseItems = getDataForSection();

            const filtered = baseItems.filter(item => {
                if (isAuthors) {
                    return normalizeStr(item.name).includes(q) ||
                           normalizeStr(item.nationality).includes(q) ||
                           normalizeStr(item.biography).includes(q);
                }
                // Búsqueda OR: título + todos los autores + todos los descriptores/tags
                const matchTitle  = normalizeStr(item.title).includes(q);
                const matchAuthor = (item.authorNames || []).some(n => normalizeStr(n).includes(q));
                const matchDesc   = (item.descriptorNames || []).some(dn => normalizeStr(dn).includes(q));
                const matchExtra  = normalizeStr(item.description).includes(q) ||
                                    normalizeStr(item.publisher).includes(q) ||
                                    normalizeStr(String(item.year)).includes(q);
                return matchTitle || matchAuthor || matchDesc || matchExtra;
            });

            // Boost: descriptor matches first, then title matches, then rest
            filtered.sort((a, b) => {
                const aD = (a.descriptorNames || []).some(dn => normalizeStr(dn).includes(q)) ? 0 : 1;
                const bD = (b.descriptorNames || []).some(dn => normalizeStr(dn).includes(q)) ? 0 : 1;
                if (aD !== bD) return aD - bD;
                const aT = normalizeStr(a.title || a.name || '').includes(q) ? 0 : 1;
                const bT = normalizeStr(b.title || b.name || '').includes(q) ? 0 : 1;
                return aT - bT;
            });

            searchFilteredItems = filtered;
            state.currentPage = 1;
            renderSearchResults(filtered, rawQ, isAuthors);
        });

        function renderSearchResults(filtered, rawQ, isAuthors) {
            const grid = document.getElementById('booksGrid');
            grid.className = 'books-grid';
            document.getElementById('resourceNumber').textContent = filtered.length;

            if (filtered.length === 0) {
                document.getElementById('booksPagination').innerHTML = '';
                grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;">
                    <i class="fas fa-search" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>
                    Sin resultados para "<strong style="color:#6b7280;">${rawQ}</strong>"
                </div>`;
                return;
            }

            const totalPages = Math.ceil(filtered.length / ITEMS_PER_PAGE) || 1;
            if (state.currentPage > totalPages) state.currentPage = totalPages;
            const start = (state.currentPage - 1) * ITEMS_PER_PAGE;
            const page  = filtered.slice(start, start + ITEMS_PER_PAGE);

            if (isAuthors) {
                grid.innerHTML = page.map(item => `
                    <div class="book-card">
                        <div class="book-cover" style="background:linear-gradient(135deg,#2d3436 0%,#636e72 100%);">
                            ${item.photo_url
                                ? `<img src="${item.photo_url}" alt="${item.name}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" onerror="this.style.display='none'">`
                                : `<i class="fas fa-user" style="font-size:3rem;color:white;opacity:0.6;position:relative;z-index:1;"></i>`}
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${item.name || 'Sin nombre'}</h3>
                            <p class="book-author" style="color:#888;font-size:0.875rem;">${item.nationality || 'Desconocida'}</p>
                            <p class="book-year" style="margin-top:0.4rem;color:#666;font-size:0.8rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${item.biography || ''}</p>
                            <div class="book-footer">
                                <a href="/biblioteca/autores/${item.id}" class="book-read-link">Más información →</a>
                            </div>
                        </div>
                    </div>`).join('');
            } else {
                grid.innerHTML = page.map((item, idx) => `
                    <div class="book-card">
                        <div class="book-cover book-cover-clickable" data-search-idx="${idx}" style="background:linear-gradient(135deg,${item.color} 0%,${item.color}cc 100%);cursor:pointer;">
                            <span class="book-badge">${item.type}</span>
                            ${item.cover_url
                                ? `<img src="${item.cover_url}" alt="${item.title}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
                                : `<span class="book-cover-icon">${item.icon}</span>`}
                            <div class="book-cover-overlay">
                                <button class="book-detail-btn">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </button>
                            </div>
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${item.title}</h3>
                            <p class="book-author">${item.author}</p>
                            <p class="book-year">Publicación: ${item.year}</p>
                            <div class="book-footer">
                                <span style="font-size:0.75rem;color:#9ca3af;">${item.pages} págs.</span>
                                ${item.read_url
                                    ? `<a href="${item.read_url}" target="_blank" rel="noopener" class="book-read-link">Leer →</a>`
                                    : `<span class="book-read-link" style="opacity:0.35;cursor:default;">Sin acceso</span>`}
                            </div>
                        </div>
                    </div>`).join('');

                grid.querySelectorAll('.book-cover-clickable').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.preventDefault();
                        closeMobileSidebar();
                        const item = page[parseInt(btn.dataset.searchIdx)];
                        if (item) showDetailView(item);
                    });
                });
            }

            renderPagination('booksPagination', filtered.length, state.currentPage, function(p) {
                state.currentPage = p;
                renderSearchResults(filtered, rawQ, isAuthors);
                document.getElementById('booksGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }

        // ========== MOBILE NAV ==========
        function openMobileNav()  {
            document.getElementById('mobileNav').classList.add('open');
            document.getElementById('mobileNavOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeMobileNav() {
            document.getElementById('mobileNav').classList.remove('open');
            document.getElementById('mobileNavOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        window.openMobileNav  = openMobileNav;
        window.closeMobileNav = closeMobileNav;

        // ========== MOBILE SIDEBAR ==========
        function openMobileSidebar() {
            document.getElementById('mobileSidebar').classList.add('mobile-open');
            document.getElementById('sidebarOverlay').classList.add('open');
            document.getElementById('sidebarCloseBtn').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        function closeMobileSidebar() {
            document.getElementById('mobileSidebar').classList.remove('mobile-open');
            document.getElementById('sidebarOverlay').classList.remove('open');
            document.getElementById('sidebarCloseBtn').style.display = 'none';
            document.body.style.overflow = '';
        }
        window.openMobileSidebar  = openMobileSidebar;
        window.closeMobileSidebar = closeMobileSidebar;

        window.goSpecialsPage = function(page) {
            state._specialsPage = page;
            renderGrid();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        // ========== CARRUSELES DE INICIO ==========
        (function() {
            const CARD_W_BOOK   = 240 + 24;   // width + margin*2
            const CARD_W_AUTHOR = 150 + 20;
            const VISIBLE       = Math.floor(window.innerWidth / CARD_W_BOOK) + 2;

            const rawLibros   = @json($booksData['Libros'] ?? []);
            const rawAutores  = @json($booksData['Autores'] ?? []);
            const rawRevistas = @json($booksData['Revistas'] ?? []);

            const routes = {
                libro:   '/biblioteca/libros/',
                autor:   '/biblioteca/autores/',
                revista: '/biblioteca/revistas/',
            };

            function bookCardHTML(book) {
                const cover = book.cover_image_path ? `/storage/${book.cover_image_path}` : null;
                const authors = (book.authors || []).map(a => a.name).join(', ') || 'Desconocido';
                return `<div class="bib-carousel-card" onclick="window.location.href='${routes.libro}${book.id}'">
                    ${cover
                        ? `<img class="bib-card-cover" src="${cover}" alt="${book.title}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="bib-card-cover-placeholder">📚</div>`}
                    <div class="bib-card-body">
                        <p class="bib-card-title">${book.title}</p>
                        <p class="bib-card-sub">${authors}</p>
                    </div>
                </div>`;
            }

            function authorCardHTML(author) {
                const photo = author.photo_path ? `/storage/${author.photo_path}` : null;
                return `<div class="bib-author-card" onclick="window.location.href='${routes.autor}${author.id}'">
                    ${photo
                        ? `<img class="bib-author-avatar" src="${photo}" alt="${author.name}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="bib-author-placeholder">👤</div>`}
                    <div class="bib-author-body">
                        <p class="bib-author-name">${author.name}</p>
                        <p class="bib-author-nat">${author.nationality || ''}</p>
                    </div>
                </div>`;
            }

            function revistaCardHTML(book) {
                const cover = book.cover_image_path ? `/storage/${book.cover_image_path}` : null;
                const pub = book.publisher ? book.publisher.name : '';
                return `<div class="bib-carousel-card" onclick="window.location.href='${routes.revista}${book.id}'">
                    ${cover
                        ? `<img class="bib-card-cover" src="${cover}" alt="${book.title}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="bib-card-cover-placeholder">📰</div>`}
                    <div class="bib-card-body">
                        <p class="bib-card-title">${book.title}</p>
                        <p class="bib-card-sub">${pub}</p>
                    </div>
                </div>`;
            }

            // Mezcla aleatoria (Fisher-Yates)
            function shuffle(arr) {
                const a = [...arr];
                for (let i = a.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [a[i], a[j]] = [a[j], a[i]];
                }
                return a;
            }

            // Rellena hasta minLen repitiendo el array base
            function fillTo(base, minLen) {
                let out = [];
                while (out.length < minLen) out = out.concat(base);
                return out;
            }

            function buildCarousel(trackId, dotsId, rawItems, cardFn, cardW) {
                if (!rawItems.length) return null;

                const track  = document.getElementById(trackId);
                const dotsEl = document.getElementById(dotsId);
                if (!track || !dotsEl) return null;

                // Máximo 20 al azar
                const base = shuffle(rawItems).slice(0, 20);
                const n    = base.length; // tamaño del "ciclo" para dots

                // Necesitamos al menos: 3 pantallas llenas a cada lado + pantalla central
                const visibleCount = Math.ceil(window.innerWidth / cardW) + 2;
                const minTotal     = visibleCount * 7; // 7 pantallas de margen
                const pool         = fillTo(base, minTotal);
                const total        = pool.length;

                track.innerHTML = pool.map(cardFn).join('');
                track.style.gap = '0';

                // Empezar en el centro del pool
                let current  = Math.floor(total / 2);
                // Ajustar al múltiplo de n más cercano al centro
                current = Math.round(current / n) * n;
                let busy     = false;
                let autoTimer;

                // Dots (máx 8)
                dotsEl.innerHTML = '';
                const dotCount = Math.min(n, 8);
                for (let i = 0; i < dotCount; i++) {
                    const d = document.createElement('div');
                    d.className = 'ico-dot' + (i === 0 ? ' active' : '');
                    const target = current + i;
                    d.addEventListener('click', () => { if (!busy) go(target); });
                    dotsEl.appendChild(d);
                }

                function applyTransform(animated) {
                    track.style.transition = animated ? 'transform 500ms ease-in-out' : 'none';
                    track.style.transform  = `translateX(${-current * cardW}px)`;
                }

                function updateDots() {
                    dotsEl.querySelectorAll('.ico-dot').forEach((d, i) => {
                        d.classList.toggle('active', i === ((current % n + n) % n));
                    });
                }

                function go(next) {
                    if (busy) return;
                    busy = true;
                    current = next;
                    applyTransform(true);
                    updateDots();
                    setTimeout(() => {
                        // Si nos acercamos demasiado a los bordes, teleport al centro
                        const safeZone = visibleCount * 2;
                        if (current >= total - safeZone) {
                            current -= Math.floor(total / 2 / n) * n;
                            applyTransform(false);
                            updateDots();
                        } else if (current < safeZone) {
                            current += Math.floor(total / 2 / n) * n;
                            applyTransform(false);
                            updateDots();
                        }
                        busy = false;
                    }, 520);
                }

                function startAuto() {
                    clearInterval(autoTimer);
                    autoTimer = setInterval(() => { if (!busy) go(current + 1); }, 3500);
                }

                applyTransform(false);
                updateDots();
                startAuto();

                return {
                    go,
                    startAuto,
                    get current() { return current; },
                    get autoTimer() { return autoTimer; }
                };
            }

            const carousels = {};

            function initCarousels() {
                carousels.libros   = buildCarousel('trackLibros',   'dotsLibros',   rawLibros,   bookCardHTML,   CARD_W_BOOK);
                carousels.autores  = buildCarousel('trackAutores',  'dotsAutores',  rawAutores,  authorCardHTML, CARD_W_AUTHOR);
                carousels.revistas = buildCarousel('trackRevistas', 'dotsRevistas', rawRevistas, revistaCardHTML, CARD_W_BOOK);
            }

            window.moveCarousel = function(name, dir) {
                const c = carousels[name];
                if (!c) return;
                clearInterval(c.autoTimer);
                c.go(c.current + dir);
                c.startAuto();
            };

            // Inicializar cuando la sección sea visible por primera vez
            let initialized = false;
            const observer = new MutationObserver(() => {
                const sec = document.getElementById('inicioSection');
                if (sec && !sec.classList.contains('hidden') && !initialized) {
                    initialized = true;
                    initCarousels();
                }
            });
            const sec = document.getElementById('inicioSection');
            if (sec) observer.observe(sec, { attributes: true, attributeFilter: ['class'] });

            // Si ya está visible al cargar (activeSection === 'Inicio')
            if (sec && !sec.classList.contains('hidden')) {
                initialized = true;
                initCarousels();
            }
        })();
        // ========== FIN CARRUSELES ==========

        window.openMobileSidebar  = openMobileSidebar;
        window.closeMobileSidebar = closeMobileSidebar;
    </script>
    <x-floating-buttons />
</body>
</html>
