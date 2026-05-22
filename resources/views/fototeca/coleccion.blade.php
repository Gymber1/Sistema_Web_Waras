<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $special->title }} · Fototeca Digital Ancashina</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite('resources/css/fototeca-fotografo.css')
    <style>
        .col-page { max-width: 1280px; margin: 0 auto; padding: calc(64px + 2rem) 2rem 5rem; }
        .col-breadcrumb { display: flex; align-items: center; gap: 0.5rem; font-size: 0.78rem; color: #555; margin-bottom: 2rem; }
        .col-breadcrumb a { color: #555; text-decoration: none; transition: color 0.2s; }
        .col-breadcrumb a:hover { color: #c9a84c; }
        .col-breadcrumb-sep { color: #333; }

        /* Hero */
        .col-hero {
            display: grid; grid-template-columns: 260px 1fr; gap: 2rem;
            background: #0e0e0e; border: 1px solid #1e1e1e; border-radius: 12px;
            overflow: hidden; margin-bottom: 3rem;
        }
        @media (max-width: 640px) { .col-hero { grid-template-columns: 1fr; } }
        .col-hero-cover {
            aspect-ratio: 4/3; background: #111;
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .col-hero-cover img { width: 100%; height: 100%; object-fit: cover; }
        .col-hero-placeholder { color: #c9a84c; opacity: 0.25; }
        .col-hero-body { padding: 2rem 2rem 2rem 0; display: flex; flex-direction: column; justify-content: center; }
        .col-badge { display: inline-block; background: rgba(201,168,76,0.15); color: #c9a84c; border: 1px solid rgba(201,168,76,0.3); font-size: 0.65rem; letter-spacing: 0.12em; text-transform: uppercase; padding: 0.3rem 0.75rem; border-radius: 20px; margin-bottom: 0.9rem; }
        .col-title { font-family: 'Playfair Display', serif; font-size: 2rem; color: #fff; font-weight: 500; margin-bottom: 0.75rem; line-height: 1.2; }
        .col-desc { font-size: 0.88rem; color: #888; line-height: 1.7; margin-bottom: 1rem; }
        .col-count { font-size: 0.8rem; color: #666; display: flex; align-items: center; gap: 0.4rem; }
        .col-count span { color: #c9a84c; font-family: 'Playfair Display', serif; font-size: 1.1rem; }

        /* Search */
        .col-search { position: relative; margin-bottom: 2rem; }
        .col-search input {
            width: 100%; padding: 0.85rem 1.2rem 0.85rem 3rem;
            background: #0e0e0e; border: 1px solid #2a2a2a; border-radius: 8px;
            color: #fff; font-size: 0.88rem; outline: none; transition: border-color 0.2s;
        }
        .col-search input:focus { border-color: #c9a84c; }
        .col-search svg { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #555; pointer-events: none; }

        /* Section header */
        .col-section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .col-section-title { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: #c9a84c; font-weight: 400; }
        .col-section-count { font-size: 0.75rem; color: #555; }
    </style>
</head>
<body>

{{-- Mobile nav --}}
<div class="g-mobile-nav" id="mobileNav">
    <button class="g-mobile-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''">✕</button>
    <a href="{{ route('fototeca.inicio') }}" class="g-mobile-link">Inicio</a>
    <a href="{{ route('fototeca.galeria.index') }}" class="g-mobile-link">Galería</a>
    <a href="{{ route('fototeca.fotografos.index') }}" class="g-mobile-link">Fotógrafos</a>
    <a href="{{ route('fototeca.colecciones.index') }}" class="g-mobile-link active">Colecciones</a>
    <a href="{{ route('fototeca.aportantes.index') }}" class="g-mobile-link">Aportantes</a>
</div>

{{-- Nav --}}
<nav class="g-nav">
    <a href="{{ route('fototeca.inicio') }}" class="g-nav-brand">
        <span class="g-nav-brand-main">FOTOTECA</span>
        <span class="g-nav-brand-sub">Digital Ancashina</span>
    </a>
    <div class="g-nav-links">
        <a href="{{ route('fototeca.inicio') }}" class="g-nav-link">Inicio</a>
        <a href="{{ route('fototeca.galeria.index') }}" class="g-nav-link">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-nav-link">Fotógrafos</a>
        <a href="{{ route('fototeca.colecciones.index') }}" class="g-nav-link active">Colecciones</a>
        <a href="{{ route('fototeca.aportantes.index') }}" class="g-nav-link">Aportantes</a>
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

<div class="col-page">

    {{-- Botón atrás --}}
    <a id="backBtn" href="{{ route('fototeca.colecciones.index') }}"
       style="display:inline-flex;align-items:center;gap:0.5rem;color:#c9a84c;font-size:0.88rem;text-decoration:none;margin-bottom:1.75rem;transition:opacity 0.2s;font-family:'Inter',sans-serif;opacity:0.85;"
       onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        <span id="backBtnLabel">Volver</span>
    </a>

    {{-- Hero --}}
    <div class="col-hero">
        <div class="col-hero-cover">
            @if($special->cover_image_path)
                <img src="{{ Storage::url($special->cover_image_path) }}" alt="{{ $special->title }}">
            @else
                <div class="col-hero-placeholder">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </div>
            @endif
        </div>
        <div class="col-hero-body">
            <span class="col-badge">Colección Fotográfica</span>
            <h1 class="col-title">{{ $special->title }}</h1>
            @if($special->description)
            <p class="col-desc" style="display:flex;align-items:center;gap:0.4rem;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><strong>Fotógrafo:</strong> {{ $special->description }}</span>
            </p>
            @endif
            <div class="col-count">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <span>{{ $special->photos->count() }}</span>
                {{ $special->photos->count() === 1 ? 'fotografía en esta colección' : 'fotografías en esta colección' }}
            </div>
        </div>
    </div>

    {{-- Búsqueda --}}
    @if($special->photos->count() > 0)
    <div class="col-search">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="searchInput" placeholder="Buscar en esta colección..." oninput="filterPhotos(this.value)">
    </div>
    @endif

    {{-- Grid de fotos --}}
    <div class="col-section-header">
        <h2 class="col-section-title">Fotografías de la colección</h2>
        <span class="col-section-count" id="photoCount">{{ $special->photos->count() }} elementos</span>
    </div>

    @if($special->photos->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        </div>
        <h2 class="empty-title">Colección vacía</h2>
        <p class="empty-desc">Esta colección no tiene fotografías asignadas aún.</p>
        <a id="emptyBackBtn" href="{{ route('fototeca.colecciones.index') }}" class="empty-btn">Volver</a>
    </div>
    @else
    <div class="photo-grid" id="photosGrid">
        @foreach($special->photos as $photo)
        <article class="photo-card"
                 data-title="{{ strtolower($photo->title) }}"
                 style="animation-delay: {{ $loop->index * 0.04 }}s"
                 onclick="sessionStorage.setItem('back_url', window.location.href); sessionStorage.setItem('back_label', '{{ addslashes($special->title) }}'); window.location.href='{{ route('fototeca.galeria.show', $photo) }}'">
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
                        <p class="overlay-year">{{ $photo->year_type === 'range' && $photo->year_from ? $photo->year_from.'–'.($photo->year_to ?? '?') : ($photo->year ?? 'S/F') }}</p>
                        @if($photo->location)
                        <p class="overlay-location">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                            {{ is_object($photo->location) ? $photo->location->name : $photo->location }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="photo-card-info">
                <p class="photo-card-year">{{ $photo->year_type === 'range' && $photo->year_from ? $photo->year_from.'–'.($photo->year_to ?? '?') : ($photo->year ?? 'S/F') }}</p>
                <h3 class="photo-card-title">{{ $photo->title }}</h3>
                @if($photo->photographers->first())
                <p style="font-size:0.68rem;color:var(--text-muted,#666);margin-top:0.2rem;">{{ $photo->photographers->first()->full_name }}</p>
                @endif
            </div>
        </article>
        @endforeach
    </div>
    @endif

</div>

<footer class="g-footer">
    © 2024 FOTOTECA Digital Ancashina — Patrimonio Visual de la Región Ancash
</footer>

<script>
(function() {
    const backUrl   = sessionStorage.getItem('back_url');
    const backLabel = sessionStorage.getItem('back_label');
    const defaultUrl = '{{ route('fototeca.colecciones.index') }}';
    const url = backUrl || defaultUrl;

    ['backBtn', 'emptyBackBtn'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.href = url;
    });

    const lbl = document.getElementById('backBtnLabel');
    if (lbl) lbl.textContent = backLabel ? 'Volver a ' + backLabel : 'Volver';

    if (backUrl) {
        sessionStorage.removeItem('back_url');
        sessionStorage.removeItem('back_label');
    }
})();

function filterPhotos(q) {
    q = q.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('#photosGrid .photo-card').forEach(card => {
        const match = !q || card.dataset.title.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('photoCount').textContent = visible + ' elementos';
}
</script>
<x-floating-buttons />
<script>document.addEventListener('contextmenu', e => { if (e.target.tagName === 'IMG') e.preventDefault(); });</script>
</body>
</html>
