<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar Fototeca - WARAS</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            color: white;
            min-height: 100vh;
            padding: 2rem 0;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            padding: 0 1.5rem 1rem;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: #e74c3c;
        }

        .sidebar-item.active {
            background: rgba(231, 76, 60, 0.1);
            color: white;
            border-left-color: #e74c3c;
        }

        .sidebar-item-icon {
            font-size: 1.2rem;
            width: 24px;
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            min-height: 100vh;
            padding: 2rem;
        }

        .page-header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a202c;
        }

        .add-btn {
            background: #e74c3c;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-btn:hover {
            background: #c0392b;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }

        .gallery-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .gallery-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .gallery-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            position: relative;
        }

        .gallery-image .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .gallery-info {
            padding: 1.5rem;
        }

        .gallery-name {
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .gallery-meta {
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 1rem;
        }

        .gallery-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-small {
            flex: 1;
            padding: 0.6rem;
            border: none;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .filters {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-item label {
            font-size: 0.9rem;
            color: #4a5568;
            font-weight: 500;
        }

        .filter-item select {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
            }

            .filters {
                flex-direction: column;
            }

            .search-box {
                width: 100%;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">W</div>
                <span>WARAS</span>
            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Módulos Operativos</div>
            <nav class="sidebar-nav">
                <a href="/admin" class="sidebar-item">
                    <span class="sidebar-item-icon">📊</span>
                    <span class="sidebar-item-text">Dashboard</span>
                </a>
                <a href="/admin/biblioteca" class="sidebar-item">
                    <span class="sidebar-item-icon">📚</span>
                    <span class="sidebar-item-text">Biblioteca</span>
                </a>
                <a href="#" class="sidebar-item active">
                    <span class="sidebar-item-icon">📷</span>
                    <span class="sidebar-item-text">Fototeca</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Fototeca</div>
            <nav class="sidebar-nav">
                <a href="#" class="sidebar-item" style="padding-left: 2.5rem;">
                    <span class="sidebar-item-icon">🎨</span>
                    <span class="sidebar-item-text">Galerías</span>
                </a>
                <a href="#" class="sidebar-item" style="padding-left: 2.5rem;">
                    <span class="sidebar-item-icon">📸</span>
                    <span class="sidebar-item-text">Fotos</span>
                </a>
                <a href="#" class="sidebar-item" style="padding-left: 2.5rem;">
                    <span class="sidebar-item-icon">👤</span>
                    <span class="sidebar-item-text">Fotógrafos</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-section" style="margin-top: auto; border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 2rem;">
            <nav class="sidebar-nav">
                <a href="/" class="sidebar-item">
                    <span class="sidebar-item-icon">🏠</span>
                    <span class="sidebar-item-text">Volver</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Galerías</h1>
            <button class="add-btn">+ Agregar Galería</button>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filter-item">
                <label>Lugar</label>
                <select>
                    <option>Todos</option>
                    <option>Huaraz</option>
                    <option>Carhuaz</option>
                    <option>Caraz</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Período</label>
                <select>
                    <option>Cualquiera</option>
                    <option>Antes de 1970</option>
                    <option>Terremoto 1970</option>
                    <option>Reconstrucción</option>
                </select>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Buscar galería...">
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid">
            <div class="gallery-card">
                <div class="gallery-image">
                    📷
                    <span class="badge">23 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Fiestas de Cruces</div>
                    <div class="gallery-meta">Por: Sal y Rosas González • 1950-1960</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-image">
                    📸
                    <span class="badge">18 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Yungay en Fotos</div>
                    <div class="gallery-meta">Por: Archivo Histórico • Antes 1970</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-image">
                    🏔️
                    <span class="badge">31 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Recuay en Fotos</div>
                    <div class="gallery-meta">Archivo Histórico • 1950-2000</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-image">
                    🏘️
                    <span class="badge">27 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Caraz y Su Paisaje</div>
                    <div class="gallery-meta">Transformación urbana • 1960-2010</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-image">
                    🎪
                    <span class="badge">15 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Eventos y Celebraciones</div>
                    <div class="gallery-meta">Momentos Importantes • Varias fechas</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-image">
                    👥
                    <span class="badge">42 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Gente y Comunidades</div>
                    <div class="gallery-meta">Retratos • Siglo XX - Presente</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-image">
                    🏛️
                    <span class="badge">19 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Arquitectura Colonial</div>
                    <div class="gallery-meta">Iglesias Históricas • Antes 1970</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-image">
                    🌾
                    <span class="badge">28 fotos</span>
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">Paisajes Rurales</div>
                    <div class="gallery-meta">Naturaleza • Colección Temporal</div>
                    <div class="gallery-actions">
                        <button class="btn-small btn-edit">✏️ Editar</button>
                        <button class="btn-small btn-delete">🗑️ Borrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
