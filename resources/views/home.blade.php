<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARAS - Portal Unificado</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        /* Header/Navigation */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.5rem 0;
            transition: all 0.3s ease;
            background: transparent;
        }

        .header.scrolled {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.95) 0%, rgba(22, 78, 99, 0.95) 100%);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
        }

        .header.scrolled .logo-icon {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
            border-radius: 8px;
            padding: 0.5rem;
        }

        .header.scrolled .logo-text {
            color: white;
        }

        .header.scrolled .nav-link {
            color: white;
        }

        .header.scrolled .nav-link:hover {
            color: #fbbf24;
        }

        .nav-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            transition: all 0.3s ease;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            transition: color 0.3s ease;
        }

        nav {
            display: flex;
            gap: 3rem;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #fbbf24;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #fbbf24;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-phone, .btn-admin {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-phone {
            background: #fbbf24;
            color: #333;
        }

        .btn-phone:hover {
            background: #f59e0b;
            transform: translateY(-2px);
        }

        .btn-admin {
            color: white;
            border: 2px solid white;
        }

        .btn-admin:hover {
            background: white;
            color: #0d9488;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/Fondo.png') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.3) 0%, rgba(22, 78, 99, 0.3) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 2rem;
        }

        .hero-tag {
            display: inline-block;
            background: rgba(251, 191, 36, 0.2);
            border: 1px solid #fbbf24;
            color: #fbbf24;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 300;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(13, 148, 136, 0.3);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            animation: bounce 2s infinite;
        }

        .scroll-indicator svg {
            width: 30px;
            height: 30px;
            stroke: white;
            fill: none;
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        /* Services Section */
        .services-section {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, #FDFCFB 0%, #f0f9ff 100%);
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-subtitle {
            color: #0d9488;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: #164e63;
            margin-bottom: 1rem;
        }

        .section-description {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .services-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(13, 148, 136, 0.15);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #0d9488 0%, #0891b2 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(13, 148, 136, 0.25);
            background: linear-gradient(135deg, #ffffff 0%, #a8e6e1 100%);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #a8e6e1 0%, #bbeef5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        .service-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: #164e63;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .service-description {
            color: #666;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .service-status {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-operativo {
            background: #d1fae5;
            color: #065f46;
        }

        .status-desarrollo {
            background: #fef3c7;
            color: #92400e;
        }

        .status-planificado {
            background: #e5e7eb;
            color: #374151;
        }

        .service-link {
            display: inline-block;
            margin-top: 1rem;
            color: #0d9488;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .service-link:hover {
            color: #0891b2;
            transform: translateX(5px);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #164e63 0%, #0d4a4a 100%);
            color: white;
            padding: 4rem 2rem 2rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-column h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .footer-column p {
            font-size: 0.95rem;
            opacity: 0.9;
            line-height: 1.8;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .footer-link {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link:hover {
            color: #fbbf24;
            transform: translateX(5px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
            opacity: 0.8;
        }

        .footer-credit {
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            nav {
                gap: 1rem;
            }

            .nav-link {
                display: none;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <header class="header" id="header">
        <div class="nav-wrapper">
            <a href="#" class="logo">
                <div class="logo-icon">W</div>
                <span class="logo-text">WARAS</span>
            </a>
            <nav>
                <a href="#servicios" class="nav-link">Servicios</a>
                <a href="#acerca" class="nav-link">Acerca de</a>
                <a href="#contacto" class="nav-link">Contacto</a>
                <div class="nav-buttons">
                    <a href="tel:+51952845942" class="btn-phone">Llamar: +51 952-845-942</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin">Panel Admin</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-tag">🌍 Bienvenido a WARAS</div>
            <h1 class="hero-title">Portal Unificado de Ciencia y Cultura</h1>
            <p class="hero-subtitle">Descubre nuestras colecciones de libros, fotos, música, artes y eventos históricos</p>
            <a href="#servicios" class="cta-button">Explorar Servicios</a>
        </div>
        <div class="scroll-indicator">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 9l7 7 7-7"></path>
            </svg>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section" id="servicios">
        <div class="section-header">
            <p class="section-subtitle">NUESTROS SERVICIOS</p>
            <h2 class="section-title">Explora Nuestras Colecciones</h2>
            <p class="section-description">Accede a nuestro vasto acervo cultural y científico desde un único portal</p>
        </div>

        <div class="services-grid">
            <!-- Biblioteca -->
            <div class="service-card">
                <div class="service-icon">📚</div>
                <h3 class="service-title">Biblioteca</h3>
                <p class="service-description">Colección completa de libros, revistas y publicaciones académicas organizadas por categoría y tema para facilitar tu búsqueda.</p>
                <span class="service-status status-operativo">✓ Operativo</span>
                <a href="/biblioteca" class="service-link">Ir a Biblioteca →</a>
            </div>

            <!-- Fototeca -->
            <div class="service-card">
                <div class="service-icon">📷</div>
                <h3 class="service-title">Fototeca</h3>
                <p class="service-description">Archivo fotográfico organizado que preserva la memoria visual de nuestra región y su diversidad cultural.</p>
                <span class="service-status status-operativo">✓ Operativo</span>
                <a href="/fototeca" class="service-link">Ver Fototeca →</a>
            </div>

            <!-- Musicoteca -->
            <div class="service-card">
                <div class="service-icon">🎵</div>
                <h3 class="service-title">Musicoteca</h3>
                <p class="service-description">Recopilación de composiciones, artistas y géneros musicales que representan nuestra identidad sonora.</p>
                <span class="service-status status-desarrollo">⚙️ En Desarrollo</span>
                <a href="#" class="service-link">Próximamente →</a>
            </div>

            <!-- Pinacoteca -->
            <div class="service-card">
                <div class="service-icon">🎨</div>
                <h3 class="service-title">Pinacoteca</h3>
                <p class="service-description">Galería virtual de obras de arte, pinturas y expresiones artísticas de maestros locales e internacionales.</p>
                <span class="service-status status-planificado">◯ Planificado</span>
                <a href="#" class="service-link">En Planificación →</a>
            </div>

            <!-- Efemérides -->
            <div class="service-card">
                <div class="service-icon">📅</div>
                <h3 class="service-title">Efemérides</h3>
                <p class="service-description">Registro de eventos históricos, fechas significativas y hitos importantes que marcaron la historia de nuestra comunidad.</p>
                <span class="service-status status-planificado">◯ Planificado</span>
                <a href="#" class="service-link">En Planificación →</a>
            </div>

            <!-- Catálogo Kohú -->
            <div class="service-card">
                <div class="service-icon">🗂️</div>
                <h3 class="service-title">Catálogo Kohú</h3>
                <p class="service-description">Sistema integral de catalogación y búsqueda avanzada para encontrar recursos en todas nuestras colecciones.</p>
                <span class="service-status status-planificado">◯ Planificado</span>
                <a href="#" class="service-link">En Planificación →</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contacto">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>WARAS</h3>
                    <p>Portal integrado de acceso a colecciones de ciencia, cultura y patrimonio. Preservando la memoria de nuestra región.</p>
                </div>
                <div class="footer-column">
                    <h3>Enlaces Rápidos</h3>
                    <div class="footer-links">
                        <a href="#servicios" class="footer-link">Servicios</a>
                        <a href="#acerca" class="footer-link">Acerca de</a>
                        <a href="#contacto" class="footer-link">Contacto</a>
                        <a href="{{ route('admin.dashboard') }}" class="footer-link">Panel Admin</a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <div class="footer-links">
                        <a href="tel:+51952845942" class="footer-link">📞 +51 952-845-942</a>
                        <a href="mailto:info@waras.local" class="footer-link">✉️ info@waras.local</a>
                        <a href="#" class="footer-link">📍 Ancash, Perú</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-credit">&copy; 2024 WARAS - Asociación de Ciencia y Cultura Ancashina. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Scroll effect on header
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
