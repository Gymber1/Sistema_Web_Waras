<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Digital - WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
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
            overflow-x: hidden;
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

        .header-actions { display: flex; align-items: center; gap: .625rem; margin-left: 1.5rem; }
        /* Hamburger */
        .hamburger-btn { display: none; background: none; border: none; cursor: pointer; color: white; padding: 0.5rem; min-width: 44px; min-height: 44px; align-items: center; justify-content: center; }
        .mobile-nav { display: none; position: fixed; inset: 0; background: rgba(27,42,71,0.98); z-index: 2000; flex-direction: column; align-items: center; justify-content: center; gap: 1.75rem; }
        .mobile-nav.open { display: flex; }
        .mobile-nav-close { position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem; min-width: 44px; min-height: 44px; display: flex; align-items: center; justify-content: center; }
        .mobile-nav-item { color: white; text-decoration: none; font-size: 1.3rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; min-height: 44px; display: flex; align-items: center; }
        .header-btn { display: inline-flex; align-items: center; gap: .4rem; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: .45rem 1rem; border-radius: .375rem; text-decoration: none; transition: all .2s; white-space: nowrap; }
        .header-btn-outline { color: #e2e8f0; border: 1px solid rgba(255,255,255,.25); }
        .header-btn-outline:hover { background: rgba(255,255,255,.1); color: var(--accent); border-color: var(--accent); }
        .header-btn-solid { background: var(--accent); color: var(--primary); border: 1px solid var(--accent); }
        .header-btn-solid:hover { background: #b08d4b; border-color: #b08d4b; }

        @media (max-width: 1024px) {
            .nav-menu { display: none; }
            .header-actions { margin-left: 0; }
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

        /* ── INICIO SECTION ── */
        .inicio-section { background: #f9f8f6; }
        .inicio-section.hidden { display: none !important; }

        /* Contadores */
        .stats-bar {
            background: var(--primary-dark);
            display: grid; grid-template-columns: repeat(5, 1fr);
        }
        .stat-item {
            padding: 2.2rem 1rem; text-align: center;
            border-right: 1px solid rgba(255,255,255,.07);
        }
        .stat-item:last-child { border-right: none; }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem; font-weight: 700; color: var(--accent);
            line-height: 1; display: block;
        }
        .stat-label {
            font-size: .6rem; font-weight: 600; letter-spacing: .18em;
            text-transform: uppercase; color: rgba(255,255,255,.45); margin-top: .45rem; display: block;
        }
        @media(max-width: 768px) {
            .stats-bar { grid-template-columns: repeat(3, 1fr); }
            .stat-item:nth-child(4), .stat-item:nth-child(5) { border-top: 1px solid rgba(255,255,255,.07); }
        }

        /* Carruseles de inicio */
        .inicio-carousel-section { padding: 3.5rem 0; overflow: hidden; position: relative; }
        .inicio-carousel-section + .inicio-carousel-section { border-top: 1px solid #e5e7eb; }
        .inicio-carousel-header {
            max-width: 1400px; margin: 0 auto 2rem; padding: 0 2rem;
            display: flex; align-items: baseline; gap: 1rem;
        }
        .inicio-carousel-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; color: var(--primary);
        }
        .inicio-carousel-count {
            font-size: .75rem; color: #9ca3af; font-weight: 500;
        }
        .inicio-carousel-track-wrap {
            position: relative; overflow: hidden;
            max-width: 1400px; margin: 0 auto; padding: 1rem 2rem 1.5rem;
        }
        .inicio-carousel-track {
            display: flex; align-items: stretch;
            will-change: transform; transition: transform 600ms ease-in-out;
        }

        /* Card de libro (carrusel) */
        .bib-carousel-card {
            flex-shrink: 0; width: 240px; margin: 0 12px;
            background: white; border-radius: 10px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            cursor: pointer; overflow: hidden;
            transform: translateZ(0);
            transition: border-color .25s, box-shadow .25s, transform .25s;
        }
        .bib-carousel-card:hover { border-color: var(--accent); box-shadow: 0 10px 28px rgba(0,0,0,.14); transform: translateY(-3px); }
        .bib-card-cover {
            width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block;
            background: #eee;
        }
        .bib-card-cover-placeholder {
            width: 100%; aspect-ratio: 2/3;
            background: linear-gradient(135deg, var(--primary) 0%, #2d4a6e 100%);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.3); font-size: 3rem;
        }
        .bib-card-body { padding: .85rem 1rem; }
        .bib-card-title {
            font-family: 'Playfair Display', serif;
            font-size: .9rem; color: #111; line-height: 1.35;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .bib-card-sub { font-size: .72rem; color: #9ca3af; margin-top: .35rem;
            display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
        }

        /* Card de autor (carrusel) */
        .bib-author-card {
            flex-shrink: 0; width: 150px; margin: 0 10px;
            background: white; border-radius: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            cursor: pointer; overflow: hidden;
            transform: translateZ(0);
            transition: border-color .25s, box-shadow .25s;
            text-align: center;
        }
        .bib-author-card:hover { border-color: var(--accent); box-shadow: 0 6px 20px rgba(0,0,0,.12); }
        .bib-author-avatar {
            width: 100%; aspect-ratio: 1/1; object-fit: cover; display: block;
            background: #eee;
        }
        .bib-author-placeholder {
            width: 100%; aspect-ratio: 1/1;
            background: linear-gradient(135deg, #2d4a6e 0%, var(--primary) 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; color: rgba(255,255,255,.3);
        }
        .bib-author-body { padding: .65rem .75rem; }
        .bib-author-name {
            font-size: .78rem; font-weight: 600; color: #111;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .bib-author-nat { font-size: .65rem; color: #9ca3af; margin-top: .2rem; }

        /* Controles carrusel */
        .inicio-carousel-controls {
            max-width: 1400px; margin: 1rem auto 0; padding: 0 2rem;
            display: flex; align-items: center; gap: 1rem;
        }
        .carousel-ver-mas {
            max-width: 1400px; margin: 1.25rem auto 0; padding: 0 2rem;
            display: flex; justify-content: center;
        }
        .carousel-ver-mas-btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .6rem 2rem; border-radius: 999px;
            background: transparent; border: 1.5px solid var(--accent);
            color: var(--accent); font-family: inherit; font-size: .82rem;
            font-weight: 600; letter-spacing: .04em; cursor: pointer;
            transition: background .2s, color .2s, transform .15s, box-shadow .2s;
        }
        .carousel-ver-mas-btn:hover {
            background: var(--accent); color: #fff;
            transform: translateY(-1px); box-shadow: 0 6px 18px rgba(197,160,89,.35);
        }
        .ico-btn {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--accent); color: white; border: none;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700;
            transition: background .2s, transform .15s;
            box-shadow: 0 2px 8px rgba(197,160,89,.3);
            flex-shrink: 0;
        }
        .ico-btn:hover { background: var(--accent-hover); transform: scale(1.08); }
        .ico-dots { display: flex; gap: .5rem; align-items: center; }
        .ico-dot {
            height: 7px; border-radius: 4px;
            background: #cbd5e1; cursor: pointer;
            transition: all .35s; width: 7px;
        }
        .ico-dot.active { background: var(--accent); width: 24px; }

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

        /* Descriptor chips */
        .descriptor-chips-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            align-items: center;
        }
        .descriptor-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.8rem;
            background: #f3f4f6;
            border: 1.5px solid #e5e7eb;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .descriptor-chip:hover {
            background: #1b2a47;
            border-color: #1b2a47;
            color: #fff;
        }
        .descriptor-chip.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
        .descriptor-chip .chip-count {
            font-size: 0.7rem;
            opacity: 0.7;
        }
        /* Suggestion dropdown */
        .descriptor-suggestion-item {
            padding: 0.6rem 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.88rem;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.12s;
        }
        .descriptor-suggestion-item:last-child { border-bottom: none; }
        .descriptor-suggestion-item:hover { background: #f9f8f6; }
        .descriptor-suggestion-item .ds-count {
            font-size: 0.75rem;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 0.1rem 0.5rem;
            border-radius: 999px;
        }

        /* Especiales gallery */
        .specials-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            padding: 0.5rem 0 1.5rem;
        }
        .special-card {
            background: #fff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            border: 1px solid #e5e7eb;
            transition: transform 0.18s, box-shadow 0.18s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }
        .special-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(0,0,0,0.12);
        }
        .special-card-cover {
            height: 160px;
            background: linear-gradient(135deg, #1b2a47, #2d4a6e);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .special-card-cover img {
            width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;
        }
        .special-card-type {
            position: absolute;
            top: 0.6rem; right: 0.6rem;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .special-card-body {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .special-card-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: #1b2a47;
            line-height: 1.35;
            margin-bottom: 0.4rem;
        }
        .special-card-count {
            font-size: 0.78rem;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }
        .special-card-btn {
            margin-top: auto;
            display: inline-block;
            padding: 0.45rem 1rem;
            background: var(--primary);
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            text-align: center;
            transition: background 0.15s;
        }
        .special-card-btn:hover { background: var(--accent); color: #fff; }

        /* Main Wrapper */
        .main-wrapper {
            display: flex;
            width: 100%;
            background: var(--bg-light);
            margin-top: 70px;
            min-height: calc(100vh - 70px);
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

        /* Mobile sidebar overlay */
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 200; }
        .sidebar-overlay.open { display: block; }

        /* Full-width layout — sin sidebar (Especiales, Editoriales, Autores) */
        .main-wrapper.no-sidebar .sidebar { display: none !important; }
        .main-wrapper.no-sidebar .sidebar-toggle-btn { display: none !important; }
        .main-wrapper.no-sidebar .content { padding: 2.5rem 4rem; max-width: 1400px; margin: 0 auto; width: 100%; }
        .main-wrapper.no-sidebar .books-grid { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
        @media (max-width: 768px) {
            .main-wrapper.no-sidebar .content { padding: 1.5rem 1rem; }
            .main-wrapper.no-sidebar .books-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; }
        }

        /* Sidebar toggle button (mobile) */
        .sidebar-toggle-btn { display: none; align-items: center; gap: 0.5rem; background: var(--primary); color: white; border: none; padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; width: 100%; }

        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .header-actions { display: none; }
            .hamburger-btn { display: flex; }
            .hero-title { font-size: 2.2rem !important; }
            .main-wrapper { margin-top: 56px; flex-direction: column; }
            .sidebar { display: none; width: 100%; position: fixed; top: 0; left: 0; height: 100vh; z-index: 250; overflow-y: auto; max-height: none; }
            .sidebar.mobile-open { display: block; }
            .sidebar-toggle-btn { display: flex; }
            .content { padding: 1.5rem 1rem; }
            .books-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; }
            .toolbar { flex-direction: column; gap: 0.75rem; align-items: flex-start; }
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
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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
            .books-grid { grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); }
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 1.875rem; }
            .search-wrapper { flex-direction: column; gap: 0.5rem; }
            .search-btn { width: 100%; }
            .books-grid { grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); }
        }
    </style>
</head>
<body>
    <!-- Mobile nav overlay -->
    <div class="mobile-nav" id="mobileNav">
        <button class="mobile-nav-close" onclick="closeMobileNav()"><i class="fas fa-times"></i></button>
        <a href="{{ route('biblioteca.inicio') }}" class="mobile-nav-item">Inicio</a>
        <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item">Biblioteca Digital</a>
        <a href="{{ route('biblioteca.editorial.index') }}" class="mobile-nav-item">Waras Editorial</a>
        <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item">Revistas</a>
        <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item">Autores</a>
        <a href="{{ route('biblioteca.especiales.index') }}" class="mobile-nav-item">Especiales</a>
        <a href="{{ route('home') }}" class="mobile-nav-item" style="font-size:1rem;opacity:0.6">Portal Principal</a>
    </div>

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
                <a href="{{ route('biblioteca.inicio') }}" data-tab="Inicio" class="nav-item">Inicio</a>
                <a href="{{ route('biblioteca.libros.index') }}" data-tab="Libros" class="nav-item">Biblioteca Digital</a>
                <a href="{{ route('biblioteca.editorial.index') }}" data-tab="Waras Editorial" class="nav-item">Waras Editorial</a>
                <a href="{{ route('biblioteca.revistas.index') }}" data-tab="Revistas" class="nav-item">Revistas</a>
                <a href="{{ route('biblioteca.autores.index') }}" data-tab="Autores" class="nav-item">Autores</a>
                <a href="{{ route('biblioteca.especiales.index') }}" data-tab="Especiales" class="nav-item">Especiales</a>
            </nav>
            <div class="header-actions">
                <a href="{{ route('home') }}" class="header-btn header-btn-outline">
                    <i class="fas fa-home"></i> Portal Principal
                </a>
                @auth
                    @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
                    <a href="{{ route('admin.dashboard') }}" class="header-btn header-btn-solid">
                        <i class="fas fa-th-large"></i> Panel
                    </a>
                    @endif
                @endauth
            </div>
            <button class="hamburger-btn" onclick="openMobileNav()" aria-label="Abrir menú">
                <i class="fas fa-bars" style="font-size:1.3rem"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="heroSection" style="background: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)), url('{{ $heroBg ?? 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}') center/cover no-repeat; background-attachment: fixed;">
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

    <!-- INICIO SECTION -->
    <div class="inicio-section hidden" id="inicioSection">

        <!-- Contadores -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-num" id="statLibros">{{ $booksData['Libros'] ? count($booksData['Libros']) : 0 }}</span>
                <span class="stat-label">Libros</span>
            </div>
            <div class="stat-item">
                <span class="stat-num" id="statRevistas">{{ $booksData['Revistas'] ? count($booksData['Revistas']) : 0 }}</span>
                <span class="stat-label">Revistas</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $totalAuthors }}</span>
                <span class="stat-label">Autores</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $totalPublishers }}</span>
                <span class="stat-label">Editoriales</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $booksData['Especiales'] ? count($booksData['Especiales']) : 0 }}</span>
                <span class="stat-label">Especiales</span>
            </div>
        </div>

        <!-- Carrusel: Libros -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Libros</h2>
                <span class="inicio-carousel-count">{{ count($booksData['Libros']) }} títulos</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackLibros"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveCarousel('libros',-1)">‹</button>
                <div class="ico-dots" id="dotsLibros"></div>
                <button class="ico-btn" onclick="moveCarousel('libros',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Libros')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Carrusel: Autores -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Autores</h2>
                <span class="inicio-carousel-count">{{ $totalAuthors }} registrados</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackAutores"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveCarousel('autores',-1)">‹</button>
                <div class="ico-dots" id="dotsAutores"></div>
                <button class="ico-btn" onclick="moveCarousel('autores',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Autores')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Carrusel: Revistas -->
        <div class="inicio-carousel-section" style="padding-bottom:4rem;">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Revistas</h2>
                <span class="inicio-carousel-count">{{ count($booksData['Revistas']) }} títulos</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackRevistas"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveCarousel('revistas',-1)">‹</button>
                <div class="ico-dots" id="dotsRevistas"></div>
                <button class="ico-btn" onclick="moveCarousel('revistas',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Revistas')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

    </div>

    <!-- Mobile sidebar overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <!-- Main Content -->
    <div class="main-wrapper hidden" id="mainWrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="mobileSidebar">
            <div class="sidebar-header" style="justify-content:space-between">
                <div style="display:flex;align-items:center;gap:0.75rem">
                    <i class="fas fa-filter"></i>
                    <span class="sidebar-title">Explorar Catálogo</span>
                </div>
                <button onclick="closeMobileSidebar()" id="sidebarCloseBtn" style="background:none;border:none;color:white;font-size:1.25rem;cursor:pointer;display:none;padding:0"><i class="fas fa-times"></i></button>
            </div>

            <div class="categories-section">
                <div class="categories-label">Materias</div>
                <ul class="categories-list" id="categoriesList"></ul>
            </div>

        </aside>

        <!-- Content Area -->
        <main class="content">
            <button class="sidebar-toggle-btn" onclick="openMobileSidebar()"><i class="fas fa-filter"></i>&nbsp; Filtrar por materia</button>
            <div class="breadcrumbs">
                <a id="breadcrumbHome">Catálogo</a>
                <span class="separator">›</span>
                <span class="current" id="breadcrumbCategory">Historia Y Geografía</span>
            </div>

            <!-- Search Box -->
            <div class="content-search" style="position:relative;">
                <i class="fas fa-search content-search-icon"></i>
                <input type="text" class="content-search-input" id="contentSearchInput" placeholder="Buscar libros, autores o temas en Historia Y Geografía..." autocomplete="off">
                <div id="descriptorSuggestions" style="display:none;position:absolute;top:100%;left:0;right:0;z-index:200;background:#fff;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px;box-shadow:0 8px 24px rgba(0,0,0,0.1);max-height:220px;overflow-y:auto;"></div>
            </div>

            <!-- Descriptor chips (filtros rápidos) -->
            <div id="descriptorChipsBar" style="display:none;margin:0.75rem 0 0.25rem;"></div>

            <div class="section-header">
                <h2 class="section-title" id="sectionTitle">Historia Y Geografía</h2>
                <p class="section-subtitle">Mostrando resultados del catálogo digital.</p>
            </div>

            <div class="toolbar">
                <span class="results-count" id="resourceCount"><strong id="resourceNumber">0</strong> recursos encontrados</span>
                <div class="sort-controls">
                    <i class="fas fa-sliders-h" style="color: #9ca3af;"></i>
                    <span>Ordenar por:</span>
                    <select class="sort-select" id="sortSelect">
                        <option value="az">Ordenar A-Z</option>
                        <option value="recent">Más recientes</option>
                        <option value="old">Más antiguos</option>
                        <option value="year_asc">Por año ↑</option>
                        <option value="year_desc">Por año ↓</option>
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
                    <a id="btnLeerLinea" href="#" target="_blank" rel="noopener"
                       class="detail-btn detail-btn-primary" style="text-decoration:none;">
                        <i class="fas fa-book-open"></i> Leer en línea
                    </a>
                    <button id="btnCompartir" class="detail-btn detail-btn-icon" title="Copiar enlace">
                        <i class="fas fa-share-alt"></i>
                    </button>
                </div>
                <div id="shareToast" style="display:none;margin-top:0.75rem;font-size:0.8rem;color:#6b7280;text-align:center;">
                    ✓ Enlace copiado al portapapeles
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

    <!-- ===== SECCIÓN NOSOTROS / APORTANTES (eliminada del nav) ===== -->
    <div id="aportantesSection" style="display:none;background:#f1f5f9;margin-top:72px;padding:0 0 4rem;">

        <!-- Hero Banner -->
        <div style="background:var(--primary);color:white;padding:5rem 2rem;text-align:center;position:relative;overflow:hidden;">
            <div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=2000&q=30') center/cover;opacity:.08;"></div>
            <div style="position:absolute;inset:0;background:linear-gradient(to bottom,rgba(27,42,71,.8),rgba(27,42,71,1));"></div>
            <div style="position:relative;z-index:1;max-width:800px;margin:0 auto;display:flex;flex-direction:column;align-items:center;">
                <div style="display:flex;align-items:flex-end;gap:.35rem;margin-bottom:1.5rem;">
                    <div style="width:8px;height:18px;background:#60a5fa;border-radius:2px;"></div>
                    <div style="width:8px;height:24px;background:#f87171;border-radius:2px;"></div>
                    <div style="width:8px;height:13px;background:var(--accent);border-radius:2px;"></div>
                </div>
                <h1 style="font-family:'Playfair Display',serif;font-size:2.75rem;font-weight:800;margin-bottom:.75rem;">Aportantes y Aliados</h1>
                <p style="font-size:.75rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:1.5rem;">Red de Colaboración Cultural</p>
                <p style="font-size:1rem;font-weight:300;color:rgba(255,255,255,.8);line-height:1.85;max-width:620px;">
                    Un grupo de ciudadanos, empresas e instituciones comprometidos con el desarrollo económico, social, científico y cultural, que hacen posible la preservación de nuestro legado.
                </p>
            </div>
        </div>

        <!-- Contenido principal -->
        <div style="max-width:1400px;margin:-2.5rem auto 0;padding:0 2rem 3rem;position:relative;z-index:10;">
            <div style="background:white;border-radius:1rem;box-shadow:0 8px 30px rgba(0,0,0,.08);border:1px solid #e2e8f0;padding:2.5rem 3.5rem;">

                <div style="display:grid;grid-template-columns:1fr minmax(0,380px);gap:3.5rem;align-items:start;">

                    <!-- Columna izquierda: aportantes -->
                    <div>
                        <!-- Título sección -->
                        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:2rem;padding-bottom:1rem;border-bottom:1px solid #e5e7eb;">
                            <div style="background:var(--primary);padding:.5rem;border-radius:.4rem;line-height:0;">
                                <svg width="22" height="22" fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            </div>
                            <h3 style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--primary);">Nuestros Aportantes</h3>
                        </div>

                        <!-- Categoría: Empresas Auspiciadoras -->
                        <div style="margin-bottom:2.5rem;">
                            <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:1.25rem;padding-bottom:.6rem;border-bottom:2px solid #f1f5f9;">
                                <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <h4 style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#1e293b;">Empresas Auspiciadoras</h4>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.875rem;">
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=200&q=80" alt="Minera Antamina" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Minera Antamina S.A.</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Auspiciador Platino. Su apoyo financiero ha sido fundamental para mantener nuestra infraestructura tecnológica y adquirir los servidores principales de la plataforma.</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Constructora Andes" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Constructora Andes EIRL</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Aportes directos para la viabilidad, contratación del equipo de digitalización inicial y adquisición de escáneres planetarios.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categoría: Donantes de Colecciones -->
                        <div style="margin-bottom:2.5rem;">
                            <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:1.25rem;padding-bottom:.6rem;border-bottom:2px solid #f1f5f9;">
                                <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                <h4 style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#1e293b;">Donantes de Colecciones y Libros</h4>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.875rem;">
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=200&q=80" alt="Familia Alba" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Familia Alba</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Cedieron temporalmente su invaluable colección privada de Historia Ancashina, permitiendo la digitalización de más de 120 volúmenes únicos.</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=200&q=80" alt="Dr. Carlos Ramirez" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Dr. Carlos Ramirez</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Aportó de forma desinteresada su hemeroteca completa de revistas literarias y recortes periodísticos publicados entre 1950 y 1980.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categoría: Instituciones Aliadas -->
                        <div>
                            <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:1.25rem;padding-bottom:.6rem;border-bottom:2px solid #f1f5f9;">
                                <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="22" x2="21" y2="22"/><line x1="6" y1="18" x2="6" y2="11"/><line x1="10" y1="18" x2="10" y2="11"/><line x1="14" y1="18" x2="14" y2="11"/><line x1="18" y1="18" x2="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg>
                                <h4 style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#1e293b;">Instituciones Aliadas</h4>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.875rem;">
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=200&q=80" alt="UNASAM" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Universidad Nacional Santiago Antúnez de Mayolo (UNASAM)</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Brinda soporte académico, valida la veracidad de los documentos históricos y facilita la participación de estudiantes voluntarios.</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:1.25rem;background:white;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.09)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
                                    <img src="https://images.unsplash.com/photo-1568667256549-094345857637?auto=format&fit=crop&w=200&q=80" alt="Biblioteca Pública Municipal de Huaraz" loading="lazy" style="width:112px;height:112px;object-fit:cover;border-radius:.5rem;flex-shrink:0;border:1px solid #e5e7eb;">
                                    <div style="display:flex;flex-direction:column;justify-content:center;">
                                        <h5 style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;">Biblioteca Pública Municipal de Huaraz</h5>
                                        <p style="font-size:.875rem;color:#475569;line-height:1.7;">Aliado estratégico en el rescate de la identidad. Fueron los primeros en acoger la idea de fortalecer el patrimonio digital ancashino.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna derecha: Director -->
                    <div>
                        <!-- Título Director -->
                        <div style="display:flex;align-items:center;margin-bottom:1.75rem;padding-top:.25rem;">
                            <h4 style="font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:600;color:var(--primary);white-space:nowrap;">Director</h4>
                            <div style="margin-left:1rem;height:1px;flex:1;background:#e2e8f0;position:relative;">
                                <div style="position:absolute;left:0;top:0;height:100%;width:3rem;background:var(--accent);"></div>
                            </div>
                        </div>

                        <!-- Tarjeta director -->
                        <div style="background:#f8fafc;border-radius:.75rem;border:1px solid #e5e7eb;padding:2rem;display:flex;flex-direction:column;align-items:center;text-align:center;">
                            <!-- Foto circular -->
                            <div style="position:relative;width:160px;height:160px;margin-bottom:1.5rem;">
                                <div style="position:absolute;inset:0;border-radius:50%;border:4px solid #e2e8f0;"></div>
                                <div style="position:absolute;inset:-4px;border-radius:50%;border:1px solid var(--accent);opacity:.5;"></div>
                                <img src="/giber.png" alt="Giber Garcia Alamo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;padding:4px;">
                            </div>
                            <!-- Datos -->
                            <h5 style="font-size:.9rem;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.35rem;">Giber Garcia Alamo</h5>
                            <p style="font-family:'Playfair Display',serif;font-style:italic;font-size:1rem;color:var(--accent);margin-bottom:1rem;">Bibliotecólogo</p>
                            <p style="font-size:.82rem;color:#64748b;line-height:1.75;margin-bottom:1.5rem;">
                                Promotor inicial de la recopilación histórica. Asumió la dirección para rescatar, catalogar y promover la Identidad Ancashina a través de esta plataforma digital.
                            </p>
                            <button style="padding:.55rem 1.5rem;background:white;border:1.5px solid var(--primary);color:var(--primary);font-size:.8rem;font-weight:700;border-radius:.375rem;cursor:pointer;transition:all .2s;font-family:inherit;"
                                onmouseover="this.style.background='var(--primary)';this.style.color='white'"
                                onmouseout="this.style.background='white';this.style.color='var(--primary)'">
                                Ver Perfil Completo
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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
            'Libros':          allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Revistas':        allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Waras Editorial': allDbCategories.length ? allDbCategories : [{ id: null, name: 'Todos' }],
            'Especiales':      [{ id: null, name: 'Todos' }],
            'Autores':         [{ id: null, name: 'Todos' }],
        };


        // ========== DATOS DINÁMICOS DESDE LARAVEL ==========
        const booksDataFromServer = @json($booksData ?? []);
        const topDescriptorsData  = @json($topDescriptors ?? []);
        
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
                categoryIds:    (book.categories  || []).map(c => c.id),
                descriptorIds:  (book.descriptors || []).map(d => d.id),
                descriptorNames:(book.descriptors || []).map(d => d.name),
                detail_url:   book.document_type === 'Revista'
                                ? '/biblioteca/revistas/' + book.id
                                : '/biblioteca/libros/' + book.id,
                read_url:     book.source_type === 'external' && book.external_url
                                ? book.external_url
                                : (book.source_type === 'pdf' && book.pdf_file_path
                                    ? '/storage/' + book.pdf_file_path
                                    : null),
            };
        }

        const dataBySectionAndCategory = {
            'Libros': {
                'default': (booksDataFromServer['Libros'] || []).map((book, idx) => mapBook(book, idx))
            },
            'Revistas': {
                'default': (booksDataFromServer['Revistas'] || []).map((book, idx) => mapBook(book, idx))
            },
            'Especiales': {
                'default': (booksDataFromServer['Especiales'] || []).map(s => ({
                    id:          s.id,
                    title:       s.title,
                    type:        s.type,
                    cover_url:   s.cover_image_path ? '/storage/' + s.cover_image_path : null,
                    books_count: s.books_count ?? (s.books ? s.books.length : 0),
                    slug:        s.slug || '',
                }))
            },
            'Waras Editorial': { 'default': (booksDataFromServer['Waras Editorial'] || []).map((book, idx) => mapBook(book, idx)) },
            'Autores': {
                'default': (booksDataFromServer['Autores'] || []).map(author => ({
                    id:          author.id,
                    name:        author.name,
                    biography:   author.biography || 'Sin biografía',
                    nationality: author.nationality || 'Desconocida',
                    photo_url:   author.photo_path ? '/storage/' + author.photo_path : null,
                }))
            },
        };

        const serverActiveSection = @json($activeSection ?? 'Inicio');

        let activeDescriptorId = null;

        let state = {
            activeTab: 'Inicio',
            activeCategory: null, // {id, name} or null
            isScrolled: false,
            openAccordions:   new Set(),  // ids abiertos manualmente
            closedAccordions: new Set()   // ids cerrados manualmente (tienen prioridad sobre ancestro activo)
        };

        // ========== OBTENER DATOS según TAB y CATEGORÍA ==========
        function getDataForSection() {
            const tab = state.activeTab;
            const allItems = dataBySectionAndCategory[tab]?.['default'] || [];

            // For Libros/Revistas filter by category id if one is selected
            if (['Libros', 'Revistas', 'Waras Editorial'].includes(tab) && state.activeCategory && state.activeCategory.id !== null) {
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

        // Recursivo: construye HTML de un nodo del árbol de categorías (Biblioteca)
        function buildCatNodeHtml(node, depth) {
            const hasChildren = node.children && node.children.length > 0;
            const manuallyClosed = state.closedAccordions.has(node.id);
            const isOpen = !manuallyClosed && (
                state.openAccordions.has(node.id) ||
                bibIsAncestorOfActive(node, state.activeCategory ? state.activeCategory.id : null)
            );
            const isActive = state.activeCategory && state.activeCategory.id === node.id;
            const pl = `${1.5 + depth * 0.875}rem`;

            if (hasChildren) {
                const childrenHtml = node.children.map(c => buildCatNodeHtml(c, depth + 1)).join('');
                return `<li>
                    <button class="acc-parent-btn ${isOpen ? 'open' : ''}"
                            data-parent-id="${node.id}" style="padding-left:${pl};">
                        <span>${node.name}</span>
                        <i class="fas fa-chevron-right acc-chevron"></i>
                    </button>
                    <div class="acc-children ${isOpen ? 'open' : ''}">
                        <ul style="list-style:none;padding:0;margin:0;">${childrenHtml}</ul>
                    </div>
                </li>`;
            } else {
                return `<li>
                    <button class="acc-child-btn ${isActive ? 'active' : ''}"
                            data-category-id="${node.id}" data-category-name="${node.name}"
                            style="padding-left:${pl};">
                        <span>${node.name}</span>
                        <i class="fas fa-chevron-right category-icon" style="font-size:0.65rem;"></i>
                    </button>
                </li>`;
            }
        }

        function bibIsAncestorOfActive(node, activeId) {
            if (!activeId || !node.children) return false;
            for (const child of node.children) {
                if (child.id === activeId) return true;
                if (bibIsAncestorOfActive(child, activeId)) return true;
            }
            return false;
        }

        function renderCategories() {
            const list = document.getElementById('categoriesList');
            const useAccordion = ['Libros', 'Revistas', 'Waras Editorial'].includes(state.activeTab) && categoriesFromDatabase.length > 0;

            if (useAccordion) {
                const allActive = state.activeCategory && state.activeCategory.id === null;
                const todosItem = `<li>
                    <button class="category-btn ${allActive ? 'active' : ''}" data-category-id="" data-category-name="Todos">
                        <span>Todos</span>
                        <i class="fas fa-chevron-right category-icon"></i>
                    </button>
                </li>`;

                list.innerHTML = todosItem + categoriesFromDatabase.map(node => buildCatNodeHtml(node, 0)).join('');

                // "Todos" button
                const todosBtn = list.querySelector('.category-btn');
                if (todosBtn) {
                    todosBtn.addEventListener('click', () => {
                        state.activeCategory = { id: null, name: 'Todos' };
                        state.openAccordions.clear();
                        state.closedAccordions.clear();
                        document.getElementById('sectionTitle').textContent = state.activeTab;
                        document.getElementById('breadcrumbCategory').textContent = state.activeTab;
                        document.getElementById('contentSearchInput').placeholder = `Buscar en ${state.activeTab}...`;
                        renderCategories();
                        renderBooks();
                        closeMobileSidebar();
                    });
                }

                // Parent toggle (cualquier profundidad) — Set-based para multinivel
                list.querySelectorAll('.acc-parent-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const pid = parseInt(btn.getAttribute('data-parent-id'));
                        const isCurrentlyOpen = btn.classList.contains('open');
                        if (isCurrentlyOpen) {
                            state.openAccordions.delete(pid);
                            state.closedAccordions.add(pid);
                        } else {
                            state.closedAccordions.delete(pid);
                            state.openAccordions.add(pid);
                        }
                        renderCategories();
                    });
                });

                // Leaf select (cualquier profundidad)
                list.querySelectorAll('.acc-child-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id   = parseInt(btn.getAttribute('data-category-id'));
                        const name = btn.getAttribute('data-category-name');
                        state.activeCategory = { id, name };
                        document.getElementById('sectionTitle').textContent = name;
                        document.getElementById('breadcrumbCategory').textContent = name;
                        document.getElementById('contentSearchInput').placeholder = `Buscar libros, autores o temas en ${name}...`;
                        renderCategories();
                        renderBooks();
                        closeMobileSidebar();
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
                        closeMobileSidebar();
                    });
                });
            }
        }

        function getSortedItems(items) {
            const sortVal = document.getElementById('sortSelect')?.value ?? 'az';
            const arr = [...items];
            if (sortVal === 'az') {
                arr.sort((a, b) => (a.title || a.name || '').localeCompare(b.title || b.name || '', 'es'));
            } else if (sortVal === 'recent') {
                arr.sort((a, b) => (parseInt(b.year) || 0) - (parseInt(a.year) || 0));
            } else if (sortVal === 'old') {
                arr.sort((a, b) => (parseInt(a.year) || 9999) - (parseInt(b.year) || 9999));
            } else if (sortVal === 'year_asc') {
                arr.sort((a, b) => (parseInt(a.year) || 0) - (parseInt(b.year) || 0));
            } else if (sortVal === 'year_desc') {
                arr.sort((a, b) => (parseInt(b.year) || 0) - (parseInt(a.year) || 0));
            }
            return arr;
        }

        function renderBooks() {
            const grid = document.getElementById('booksGrid');
            const items = getSortedItems(getDataForSection());

            // Actualizar contador de recursos
            document.getElementById('resourceNumber').textContent = items.length;

            // Detectar tipo de sección
            const isAuthorsSection     = state.activeTab === 'Autores';
            const isEditorialesSection = false;
            const isEspecialesSection  = state.activeTab === 'Especiales';

            // Gestionar visibilidad de descriptor chips
            const chipsBar = document.getElementById('descriptorChipsBar');
            const hasDescriptors = ['Libros','Revistas','Waras Editorial'].includes(state.activeTab);
            if (hasDescriptors && topDescriptorsData.length > 0) {
                chipsBar.style.display = 'block';
                renderDescriptorChips();
            } else {
                chipsBar.style.display = 'none';
            }

            // ESPECIALES → galería de colecciones
            if (isEspecialesSection) {
                document.getElementById('resourceNumber').textContent = items.length;
                if (items.length === 0) {
                    grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;"><i class="fas fa-star" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>No hay colecciones especiales disponibles.</div>`;
                    return;
                }
                // Reemplazar grid con layout de galería
                grid.className = 'specials-gallery';
                grid.innerHTML = items.map(s => {
                    const isRev = s.type === 'revista';
                    const label = isRev ? 'Revistas' : 'Libros';
                    const count = s.books_count;
                    const countLabel = count + ' ' + (isRev ? (count === 1 ? 'revista' : 'revistas') : (count === 1 ? 'libro' : 'libros'));
                    const typeColor = isRev ? 'background:#2563eb;color:#fff' : 'background:#059669;color:#fff';
                    const coverHtml = s.cover_url
                        ? `<img src="${s.cover_url}" alt="${s.title}" onerror="this.style.display='none'">`
                        : `<i class="fas fa-star" style="font-size:2.5rem;color:rgba(255,255,255,0.3);position:relative;z-index:1;"></i>`;
                    return `
                    <div class="special-card">
                        <div class="special-card-cover">
                            ${coverHtml}
                            <span class="special-card-type" style="${typeColor}">${label}</span>
                        </div>
                        <div class="special-card-body">
                            <div class="special-card-title">${s.title}</div>
                            <div class="special-card-count"><i class="fas fa-book" style="margin-right:0.3rem;opacity:0.5;"></i>${countLabel} asignados</div>
                            <a href="/biblioteca/especiales/${s.id}" class="special-card-btn">Ver colección →</a>
                        </div>
                    </div>`;
                }).join('');
                return;
            }

            // Restaurar grid normal si veníamos de especiales
            grid.className = 'books-grid';

            if (isAuthorsSection) {
                // Template para AUTORES
                grid.innerHTML = items.map((item, index) => `
                    <div class="book-card">
                        <div class="book-cover" style="background:linear-gradient(135deg,#2d3436 0%,#636e72 100%);">
                            ${item.photo_url
                                ? `<img src="${item.photo_url}" alt="${item.name}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" onerror="this.style.display='none'">`
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
                                ? `<img src="${item.cover_url}" alt="${item.title}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
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
                                ${item.read_url
                                    ? `<a href="${item.read_url}" target="_blank" rel="noopener" class="book-read-link">Leer →</a>`
                                    : `<span class="book-read-link" style="opacity:0.35;cursor:default;">Sin acceso</span>`}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Agregar event listeners a los botones
            document.querySelectorAll('.book-detail-btn').forEach((btn, index) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    closeMobileSidebar();
                    const item = items[index];
                    showDetailView(item);
                });
            });
        }

        function hideAllSections() {
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('inicioSection').classList.add('hidden');
            document.getElementById('mainWrapper').classList.add('hidden');
            document.getElementById('detailView').classList.add('hidden');
        }

        function showSection(tab) {
            state.activeTab = tab;
            state.openAccordions.clear();
            state.closedAccordions.clear();

            hideAllSections();

            const useAccordion = ['Libros', 'Revistas', 'Waras Editorial'].includes(tab) && categoriesFromDatabase.length > 0;
            if (useAccordion) {
                state.activeCategory = { id: null, name: 'Todos' };
            } else {
                const firstCat = (categoriesBySection[tab] || categoriesBySection['Libros'])[0] || { id: null, name: tab };
                state.activeCategory = firstCat;
            }

            const TABS_NO_SIDEBAR = new Set(['Especiales', 'Autores']);
            const wrapper = document.getElementById('mainWrapper');
            wrapper.classList.remove('hidden');
            wrapper.classList.toggle('no-sidebar', TABS_NO_SIDEBAR.has(tab));
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
            state.activeTab = 'Inicio';
            state.activeCategory = null;

            hideAllSections();
            document.getElementById('heroSection').classList.remove('hidden');
            document.getElementById('inicioSection').classList.remove('hidden');

            updateNavigation();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            window.dispatchEvent(new Event('scroll'));
        }

        function updateNavigation() {
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.toggle('active', item.getAttribute('data-tab') === state.activeTab);
            });
            // Update browser URL without reload (history state)
            const tabUrlMap = {
                'Inicio':          '{{ route('biblioteca.dashboard') }}',
                'Libros':          '{{ route('biblioteca.libros.index') }}',
                'Revistas':        '{{ route('biblioteca.revistas.index') }}',
                'Waras Editorial': '{{ route('biblioteca.editorial.index') }}',
                'Especiales':      '{{ route('biblioteca.especiales.index') }}',
                'Autores':         '{{ route('biblioteca.autores.index') }}',
            };
            if (tabUrlMap[state.activeTab]) {
                history.replaceState(null, '', tabUrlMap[state.activeTab]);
            }
        }

        document.getElementById('logoBtn').addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = '{{ route('biblioteca.dashboard') }}';
        });
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = btn.getAttribute('href');
            });
        });

        // ========== FUNCIONES PARA VISTA DE DETALLE ==========
        let currentMaterial = null;

        function showDetailView(item) {
            if (item.detail_url) {
                sessionStorage.setItem('biblioteca_tab', state.activeTab);
                window.location.href = item.detail_url;
                return;
            }
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

            // Botón "Leer en línea"
            const btnLeer = document.getElementById('btnLeerLinea');
            if (item.source_type === 'external' && item.external_url) {
                btnLeer.href = item.external_url;
                btnLeer.style.display = '';
                btnLeer.style.opacity = '1';
                btnLeer.style.pointerEvents = '';
            } else if (item.source_type === 'pdf' && item.pdf_path) {
                btnLeer.href = '/storage/' + item.pdf_path;
                btnLeer.style.display = '';
                btnLeer.style.opacity = '1';
                btnLeer.style.pointerEvents = '';
            } else {
                btnLeer.href = '#';
                btnLeer.style.opacity = '0.4';
                btnLeer.style.pointerEvents = 'none';
            }

            // Botón compartir — copia URL con hash para identificar el libro
            const btnCompartir = document.getElementById('btnCompartir');
            const shareToast   = document.getElementById('shareToast');
            btnCompartir.onclick = () => {
                const shareUrl = window.location.origin + window.location.pathname + '?libro=' + item.id;
                navigator.clipboard.writeText(shareUrl).then(() => {
                    shareToast.style.display = 'block';
                    setTimeout(() => { shareToast.style.display = 'none'; }, 2500);
                }).catch(() => {
                    // Fallback para navegadores sin clipboard API
                    const ta = document.createElement('textarea');
                    ta.value = shareUrl;
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                    shareToast.style.display = 'block';
                    setTimeout(() => { shareToast.style.display = 'none'; }, 2500);
                });
            };

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

        // Activar sección según la ruta visitada (definida por el servidor)
        const validTabs = ['Inicio','Libros','Revistas','Waras Editorial','Especiales','Autores'];

        // serverActiveSection tiene prioridad cuando la URL apunta a una sección concreta.
        // sessionStorage solo aplica cuando se llega al dashboard raíz (/biblioteca o /biblioteca/inicio).
        const sectionTab = validTabs.includes(serverActiveSection) ? serverActiveSection : 'Inicio';
        if (sectionTab !== 'Inicio') {
            sessionStorage.removeItem('biblioteca_tab');
            showSection(sectionTab);
        } else {
            const pendingTab = sessionStorage.getItem('biblioteca_tab');
            if (pendingTab && validTabs.includes(pendingTab)) {
                sessionStorage.removeItem('biblioteca_tab');
                if (pendingTab === 'Inicio') showHero(); else showSection(pendingTab);
            } else {
                showHero();
            }
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
                    closeMobileSidebar();
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
            closeMobileSidebar();
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


        // ========== DESCRIPTOR CHIPS ==========

        function renderDescriptorChips() {
            const bar = document.getElementById('descriptorChipsBar');
            const chips = topDescriptorsData.map(d => {
                const isActive = activeDescriptorId === d.id;
                return `<button class="descriptor-chip${isActive ? ' active' : ''}" data-id="${d.id}" data-name="${d.name}" onclick="toggleDescriptorChip(${d.id}, '${d.name.replace(/'/g,"\\'")}')">
                    ${d.name} <span class="chip-count">${d.books_count}</span>
                </button>`;
            }).join('');
            bar.innerHTML = `<div class="descriptor-chips-wrap">${chips}</div>`;
        }

        function toggleDescriptorChip(id, name) {
            if (activeDescriptorId === id) {
                activeDescriptorId = null;
                document.getElementById('contentSearchInput').value = '';
                renderBooks();
            } else {
                activeDescriptorId = id;
                document.getElementById('contentSearchInput').value = name;
                filterByDescriptor(id);
            }
            renderDescriptorChips();
        }

        function filterByDescriptor(descriptorId) {
            const tab = state.activeTab;
            const allItems = dataBySectionAndCategory[tab]?.['default'] || [];
            // Filtrar usando el campo descriptorIds que agregaremos en mapBook
            const filtered = allItems.filter(item =>
                item.descriptorIds && item.descriptorIds.includes(descriptorId)
            );
            const grid = document.getElementById('booksGrid');
            grid.className = 'books-grid';
            document.getElementById('resourceNumber').textContent = filtered.length;
            if (filtered.length === 0) {
                grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;">
                    <i class="fas fa-tag" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>
                    Sin resultados para el descriptor "<strong style="color:#6b7280;">${document.getElementById('contentSearchInput').value}</strong>"
                </div>`;
                return;
            }
            // Reusar render de libros estándar
            renderBookItems(grid, filtered);
        }

        function renderBookItems(grid, items) {
            grid.innerHTML = items.map((item, index) => `
                <div class="book-card">
                    <div class="book-cover" style="background:linear-gradient(135deg,${item.color} 0%,${item.color}cc 100%);">
                        <span class="book-badge">${item.type}</span>
                        ${item.cover_url
                            ? `<img src="${item.cover_url}" alt="${item.title}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
                            : `<span class="book-cover-icon">${item.icon}</span>`}
                        <div class="book-cover-overlay">
                            <button class="book-detail-btn" data-item-idx="${index}">
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
                            ${item.read_url
                                ? `<a href="${item.read_url}" target="_blank" rel="noopener" class="book-read-link">Leer →</a>`
                                : `<span class="book-read-link" style="opacity:0.35;cursor:default;">Sin acceso</span>`}
                        </div>
                    </div>
                </div>
            `).join('');
            grid.querySelectorAll('.book-detail-btn').forEach((btn, idx) => {
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    closeMobileSidebar();
                    showDetailView(items[parseInt(btn.dataset.itemIdx)]);
                });
            });
        }

        // ========== SUGERENCIAS DE DESCRIPTORES EN BUSCADOR ==========
        const descriptorSuggestions = document.getElementById('descriptorSuggestions');

        function showDescriptorSuggestions(q) {
            if (!q || q.length < 2) { descriptorSuggestions.style.display = 'none'; return; }
            const nq = q.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g,'');
            const matches = topDescriptorsData.filter(d =>
                d.name.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g,'').includes(nq)
            ).slice(0, 6);
            if (!matches.length) { descriptorSuggestions.style.display = 'none'; return; }
            descriptorSuggestions.innerHTML = matches.map(d => `
                <div class="descriptor-suggestion-item" onclick="applyDescriptorSuggestion(${d.id}, '${d.name.replace(/'/g,"\\'")}')">
                    <span><i class="fas fa-tag" style="margin-right:0.4rem;color:#c5a059;font-size:0.75rem;"></i>${d.name}</span>
                    <span class="ds-count">${d.books_count} recursos</span>
                </div>`).join('');
            descriptorSuggestions.style.display = 'block';
        }

        function applyDescriptorSuggestion(id, name) {
            descriptorSuggestions.style.display = 'none';
            activeDescriptorId = id;
            document.getElementById('contentSearchInput').value = name;
            filterByDescriptor(id);
            renderDescriptorChips();
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('.content-search')) descriptorSuggestions.style.display = 'none';
        });

        // ---- BÚSQUEDA EN CATÁLOGO (filtra tarjetas visibles) ----
        document.getElementById('sortSelect').addEventListener('change', function() {
            closeMobileSidebar();
            renderBooks();
        });

        document.getElementById('contentSearchInput').addEventListener('input', function() {
            closeMobileSidebar();
            const rawQ = this.value.trim();
            const q    = normalizeStr(rawQ);
            const isAuthors = state.activeTab === 'Autores';

            // Mostrar sugerencias de descriptores
            showDescriptorSuggestions(rawQ);

            if (!q) {
                activeDescriptorId = null;
                renderDescriptorChips();
                renderBooks();
                return;
            }

            // Si no hay descriptor activo, limpiar selección de chip
            if (activeDescriptorId !== null) {
                activeDescriptorId = null;
                renderDescriptorChips();
            }

            const baseItems = getDataForSection();

            const filtered = baseItems.filter(item => {
                if (isAuthors) {
                    return normalizeStr(item.name).includes(q) ||
                           normalizeStr(item.nationality).includes(q) ||
                           normalizeStr(item.biography).includes(q);
                }
                if (isEditoriales) {
                    return normalizeStr(item.name).includes(q) ||
                           normalizeStr(item.description).includes(q) ||
                           normalizeStr(item.address).includes(q);
                }
                // Búsqueda normal + boost por descriptor (aparecen primero)
                const matchDesc = item.descriptorNames &&
                    item.descriptorNames.some(dn => normalizeStr(dn).includes(q));
                const matchText = normalizeStr(item.title).includes(q) ||
                    normalizeStr(item.author).includes(q) ||
                    normalizeStr(item.description).includes(q) ||
                    normalizeStr(item.publisher).includes(q) ||
                    normalizeStr(String(item.year)).includes(q);
                return matchDesc || matchText;
            });

            // Ordenar: matches de descriptor primero
            filtered.sort((a, b) => {
                const aD = a.descriptorNames && a.descriptorNames.some(dn => normalizeStr(dn).includes(q)) ? 0 : 1;
                const bD = b.descriptorNames && b.descriptorNames.some(dn => normalizeStr(dn).includes(q)) ? 0 : 1;
                return aD - bD;
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
                                ? `<img src="${item.photo_url}" alt="${item.name}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" onerror="this.style.display='none'">`
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
                                ? `<img src="${item.cover_url}" alt="${item.title}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">`
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
                        closeMobileSidebar();
                        const item = filtered[parseInt(btn.dataset.searchIdx)];
                        if (item) showDetailView(item);
                    });
                });
            }
        });

        // ========== MOBILE NAV ==========
        function openMobileNav()  { document.getElementById('mobileNav').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeMobileNav() { document.getElementById('mobileNav').classList.remove('open'); document.body.style.overflow = ''; }
        window.openMobileNav  = openMobileNav;
        window.closeMobileNav = closeMobileNav;

        // ========== MOBILE SIDEBAR ==========
        function openMobileSidebar() {
            document.getElementById('mobileSidebar').classList.add('mobile-open');
            document.getElementById('sidebarOverlay').classList.add('open');
            document.getElementById('sidebarCloseBtn').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        function closeMobileSidebar() {
            document.getElementById('mobileSidebar').classList.remove('mobile-open');
            document.getElementById('sidebarOverlay').classList.remove('open');
            document.getElementById('sidebarCloseBtn').style.display = 'none';
            document.body.style.overflow = '';
        }
        window.openMobileSidebar  = openMobileSidebar;
        window.closeMobileSidebar = closeMobileSidebar;

        // ========== CARRUSELES DE INICIO ==========
        (function() {
            const CARD_W_BOOK   = 240 + 24;   // width + margin*2
            const CARD_W_AUTHOR = 150 + 20;
            const VISIBLE       = Math.floor(window.innerWidth / CARD_W_BOOK) + 2;

            const rawLibros   = @json($booksData['Libros'] ?? []);
            const rawAutores  = @json($booksData['Autores'] ?? []);
            const rawRevistas = @json($booksData['Revistas'] ?? []);

            const routes = {
                libro:   '/biblioteca/libros/',
                autor:   '/biblioteca/autores/',
                revista: '/biblioteca/revistas/',
            };

            function bookCardHTML(book) {
                const cover = book.cover_image_path ? `/storage/${book.cover_image_path}` : null;
                const authors = (book.authors || []).map(a => a.name).join(', ') || 'Desconocido';
                return `<div class="bib-carousel-card" onclick="window.location.href='${routes.libro}${book.id}'">
                    ${cover
                        ? `<img class="bib-card-cover" src="${cover}" alt="${book.title}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="bib-card-cover-placeholder">📚</div>`}
                    <div class="bib-card-body">
                        <p class="bib-card-title">${book.title}</p>
                        <p class="bib-card-sub">${authors}</p>
                    </div>
                </div>`;
            }

            function authorCardHTML(author) {
                const photo = author.photo_path ? `/storage/${author.photo_path}` : null;
                return `<div class="bib-author-card" onclick="window.location.href='${routes.autor}${author.id}'">
                    ${photo
                        ? `<img class="bib-author-avatar" src="${photo}" alt="${author.name}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="bib-author-placeholder">👤</div>`}
                    <div class="bib-author-body">
                        <p class="bib-author-name">${author.name}</p>
                        <p class="bib-author-nat">${author.nationality || ''}</p>
                    </div>
                </div>`;
            }

            function revistaCardHTML(book) {
                const cover = book.cover_image_path ? `/storage/${book.cover_image_path}` : null;
                const pub = book.publisher ? book.publisher.name : '';
                return `<div class="bib-carousel-card" onclick="window.location.href='${routes.revista}${book.id}'">
                    ${cover
                        ? `<img class="bib-card-cover" src="${cover}" alt="${book.title}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="bib-card-cover-placeholder">📰</div>`}
                    <div class="bib-card-body">
                        <p class="bib-card-title">${book.title}</p>
                        <p class="bib-card-sub">${pub}</p>
                    </div>
                </div>`;
            }

            // Mezcla aleatoria (Fisher-Yates)
            function shuffle(arr) {
                const a = [...arr];
                for (let i = a.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [a[i], a[j]] = [a[j], a[i]];
                }
                return a;
            }

            // Rellena hasta minLen repitiendo el array base
            function fillTo(base, minLen) {
                let out = [];
                while (out.length < minLen) out = out.concat(base);
                return out;
            }

            function buildCarousel(trackId, dotsId, rawItems, cardFn, cardW) {
                if (!rawItems.length) return null;

                const track  = document.getElementById(trackId);
                const dotsEl = document.getElementById(dotsId);
                if (!track || !dotsEl) return null;

                // Máximo 20 al azar
                const base = shuffle(rawItems).slice(0, 20);
                const n    = base.length; // tamaño del "ciclo" para dots

                // Necesitamos al menos: 3 pantallas llenas a cada lado + pantalla central
                const visibleCount = Math.ceil(window.innerWidth / cardW) + 2;
                const minTotal     = visibleCount * 7; // 7 pantallas de margen
                const pool         = fillTo(base, minTotal);
                const total        = pool.length;

                track.innerHTML = pool.map(cardFn).join('');
                track.style.gap = '0';

                // Empezar en el centro del pool
                let current  = Math.floor(total / 2);
                // Ajustar al múltiplo de n más cercano al centro
                current = Math.round(current / n) * n;
                let busy     = false;
                let autoTimer;

                // Dots (máx 8)
                dotsEl.innerHTML = '';
                const dotCount = Math.min(n, 8);
                for (let i = 0; i < dotCount; i++) {
                    const d = document.createElement('div');
                    d.className = 'ico-dot' + (i === 0 ? ' active' : '');
                    const target = current + i;
                    d.addEventListener('click', () => { if (!busy) go(target); });
                    dotsEl.appendChild(d);
                }

                function applyTransform(animated) {
                    track.style.transition = animated ? 'transform 500ms ease-in-out' : 'none';
                    track.style.transform  = `translateX(${-current * cardW}px)`;
                }

                function updateDots() {
                    dotsEl.querySelectorAll('.ico-dot').forEach((d, i) => {
                        d.classList.toggle('active', i === ((current % n + n) % n));
                    });
                }

                function go(next) {
                    if (busy) return;
                    busy = true;
                    current = next;
                    applyTransform(true);
                    updateDots();
                    setTimeout(() => {
                        // Si nos acercamos demasiado a los bordes, teleport al centro
                        const safeZone = visibleCount * 2;
                        if (current >= total - safeZone) {
                            current -= Math.floor(total / 2 / n) * n;
                            applyTransform(false);
                            updateDots();
                        } else if (current < safeZone) {
                            current += Math.floor(total / 2 / n) * n;
                            applyTransform(false);
                            updateDots();
                        }
                        busy = false;
                    }, 520);
                }

                function startAuto() {
                    clearInterval(autoTimer);
                    autoTimer = setInterval(() => { if (!busy) go(current + 1); }, 3500);
                }

                applyTransform(false);
                updateDots();
                startAuto();

                return {
                    go,
                    startAuto,
                    get current() { return current; },
                    get autoTimer() { return autoTimer; }
                };
            }

            const carousels = {};

            function initCarousels() {
                carousels.libros   = buildCarousel('trackLibros',   'dotsLibros',   rawLibros,   bookCardHTML,   CARD_W_BOOK);
                carousels.autores  = buildCarousel('trackAutores',  'dotsAutores',  rawAutores,  authorCardHTML, CARD_W_AUTHOR);
                carousels.revistas = buildCarousel('trackRevistas', 'dotsRevistas', rawRevistas, revistaCardHTML, CARD_W_BOOK);
            }

            window.moveCarousel = function(name, dir) {
                const c = carousels[name];
                if (!c) return;
                clearInterval(c.autoTimer);
                c.go(c.current + dir);
                c.startAuto();
            };

            // Inicializar cuando la sección sea visible por primera vez
            let initialized = false;
            const observer = new MutationObserver(() => {
                const sec = document.getElementById('inicioSection');
                if (sec && !sec.classList.contains('hidden') && !initialized) {
                    initialized = true;
                    initCarousels();
                }
            });
            const sec = document.getElementById('inicioSection');
            if (sec) observer.observe(sec, { attributes: true, attributeFilter: ['class'] });

            // Si ya está visible al cargar (activeSection === 'Inicio')
            if (sec && !sec.classList.contains('hidden')) {
                initialized = true;
                initCarousels();
            }
        })();
        // ========== FIN CARRUSELES ==========

        window.openMobileSidebar  = openMobileSidebar;
        window.closeMobileSidebar = closeMobileSidebar;
    </script>
    <x-floating-buttons />
</body>
</html>
