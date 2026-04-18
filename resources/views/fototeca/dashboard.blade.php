<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fototeca Digital - WARAS</title>
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
            background: transparent; /* <-- CAMBIADO AQUÍ */
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
        .nav-item { background: none; border: none; color: #9ca3af; cursor: pointer; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; transition: color 0.3s ease; padding: 0.5rem 0; border-bottom: 2px solid transparent; }
        .nav-item:hover { color: white; }
        .nav-item.active { color: white; border-bottom-color: white; }

        /* Hero Section */
        .hero { width: 100%; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1505322022379-7c3353ee6291?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat; }
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
        
        .sidebar { width: 300px; background: white; border-right: 1px solid #e5e7eb; flex-shrink: 0; overflow-y: auto; max-height: calc(100vh - 72px); }
        .sidebar-header { display: flex; align-items: center; gap: 0.75rem; padding: 1.5rem 2rem; background: black; color: white; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        
        .filter-section { border-bottom: 1px solid #f3f4f6; }
        .filter-section-title { padding: 1.25rem 2rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 1px; background: white; cursor: pointer; display: flex; align-items: center; justify-content: space-between; border: none; width: 100%; text-align: left; transition: background 0.2s; }
        .filter-section-title:hover { background: #f9fafb; }
        .filter-items { display: block; background: #f9fafb; padding: 0.5rem 0; }
        .filter-items.collapsed { display: none; }
        
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
                    <button data-tab="Inicio" class="nav-item active">Inicio</button>
                    <button data-tab="Galería" class="nav-item">Galería</button>
                    <button data-tab="Fotógrafos" class="nav-item">Fotógrafos</button>
                    <button data-tab="Especiales" class="nav-item">Especiales</button>
                    <button data-tab="Aportantes" class="nav-item">Aportantes</button>
                </div>
            </nav>
        </div>
    </header>

    <section class="hero" id="heroSection">
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

    <div class="main-wrapper hidden" id="mainWrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-filter"></i> Filtros de Galería
            </div>

            <div class="filter-section">
                <button class="filter-section-title" onclick="this.classList.toggle('collapsed'); this.nextElementSibling.classList.toggle('collapsed')">
                    DISTRIBUCIÓN GEOGRÁFICA <i class="fas fa-chevron-down"></i>
                </button>
                <div class="filter-items">
                    <button class="filter-item" data-category="Por Provincias">Por Provincias <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item" data-category="Por Distritos">Por Distritos <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item" data-category="Por Ciudades">Por Ciudades <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item" data-category="Panorámica">Panorámica <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item active" data-category="Plaza de Armas y Catedral">Plaza de Armas y Catedral <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item" data-category="Barrios (Belén, La Soledad...)">Barrios <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item" data-category="Puentes">Puentes <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item" data-category="Calles">Calles <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                    <button class="filter-item" data-category="Casas y Edificios">Casas y Edificios <i class="fas fa-chevron-right" style="font-size:0.6rem; opacity:0.5;"></i></button>
                </div>
            </div>

            <div class="filter-section">
                <button class="filter-section-title collapsed" onclick="this.classList.toggle('collapsed'); this.nextElementSibling.classList.toggle('collapsed')">
                    SOCIEDAD Y CULTURA <i class="fas fa-chevron-down"></i>
                </button>
                <div class="filter-items collapsed">
                    <button class="filter-item" data-category="Instituciones Sociales">Instituciones Sociales</button>
                    <button class="filter-item" data-category="Instituciones Culturales">Instituciones Culturales</button>
                    <button class="filter-item" data-category="Instituciones Educativas">Instituciones Educativas</button>
                    <button class="filter-item" data-category="Deportes">Deportes</button>
                    <button class="filter-item" data-category="Familias">Familias</button>
                </div>
            </div>

            <div class="filter-section">
                <button class="filter-section-title collapsed" onclick="this.classList.toggle('collapsed'); this.nextElementSibling.classList.toggle('collapsed')">
                    FOTÓGRAFOS CONSAGRADOS <i class="fas fa-chevron-down"></i>
                </button>
                <div class="filter-items collapsed">
                    <button class="filter-item" data-category="Siglo XIX">Siglo XIX</button>
                    <button class="filter-item" data-category="Siglo XX">Siglo XX</button>
                    <button class="filter-item" data-category="Siglo XXI">Siglo XXI</button>
                    <button class="filter-item" data-category="Colecciones Temáticas">Colecciones Temáticas</button>
                </div>
            </div>

            <div class="filter-section">
                <button class="filter-section-title collapsed" onclick="this.classList.toggle('collapsed'); this.nextElementSibling.classList.toggle('collapsed')">
                    ESPECIALES <i class="fas fa-chevron-down"></i>
                </button>
                <div class="filter-items collapsed">
                    <button class="filter-item" data-category="Desastres en Ancash">Desastres en Ancash</button>
                    <button class="filter-item" data-category="Tradiciones y Costumbres">Tradiciones y Costumbres</button>
                    <button class="filter-item" data-category="Patrimonio Arqueológico">Patrimonio Arqueológico</button>
                    <button class="filter-item" data-category="Parque Nacional Huascarán">Parque Nacional Huascarán</button>
                </div>
            </div>

            <div class="temporal-filter">
                <label class="temporal-label">Distribución Temporal</label>
                <select class="temporal-select">
                    <option>Todas las épocas</option>
                    <option>Antes del Terremoto</option>
                    <option>Terremoto (1970)</option>
                    <option>Después del Terremoto</option>
                    <option>Siglo XXI</option>
                </select>
            </div>
        </aside>

        <main class="content">
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
                    <select class="sort-select">
                        <option>Más recientes</option>
                        <option>Más antiguas</option>
                        <option>Más populares</option>
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

    <footer class="footer">
        <div class="footer-icon"><i class="fas fa-camera" style="font-size: 1.5rem;"></i></div>
        <p class="footer-text">© 2024 FOTOTECA WARAS - Archivo Visual Ancashino</p>
        <p class="footer-subtext">Preservando, digitalizando y compartiendo la memoria fotográfica e histórica de nuestra región.</p>
    </footer>
    <script>
        // ========== ESTADO GLOBAL ==========
        let state = {
            activeTab: 'Inicio',
            activeCategory: 'Plaza de Armas y Catedral'
        };

        // ========== DATOS ADAPTADOS DE LA BASE DE DATOS ==========
        const photoData = {
            'Plaza de Armas y Catedral': [
                { 
                    id: 1, 
                    title: 'Nevado Huascarán desde el Valle', 
                    photographer: 'Martín Chambi (Atribuido)', 
                    year: '1932', 
                    type: 'Placa de Vidrio', 
                    imageUrl: 'https://images.unsplash.com/photo-1542224566-6e85f2e6772f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
                    description: 'Impresionante captura del nevado Huascarán visto desde las afueras de Yungay antes del sismo de 1970. Esta fotografía en blanco y negro destaca por su alto contraste y detalle en las formaciones rocosas.', 
                    resolution: '4500 x 3200 px', 
                    location: 'Yungay, Ancash', 
                    camera: 'Cámara de gran formato' 
                },
                { 
                    id: 2, 
                    title: 'Campesina en el Mercado', 
                    photographer: 'Archivo Histórico', 
                    year: '1955', 
                    type: 'Negativo 35mm', 
                    imageUrl: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
                    description: 'Retrato costumbrista de una mujer andina vistiendo el traje tradicional durante el mercado dominical en la plaza principal de Huaraz.', 
                    resolution: '3200 x 2400 px', 
                    location: 'Huaraz, Ancash', 
                    camera: 'Leica III (estimado)' 
                },
                { 
                    id: 3, 
                    title: 'Callejón de Huaylas', 
                    photographer: 'Carlos Zegarra', 
                    year: '1980', 
                    type: 'Diapositiva Color', 
                    imageUrl: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
                    description: 'Fotografía a color que muestra la inmensidad del Callejón de Huaylas al amanecer, con los primeros rayos de sol iluminando la Cordillera Blanca.', 
                    resolution: '5120 x 3400 px', 
                    location: 'Carhuaz, Ancash', 
                    camera: 'Nikon F3, Lente 35mm' 
                },
                { 
                    id: 4, 
                    title: 'Restos Arqueológicos de Chavín', 
                    photographer: 'Desconocido', 
                    year: '1919', 
                    type: 'Impresión en Papel', 
                    imageUrl: 'https://images.unsplash.com/photo-1518098268026-4e89f1a2cd8e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
                    description: 'Una de las primeras documentaciones fotográficas de las cabezas clavas en su posición original en el templo de Chavín de Huántar.', 
                    resolution: '2800 x 2800 px', 
                    location: 'Chavín de Huántar', 
                    camera: 'Desconocida' 
                }
            ],
            // Datos por defecto si la categoría seleccionada aún no tiene fotos
            'default': [
                { 
                    id: 99, 
                    title: 'Fotografía de Archivo', 
                    photographer: 'Autor Anónimo', 
                    year: 'S/F', 
                    type: 'Digitalizado', 
                    imageUrl: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
                    description: 'Registro visual perteneciente a esta colección. Actualmente en proceso de catalogación detallada por parte de la Fototeca WARAS.', 
                    resolution: 'Variada', 
                    location: 'Ancash', 
                    camera: 'Varios formatos' 
                }
            ]
        };

        // ========== FUNCIONES DE RENDERIZADO ==========
        function renderPhotos() {
            const grid = document.getElementById('photosGrid');
            // Busca las fotos de la categoría, si no hay, carga las 'default'
            const photos = photoData[state.activeCategory] || photoData['default'];
            
            // Actualiza el contador de resultados
            document.getElementById('photoCount').textContent = photos.length;

            // Genera las tarjetas HTML para cada foto
            grid.innerHTML = photos.map((photo, index) => `
                <div class="photo-card" data-index="${index}">
                    <div class="photo-image-container">
                        <img src="${photo.imageUrl}" alt="${photo.title}" class="photo-image">
                        <div class="photo-overlay">
                            <button class="photo-overlay-btn"><i class="fas fa-eye"></i> Ver Fotografía</button>
                        </div>
                        <div class="photo-badge">${photo.type}</div>
                    </div>
                    <div class="photo-title">${photo.title}</div>
                    <div class="photo-meta">
                        <span>${photo.photographer}</span>
                        <span style="font-family: monospace;">${photo.year}</span>
                    </div>
                </div>
            `).join('');

            // Agrega el evento click a cada tarjeta para abrir los detalles
            document.querySelectorAll('.photo-card').forEach((card, index) => {
                card.addEventListener('click', () => {
                    showDetail(photos[index]);
                });
            });
        }

        function showDetail(photo) {
            // Llenar datos de la vista de detalle con la foto seleccionada
            document.getElementById('detailImage').src = photo.imageUrl;
            document.getElementById('detailTitle').textContent = photo.title;
            document.getElementById('detailPhotographer').textContent = photo.photographer;
            document.getElementById('detailYear').textContent = photo.year;
            document.getElementById('detailLocation').textContent = photo.location;
            document.getElementById('detailResolution').textContent = photo.resolution;
            document.getElementById('detailCamera').textContent = photo.camera;
            document.getElementById('detailBadge').textContent = photo.type;
            document.getElementById('detailDescription').textContent = photo.description;

            // Ocultar la grilla principal y mostrar la vista de detalles
            document.getElementById('mainWrapper').classList.add('hidden');
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('detailView').classList.remove('hidden');

            // Regresar el scroll hacia arriba suavemente
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showGaleria() {
            // Ocultar la vista de inicio/detalles y mostrar la galería con filtros
            document.getElementById('mainWrapper').classList.remove('hidden');
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('detailView').classList.add('hidden');
            
            // Actualizar el título de la sección y renderizar
            document.getElementById('sectionTitle').textContent = state.activeCategory;
            renderPhotos();
            updateNav();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateNav() {
            // Actualizar estilo (línea blanca debajo) del navbar superior
            document.querySelectorAll('.nav-item').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-tab') === state.activeTab);
            });
            updateHeaderStyle(); // Llama a la corrección del fondo
        }

        // NUEVA FUNCIÓN: Controla inteligentemente el color del header
        function updateHeaderStyle() {
            const header = document.getElementById('header');
            const isDetailHidden = document.getElementById('detailView').classList.contains('hidden');
            
            // Si estamos en el Inicio y NO estamos viendo una foto en detalle
            if (state.activeTab === 'Inicio' && isDetailHidden) {
                if (window.scrollY > 50) {
                    header.style.background = 'rgba(0, 0, 0, 0.98)';
                    header.style.borderBottom = 'none';
                } else {
                    header.style.background = 'transparent';
                    header.style.borderBottom = '1px solid rgba(255,255,255,0.2)';
                }
            } else {
                // Si entramos a Galería, Fotógrafos o a ver una foto, el fondo DEBE ser negro
                header.style.background = 'rgba(0, 0, 0, 0.98)';
                header.style.borderBottom = 'none';
            }
        }

        // ========== EVENT LISTENERS (INTERACTIVIDAD) ==========
        
        // Efecto scroll en el header (se vuelve negro sólido al bajar)
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.style.background = 'black';
                header.style.borderBottom = 'none';
            } else {
                header.style.background = state.activeTab === 'Inicio' ? 'rgba(0,0,0,0.4)' : 'black';
                header.style.borderBottom = state.activeTab === 'Inicio' ? '1px solid rgba(255,255,255,0.1)' : 'none';
            }
        });

        // Click en el Logo para volver al Inicio
        document.getElementById('logoBtn').addEventListener('click', () => {
            state.activeTab = 'Inicio';
            document.getElementById('heroSection').classList.remove('hidden');
            document.getElementById('mainWrapper').classList.add('hidden');
            document.getElementById('detailView').classList.add('hidden');
            updateNav();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Click en los botones del Menú de Navegación Principal
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                state.activeTab = tab;
                
                if (tab === 'Inicio') {
                    document.getElementById('heroSection').classList.remove('hidden');
                    document.getElementById('mainWrapper').classList.add('hidden');
                    document.getElementById('detailView').classList.add('hidden');
                } else {
                    showGaleria();
                }
                updateNav();
            });
        });

        // Click en los Filtros de la Barra Lateral
        document.querySelectorAll('.filter-item').forEach(btn => {
            btn.addEventListener('click', () => {
                // Quitar clase active de todos los botones
                document.querySelectorAll('.filter-item').forEach(b => b.classList.remove('active'));
                
                // Agregar clase active al botón clickeado
                btn.classList.add('active');
                
                // Cambiar el estado y actualizar UI
                state.activeCategory = btn.getAttribute('data-category');
                document.getElementById('sectionTitle').textContent = state.activeCategory;
                
                renderPhotos();
            });
        });

        // Click en el botón "Atrás" de la Vista de Detalle
        document.getElementById('backBtn').addEventListener('click', () => {
            document.getElementById('detailView').classList.add('hidden');
            document.getElementById('mainWrapper').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ========== INICIALIZACIÓN ==========
        // Se ejecuta una vez al cargar la página para mostrar las fotos por defecto
        renderPhotos(); 
    </script>
</body>
</html>