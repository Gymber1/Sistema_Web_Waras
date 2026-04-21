<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $photographer->full_name }} · Fototeca Digital Ancashina</title>
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

        html, body { font-family: 'Inter', sans-serif; background: var(--bg-page); color: var(--text-primary); min-height: 100vh; }
        body { display: flex; flex-direction: column; }

        /* ── NAV (oscuro) ── */
        .g-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
            height: var(--nav-h);
            background: var(--nav-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--nav-border);
            display: flex; align-items: center;
            padding: 0 1.5rem;
            gap: 2rem;
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
            font-size: 0.7rem; font-weight: 500;
            text-transform: uppercase; letter-spacing: 0.2em;
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

        /* ── PROFILE HEADER ── */
        .profile-header {
            display: flex;
            gap: 3rem;
            padding: 3rem;
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border-line);
            align-items: flex-start;
            position: relative;
            margin-top: var(--nav-h);
        }

        .back-btn {
            position: absolute;
            top: 1.5rem; right: 2rem;
            color: var(--text-muted); text-decoration: none;
            font-size: 0.78rem;
            display: flex; align-items: center; gap: 0.4rem;
            transition: color 0.2s, border-color 0.2s;
            border: 1px solid var(--border-line);
            padding: 0.35rem 0.75rem;
            border-radius: 4px;
            background: var(--bg-card);
        }
        .back-btn:hover { color: var(--gold); border-color: var(--border-gold); }

        .profile-avatar-wrap {
            width: 220px; height: 220px;
            flex-shrink: 0;
            border-radius: var(--radius-card);
            overflow: hidden;
            border: 1px solid var(--border-medium);
            position: relative;
        }
        .profile-avatar {
            width: 100%; height: 100%;
            object-fit: cover;
            filter: grayscale(0.3) contrast(1.05);
            transition: filter 0.4s ease;
        }
        .profile-avatar-wrap:hover .profile-avatar { filter: none; }
        .profile-avatar-placeholder {
            width: 100%; height: 100%;
            background: var(--bg-sidebar);
            display: flex; align-items: center; justify-content: center;
            color: var(--border-strong);
        }

        .profile-info { flex: 1; }
        .profile-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem; color: var(--sepia-light);
            margin-bottom: 0.5rem; font-weight: 700; line-height: 1.1;
        }
        .profile-meta {
            font-family: 'Libre Baskerville', serif;
            font-style: italic;
            color: var(--text-accent); font-size: 0.95rem;
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
        }
        .profile-meta-sep { opacity: 0.4; }

        .profile-dates-block {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 0.75rem 2rem;
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            background: var(--bg-card);
            border-radius: 6px;
            border: 1px solid var(--border-line);
            max-width: 500px;
            font-size: 0.82rem;
        }
        .profile-dates-item { display: flex; flex-direction: column; gap: 0.15rem; }
        .profile-dates-label { font-size: 0.67rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); }
        .profile-dates-value { color: var(--text-secondary); }

        .profile-bio {
            font-size: 0.92rem; line-height: 1.85;
            color: var(--text-secondary); max-width: 780px; margin-bottom: 1.5rem;
        }

        .profile-critique {
            font-size: 0.88rem; line-height: 1.75;
            color: var(--text-muted); font-style: italic;
            padding: 1rem 1.25rem;
            border-left: 3px solid var(--gold);
            margin-bottom: 1.5rem; max-width: 780px;
            background: var(--bg-card);
            border-radius: 0 4px 4px 0;
        }
        .profile-critique-label {
            font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em;
            color: var(--text-accent); margin-bottom: 0.5rem;
            font-style: normal; font-weight: 600;
        }

        .profile-stats {
            display: flex; gap: 1.5rem;
            border-top: 1px dashed var(--border-medium);
            padding-top: 1.5rem; max-width: 780px;
        }
        .stat-item { display: flex; flex-direction: column; color: var(--text-muted); }
        .stat-value {
            font-size: 1.5rem; font-weight: 600;
            color: var(--sepia-light);
            font-family: 'Playfair Display', serif; line-height: 1;
        }
        .stat-label { font-size: 0.66rem; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 0.25rem; }

        /* ── GALLERY CONTEXT BAR ── */
        .gallery-context-bar {
            display: flex; align-items: center; gap: 1.25rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-subtle);
        }
        .gallery-context-line { flex: 1; height: 1px; background: var(--border-subtle); }
        .gallery-context-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; font-weight: 500;
            color: var(--text-muted); letter-spacing: 0.08em;
            white-space: nowrap;
        }
        .gallery-context-count {
            font-size: 0.72rem; color: var(--text-muted);
            border: 1px solid var(--border-subtle);
            padding: 0.2rem 0.65rem; border-radius: 20px; white-space: nowrap;
        }

        /* ── PHOTO GRID ── */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .photo-card {
            background: var(--bg-card);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-card);
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease, border-color 0.3s ease;
            animation: cardIn 0.5s ease both;
        }
        .photo-card:hover {
            transform: translateY(-4px);
            border-color: rgba(197,166,109,0.5);
        }
        .photo-card-img-wrap {
            position: relative;
            aspect-ratio: 4/3;
            overflow: hidden;
            background: #111;
        }
        .photo-card-img {
            width: 100%; height: 100%; object-fit: cover;
            display: block;
            filter: none;
            transition: transform 0.7s ease;
        }
        .photo-card:hover .photo-card-img {
            transform: scale(1.05);
        }
        .photo-card-img-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            color: var(--border-strong); font-size: 2.5rem;
        }

        .photo-card-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(18,12,6,0.85) 0%, transparent 55%);
            opacity: 0; transition: opacity 0.3s ease;
            display: flex; align-items: flex-end;
        }
        .photo-card:hover .photo-card-overlay { opacity: 1; }
        .photo-card-overlay-content { padding: 1rem; width: 100%; }
        .overlay-year { font-size: 0.75rem; color: var(--sepia-mid); font-family: 'Libre Baskerville', serif; font-style: italic; }
        .overlay-location {
            font-size: 0.7rem; color: var(--text-secondary);
            display: flex; align-items: center; gap: 0.3rem; margin-top: 0.2rem;
        }
        .overlay-period-tag {
            display: inline-block; margin-top: 0.4rem;
            font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.08em;
            background: rgba(201,149,106,0.2); color: var(--text-accent);
            padding: 0.15rem 0.5rem; border-radius: 2px;
        }

        .photo-card-info { padding: 0.85rem 1rem; background: var(--bg-card); }
        .photo-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 0.92rem; color: #fff;
            margin-bottom: 0.4rem;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            transition: color 0.2s;
        }
        .photo-card:hover .photo-card-title { color: var(--gold); }
        .photo-card-meta { display: flex; flex-wrap: wrap; gap: 0.3rem; }
        .cat-badge {
            font-size: 0.62rem; color: var(--text-muted);
            background: rgba(201,149,106,0.08);
            border: 1px solid var(--border-subtle);
            padding: 0.15rem 0.45rem; border-radius: 2px;
        }
        .photo-card-year {
            font-size: 0.72rem; color: var(--text-muted);
            font-family: 'Libre Baskerville', serif; font-style: italic;
            margin-bottom: 0.35rem;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 5rem 2rem; text-align: center;
        }
        .empty-icon { color: var(--border-strong); margin-bottom: 1.5rem; }
        .empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; color: var(--text-muted); margin-bottom: 0.75rem;
        }
        .empty-desc { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem; }
        .empty-btn {
            display: inline-block; padding: 0.6rem 1.5rem;
            border: 1px solid var(--border-medium); border-radius: 4px;
            color: var(--text-accent); text-decoration: none; font-size: 0.82rem;
            transition: all 0.2s;
        }
        .empty-btn:hover { background: rgba(201,149,106,0.1); }

        /* ── PAGINATION ── */
        .pagination-wrap {
            padding: 2rem; display: flex; justify-content: center;
            border-top: 1px solid var(--border-subtle);
        }
        .pagination-wrap nav span, .pagination-wrap nav a {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 2rem; height: 2rem; padding: 0 0.5rem;
            font-size: 0.8rem; border-radius: 3px;
            border: 1px solid var(--border-subtle); margin: 0 0.1rem;
            color: var(--text-muted); text-decoration: none; transition: all 0.2s;
        }
        .pagination-wrap nav a:hover { border-color: var(--border-medium); color: var(--text-accent); }
        .pagination-wrap nav span[aria-current] { background: var(--gold); color: #000; border-color: var(--gold); font-weight: 700; }

        /* ── FOOTER ── */
        .g-footer {
            background: var(--bg-page);
            border-top: 1px solid var(--border-line);
            padding: 1.5rem 2rem;
            text-align: center;
            font-size: 0.75rem; color: var(--text-muted);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .profile-header { flex-direction: column; padding: 2rem; gap: 1.5rem; }
            .profile-avatar-wrap { width: 160px; height: 160px; }
            .profile-name { font-size: 1.8rem; }
            .back-btn { position: static; margin-bottom: 0.5rem; }
            .profile-stats { flex-wrap: wrap; gap: 1rem; }
            .photo-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; padding: 1.25rem; }
        }
        @media (max-width: 480px) {
            .profile-header { padding: 1.25rem; }
            .profile-avatar-wrap { width: 120px; height: 120px; }
            .profile-name { font-size: 1.5rem; }
            .profile-bio { font-size: 0.88rem; }
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
        <a href="{{ route('fototeca.galeria.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-nav-link active" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
        <a href="{{ route('fototeca.especiales.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Especiales')">Especiales</a>
        <a href="{{ route('fototeca.aportantes.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Aportantes')">Aportantes</a>
    </div>
    <div class="g-nav-actions">
        <a href="{{ route('home') }}" class="g-nav-btn">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Portal
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

{{-- Profile Header --}}
<div class="profile-header">
    <a href="{{ route('fototeca.fotografos.index') }}" class="back-btn">← Volver a Fotógrafos</a>

    <div class="profile-avatar-wrap">
        <div class="photo-corner photo-corner--tl"></div>
        <div class="photo-corner photo-corner--br"></div>
        @if($photographer->photo_path)
            <img src="{{ Storage::url($photographer->photo_path) }}"
                 alt="{{ $photographer->full_name }}"
                 class="profile-avatar">
        @else
            <div class="profile-avatar-placeholder">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            </div>
        @endif
    </div>

    <div class="profile-info">
        <h1 class="profile-name">{{ $photographer->full_name }}</h1>

        <div class="profile-meta">
            @if($photographer->birth_date || $photographer->death_date)
            <span>
                {{ $photographer->birth_date?->year ?? '?' }}
                &ndash;
                {{ $photographer->death_date?->year ?? 'presente' }}
            </span>
            @endif
            @if($photographer->birth_place)
            <span class="profile-meta-sep">|</span>
            <span>{{ $photographer->birth_place }}</span>
            @endif
        </div>

        @if($photographer->birth_date || $photographer->death_date || $photographer->birth_place || $photographer->death_place)
        <div class="profile-dates-block">
            @if($photographer->birth_date)
            <div class="profile-dates-item">
                <span class="profile-dates-label">Fecha de nacimiento</span>
                <span class="profile-dates-value">{{ $photographer->birth_date->format('d/m/Y') }}</span>
            </div>
            @endif
            @if($photographer->birth_place)
            <div class="profile-dates-item">
                <span class="profile-dates-label">Lugar de nacimiento</span>
                <span class="profile-dates-value">{{ $photographer->birth_place }}</span>
            </div>
            @endif
            @if($photographer->death_date)
            <div class="profile-dates-item">
                <span class="profile-dates-label">Fecha de fallecimiento</span>
                <span class="profile-dates-value">{{ $photographer->death_date->format('d/m/Y') }}</span>
            </div>
            @endif
            @if($photographer->death_place)
            <div class="profile-dates-item">
                <span class="profile-dates-label">Lugar de fallecimiento</span>
                <span class="profile-dates-value">{{ $photographer->death_place }}</span>
            </div>
            @endif
        </div>
        @endif

        <p class="profile-bio">
            {{ $photographer->biography ?? ($photographer->bio ?? 'Biografía no disponible.') }}
        </p>

        @if($photographer->studies_critique)
        <div class="profile-critique">
            <div class="profile-critique-label">Crítica y Estudios</div>
            {{ $photographer->studies_critique }}
        </div>
        @endif

        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-value">{{ $photographer->photos->count() }}</span>
                <span class="stat-label">Fotografías</span>
            </div>
            @if($photographer->birth_date && $photographer->death_date)
            <div class="stat-item">
                <span class="stat-value">{{ $photographer->death_date->year - $photographer->birth_date->year }}</span>
                <span class="stat-label">Años de vida</span>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Gallery --}}
@if($photographer->photos->count() > 0)
<div class="gallery-context-bar">
    <div class="gallery-context-line"></div>
    <h2 class="gallery-context-title">Archivo de {{ \Illuminate\Support\Str::words($photographer->full_name, 2, '') }}</h2>
    <span class="gallery-context-count">{{ $photographer->photos->count() }} fotografía(s) catalogada(s)</span>
    <div class="gallery-context-line"></div>
</div>

<div class="photo-grid">
    @foreach($photographer->photos as $photo)
    <article class="photo-card"
             style="animation-delay: {{ $loop->index * 0.05 }}s"
             onclick="window.location.href='{{ route('fototeca.galeria.show', $photo) }}'">
        <div class="photo-card-img-wrap">
            <div class="photo-corner photo-corner--tl"></div>
            <div class="photo-corner photo-corner--br"></div>

            @if($photo->thumbnail_url)
                <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}" class="photo-card-img" loading="lazy">
            @elseif($photo->image_url)
                <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="photo-card-img" loading="lazy">
            @else
                <div class="photo-card-img-placeholder">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </div>
            @endif

            <div class="photo-card-overlay">
                <div class="photo-card-overlay-content">
                    <p class="overlay-year">{{ $photo->year ?? 'S/F' }}</p>
                    @if($photo->location)
                    <p class="overlay-location">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        {{ is_object($photo->location) ? $photo->location->name : $photo->location }}
                    </p>
                    @endif
                    @if($photo->format)
                    <span class="overlay-period-tag">{{ $photo->format }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="photo-card-info">
            <p class="photo-card-year">{{ $photo->year ?? 'S/F' }}</p>
            <h3 class="photo-card-title">{{ $photo->title }}</h3>
            @if($photo->categories->count())
            <div class="photo-card-meta">
                @foreach($photo->categories->take(3) as $cat)
                <span class="cat-badge">{{ $cat->name }}</span>
                @endforeach
            </div>
            @endif
        </div>
    </article>
    @endforeach
</div>

@else
<div class="empty-state">
    <div class="empty-icon">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
    </div>
    <h2 class="empty-title">Archivo Vacío</h2>
    <p class="empty-desc">No se encontraron fotografías digitalizadas para este fotógrafo.</p>
    <a href="{{ route('fototeca.fotografos.index') }}" class="empty-btn">← Volver a Fotógrafos</a>
</div>
@endif

<footer class="g-footer">
    © 2024 FOTOTECA Digital Ancashina — Patrimonio Visual de la Región Ancash
</footer>

<script>
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const hashIdx = href.indexOf('#');
            if (hashIdx !== -1) {
                const base = href.substring(0, hashIdx);
                const tab  = href.substring(hashIdx + 1);
                if (tab) {
                    e.preventDefault();
                    sessionStorage.setItem('fototeca_tab', tab);
                    window.location.href = base;
                }
            }
        });
    });
</script>
<x-floating-buttons />
</body>
</html>
