<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fototeca Digital Ancashina</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        .header {
            background: linear-gradient(135deg, #8b4513 0%, #a0522d 100%);
            color: white;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 2rem;
        }

        .header-nav a {
            color: white;
            text-decoration: none;
            margin-left: 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .header-nav a:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }

        .header-back {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .header-back:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><path fill="%23e74c3c40" d="M0,200 Q300,100 600,200 T1200,200 L1200,400 L0,400 Z"/></svg>');
            background-size: cover;
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            background-color: #4a3728;
        }

        .hero-banner h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-section {
            max-width: 1200px;
            margin: -2rem auto 2rem;
            padding: 0 2rem;
            display: flex;
            gap: 1rem;
        }

        .search-box {
            flex: 1;
            display: flex;
            gap: 0.5rem;
        }

        .search-box input {
            flex: 1;
            padding: 1rem;
            border: none;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-box button {
            padding: 1rem 2rem;
            background: #8b4513;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .search-box button:hover {
            background: #704214;
        }

        .filters {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            display: flex;
            gap: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            flex-wrap: wrap;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-item label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #4a3728;
        }

        .filter-item select {
            padding: 0.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            min-width: 180px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .galleries-section {
            margin-bottom: 3rem;
        }

        .galleries-section h3 {
            color: #4a3728;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            border-bottom: 3px solid #8b4513;
            padding-bottom: 0.5rem;
        }

        .galleries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .gallery-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .gallery-cover {
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, #8b4513 0%, #d2c5a0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            position: relative;
        }

        .gallery-count {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .gallery-info {
            padding: 1.5rem;
        }

        .gallery-info h4 {
            color: #4a3728;
            margin-bottom: 0.3rem;
            font-size: 1rem;
            line-height: 1.3;
        }

        .gallery-info p {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 0.8rem;
            line-height: 1.4;
            height: 2.8em;
            overflow: hidden;
        }

        .gallery-date {
            color: #a0522d;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .categories {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 3rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .categories h3 {
            color: #4a3728;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .category-pins {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
        }

        .category-pin {
            background: #f5e6d3;
            color: #8b4513;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .category-pin:hover {
            background: #8b4513;
            color: white;
            border-color: #704214;
        }

        .photographers {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .photographers h3 {
            color: #4a3728;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .photographers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .photographer-card {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: #f9f7f3;
            transition: all 0.3s ease;
        }

        .photographer-card:hover {
            background: #8b4513;
            color: white;
        }

        .photographer-avatar {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #8b4513 0%, #a0522d 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .photographer-card:hover .photographer-avatar {
            background: rgba(255, 255, 255, 0.2);
        }

        .photographer-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #4a3728;
        }

        .photographer-card:hover .photographer-name {
            color: white;
        }

        .photographer-count {
            font-size: 0.85rem;
            color: #888;
        }

        .photographer-card:hover .photographer-count {
            color: rgba(255, 255, 255, 0.8);
        }

        .footer {
            background: #4a3728;
            color: white;
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .hero-banner h2 {
                font-size: 1.8rem;
            }

            .search-section {
                flex-direction: column;
                margin-top: 0;
            }

            .galleries-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }

            .filter-item select {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📷 Fototeca Digital Ancashina</h1>
        <div class="header-nav">
            <a href="/">← Volver al portal</a>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="hero-banner">
        <h2>Galería de Fotografías Históricas</h2>
        <p>Explora imágenes que documentan la historia y la cultura de Ancash</p>
    </div>

    <div class="container">
        <!-- Search Section -->
        <div class="search-section">
            <div class="search-box">
                <input type="text" placeholder="Buscar por título, fotografo, lugar...">
                <button>Buscar</button>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filter-item">
                <label>Lugar</label>
                <select>
                    <option>Todos</option>
                    <option>Huaraz</option>
                    <option>Huacho</option>
                    <option>Carhuaz</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Período</label>
                <select>
                    <option>Cualquiera</option>
                    <option>Antes del terremoto 1970</option>
                    <option>Terremoto 1970</option>
                    <option>Reconstrucción</option>
                    <option>S. XXI</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Tema</label>
                <select>
                    <option>Todos</option>
                    <option>Paisajes</option>
                    <option>Culturas</option>
                    <option>Eventos</option>
                    <option>Arquitectura</option>
                </select>
            </div>
        </div>

        <!-- Categories -->
        <div class="categories">
            <h3>Categorías Populares</h3>
            <div class="category-pins">
                <span class="category-pin">Huaraz</span>
                <span class="category-pin">Terremoto 1970</span>
                <span class="category-pin">Reconstrucción</span>
                <span class="category-pin">Paisajes</span>
                <span class="category-pin">Comunidades</span>
                <span class="category-pin">Tradiciones</span>
                <span class="category-pin">S. XXI</span>
                <span class="category-pin">Fiestas</span>
            </div>
        </div>

        <!-- Galleries -->
        <div class="galleries-section">
            <h3>Galerías Destacadas</h3>
            <div class="galleries-grid">
                <div class="gallery-card">
                    <div class="gallery-cover">
                        📷
                        <span class="gallery-count">23 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Fiestas de Cruces en Carnavales</h4>
                        <p>Documentación de celebraciones tradicionales 1950-1960</p>
                        <span class="gallery-date">Por: Sal y Rosas González Abel</span>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-cover">
                        📸
                        <span class="gallery-count">18 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Yungay en Fotos</h4>
                        <p>Imágenes históricas de la ciudad antes del 1970</p>
                        <span class="gallery-date">Colección Especial</span>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-cover">
                        🏔️
                        <span class="gallery-count">31 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Recuay en Fotos</h4>
                        <p>Documentación del lugar antes y después del terremoto</p>
                        <span class="gallery-date">Archivo Histórico</span>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-cover">
                        🏘️
                        <span class="gallery-count">27 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Caraz y Su Cambiante Paisaje</h4>
                        <p>Transformación urbana y cultural a través de los años</p>
                        <span class="gallery-date">Período: 1960-2010</span>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-cover">
                        🎪
                        <span class="gallery-count">15 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Eventos y Celebraciones</h4>
                        <p>Momentos importantes de la vida social ancashina</p>
                        <span class="gallery-date">Varias fechas</span>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-cover">
                        👥
                        <span class="gallery-count">42 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Gente y Comunidades</h4>
                        <p>Retratos y momentos de la vida cotidiana</p>
                        <span class="gallery-date">Siglo XX - Presente</span>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-cover">
                        🏛️
                        <span class="gallery-count">19 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Arquitectura Colonial</h4>
                        <p>Iglesias y construcciones históricas</p>
                        <span class="gallery-date">Antes de 1970</span>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-cover">
                        🌾
                        <span class="gallery-count">28 fotos</span>
                    </div>
                    <div class="gallery-info">
                        <h4>Paisajes Rurales</h4>
                        <p>Naturaleza y espacios agrícolas de Ancash</p>
                        <span class="gallery-date">Colección Temporal</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photographers -->
        <div class="photographers">
            <h3>Fotógrafos Destacados</h3>
            <div class="photographers-grid">
                <div class="photographer-card">
                    <div class="photographer-avatar">👨‍📷</div>
                    <div class="photographer-name">Sal González Abel</div>
                    <div class="photographer-count">23 galerías</div>
                </div>

                <div class="photographer-card">
                    <div class="photographer-avatar">📷</div>
                    <div class="photographer-name">Rosa González Abel</div>
                    <div class="photographer-count">18 galerías</div>
                </div>

                <div class="photographer-card">
                    <div class="photographer-avatar">👩‍📷</div>
                    <div class="photographer-name">Archivo Histórico</div>
                    <div class="photographer-count">31 galerías</div>
                </div>

                <div class="photographer-card">
                    <div class="photographer-avatar">🎞️</div>
                    <div class="photographer-name">Colección Privada</div>
                    <div class="photographer-count">27 galerías</div>
                </div>

                <div class="photographer-card">
                    <div class="photographer-avatar">📸</div>
                    <div class="photographer-name">Herederos</div>
                    <div class="photographer-count">15 galerías</div>
                </div>

                <div class="photographer-card">
                    <div class="photographer-avatar">🖼️</div>
                    <div class="photographer-name">Museo Regional</div>
                    <div class="photographer-count">42 galerías</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 WARAS - Asociación de Ciencia y Cultura Ancashina</p>
        <p>Preservando la memoria visual de nuestra región</p>
    </div>
</body>
</html>
