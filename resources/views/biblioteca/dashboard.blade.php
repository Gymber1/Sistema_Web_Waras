<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Digital Ancashina</title>
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
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
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
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><path fill="%23f39c1240" d="M0,200 Q300,100 600,200 T1200,200 L1200,400 L0,400 Z"/></svg>');
            background-size: cover;
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            background-color: #2c3e50;
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
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .search-box button:hover {
            background: #2c3e50;
        }

        .filters {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            display: flex;
            gap: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-item label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .filter-item select {
            padding: 0.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .category-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #3498db;
        }

        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .category-card h3 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .category-card p {
            color: #666;
            font-size: 0.9rem;
        }

        .books-section h3 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            border-bottom: 3px solid #3498db;
            padding-bottom: 0.5rem;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .book-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .book-cover {
            width: 100%;
            height: 240px;
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .book-info {
            padding: 1rem;
        }

        .book-info h4 {
            color: #2c3e50;
            margin-bottom: 0.3rem;
            font-size: 0.95rem;
            line-height: 1.3;
            height: 2.6em;
            overflow: hidden;
        }

        .book-info p {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .book-rating {
            color: #f39c12;
            font-size: 0.9rem;
        }

        .footer {
            background: #2c3e50;
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

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📚 Biblioteca Digital Ancashina</h1>
        <div class="header-nav">
            <a href="/">← Volver al portal</a>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="hero-banner">
        <h2>Bienvenido a la Biblioteca Digital Ancashina</h2>
        <p>Accede a miles de libros, revistas y artículos del patrimonio literario</p>
    </div>

    <div class="container">
        <!-- Search Section -->
        <div class="search-section">
            <div class="search-box">
                <input type="text" placeholder="Buscar por título, autor o tema...">
                <button>Buscar</button>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filter-item">
                <label>Categoría</label>
                <select>
                    <option>Todas</option>
                    <option>Ficción</option>
                    <option>Historia</option>
                    <option>Ciencia</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Año de Publicación</label>
                <select>
                    <option>Cualquiera</option>
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Ordenar por</label>
                <select>
                    <option>Más recientes</option>
                    <option>Más populares</option>
                    <option>Mejor valorados</option>
                </select>
            </div>
        </div>

        <!-- Categories -->
        <h3 style="color: #2c3e50; margin: 3rem 0 1.5rem; font-size: 1.5rem;">Categorías Destacadas</h3>
        <div class="categories">
            <div class="category-card">
                <h3>📖 Historia Ancashina</h3>
                <p>Explora el pasado rico de nuestra región</p>
            </div>
            <div class="category-card">
                <h3>📚 Literatura Regional</h3>
                <p>Autores y obras de Ancash</p>
            </div>
            <div class="category-card">
                <h3>📕 Ciencias Sociales</h3>
                <p>Estudios sobre cultura y sociedad</p>
            </div>
            <div class="category-card">
                <h3>📗 Referencia</h3>
                <p>Diccionarios y enciclopedias</p>
            </div>
        </div>

        <!-- Books Grid -->
        <h3>Libros Destacados</h3>
        <div class="books-grid">
            <div class="book-card">
                <div class="book-cover">📖</div>
                <div class="book-info">
                    <h4>Historia de Ancash</h4>
                    <p>Autor desconocido</p>
                    <div class="book-rating">⭐⭐⭐⭐⭐ (45 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📕</div>
                <div class="book-info">
                    <h4>Poesía Ancashina</h4>
                    <p>Varios autores</p>
                    <div class="book-rating">⭐⭐⭐⭐ (32 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📗</div>
                <div class="book-info">
                    <h4>Geografía Regional</h4>
                    <p>Instituto Geográfico</p>
                    <div class="book-rating">⭐⭐⭐⭐⭐ (28 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📘</div>
                <div class="book-info">
                    <h4>Tradiciones Ancashinas</h4>
                    <p>Colectivo Cultural</p>
                    <div class="book-rating">⭐⭐⭐⭐ (19 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📙</div>
                <div class="book-info">
                    <h4>Leyendas y Mitos</h4>
                    <p>Recopilador Anónimo</p>
                    <div class="book-rating">⭐⭐⭐⭐⭐ (56 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📓</div>
                <div class="book-info">
                    <h4>Ensayos Críticos</h4>
                    <p>Academia Local</p>
                    <div class="book-rating">⭐⭐⭐ (15 reseñas)</div>
                </div>
            </div>
        </div>

        <!-- More Books Section -->
        <h3>Últimos Agregados</h3>
        <div class="books-grid">
            <div class="book-card">
                <div class="book-cover">📖</div>
                <div class="book-info">
                    <h4>Monografía Regional</h4>
                    <p>Historiador Local</p>
                    <div class="book-rating">⭐⭐⭐⭐ (8 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📕</div>
                <div class="book-info">
                    <h4>Arte Colonial</h4>
                    <p>Experto en Arte</p>
                    <div class="book-rating">⭐⭐⭐⭐⭐ (22 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📗</div>
                <div class="book-info">
                    <h4>Cultura Popular</h4>
                    <p>Antropólogo</p>
                    <div class="book-rating">⭐⭐⭐⭐ (11 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📘</div>
                <div class="book-info">
                    <h4>Diccionario Regional</h4>
                    <p>Academia del Idioma</p>
                    <div class="book-rating">⭐⭐⭐⭐⭐ (34 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📙</div>
                <div class="book-info">
                    <h4>Novela Histórica</h4>
                    <p>Escritor Regional</p>
                    <div class="book-rating">⭐⭐⭐⭐ (27 reseñas)</div>
                </div>
            </div>

            <div class="book-card">
                <div class="book-cover">📓</div>
                <div class="book-info">
                    <h4>Ensayo Filosófico</h4>
                    <p>Filósofo Ancashino</p>
                    <div class="book-rating">⭐⭐⭐⭐⭐ (39 reseñas)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 WARAS - Asociación de Ciencia y Cultura Ancashina</p>
        <p>Preservando la memoria cultural de nuestra región</p>
    </div>
</body>
</html>
