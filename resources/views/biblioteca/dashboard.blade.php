<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Digital - WARAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        body {
            display: flex;
            flex-direction: column;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #1b2a47;
            --primary-dark: #121d33;
            --accent: #c5a059;
            --accent-hover: #b08d4b;
            --bg-light: #f9f8f6;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: transparent;
            padding: 1.5rem 2rem;
        }

        .header.scrolled {
            background: rgba(27, 42, 71, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.5rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .header.scrolled-content {
            background: rgba(27, 42, 71, 1);
            padding: 0.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-decoration: none;
            color: white;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-squares {
            display: flex;
            gap: 0.25rem;
        }

        .logo-square {
            width: 10px;
            border-radius: 2px;
        }

        .logo-square-1 { height: 28px; background: #60a5fa; }
        .logo-square-2 { height: 22px; background: #f87171; margin-top: 6px; }
        .logo-square-3 { height: 16px; background: var(--accent); margin-top: 12px; }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            font-family: 'Playfair Display', serif;
        }

        .logo-text-sub {
            font-size: 0.85rem;
            font-weight: 300;
            margin-left: 0.5rem;
            font-style: italic;
            opacity: 0.9;
        }

        /* Nav */
        .nav-menu {
            display: flex;
            gap: 0.25rem;
        }

        .nav-item {
            color: #e2e8f0;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            background: transparent;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--accent);
        }

        @media (max-width: 1024px) {
            .nav-menu { display: none; }
        }

        /* Hero */
        .hero {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 80px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            background-attachment: fixed;
        }

        .hero.hidden { 
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 56rem;
            width: 100%;
            padding: 2rem;
            text-align: center;
            color: white;
            margin-top: 4rem;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 300;
            font-style: italic;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
        }

        .search-wrapper {
            width: 100%;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            display: flex;
            overflow: hidden;
            padding: 0.375rem;
            border: 2px solid transparent;
            transition: border-color 0.2s ease;
            max-width: 700px;
            margin: 0 auto;
        }

        .search-wrapper:focus-within { border-color: var(--accent); }

        .search-wrapper-inner {
            flex: 1;
            display: flex;
            align-items: center;
            padding-left: 1.25rem;
        }

        .search-icon {
            color: #9ca3af;
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 1rem 0;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            outline: none;
            background: transparent;
        }

        .search-input::placeholder { color: #9ca3af; }

        .search-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.5rem 2.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .search-btn:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(197, 160, 89, 0.4);
        }

        /* Content Search */
        .content-search {
            margin: 1.5rem 0;
            border: 2px solid var(--accent);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background: white;
            gap: 0.75rem;
        }

        .content-search-icon {
            color: var(--accent);
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .content-search-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .content-search-input::placeholder {
            color: #9ca3af;
        }

        /* Main Wrapper */
        .main-wrapper {
            display: flex;
            width: 100%;
            background: var(--bg-light);
            margin-top: 70px;
            min-height: auto;
        }

        .main-wrapper.hidden { 
            display: none !important;
        }

        /* Sidebar */
        .sidebar {
            width: 288px;
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 0;
            flex-shrink: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: var(--primary);
            color: white;
        }

        .sidebar-title {
            font-weight: 700;
            font-size: 1.125rem;
            font-family: 'Playfair Display', serif;
        }

        /* Categories */
        .categories-section { padding: 1rem 0; }
        .categories-label {
            padding: 0.5rem 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
        }

        .categories-list { list-style: none; }
        .categories-list li { border-bottom: 1px solid #f3f4f6; }

        .category-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 2rem;
            color: #4b5563;
            font-size: 0.875rem;
            font-weight: 500;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .category-btn:hover {
            background: #f9f8f6;
            color: var(--primary);
        }

        .category-btn.active {
            background: #f0f4f8;
            color: var(--primary);
            border-left-color: var(--accent);
        }

        .category-btn.active .category-icon {
            opacity: 1;
            color: var(--accent);
        }

        .category-btn .category-icon { opacity: 0.3; }

        /* Filters */
        .filters-section {
            padding: 1rem 0;
            border-top: 1px solid #e2e8f0;
        }

        .filter-group { padding: 0 2rem 1rem; }
        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }

        .filter-select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e1d8;
            border-radius: 0.375rem;
            background: #fafafa;
            font-size: 0.875rem;
            color: #374151;
        }

        .filter-select:focus { outline: none; border-color: var(--accent); }

        .filter-check { display: flex; flex-direction: column; gap: 0.5rem; }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            cursor: pointer;
        }

        .checkbox-item input { cursor: pointer; }

        /* Content */
        .content {
            flex: 1;
            padding: 2rem 3rem;
            background: var(--bg-light);
        }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .content { padding: 1.5rem 1rem; }
        }

        /* Breadcrumbs */
        .breadcrumbs {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: #9ca3af;
            margin-bottom: 1.5rem;
        }

        .breadcrumbs a {
            color: #1b2a47;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .breadcrumbs a:hover { color: var(--accent); }
        .breadcrumbs .separator { margin: 0 0.5rem; }
        .breadcrumbs .current { color: var(--accent); }

        /* Section */
        .section-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e1d8;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .section-subtitle { color: #9ca3af; font-size: 0.875rem; }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }

        .results-count { font-size: 0.875rem; color: #6b7280; }
        .results-count strong { color: var(--primary); font-weight: 700; }

        .sort-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sort-select {
            background: transparent;
            border: none;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary);
            cursor: pointer;
            outline: none;
        }

        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* Book Card */
        .book-card {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(27, 42, 71, 0.2);
        }

        .book-cover {
            position: relative;
            width: 100%;
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #5c4033 0%, #4a3728 100%);
            overflow: hidden;
        }

        .book-cover-icon {
            font-size: 3rem;
            opacity: 0.8;
            transition: transform 0.3s ease;
            z-index: 10;
        }

        .book-card:hover .book-cover-icon {
            transform: scale(1.1);
            opacity: 1;
        }

        .book-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary);
            padding: 0.375rem 0.625rem;
            border-radius: 0.25rem;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            z-index: 20;
        }

        .book-cover-overlay {
            position: absolute;
            inset: 0;
            background: rgba(27, 42, 71, 0.6);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
            z-index: 15;
        }

        .book-card:hover .book-cover-overlay { opacity: 1; }

        .book-detail-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            transform: translateY(16px);
            opacity: 0;
        }

        .book-card:hover .book-detail-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .book-info {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-card:hover .book-title { color: var(--accent); }

        .book-author {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .book-year {
            font-size: 0.75rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .book-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e5e1d8;
            margin-top: auto;
        }

        .book-rating {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--accent);
        }

        .book-rating-value {
            color: #6b7280;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .book-read-link {
            color: var(--primary);
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .book-card:hover .book-read-link { color: var(--accent); }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            border-top: 4px solid var(--accent);
            z-index: 10;
        }

        .footer-text { font-size: 1rem; margin-bottom: 0.75rem; }
        .footer-subtext {
            font-size: 0.875rem;
            color: #d1d5db;
            margin-top: 0.75rem;
        }

        /* Detail View */
        .detail-view {
            display: none;
            padding: 2rem 3rem;
            background: var(--bg-light);
            margin-top: 70px;
        }

        .detail-view:not(.hidden) {
            display: block;
        }

        .detail-view.hidden {
            display: none !important;
        }

        .detail-back-btn {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s;
        }

        .detail-back-btn:hover {
            color: var(--accent);
        }

        .detail-breadcrumbs {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: #9ca3af;
            margin-bottom: 2rem;
            gap: 0.5rem;
        }

        .breadcrumb-item {
            color: #6b7280;
        }

        .breadcrumb-item.active {
            color: var(--accent);
            font-weight: 600;
        }

        .breadcrumb-separator {
            color: #d1d5db;
        }

        .detail-container {
            display: flex;
            gap: 3rem;
            margin-bottom: 4rem;
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .detail-cover-section {
            flex-shrink: 0;
        }

        .detail-cover {
            width: 280px;
            height: 420px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .detail-cover-icon {
            font-size: 5rem;
        }

        .detail-info-section {
            flex: 1;
        }

        .detail-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .detail-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e1d8;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .meta-item i {
            color: var(--accent);
            width: 1rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section h3 {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        .detail-section p {
            color: #6b7280;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .detail-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .detail-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .detail-btn-primary {
            background: var(--primary);
            color: white;
        }

        .detail-btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 42, 71, 0.3);
        }

        .detail-btn-secondary {
            background: white;
            color: var(--primary);
            border: 1px solid #e2e8f0;
        }

        .detail-btn-secondary:hover {
            background: #f9f8f6;
            border-color: var(--accent);
        }

        .detail-btn-icon {
            width: 2.5rem;
            height: 2.5rem;
            padding: 0;
            justify-content: center;
            background: white;
            color: #6b7280;
            border: 1px solid #e2e8f0;
        }

        .detail-btn-icon:hover {
            color: var(--accent);
            border-color: var(--accent);
        }

        /* Related Materials */
        .related-section {
            margin-top: 3rem;
        }

        .related-section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2rem;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .related-card {
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(27, 42, 71, 0.15);
        }

        .related-cover {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .related-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background: white;
            color: var(--primary);
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .related-icon {
            font-size: 2.5rem;
        }

        .related-info {
            padding: 1rem;
        }

        .related-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .related-author {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 1024px) {
            .detail-container {
                flex-direction: column;
                gap: 2rem;
            }

            .detail-cover {
                width: 240px;
                height: 360px;
                margin: 0 auto;
            }

            .related-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .detail-view {
                padding: 1.5rem 1rem;
            }

            .detail-container {
                padding: 1.5rem;
                border-radius: 0.5rem;
            }

            .detail-cover {
                width: 200px;
                height: 300px;
            }

            .detail-title {
                font-size: 1.5rem;
            }

            .detail-actions {
                flex-wrap: wrap;
            }

            .detail-btn {
                flex: 1;
                min-width: 140px;
            }

            .related-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 1rem;
            }
        }
            margin-top: 0.75rem;
        }

        @media (max-width: 1024px) {
            .hero-title { font-size: 2.5rem; }
            .books-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 1.875rem; }
            .search-wrapper { flex-direction: column; gap: 0.5rem; }
            .search-btn { width: 100%; }
            .books-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="header-container">
            <a href="javascript:void(0)" class="logo" id="logoBtn">
                <div class="logo-squares">
                    <div class="logo-square logo-square-1"></div>
                    <div class="logo-square logo-square-2"></div>
                    <div class="logo-square logo-square-3"></div>
                </div>
                <span class="logo-text">WARAS</span>
                <span class="logo-text-sub">Biblioteca</span>
            </a>

            <nav class="nav-menu" id="navMenu">
                <button data-tab="Inicio" class="nav-item active">Inicio</button>
                <button data-tab="Libros" class="nav-item">Libros</button>
                <button data-tab="Revistas" class="nav-item">Revistas</button>
                <button data-tab="Editoriales" class="nav-item">Editoriales</button>
                <button data-tab="Especiales" class="nav-item">Especiales</button>
                <button data-tab="Autores" class="nav-item">Autores</button>
                <button data-tab="Aportantes" class="nav-item">Aportantes</button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="heroSection">
        <div class="hero-content">
            <h1 class="hero-title">Biblioteca Digital Ancashina</h1>
            <p class="hero-subtitle">"Conocimiento e historia accesible para todos"</p>
            <div class="search-wrapper">
                <div class="search-wrapper-inner">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Buscar por título, autor, materia o palabra clave...">
                </div>
                <button class="search-btn">Buscar</button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-wrapper hidden" id="mainWrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-filter"></i>
                <span class="sidebar-title">Explorar Catálogo</span>
            </div>

            <div class="categories-section">
                <div class="categories-label">Materias</div>
                <ul class="categories-list" id="categoriesList"></ul>
            </div>

            <div class="filters-section">
                <div class="categories-label">Filtros</div>
                
                <div class="filter-group">
                    <label class="filter-label">Año de Publicación</label>
                    <select class="filter-select">
                        <option>Todos los años</option>
                        <option>Últimos 5 años</option>
                        <option>Últimos 10 años</option>
                        <option>Anteriores a 2000</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Formato</label>
                    <div class="filter-check">
                        <label class="checkbox-item">
                            <input type="checkbox" checked>
                            <span>Libros Digitales</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" checked>
                            <span>Revistas</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox">
                            <span>Manuscritos</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox">
                            <span>Mapas</span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="content">
            <div class="breadcrumbs">
                <a id="breadcrumbHome">Catálogo</a>
                <span class="separator">›</span>
                <span class="current" id="breadcrumbCategory">Historia Y Geografía</span>
            </div>

            <!-- Search Box -->
            <div class="content-search">
                <i class="fas fa-search content-search-icon"></i>
                <input type="text" class="content-search-input" id="contentSearchInput" placeholder="Buscar libros, autores o temas en Historia Y Geografía...">
            </div>

            <div class="section-header">
                <h2 class="section-title" id="sectionTitle">Historia Y Geografía</h2>
                <p class="section-subtitle">Mostrando resultados del catálogo digital.</p>
            </div>

            <div class="toolbar">
                <span class="results-count" id="resourceCount"><strong id="resourceNumber">0</strong> recursos encontrados</span>
                <div class="sort-controls">
                    <i class="fas fa-sliders-h" style="color: #9ca3af;"></i>
                    <span>Ordenar por:</span>
                    <select class="sort-select">
                        <option>Relevancia</option>
                        <option>Título (A-Z)</option>
                        <option>Más recientes</option>
                        <option>Más consultados</option>
                    </select>
                </div>
            </div>

            <div class="books-grid" id="booksGrid"></div>
        </main>
    </div>

    <!-- Detail View -->
    <div class="detail-view hidden" id="detailView">
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
                        <i class="fas fa-star"></i>
                        <span id="detailRating">0</span> votos
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
                    <button class="detail-btn detail-btn-primary">
                        <i class="fas fa-book-open"></i> Leer en línea
                    </button>
                    <button class="detail-btn detail-btn-secondary">
                        <i class="fas fa-download"></i> Descargar PDF
                    </button>
                    <button class="detail-btn detail-btn-icon">
                        <i class="fas fa-bookmark"></i>
                    </button>
                    <button class="detail-btn detail-btn-icon">
                        <i class="fas fa-share-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Materials -->
        <div class="related-section">
            <h2>Materiales Relacionados</h2>
            <div class="related-grid" id="relatedGrid"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p class="footer-text">© 2024 WARAS - Asociación de Ciencia y Cultura Ancashina</p>
        <p class="footer-subtext">Preservando la memoria cultural de nuestra región</p>
    </footer>

    <script>
        // ========== CATEGORÍAS POR SECCIÓN ==========
        const categoriesBySection = {
            'Libros': [
                'Generalidades', 'Filosofía y Psicología', 'Religión', 'Ciencias Sociales',
                'Lenguas', 'Ciencias Naturales', 'Ciencias Aplicadas', 'Arte',
                'Literatura', 'Historia Y Geografía'
            ],
            'Revistas': [
                'Ciencia y Tecnología', 'Cultura y Arte', 'Historia', 'Política y Sociedad',
                'Literatura y Poesía', 'Naturales y Medio Ambiente', 'Educación', 'Especializadas'
            ],
            'Editoriales': [
                'Editorial WARAS', 'Universidad Nacional de Ancash', 'Fondo Editorial Andino',
                'Ministerio de Cultura', 'Editorial Ancashina', 'Imprentas Locales'
            ],
            'Especiales': [
                'Colecciones Raras', 'Documentos Históricos', 'Manuscritos Antiguos',
                'Mapas Geográficos', 'Fotografías Históricas', 'Diarios y Crónicas'
            ],
            'Autores': [
                'Escritores Ancashinos', 'Poetas', 'Historiadores', 'Cronistas',
                'Investigadores', 'Académicos', 'Folcloristas', 'Periodistas'
            ],
            'Aportantes': [
                'Donaciones Privadas', 'Universidades', 'Organizaciones Culturales',
                'Museos y Archivos', 'Instituciones Públicas', 'Coleccionistas'
            ]
        };

        // ========== DATOS POR SECCIÓN ==========
        const dataBySectionAndCategory = {
            'Libros': {
                'Historia Y Geografía': [
                    { id: 1, title: 'Historia de Ancash I', author: 'Julio Ruiz', year: '1998', rating: 45, type: 'Libro', icon: '📚', pages: 342, language: 'Español', publisher: 'Ediciones Huascarán', color: '#5c4033', synopsis: 'Una exploración profunda de los eventos históricos que moldearon la región de Ancash desde la época preincaica hasta la colonia. Contiene ilustraciones y mapas detallados sobre la evolución de los pueblos.' },
                    { id: 2, title: 'Geografía Regional del Santa', author: 'Instituto Geográfico', year: '2005', rating: 28, type: 'Mapa', icon: '🗺️', pages: 156, language: 'Español', publisher: 'INEGI', color: '#4a7c5e', synopsis: 'Análisis cartográfico exhaustivo de la región del Santa con datos actualizados sobre geografía, hidrología y características demográficas.' },
                    { id: 3, title: 'Crónicas Coloniales', author: 'Pedro Mora', year: '1992', rating: 67, type: 'Libro', icon: '📚', pages: 298, language: 'Español', publisher: 'Editorial Andrés Bello', color: '#5c4033', synopsis: 'Compilación de crónicas y relatos de la época colonial en Ancash, documentando el encuentro entre culturas y la transformación social.' },
                    { id: 4, title: 'Mapas Históricos', author: 'Cartografía Nacional', year: '2010', rating: 34, type: 'Mapa', icon: '🗺️', pages: 128, language: 'Español', publisher: 'Biblioteca Nacional', color: '#4a7c5e', synopsis: 'Colección de mapas históricos que documenta la evolución territorial y administrativa de Ancash a través de los siglos.' },
                    { id: 5, title: 'Evolución Demográfica 1800-2020', author: 'INEI', year: '2021', rating: 89, type: 'Libro', icon: '📚', pages: 412, language: 'Español', publisher: 'Instituto Nacional de Estadística', color: '#5c4033', synopsis: 'Análisis estadístico y demográfico de la región de Ancash en los últimos 220 años, con gráficos y datos históricos.' },
                    { id: 6, title: 'Batallas y Conflictos', author: 'Dr. Carlos Rivas', year: '1995', rating: 78, type: 'Libro', icon: '📚', pages: 267, language: 'Español', publisher: 'Fondo Editorial Andino', color: '#5c4033', synopsis: 'Estudio académico de los principales conflictos y batallas que ocurrieron en la región andina, especialmente en Ancash.' }
                ],
                'Literatura': [
                    { id: 7, title: 'Cuentos Andinos Ancashinos', author: 'Marcos Yauri', year: '2012', rating: 134, type: 'Libro', icon: '📖', pages: 189, language: 'Español', publisher: 'Editorial Cultura Andina', color: '#8b3a3a', synopsis: 'Colección de cuentos tradicionales y contemporáneos que capturan la esencia de la cultura ancashina con narrativas cautivadoras.' },
                    { id: 8, title: 'Poesía de la Cordillera', author: 'Luis Montoya', year: '2000', rating: 92, type: 'Libro', icon: '📖', pages: 234, language: 'Español', publisher: 'Poesía Contemporánea', color: '#8b3a3a', synopsis: 'Antología de poesía que celebra la majestuosidad de las montañas andinas y la riqueza cultural de sus pueblos.' },
                    { id: 9, title: 'Narrativa Regional', author: 'Varios Autores', year: '2018', rating: 67, type: 'Libro', icon: '📖', pages: 301, language: 'Español', publisher: 'Ediciones Regionales', color: '#8b3a3a', synopsis: 'Compilación de obras narrativas de escritores ancashinos que exploran temas de identidad, tradición y modernidad.' },
                    { id: 10, title: 'El Realismo Andino', author: 'Dr. Enrique Covarrubias', year: '2007', rating: 45, type: 'Libro', icon: '📖', pages: 276, language: 'Español', publisher: 'Academia Literaria', color: '#8b3a3a', synopsis: 'Análisis crítico y teórico del realismo en la literatura andina, explorando sus características y representantes principales.' },
                    { id: 11, title: 'Tradiciones Populares', author: 'Folklore Institute', year: '2015', rating: 88, type: 'Libro', icon: '📖', pages: 312, language: 'Español', publisher: 'Instituto de Tradiciones', color: '#8b3a3a', synopsis: 'Registro documentado de tradiciones, leyendas y costumbres populares de las comunidades ancashinas.' },
                    { id: 12, title: 'Mitología Andina', author: 'Anthropos Press', year: '2003', rating: 76, type: 'Libro', icon: '📖', pages: 267, language: 'Español', publisher: 'Anthropos Publishing', color: '#8b3a3a', synopsis: 'Estudio comprensivo de los mitos y creencias cosmológicas de las culturas andinas prehispánicas.' }
                ],
                'default': [
                    { id: 1, title: 'Historia de Ancash I', author: 'Julio Ruiz', year: '1998', rating: 45, type: 'Libro', icon: '📚', pages: 342, language: 'Español', publisher: 'Ediciones Huascarán', color: '#5c4033', synopsis: 'Una exploración profunda de los eventos históricos que moldearon la región de Ancash.' },
                    { id: 2, title: 'Geografía Regional del Santa', author: 'Instituto Geográfico', year: '2005', rating: 28, type: 'Mapa', icon: '🗺️', pages: 156, language: 'Español', publisher: 'INEGI', color: '#4a7c5e', synopsis: 'Análisis cartográfico exhaustivo de la región del Santa.' },
                    { id: 3, title: 'Cuentos Andinos Ancashinos', author: 'Marcos Yauri', year: '2012', rating: 134, type: 'Libro', icon: '📖', pages: 189, language: 'Español', publisher: 'Editorial Cultura Andina', color: '#8b3a3a', synopsis: 'Colección de cuentos tradicionales y contemporáneos.' },
                    { id: 4, title: 'Anales de la Literatura', author: 'Varios Autores', year: '1985', rating: 12, type: 'Revista', icon: '📰', pages: 98, language: 'Español', publisher: 'Editorial General', color: '#2c3e50', synopsis: 'Análisis de eventos literarios y cultural importantes.' }
                ]
            },
            'Revistas': {
                'Ciencia y Tecnología': [
                    { id: 20, title: 'Revista de Ciencias Aplicadas', author: 'Dr. Fernando López', year: '2023', rating: 78, type: 'Revista', icon: '📰', pages: 124, language: 'Español', publisher: 'Academia Científica', color: '#2c3e50', synopsis: 'Publicación trimestral con artículos de investigación sobre ciencias aplicadas e innovación tecnológica.' },
                    { id: 21, title: 'Tecnología en los Andes', author: 'Instituto Tecnológico', year: '2022', rating: 65, type: 'Revista', icon: '📰', pages: 112, language: 'Español', publisher: 'Instituto Andino', color: '#2c3e50', synopsis: 'Revista especializada en tecnología moderna y su aplicación en comunidades andinas.' },
                    { id: 22, title: 'Investigaciones Modernas', author: 'Academia Ancashina', year: '2021', rating: 89, type: 'Revista', icon: '📰', pages: 156, language: 'Español', publisher: 'Academia Ancashina', color: '#2c3e50', synopsis: 'Compilación de investigaciones contemporáneas en diversas disciplinas científicas.' },
                    { id: 23, title: 'Boletín Científico Mensual', author: 'CONCYTEC', year: '2023', rating: 92, type: 'Revista', icon: '📰', pages: 98, language: 'Español', publisher: 'CONCYTEC', color: '#2c3e50', synopsis: 'Boletín mensual con resúmenes de investigaciones y avances científicos nacionales.' },
                    { id: 24, title: 'Reportes Tecnológicos', author: 'Ministerio de Ciencia', year: '2022', rating: 71, type: 'Revista', icon: '📰', pages: 134, language: 'Español', publisher: 'Ministerio de Ciencia', color: '#2c3e50', synopsis: 'Reportes técnicos sobre innovaciones y proyectos tecnológicos regionales.' },
                    { id: 25, title: 'El Avance Digital', author: 'Varios', year: '2023', rating: 84, type: 'Revista', icon: '📰', pages: 108, language: 'Español', publisher: 'Editorial Digital', color: '#2c3e50', synopsis: 'Revista enfocada en transformación digital y tecnología de información.' }
                ],
                'default': [
                    { id: 20, title: 'Revista Cultural Ancashina', author: 'Editorial WARAS', year: '2023', rating: 78, type: 'Revista', icon: '📰', pages: 124, language: 'Español', publisher: 'Editorial WARAS', color: '#2c3e50', synopsis: 'Publicación periódica sobre cultura y tradiciones de Ancash.' },
                    { id: 21, title: 'Revista Histórica Regional', author: 'Museo Ancash', year: '2022', rating: 65, type: 'Revista', icon: '📰', pages: 112, language: 'Español', publisher: 'Museo Ancash', color: '#2c3e50', synopsis: 'Revista especializada en historia regional y patrimonio cultural.' },
                    { id: 22, title: 'Boletín Informativo', author: 'Varios', year: '2023', rating: 59, type: 'Revista', icon: '📰', pages: 88, language: 'Español', publisher: 'WARAS', color: '#2c3e50', synopsis: 'Boletín informativo con noticias sobre actividades culturales.' },
                    { id: 23, title: 'Publicación Trimestral', author: 'WARAS', year: '2023', rating: 72, type: 'Revista', icon: '📰', pages: 96, language: 'Español', publisher: 'WARAS', color: '#2c3e50', synopsis: 'Publicación trimestral con reportes y análisis culturales.' }
                ]
            },
            'Editoriales': {
                'default': [
                    { id: 30, title: 'Catálogo Editorial WARAS 2023', author: 'Editorial WARAS', year: '2023', rating: 85, type: 'Catálogo', icon: '📚', pages: 156, language: 'Español', publisher: 'Editorial WARAS', color: '#5c4033', synopsis: 'Catálogo completo de publicaciones de WARAS con descripción de obras y autores.' },
                    { id: 31, title: 'Publicaciones Universidad Nacional', author: 'UNASAM', year: '2023', rating: 78, type: 'Catálogo', icon: '📚', pages: 178, language: 'Español', publisher: 'UNASAM', color: '#5c4033', synopsis: 'Catálogo de investigaciones y publicaciones de la Universidad Nacional de Ancash.' },
                    { id: 32, title: 'Obras Fondo Editorial Andino', author: 'Fondo Editorial', year: '2022', rating: 71, type: 'Catálogo', icon: '📚', pages: 134, language: 'Español', publisher: 'Fondo Editorial Andino', color: '#5c4033', synopsis: 'Listado completo de obras publicadas por el Fondo Editorial Andino.' },
                    { id: 33, title: 'Patrimonio Impreso', author: 'Ministerio de Cultura', year: '2021', rating: 88, type: 'Libroguía', icon: '📚', pages: 198, language: 'Español', publisher: 'Ministerio de Cultura', color: '#5c4033', synopsis: 'Guía del patrimonio bibliográfico impreso de la región.' },
                    { id: 34, title: 'Acervo Ancashino', author: 'Biblioteca Central', year: '2023', rating: 76, type: 'Catálogo', icon: '📚', pages: 145, language: 'Español', publisher: 'Biblioteca Central', color: '#5c4033', synopsis: 'Catálogo del acervo bibliográfico de la Biblioteca Central de Ancash.' },
                    { id: 35, title: 'Índice de Publicaciones', author: 'Archivo Regional', year: '2022', rating: 69, type: 'Referencia', icon: '📚', pages: 234, language: 'Español', publisher: 'Archivo Regional', color: '#5c4033', synopsis: 'Índice sistemático de todas las publicaciones registradas en la región.' }
                ]
            },
            'Especiales': {
                'default': [
                    { id: 40, title: 'Manuscritos del Siglo XVII', author: 'Archivo Antiguo', year: '1685', rating: 95, type: 'Manuscrito', icon: '✍️', pages: 156, language: 'Español', publisher: 'Archivo Antiguo', color: '#6b4423', synopsis: 'Colección de manuscritos originales del siglo XVII de gran valor histórico y literario.' },
                    { id: 41, title: 'Colección de Mapas Antiguos', author: 'Cartografía Histórica', year: '1800', rating: 92, type: 'Mapa', icon: '🗺️', pages: 124, language: 'Español', publisher: 'Archivo Nacional', color: '#4a7c5e', synopsis: 'Mapas históricos y cartografía antigua de las regiones andinas.' },
                    { id: 42, title: 'Fotografías 1900-1950', author: 'Fondo Fotográfico', year: '1925', rating: 88, type: 'Fotografía', icon: '📷', pages: 189, language: 'Español', publisher: 'Fondo Fotográfico', color: '#3d5a3d', synopsis: 'Archivo de fotografías históricas que documentan la vida y la sociedad ancashina.' },
                    { id: 43, title: 'Diarios y Crónicas Coloniales', author: 'Archivo Histórico', year: '1750', rating: 94, type: 'Documento', icon: '📜', pages: 267, language: 'Español', publisher: 'Archivo Histórico', color: '#5c4033', synopsis: 'Diarios originales y crónicas de la época colonial de gran valor documental.' },
                    { id: 44, title: 'Records Rarísimos del Perú', author: 'Biblioteca Nacional', year: '1600', rating: 96, type: 'Raro', icon: '💎', pages: 198, language: 'Español', publisher: 'Biblioteca Nacional Peruana', color: '#8b7355', synopsis: 'Compilación de documentos rarísimos y únicos sobre Perú y Ancash.' },
                    { id: 45, title: 'Ediciones de Incunables', author: 'Colección Especial', year: '1500', rating: 98, type: 'Incunable', icon: '📖', pages: 112, language: 'Latín', publisher: 'Colección Especial', color: '#6b4423', synopsis: 'Colección de los primeros libros impresos, de extraordinario valor histórico.' }
                ]
            },
            'Autores': {
                'default': [
                    { id: 50, title: 'Grandes Escritores Ancashinos', author: 'Enciclopedia Autores', year: '2023', rating: 87, type: 'Antología', icon: '✍️', pages: 267, language: 'Español', publisher: 'Enciclopedia Nacional', color: '#5c4033', synopsis: 'Biografías y análisis crítico de los más importantes escritores ancashinos.' },
                    { id: 51, title: 'Poetas de la Región', author: 'Varios', year: '2022', rating: 79, type: 'Antología', icon: '📝', pages: 189, language: 'Español', publisher: 'Antología Poética', color: '#5c4033', synopsis: 'Compilación de poesía de autores de toda la región andina.' },
                    { id: 52, title: 'Historiadores Ancashinos', author: 'Academia', year: '2021', rating: 84, type: 'Referencia', icon: '📚', pages: 234, language: 'Español', publisher: 'Academia Histórica', color: '#5c4033', synopsis: 'Perfil y obra de los historiadores más importantes de Ancash.' },
                    { id: 53, title: 'Cronistas del Siglo XX', author: 'Archivo Regional', year: '2020', rating: 81, type: 'Colección', icon: '📰', pages: 198, language: 'Español', publisher: 'Archivo Regional', color: '#5c4033', synopsis: 'Obras completas de cronistas del siglo XX que han documentado la historia regional.' },
                    { id: 54, title: 'Obra Completa - Escritores Clásicos', author: 'Selección Editorial', year: '2019', rating: 92, type: 'Colección', icon: '📖', pages: 456, language: 'Español', publisher: 'Selección Editorial', color: '#5c4033', synopsis: 'Compilación completa de los escritores clásicos más importantes de Ancash.' },
                    { id: 55, title: 'Autores Contemporáneos', author: 'Crítica Literaria', year: '2023', rating: 76, type: 'Análisis', icon: '✍️', pages: 167, language: 'Español', publisher: 'Instituto Literario', color: '#5c4033', synopsis: 'Análisis crítico de autores contemporáneos y sus contribuciones literarias.' }
                ]
            },
            'Aportantes': {
                'default': [
                    { id: 60, title: 'Donaciones del Año 2023', author: 'WARAS Biblioteca', year: '2023', rating: 82, type: 'Informe', icon: '🎁', pages: 134, language: 'Español', publisher: 'WARAS', color: '#5c4033', synopsis: 'Informe detallado de todas las donaciones de libros recibidas en 2023.' },
                    { id: 61, title: 'Contribuciones Universitarias', author: 'UNASAM y Universidades', year: '2023', rating: 78, type: 'Reporte', icon: '🏫', pages: 156, language: 'Español', publisher: 'UNASAM', color: '#5c4033', synopsis: 'Reporte de contribuciones de universidades y centros de investigación.' },
                    { id: 62, title: 'Acervos de Organizaciones', author: 'ONGs Culturales', year: '2022', rating: 75, type: 'Catálogo', icon: '🤝', pages: 145, language: 'Español', publisher: 'WARAS', color: '#5c4033', synopsis: 'Catálogo de materiales donados por organizaciones culturales.' },
                    { id: 63, title: 'Recaudos de Museos', author: 'Museos Ancashinos', year: '2022', rating: 89, type: 'Colección', icon: '🏢', pages: 178, language: 'Español', publisher: 'Museos Ancashinos', color: '#5c4033', synopsis: 'Listado de acervos donados por museos locales y regionales.' },
                    { id: 64, title: 'Fondos Institucionales', author: 'Ministerios', year: '2021', rating: 84, type: 'Archivo', icon: '📦', pages: 167, language: 'Español', publisher: 'Gobierno Regional', color: '#5c4033', synopsis: 'Fondos y materiales aportados por instituciones públicas y ministerios.' },
                    { id: 65, title: 'Colecciones Privadas Donadas', author: 'Mecenas', year: '2023', rating: 91, type: 'Especial', icon: '💰', pages: 189, language: 'Español', publisher: 'WARAS', color: '#5c4033', synopsis: 'Colecciones privadas de valor histórico donadas por mecenas y coleccionistas.' }
                ]
            }
        };

        let state = {
            activeTab: 'Inicio',
            activeCategory: 'Historia Y Geografía',
            isScrolled: false
        };

        // ========== OBTENER DATOS según TAB y CATEGORÍA ==========
        function getDataForSection() {
            const sectionData = dataBySectionAndCategory[state.activeTab];
            if (sectionData && sectionData[state.activeCategory]) {
                return sectionData[state.activeCategory];
            } else if (sectionData && sectionData['default']) {
                return sectionData['default'];
            }
            return [];
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

        function renderCategories() {
            const list = document.getElementById('categoriesList');
            const currentCategories = categoriesBySection[state.activeTab] || categoriesBySection['Libros'];
            
            list.innerHTML = currentCategories.map(cat => `
                <li>
                    <button class="category-btn ${cat === state.activeCategory ? 'active' : ''}" data-category="${cat}">
                        <span>${cat}</span>
                        <i class="fas fa-chevron-right category-icon"></i>
                    </button>
                </li>
            `).join('');

            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const newCategory = btn.getAttribute('data-category');
                    state.activeCategory = newCategory;
                    document.getElementById('sectionTitle').textContent = newCategory;
                    document.getElementById('breadcrumbCategory').textContent = newCategory;
                    document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${newCategory}...`;
                    
                    document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    renderBooks();
                });
            });
        }

        function renderBooks() {
            const grid = document.getElementById('booksGrid');
            const items = getDataForSection();
            
            // Actualizar contador de recursos
            document.getElementById('resourceNumber').textContent = items.length;
            
            grid.innerHTML = items.map((item, index) => `
                <div class="book-card">
                    <div class="book-cover">
                        <span class="book-badge">${item.type}</span>
                        <span class="book-cover-icon">${item.icon}</span>
                        <div class="book-cover-overlay">
                            <button class="book-detail-btn" data-item-id="book-${index}">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </button>
                        </div>
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">${item.title}</h3>
                        <p class="book-author">${item.author}</p>
                        <p class="book-year">Publicación: ${item.year}</p>
                        <div class="book-footer">
                            <div class="book-rating">
                                <i class="fas fa-star"></i>
                                <span class="book-rating-value">${item.rating}</span>
                            </div>
                            <a href="#" class="book-read-link">Leer →</a>
                        </div>
                    </div>
                </div>
            `).join('');

            // Agregar event listeners a los botones
            document.querySelectorAll('.book-detail-btn').forEach((btn, index) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const item = items[index];
                    showDetailView(item);
                });
            });
        }

        function showSection(tab) {
            const hero = document.getElementById('heroSection');
            const main = document.getElementById('mainWrapper');
            
            state.activeTab = tab;
            state.activeCategory = (categoriesBySection[tab] || categoriesBySection['Libros'])[0];
            
            hero.classList.add('hidden');
            main.classList.remove('hidden');
            
            document.getElementById('sectionTitle').textContent = state.activeCategory;
            document.getElementById('breadcrumbCategory').textContent = state.activeCategory;
            document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${state.activeCategory}...`;
            
            renderCategories();
            renderBooks();
            updateNavigation();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function showHero() {
            const hero = document.getElementById('heroSection');
            const main = document.getElementById('mainWrapper');
            
            state.activeTab = 'Inicio';
            state.activeCategory = 'Historia Y Geografía';
            
            hero.classList.remove('hidden');
            main.classList.add('hidden');
            
            updateNavigation();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function updateNavigation() {
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.toggle('active', item.getAttribute('data-tab') === state.activeTab);
            });
        }

        document.getElementById('logoBtn').addEventListener('click', showHero);
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                if (tab === 'Inicio') showHero();
                else showSection(tab);
            });
        });

        // ========== FUNCIONES PARA VISTA DE DETALLE ==========
        let currentMaterial = null;

        function showDetailView(item) {
            currentMaterial = item;
            
            // Llenar información
            document.getElementById('detailTitle').textContent = item.title;
            document.getElementById('detailAuthor').textContent = item.author;
            document.getElementById('detailYear').textContent = item.year;
            document.getElementById('detailPages').textContent = item.pages || 'N/A';
            document.getElementById('detailLanguage').textContent = item.language || 'Español';
            document.getElementById('detailRating').textContent = item.rating;
            document.getElementById('detailSynopsis').textContent = item.synopsis;
            document.getElementById('detailPublisher').textContent = item.publisher;
            document.getElementById('breadcrumb-category').textContent = state.activeCategory;
            document.getElementById('breadcrumb-title').textContent = item.title;

            // Cover info
            const detailCover = document.getElementById('detailCover');
            detailCover.style.backgroundColor = item.color || '#5c4033';
            document.getElementById('detailCoverIcon').textContent = item.icon;

            // Materiales relacionados
            renderRelatedMaterials(item);

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
                    <div class="related-cover" style="background-color: ${item.color};">
                        <span class="related-badge">${item.type}</span>
                        <span class="related-icon">${item.icon}</span>
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
        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${state.activeCategory}...`;
    </script>
</body>
</html>
