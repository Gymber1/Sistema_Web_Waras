<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fototeca Digital - WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; display: flex; flex-direction: column; background: #ffffff; min-height: 100vh; }
        
        :root {
            --primary: #111111;
            --primary-dark: #000000;
            --accent: #333333;
            --highlight: #E53935;
            --bg-light: #ffffff;
            --bg-gray: #f5f5f7;
        }

        /* Header */
        .header { 
            position: fixed; 
            top: 0; 
            width: 100%; 
            z-index: 1000; 
            transition: all 0.3s ease; 
            background: rgba(0, 0, 0, 0.95);
            border-bottom: 1px solid rgba(255,255,255,0.1); 
            padding: 0.5rem 2rem; 
            backdrop-filter: blur(10px); 
        }
        .header-container { max-width: 1600px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 56px; }
        
        .logo { display: flex; align-items: center; gap: 0.75rem; cursor: pointer; text-decoration: none; color: white; background: none; border: none; }
        .logo-icon { width: 32px; height: 32px; border: 2px solid white; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: transform 0.3s; }
        .logo:hover .logo-icon { transform: scale(1.1); }
        .logo-text { display: flex; align-items: center; gap: 0.5rem; }
        .logo-main { font-size: 1.25rem; font-weight: 800; letter-spacing: 0.2em; text-transform: uppercase; }
        .logo-sub { font-size: 1.25rem; font-weight: 300; color: #9ca3af; }

        .nav-menu { display: flex; gap: 2rem; list-style: none; }
        .nav-item { background: none; border: none; color: #9ca3af; cursor: pointer; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; transition: color 0.3s ease; padding: 0.5rem 0; border-bottom: 2px solid transparent; text-decoration: none; }
        .nav-item:hover { color: white; }
        .nav-item.active { color: white; border-bottom-color: white; }
        .header-actions { display: flex; align-items: center; gap: .625rem; margin-left: 1.5rem; }

        /* Hamburger */
        .hamburger-btn { display: none; background: none; border: none; cursor: pointer; color: white; padding: 0.5rem; min-width: 44px; min-height: 44px; align-items: center; justify-content: center; }
        .mobile-nav { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.97); z-index: 2000; flex-direction: column; align-items: center; justify-content: center; gap: 2rem; }
        .mobile-nav.open { display: flex; }
        .mobile-nav-close { position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem; min-width: 44px; min-height: 44px; display: flex; align-items: center; justify-content: center; }
        .mobile-nav-item { color: white; text-decoration: none; font-size: 1.4rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; min-height: 44px; display: flex; align-items: center; }
        .header-btn { display: inline-flex; align-items: center; gap: .4rem; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: .45rem 1rem; border-radius: .25rem; text-decoration: none; transition: all .2s; white-space: nowrap; }
        .header-btn-outline { color: #9ca3af; border: 1px solid rgba(255,255,255,.2); }
        .header-btn-outline:hover { background: rgba(255,255,255,.08); color: white; border-color: rgba(255,255,255,.4); }
        .header-btn-solid { background: white; color: black; border: 1px solid white; }
        .header-btn-solid:hover { background: #e5e7eb; border-color: #e5e7eb; }

        /* Hero Section */
        .hero { width: 100%; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .hero.hidden { display: none !important; }
        .hero-content { max-width: 56rem; width: 100%; padding: 2rem; text-align: center; color: white; }
        .hero-icon-wrapper { display: inline-block; padding: 1rem; border: 1px solid rgba(255,255,255,0.3); border-radius: 50%; margin-bottom: 1.5rem; backdrop-filter: blur(5px); }
        .hero-title { font-size: 4rem; font-weight: 800; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: -1px; }
        .hero-title .light { font-weight: 300; }
        .hero-subtitle { font-size: 1.25rem; font-weight: 300; margin-bottom: 3rem; color: #d1d5db; max-width: 600px; margin-left: auto; margin-right: auto; }

        .search-wrapper { width: 100%; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 0.25rem; display: flex; padding: 0.25rem; max-width: 800px; margin: 0 auto; transition: background 0.3s; }
        .search-wrapper:focus-within { background: white; }
        .search-inner { flex: 1; display: flex; align-items: center; padding-left: 1.25rem; gap: 1rem; }
        .search-icon { color: white; transition: color 0.3s; }
        .search-wrapper:focus-within .search-icon { color: #9ca3af; }
        .search-input { flex: 1; border: none; padding: 1rem 0; font-family: 'Poppins', sans-serif; font-size: 1.1rem; outline: none; background: transparent; color: white; font-weight: 300; }
        .search-wrapper:focus-within .search-input { color: black; }
        .search-input::placeholder { color: rgba(255, 255, 255, 0.7); }
        .search-wrapper:focus-within .search-input::placeholder { color: #9ca3af; }
        .search-btn { background: white; color: black; border: none; padding: 0 2.5rem; border-radius: 0.125rem; font-weight: 700; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; transition: background 0.2s; }
        .search-btn:hover { background: #e5e7eb; }

        /* Main Wrapper & Sidebar */
        .main-wrapper { display: flex; width: 100%; background: var(--bg-gray); margin-top: 72px; flex: 1; }
        .main-wrapper.hidden { display: none !important; }

        .sidebar { width: 300px; background: white; border-right: 1px solid #e5e7eb; flex-shrink: 0; overflow-y: auto; max-height: calc(100vh - 72px); position: sticky; top: 72px; align-self: flex-start; }
        .sidebar-header { display: flex; align-items: center; gap: 0.75rem; padding: 1.5rem 2rem; background: black; color: white; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }

        /* Mobile sidebar overlay */
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 200; }
        .sidebar-overlay.open { display: block; }

        /* Full-width layout — sin sidebar (Especiales, Fotógrafos) */
        .main-wrapper.no-sidebar .sidebar { display: none !important; }
        .main-wrapper.no-sidebar .sidebar-toggle-btn { display: none !important; }
        .main-wrapper.no-sidebar .content { padding: 2.5rem 4rem; max-width: 1400px; margin: 0 auto; width: 100%; }
        .main-wrapper.no-sidebar .photos-grid { grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 2.5rem; }
        @media (max-width: 768px) {
            .main-wrapper.no-sidebar .content { padding: 1.5rem 1.25rem; }
            .main-wrapper.no-sidebar .photos-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
        }

        /* Sidebar toggle button (mobile) */
        .sidebar-toggle-btn { display: none; align-items: center; gap: 0.5rem; background: black; color: white; border: none; padding: 0.6rem 1.25rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; margin-bottom: 0; width: 100%; }
        .sidebar-toggle-btn i { font-size: 0.9rem; }

        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .header-actions { display: none; }
            .hamburger-btn { display: flex; }
            .hero-title { font-size: 2.2rem; }
            .hero-subtitle { font-size: 1rem; }
            .search-wrapper { flex-direction: column; }
            .search-btn { padding: 0.75rem; border-radius: 0; }
            .main-wrapper { margin-top: 56px; flex-direction: column; }
            .sidebar { display: none; width: 100%; max-height: none; position: fixed; top: 0; left: 0; height: 100vh; z-index: 250; overflow-y: auto; }
            .sidebar.mobile-open { display: block; }
            .sidebar-toggle-btn { display: flex; }
            .content { padding: 1.5rem 1.25rem; }
            .search-bar { flex-direction: column; gap: 0.75rem; }
            .sort-controls { width: 100%; }
            .photos-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
            .detail-view { padding: 1.5rem 1rem; margin-top: 56px; }
            .detail-header { flex-direction: column; }
            .detail-info { min-width: unset; padding: 1.5rem; }
            .detail-image-box { min-height: 250px; }
            .detail-meta { grid-template-columns: 1fr 1fr; gap: 1rem; }
        }

        @media (max-width: 480px) {
            .photos-grid { grid-template-columns: 1fr 1fr; gap: 0.75rem; }
            .detail-meta { grid-template-columns: 1fr; }
        }

        /* Accordion sidebar */
        .acc-todos-btn { width: 100%; padding: 0.875rem 2rem; font-size: 0.85rem; font-weight: 600; color: #374151; background: transparent; border: none; border-left: 3px solid transparent; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s; }
        .acc-todos-btn:hover { background: #f9fafb; color: black; }
        .acc-todos-btn.active { background: #f3f4f6; color: black; border-left-color: black; }

        .acc-parent-btn { width: 100%; padding: 0.875rem 2rem; font-size: 0.8rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.06em; background: white; border: none; border-left: 3px solid transparent; border-bottom: 1px solid #f3f4f6; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s; }
        .acc-parent-btn:hover { background: #f9fafb; }
        .acc-parent-btn.open { background: #f9fafb; color: black; border-left-color: black; }
        .acc-parent-btn.active-parent { color: black; font-weight: 700; }
        .acc-chevron { font-size: 0.65rem; color: #9ca3af; transition: transform 0.25s ease; }
        .acc-parent-btn.open .acc-chevron { transform: rotate(90deg); color: black; }

        .acc-children { overflow: hidden; max-height: 0; transition: max-height 0.3s ease; }
        .acc-children.open { max-height: 600px; }

        .acc-child-btn { width: 100%; padding: 0.65rem 2rem 0.65rem 3rem; font-size: 0.825rem; font-weight: 400; color: #6b7280; background: transparent; border: none; border-left: 3px solid transparent; border-bottom: 1px solid #f9fafb; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s; text-align: left; }
        .acc-child-btn:hover { background: #f9fafb; color: black; }
        .acc-child-btn.active { background: #f3f4f6; color: black; font-weight: 600; border-left-color: black; }
        .acc-child-icon { font-size: 0.6rem; opacity: 0.3; }
        .acc-child-btn.active .acc-child-icon { opacity: 1; }

        .filter-section { border-bottom: 1px solid #f3f4f6; }
        .filter-item { padding: 0.6rem 2rem; color: #6b7280; font-size: 0.85rem; font-weight: 500; background: transparent; border: none; width: 100%; text-align: left; cursor: pointer; transition: all 0.2s; border-left: 3px solid transparent; display: flex; justify-content: space-between; align-items: center; }
        .filter-item:hover { color: black; background: #f3f4f6; }
        .filter-item.active { color: black; background: #f3f4f6; border-left-color: black; font-weight: 600; }

        .temporal-filter { padding: 1.5rem 2rem; background: white; border-top: 1px solid #e5e7eb; }
        .temporal-label { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem; display: block; }
        .temporal-select { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-family: 'Poppins'; font-size: 0.85rem; outline: none; }

        /* Content */
        .content { flex: 1; padding: 2.5rem 3rem; background: white; }
        .content-header { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb; }
        .content-title { font-size: 2rem; font-weight: 700; color: black; margin-bottom: 0.25rem; letter-spacing: -0.5px; }
        .content-subtitle { color: #6b7280; font-size: 0.9rem; }

        .search-bar { margin: 2rem 0; display: flex; gap: 1rem; align-items: center; }
        .search-box { flex: 1; display: flex; align-items: center; gap: 1rem; padding: 0.75rem 1.25rem; border: 1px solid #e5e7eb; background: #f9fafb; border-radius: 0.25rem; }
        .search-box:focus-within { border-color: black; background: white; }
        .search-box input { flex: 1; border: none; outline: none; font-size: 0.9rem; background: transparent; }
        .sort-controls { display: flex; align-items: center; gap: 1rem; background: #f9fafb; padding: 0.75rem 1.25rem; border-radius: 0.25rem; border: 1px solid #e5e7eb; }
        .sort-select { background: transparent; border: none; font-size: 0.9rem; font-weight: 600; color: black; cursor: pointer; outline: none; }

        /* Grid */
        .photos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; }
        .photo-card { cursor: pointer; display: flex; flex-direction: column; group; }
        .photo-image-container { position: relative; width: 100%; aspect-ratio: 4/3; background: #f3f4f6; overflow: hidden; margin-bottom: 0.75rem; }
        .photo-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease; }
        .photo-card:hover .photo-image { transform: scale(1.05); }
        .photo-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center; }
        .photo-card:hover .photo-overlay { opacity: 1; }
        .photo-overlay-btn { background: white; color: black; border: none; padding: 0.5rem 1.5rem; font-weight: 700; cursor: pointer; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; display: flex; align-items: center; gap: 0.5rem; }
        .photo-badge { position: absolute; top: 0.75rem; left: 0.75rem; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); color: white; padding: 0.2rem 0.6rem; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .photo-title { font-size: 1rem; font-weight: 700; color: black; margin-bottom: 0.25rem; line-height: 1.2; }
        .photo-meta { display: flex; justify-content: space-between; font-size: 0.85rem; color: #6b7280; }

        /* Detail View */
        .detail-view { display: none; padding: 2rem 3rem; background: var(--bg-gray); margin-top: 72px; flex: 1; }
        .detail-view:not(.hidden) { display: block; }
        .detail-view.hidden { display: none !important; }
        
        .detail-back-btn { background: white; border: 1px solid #e5e7eb; border-radius: 50%; width: 40px; height: 40px; color: #6b7280; cursor: pointer; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; transition: all 0.2s; }
        .detail-back-btn:hover { background: black; color: white; border-color: black; }

        .detail-header { background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; overflow: hidden; display: flex; gap: 0; margin-bottom: 3rem; }
        .detail-image-box { flex: 2; background: black; min-height: 500px; display: flex; align-items: center; justify-content: center; padding: 2rem; position: relative; }
        .detail-image { max-width: 100%; max-height: 70vh; object-fit: contain; }
        
        .detail-info { flex: 1; padding: 2.5rem; display: flex; flex-direction: column; min-width: 400px; }
        .detail-badge { background: #f3f4f6; color: #374151; padding: 0.25rem 0.75rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: inline-block; width: fit-content; margin-bottom: 1rem; }
        .detail-title { font-size: 2rem; font-weight: 700; color: black; margin-bottom: 1rem; line-height: 1.2; letter-spacing: -0.5px; }
        .detail-photographer { display: flex; align-items: center; gap: 0.5rem; color: #4b5563; font-size: 1rem; font-weight: 500; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; }

        .detail-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        .meta-label { font-size: 0.7rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.25rem; }
        .meta-value { font-size: 0.9rem; color: #374151; font-weight: 500; display: flex; align-items: center; gap: 0.5rem; }

        .detail-section h3 { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
        .detail-section p { color: #374151; line-height: 1.6; font-size: 0.95rem; }

        .detail-actions { display: flex; gap: 1rem; margin-top: auto; padding-top: 2rem; border-top: 1px solid #e5e7eb; }
        .btn { display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.8rem 1.5rem; border: none; font-weight: 600; font-size: 0.85rem; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; flex: 1; }
        .btn-primary { background: black; color: white; }
        .btn-primary:hover { background: #333; }
        .btn-icon { flex: 0 0 auto; width: 3rem; padding: 0; background: white; border: 1px solid #e5e7eb; color: #4b5563; }
        .btn-icon:hover { border-color: black; color: black; }

        /* Footer */
        .footer { background: black; color: white; padding: 3rem 2rem; text-align: center; margin-top: auto; }
        .footer-icon { opacity: 0.5; margin-bottom: 1rem; }
        .footer-text { font-size: 1rem; margin-bottom: 0.5rem; letter-spacing: 1px; }
        .footer-subtext { font-size: 0.85rem; color: #9ca3af; }
    </style>
</head>
<body>
    <!-- Mobile nav overlay -->
    <div class="mobile-nav" id="mobileNav">
        <button class="mobile-nav-close" onclick="closeMobileNav()"><i class="fas fa-times"></i></button>
        <a href="{{ route('fototeca.inicio') }}" class="mobile-nav-item">Inicio</a>
        <a href="{{ route('fototeca.galeria.index') }}" class="mobile-nav-item">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="mobile-nav-item">Fotógrafos</a>
        <a href="{{ route('fototeca.especiales.index') }}" class="mobile-nav-item">Especiales</a>
        <a href="{{ route('fototeca.aportantes.index') }}" class="mobile-nav-item">Aportantes</a>
        <a href="{{ route('home') }}" class="mobile-nav-item" style="font-size:1rem;color:#9ca3af">Portal Principal</a>
    </div>

    <header class="header" id="header">
        <div class="header-container">
            <button class="logo" id="logoBtn">
                <div class="logo-icon"><i class="fas fa-camera"></i></div>
                <div class="logo-text">
                    <span class="logo-main">Fototeca</span>
                    <span class="logo-sub">Ancashina</span>
                </div>
            </button>
            <nav>
                <div class="nav-menu">
                    <a href="{{ route('fototeca.inicio') }}" data-tab="Inicio" class="nav-item">Inicio</a>
                    <a href="{{ route('fototeca.galeria.index') }}" data-tab="Galería" class="nav-item">Galería</a>
                    <a href="{{ route('fototeca.fotografos.index') }}" data-tab="Fotógrafos" class="nav-item">Fotógrafos</a>
                    <a href="{{ route('fototeca.especiales.index') }}" data-tab="Especiales" class="nav-item">Especiales</a>
                    <a href="{{ route('fototeca.aportantes.index') }}" data-tab="Aportantes" class="nav-item">Aportantes</a>
                </div>
            </nav>
            <div class="header-actions">
                <a href="{{ route('home') }}" class="header-btn header-btn-outline">
                    <i class="fas fa-home"></i> Portal Principal
                </a>
                @auth
                    @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
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

    <section class="hero" id="heroSection" style="background: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)), url('{{ $heroBg ?? 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}') center/cover no-repeat;">
        <div class="hero-content">
            <div class="hero-icon-wrapper">
                <i class="fas fa-camera" style="font-size: 2rem;"></i>
            </div>
            <h1 class="hero-title">Fototeca <span class="light">Ancashina</span></h1>
            <p class="hero-subtitle">Preservando y compartiendo la memoria visual, histórica y cultural de nuestra región.</p>
            <div class="search-wrapper">
                <div class="search-inner">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="heroSearchInput" placeholder="Buscar fotografías, lugares, años o autores...">
                </div>
                <button class="search-btn">Buscar</button>
            </div>
        </div>
    </section>

    <!-- Mobile sidebar overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <div class="main-wrapper hidden" id="mainWrapper">
        <aside class="sidebar" id="mobileSidebar">
            <div class="sidebar-header" style="justify-content:space-between">
                <span><i class="fas fa-filter"></i> Explorar Catálogo</span>
                <button onclick="closeMobileSidebar()" style="background:none;border:none;color:white;font-size:1.2rem;cursor:pointer;padding:0 0.25rem;display:none" id="sidebarCloseBtn"><i class="fas fa-times"></i></button>
            </div>
            <ul id="sidebarCategories" style="list-style:none; padding:0; margin:0;"></ul>
        </aside>

        <main class="content">
            <button class="sidebar-toggle-btn" onclick="openMobileSidebar()"><i class="fas fa-filter"></i> Filtrar por categoría</button>
            <div class="content-header">
                <h2 class="content-title" id="sectionTitle">Plaza de Armas y Catedral</h2>
                <p class="content-subtitle">Explorando el archivo histórico y fotográfico.</p>
            </div>

            <div class="search-bar">
                <div class="search-box">
                    <i class="fas fa-search" style="color:#9ca3af"></i>
                    <input type="text" id="contentSearchInput" placeholder="Buscar en esta categoría...">
                </div>
                <div class="sort-controls">
                    <span style="font-size:0.85rem; color:#6b7280"><strong style="color:black" id="photoCount">0</strong> fotos</span>
                    <div style="width:1px; height:20px; background:#e5e7eb; margin: 0 0.5rem;"></div>
                    <i class="fas fa-sliders-h" style="color:#9ca3af"></i>
                    <select class="sort-select" id="sortSelect">
                        <option value="az">Ordenar A-Z</option>
                        <option value="recent">Más recientes</option>
                        <option value="old">Más antiguos</option>
                    </select>
                </div>
            </div>

            <div class="photos-grid" id="photosGrid"></div>
        </main>
    </div>

    <div class="detail-view hidden" id="detailView">
        <button class="detail-back-btn" id="backBtn"><i class="fas fa-arrow-left"></i></button>

        <div class="detail-header">
            <div class="detail-image-box">
                <img id="detailImage" src="" alt="Foto" class="detail-image">
                <div style="position:absolute; bottom:1.5rem; right:1.5rem;">
                    <button style="background:rgba(255,255,255,0.2); border:none; color:white; padding:0.5rem; border-radius:0.25rem; cursor:pointer;"><i class="fas fa-expand"></i></button>
                </div>
            </div>

            <div class="detail-info">
                <div class="detail-badge" id="detailBadge">Formato</div>
                <h1 class="detail-title" id="detailTitle">Título</h1>
                
                <div class="detail-photographer">
                    <i class="fas fa-user-circle"></i>
                    <span id="detailPhotographer">Fotógrafo</span>
                </div>

                <div class="detail-meta">
                    <div class="meta-item">
                        <div class="meta-label">Año / Fecha</div>
                        <div class="meta-value"><i class="far fa-calendar-alt"></i> <span id="detailYear"></span></div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Ubicación</div>
                        <div class="meta-value"><i class="fas fa-map-marker-alt"></i> <span id="detailLocation"></span></div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Resolución</div>
                        <div class="meta-value"><i class="fas fa-expand"></i> <span id="detailResolution"></span></div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Formato / Equipo</div>
                        <div class="meta-value"><i class="fas fa-camera"></i> <span id="detailCamera"></span></div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Descripción del Archivo</h3>
                    <p id="detailDescription"></p>
                </div>

                <div class="detail-actions">
                    <button class="btn btn-primary"><i class="fas fa-download"></i> Descargar TIF</button>
                    <button class="btn btn-icon"><i class="far fa-heart"></i></button>
                    <button class="btn btn-icon"><i class="fas fa-share-alt"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SECCIÓN APORTANTES ===== -->
    <div id="aportantesSection" style="display:none; background:white; margin-top:56px; min-height:calc(100vh - 56px);">
        <div id="aportantesGrid" style="max-width:1400px; margin:0 auto; padding:4rem 3rem; display:grid; grid-template-columns:1fr 340px; gap:6rem; align-items:start;">

            <!-- COLUMNA IZQUIERDA: Acordeones -->
            <div id="aportantesLeft">
                <!-- Título con línea punteada -->
                <div style="display:flex; align-items:center; gap:1.5rem; margin-bottom:3rem;">
                    <h1 id="aportantesTitle" style="font-size:2rem; font-weight:300; color:#1F2937; letter-spacing:.08em; text-transform:uppercase; white-space:nowrap;">Fototeca Digital Ancashina</h1>
                    <div style="flex:1; border-bottom:1px dashed #cbd5e1;"></div>
                </div>

                <!-- Lista de acordeones -->
                <div style="display:flex; flex-direction:column; gap:0.75rem;" id="aportantesAccordion">

                    <div class="aport-item" data-id="inicio">
                        <button class="aport-btn aport-active" onclick="toggleAportante('inicio')" style="width:100%; display:flex; align-items:center; padding:0; border:none; cursor:pointer; background:#FCFBF8; box-shadow:0 1px 3px rgba(0,0,0,.08);">
                            <div class="aport-icon" style="width:56px; height:56px; display:flex; align-items:center; justify-content:center; background:#986A41; flex-shrink:0; transition:background .2s;">
                                <i class="fas fa-minus" style="color:white; font-size:1rem;"></i>
                            </div>
                            <span style="padding:0 1.5rem; font-size:.9375rem; font-weight:500; color:#1e293b; letter-spacing:.02em;">Inicio</span>
                        </button>
                        <div class="aport-content" style="max-height:1000px; overflow:hidden; transition:max-height .4s ease, opacity .3s ease; opacity:1;">
                            <div style="padding:2rem; font-size:.9375rem; color:#5A6B81; line-height:1.8; background:white; border:1px solid #f1f5f9; border-top:none; text-align:justify;">
                                Nace con la idea de fortalecer la Identidad Cultural de las nuevas generaciones del Departamento de Ancash. Fue promovido inicialmente por la Sociedad Unión Progreso Soledad, en el año 2010. Luego, fue asumido por la Biblioteca Pública Municipal de Huaraz, como un servicio y producto a desarrollar y difundir, como parte de su función de rescatar y promover Identidad.
                            </div>
                        </div>
                    </div>

                    <div class="aport-item" data-id="antecedentes">
                        <button class="aport-btn" onclick="toggleAportante('antecedentes')" style="width:100%; display:flex; align-items:center; padding:0; border:none; cursor:pointer; background:#F8F9FA; box-shadow:0 1px 3px rgba(0,0,0,.06);">
                            <div class="aport-icon" style="width:56px; height:56px; display:flex; align-items:center; justify-content:center; background:#2A3441; flex-shrink:0; transition:background .2s;">
                                <i class="fas fa-plus" style="color:white; font-size:1rem;"></i>
                            </div>
                            <span style="padding:0 1.5rem; font-size:.9375rem; font-weight:500; color:#1e293b; letter-spacing:.02em;">Antecedentes</span>
                        </button>
                        <div class="aport-content" style="max-height:0; overflow:hidden; transition:max-height .4s ease, opacity .3s ease; opacity:0;">
                            <div style="padding:2rem; font-size:.9375rem; color:#5A6B81; line-height:1.8; background:white; border:1px solid #f1f5f9; border-top:none; text-align:justify;">
                                El sistema educativo no incluye en su currículo temas de historia, literatura, geografía, ciencias, etc., de manera específica sobre nuestra Región, por lo cual, las nuevas generaciones desconocen de nuestra historia, recursos y cultura. Asimismo, los docentes expresan que, para poder cubrir estas necesidades temáticas carecen de fuentes bibliográficas de donde poder tomar datos, información y conocimientos para incluirlos en la malla curricular, denotando la carencia de bibliotecas y fuentes primarias para obtener física o virtualmente estos conocimientos. Ante esta situación paupérrima y de miseria de fuentes de información sobre nuestra identidad, es que se generó el proyecto denominado "PORTAL DE LA CIENCIA Y CULTURA ANCASHINA", que tiene una estrategia novedosa, democrática e inclusiva, utilizando las TIC´s y la red de redes, para desde allí, publicar información sobre nuestra historia, geografía, aspectos sociales y recursos de nuestra Región, utilizando autores y bibliografía autorizadas. Para plasmar esta propuesta se planteó desarrollarlos por módulos, uno de los módulos es la Fototeca Digital Ancashina.
                            </div>
                        </div>
                    </div>

                    <div class="aport-item" data-id="finalidad">
                        <button class="aport-btn" onclick="toggleAportante('finalidad')" style="width:100%; display:flex; align-items:center; padding:0; border:none; cursor:pointer; background:#F8F9FA; box-shadow:0 1px 3px rgba(0,0,0,.06);">
                            <div class="aport-icon" style="width:56px; height:56px; display:flex; align-items:center; justify-content:center; background:#2A3441; flex-shrink:0; transition:background .2s;">
                                <i class="fas fa-plus" style="color:white; font-size:1rem;"></i>
                            </div>
                            <span style="padding:0 1.5rem; font-size:.9375rem; font-weight:500; color:#1e293b; letter-spacing:.02em;">Finalidad</span>
                        </button>
                        <div class="aport-content" style="max-height:0; overflow:hidden; transition:max-height .4s ease, opacity .3s ease; opacity:0;">
                            <div style="padding:2rem; font-size:.9375rem; color:#5A6B81; line-height:1.8; background:white; border:1px solid #f1f5f9; border-top:none; text-align:justify;">
                                La Fototeca Digital Ancashina tiene por finalidad recopilar, preservar y difundir el patrimonio fotográfico de la Provincia de Huaraz, cuya concreción ha sido posible gracias a la alianza y cooperación entre la Biblioteca Municipal de Huaraz, la Sociedad Unión Progreso Soledad, el Club de Fotógrafos de Huaraz y La Sociedad Patriotica Sanchez Carrion - Luzuriaga y Mejía, con quienes se ha hecho posible la recopilación de fotografías históricas y fotografías de los últimos tiempos, todos ellos bajo temática referidos exclusivamente a Huaraz o Ancash, como Vida Social, Vida Cultural, Vida Religiosa, Vida Estudiantil, entre otros, como una manera de contar nuestra historia a través de imágenes. También es un centro de difusión de nuestros recursos paisajísticos y naturales para el mundo.
                            </div>
                        </div>
                    </div>

                    <div class="aport-item" data-id="responsables">
                        <button class="aport-btn" onclick="toggleAportante('responsables')" style="width:100%; display:flex; align-items:center; padding:0; border:none; cursor:pointer; background:#F8F9FA; box-shadow:0 1px 3px rgba(0,0,0,.06);">
                            <div class="aport-icon" style="width:56px; height:56px; display:flex; align-items:center; justify-content:center; background:#2A3441; flex-shrink:0; transition:background .2s;">
                                <i class="fas fa-plus" style="color:white; font-size:1rem;"></i>
                            </div>
                            <span style="padding:0 1.5rem; font-size:.9375rem; font-weight:500; color:#1e293b; letter-spacing:.02em;">Responsables</span>
                        </button>
                        <div class="aport-content" style="max-height:0; overflow:hidden; transition:max-height .4s ease, opacity .3s ease; opacity:0;">
                            <div style="padding:2rem; font-size:.9375rem; color:#5A6B81; line-height:1.8; background:white; border:1px solid #f1f5f9; border-top:none; text-align:justify;">
                                Giber Garcia Alamo y equipo del archivo fotográfico.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- COLUMNA DERECHA: Director -->
            <div id="aportantesRight" style="display:flex; flex-direction:column; align-items:center;">
                <!-- Título con línea (oculto en móvil) -->
                <div id="directorTitleRow" style="width:100%; display:flex; align-items:center; gap:1rem; margin-bottom:2.5rem;">
                    <h3 style="font-size:1.5rem; font-weight:300; color:#2A3441; white-space:nowrap;">Director</h3>
                    <div style="flex:1; border-bottom:1px dashed #cbd5e1;"></div>
                </div>

                <!-- Tarjeta de perfil -->
                <div id="directorCard" style="display:flex; flex-direction:column; align-items:center; text-align:center;">
                    <div id="directorAvatar" style="width:192px; height:192px; border-radius:50%; border:3px solid #F2D7B9; margin-bottom:1.5rem; box-shadow:0 10px 40px rgba(0,0,0,.15); overflow:hidden; flex-shrink:0;">
                        <img src="{{ asset('giber.png') }}" alt="Giber Garcia Alamo" style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                    <h4 id="directorName" style="font-size:1rem; font-weight:900; color:#1E293B; letter-spacing:.05em; text-transform:uppercase; margin-bottom:.375rem;">Giber Garcia Alamo</h4>
                    <p style="font-size:.9375rem; color:#64748B; font-style:italic;">Bibliotecologo</p>
                    <button style="margin-top:2rem; padding:.5rem 1.5rem; border:1px solid #cbd5e1; background:transparent; color:#64748b; font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; cursor:pointer; transition:all .2s;"
                            onmouseover="this.style.background='#f8fafc';this.style.color='#1e293b'"
                            onmouseout="this.style.background='transparent';this.style.color='#64748b'">
                        Contactar
                    </button>
                </div>
            </div>

        </div>

        <style>
            @media (max-width: 900px) {
                #aportantesGrid {
                    grid-template-columns: 1fr !important;
                    gap: 0 !important;
                    padding: 2rem 1.25rem !important;
                }
                #aportantesTitle {
                    font-size: 1.2rem !important;
                    white-space: normal !important;
                }
                /* Director arriba, en fila horizontal */
                #aportantesRight {
                    order: -1;
                    flex-direction: row !important;
                    align-items: center !important;
                    gap: 1.25rem !important;
                    padding-bottom: 1.75rem !important;
                    margin-bottom: 1.75rem !important;
                    border-bottom: 1px solid #e5e7eb !important;
                }
                #directorTitleRow { display: none !important; }
                #directorCard {
                    flex-direction: row !important;
                    text-align: left !important;
                    gap: 1.25rem !important;
                }
                #directorAvatar {
                    width: 80px !important;
                    height: 80px !important;
                    margin-bottom: 0 !important;
                    flex-shrink: 0 !important;
                }
                #directorName { font-size: .85rem !important; }
            }
            @media (max-width: 480px) {
                #directorCard {
                    flex-direction: column !important;
                    align-items: center !important;
                    text-align: center !important;
                }
                #directorAvatar {
                    width: 120px !important;
                    height: 120px !important;
                }
            }
        </style>
    </div>

    <footer class="footer">
        <div class="footer-icon"><i class="fas fa-camera" style="font-size: 1.5rem;"></i></div>
        <p class="footer-text">© 2024 FOTOTECA WARAS - Archivo Visual Ancashino</p>
        <p class="footer-subtext">Preservando, digitalizando y compartiendo la memoria fotográfica e histórica de nuestra región.</p>
    </footer>
    <script>
        const PLACEHOLDER = 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';

        // ========== DATOS DESDE LARAVEL ==========
        const photosByCategory  = @json($photosByCategory ?? []);
        const photographersData = @json($photographersData ?? []);
        const categoriesFromDB  = @json($categoriesForFilters ?? []);
        const especialesData    = @json($especialesData ?? []);

        // Flat list of all photos (deduplicated by id)
        const allPhotosFlat = (() => {
            const seen = new Set();
            const result = [];
            Object.values(photosByCategory).flat().forEach(p => {
                if (!seen.has(p.id)) { seen.add(p.id); result.push(p); }
            });
            return result;
        })();

        const serverActiveSection = @json($activeSection ?? 'Inicio');

        // ========== ESTADO ==========
        let state = {
            activeTab:      'Inicio',
            activeCategory: { id: null, name: 'Todas' }, // {id, name} — null id = mostrar todas
            openAccordions:   new Set(),  // ids abiertos manualmente
            closedAccordions: new Set()   // ids cerrados manualmente (prioridad sobre ancestro activo)
        };

        // ========== FILTRADO ==========
        function getCurrentPhotos() {
            if (state.activeTab === 'Fotógrafos') return photographersData;
            if (state.activeTab === 'Especiales') return especialesData;

            let base = allPhotosFlat;
            if (state.activeCategory.id !== null) {
                const catName = state.activeCategory.name;
                base = photosByCategory[catName] || [];
            }

            const q = document.getElementById('contentSearchInput')?.value?.toLowerCase().trim();
            if (q) {
                base = base.filter(p =>
                    (p.title || '').toLowerCase().includes(q) ||
                    (p.photographer || '').toLowerCase().includes(q) ||
                    (p.description || '').toLowerCase().includes(q) ||
                    (p.location || '').toLowerCase().includes(q)
                );
            }
            return base;
        }

        // ========== RENDER FOTOS ==========
        function getSortedPhotos(items) {
            const sortVal = document.getElementById('sortSelect')?.value ?? 'az';
            const arr = [...items];
            if (sortVal === 'az') {
                arr.sort((a, b) => (a.title || a.full_name || '').localeCompare(b.title || b.full_name || '', 'es'));
            } else if (sortVal === 'recent') {
                arr.sort((a, b) => (parseInt(b.year) || 0) - (parseInt(a.year) || 0));
            } else if (sortVal === 'old') {
                arr.sort((a, b) => (parseInt(a.year) || 9999) - (parseInt(b.year) || 9999));
            }
            return arr;
        }

        function renderPhotos() {
            const grid = document.getElementById('photosGrid');
            const items = getSortedPhotos(getCurrentPhotos());
            document.getElementById('photoCount').textContent = items.length;

            if (state.activeTab === 'Fotógrafos') {
                grid.innerHTML = items.map(p => `
                    <div class="photo-card">
                        <div class="photo-image-container" style="background:#111;">
                            ${p.photo_path
                                ? `<img src="${p.photo_path}" alt="${p.full_name}" class="photo-image" onerror="this.style.display='none'">`
                                : `<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user" style="font-size:3rem;color:#555;"></i></div>`}
                            <div class="photo-badge">${p.photos_count} fotos</div>
                            <div class="photo-overlay">
                                <a href="/fototeca/fotografos/${p.id}" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')"
                                   class="photo-overlay-btn"><i class="fas fa-user"></i> Ver Perfil</a>
                            </div>
                        </div>
                        <div class="photo-title">${p.full_name}</div>
                        <div class="photo-meta"><span>${p.biography ? p.biography.slice(0, 80) + '…' : 'Sin biografía'}</span></div>
                        <div style="padding:0.5rem 0 0.25rem;">
                            <a href="/fototeca/fotografos/${p.id}" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')"
                               style="font-size:0.8rem;font-weight:700;color:black;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;border-bottom:1px solid black;padding-bottom:1px;transition:opacity 0.2s;"
                               onmouseover="this.style.opacity='0.6'" onmouseout="this.style.opacity='1'">
                                Más información →
                            </a>
                        </div>
                    </div>
                `).join('') || `<div style="grid-column:1/-1;text-align:center;padding:4rem 0;color:#9ca3af;">No hay fotógrafos registrados.</div>`;
                return;
            }

            if (state.activeTab === 'Especiales') {
                if (items.length === 0) {
                    grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:4rem 0;color:#9ca3af;">No hay fotografías especiales.</div>`;
                    return;
                }
                grid.innerHTML = items.map((photo, index) => `
                    <div class="photo-card" data-index="${index}">
                        <div class="photo-image-container">
                            ${photo.image_url
                                ? `<img src="${photo.image_url}" alt="${photo.title}" class="photo-image" onerror="this.style.display='none'">`
                                : ''}
                            <div class="photo-badge">${photo.format || photo.source_type || 'Archivo'}</div>
                        </div>
                        <div class="photo-title">${photo.title}</div>
                        <div class="photo-meta">
                            <span>${photo.photographer}</span>
                            <span style="font-family:monospace;">${photo.year}</span>
                        </div>
                    </div>
                `).join('');
                document.querySelectorAll('#photosGrid .photo-card').forEach((card, index) => {
                    card.addEventListener('click', () => { closeMobileSidebar(); showDetail(items[index]); });
                });
                return;
            }

            if (items.length === 0) {
                grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:4rem 0;color:#9ca3af;">No hay fotografías en esta categoría.</div>`;
                return;
            }

            grid.innerHTML = items.map((photo, index) => `
                <div class="photo-card" data-index="${index}">
                    <div class="photo-image-container">
                        <img src="${photo.image_url || PLACEHOLDER}" alt="${photo.title}" class="photo-image"
                             onerror="this.src='${PLACEHOLDER}'">
                        <div class="photo-overlay">
                            <button class="photo-overlay-btn"><i class="fas fa-eye"></i> Ver Fotografía</button>
                        </div>
                        <div class="photo-badge">${photo.format || photo.source_type || 'Archivo'}</div>
                    </div>
                    <div class="photo-title">${photo.title}</div>
                    <div class="photo-meta">
                        <span>${photo.photographer}</span>
                        <span style="font-family:monospace;">${photo.year}</span>
                    </div>
                </div>
            `).join('');

            document.querySelectorAll('#photosGrid .photo-card').forEach((card, index) => {
                card.addEventListener('click', () => showDetail(items[index]));
            });
        }

        // ========== RENDER SIDEBAR ACORDEÓN (RECURSIVO) ==========

        // Construir HTML recursivo para un nodo y sus hijos
        function buildNodeHtml(node, depth) {
            const hasChildren = node.children && node.children.length > 0;
            const manuallyClosed = state.closedAccordions.has(node.id);
            const isOpen = !manuallyClosed && (
                state.openAccordions.has(node.id) ||
                isAncestorOfActive(node, state.activeCategory.id)
            );
            const isActive = state.activeCategory.id === node.id;
            const indent = 2 + depth * 1; // rem
            const paddingLeft = `${indent}rem`;

            if (hasChildren) {
                // Nodo con hijos → botón acordeón + children colapsables
                const childrenHtml = node.children.map(child => buildNodeHtml(child, depth + 1)).join('');
                return `<li>
                    <button class="acc-parent-btn ${isOpen ? 'open' : ''} ${isActive ? 'active-parent' : ''}"
                            data-parent-id="${node.id}"
                            style="padding-left:${paddingLeft};">
                        <span>${node.name}</span>
                        <i class="fas fa-chevron-right acc-chevron"></i>
                    </button>
                    <div class="acc-children ${isOpen ? 'open' : ''}">
                        <ul style="list-style:none;padding:0;margin:0;">${childrenHtml}</ul>
                    </div>
                </li>`;
            } else {
                // Nodo hoja → botón seleccionable
                return `<li>
                    <button class="acc-child-btn ${isActive ? 'active' : ''}"
                            data-cat-id="${node.id}" data-cat-name="${node.name}"
                            style="padding-left:${paddingLeft};">
                        <span>${node.name}</span>
                        <i class="fas fa-chevron-right acc-child-icon"></i>
                    </button>
                </li>`;
            }
        }

        // Comprobar si un nodo es ancestro de la categoría activa (para mantener abierto)
        function isAncestorOfActive(node, activeId) {
            if (!activeId || !node.children) return false;
            for (const child of node.children) {
                if (child.id === activeId) return true;
                if (isAncestorOfActive(child, activeId)) return true;
            }
            return false;
        }

        function renderSidebar() {
            const list = document.getElementById('sidebarCategories');

            const todosActive = state.activeCategory.id === null;
            let html = `<li><button class="acc-todos-btn ${todosActive ? 'active' : ''}" id="acc-todos">
                            Todas las fotografías
                            <i class="fas fa-chevron-right acc-child-icon"></i>
                        </button></li>`;

            if (categoriesFromDB.length > 0) {
                html += categoriesFromDB.map(node => buildNodeHtml(node, 0)).join('');
            } else {
                Object.keys(photosByCategory).forEach(name => {
                    const isActive = state.activeCategory.name === name;
                    html += `<li><button class="acc-todos-btn ${isActive ? 'active' : ''}" data-cat-name="${name}">${name}</button></li>`;
                });
            }

            list.innerHTML = html;

            // "Todas" button
            list.querySelector('#acc-todos')?.addEventListener('click', () => {
                state.activeCategory = { id: null, name: 'Todas' };
                state.openAccordions.clear();
                state.closedAccordions.clear();
                document.getElementById('sectionTitle').textContent = state.activeTab;
                renderSidebar();
                renderPhotos();
                closeMobileSidebar();
            });

            // Accordion parent toggle (cualquier profundidad) — Set-based para multinivel
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
                    renderSidebar();
                    // No cierra el sidebar al expandir/colapsar — el usuario sigue navegando
                });
            });

            // Leaf category select (cualquier profundidad)
            list.querySelectorAll('.acc-child-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id   = parseInt(btn.getAttribute('data-cat-id'));
                    const name = btn.getAttribute('data-cat-name');
                    state.activeCategory = { id, name };
                    document.getElementById('sectionTitle').textContent = name;
                    renderSidebar();
                    renderPhotos();
                    closeMobileSidebar();
                });
            });

            // Flat fallback buttons
            list.querySelectorAll('.acc-todos-btn[data-cat-name]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const name = btn.getAttribute('data-cat-name');
                    state.activeCategory = { id: null, name };
                    document.getElementById('sectionTitle').textContent = name;
                    renderSidebar();
                    renderPhotos();
                    closeMobileSidebar();
                });
            });
        }

        // ========== MOSTRAR DETALLE ==========
        function showDetail(photo) {
            if (photo.detail_url) {
                sessionStorage.setItem('fototeca_tab', state.activeTab);
                window.location.href = photo.detail_url;
                return;
            }
            const imgEl = document.getElementById('detailImage');
            imgEl.src = photo.image_url || PLACEHOLDER;
            imgEl.onerror = () => { imgEl.src = PLACEHOLDER; };

            document.getElementById('detailTitle').textContent        = photo.title;
            document.getElementById('detailPhotographer').textContent = photo.photographer;
            document.getElementById('detailYear').textContent         = photo.year;
            document.getElementById('detailLocation').textContent     = photo.location || '—';
            document.getElementById('detailResolution').textContent   = photo.resolution || '—';
            document.getElementById('detailCamera').textContent       = photo.format || '—';
            document.getElementById('detailBadge').textContent        = photo.format || photo.source_type || 'Archivo';
            document.getElementById('detailDescription').textContent  = photo.description || '';

            document.getElementById('mainWrapper').classList.add('hidden');
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('detailView').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function hideAllSections() {
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('detailView').classList.add('hidden');
            document.getElementById('mainWrapper').classList.add('hidden');
            document.getElementById('aportantesSection').style.display = 'none';
        }

        // Tabs que no necesitan sidebar de categorías
        const TABS_NO_SIDEBAR = new Set(['Especiales', 'Fotógrafos']);

        // ========== MOSTRAR GALERÍA / SECCIONES ==========
        function showSection(tab) {
            state.activeTab = tab;
            state.activeCategory = { id: null, name: 'Todas' };
            state.openAccordions.clear();
            state.closedAccordions.clear();

            hideAllSections();

            if (tab === 'Aportantes') {
                document.getElementById('aportantesSection').style.display = 'block';
            } else if (tab === 'Inicio') {
                document.getElementById('heroSection').classList.remove('hidden');
            } else {
                const wrapper = document.getElementById('mainWrapper');
                wrapper.classList.remove('hidden');
                wrapper.classList.toggle('no-sidebar', TABS_NO_SIDEBAR.has(tab));
                document.getElementById('sectionTitle').textContent = tab;
                document.getElementById('contentSearchInput').value = '';
                renderSidebar();
                renderPhotos();
            }

            updateNav();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateNav() {
            document.querySelectorAll('.nav-item').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-tab') === state.activeTab);
            });
            const tabUrlMap = {
                'Inicio':      '{{ route('fototeca.dashboard') }}',
                'Galería':     '{{ route('fototeca.galeria.index') }}',
                'Fotógrafos':  '{{ route('fototeca.fotografos.index') }}',
                'Especiales':  '{{ route('fototeca.especiales.index') }}',
                'Aportantes':  '{{ route('fototeca.aportantes.index') }}',
            };
            if (tabUrlMap[state.activeTab]) {
                history.replaceState(null, '', tabUrlMap[state.activeTab]);
            }
        }

        // ========== BÚSQUEDA EN CONTENIDO ==========
        document.getElementById('contentSearchInput')?.addEventListener('input', () => {
            closeMobileSidebar();
            renderPhotos();
        });

        document.getElementById('sortSelect').addEventListener('change', () => {
            closeMobileSidebar();
            renderPhotos();
        });

        // ========== SCROLL HEADER ==========
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            header.style.background = window.scrollY > 50 || state.activeTab !== 'Inicio'
                ? 'black'
                : 'rgba(0,0,0,0.4)';
        });

        // ========== LOGO → INICIO ==========
        document.getElementById('logoBtn').addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = '{{ route('fototeca.dashboard') }}';
        });

        // ========== NAVEGACIÓN ==========
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = btn.getAttribute('href');
            });
        });

        // ========== BOTÓN VOLVER ==========
        document.getElementById('backBtn').addEventListener('click', () => {
            document.getElementById('detailView').classList.add('hidden');
            document.getElementById('mainWrapper').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ========== BÚSQUEDA HERO ==========
        document.getElementById('heroSearchInput')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                const q = e.target.value.trim();
                if (q) {
                    showSection('Galería');
                    document.getElementById('contentSearchInput').value = q;
                    renderPhotos();
                }
            }
        });
        document.querySelector('.search-btn')?.addEventListener('click', () => {
            const q = document.getElementById('heroSearchInput').value.trim();
            closeMobileSidebar();
            showSection('Galería');
            if (q) {
                document.getElementById('contentSearchInput').value = q;
                renderPhotos();
            }
        });

        // ========== INICIO ==========
        // Activar sección según la ruta visitada (definida por el servidor)
        const validTabs = ['Inicio','Galería','Fotógrafos','Especiales','Aportantes'];

        // Fallback sessionStorage para compatibilidad con páginas de detalle
        const pendingTab = sessionStorage.getItem('fototeca_tab');
        if (pendingTab && validTabs.includes(pendingTab)) {
            sessionStorage.removeItem('fototeca_tab');
            showSection(pendingTab);
        } else {
            const sectionTab = validTabs.includes(serverActiveSection) ? serverActiveSection : 'Inicio';
            showSection(sectionTab);
        }

        // ========== MOBILE NAV ==========
        function openMobileNav()  { document.getElementById('mobileNav').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeMobileNav() { document.getElementById('mobileNav').classList.remove('open'); document.body.style.overflow = ''; }
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
            document.body.style.overflow = '';
        }
        window.openMobileSidebar  = openMobileSidebar;
        window.closeMobileSidebar = closeMobileSidebar;

        // ========== ACORDEÓN APORTANTES ==========
        function toggleAportante(id) {
            const items = document.querySelectorAll('#aportantesAccordion .aport-item');
            items.forEach(item => {
                const isTarget = item.getAttribute('data-id') === id;
                const btn      = item.querySelector('.aport-btn');
                const icon     = item.querySelector('.aport-icon');
                const iconEl   = item.querySelector('.aport-icon i');
                const content  = item.querySelector('.aport-content');

                if (isTarget) {
                    const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';
                    if (isOpen) {
                        // Cerrar
                        content.style.maxHeight = '0px';
                        content.style.opacity   = '0';
                        btn.style.background    = '#F8F9FA';
                        icon.style.background   = '#2A3441';
                        iconEl.className        = 'fas fa-plus';
                        iconEl.style.color      = 'white';
                    } else {
                        // Abrir
                        content.style.maxHeight = '1000px';
                        content.style.opacity   = '1';
                        btn.style.background    = '#FCFBF8';
                        icon.style.background   = '#986A41';
                        iconEl.className        = 'fas fa-minus';
                        iconEl.style.color      = 'white';
                    }
                } else {
                    // Cerrar los demás
                    content.style.maxHeight = '0px';
                    content.style.opacity   = '0';
                    btn.style.background    = '#F8F9FA';
                    icon.style.background   = '#2A3441';
                    iconEl.className        = 'fas fa-plus';
                    iconEl.style.color      = 'white';
                }
            });
        }
        window.toggleAportante = toggleAportante;
    </script>
    <x-floating-buttons />
</body>
</html>