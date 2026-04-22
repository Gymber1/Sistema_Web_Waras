<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $photo->title }} · Fototeca Digital Ancashina</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-page:       #0a0a0a;
            --bg-surface:    #141414;
            --bg-card:       #1a1a1a;
            --gold:          #c5a66d;
            --gold-hover:    #d4b783;
            --text-primary:  #f0f0f0;
            --text-secondary:#cccccc;
            --text-muted:    #888888;
            --text-accent:   #c5a66d;
            --border-line:   #2a2a2a;
            --border-gold:   rgba(197,166,109,0.4);
            --radius-card:   8px;
            --nav-h:         64px;
            /* nav/footer */
            --nav-bg:        rgba(0,0,0,0.85);
            --nav-border:    #2a2a2a;
            --nav-text:      #888888;
            --nav-text-hover:#f0f0f0;
            --nav-accent:    #c5a66d;
            /* legacy aliases */
            --wood-light:    #c5a66d;
            --wood-mid:      #c5a66d;
            --wood-dark:     #1a1a1a;
            --sepia-light:   #f0f0f0;
            --border-subtle: #2a2a2a;
            --border-medium: #2a2a2a;
            --border-strong: #c5a66d;
        }

        html, body { font-family: 'Inter', sans-serif; background: var(--bg-page); color: var(--text-primary); min-height: 100vh; display: flex; flex-direction: column; line-height: 1.6; }

        /* ── NAV (oscuro) ── */
        .g-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
            height: var(--nav-h);
            background: var(--nav-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--nav-border);
            display: flex; align-items: center;
            padding: 0 1.5rem; gap: 2rem;
        }
        .g-nav-brand {
            display: flex; flex-direction: column;
            text-decoration: none; white-space: nowrap;
            background: none; border: none; cursor: pointer;
            text-align: left;
        }
        .g-nav-brand-main {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 700;
            color: #ffffff; letter-spacing: 0.15em;
            text-transform: uppercase; line-height: 1;
        }
        .g-nav-brand-sub {
            font-size: 0.6rem; letter-spacing: 0.3em;
            text-transform: uppercase; color: var(--nav-accent);
            margin-top: 2px;
        }
        .g-nav-links { display: flex; gap: 2rem; align-items: center; margin: 0 auto; }
        .g-nav-link {
            font-size: 0.7rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.2em;
            color: var(--nav-text); text-decoration: none;
            padding-bottom: 2px;
            border-bottom: 2px solid transparent;
            transition: color 0.2s, border-color 0.2s;
        }
        .g-nav-link:hover { color: #ffffff; }
        .g-nav-link.active { color: #ffffff; border-bottom-color: var(--gold); }
        .g-nav-actions { display: flex; gap: 0.5rem; align-items: center; }
        .g-nav-btn {
            font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.15em;
            padding: 0.4rem 1rem; border-radius: 2px; text-decoration: none;
            border: 1px solid var(--border-line); color: #ffffff;
            transition: all 0.2s; white-space: nowrap; display: flex; align-items: center; gap: 0.35rem;
        }
        .g-nav-btn:hover { background: #ffffff; color: #000000; }
        .g-nav-btn.solid { background: var(--gold); color: #000; border-color: var(--gold); font-weight: 700; }
        .g-nav-btn.solid:hover { background: var(--gold-hover); border-color: var(--gold-hover); }
        .g-hamburger { display: none; background: none; border: none; color: #a89880; cursor: pointer; padding: 0.5rem; }
        .g-mobile-nav {
            display: none; position: fixed; inset: 0; z-index: 500;
            background: rgba(18,15,12,0.97); flex-direction: column;
            align-items: center; justify-content: center; gap: 2rem;
        }
        .g-mobile-nav.open { display: flex; }
        .g-mobile-close { position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; color: #a89880; cursor: pointer; font-size: 1.5rem; }
        .g-mobile-link { color: #f0e4d0; text-decoration: none; font-size: 1.3rem; font-family: 'Playfair Display', serif; letter-spacing: 0.08em; }
        @media (max-width: 768px) {
            .g-nav-links { display: none; }
            .g-nav-actions { display: none; }
            .g-hamburger { display: flex; }
        }

        /* ── PHOTO CORNERS ── */
        .photo-corner {
            position: absolute; width: 14px; height: 14px; z-index: 2; pointer-events: none;
        }
        .photo-corner--tl { top: 6px; left: 6px; border-top: 2px solid var(--wood-light); border-left: 2px solid var(--wood-light); }
        .photo-corner--br { bottom: 6px; right: 6px; border-bottom: 2px solid var(--wood-light); border-right: 2px solid var(--wood-light); }

        /* ── PAGE BODY ── */
        .page-body {
            flex: 1;
            margin-top: var(--nav-h);
            max-width: 1200px;
            width: 100%;
            margin-left: auto; margin-right: auto;
            padding: 2rem 1.5rem 4rem;
        }

        /* ── BREADCRUMB ── */
        .breadcrumb {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.75rem; color: #999;
            margin-bottom: 1.75rem;
        }
        .breadcrumb a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
        .breadcrumb a:hover { color: var(--gold); }
        .breadcrumb-sep { opacity: 0.5; }
        .breadcrumb-current { color: var(--text-secondary); }

        /* ── DETAIL LAYOUT ── */
        .detail-layout {
            display: flex;
            gap: 0;
            background: var(--bg-card);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-card);
            overflow: hidden;
        }

        /* Photo panel */
        .photo-panel {
            flex: 2;
            background: #1a1410;
            min-height: 500px;
            display: flex; align-items: center; justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .main-photo {
            max-width: 100%; max-height: 78vh;
            object-fit: contain; display: block;
        }
        .photo-placeholder {
            width: 100%; height: 500px;
            display: flex; align-items: center; justify-content: center;
            color: var(--border-strong);
        }
        .photo-zoom-hint {
            position: absolute; bottom: 1rem; right: 1rem;
            font-size: 0.65rem; color: var(--text-muted);
            background: rgba(0,0,0,0.5); padding: 0.3rem 0.65rem; border-radius: 20px;
            backdrop-filter: blur(4px); border: 1px solid var(--border-subtle);
            display: flex; align-items: center; gap: 0.3rem;
        }

        /* Info panel */
        .info-panel {
            flex: 0 0 360px;
            min-width: 300px;
            background: var(--bg-surface);
            border-left: 1px solid var(--border-line);
            padding: 2rem;
            display: flex; flex-direction: column;
            overflow-y: auto;
            max-height: 78vh;
        }

        .info-badge {
            display: inline-block; width: fit-content;
            font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.1em;
            font-weight: 600;
            color: var(--text-accent);
            background: rgba(201,149,106,0.1);
            border: 1px solid var(--border-medium);
            padding: 0.2rem 0.65rem; border-radius: 2px;
            margin-bottom: 1rem;
        }

        .photo-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 600;
            color: #ffffff; line-height: 1.2;
            margin-bottom: 0.85rem;
        }

        .photographer-line {
            display: flex; align-items: center; gap: 0.5rem;
            color: var(--text-muted); font-size: 0.875rem;
            margin-bottom: 1.25rem; padding-bottom: 1.25rem;
            border-bottom: 1px dashed var(--border-line);
        }
        .photographer-link {
            color: var(--gold); text-decoration: none;
            font-weight: 500; font-family: 'Libre Baskerville', serif;
            font-style: italic;
            transition: color 0.2s;
        }
        .photographer-link:hover { color: var(--gold-hover); text-decoration: underline; }

        .meta-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1.1rem;
            margin-bottom: 1.5rem;
        }
        .meta-item { display: flex; flex-direction: column; gap: 0.2rem; }
        .meta-label {
            font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.1em;
            color: var(--text-muted); font-weight: 600;
        }
        .meta-value {
            font-size: 0.875rem; color: var(--text-secondary);
            display: flex; align-items: center; gap: 0.35rem;
        }

        .desc-block { margin-bottom: 1.25rem; }
        .desc-label {
            font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.1em;
            color: var(--text-muted); font-weight: 600; margin-bottom: 0.45rem;
        }
        .desc-text {
            font-size: 0.88rem; color: var(--text-muted);
            line-height: 1.75;
            padding: 0.85rem 1rem;
            background: var(--bg-card);
            border-left: 2px solid var(--border-line);
            border-radius: 0 3px 3px 0;
            font-style: italic;
        }

        .cats { display: flex; flex-wrap: wrap; gap: 0.35rem; margin-bottom: 1.25rem; }
        .cat-badge {
            font-size: 0.65rem; color: var(--text-muted);
            background: rgba(201,149,106,0.08);
            border: 1px solid var(--border-subtle);
            padding: 0.2rem 0.55rem; border-radius: 2px;
        }

        .archive-note {
            margin-top: auto;
            padding-top: 1.25rem;
            border-top: 1px dashed var(--border-line);
            font-size: 0.72rem; color: #555;
            font-style: italic;
        }

        .actions {
            display: flex; gap: 0.6rem;
            margin-top: 1.25rem;
        }
        .btn-action {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            padding: 0.6rem 1.2rem;
            font-size: 0.72rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.08em;
            border-radius: 3px; border: 1px solid var(--border-medium);
            cursor: pointer; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-action-primary {
            background: var(--gold); color: #000;
            border-color: var(--gold); flex: 1; font-weight: 700;
        }
        .btn-action-primary:hover { background: var(--gold-hover); border-color: var(--gold-hover); }
        .btn-action-icon {
            background: transparent; color: var(--text-muted);
            width: 2.5rem; padding: 0;
        }
        .btn-action-icon:hover { color: var(--text-accent); border-color: var(--border-strong); }

        .share-toast {
            display: none; font-size: 0.72rem; color: var(--text-accent);
            margin-top: 0.5rem; text-align: center;
        }

        /* ── LIGHTBOX ── */
        .lightbox {
            display: none;
            position: fixed; inset: 0; z-index: 1000;
            background: rgba(0,0,0,0.95);
            align-items: center; justify-content: center;
            cursor: zoom-out;
        }
        .lightbox.open { display: flex; }
        .lightbox-img {
            max-width: 92vw; max-height: 92vh;
            object-fit: contain;
            border-radius: 4px;
            box-shadow: 0 0 60px rgba(0,0,0,0.8);
            transform-origin: center;
            transition: transform 0.2s ease;
            cursor: zoom-in;
            user-select: none;
        }
        .lightbox-img.zoomed { transform: scale(2); cursor: zoom-out; }
        .lightbox-close {
            position: fixed; top: 1.25rem; right: 1.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff; font-size: 1.2rem;
            width: 2.25rem; height: 2.25rem;
            border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s;
            z-index: 1001;
        }
        .lightbox-close:hover { background: rgba(255,255,255,0.2); }
        .lightbox-hint {
            position: fixed; bottom: 1.25rem; left: 50%; transform: translateX(-50%);
            font-size: 0.65rem; color: rgba(255,255,255,0.4);
            letter-spacing: 0.1em; text-transform: uppercase;
            pointer-events: none;
        }

        /* ── RELACIONADAS ── */
        .related-section {
            max-width: 1280px; margin: 0 auto; padding: 3.5rem 2rem 4rem;
        }
        .related-header {
            display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;
        }
        .related-line { flex: 1; height: 1px; background: var(--border-line); }
        .related-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 400; color: var(--text-secondary);
            white-space: nowrap;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        .related-card {
            border-radius: 6px; overflow: hidden; cursor: pointer;
            border: 1px solid var(--border-line);
            background: var(--bg-card);
            transition: border-color 0.25s ease;
            text-decoration: none; display: block;
            transform: translateZ(0);
        }
        .related-card:hover { border-color: var(--border-gold); }
        .related-card-img-wrap {
            position: relative; aspect-ratio: 4/3; overflow: hidden; background: #111;
            transform: translateZ(0);
        }
        .related-card-img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.4s ease;
            will-change: transform;
        }
        .related-card:hover .related-card-img { transform: scale(1.06); }
        .related-card-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,10,10,0.85) 0%, transparent 55%);
            opacity: 0; transition: opacity 0.25s ease;
            display: flex; align-items: flex-end; padding: 0.75rem;
            will-change: opacity;
        }
        .related-card:hover .related-card-overlay { opacity: 1; }
        .related-card-year { font-size: 0.68rem; color: var(--gold); font-style: italic; }
        .related-card-info { padding: 0.75rem 0.85rem; }
        .related-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 0.85rem; color: #fff; line-height: 1.3;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            transition: color 0.2s;
        }
        .related-card:hover .related-card-title { color: var(--gold); }
        .related-card-author {
            font-size: 0.65rem; color: var(--text-muted); margin-top: 0.3rem;
        }

        /* ── FOOTER ── */
        .g-footer {
            background: var(--bg-page);
            border-top: 1px solid var(--border-line);
            padding: 1.5rem 2rem;
            text-align: center;
            font-size: 0.75rem; color: var(--text-muted);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .detail-layout { flex-direction: column; }
            .info-panel { flex: unset; min-width: unset; max-height: unset; border-left: none; border-top: 1px solid var(--border-line); }
            .photo-panel { min-height: 280px; }
        }
        @media (max-width: 600px) {
            .page-body { padding: 1.25rem 1rem 3rem; }
            .photo-title { font-size: 1.3rem; }
            .meta-grid { grid-template-columns: 1fr; gap: 0.75rem; }
        }
    </style>
</head>
<body>

{{-- Mobile nav --}}
<div class="g-mobile-nav" id="mobileNav">
    <button class="g-mobile-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''">✕</button>
    <a href="{{ route('fototeca.inicio') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Inicio')">Inicio</a>
    <a href="{{ route('fototeca.galeria.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
    <a href="{{ route('fototeca.fotografos.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
    <a href="{{ route('fototeca.especiales.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Especiales')">Especiales</a>
    <a href="{{ route('fototeca.aportantes.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Aportantes')">Aportantes</a>
</div>

{{-- Nav --}}
<nav class="g-nav">
    <a href="{{ route('fototeca.inicio') }}" class="g-nav-brand">
        <span class="g-nav-brand-main">FOTOTECA</span>
        <span class="g-nav-brand-sub">Digital Ancashina</span>
    </a>
    <div class="g-nav-links">
        <a href="{{ route('fototeca.inicio') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Inicio')">Inicio</a>
        <a href="{{ route('fototeca.galeria.index') }}" class="g-nav-link active" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
        <a href="{{ route('fototeca.especiales.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Especiales')">Especiales</a>
        <a href="{{ route('fototeca.aportantes.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Aportantes')">Aportantes</a>
        <a href="{{ route('home') }}" class="g-nav-btn">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Portal Principal
        </a>
        @auth
            @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
            <a href="{{ route('admin.dashboard') }}" class="g-nav-btn solid">Panel</a>
            @endif
        @endauth
    </div>
    <button class="g-hamburger" onclick="document.getElementById('mobileNav').classList.add('open');document.body.style.overflow='hidden'" aria-label="Menú">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
</nav>

<div class="page-body">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a id="breadcrumbBack" href="{{ route('fototeca.dashboard') }}">Inicio</a>
        <span class="breadcrumb-sep">›</span>
        <a id="breadcrumbSection" href="{{ route('fototeca.dashboard') }}">Galería</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">{{ Str::limit($photo->title, 50) }}</span>
    </div>

    <div class="detail-layout">

        {{-- Foto --}}
        <div class="photo-panel">
            <div class="photo-corner photo-corner--tl"></div>
            <div class="photo-corner photo-corner--br"></div>
            @if($photo->image_url)
                <img src="{{ $photo->image_url }}"
                     alt="{{ $photo->title }}"
                     class="main-photo"
                     onerror="this.style.display='none'">
            @elseif($photo->image_path)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->image_path) }}"
                     alt="{{ $photo->title }}"
                     class="main-photo"
                     onerror="this.style.display='none'">
            @else
                <div class="photo-placeholder">
                    <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </div>
            @endif
            <div class="photo-zoom-hint">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                Ampliar
            </div>
        </div>

        {{-- Info --}}
        <div class="info-panel">
            <span class="info-badge">{{ $photo->format ?: ($photo->source_type ?: 'Archivo') }}</span>

            <h1 class="photo-title">{{ $photo->title }}</h1>

            @if($photo->photographers->count())
            <div class="photographer-line">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <span>
                    @foreach($photo->photographers as $i => $photographer)
                        @if($i > 0), @endif
                        <a href="{{ route('fototeca.fotografos.show', $photographer) }}" class="photographer-link">{{ $photographer->full_name }}</a>
                    @endforeach
                </span>
            </div>
            @endif

            <div class="meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Año / Fecha</span>
                    <span class="meta-value">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $photo->year ?? 'S/F' }}
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Ubicación</span>
                    <span class="meta-value">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        {{ is_object($photo->location) ? $photo->location->name : ($photo->location ?: '—') }}
                    </span>
                </div>
                @if($photo->resolution)
                <div class="meta-item">
                    <span class="meta-label">Resolución</span>
                    <span class="meta-value">{{ $photo->resolution }}</span>
                </div>
                @endif
                @if($photo->format)
                <div class="meta-item">
                    <span class="meta-label">Formato</span>
                    <span class="meta-value">{{ $photo->format }}</span>
                </div>
                @endif
                @if($photo->source_archive)
                <div class="meta-item" style="grid-column: 1 / -1;">
                    <span class="meta-label">Archivo fuente</span>
                    <span class="meta-value" style="font-size:0.8rem;">{{ $photo->source_archive }}</span>
                </div>
                @endif
            </div>

            @if($photo->description)
            <div class="desc-block">
                <p class="desc-label">Descripción del archivo</p>
                <p class="desc-text">{{ $photo->description }}</p>
            </div>
            @endif

            @if($photo->categories->count())
            <div class="cats">
                @foreach($photo->categories as $cat)
                <span class="cat-badge">{{ $cat->name }}</span>
                @endforeach
            </div>
            @endif

            <div class="archive-note">
                Documento del patrimonio fotográfico de la región Ancash · Fototeca Digital Ancashina
            </div>

            <div class="actions">
                @if($photo->source_type === 'external' && $photo->external_url)
                    <a href="{{ $photo->external_url }}" target="_blank" rel="noopener" class="btn-action btn-action-primary">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        Ver Original
                    </a>
                @else
                    <button class="btn-action btn-action-primary" onclick="window.print()">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        Imprimir / Guardar
                    </button>
                @endif
                <button id="btnShare" class="btn-action btn-action-icon" title="Copiar enlace">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                </button>
            </div>
            <div id="shareToast" class="share-toast">✓ Enlace copiado al portapapeles</div>
        </div>
    </div>
</div>

<!-- ── LIGHTBOX MODAL ── -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Visor de imagen">
    <button class="lightbox-close" id="lightboxClose" title="Cerrar (Esc)">✕</button>
    <img src="" alt="" class="lightbox-img" id="lightboxImg" draggable="false">
    <p class="lightbox-hint">Clic para ampliar · Esc para cerrar</p>
</div>

@if($related->count())
<section class="related-section">
    <div class="related-header">
        <span class="related-line"></span>
        <h2 class="related-title">Más del Archivo</h2>
        <span class="related-line"></span>
    </div>
    <div class="related-grid">
        @foreach($related as $rel)
        <a href="{{ route('fototeca.galeria.show', $rel->id) }}" class="related-card">
            <div class="related-card-img-wrap">
                @if($rel->thumbnail_url || $rel->image_url)
                    <img src="{{ $rel->thumbnail_url ?? $rel->image_url }}" alt="{{ $rel->title }}" class="related-card-img" loading="lazy">
                @endif
                <div class="related-card-overlay">
                    <span class="related-card-year">{{ $rel->year ?? 'S/F' }}</span>
                </div>
            </div>
            <div class="related-card-info">
                <p class="related-card-title">{{ $rel->title }}</p>
                @if($rel->photographers->first())
                <p class="related-card-author">{{ $rel->photographers->first()->full_name }}</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

<footer class="g-footer">
    © 2024 FOTOTECA Digital Ancashina — Patrimonio Visual de la Región Ancash
</footer>

<script>
    (function() {
        const tab  = sessionStorage.getItem('fototeca_tab') || 'Galería';
        const base = '{{ route('fototeca.dashboard') }}';
        document.getElementById('breadcrumbBack').href  = base + '#' + tab;
        const bc = document.getElementById('breadcrumbSection');
        bc.href = base + '#' + tab;
        bc.textContent = tab;
    })();

    document.getElementById('btnShare').addEventListener('click', () => {
        const url = window.location.href;
        const toast = document.getElementById('shareToast');
        navigator.clipboard.writeText(url).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = url; document.body.appendChild(ta); ta.select();
            document.execCommand('copy'); document.body.removeChild(ta);
        }).finally(() => {
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 2500);
        });
    });

    // ── LIGHTBOX ─────────────────────────────────────────────────
    (function() {
        const lightbox     = document.getElementById('lightbox');
        const lightboxImg  = document.getElementById('lightboxImg');
        const lightboxClose = document.getElementById('lightboxClose');
        const mainPhoto    = document.querySelector('.main-photo');
        const zoomHint     = document.querySelector('.photo-zoom-hint');

        function openLightbox() {
            if (!mainPhoto) return;
            lightboxImg.src = mainPhoto.src;
            lightboxImg.alt = mainPhoto.alt;
            lightboxImg.classList.remove('zoomed');
            lightbox.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('open');
            lightboxImg.classList.remove('zoomed');
            document.body.style.overflow = '';
        }

        if (zoomHint) {
            zoomHint.style.cursor = 'pointer';
            zoomHint.addEventListener('click', openLightbox);
        }
        if (mainPhoto) {
            mainPhoto.style.cursor = 'zoom-in';
            mainPhoto.addEventListener('click', openLightbox);
        }

        lightboxClose.addEventListener('click', closeLightbox);

        lightboxImg.addEventListener('click', (e) => {
            e.stopPropagation();
            lightboxImg.classList.toggle('zoomed');
            const hint = lightbox.querySelector('.lightbox-hint');
            if (hint) hint.style.opacity = lightboxImg.classList.contains('zoomed') ? '0' : '1';
        });

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLightbox();
        });
    })();
</script>
<x-floating-buttons />
</body>
</html>
