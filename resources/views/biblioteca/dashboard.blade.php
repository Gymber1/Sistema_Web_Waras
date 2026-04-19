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
            padding-bottom: 80px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            background-attachment: fixed;
            overflow: visible;
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
            overflow: visible;
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

        /* Hero search dropdown */
        .hero-search-container {
            position: relative;
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-search-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.45);
            z-index: 9999;
            max-height: 420px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .hero-search-dropdown.open { display: block; }

        .hsd-section-label {
            padding: 0.6rem 1.25rem 0.3rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            background: #f9f8f6;
            border-bottom: 1px solid #f0ede8;
        }

        .hsd-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.75rem 1.25rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.15s;
            text-decoration: none;
            color: inherit;
        }

        .hsd-item:hover { background: #f9f8f6; }
        .hsd-item:last-child { border-bottom: none; }

        .hsd-thumb {
            width: 36px; height: 36px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            background: linear-gradient(135deg,#2d3436,#636e72);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            overflow: hidden;
        }

        .hsd-thumb img { width: 100%; height: 100%; object-fit: cover; }

        .hsd-info { flex: 1; min-width: 0; }

        .hsd-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .hsd-sub {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .hsd-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            background: #e5e7eb;
            color: #6b7280;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .hsd-empty {
            padding: 1.5rem;
            text-align: center;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .hsd-all-btn {
            display: block;
            padding: 0.75rem;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent);
            cursor: pointer;
            border-top: 1px solid #e5e7eb;
            background: white;
            border: none;
            width: 100%;
            transition: background 0.15s;
        }

        .hsd-all-btn:hover { background: #f9f8f6; }

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

        /* Accordion categories */
        .acc-parent-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 2rem;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 600;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .acc-parent-btn:hover {
            background: #f0f4f8;
            color: var(--primary);
        }

        .acc-parent-btn.open {
            background: #f0f4f8;
            color: var(--primary);
            border-left-color: var(--accent);
        }

        .acc-chevron {
            font-size: 0.7rem;
            transition: transform 0.25s ease;
            color: #9ca3af;
        }

        .acc-parent-btn.open .acc-chevron {
            transform: rotate(90deg);
            color: var(--accent);
        }

        .acc-children {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }

        .acc-children.open {
            max-height: 600px;
        }

        .acc-child-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 2rem 0.7rem 3rem;
            color: #6b7280;
            font-size: 0.8125rem;
            font-weight: 400;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            border-bottom: 1px solid #f3f4f6;
        }

        .acc-child-btn:hover {
            background: #fafaf9;
            color: var(--primary);
        }

        .acc-child-btn.active {
            background: #fdf7ee;
            color: var(--primary);
            font-weight: 600;
            border-left-color: var(--accent);
        }

        .acc-child-btn.active .category-icon {
            opacity: 1;
            color: var(--accent);
        }

        .acc-child-btn .category-icon { opacity: 0.3; }

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
            aspect-ratio: 2 / 3;
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
            <div class="hero-search-container">
                <div class="search-wrapper">
                    <div class="search-wrapper-inner">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="heroSearchInput" class="search-input" placeholder="Buscar por título, autor, materia o palabra clave..." autocomplete="off">
                    </div>
                    <button class="search-btn" id="heroSearchBtn">Buscar</button>
                </div>
                <div class="hero-search-dropdown" id="heroDropdown"></div>
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
        <div style="max-width:900px; margin:0 auto;">
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
                        <i class="fas fa-barcode"></i>
                        ISBN: <span id="detailRating">N/A</span>
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
        </div><!-- end max-width wrapper -->
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p class="footer-text">© 2024 WARAS - Asociación de Ciencia y Cultura Ancashina</p>
        <p class="footer-subtext">Preservando la memoria cultural de nuestra región</p>
    </footer>

    <script>
        // ========== CATEGORÍAS DINÁMICAS DESDE LARAVEL ==========
        const categoriesFromDatabase = @json($categoriesForFilters ?? []);

        // Flat list of {id, name} objects from DB (parents + children)
        const allDbCategories = [];
        categoriesFromDatabase.forEach(parent => {
            allDbCategories.push({ id: parent.id, name: parent.name });
            (parent.children || []).forEach(child => {
                allDbCategories.push({ id: child.id, name: child.name });
            });
        });

        // categoriesBySection stores arrays of {id, name} objects
        // Books/Revistas use DB categories; others use label-only items (no filtering)
        const categoriesBySection = {
            'Libros':      allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Revistas':    allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Editoriales': [{ id: null, name: 'Todos' }],
            'Especiales':  [{ id: null, name: 'Todos' }],
            'Autores':     [{ id: null, name: 'Todos' }],
            'Aportantes':  [{ id: null, name: 'Todos' }],
        };


        // ========== DATOS DINÁMICOS DESDE LARAVEL ==========
        const booksDataFromServer = @json($booksData ?? []);
        
        // ========== DATOS POR SECCIÓN ==========
        const COVER_COLORS = ['#5c4033','#2d4a6e','#3a5a40','#6b3a2a','#1a3a5c','#4a3a6b'];
        const ICONS = { 'Libro': '📚', 'Revista': '📰', 'Artículo': '📄', 'Tesis': '🎓' };

        function mapBook(book, idx) {
            return {
                id:           book.id,
                title:        book.title,
                author:       book.authors && book.authors.length > 0 ? book.authors[0].name : 'Anónimo',
                authorId:     book.authors && book.authors.length > 0 ? book.authors[0].id : null,
                year:         book.publication_date ? book.publication_date.split('T')[0].split('-')[0] : 'S/F',
                type:         book.document_type || 'Libro',
                description:  book.summary || 'Sin descripción disponible',
                publisher:    book.publisher ? book.publisher.name : 'Sin editorial',
                pages:        book.pages || 'N/A',
                language:     book.language || 'Español',
                isbn:         book.isbn || 'N/A',
                color:        COVER_COLORS[idx % COVER_COLORS.length],
                icon:         ICONS[book.document_type] || '📚',
                cover_url:    book.cover_image_path ? '/storage/' + book.cover_image_path : null,
                source_type:  book.source_type || 'none',
                external_url: book.external_url || '',
                pdf_path:     book.pdf_file_path || '',
                categoryIds:  (book.categories || []).map(c => c.id),
            };
        }

        const dataBySectionAndCategory = {
            'Libros': {
                'default': (booksDataFromServer['Libros'] || []).map((book, idx) => mapBook(book, idx))
            },
            'Revistas': {
                'default': (booksDataFromServer['Revistas'] || []).map((book, idx) => mapBook(book, idx))
            },
            'Editoriales': { 'default': [] },
            'Especiales':  { 'default': [] },
            'Autores': {
                'default': (booksDataFromServer['Autores'] || []).map(author => ({
                    id:          author.id,
                    name:        author.name,
                    biography:   author.biography || 'Sin biografía',
                    nationality: author.nationality || 'Desconocida',
                    photo_url:   author.photo_path ? '/storage/' + author.photo_path : null,
                }))
            },
            'Aportantes': { 'default': [] }
        };

        let state = {
            activeTab: 'Inicio',
            activeCategory: null, // {id, name} or null
            isScrolled: false,
            openAccordion: null  // parent category id that is expanded in sidebar
        };

        // ========== OBTENER DATOS según TAB y CATEGORÍA ==========
        function getDataForSection() {
            const tab = state.activeTab;
            const allItems = dataBySectionAndCategory[tab]?.['default'] || [];

            // For Libros/Revistas filter by category id if one is selected
            if ((tab === 'Libros' || tab === 'Revistas') && state.activeCategory && state.activeCategory.id !== null) {
                const catId = state.activeCategory.id;
                return allItems.filter(item => item.categoryIds && item.categoryIds.includes(catId));
            }
            return allItems;
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
            const useAccordion = (state.activeTab === 'Libros' || state.activeTab === 'Revistas') && categoriesFromDatabase.length > 0;

            if (useAccordion) {
                const allActive = state.activeCategory && state.activeCategory.id === null;
                const todosItem = `<li>
                    <button class="category-btn ${allActive ? 'active' : ''}" data-category-id="" data-category-name="Todos">
                        <span>Todos</span>
                        <i class="fas fa-chevron-right category-icon"></i>
                    </button>
                </li>`;

                // Build accordion: parent rows + collapsible children
                list.innerHTML = todosItem + categoriesFromDatabase.map(parent => {
                    const hasChildren = parent.children && parent.children.length > 0;
                    const isOpen = state.openAccordion === parent.id;
                    const childrenHtml = hasChildren ? parent.children.map(child => {
                        const isActive = state.activeCategory && state.activeCategory.id === child.id;
                        return `<button class="acc-child-btn ${isActive ? 'active' : ''}"
                                    data-category-id="${child.id}"
                                    data-category-name="${child.name}">
                                    <span>${child.name}</span>
                                    <i class="fas fa-chevron-right category-icon" style="font-size:0.65rem;"></i>
                                </button>`;
                    }).join('') : '';

                    return `<li>
                        <button class="acc-parent-btn ${isOpen ? 'open' : ''}" data-parent-id="${parent.id}">
                            <span>${parent.name}</span>
                            <i class="fas fa-chevron-right acc-chevron"></i>
                        </button>
                        ${hasChildren ? `<div class="acc-children ${isOpen ? 'open' : ''}" id="acc-children-${parent.id}">${childrenHtml}</div>` : ''}
                    </li>`;
                }).join('');

                // "Todos" button
                const todosBtn = list.querySelector('.category-btn');
                if (todosBtn) {
                    todosBtn.addEventListener('click', () => {
                        state.activeCategory = { id: null, name: 'Todos' };
                        state.openAccordion = null;
                        document.getElementById('sectionTitle').textContent = state.activeTab;
                        document.getElementById('breadcrumbCategory').textContent = state.activeTab;
                        document.getElementById('contentSearchInput').placeholder = `Buscar en ${state.activeTab}...`;
                        renderCategories();
                        renderBooks();
                    });
                }

                // Parent toggle
                list.querySelectorAll('.acc-parent-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const pid = parseInt(btn.getAttribute('data-parent-id'));
                        if (state.openAccordion === pid) {
                            state.openAccordion = null;
                        } else {
                            state.openAccordion = pid;
                        }
                        renderCategories();
                    });
                });

                // Child select
                list.querySelectorAll('.acc-child-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = parseInt(btn.getAttribute('data-category-id'));
                        const name = btn.getAttribute('data-category-name');
                        // Find which parent owns this child
                        const accChildren = btn.closest('.acc-children');
                        if (accChildren) {
                            const accParentBtn = accChildren.previousElementSibling;
                            if (accParentBtn) state.openAccordion = parseInt(accParentBtn.getAttribute('data-parent-id'));
                        }
                        state.activeCategory = { id, name };
                        document.getElementById('sectionTitle').textContent = name;
                        document.getElementById('breadcrumbCategory').textContent = name;
                        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${name}...`;
                        list.querySelectorAll('.acc-child-btn').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        renderBooks();
                    });
                });

            } else {
                // Flat list for other tabs
                const currentCategories = categoriesBySection[state.activeTab] || categoriesBySection['Libros'];
                list.innerHTML = currentCategories.map(cat => {
                    const isActive = state.activeCategory && state.activeCategory.id === cat.id && state.activeCategory.name === cat.name;
                    return `<li>
                        <button class="category-btn ${isActive ? 'active' : ''}" data-category-id="${cat.id ?? ''}" data-category-name="${cat.name}">
                            <span>${cat.name}</span>
                            <i class="fas fa-chevron-right category-icon"></i>
                        </button>
                    </li>`;
                }).join('');

                list.querySelectorAll('.category-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-category-id');
                        const name = btn.getAttribute('data-category-name');
                        state.activeCategory = { id: id ? parseInt(id) : null, name };
                        document.getElementById('sectionTitle').textContent = name;
                        document.getElementById('breadcrumbCategory').textContent = name;
                        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${name}...`;
                        list.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        renderBooks();
                    });
                });
            }
        }

        function renderBooks() {
            const grid = document.getElementById('booksGrid');
            const items = getDataForSection();
            
            // Actualizar contador de recursos
            document.getElementById('resourceNumber').textContent = items.length;
            
            // Detectar si estamos mostrando autores o libros
            const isAuthorsSection = state.activeTab === 'Autores';
            
            if (isAuthorsSection) {
                // Template para AUTORES
                grid.innerHTML = items.map((item, index) => `
                    <div class="book-card">
                        <div class="book-cover" style="background:linear-gradient(135deg,#2d3436 0%,#636e72 100%);">
                            ${item.photo_url
                                ? `<img src="${item.photo_url}" alt="${item.name}" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" onerror="this.style.display='none'">`
                                : `<i class="fas fa-user" style="font-size:3rem;color:white;opacity:0.6;position:relative;z-index:1;"></i>`}
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${item.name || 'Sin nombre'}</h3>
                            <p class="book-author" style="color:#888; font-size:0.875rem;">${item.nationality || 'Desconocida'}</p>
                            <p class="book-year" style="margin-top:0.4rem; color:#666; font-size:0.8rem; display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${item.biography || 'Sin biografía disponible'}</p>
                            <div class="book-footer">
                                <a href="/biblioteca/autores/${item.id}" class="book-read-link">Más información →</a>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                // Template para LIBROS Y REVISTAS
                grid.innerHTML = items.map((item, index) => `
                    <div class="book-card">
                        <div class="book-cover" style="background:linear-gradient(135deg,${item.color} 0%,${item.color}cc 100%);">
                            <span class="book-badge">${item.type}</span>
                            ${item.cover_url
                                ? `<img src="${item.cover_url}" alt="${item.title}" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
                                : `<span class="book-cover-icon">${item.icon}</span>`}
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
                                <span style="font-size:0.75rem;color:#9ca3af;">${item.pages} págs.</span>
                                <a href="#" class="book-read-link">Leer →</a>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

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
            const detail = document.getElementById('detailView');

            state.activeTab = tab;
            state.openAccordion = null;

            const useAccordion = (tab === 'Libros' || tab === 'Revistas') && categoriesFromDatabase.length > 0;
            if (useAccordion) {
                // Start with no category filter (show all)
                state.activeCategory = { id: null, name: 'Todos' };
            } else {
                const firstCat = (categoriesBySection[tab] || categoriesBySection['Libros'])[0] || { id: null, name: tab };
                state.activeCategory = firstCat;
            }

            const displayName = state.activeCategory.name;

            hero.classList.add('hidden');
            detail.classList.add('hidden');
            main.classList.remove('hidden');

            document.getElementById('sectionTitle').textContent = tab;
            document.getElementById('breadcrumbCategory').textContent = tab;
            document.getElementById('contentSearchInput').placeholder = `Buscar en ${tab}...`;

            renderCategories();
            renderBooks();
            updateNavigation();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function showHero() {
            const hero = document.getElementById('heroSection');
            const main = document.getElementById('mainWrapper');
            const detail = document.getElementById('detailView');

            state.activeTab = 'Inicio';
            state.activeCategory = null;

            detail.classList.add('hidden');
            main.classList.add('hidden');
            hero.classList.remove('hidden');

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
            document.getElementById('detailTitle').textContent    = item.title;
            document.getElementById('detailAuthor').textContent   = item.author;
            document.getElementById('detailYear').textContent     = item.year;
            document.getElementById('detailPages').textContent    = item.pages || 'N/A';
            document.getElementById('detailLanguage').textContent = item.language || 'Español';
            document.getElementById('detailRating').textContent   = item.isbn || 'N/A';
            document.getElementById('detailSynopsis').textContent = item.description;
            document.getElementById('detailPublisher').textContent= item.publisher;
            document.getElementById('breadcrumb-category').textContent = state.activeCategory ? state.activeCategory.name : '';
            document.getElementById('breadcrumb-title').textContent    = item.title;

            // Cover info
            const detailCover = document.getElementById('detailCover');
            detailCover.style.background = item.cover_url
                ? `url('${item.cover_url}') center/cover no-repeat`
                : `linear-gradient(135deg, ${item.color || '#5c4033'} 0%, ${item.color || '#5c4033'}cc 100%)`;
            document.getElementById('detailCoverIcon').textContent = item.cover_url ? '' : item.icon;

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
                    <div class="related-cover" style="background:${item.cover_url ? `url('${item.cover_url}') center/cover no-repeat` : `linear-gradient(135deg,${item.color || '#5c4033'} 0%,${item.color || '#5c4033'}cc 100%)`};">
                        <span class="related-badge">${item.type}</span>
                        ${item.cover_url ? '' : `<span class="related-icon">${item.icon}</span>`}
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
        const initCatName = state.activeCategory ? state.activeCategory.name : '';
        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${initCatName}...`;

        // Abrir sección correcta si se vuelve desde otra página (ej. autor detail)
        const pendingTab = sessionStorage.getItem('biblioteca_tab');
        if (pendingTab) {
            sessionStorage.removeItem('biblioteca_tab');
            const validTabs = ['Libros','Revistas','Editoriales','Especiales','Autores','Aportantes'];
            if (validTabs.includes(pendingTab)) showSection(pendingTab);
        }

        // ========== BÚSQUEDA ==========

        // Fuente de datos plana para búsqueda global
        function getAllSearchableItems() {
            const books   = dataBySectionAndCategory['Libros']['default']   || [];
            const mags    = dataBySectionAndCategory['Revistas']['default'] || [];
            const authors = dataBySectionAndCategory['Autores']['default']  || [];
            return { books, mags, authors };
        }

        function normalizeStr(s) {
            return (s || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }

        // ---- HERO DROPDOWN ----
        const heroInput    = document.getElementById('heroSearchInput');
        const heroDropdown = document.getElementById('heroDropdown');
        const heroBtn      = document.getElementById('heroSearchBtn');

        function renderHeroDropdown(q) {
            if (!q) { heroDropdown.classList.remove('open'); return; }
            const nq = normalizeStr(q);
            const { books, mags, authors } = getAllSearchableItems();

            const matchBooks = books.filter(b =>
                normalizeStr(b.title).includes(nq) ||
                normalizeStr(b.author).includes(nq) ||
                normalizeStr(b.description).includes(nq)
            ).slice(0, 4);

            const matchMags = mags.filter(b =>
                normalizeStr(b.title).includes(nq) ||
                normalizeStr(b.author).includes(nq)
            ).slice(0, 3);

            const matchAuthors = authors.filter(a =>
                normalizeStr(a.name).includes(nq) ||
                normalizeStr(a.nationality).includes(nq) ||
                normalizeStr(a.biography).includes(nq)
            ).slice(0, 3);

            const total = matchBooks.length + matchMags.length + matchAuthors.length;

            if (total === 0) {
                heroDropdown.innerHTML = `<div class="hsd-empty">Sin resultados para "<strong>${q}</strong>"</div>`;
                heroDropdown.classList.add('open');
                return;
            }

            let html = '';

            if (matchBooks.length) {
                html += `<div class="hsd-section-label">Libros</div>`;
                html += matchBooks.map(b => `
                    <div class="hsd-item" data-action="book-detail" data-tab="Libros" data-id="${b.id}">
                        <div class="hsd-thumb" style="background:${b.cover_url ? 'none' : `linear-gradient(135deg,${b.color},${b.color}cc)`};">
                            ${b.cover_url ? `<img src="${b.cover_url}" alt="">` : b.icon}
                        </div>
                        <div class="hsd-info">
                            <div class="hsd-title">${b.title}</div>
                            <div class="hsd-sub">${b.author} · ${b.year}</div>
                        </div>
                        <span class="hsd-badge">Libro</span>
                    </div>`).join('');
            }

            if (matchMags.length) {
                html += `<div class="hsd-section-label">Revistas</div>`;
                html += matchMags.map(b => `
                    <div class="hsd-item" data-action="book-detail" data-tab="Revistas" data-id="${b.id}">
                        <div class="hsd-thumb" style="background:linear-gradient(135deg,${b.color},${b.color}cc);">
                            ${b.cover_url ? `<img src="${b.cover_url}" alt="">` : b.icon}
                        </div>
                        <div class="hsd-info">
                            <div class="hsd-title">${b.title}</div>
                            <div class="hsd-sub">${b.author} · ${b.year}</div>
                        </div>
                        <span class="hsd-badge">Revista</span>
                    </div>`).join('');
            }

            if (matchAuthors.length) {
                html += `<div class="hsd-section-label">Autores</div>`;
                html += matchAuthors.map(a => `
                    <a class="hsd-item" href="/biblioteca/autores/${a.id}">
                        <div class="hsd-thumb">
                            ${a.photo_url ? `<img src="${a.photo_url}" alt="">` : '<i class="fas fa-user" style="color:rgba(255,255,255,0.6);font-size:1rem;"></i>'}
                        </div>
                        <div class="hsd-info">
                            <div class="hsd-title">${a.name}</div>
                            <div class="hsd-sub">${a.nationality}</div>
                        </div>
                        <span class="hsd-badge">Autor</span>
                    </a>`).join('');
            }

            html += `<button class="hsd-all-btn" id="hsdAllBtn">Ver todos los resultados para "${q}" →</button>`;

            heroDropdown.innerHTML = html;
            heroDropdown.classList.add('open');

            // Clic en resultado libro/revista → abrir detalle
            heroDropdown.querySelectorAll('.hsd-item[data-action="book-detail"]').forEach(el => {
                el.addEventListener('click', () => {
                    const tab = el.dataset.tab;
                    const id  = parseInt(el.dataset.id);
                    const allItems = dataBySectionAndCategory[tab]['default'];
                    const item = allItems.find(i => i.id === id);
                    if (!item) return;
                    heroDropdown.classList.remove('open');
                    heroInput.value = '';
                    showSection(tab);
                    showDetailView(item);
                });
            });

            // "Ver todos" → ir a Libros con búsqueda activa
            document.getElementById('hsdAllBtn')?.addEventListener('click', () => {
                heroDropdown.classList.remove('open');
                showSection('Libros');
                const ci = document.getElementById('contentSearchInput');
                ci.value = q;
                ci.dispatchEvent(new Event('input'));
            });
        }

        heroInput.addEventListener('input', () => renderHeroDropdown(heroInput.value.trim()));

        heroBtn.addEventListener('click', () => {
            const q = heroInput.value.trim();
            if (!q) return;
            heroDropdown.classList.remove('open');
            showSection('Libros');
            const ci = document.getElementById('contentSearchInput');
            ci.value = q;
            ci.dispatchEvent(new Event('input'));
        });

        heroInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') heroBtn.click();
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('.hero-search-container')) {
                heroDropdown.classList.remove('open');
            }
        });


        // ---- BÚSQUEDA EN CATÁLOGO (filtra tarjetas visibles) ----
        document.getElementById('contentSearchInput').addEventListener('input', function() {
            const q = normalizeStr(this.value.trim());
            const isAuthors = state.activeTab === 'Autores';

            if (!q) { renderBooks(); return; }

            const baseItems = getDataForSection();

            const filtered = baseItems.filter(item => {
                if (isAuthors) {
                    return normalizeStr(item.name).includes(q) ||
                           normalizeStr(item.nationality).includes(q) ||
                           normalizeStr(item.biography).includes(q);
                }
                return normalizeStr(item.title).includes(q) ||
                       normalizeStr(item.author).includes(q) ||
                       normalizeStr(item.description).includes(q) ||
                       normalizeStr(item.publisher).includes(q) ||
                       normalizeStr(String(item.year)).includes(q);
            });

            // Renderizar resultados filtrados
            const grid = document.getElementById('booksGrid');
            document.getElementById('resourceNumber').textContent = filtered.length;

            if (filtered.length === 0) {
                grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;">
                    <i class="fas fa-search" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>
                    Sin resultados para "<strong style="color:#6b7280;">${this.value.trim()}</strong>"
                </div>`;
                return;
            }

            if (isAuthors) {
                grid.innerHTML = filtered.map(item => `
                    <div class="book-card">
                        <div class="book-cover" style="background:linear-gradient(135deg,#2d3436 0%,#636e72 100%);">
                            ${item.photo_url
                                ? `<img src="${item.photo_url}" alt="${item.name}" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" onerror="this.style.display='none'">`
                                : `<i class="fas fa-user" style="font-size:3rem;color:white;opacity:0.6;position:relative;z-index:1;"></i>`}
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${item.name || 'Sin nombre'}</h3>
                            <p class="book-author" style="color:#888;font-size:0.875rem;">${item.nationality || 'Desconocida'}</p>
                            <p class="book-year" style="margin-top:0.4rem;color:#666;font-size:0.8rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${item.biography || ''}</p>
                            <div class="book-footer">
                                <a href="/biblioteca/autores/${item.id}" class="book-read-link">Más información →</a>
                            </div>
                        </div>
                    </div>`).join('');
            } else {
                grid.innerHTML = filtered.map((item, idx) => `
                    <div class="book-card">
                        <div class="book-cover" style="background:linear-gradient(135deg,${item.color} 0%,${item.color}cc 100%);">
                            <span class="book-badge">${item.type}</span>
                            ${item.cover_url
                                ? `<img src="${item.cover_url}" alt="${item.title}" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
                                : `<span class="book-cover-icon">${item.icon}</span>`}
                            <div class="book-cover-overlay">
                                <button class="book-detail-btn" data-search-idx="${idx}">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </button>
                            </div>
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${item.title}</h3>
                            <p class="book-author">${item.author}</p>
                            <p class="book-year">Publicación: ${item.year}</p>
                            <div class="book-footer">
                                <span style="font-size:0.75rem;color:#9ca3af;">${item.pages} págs.</span>
                                <a href="#" class="book-read-link">Leer →</a>
                            </div>
                        </div>
                    </div>`).join('');

                grid.querySelectorAll('.book-detail-btn').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.preventDefault();
                        const item = filtered[parseInt(btn.dataset.searchIdx)];
                        if (item) showDetailView(item);
                    });
                });
            }
        });
    </script>
</body>
</html>
