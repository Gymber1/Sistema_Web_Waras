<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fototeca Digital Ancashina — WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&family=Libre+Baskerville:ital@0;1&display=swap" rel="stylesheet">
    <style>
        /* ── VARIABLES ─────────────────────────────────────────────── */
        :root {
            --bg-page:       #0a0a0a;
            --bg-sidebar:    #141414;
            --bg-main:       #0a0a0a;
            --bg-card:       #1a1a1a;
            --bg-card-hover: #222222;
            --bg-topbar:     #0a0a0a;
            --gold:          #c5a66d;
            --gold-hover:    #d4b783;
            --text-primary:  #f0f0f0;
            --text-secondary:#cccccc;
            --text-muted:    #888888;
            --text-accent:   #c5a66d;
            --border-line:   #2a2a2a;
            --border-gold:   rgba(197,166,109,0.4);
            --sidebar-w:     288px;
            --nav-h:         80px;
            --topbar-h:      64px;
            --radius-card:   8px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            background: var(--bg-page);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* ── GLOBAL NAV ─────────────────────────────────────────────── */
        .global-nav {
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-line);
            transition: background 0.3s ease, border-color 0.3s ease, backdrop-filter 0.3s ease;
            padding: 0 2rem;
            height: var(--nav-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
        }
        /* Compensar el nav fixed en todas las secciones excepto el hero */
        body { padding-top: var(--nav-h); }
        .global-nav-brand {
            display: flex;
            flex-direction: column;
            cursor: pointer;
            background: none;
            border: none;
            text-align: left;
        }
        .global-nav-brand-main {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            line-height: 1;
        }
        .global-nav-brand-sub {
            font-size: 0.65rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gold);
            margin-top: 2px;
        }
        .global-nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            margin: 0 auto;
        }
        .global-nav-links a, .global-nav-links button {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            transition: color 0.2s;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            padding-bottom: 2px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .global-nav-links a:hover,
        .global-nav-links button:hover { color: #ffffff; }
        .global-nav-links a.active,
        .global-nav-links button.active { color: #ffffff; border-bottom-color: var(--gold); }
        .nav-portal-btn {
            color: #ffffff !important;
            border: 1px solid var(--border-line) !important;
            padding: 0.4rem 1rem !important;
            border-radius: 2px;
            font-size: 0.65rem !important;
            letter-spacing: 0.15em !important;
            transition: all 0.2s !important;
        }
        .nav-portal-btn:hover { background: #ffffff !important; color: #000000 !important; border-bottom: 1px solid var(--border-line) !important; }
        .nav-panel-btn {
            background: var(--gold) !important;
            color: #000000 !important;
            padding: 0.4rem 1rem !important;
            border-radius: 2px;
            font-size: 0.65rem !important;
            border: 1px solid var(--gold) !important;
            transition: all 0.2s !important;
            text-decoration: none !important;
            letter-spacing: 0.1em !important;
            font-weight: 700 !important;
        }
        .nav-panel-btn:hover { background: var(--gold-hover) !important; border-color: var(--gold-hover) !important; }
        .global-nav-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
        }
        .global-nav-hamburger span {
            display: block;
            width: 22px;
            height: 1.5px;
            background: #ffffff;
            border-radius: 1px;
            transition: transform 0.3s, opacity 0.3s;
        }
        .global-nav-hamburger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
        .global-nav-hamburger.open span:nth-child(2) { opacity: 0; }
        .global-nav-hamburger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }
        .global-nav-mobile {
            display: none;
            position: absolute;
            top: 100%;
            left: 0; right: 0;
            background: var(--bg-page);
            border-bottom: 1px solid var(--border-line);
            flex-direction: column;
            padding: 1rem 2rem 1.5rem;
            gap: 0;
            z-index: 199;
        }
        .global-nav-mobile.open { display: flex; }
        .global-nav-mobile a, .global-nav-mobile button {
            color: #999;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.85rem 0;
            border-bottom: 1px solid var(--border-line);
            transition: color 0.2s;
            background: none;
            border-top: none; border-left: none; border-right: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-align: left;
        }
        .global-nav-mobile a:last-child, .global-nav-mobile button:last-child { border-bottom: none; }
        .global-nav-mobile a:hover, .global-nav-mobile a.active,
        .global-nav-mobile button:hover, .global-nav-mobile button.active { color: var(--gold); }

        .global-nav.nav-transparent {
            background: rgba(0,0,0,0.35);
            backdrop-filter: blur(4px);
            border-bottom-color: transparent;
        }

        /* ── HERO ───────────────────────────────────────────────────── */
        .hero-section {
            position: relative;
            min-height: 100vh;
            margin-top: calc(-1 * var(--nav-h));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .hero-section.hidden { display: none !important; }
        .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            filter: sepia(0.2) brightness(0.65) contrast(1.05);
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(10,7,4,0.1) 0%,
                rgba(10,7,4,0.35) 60%,
                rgba(10,7,4,0.65) 100%
            );
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 820px;
            padding: 2rem 1.5rem;
            margin-top: 2rem;
        }
        .hero-eyebrow {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--text-accent);
            margin-bottom: 1.25rem;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 700;
            color: var(--sepia-light);
            line-height: 1.1;
            margin-bottom: 1.25rem;
        }
        .hero-title em {
            font-style: italic;
            color: var(--text-accent);
        }
        .hero-subtitle {
            font-size: 0.95rem;
            font-weight: 300;
            color: var(--sepia-mid);
            font-style: italic;
            max-width: 560px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
        }

        /* hero search */
        .hero-search-container { position: relative; width: 100%; max-width: 680px; margin: 0 auto; }
        .hero-search-wrap {
            display: flex;
            background: rgba(201,149,106,0.06);
            border: 1px solid var(--border-medium);
            backdrop-filter: blur(8px);
            overflow: hidden;
        }
        .hero-search-icon-wrap {
            display: flex;
            align-items: center;
            padding: 0 1rem;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .hero-search-input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: var(--sepia-light);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            padding: 0.9rem 0.5rem;
        }
        .hero-search-input::placeholder { color: var(--text-muted); }
        .hero-search-btn {
            background: linear-gradient(135deg, var(--wood-dark), var(--wood-mid));
            color: var(--sepia-light);
            border: none;
            padding: 0 1.75rem;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            flex-shrink: 0;
        }
        .hero-search-btn:hover { background: linear-gradient(135deg, var(--wood-mid), var(--wood-light)); }

        /* hero dropdown */
        .hero-search-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            left: 0; right: 0;
            background: var(--bg-card);
            border: 1px solid var(--border-medium);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            z-index: 999;
            max-height: 420px;
            overflow-y: auto;
        }
        .hero-search-dropdown.open { display: block; }
        .hsd-section-label {
            padding: 0.5rem 1rem 0.25rem;
            font-size: 0.62rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }
        .hsd-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1rem;
            cursor: pointer;
            transition: background 0.15s;
            text-decoration: none;
            color: inherit;
        }
        .hsd-item:hover { background: rgba(201,149,106,0.08); }
        .hsd-thumb {
            width: 44px; height: 36px;
            background: var(--bg-sidebar);
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-subtle);
        }
        .hsd-thumb img { width: 100%; height: 100%; object-fit: cover; filter: sepia(0.2); }
        .hsd-info { flex: 1; min-width: 0; }
        .hsd-title { font-size: 0.83rem; font-weight: 500; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .hsd-sub { font-size: 0.72rem; color: var(--text-muted); }
        .hsd-badge {
            font-size: 0.62rem; font-weight: 700;
            color: var(--text-accent);
            background: rgba(201,149,106,0.1);
            border: 1px solid var(--border-subtle);
            padding: 0.15rem 0.5rem;
            flex-shrink: 0;
        }
        .hsd-empty { padding: 1.25rem 1rem; font-size: 0.85rem; color: var(--text-muted); text-align: center; }
        .hsd-all-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(201,149,106,0.05);
            border: none;
            border-top: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            font-size: 0.82rem;
            cursor: pointer;
            text-align: center;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s;
        }
        .hsd-all-btn:hover { background: rgba(201,149,106,0.1); color: var(--text-accent); }

        /* ── INICIO SECTION ─────────────────────────────────────────── */
        .inicio-section { background: var(--bg-page); }
        .inicio-section.hidden { display: none !important; }

        .stats-bar {
            background: #111111;
            display: grid; grid-template-columns: repeat(3, 1fr);
            border-bottom: 1px solid var(--border-line);
        }
        .stat-item {
            padding: 2.2rem 1rem; text-align: center;
            border-right: 1px solid var(--border-line);
        }
        .stat-item:last-child { border-right: none; }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem; font-weight: 700; color: var(--gold);
            line-height: 1; display: block;
        }
        .stat-label {
            font-size: .6rem; font-weight: 600; letter-spacing: .18em;
            text-transform: uppercase; color: var(--text-muted); margin-top: .45rem; display: block;
        }

        .inicio-carousel-section { padding: 3.5rem 0; overflow: hidden; position: relative; }
        .inicio-carousel-section + .inicio-carousel-section { border-top: 1px solid var(--border-line); }
        .inicio-carousel-header {
            max-width: 1400px; margin: 0 auto 2rem; padding: 0 2rem;
            display: flex; align-items: baseline; gap: 1rem;
        }
        .inicio-carousel-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; color: var(--text-primary);
        }
        .inicio-carousel-count {
            font-size: .75rem; color: var(--text-muted); font-weight: 500;
        }
        .inicio-carousel-track-wrap {
            position: relative; overflow: hidden;
            max-width: 1400px; margin: 0 auto; padding: 1rem 2rem 1.5rem;
        }
        .inicio-carousel-track {
            display: flex; align-items: stretch;
            will-change: transform; transition: transform 600ms ease-in-out;
        }
        .inicio-carousel-controls {
            max-width: 1400px; margin: 1rem auto 0; padding: 0 2rem;
            display: flex; align-items: center; gap: 1rem;
        }

        /* Card de fotografía (carrusel) */
        .ftc-carousel-card {
            flex-shrink: 0; width: 340px; margin: 0 14px;
            background: var(--bg-card); border-radius: 10px;
            border: 1px solid var(--border-line);
            cursor: pointer; overflow: hidden;
            transform: translateZ(0);
            transition: border-color .25s, box-shadow .25s, transform .25s;
        }
        .ftc-carousel-card:hover { border-color: var(--gold); box-shadow: 0 12px 32px rgba(0,0,0,.6); transform: translateY(-4px); }
        .ftc-card-cover {
            width: 100%; aspect-ratio: 16/10; object-fit: cover; display: block;
            background: #111; filter: sepia(0.15);
        }
        .ftc-card-cover-placeholder {
            width: 100%; aspect-ratio: 16/10;
            background: #1a1a1a;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted); font-size: 3.5rem;
        }
        .ftc-card-body { padding: .9rem 1.1rem; }
        .ftc-card-title {
            font-size: .95rem; color: var(--text-primary); line-height: 1.35;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .ftc-card-sub { font-size: .75rem; color: var(--text-muted); margin-top: .35rem;
            display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
        }

        /* Card de fotógrafo (carrusel) */
        .ftc-author-card {
            flex-shrink: 0; width: 150px; margin: 0 10px;
            background: var(--bg-card); border-radius: 6px;
            border: 1px solid var(--border-line);
            cursor: pointer; overflow: hidden;
            transform: translateZ(0);
            transition: border-color .25s, box-shadow .25s;
            text-align: center;
        }
        .ftc-author-card:hover { border-color: var(--gold); box-shadow: 0 6px 20px rgba(0,0,0,.4); }
        .ftc-author-avatar {
            width: 100%; aspect-ratio: 1/1; object-fit: cover; display: block;
            background: #111;
        }
        .ftc-author-placeholder {
            width: 100%; aspect-ratio: 1/1;
            background: #1a1a1a;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; color: var(--text-muted);
        }
        .ftc-author-body { padding: .65rem .75rem; }
        .ftc-author-name {
            font-size: .78rem; font-weight: 600; color: var(--text-primary);
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .ftc-author-count { font-size: .65rem; color: var(--text-muted); margin-top: .2rem; }

        /* Botón Ver más carrusel */
        .carousel-ver-mas {
            max-width: 1400px; margin: 1.25rem auto 0; padding: 0 2rem;
            display: flex; justify-content: center;
        }
        .carousel-ver-mas-btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .6rem 2rem; border-radius: 999px;
            background: transparent; border: 1.5px solid var(--gold);
            color: var(--gold); font-family: inherit; font-size: .82rem;
            font-weight: 600; letter-spacing: .04em; cursor: pointer;
            transition: background .2s, color .2s, transform .15s, box-shadow .2s;
        }
        .carousel-ver-mas-btn:hover {
            background: var(--gold); color: #000;
            transform: translateY(-1px); box-shadow: 0 6px 18px rgba(197,166,109,.35);
        }

        /* Controles carrusel */
        .ico-btn {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--gold); color: #000; border: none;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700;
            transition: background .2s, transform .15s;
            box-shadow: 0 2px 8px rgba(197,166,109,.3);
            flex-shrink: 0;
        }
        .ico-btn:hover { background: var(--gold-hover); transform: scale(1.08); }
        .ico-dots { display: flex; gap: .5rem; align-items: center; }
        .ico-dot {
            height: 7px; border-radius: 4px;
            background: #444; cursor: pointer;
            transition: all .35s; width: 7px;
        }
        .ico-dot.active { background: var(--gold); width: 24px; }

        /* ── LAYOUT GALLERY ─────────────────────────────────────────── */
        .gallery-layout {
            display: flex;
            flex: 1;
        }
        .gallery-layout.hidden { display: none !important; }

        /* ── SIDEBAR ─────────────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-width: var(--sidebar-w);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-line);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            position: sticky;
            top: var(--nav-h);
            height: calc(100vh - var(--nav-h));
            scrollbar-width: thin;
            scrollbar-color: #333 transparent;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #333; border-radius: 2px; }
        .sidebar.no-sidebar { display: none; }
        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid var(--border-line);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-logo {
            width: 32px; height: 32px;
            background: var(--gold);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .sidebar-title-text {
            font-family: 'Playfair Display', serif;
            font-size: 0.82rem; font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .sidebar-subtitle-text {
            font-size: 0.62rem; color: var(--text-muted);
            letter-spacing: 0.2em; text-transform: uppercase;
            margin-top: 1px;
        }
        .sidebar-close-btn {
            display: none;
            margin-left: auto;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1rem;
            cursor: pointer;
            width: 28px; height: 28px;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }
        .sidebar-close-btn:hover { color: #fff; }

        /* sidebar accordion */
        .sidebar-section { padding: 1.5rem 1rem 0; }
        .sidebar-section-label {
            font-size: 0.6rem; font-weight: 700;
            letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 0.5rem 0.75rem;
            display: flex; align-items: center; gap: 0.4rem;
        }
        .accordion-group { margin-bottom: 2px; }
        .accordion-btn {
            width: 100%;
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.55rem 0.75rem;
            background: none;
            border: none;
            color: #ccc;
            font-size: 0.8rem;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            border-radius: 6px;
            text-align: left;
            transition: background 0.15s, color 0.15s;
        }
        .accordion-btn:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .accordion-btn--active { color: var(--gold) !important; background: rgba(197,166,109,0.12) !important; }
        .accordion-btn-text { flex: 1; }
        .accordion-chevron {
            flex-shrink: 0;
            transition: transform 0.25s ease;
            color: var(--text-muted);
            font-size: 0.65rem;
        }
        .accordion-chevron.open { transform: rotate(90deg); color: var(--gold); }
        .accordion-panel { overflow: hidden; max-height: 0; transition: max-height 0.3s ease; padding-left: 0.25rem; }
        .accordion-panel.open { max-height: 1000px; }
        .sidebar-leaf {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.45rem 0.75rem 0.45rem 1.5rem;
            color: #999;
            font-size: 0.78rem;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-family: 'Inter', sans-serif;
        }
        .sidebar-leaf:hover { background: rgba(255,255,255,0.05); color: #ccc; }
        .sidebar-leaf.active { color: var(--gold) !important; background: rgba(197,166,109,0.12) !important; font-weight: 600; }
        .leaf-dot { width: 4px; height: 4px; border-radius: 50%; background: #444; flex-shrink: 0; }
        .sidebar-leaf.active .leaf-dot { background: var(--gold); }
        .sidebar-footer {
            margin-top: auto;
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border-line);
            font-size: 0.68rem;
            color: var(--text-muted);
            line-height: 1.8;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ── GALLERY MAIN ────────────────────────────────────────────── */
        .gallery-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: var(--bg-main);
        }

        /* topbar filtros */
        .topbar {
            background: var(--bg-page);
            border-bottom: 1px solid var(--border-line);
            padding: 0 2rem;
            min-height: var(--topbar-h);
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            position: sticky;
            top: var(--nav-h);
            z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }
        .hamburger-btn {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 4px;
        }
        .hamburger-btn span { display: block; width: 18px; height: 1.5px; background: #888; border-radius: 1px; }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 0.4rem; font-size: 0.7rem; letter-spacing: 0.1em; text-transform: uppercase; }
        .topbar-breadcrumb-home { color: var(--text-muted); }
        .topbar-breadcrumb-sep { color: #444; }
        .topbar-breadcrumb-current { color: var(--gold); font-weight: 500; }
        .topbar-filters { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-left: auto; align-items: center; }
        .filter-pill {
            padding: 0.3rem 0.75rem;
            border: 1px solid var(--border-line);
            border-radius: 4px;
            color: var(--text-muted);
            font-size: 0.65rem; font-weight: 600;
            letter-spacing: 0.12em; text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            background: none;
            font-family: 'Inter', sans-serif;
        }
        .filter-pill:hover { border-color: var(--gold); color: #fff; background: rgba(197,166,109,0.08); }
        .filter-pill.active { background: var(--gold); border-color: var(--gold); color: #000; font-weight: 700; }
        /* custom sort dropdown */
        .sort-select-wrap { position: relative; }
        .sort-btn {
            display: flex; align-items: center; gap: 0.5rem;
            background: transparent;
            border: 1px solid var(--border-line);
            color: #fff;
            font-size: 0.68rem; font-weight: 500;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.08em; text-transform: uppercase;
            padding: 0.3rem 0.75rem;
            cursor: pointer;
            outline: none;
            border-radius: 4px;
            transition: border-color 0.2s;
            white-space: nowrap;
        }
        .sort-btn:hover { border-color: var(--gold); }
        .sort-btn svg { color: var(--text-muted); transition: transform 0.2s; }
        .sort-btn.open svg { transform: rotate(180deg); }
        .sort-dropdown {
            display: none;
            position: absolute; top: calc(100% + 6px); right: 0;
            background: #1a1a1a;
            border: 1px solid var(--border-line);
            border-radius: 6px;
            min-width: 160px;
            z-index: 200;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }
        .sort-dropdown.open { display: block; }
        .sort-option {
            display: block; width: 100%;
            padding: 0.6rem 1rem;
            background: none; border: none;
            color: var(--text-muted);
            font-size: 0.68rem; font-family: 'Inter', sans-serif;
            letter-spacing: 0.06em; text-transform: uppercase;
            text-align: left; cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .sort-option:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .sort-option.active { color: var(--gold); background: rgba(197,166,109,0.1); }

        /* barra contextual — header de sección */
        .gallery-context-bar {
            display: flex;
            align-items: baseline;
            gap: 1.25rem;
            padding: 2.5rem 2rem 1.5rem;
            border-bottom: 1px solid var(--border-line);
        }
        .gallery-context-title-row {
            display: contents; /* inline in Galería — children participate in parent flex */
        }
        .gallery-context-line { display: none; }
        .gallery-context-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 400;
            color: #ffffff;
            white-space: nowrap;
        }
        .gallery-context-count {
            font-size: 0.82rem; color: var(--text-muted);
            white-space: nowrap; font-style: italic;
        }

        /* busqueda contenido */
        .content-search-wrap {
            padding: 0.75rem 2rem;
            border-bottom: 1px solid var(--border-line);
        }
        .content-search-inner {
            display: flex; align-items: center; gap: 0.5rem;
            background: var(--bg-page);
            border: 1px solid var(--border-line);
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            max-width: 420px;
        }
        .content-search-inner:focus-within { border-color: var(--gold); }
        .content-search-input {
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 0.82rem;
            font-family: 'Inter', sans-serif;
            flex: 1;
        }
        .content-search-input::placeholder { color: var(--text-muted); }

        /* ── PHOTO GRID ──────────────────────────────────────────────── */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }
        .photo-card {
            animation: cardIn 0.4s ease both;
            cursor: pointer;
        }
        @keyframes cardIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .photo-card-inner {
            background: var(--bg-card);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-card);
            overflow: hidden;
            transition: border-color 0.25s ease;
            transform: translateZ(0);
        }
        .photo-card-inner:hover {
            border-color: rgba(197,166,109,0.5);
        }
        .photo-card-img-wrap {
            position: relative;
            aspect-ratio: 4/3;
            overflow: hidden;
            background: #111;
            transform: translateZ(0);
        }
        .photo-card-img {
            width: 100%; height: 100%; object-fit: cover; display: block;
            transition: transform 0.4s ease;
            will-change: transform;
        }
        .photo-card-inner:hover .photo-card-img { transform: scale(1.05); }
        .photo-card-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,10,10,0.88) 0%, transparent 55%);
            opacity: 0; transition: opacity 0.25s ease;
            display: flex; align-items: flex-end;
            will-change: opacity;
        }
        .photo-card-inner:hover .photo-card-overlay { opacity: 1; }
        .photo-card-overlay-content { padding: 0.85rem 1rem; width: 100%; }
        .overlay-year { font-size: 0.72rem; color: var(--gold); font-family: 'Libre Baskerville', serif; font-style: italic; }
        .overlay-location {
            font-size: 0.68rem; color: var(--text-secondary);
            display: flex; align-items: center; gap: 0.3rem; margin-top: 0.2rem;
        }
        .photo-card-badge {
            position: absolute; top: 0.75rem; left: 0.75rem;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(8px);
            color: #fff;
            font-size: 0.6rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.12em;
            padding: 0.2rem 0.5rem; border-radius: 3px;
        }
        .photo-card-info { padding: 1.25rem; background: var(--bg-card); }
        .photo-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem; font-weight: 400;
            color: #fff; line-height: 1.35; margin-bottom: 0.5rem;
            transition: color 0.2s;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .photo-card-inner:hover .photo-card-title { color: var(--gold); }
        .photo-card-meta { display: flex; flex-direction: column; gap: 0.25rem; }
        .meta-photographer {
            font-size: 0.72rem; color: var(--text-muted);
            display: flex; align-items: center; gap: 0.3rem;
        }
        .meta-categories { display: flex; gap: 0.3rem; flex-wrap: wrap; margin-top: 0.25rem; }
        .cat-badge {
            font-size: 0.6rem; font-weight: 600;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border-line);
            color: #888;
            padding: 0.1rem 0.45rem;
            border-radius: 3px;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        /* eliminar corners decorativos */
        .photo-corner { display: none; }

        /* ── FOTÓGRAFOS CARDS ──────────────────────────────────────── */
        .photographer-card {
            background: var(--bg-card);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-card);
            overflow: hidden;
            text-decoration: none;
            display: flex; flex-direction: column;
            transition: border-color 0.3s ease;
            animation: cardIn 0.5s ease both;
            cursor: pointer;
        }
        .photographer-card:hover { border-color: rgba(197,166,109,0.5); }
        .pg-img-wrap {
            position: relative;
            aspect-ratio: 1/1;
            overflow: hidden;
            background: #111;
        }
        .pg-img {
            width: 100%; height: 100%; object-fit: cover;
            filter: grayscale(1);
            transition: filter 0.5s ease, transform 0.5s ease;
        }
        .photographer-card:hover .pg-img { filter: grayscale(0); transform: scale(1.03); }
        .pg-placeholder {
            width: 100%; height: 100%;
            background: #1a1a1a;
            display: flex; align-items: center; justify-content: center;
            color: #333; font-size: 3rem;
        }
        .pg-img-overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.1);
            transition: background 0.3s ease;
        }
        .photographer-card:hover .pg-img-overlay { background: transparent; }
        .pg-info {
            padding: 1.5rem;
            flex: 1; display: flex; flex-direction: column;
            background: var(--bg-card);
        }
        .pg-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 400;
            color: #fff; margin-bottom: 0.35rem;
        }
        .pg-bio {
            font-size: 0.78rem; color: var(--text-muted);
            line-height: 1.6; flex: 1;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            margin-bottom: 1.5rem;
            min-height: 2.4em;
        }
        .pg-footer {
            margin-top: auto; padding-top: 1rem;
            border-top: 1px solid var(--border-line);
            display: flex; justify-content: space-between; align-items: center;
            font-size: 0.65rem;
        }
        .pg-footer-link {
            color: var(--gold);
            text-transform: uppercase; letter-spacing: 0.15em; font-weight: 600;
        }
        .pg-count-badge {
            background: #222;
            color: #ccc;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-weight: 700; font-size: 0.62rem;
            border: 1px solid var(--border-line);
            letter-spacing: 0.05em;
        }

        /* ── EMPTY STATE ─────────────────────────────────────────────── */
        .empty-state {
            flex: 1;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 5rem 2rem; text-align: center; gap: 1rem;
            color: var(--text-muted);
        }
        .empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; color: #555;
        }
        .empty-desc { color: var(--text-muted); font-size: 0.9rem; max-width: 28rem; }
        .empty-btn {
            display: inline-block; margin-top: 0.5rem;
            background: var(--gold);
            color: #000;
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 3px;
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            text-decoration: none; cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .empty-btn:hover { background: var(--gold-hover); }

        /* ── PAGINACION ─────────────────────────────────────────────── */
        .pagination-wrap { padding: 2rem; display: flex; justify-content: center; }

        /* ── APORTANTES ──────────────────────────────────────────────── */
        .aportantes-section {
            display: none;
            flex: 1;
            background: var(--bg-page);
        }
        .aportantes-inner {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 320px;
            gap: 5rem; padding: 4rem 2rem;
            align-items: start;
        }
        .aportantes-title-row {
            display: flex; align-items: center; gap: 1.5rem; margin-bottom: 3rem;
        }
        .aportantes-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; font-weight: 400;
            color: #ffffff;
            white-space: nowrap;
        }
        .aportantes-divider { flex: 1; height: 1px; background: var(--border-line); }
        .aport-item { margin-bottom: 0.4rem; }
        .aport-btn {
            width: 100%; display: flex; align-items: center;
            padding: 0; border: none; cursor: pointer;
            background: var(--bg-card);
            border: 1px solid var(--border-line);
            border-radius: 6px;
            transition: border-color 0.2s;
            overflow: hidden;
        }
        .aport-btn:hover, .aport-btn.aport-active { border-color: rgba(197,166,109,0.4); }
        .aport-icon {
            width: 52px; height: 52px;
            display: flex; align-items: center; justify-content: center;
            background: var(--gold); flex-shrink: 0;
            transition: background 0.2s;
            font-size: 1rem; color: #000; font-weight: 700;
        }
        .aport-btn.aport-active .aport-icon { background: var(--gold-hover); }
        .aport-label {
            padding: 0 1.5rem;
            font-size: 0.85rem; font-weight: 500;
            color: #ddd; letter-spacing: 0.03em;
            font-family: 'Inter', sans-serif;
        }
        .aport-content {
            max-height: 0; overflow: hidden; opacity: 0;
            transition: max-height 0.4s ease, opacity 0.3s ease;
        }
        .aport-content-inner {
            padding: 1.5rem 2rem;
            font-size: 0.88rem;
            color: #999;
            line-height: 1.9;
            background: var(--bg-card);
            border: 1px solid var(--border-line); border-top: none;
            border-radius: 0 0 6px 6px;
            text-align: justify;
        }
        .director-title-row {
            display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;
        }
        .director-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 400;
            color: var(--gold); white-space: nowrap;
        }
        .director-card {
            display: flex; flex-direction: column; align-items: center; text-align: center;
        }
        .director-avatar {
            width: 160px; height: 160px;
            border-radius: 50%;
            border: 2px solid var(--border-line);
            overflow: hidden;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        }
        .director-avatar img { width: 100%; height: 100%; object-fit: cover; filter: grayscale(0.3); }
        .director-name {
            font-size: 0.85rem; font-weight: 600;
            color: #fff;
            letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.3rem;
        }
        .director-role { font-size: 0.8rem; color: var(--text-muted); font-style: italic; }

        /* ── OVERLAY SIDEBAR MÓVIL ───────────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.7); z-index: 149;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.open { display: block; }

        /* ── FOOTER ──────────────────────────────────────────────────── */
        .site-footer {
            background: var(--bg-page);
            border-top: 1px solid var(--border-line);
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .site-footer p:first-child {
            font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--text-muted); margin-bottom: 0.5rem;
        }
        .site-footer p:last-child { font-size: 0.72rem; color: #333; }

        /* ── SCROLLBAR ───────────────────────────────────────────────── */
        * { scrollbar-width: thin; scrollbar-color: #333 transparent; }
        *::-webkit-scrollbar { width: 5px; height: 5px; }
        *::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }


        /* ── RESPONSIVE ──────────────────────────────────────────────── */
        @media (max-width: 768px) {
            .global-nav { position: fixed; }
            .global-nav-links { display: none; }
            .global-nav-hamburger { display: flex; }

            .sidebar {
                position: fixed; top: 0; left: 0;
                height: 100vh; transform: translateX(-100%);
                transition: transform 0.3s ease; z-index: 150;
            }
            .sidebar--open { transform: translateX(0) !important; }
            .sidebar-close-btn { display: flex; }

            .hamburger-btn { display: flex; }
            .topbar { flex-wrap: nowrap; overflow: hidden; padding: 0 1rem; }
            .topbar-filters { margin-left: 0; overflow-x: auto; flex-wrap: nowrap; padding-bottom: 2px; }
            .topbar-filters::-webkit-scrollbar { display: none; }
            .photo-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; padding: 1rem; }
            .aportantes-inner { grid-template-columns: 1fr; gap: 0; padding: 2rem 1.25rem; }
            .aportantes-title { font-size: 1.1rem; white-space: normal; }
        }
        @media (max-width: 480px) {
            .photo-grid { grid-template-columns: repeat(2, 1fr); gap: 0.6rem; padding: 0.75rem; }
        }
        /* no-sidebar layout (Especiales, Fotógrafos) */
        .gallery-layout.no-sidebar .sidebar { display: none !important; }
        .gallery-layout.no-sidebar .photo-grid,
        .gallery-layout.no-sidebar .photographer-grid-container { max-width: 1400px; margin: 0 auto; }

        /* Fotógrafos / Especiales: hide topbar, center context bar */
        .gallery-layout.no-sidebar #galleryTopbar { display: none !important; }
        .gallery-layout.no-sidebar .gallery-context-bar {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 4rem 2rem 3rem;
        }
        .gallery-layout.no-sidebar .gallery-context-title-row {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        .gallery-layout.no-sidebar .gallery-context-line {
            display: block;
            width: 3rem; height: 1px;
            background: var(--gold);
        }
        .gallery-layout.no-sidebar .gallery-context-title {
            font-size: 2.5rem;
        }
        .gallery-layout.no-sidebar .gallery-context-count {
            font-size: 0.85rem;
            font-style: italic;
            color: var(--text-muted);
        }
        .gallery-layout.no-sidebar .photo-grid {
            padding: 0 2rem 3rem;
            gap: 1.5rem;
        }
    </style>
</head>
<body>

    <!-- ── GLOBAL NAV ──────────────────────────────────────────────── -->
    <nav class="global-nav" id="globalNav">
        <button class="global-nav-brand" id="logoBtn">
            <span class="global-nav-brand-main">FOTOTECA</span>
            <span class="global-nav-brand-sub">Digital Ancashina</span>
        </button>
        <div class="global-nav-links" id="globalNavLinks">
            <button class="nav-item-btn" data-tab="Inicio">Inicio</button>
            <button class="nav-item-btn" data-tab="Galería">Galería</button>
            <button class="nav-item-btn" data-tab="Fotógrafos">Fotógrafos</button>
            <button class="nav-item-btn" data-tab="Aportantes">Sobre Nosotros</button>
            <a href="{{ route('home') }}" class="nav-portal-btn">Portal Principal</a>
            @auth
                @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
                <a href="{{ route('admin.dashboard') }}" class="nav-panel-btn">
                    Panel
                </a>
                @endif
            @endauth
        </div>
        <button class="global-nav-hamburger" id="globalNavHamburger" aria-label="Menú">
            <span></span><span></span><span></span>
        </button>
        <div class="global-nav-mobile" id="globalNavMobile">
            <button class="nav-item-btn" data-tab="Inicio">Inicio</button>
            <button class="nav-item-btn" data-tab="Galería">Galería</button>
            <button class="nav-item-btn" data-tab="Fotógrafos">Fotógrafos</button>
            <button class="nav-item-btn" data-tab="Aportantes">Sobre Nosotros</button>
            <a href="{{ route('home') }}" style="color:var(--text-muted)">Portal Principal</a>
            @auth
                @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
                <a href="{{ route('admin.dashboard') }}" style="color:var(--text-accent)">Panel Admin</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- ── HERO ────────────────────────────────────────────────────── -->
    <section class="hero-section" id="heroSection">
        <div class="hero-bg" style="background-image:url('{{ $heroBg ?? 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?auto=format&fit=crop&w=1920&q=80' }}');"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <p class="hero-eyebrow">Archivo Visual de Áncash</p>
            <h1 class="hero-title">Fototeca<br><em>Ancashina</em></h1>
            <p class="hero-subtitle">Preservando y compartiendo la memoria visual, histórica y cultural de nuestra región.</p>
            <div class="hero-search-container">
                <div class="hero-search-wrap">
                    <div class="hero-search-icon-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </div>
                    <input type="text" class="hero-search-input" id="heroSearchInput" placeholder="Buscar fotografías, autores, años…" autocomplete="off">
                    <button class="hero-search-btn" id="heroSearchBtn">Buscar</button>
                </div>
                <div class="hero-search-dropdown" id="heroDropdown"></div>
            </div>
        </div>
    </section>

    <!-- ── INICIO SECTION ────────────────────────────────────────── -->
    <div class="inicio-section hidden" id="inicioSection">

        <!-- Contadores -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-num">{{ $totalPhotos }}</span>
                <span class="stat-label">Galería</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $totalPhotographers }}</span>
                <span class="stat-label">Fotógrafos</span>
            </div>
        </div>

        <!-- Carrusel: Galería -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Galería</h2>
                <span class="inicio-carousel-count">{{ $totalPhotos }} fotografías</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackGaleria"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveFtcCarousel('galeria',-1)">‹</button>
                <div class="ico-dots" id="dotsGaleria"></div>
                <button class="ico-btn" onclick="moveFtcCarousel('galeria',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Galería')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Carrusel: Fotógrafos -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Fotógrafos</h2>
                <span class="inicio-carousel-count">{{ $totalPhotographers }} registrados</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackFotografos"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveFtcCarousel('fotografos',-1)">‹</button>
                <div class="ico-dots" id="dotsFotografos"></div>
                <button class="ico-btn" onclick="moveFtcCarousel('fotografos',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Fotógrafos')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>


    </div>

    <!-- ── SIDEBAR OVERLAY (móvil) ────────────────────────────────── -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ── GALLERY LAYOUT ─────────────────────────────────────────── -->
    <div class="gallery-layout hidden" id="galleryLayout">

        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <div>
                    <p class="sidebar-title-text">FOTOTECA</p>
                    <p class="sidebar-subtitle-text">Ancash Digital</p>
                </div>
                <button class="sidebar-close-btn" id="sidebarClose">✕</button>
            </div>

            <!-- Buscador sidebar -->
            <div style="padding:0.75rem 1rem; border-bottom:1px solid var(--border-subtle);">
                <div class="content-search-inner" style="max-width:100%;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);flex-shrink:0;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" class="content-search-input" id="contentSearchInput" placeholder="Buscar en esta sección…">
                </div>
            </div>

            <!-- Sección categorías -->
            <div class="sidebar-section">
                <h4 class="sidebar-section-label">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                    Distribución Geográfica
                </h4>
                <ul id="sidebarCategories" style="list-style:none;padding:0;margin:0;"></ul>
            </div>

            <div class="sidebar-footer" id="sidebarFooter">
                <p>Archivo Histórico Ancashino</p>
                <p id="sidebarPhotoCount">— fotografías catalogadas</p>
            </div>
        </aside>

        <!-- MAIN GALLERY -->
        <main class="gallery-main" id="galleryMain">
            <div class="topbar" id="galleryTopbar">
                <div class="topbar-left">
                    <button class="hamburger-btn" id="hamburgerBtn">
                        <span></span><span></span><span></span>
                    </button>
                    <div class="topbar-breadcrumb">
                        <span class="topbar-breadcrumb-home">Fototeca</span>
                        <span class="topbar-breadcrumb-sep">›</span>
                        <span class="topbar-breadcrumb-current" id="breadcrumbCurrent">Galería</span>
                    </div>
                </div>
                <div class="topbar-filters" id="topbarFilters">
                    <!-- period pills rendered by JS -->
                </div>
                <div class="sort-select-wrap">
                    <button class="sort-btn" id="sortBtn" aria-haspopup="listbox">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        <span id="sortLabel">Ordenar: A-Z</span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="sort-dropdown" id="sortDropdown" role="listbox">
                        <button class="sort-option active" data-value="az" role="option">A–Z</button>
                        <button class="sort-option" data-value="recent" role="option">Más recientes</button>
                        <button class="sort-option" data-value="old" role="option">Más antiguos</button>
                        <button class="sort-option" data-value="year_asc" role="option">Por año ↑</button>
                        <button class="sort-option" data-value="year_desc" role="option">Por año ↓</button>
                    </div>
                    <!-- hidden select for JS compatibility -->
                    <select id="sortSelect" style="display:none">
                        <option value="az">A-Z</option>
                        <option value="recent">Más recientes</option>
                        <option value="old">Más antiguos</option>
                        <option value="year_asc">Por año ↑</option>
                        <option value="year_desc">Por año ↓</option>
                    </select>
                </div>
            </div>

            <div class="gallery-context-bar">
                <div class="gallery-context-title-row">
                    <div class="gallery-context-line"></div>
                    <h2 class="gallery-context-title" id="sectionTitle">Galería</h2>
                    <div class="gallery-context-line"></div>
                </div>
                <div class="gallery-context-count"><span id="photoCount">0</span> resultado(s)</div>
            </div>

            <div class="photo-grid" id="photosGrid"></div>
        </main>
    </div>

    <!-- ── APORTANTES ──────────────────────────────────────────────── -->
    <div class="aportantes-section" id="aportantesSection">
        <div class="aportantes-inner">
            <div>
                <div class="aportantes-title-row">
                    <h1 class="aportantes-title">Fototeca Digital Ancashina</h1>
                    <div class="aportantes-divider"></div>
                </div>
                <div id="aportantesAccordion" style="display:flex;flex-direction:column;gap:0.4rem;">
                    <div class="aport-item" data-id="inicio">
                        <button class="aport-btn aport-active" onclick="toggleAportante('inicio')">
                            <div class="aport-icon">−</div>
                            <span class="aport-label">Inicio</span>
                        </button>
                        <div class="aport-content" style="max-height:1000px;opacity:1;">
                            <div class="aport-content-inner">
                                Nace con la idea de fortalecer la Identidad Cultural de las nuevas generaciones del Departamento de Ancash. Fue promovido inicialmente por la Sociedad Unión Progreso Soledad, en el año 2010. Luego, fue asumido por la Biblioteca Pública Municipal de Huaraz, como un servicio y producto a desarrollar y difundir, como parte de su función de rescatar y promover Identidad.
                            </div>
                        </div>
                    </div>
                    <div class="aport-item" data-id="antecedentes">
                        <button class="aport-btn" onclick="toggleAportante('antecedentes')">
                            <div class="aport-icon">+</div>
                            <span class="aport-label">Antecedentes</span>
                        </button>
                        <div class="aport-content">
                            <div class="aport-content-inner">
                                El sistema educativo no incluye en su currículo temas de historia, literatura, geografía, ciencias, etc., de manera específica sobre nuestra Región, por lo cual, las nuevas generaciones desconocen de nuestra historia, recursos y cultura. Asimismo, los docentes expresan que, para poder cubrir estas necesidades temáticas carecen de fuentes bibliográficas de donde poder tomar datos, información y conocimientos para incluirlos en la malla curricular, denotando la carencia de bibliotecas y fuentes primarias para obtener física o virtualmente estos conocimientos. Ante esta situación paupérrima y de miseria de fuentes de información sobre nuestra identidad, es que se generó el proyecto denominado "PORTAL DE LA CIENCIA Y CULTURA ANCASHINA".
                            </div>
                        </div>
                    </div>
                    <div class="aport-item" data-id="finalidad">
                        <button class="aport-btn" onclick="toggleAportante('finalidad')">
                            <div class="aport-icon">+</div>
                            <span class="aport-label">Finalidad</span>
                        </button>
                        <div class="aport-content">
                            <div class="aport-content-inner">
                                La Fototeca Digital Ancashina tiene por finalidad recopilar, preservar y difundir el patrimonio fotográfico de la Provincia de Huaraz, cuya concreción ha sido posible gracias a la alianza y cooperación entre la Biblioteca Municipal de Huaraz, la Sociedad Unión Progreso Soledad, el Club de Fotógrafos de Huaraz y La Sociedad Patriotica Sanchez Carrion - Luzuriaga y Mejía.
                            </div>
                        </div>
                    </div>
                    <div class="aport-item" data-id="responsables">
                        <button class="aport-btn" onclick="toggleAportante('responsables')">
                            <div class="aport-icon">+</div>
                            <span class="aport-label">Responsables</span>
                        </button>
                        <div class="aport-content">
                            <div class="aport-content-inner">
                                Giber Garcia Alamo y equipo del archivo fotográfico.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="director-title-row">
                    <h3 class="director-title">Director</h3>
                    <div class="aportantes-divider"></div>
                </div>
                <div class="director-card">
                    <div class="director-avatar">
                        <img src="{{ asset('giber.png') }}" alt="Giber Garcia Alamo">
                    </div>
                    <p class="director-name">Giber Garcia Alamo</p>
                    <p class="director-role">Bibliotecologo</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ── FOOTER ───────────────────────────────────────────────────── -->
    <footer class="site-footer">
        <p>© 2024 FOTOTECA WARAS — Archivo Visual Ancashino</p>
        <p>Preservando, digitalizando y compartiendo la memoria fotográfica e histórica de nuestra región.</p>
    </footer>

    <script>
        const PLACEHOLDER = 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?auto=format&fit=crop&w=800&q=80';

        // ── DATOS DESDE LARAVEL ──────────────────────────────────────
        const photosByCategory  = @json($photosByCategory ?? []);
        const photographersData = @json($photographersData ?? []);
        const categoriesFromDB  = @json($categoriesForFilters ?? []);

        const allPhotosFlat = (() => {
            const seen = new Set(); const result = [];
            Object.values(photosByCategory).flat().forEach(p => {
                if (!seen.has(p.id)) { seen.add(p.id); result.push(p); }
            });
            return result;
        })();

        const serverActiveSection = @json($activeSection ?? 'Inicio');

        // ── ESTADO ───────────────────────────────────────────────────
        let state = {
            activeTab:       'Inicio',
            activeCategory:  { id: null, name: 'Todas' },
            openAccordions:  new Set(),
            closedAccordions: new Set()
        };

        // ── FILTRADO ─────────────────────────────────────────────────
        function getCurrentPhotos() {
            if (state.activeTab === 'Fotógrafos') return photographersData;
            let base = allPhotosFlat;
            if (state.activeCategory.id !== null) {
                const catName = state.activeCategory.name;
                base = photosByCategory[catName] || [];
            }
            const rawQ = document.getElementById('contentSearchInput')?.value?.trim();
            const q = rawQ ? rawQ.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'') : '';
            if (q) {
                const norm = s => (s||'').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');
                base = base.filter(p =>
                    norm(p.title).includes(q)||norm(p.photographer).includes(q)||
                    norm(p.description).includes(q)||norm(p.location).includes(q)||
                    norm(String(p.year)).includes(q)
                );
            }
            return base;
        }

        function getSortedPhotos(items) {
            const sortVal = document.getElementById('sortSelect')?.value ?? 'az';
            const arr = [...items];
            if (sortVal==='az') arr.sort((a,b)=>(a.title||a.full_name||'').localeCompare(b.title||b.full_name||'','es'));
            else if (sortVal==='recent') arr.sort((a,b)=>(parseInt(b.year)||0)-(parseInt(a.year)||0));
            else if (sortVal==='old') arr.sort((a,b)=>(parseInt(a.year)||9999)-(parseInt(b.year)||9999));
            else if (sortVal==='year_asc') arr.sort((a,b)=>(parseInt(a.year)||0)-(parseInt(b.year)||0));
            else if (sortVal==='year_desc') arr.sort((a,b)=>(parseInt(b.year)||0)-(parseInt(a.year)||0));
            return arr;
        }

        // ── RENDER GRILLA ────────────────────────────────────────────
        function renderPhotos() {
            const grid = document.getElementById('photosGrid');
            const items = getSortedPhotos(getCurrentPhotos());
            document.getElementById('photoCount').textContent = items.length;
            document.getElementById('sidebarPhotoCount').textContent = allPhotosFlat.length + ' fotografías catalogadas';

            if (state.activeTab === 'Fotógrafos') {
                grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(240px, 1fr))';
                grid.style.maxWidth = '1200px';
                grid.style.margin = '0 auto';
                grid.innerHTML = items.length === 0
                    ? `<div style="grid-column:1/-1;text-align:center;padding:4rem 0;color:var(--text-muted);">No hay fotógrafos registrados.</div>`
                    : items.map((p, i) => `
                        <div class="photographer-card" onclick="window.location.href='/fototeca/fotografos/${p.id}';sessionStorage.setItem('fototeca_tab','Fotógrafos')" style="animation-delay:${i*0.06}s">
                            <div class="pg-img-wrap">
                                <div class="pg-img-overlay"></div>
                                ${p.photo_path
                                    ? `<img src="${p.photo_path}" alt="${p.full_name}" class="pg-img" onerror="this.style.display='none'">`
                                    : `<div class="pg-placeholder"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg></div>`}
                                ${(() => { const yr = p.birth_year; const c = yr ? Math.ceil(yr/100) : null; const lbl = c ? 'Siglo '+({19:'XIX',20:'XX',21:'XXI'}[c]||c+'º') : null; return lbl ? `<span class="overlay-period-tag" style="position:absolute;top:0.75rem;right:0.75rem;">${lbl}</span>` : ''; })()}
                            </div>
                            <div class="pg-info">
                                <h3 class="pg-name">${p.full_name}</h3>
                                <p class="pg-bio">${p.biography || 'Sin biografía disponible.'}</p>
                                <div class="pg-footer">
                                    <span class="pg-footer-link">Ver colección</span>
                                    <span class="pg-count-badge">${p.photos_count} foto${p.photos_count!==1?'s':''}</span>
                                </div>
                            </div>
                        </div>`).join('');
                return;
            }


            grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(240px, 1fr))';
            grid.style.maxWidth = ''; grid.style.margin = '';
            if (items.length === 0) {
                grid.innerHTML = `<div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;padding:5rem 2rem;gap:1rem;color:var(--text-muted);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    <p style="font-family:'Playfair Display',serif;font-size:1.2rem;">Sin resultados</p>
                    <p style="font-size:0.85rem;">No se encontraron fotografías con los filtros aplicados.</p>
                    </div>`;
                return;
            }

            grid.innerHTML = items.map((photo, i) => `
                <div class="photo-card" data-index="${i}" style="animation-delay:${i*0.04}s">
                    <div class="photo-card-inner">
                        <div class="photo-card-img-wrap">
                            <div class="photo-corner photo-corner--tl"></div>
                            <div class="photo-corner photo-corner--br"></div>
                            <img src="${photo.image_url || PLACEHOLDER}" alt="${photo.title}"
                                 class="photo-card-img" loading="lazy"
                                 onerror="this.src='${PLACEHOLDER}'">
                            <div class="photo-card-overlay">
                                <div class="photo-card-overlay-content">
                                    <p class="overlay-year">${photo.year||'S/F'}</p>
                                    ${photo.location ? `<p class="overlay-location"><svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>${photo.location}</p>` : ''}
                                </div>
                            </div>
                            ${photo.year ? `<span class="photo-card-badge">${photo.year}</span>` : ''}
                        </div>
                        <div class="photo-card-info">
                            <h3 class="photo-card-title">${photo.title}</h3>
                            <div class="photo-card-meta">
                                ${photo.photographer ? `<span class="meta-photographer"><svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>${photo.photographer}</span>` : ''}
                                <div class="meta-categories">${(photo.categories||[]).slice(0,2).map(c=>`<span class="cat-badge">${c}</span>`).join('')}</div>
                            </div>
                        </div>
                    </div>
                </div>`).join('');

            document.querySelectorAll('#photosGrid .photo-card').forEach((card, i) => {
                card.addEventListener('click', () => {
                    if (items[i]?.detail_url) {
                        sessionStorage.setItem('fototeca_tab', state.activeTab);
                        window.location.href = items[i].detail_url;
                    }
                });
            });
        }

        // ── RENDER SIDEBAR ───────────────────────────────────────────
        function isAncestorOfActive(node, activeId) {
            if (!activeId || !node.children) return false;
            for (const child of node.children) {
                if (child.id === activeId) return true;
                if (isAncestorOfActive(child, activeId)) return true;
            }
            return false;
        }

        function buildNodeHtml(node, depth) {
            const hasChildren = node.children && node.children.length > 0;
            const manuallyClosed = state.closedAccordions.has(node.id);
            const isOpen = !manuallyClosed && (state.openAccordions.has(node.id) || isAncestorOfActive(node, state.activeCategory.id));
            const isActive = state.activeCategory.id === node.id;
            const indent = (2 + depth * 1) + 'rem';

            if (hasChildren) {
                const childrenHtml = node.children.map(child => buildNodeHtml(child, depth+1)).join('');
                return `<li>
                    <button class="accordion-btn ${isActive?'accordion-btn--active':''}" data-parent-id="${node.id}" style="padding-left:${indent}">
                        <svg class="accordion-icon" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                        <span class="accordion-btn-text">${node.name}</span>
                        <svg class="accordion-chevron ${isOpen?'open':''}" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="accordion-panel ${isOpen?'open':''}" style="padding-left:0.5rem;">
                        <ul style="list-style:none;padding:0;margin:0;">${childrenHtml}</ul>
                    </div>
                </li>`;
            } else {
                return `<li>
                    <button class="sidebar-leaf ${isActive?'active':''}" data-cat-id="${node.id}" data-cat-name="${node.name}" style="padding-left:${indent}">
                        <span class="leaf-dot"></span>${node.name}
                    </button>
                </li>`;
            }
        }

        function renderSidebar() {
            const list = document.getElementById('sidebarCategories');
            const todosActive = state.activeCategory.id === null;
            let html = `<li>
                <button class="accordion-btn ${todosActive?'accordion-btn--active':''}" id="acc-todos" style="padding-left:1rem;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span class="accordion-btn-text">Toda la Colección</span>
                </button>
            </li>`;
            if (categoriesFromDB.length > 0) {
                html += categoriesFromDB.map(node => buildNodeHtml(node, 0)).join('');
            } else {
                Object.keys(photosByCategory).forEach(name => {
                    const isActive = state.activeCategory.name === name;
                    html += `<li><button class="accordion-btn ${isActive?'accordion-btn--active':''}" data-cat-name="${name}" style="padding-left:1rem;"><span class="accordion-btn-text">${name}</span></button></li>`;
                });
            }
            list.innerHTML = html;

            list.querySelector('#acc-todos')?.addEventListener('click', () => {
                state.activeCategory = { id: null, name: 'Todas' };
                state.openAccordions.clear(); state.closedAccordions.clear();
                document.getElementById('sectionTitle').textContent = state.activeTab;
                document.getElementById('breadcrumbCurrent').textContent = state.activeTab;
                renderSidebar(); renderPhotos(); closeSidebar();
            });

            list.querySelectorAll('.accordion-btn[data-parent-id]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const pid = parseInt(btn.getAttribute('data-parent-id'));
                    const isCurrentlyOpen = btn.querySelector('.accordion-chevron')?.classList.contains('open');
                    if (isCurrentlyOpen) { state.openAccordions.delete(pid); state.closedAccordions.add(pid); }
                    else { state.closedAccordions.delete(pid); state.openAccordions.add(pid); }
                    renderSidebar();
                });
            });

            list.querySelectorAll('.sidebar-leaf[data-cat-id]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id   = parseInt(btn.getAttribute('data-cat-id'));
                    const name = btn.getAttribute('data-cat-name');
                    state.activeCategory = { id, name };
                    document.getElementById('sectionTitle').textContent = name;
                    document.getElementById('breadcrumbCurrent').textContent = name;
                    renderSidebar(); renderPhotos(); closeSidebar();
                });
            });

            list.querySelectorAll('.accordion-btn[data-cat-name]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const name = btn.getAttribute('data-cat-name');
                    state.activeCategory = { id: null, name };
                    document.getElementById('sectionTitle').textContent = name;
                    document.getElementById('breadcrumbCurrent').textContent = name;
                    renderSidebar(); renderPhotos(); closeSidebar();
                });
            });
        }

        // ── SECCIONES ────────────────────────────────────────────────
        function hideAllSections() {
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('inicioSection').classList.add('hidden');
            document.getElementById('galleryLayout').classList.add('hidden');
            document.getElementById('aportantesSection').style.display = 'none';
        }

        const TABS_NO_SIDEBAR = new Set(['Fotógrafos']);

        function showSection(tab) {
            state.activeTab = tab;
            state.activeCategory = { id: null, name: 'Todas' };
            state.openAccordions.clear(); state.closedAccordions.clear();
            hideAllSections();

            if (tab === 'Aportantes') {
                document.getElementById('aportantesSection').style.display = 'block';
            } else if (tab === 'Inicio') {
                document.getElementById('heroSection').classList.remove('hidden');
                document.getElementById('inicioSection').classList.remove('hidden');
            } else {
                const layout = document.getElementById('galleryLayout');
                layout.classList.remove('hidden');
                layout.classList.toggle('no-sidebar', TABS_NO_SIDEBAR.has(tab));
                document.getElementById('sidebar').classList.toggle('no-sidebar', TABS_NO_SIDEBAR.has(tab));
                document.getElementById('sectionTitle').textContent = tab;
                document.getElementById('breadcrumbCurrent').textContent = tab;
                document.getElementById('contentSearchInput').value = '';
                renderSidebar(); renderPhotos();
            }
            updateNav();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (window._updateNavBg) window._updateNavBg();
        }

        function updateNav() {
            document.querySelectorAll('.nav-item-btn').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-tab') === state.activeTab);
            });
            const tabUrlMap = {
                'Inicio':     '{{ route('fototeca.dashboard') }}',
                'Galería':    '{{ route('fototeca.galeria.index') }}',
                'Fotógrafos': '{{ route('fototeca.fotografos.index') }}',
                'Aportantes': '{{ route('fototeca.aportantes.index') }}',
            };
            if (tabUrlMap[state.activeTab]) history.replaceState(null, '', tabUrlMap[state.activeTab]);
        }

        // ── BÚSQUEDA HERO ────────────────────────────────────────────
        const heroInput    = document.getElementById('heroSearchInput');
        const heroDropdown = document.getElementById('heroDropdown');
        const heroBtn      = document.getElementById('heroSearchBtn');

        function normalizeStr(s) { return (s||'').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,''); }

        function renderHeroDropdown(q) {
            if (!q) { heroDropdown.classList.remove('open'); return; }
            const nq = normalizeStr(q);
            const seen = new Set();
            const unique = Object.values(photosByCategory).flat().filter(p => { if(seen.has(p.id)) return false; seen.add(p.id); return true; });
            const matchPhotos = unique.filter(p =>
                normalizeStr(p.title).includes(nq)||normalizeStr(p.photographer).includes(nq)||
                normalizeStr(p.location).includes(nq)||normalizeStr(String(p.year)).includes(nq)
            ).slice(0,5);
            const matchPhotographers = photographersData.filter(p =>
                normalizeStr(p.full_name).includes(nq)||normalizeStr(p.biography).includes(nq)
            ).slice(0,3);
            const total = matchPhotos.length + matchPhotographers.length;
            if (total === 0) {
                heroDropdown.innerHTML = `<div class="hsd-empty">Sin resultados para "<strong>${q}</strong>"</div>`;
                heroDropdown.classList.add('open'); return;
            }
            let html = '';
            if (matchPhotos.length) {
                html += `<div class="hsd-section-label">Fotografías</div>`;
                html += matchPhotos.map(p => `
                    <div class="hsd-item" data-action="photo" data-id="${p.id}">
                        <div class="hsd-thumb">${p.image_url ? `<img src="${p.image_url}" alt="" onerror="this.style.display='none'">` : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>'}</div>
                        <div class="hsd-info">
                            <div class="hsd-title">${p.title}</div>
                            <div class="hsd-sub">${p.photographer}${p.year&&p.year!=='S/F'?' · '+p.year:''}</div>
                        </div>
                        <span class="hsd-badge">Foto</span>
                    </div>`).join('');
            }
            if (matchPhotographers.length) {
                html += `<div class="hsd-section-label">Fotógrafos</div>`;
                html += matchPhotographers.map(p => `
                    <a class="hsd-item" href="/fototeca/fotografos/${p.id}">
                        <div class="hsd-thumb">${p.photo_path ? `<img src="${p.photo_path}" alt="">` : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'}</div>
                        <div class="hsd-info">
                            <div class="hsd-title">${p.full_name}</div>
                            <div class="hsd-sub">${p.photos_count} foto${p.photos_count!==1?'s':''}</div>
                        </div>
                        <span class="hsd-badge">Fotógrafo</span>
                    </a>`).join('');
            }
            html += `<button class="hsd-all-btn" id="hsdAllBtn">Ver todos los resultados para "${q}" →</button>`;
            heroDropdown.innerHTML = html;
            heroDropdown.classList.add('open');

            heroDropdown.querySelectorAll('.hsd-item[data-action="photo"]').forEach(el => {
                el.addEventListener('click', () => {
                    const id = parseInt(el.dataset.id);
                    const item = Object.values(photosByCategory).flat().find(p => p.id === id);
                    if (!item) return;
                    heroDropdown.classList.remove('open');
                    heroInput.value = '';
                    if (item.detail_url) { sessionStorage.setItem('fototeca_tab','Galería'); window.location.href = item.detail_url; }
                    else { showSection('Galería'); }
                });
            });

            document.getElementById('hsdAllBtn')?.addEventListener('click', () => {
                heroDropdown.classList.remove('open');
                showSection('Galería');
                const ci = document.getElementById('contentSearchInput');
                ci.value = q; ci.dispatchEvent(new Event('input'));
            });
        }

        heroInput.addEventListener('input', () => renderHeroDropdown(heroInput.value.trim()));
        heroBtn.addEventListener('click', () => {
            const q = heroInput.value.trim();
            heroDropdown.classList.remove('open');
            showSection('Galería');
            if (q) { const ci = document.getElementById('contentSearchInput'); ci.value = q; ci.dispatchEvent(new Event('input')); }
        });
        heroInput.addEventListener('keydown', e => { if(e.key==='Enter') heroBtn.click(); });
        document.addEventListener('click', e => { if (!e.target.closest('.hero-search-container')) heroDropdown.classList.remove('open'); });

        // ── EVENTOS ──────────────────────────────────────────────────
        document.getElementById('contentSearchInput')?.addEventListener('input', renderPhotos);
        document.getElementById('logoBtn')?.addEventListener('click', () => showSection('Inicio'));

        // ── SORT DROPDOWN ─────────────────────────────────────────────
        (function() {
            const btn      = document.getElementById('sortBtn');
            const dropdown = document.getElementById('sortDropdown');
            const label    = document.getElementById('sortLabel');
            const select   = document.getElementById('sortSelect');
            if (!btn) return;

            const labels = { az: 'Ordenar: A–Z', recent: 'Ordenar: Recientes', old: 'Ordenar: Antiguos', year_asc: 'Ordenar: Año ↑', year_desc: 'Ordenar: Año ↓' };

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                btn.classList.toggle('open');
                dropdown.classList.toggle('open');
            });

            dropdown.querySelectorAll('.sort-option').forEach(opt => {
                opt.addEventListener('click', () => {
                    const val = opt.dataset.value;
                    select.value = val;
                    label.textContent = labels[val];
                    dropdown.querySelectorAll('.sort-option').forEach(o => o.classList.remove('active'));
                    opt.classList.add('active');
                    btn.classList.remove('open');
                    dropdown.classList.remove('open');
                    renderPhotos();
                });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.sort-select-wrap')) {
                    btn.classList.remove('open');
                    dropdown.classList.remove('open');
                }
            });
        })();

        document.querySelectorAll('.nav-item-btn').forEach(btn => {
            btn.addEventListener('click', () => showSection(btn.getAttribute('data-tab')));
        });

        // ── SIDEBAR MÓVIL ────────────────────────────────────────────
        function openSidebar() {
            document.getElementById('sidebar').classList.add('sidebar--open');
            document.getElementById('sidebarOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('sidebar--open');
            document.getElementById('sidebarOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.getElementById('hamburgerBtn')?.addEventListener('click', openSidebar);
        document.getElementById('sidebarClose')?.addEventListener('click', closeSidebar);
        document.getElementById('sidebarOverlay')?.addEventListener('click', closeSidebar);

        // ── NAV TRANSPARENTE EN HERO ─────────────────────────────────
        (function() {
            const nav = document.getElementById('globalNav');

            function updateNavBg() {
                const isInicio = state.activeTab === 'Inicio';
                if (isInicio && window.scrollY < 60) {
                    nav.classList.add('nav-transparent');
                } else {
                    nav.classList.remove('nav-transparent');
                }
            }

            window.addEventListener('scroll', updateNavBg, { passive: true });

            // Exponer para que showSection lo llame al cambiar de tab
            window._updateNavBg = updateNavBg;
            updateNavBg();
        })();

        // ── NAV MÓVIL ────────────────────────────────────────────────
        (function() {
            const btn  = document.getElementById('globalNavHamburger');
            const menu = document.getElementById('globalNavMobile');
            if (!btn||!menu) return;
            btn.addEventListener('click', () => {
                const isOpen = menu.classList.contains('open');
                btn.classList.toggle('open', !isOpen);
                menu.classList.toggle('open', !isOpen);
            });
            document.addEventListener('click', e => {
                if (!btn.contains(e.target)&&!menu.contains(e.target)) {
                    btn.classList.remove('open'); menu.classList.remove('open');
                }
            });
        })();

        // ── APORTANTES ACORDEÓN ───────────────────────────────────────
        function toggleAportante(id) {
            document.querySelectorAll('#aportantesAccordion .aport-item').forEach(item => {
                const isTarget = item.getAttribute('data-id') === id;
                const btn     = item.querySelector('.aport-btn');
                const icon    = item.querySelector('.aport-icon');
                const content = item.querySelector('.aport-content');
                const isOpen  = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';
                if (isTarget) {
                    if (isOpen) {
                        content.style.maxHeight = '0px'; content.style.opacity = '0';
                        icon.textContent = '+'; btn.classList.remove('aport-active');
                    } else {
                        content.style.maxHeight = '1000px'; content.style.opacity = '1';
                        icon.textContent = '−'; btn.classList.add('aport-active');
                    }
                } else {
                    content.style.maxHeight = '0px'; content.style.opacity = '0';
                    icon.textContent = '+'; btn.classList.remove('aport-active');
                }
            });
        }
        window.toggleAportante = toggleAportante;

        // ========== CARRUSELES DE INICIO ==========
        (function() {
            const CARD_W_PHOTO  = 340 + 28;
            const CARD_W_AUTHOR = 150 + 20;

            const rawGaleria    = Object.values(photosByCategory).flat().filter((p, i, a) => a.findIndex(x => x.id === p.id) === i);
            const rawFotografos = photographersData;
            function photoCardHTML(photo) {
                return `<div class="ftc-carousel-card" onclick="window.location.href='${photo.detail_url}'">
                    ${photo.image_url
                        ? `<img class="ftc-card-cover" src="${photo.image_url}" alt="${photo.title}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="ftc-card-cover-placeholder">📷</div>`}
                    <div class="ftc-card-body">
                        <p class="ftc-card-title">${photo.title}</p>
                        <p class="ftc-card-sub">${photo.photographer}</p>
                    </div>
                </div>`;
            }

            function fotografoCardHTML(p) {
                return `<div class="ftc-author-card" onclick="window.location.href='/fototeca/fotografos/${p.id}'">
                    ${p.photo_path
                        ? `<img class="ftc-author-avatar" src="${p.photo_path}" alt="${p.full_name}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="ftc-author-placeholder">👤</div>`}
                    <div class="ftc-author-body">
                        <p class="ftc-author-name">${p.full_name}</p>
                        <p class="ftc-author-count">${p.photos_count} foto${p.photos_count !== 1 ? 's' : ''}</p>
                    </div>
                </div>`;
            }

            function shuffle(arr) {
                const a = [...arr];
                for (let i = a.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [a[i], a[j]] = [a[j], a[i]];
                }
                return a;
            }

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

                const base = shuffle(rawItems).slice(0, 20);
                const n    = base.length;

                const visibleCount = Math.ceil(window.innerWidth / cardW) + 2;
                const minTotal     = visibleCount * 7;
                const pool         = fillTo(base, minTotal);
                const total        = pool.length;

                track.innerHTML = pool.map(cardFn).join('');
                track.style.gap = '0';

                let current = Math.floor(total / 2);
                current = Math.round(current / n) * n;
                let busy = false;
                let autoTimer;

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

            const ftcCarousels = {};

            function initCarousels() {
                ftcCarousels.galeria    = buildCarousel('trackGaleria',    'dotsGaleria',    rawGaleria,    photoCardHTML,    CARD_W_PHOTO);
                ftcCarousels.fotografos = buildCarousel('trackFotografos', 'dotsFotografos', rawFotografos, fotografoCardHTML, CARD_W_AUTHOR);
            }

            window.moveFtcCarousel = function(name, dir) {
                const c = ftcCarousels[name];
                if (!c) return;
                clearInterval(c.autoTimer);
                c.go(c.current + dir);
                c.startAuto();
            };

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

            if (sec && !sec.classList.contains('hidden')) {
                initialized = true;
                initCarousels();
            }
        })();
        // ========== FIN CARRUSELES ==========

        // ── INICIO ───────────────────────────────────────────────────
        const validTabs = ['Inicio','Galería','Fotógrafos','Aportantes'];
        const pendingTab = sessionStorage.getItem('fototeca_tab');
        if (pendingTab && validTabs.includes(pendingTab)) {
            sessionStorage.removeItem('fototeca_tab');
            showSection(pendingTab);
        } else {
            showSection(validTabs.includes(serverActiveSection) ? serverActiveSection : 'Inicio');
        }
    </script>
    <x-floating-buttons />
</body>
</html>
