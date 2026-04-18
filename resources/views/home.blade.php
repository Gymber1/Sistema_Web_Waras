<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WARAS - Portal de la Ciencia y la Cultura Ancashina</title>
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License */
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
            * { margin: 0; padding: 0; box-sizing: border-box; }
            html, body { font-family: 'Poppins', sans-serif; }
        </style>
    @endif

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><defs><linearGradient id="grad" x1="0" y1="0" x2="100" y2="100"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1);stop-opacity:1" /><stop offset="100%" style="stop-color:rgba(255,255,255,0);stop-opacity:0" /></linearGradient></defs><path fill="url(%23grad)" d="M0,400 Q300,200 600,400 T1200,400 L1200,800 L0,800 Z" /></svg>') center/cover;
            background-color: linear-gradient(135deg, #0f4c75 0%, #3282b8 50%, #0f3460 100%);
            color: white;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f4c75;
            font-weight: bold;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .auth-buttons a {
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            border: 2px solid white;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .auth-buttons a:hover {
            background: white;
            color: #0f4c75;
        }

        .hero-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.4);
        }

        .hero-logo {
            width: 150px;
            height: 150px;
            margin: 2rem auto;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            backdrop-filter: blur(10px);
        }

        .modules-section {
            background: white;
            padding: 4rem 2rem;
            margin-top: auto;
        }

        .modules-title {
            text-align: center;
            color: #0f4c75;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 3rem;
            border-bottom: 3px solid #667eea;
            padding-bottom: 1rem;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .module-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-top: 4px solid #667eea;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .module-card.biblioteca {
            border-top-color: #2c3e50;
        }

        .module-card.biblioteca:hover {
            border-top-color: #3498db;
        }

        .module-card.fototeca {
            border-top-color: #e74c3c;
        }

        .module-card.fototeca:hover {
            border-top-color: #c0392b;
        }

        .module-card.musicoteca {
            border-top-color: #f39c12;
        }

        .module-card.pinacoteca {
            border-top-color: #9b59b6;
        }

        .module-icon {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            font-weight: bold;
        }

        .module-card.biblioteca .module-icon {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
        }

        .module-card.fototeca .module-icon {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .module-card.musicoteca .module-icon {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .module-card.pinacoteca .module-icon {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            color: white;
        }

        .module-card.efemeridades .module-icon {
            background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
            color: white;
        }

        .module-content {
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .module-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f4c75;
            margin-bottom: 0.5rem;
        }

        .module-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            flex: 1;
        }

        .module-link {
            display: inline-block;
            margin-top: auto;
            padding: 0.8rem 1.5rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }

        .module-link:hover {
            background: #764ba2;
            transform: translateX(3px);
        }

        .module-link.biblioteca {
            background: #2c3e50;
        }

        .module-link.biblioteca:hover {
            background: #3498db;
        }

        .module-link.fototeca {
            background: #e74c3c;
        }

        .module-link.fototeca:hover {
            background: #c0392b;
        }

        .module-link.musicoteca {
            background: #f39c12;
        }

        .module-link.musicoteca:hover {
            background: #e67e22;
        }

        .module-link.pinacoteca {
            background: #9b59b6;
        }

        .module-link.pinacoteca:hover {
            background: #8e44ad;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .badge-complete {
            background: #d5f4e6;
            color: #15803d;
        }

        .badge-developing {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-planning {
            background: #ede9fe;
            color: #5b21b6;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .modules-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <div class="logo-icon">W</div>
                <span>WARAS</span>
            </div>
            <div class="auth-buttons">
                <a href="#contacto">Contacto</a>
                <a href="#info">Información</a>
                <a href="/admin" style="background: #667eea; padding: 0.5rem 1.2rem; border-radius: 6px;">Panel</a>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="hero-content">
            <div class="hero-logo">🏔️</div>
            <h1 class="hero-title">Portal de la Ciencia y la Cultura Ancashina</h1>
            <p class="hero-subtitle">WARAS - Asociación de Ciencia y Cultura</p>
        </div>
    </div>

    <!-- Modules Section -->
    <div class="modules-section">
        <h2 class="modules-title">Servicios</h2>
        
        <div class="modules-grid">
            <!-- Biblioteca -->
            <div class="module-card biblioteca">
                <div class="module-icon">📚</div>
                <div class="module-content">
                    <h3 class="module-name">Biblioteca</h3>
                    <p class="module-description">Acceso a nuestra colección digital de libros, artículos y revistas. Explora miles de títulos de la literatura ancashina y universal.</p>
                    <span class="status-badge badge-complete">Operativo</span>
                    <a href="/biblioteca" class="module-link biblioteca">Acceder</a>
                </div>
            </div>

            <!-- Fototeca -->
            <div class="module-card fototeca">
                <div class="module-icon">📷</div>
                <div class="module-content">
                    <h3 class="module-name">Fototeca</h3>
                    <p class="module-description">Galería digital de fotografías históricas y contemporáneas. Descubre imágenes que documentan la historia de Ancash.</p>
                    <span class="status-badge badge-complete">Operativo</span>
                    <a href="/fototeca" class="module-link fototeca">Acceder</a>
                </div>
            </div>

            <!-- Musicoteca -->
            <div class="module-card musicoteca">
                <div class="module-icon">🎵</div>
                <div class="module-content">
                    <h3 class="module-name">Musicoteca</h3>
                    <p class="module-description">Colección de música tradicional y contemporánea. Preserva y comparte el patrimonio musical ancashino.</p>
                    <span class="status-badge badge-planning">Planificado</span>
                    <a href="#musicoteca" class="module-link musicoteca">Próximamente</a>
                </div>
            </div>

            <!-- Pinacoteca -->
            <div class="module-card pinacoteca">
                <div class="module-icon">🎨</div>
                <div class="module-content">
                    <h3 class="module-name">Pinacoteca</h3>
                    <p class="module-description">Galería de arte visual. Obras de artistas locales e internacionales en un espacio digital accesible.</p>
                    <span class="status-badge badge-planning">Planificado</span>
                    <a href="#pinacoteca" class="module-link pinacoteca">Próximamente</a>
                </div>
            </div>

            <!-- Efemeridades -->
            <div class="module-card efemeridades">
                <div class="module-icon">📅</div>
                <div class="module-content">
                    <h3 class="module-name">Efemeridades</h3>
                    <p class="module-description">Calendario de eventos, fechas importantes y celebraciones culturales del patrimonio ancashino.</p>
                    <span class="status-badge badge-planning">Planificado</span>
                    <a href="#efemeridades" class="module-link">Próximamente</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
