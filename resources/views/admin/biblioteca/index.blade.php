<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar Biblioteca - WARAS</title>
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
            background: #2c3e50;
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
            background: #1a202c;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-toolbar {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .toolbar-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .toolbar-item label {
            font-size: 0.9rem;
            color: #4a5568;
            font-weight: 500;
        }

        .toolbar-item select {
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

        .entries-info {
            font-size: 0.9rem;
            color: #718096;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
            font-size: 0.9rem;
        }

        tbody tr:hover {
            background: #f7fafc;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-edit {
            background: #3498db;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .pagination {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
            font-size: 0.9rem;
            color: #718096;
        }

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .pagination-btn {
            padding: 0.4rem 0.8rem;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .pagination-btn:hover {
            background: #f7fafc;
        }

        .pagination-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-active {
            background: #c6f6d5;
            color: #22543d;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
            }

            .table-toolbar {
                flex-direction: column;
            }

            .search-box {
                width: 100%;
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
                <a href="#" class="sidebar-item active">
                    <span class="sidebar-item-icon">📚</span>
                    <span class="sidebar-item-text">Biblioteca</span>
                </a>
                <a href="/admin/fototeca" class="sidebar-item">
                    <span class="sidebar-item-icon">📷</span>
                    <span class="sidebar-item-text">Fototeca</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Biblioteca</div>
            <nav class="sidebar-nav">
                <a href="#" class="sidebar-item" style="padding-left: 2.5rem;">
                    <span class="sidebar-item-icon">✏️</span>
                    <span class="sidebar-item-text">Autores</span>
                </a>
                <a href="#" class="sidebar-item" style="padding-left: 2.5rem;">
                    <span class="sidebar-item-icon">📖</span>
                    <span class="sidebar-item-text">Libros</span>
                </a>
                <a href="#" class="sidebar-item" style="padding-left: 2.5rem;">
                    <span class="sidebar-item-icon">📑</span>
                    <span class="sidebar-item-text">Categorías</span>
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
            <h1 class="page-title">Autores</h1>
            <button class="add-btn">+ Agregar Autor</button>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <!-- Toolbar -->
            <div class="table-toolbar">
                <div class="toolbar-item">
                    <label>Mostrar</label>
                    <select>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                </div>
                <div class="toolbar-item">
                    <span>Entradas</span>
                </div>
                <div class="search-box">
                    <input type="text" placeholder="Buscar por autor">
                </div>
            </div>

            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Autor</th>
                        <th>Libros</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>32</td>
                        <td>[Corporación Peruana del Santo]</td>
                        <td>5</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>71</td>
                        <td>Alba Herrera, Claudio Augusto</td>
                        <td>3</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>50</td>
                        <td>Albornoz, Santiago E.</td>
                        <td>2</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>69</td>
                        <td>Antúnez de Mayolo Gomero, Santiago</td>
                        <td>4</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>38</td>
                        <td>Antúnez de Mayolo, Santiago ; Torres V., Celso ; Arnao, Aurelio... [y otros]</td>
                        <td>1</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>80</td>
                        <td>Anónimo</td>
                        <td>8</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>61</td>
                        <td>Arnao Loli, Aurelio</td>
                        <td>2</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>112</td>
                        <td>Baronesa de Wilson</td>
                        <td>6</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>93</td>
                        <td>Barriouevo, Leandro</td>
                        <td>3</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>103</td>
                        <td>Blasco Lamenca, Mario y otros</td>
                        <td>1</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit">✏️ Editar</button>
                                <button class="btn-delete">🗑️ Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <div class="entries-info">Mostrando 1 a 10 de 103 Entradas</div>
                <div class="pagination-controls">
                    <button class="pagination-btn">Primero</button>
                    <button class="pagination-btn">Anterior</button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Siguiente</button>
                    <button class="pagination-btn">Último</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
