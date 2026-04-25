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
    @vite('resources/css/fototeca-foto.css')
</head>
<body>

{{-- Mobile nav --}}
<div class="g-mobile-nav" id="mobileNav">
    <button class="g-mobile-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''">✕</button>
    <a href="{{ route('fototeca.inicio') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Inicio')">Inicio</a>
    <a href="{{ route('fototeca.galeria.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
    <a href="{{ route('fototeca.fotografos.index') }}" class="g-mobile-link" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
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
