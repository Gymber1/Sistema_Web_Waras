<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Colecciones · Fototeca Digital Ancashina</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite('resources/css/fototeca-fotografo.css')
    <style>
        html, body { width: 100%; }
        .collections-page { width: 100%; max-width: 1280px; margin: 0 auto; padding: 4.5rem 2rem 5rem; min-height: 80vh; box-sizing: border-box; }
        .collections-header { margin-bottom: 2.5rem; }
        .collections-header h1 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #fff; font-weight: 500; margin-bottom: 0.5rem; }
        .collections-header p { font-size: 0.9rem; color: #666; }
        .collections-search { position: relative; margin-bottom: 2rem; width: 100%; max-width: 100%; box-sizing: border-box; display: block; }
        .collections-search input {
            display: block; width: 100%; padding: 0.9rem 1.2rem 0.9rem 3rem;
            background: #111; border: 1px solid #2a2a2a; border-radius: 10px;
            color: #fff; font-size: 0.9rem; outline: none;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .collections-search input:focus { border-color: #c9a84c; }
        .collections-search svg { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #555; pointer-events: none; flex-shrink: 0; }
        .collections-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; width: 100%; min-height: 1px; }
        .collection-card {
            background: #0e0e0e; border: 1px solid #1e1e1e; border-radius: 10px;
            overflow: hidden; text-decoration: none; display: block;
            transition: border-color 0.25s, transform 0.2s;
        }
        .collection-card:hover { border-color: #c9a84c; transform: translateY(-3px); }
        .collection-card-cover {
            aspect-ratio: 16/9; background: #111;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }
        .collection-card-cover img { width: 100%; height: 100%; object-fit: cover; }
        .collection-card-placeholder {
            color: #c9a84c; opacity: 0.3;
        }
        .collection-card-body { padding: 1rem 1.1rem 1.25rem; }
        .collection-card-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; color: #fff; margin-bottom: 0.4rem; }
        .collection-card-meta { font-size: 0.75rem; color: #666; display: flex; align-items: center; gap: 0.4rem; }
        .collection-card-count { font-size: 0.72rem; color: #c9a84c; font-style: italic; }
        .empty-collections { text-align: center; padding: 5rem 2rem; color: #444; }
        .empty-collections svg { color: #c9a84c; opacity: 0.3; margin-bottom: 1rem; }
        .empty-collections p { font-size: 1rem; }
        /* Paginación */
        .col-pagination { display: flex; align-items: center; justify-content: center; gap: 0.4rem; margin-top: 2.5rem; flex-wrap: wrap; }
        .col-page-btn { background: none; border: 1px solid #2a2a2a; color: #888; width: 36px; height: 36px; border-radius: 6px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif; }
        .col-page-btn:hover { border-color: #c9a84c; color: #c9a84c; }
        .col-page-btn.active { background: #c9a84c; border-color: #c9a84c; color: #000; font-weight: 600; }
        .col-page-ellipsis { color: #444; padding: 0 0.25rem; font-size: 0.85rem; }
    </style>
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
        <a href="{{ route('fototeca.inicio') }}" class="g-mobile-link">Inicio</a>
        <a href="{{ route('fototeca.galeria.index') }}" class="g-mobile-link">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-mobile-link">Fotógrafos</a>
        <a href="{{ route('fototeca.colecciones.index') }}" class="g-mobile-link active">Colecciones</a>
        <a href="{{ route('fototeca.aportantes.index') }}" class="g-mobile-link">Aportantes</a>
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

<div class="collections-page">
    <div class="collections-header">
        <h1>Colecciones Fotográficas</h1>
        <p>Archivos temáticos del patrimonio visual de la región Ancash</p>
    </div>

    @if($colecciones->count() > 0)
    <div class="collections-search">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="searchInput" placeholder="Buscar colección..." oninput="filterCollections(this.value)">
    </div>

    <div class="collections-grid" id="collectionsGrid">
        @foreach($colecciones as $col)
        <a href="{{ route('fototeca.colecciones.show', $col) }}" class="collection-card" data-title="{{ strtolower($col->title) }}"
           onclick="sessionStorage.setItem('back_url', window.location.href); sessionStorage.setItem('back_label', 'Colecciones')">
            <div class="collection-card-cover">
                @if($col->cover_image_path)
                    <img src="{{ Storage::url($col->cover_image_path) }}" alt="{{ $col->title }}" loading="lazy">
                @else
                    <div class="collection-card-placeholder">
                        <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    </div>
                @endif
            </div>
            <div class="collection-card-body">
                <p class="collection-card-title">{{ $col->title }}</p>
                @if($col->description)
                <p class="collection-card-meta" style="margin-bottom:0.5rem;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $col->description }}
                </p>
                @endif
                <p class="collection-card-count">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;vertical-align:middle;margin-right:3px;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    {{ $col->photos_count }} {{ $col->photos_count === 1 ? 'fotografía' : 'fotografías' }}
                </p>
            </div>
        </a>
        @endforeach
    </div>
    <p id="noResultsMsg" style="display:none;color:#555;font-size:0.9rem;padding:2rem 0;">No se encontraron colecciones con ese nombre.</p>
    <div class="col-pagination" id="colPagination"></div>
    @else
    <div class="empty-collections">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        <p>No hay colecciones publicadas aún.</p>
    </div>
    @endif
</div>

<footer class="g-footer">
    © 2024 FOTOTECA Digital Ancashina — Patrimonio Visual de la Región Ancash
</footer>

<script>
const PER_PAGE = 9;
let currentPage = 1;
let searchQuery = '';

function getCards() {
    return Array.from(document.querySelectorAll('#collectionsGrid .collection-card'));
}

function getFiltered() {
    return getCards().filter(c => !searchQuery || c.dataset.title.includes(searchQuery));
}

function renderPage() {
    const filtered = getFiltered();
    const total = filtered.length;
    const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * PER_PAGE;
    const visible = new Set(filtered.slice(start, start + PER_PAGE).map(c => c));

    getCards().forEach(c => c.style.display = visible.has(c) ? '' : 'none');

    // Mensaje sin resultados
    const noResults = document.getElementById('noResultsMsg');
    if (noResults) noResults.style.display = total === 0 && searchQuery ? '' : 'none';

    // Paginación
    const pag = document.getElementById('colPagination');
    if (!pag) return;
    if (totalPages <= 1) { pag.innerHTML = ''; return; }

    const range = (a, b) => Array.from({length: b - a + 1}, (_, i) => a + i);
    let pages;
    if (totalPages <= 7) {
        pages = range(1, totalPages);
    } else if (currentPage <= 4) {
        pages = [...range(1, 5), '…', totalPages];
    } else if (currentPage >= totalPages - 3) {
        pages = [1, '…', ...range(totalPages - 4, totalPages)];
    } else {
        pages = [1, '…', currentPage - 1, currentPage, currentPage + 1, '…', totalPages];
    }

    pag.innerHTML = pages.map(p => p === '…'
        ? `<span class="col-page-ellipsis">…</span>`
        : `<button class="col-page-btn${p === currentPage ? ' active' : ''}" onclick="goToPage(${p})">${p}</button>`
    ).join('');
}

function goToPage(p) {
    currentPage = p;
    renderPage();
    document.getElementById('collectionsGrid')?.scrollIntoView({behavior: 'smooth', block: 'start'});
}

function filterCollections(q) {
    searchQuery = q.toLowerCase().trim();
    currentPage = 1;
    renderPage();
}

// Init
renderPage();
</script>
<x-floating-buttons />
<script>document.addEventListener('contextmenu', e => { if (e.target.tagName === 'IMG') e.preventDefault(); });</script>
</body>
</html>
