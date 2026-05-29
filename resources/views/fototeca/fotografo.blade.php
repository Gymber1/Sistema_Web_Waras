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
    <div class="g-mobile-header">
        <a href="{{ route('fototeca.inicio') }}" class="g-mobile-brand">
            <span class="g-nav-brand-main">FOTOTECA</span>
            <span class="g-nav-brand-sub">Digital Ancashina</span>
        </a>
        <button class="g-mobile-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''">✕</button>
    </div>
    <nav class="g-mobile-links">
        <a href="{{ route('fototeca.inicio') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Inicio')">Inicio</a>
        <a href="{{ route('fototeca.galeria.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-mobile-link active" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
        <a href="{{ route('fototeca.donadores.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Donadores')">Donadores</a>
        <a href="{{ route('fototeca.colecciones.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Colecciones')">Colecciones</a>
        <a href="{{ route('fototeca.aportantes.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Aportantes')">Aportantes</a>
        <a href="{{ route('home') }}" class="g-mobile-link" style="opacity:0.7;font-size:0.68rem;">Portal Principal</a>
        @auth
            @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
            <a href="{{ route('admin.dashboard') }}" class="g-mobile-link g-mobile-admin">Panel Admin</a>
            @endif
        @endauth
    </nav>
</div>

{{-- Nav --}}
<nav class="g-nav">
    <a href="{{ route('fototeca.inicio') }}" class="g-nav-brand">
        <span class="g-nav-brand-main">FOTOTECA</span>
        <span class="g-nav-brand-sub">Digital Ancashina</span>
    </a>
    <div class="g-nav-links">
        <a href="{{ route('fototeca.inicio') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Inicio')">Inicio</a>
        <span class="nav-sep-foto" style="color:rgba(255,255,255,.25);font-size:.85rem;user-select:none;">|</span>
        <a href="{{ route('fototeca.galeria.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-nav-link active" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
        <a href="{{ route('fototeca.donadores.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Donadores')">Donadores</a>
        <a href="{{ route('fototeca.colecciones.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Colecciones')">Colecciones</a>
        <span class="nav-sep-foto" style="color:rgba(255,255,255,.25);font-size:.85rem;user-select:none;">|</span>
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

@php
$authorName = \Illuminate\Support\Str::words($photographer->full_name, 2, '');
$allCols = $photographer->collections->map(fn($c) => [
    'url'    => route('fototeca.colecciones.show', $c),
    'cover'  => $c->cover_image_path ? Storage::url($c->cover_image_path) : null,
    'title'  => $c->title,
    'photographer' => $c->description ?: $photographer->full_name,
    'count'  => $c->photos->count(),
])->values()->toArray();
@endphp

<div style="max-width:1280px;margin:3rem auto 0;padding:0 2rem 5rem;">

    {{-- Header + buscador --}}
    <div class="gallery-context-bar" style="margin-bottom:2rem;">
        <div class="gallery-context-line"></div>
        <h2 class="gallery-context-title">Colecciones de {{ $authorName }}</h2>
        <span class="gallery-context-count" id="col-count-label">{{ $photographer->collections->count() }} colección(es)</span>
        <div class="gallery-context-line"></div>
    </div>

    <div style="display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;">
        <div style="position:relative;width:100%;max-width:400px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);pointer-events:none;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="col-search" placeholder="Buscar colección..."
                oninput="colSearch(this.value)"
                style="width:100%;padding:9px 14px 9px 34px;background:#111;border:1px solid #2a2a2a;border-radius:8px;color:#fff;font-size:.875rem;outline:none;transition:border-color .2s;box-sizing:border-box;"
                onfocus="this.style.borderColor='#c9a84c'" onblur="this.style.borderColor='#2a2a2a'">
        </div>
    </div>

    {{-- Grid --}}
    <div id="col-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;">
    </div>

    {{-- Sin resultados --}}
    <div id="col-no-results" style="display:none;text-align:center;padding:3rem 0;color:#555;font-size:.9rem;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.2" style="opacity:.3;display:block;margin:0 auto .75rem"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        No se encontraron colecciones.
    </div>

    {{-- Paginación --}}
    <div id="col-pagination" style="display:flex;align-items:center;justify-content:center;gap:.4rem;margin-top:2rem;flex-wrap:wrap;"></div>
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

<style>
@media(max-width:1024px){ #col-grid{ grid-template-columns:repeat(3,1fr)!important; } }
@media(max-width:640px){  #col-grid{ grid-template-columns:repeat(2,1fr)!important; } }
@media(max-width:400px){  #col-grid{ grid-template-columns:1fr!important; } }
.col-page-btn { background:none;border:1px solid #2a2a2a;color:#888;width:32px;height:32px;border-radius:6px;font-size:.8rem;cursor:pointer;transition:all .2s;font-family:inherit; }
.col-page-btn:hover { border-color:#c9a84c;color:#c9a84c; }
.col-page-btn.active { background:#c9a84c;border-color:#c9a84c;color:#000;font-weight:700; }
</style>

<script>
(function(){
    const allCols  = @json($allCols ?? []);
    const backUrl  = window.location.href;
    const backLabel = @json($photographer->full_name);
    const PER_PAGE = 8;
    let filtered   = allCols.slice();
    let page       = 1;

    function cardHtml(c) {
        const img = c.cover
            ? `<img src="${c.cover}" alt="${c.title}" style="width:100%;height:100%;object-fit:cover;" loading="lazy">`
            : `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.2" style="opacity:.25"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>`;
        return `<a href="${c.url}" onclick="sessionStorage.setItem('back_url','${backUrl}');sessionStorage.setItem('back_label',${JSON.stringify(backLabel)})"
            style="background:#0e0e0e;border:1px solid #1e1e1e;border-radius:10px;overflow:hidden;text-decoration:none;display:block;transition:border-color .25s,transform .2s;"
            onmouseover="this.style.borderColor='#c9a84c';this.style.transform='translateY(-3px)'"
            onmouseout="this.style.borderColor='#1e1e1e';this.style.transform=''">
            <div style="aspect-ratio:16/9;background:#111;display:flex;align-items:center;justify-content:center;overflow:hidden;">${img}</div>
            <div style="padding:.9rem 1rem 1.1rem;">
                <p style="font-family:'Playfair Display',serif;font-size:1rem;color:#fff;margin-bottom:.35rem;">${c.title}</p>
                <p style="font-size:.72rem;color:#c9a84c;font-style:italic;display:flex;align-items:center;gap:4px;">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    ${c.count} ${c.count === 1 ? 'fotografía' : 'fotografías'}
                </p>
            </div>
        </a>`;
    }

    function render() {
        const grid = document.getElementById('col-grid');
        const noRes = document.getElementById('col-no-results');
        const pag   = document.getElementById('col-pagination');
        const label = document.getElementById('col-count-label');

        if (filtered.length === 0) {
            grid.innerHTML = '';
            noRes.style.display = '';
            pag.innerHTML = '';
            if (label) label.textContent = '0 colección(es)';
            return;
        }
        noRes.style.display = 'none';
        if (label) label.textContent = filtered.length + ' colección(es)';

        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        if (page > totalPages) page = totalPages;
        const start = (page - 1) * PER_PAGE;
        grid.innerHTML = filtered.slice(start, start + PER_PAGE).map(cardHtml).join('');

        // Paginación
        if (totalPages <= 1) { pag.innerHTML = ''; return; }
        let html = '';
        for (let p = 1; p <= totalPages; p++) {
            html += `<button class="col-page-btn${p===page?' active':''}" onclick="colGoPage(${p})">${p}</button>`;
        }
        pag.innerHTML = html;
    }

    window.colSearch = function(q) {
        const t = q.toLowerCase().trim();
        filtered = t ? allCols.filter(c => c.title.toLowerCase().includes(t)) : allCols.slice();
        page = 1;
        render();
    };

    window.colGoPage = function(p) {
        page = p;
        render();
        document.getElementById('col-grid')?.scrollIntoView({behavior:'smooth', block:'start'});
    };

    render();
})();
</script>

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
<script>document.addEventListener('contextmenu', e => { if (e.target.tagName === 'IMG') e.preventDefault(); });</script>
</body>
</html>
