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
    @vite('resources/css/fototeca-fotografo.css')
</head>
<body>

{{-- Mobile nav --}}
<div class="g-mobile-nav" id="mobileNav">
    <button class="g-mobile-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''">✕</button>
    <a href="{{ route('fototeca.inicio') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Inicio')">Inicio</a>
    <a href="{{ route('fototeca.galeria.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
    <a href="{{ route('fototeca.fotografos.index') }}" class="g-mobile-link active" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
    <a href="{{ route('fototeca.colecciones.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Colecciones')">Colecciones</a>
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
        <a href="{{ route('fototeca.colecciones.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Colecciones')">Colecciones</a>
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

{{-- Profile Header --}}
<div class="profile-header">
    <a id="backBtn" href="{{ route('fototeca.fotografos.index') }}" class="back-btn">← Volver</a>

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
                <span class="stat-value">{{ $photographer->collections->count() }}</span>
                <span class="stat-label">Colecciones</span>
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

{{-- Collections --}}
@if($photographer->collections->count() > 0)
<div class="gallery-context-bar">
    <div class="gallery-context-line"></div>
    <h2 class="gallery-context-title">Colecciones de {{ \Illuminate\Support\Str::words($photographer->full_name, 2, '') }}</h2>
    <span class="gallery-context-count">{{ $photographer->collections->count() }} colección(es)</span>
    <div class="gallery-context-line"></div>
</div>

<div style="max-width:1280px;margin:0 auto;padding:0 2rem 4rem;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
    @foreach($photographer->collections as $col)
    <a href="{{ route('fototeca.colecciones.show', $col) }}"
       onclick="sessionStorage.setItem('back_url', window.location.href); sessionStorage.setItem('back_label', '{{ addslashes($photographer->full_name) }}')"
       style="background:#0e0e0e;border:1px solid #1e1e1e;border-radius:10px;overflow:hidden;text-decoration:none;display:block;transition:border-color 0.25s,transform 0.2s;"
       onmouseover="this.style.borderColor='#c9a84c';this.style.transform='translateY(-3px)'"
       onmouseout="this.style.borderColor='#1e1e1e';this.style.transform='translateY(0)'">
        <div style="aspect-ratio:16/9;background:#111;display:flex;align-items:center;justify-content:center;overflow:hidden;">
            @if($col->cover_image_path)
                <img src="{{ Storage::url($col->cover_image_path) }}" alt="{{ $col->title }}"
                     style="width:100%;height:100%;object-fit:cover;" loading="lazy">
            @else
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.2" style="opacity:0.25"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            @endif
        </div>
        <div style="padding:1rem 1.1rem 1.25rem;">
            <p style="font-family:'Playfair Display',serif;font-size:1.05rem;color:#fff;margin-bottom:0.4rem;">{{ $col->title }}</p>
            @if($col->description)
            <p style="font-size:0.75rem;color:#666;margin-bottom:0.5rem;line-height:1.4;">{{ Str::limit($col->description, 70) }}</p>
            @endif
            <p style="font-size:0.72rem;color:#c9a84c;font-style:italic;display:flex;align-items:center;gap:4px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                {{ $col->photos->count() }} {{ $col->photos->count() === 1 ? 'fotografía' : 'fotografías' }}
            </p>
        </div>
    </a>
    @endforeach
</div>

@else
<div class="empty-state">
    <div class="empty-icon">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
    </div>
    <h2 class="empty-title">Sin colecciones asignadas</h2>
    <p class="empty-desc">Este fotógrafo aún no tiene colecciones fotográficas asignadas.</p>
    <a id="backBtnEmpty" href="{{ route('fototeca.fotografos.index') }}" class="empty-btn">← Volver</a>
</div>
@endif

<footer class="g-footer">
    © 2024 FOTOTECA Digital Ancashina — Patrimonio Visual de la Región Ancash
</footer>

<script>
    // Back button — sabe de dónde vino
    (function() {
        const backUrl   = sessionStorage.getItem('back_url');
        const backLabel = sessionStorage.getItem('back_label');
        const defaultUrl = '{{ route('fototeca.fotografos.index') }}';
        const defaultLabel = 'Fotógrafos';

        ['backBtn', 'backBtnEmpty'].forEach(id => {
            const btn = document.getElementById(id);
            if (!btn) return;
            if (backUrl) {
                btn.href = backUrl;
                btn.textContent = '← Volver a ' + (backLabel || defaultLabel);
                sessionStorage.removeItem('back_url');
                sessionStorage.removeItem('back_label');
            } else {
                btn.href = defaultUrl;
                btn.textContent = '← Volver a ' + defaultLabel;
            }
        });
    })();

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
