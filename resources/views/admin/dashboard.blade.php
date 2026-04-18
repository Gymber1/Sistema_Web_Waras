<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administrativo - WARAS</title>
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
            position: relative;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: #667eea;
        }

        .sidebar-item.active {
            background: rgba(102, 126, 234, 0.1);
            color: white;
            border-left-color: #667eea;
        }

        .sidebar-item-icon {
            font-size: 1.2rem;
            width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-item-text {
            flex: 1;
        }

        .sidebar-item-badge {
            background: #667eea;
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .sidebar-item-badge.inactive {
            background: #cbd5e0;
            color: #4a5568;
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            min-height: 100vh;
            padding: 2rem;
        }

        .header-bar {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .header-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a202c;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .user-name {
            font-weight: 600;
            color: #1a202c;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #718096;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .module-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-top: 4px solid #e2e8f0;
        }

        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .module-card.biblioteca {
            border-top-color: #2c3e50;
        }

        .module-card.fototeca {
            border-top-color: #e74c3c;
        }

        .module-card.musicoteca {
            border-top-color: #f39c12;
        }

        .module-card.pinacoteca {
            border-top-color: #9b59b6;
        }

        .module-card.efemeridades {
            border-top-color: #1abc9c;
        }

        .module-header {
            padding: 1.5rem;
            background: #f7fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .module-icon {
            font-size: 2rem;
        }

        .module-titles {
            flex: 1;
        }

        .module-name {
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.2rem;
        }

        .module-type {
            font-size: 0.8rem;
            color: #718096;
        }

        .module-content {
            padding: 1.5rem;
        }

        .module-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            background: #f7fafc;
            padding: 1rem;
            border-radius: 6px;
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #718096;
            margin-top: 0.3rem;
        }

        .module-actions {
            display: flex;
            gap: 0.8rem;
        }

        .btn {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #2d3748;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
        }

        .btn-disabled {
            background: #cbd5e0;
            color: #a0aec0;
            cursor: not-allowed;
        }

        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .status-operativo {
            background: #c6f6d5;
            color: #22543d;
        }

        .status-desarrollo {
            background: #fef5e7;
            color: #6d4c41;
        }

        .status-planificado {
            background: #ede9fe;
            color: #581c87;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                left: -200px;
                width: 200px;
                transition: left 0.3s ease;
                z-index: 100;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .header-bar {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">W</div>
                <span>WARAS</span>
            </div>
        </div>

        <!-- Módulos Operativos -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Módulos Operativos</div>
            <nav class="sidebar-nav">
                <a href="#biblioteca" class="sidebar-item active">
                    <span class="sidebar-item-icon">📚</span>
                    <span class="sidebar-item-text">Biblioteca</span>
                </a>
                <a href="#fototeca" class="sidebar-item">
                    <span class="sidebar-item-icon">📷</span>
                    <span class="sidebar-item-text">Fototeca</span>
                </a>
            </nav>
        </div>

        <!-- Módulos en Desarrollo -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">En Desarrollo</div>
            <nav class="sidebar-nav">
                <a href="#musicoteca" class="sidebar-item">
                    <span class="sidebar-item-icon">🎵</span>
                    <span class="sidebar-item-text">Musicoteca</span>
                    <span class="sidebar-item-badge inactive">Pronto</span>
                </a>
            </nav>
        </div>

        <!-- Módulos Planificados -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Planificado</div>
            <nav class="sidebar-nav">
                <a href="#pinacoteca" class="sidebar-item">
                    <span class="sidebar-item-icon">🎨</span>
                    <span class="sidebar-item-text">Pinacoteca</span>
                    <span class="sidebar-item-badge inactive">Pronto</span>
                </a>
                <a href="#efemeridades" class="sidebar-item">
                    <span class="sidebar-item-icon">📅</span>
                    <span class="sidebar-item-text">Efemeridades</span>
                    <span class="sidebar-item-badge inactive">Pronto</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar -->
        <div class="sidebar-section" style="margin-top: auto; border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 2rem;">
            <nav class="sidebar-nav">
                <a href="/" class="sidebar-item">
                    <span class="sidebar-item-icon">🏠</span>
                    <span class="sidebar-item-text">Volver al Portal</span>
                </a>
                <a href="#logout" class="sidebar-item">
                    <span class="sidebar-item-icon">🚪</span>
                    <span class="sidebar-item-text">Cerrar Sesión</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Bar -->
        <div class="header-bar">
            <div>
                <h1 class="header-title">Panel Administrativo</h1>
            </div>
            <div class="header-user">
                <div class="user-avatar">A</div>
                <div class="user-info">
                    <div class="user-name">Administrador</div>
                    <div class="user-role">Admin Global</div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Biblioteca Module -->
            <div class="module-card biblioteca">
                <div class="module-header">
                    <div class="module-icon">📚</div>
                    <div class="module-titles">
                        <div class="module-name">Biblioteca Digital</div>
                        <div class="module-type">Gestión de Libros y Autores</div>
                    </div>
                    <span class="status-badge status-operativo">Operativo</span>
                </div>
                <div class="module-content">
                    <div class="module-stats">
                        <div class="stat-item">
                            <div class="stat-number">127</div>
                            <div class="stat-label">Libros</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">103</div>
                            <div class="stat-label">Autores</div>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="/admin/biblioteca" class="btn btn-primary">Administrar</a>
                        <a href="/biblioteca" class="btn btn-secondary">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Fototeca Module -->
            <div class="module-card fototeca">
                <div class="module-header">
                    <div class="module-icon">📷</div>
                    <div class="module-titles">
                        <div class="module-name">Fototeca Digital</div>
                        <div class="module-type">Gestión de Galerías</div>
                    </div>
                    <span class="status-badge status-operativo">Operativo</span>
                </div>
                <div class="module-content">
                    <div class="module-stats">
                        <div class="stat-item">
                            <div class="stat-number">42</div>
                            <div class="stat-label">Galerías</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">856</div>
                            <div class="stat-label">Fotos</div>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="/admin/fototeca" class="btn btn-primary">Administrar</a>
                        <a href="/fototeca" class="btn btn-secondary">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Musicoteca Module -->
            <div class="module-card musicoteca">
                <div class="module-header">
                    <div class="module-icon">🎵</div>
                    <div class="module-titles">
                        <div class="module-name">Musicoteca Digital</div>
                        <div class="module-type">Gestión de Música</div>
                    </div>
                    <span class="status-badge status-desarrollo">En Desarrollo</span>
                </div>
                <div class="module-content">
                    <div class="module-stats">
                        <div class="stat-item">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Álbumes</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Canciones</div>
                        </div>
                    </div>
                    <div class="module-actions">
                        <button class="btn btn-disabled" disabled>En Desarrollo</button>
                    </div>
                </div>
            </div>

            <!-- Pinacoteca Module -->
            <div class="module-card pinacoteca">
                <div class="module-header">
                    <div class="module-icon">🎨</div>
                    <div class="module-titles">
                        <div class="module-name">Pinacoteca Digital</div>
                        <div class="module-type">Gestión de Arte</div>
                    </div>
                    <span class="status-badge status-planificado">Planificado</span>
                </div>
                <div class="module-content">
                    <div class="module-stats">
                        <div class="stat-item">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Obras</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Artistas</div>
                        </div>
                    </div>
                    <div class="module-actions">
                        <button class="btn btn-disabled" disabled>Próximamente</button>
                    </div>
                </div>
            </div>

            <!-- Efemeridades Module -->
            <div class="module-card efemeridades">
                <div class="module-header">
                    <div class="module-icon">📅</div>
                    <div class="module-titles">
                        <div class="module-name">Efemeridades Digital</div>
                        <div class="module-type">Gestión de Eventos</div>
                    </div>
                    <span class="status-badge status-planificado">Planificado</span>
                </div>
                <div class="module-content">
                    <div class="module-stats">
                        <div class="stat-item">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Eventos</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Fechas</div>
                        </div>
                    </div>
                    <div class="module-actions">
                        <button class="btn btn-disabled" disabled>Próximamente</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple sidebar toggle
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
