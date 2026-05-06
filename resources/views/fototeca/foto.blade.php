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
        <a href="{{ route('fototeca.galeria.index') }}" class="g-nav-link active" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
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
                        {{ $photo->year_type === 'range' && $photo->year_from ? $photo->year_from.'–'.($photo->year_to ?? '?') : ($photo->year ?? 'S/F') }}
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Ubicación</span>
                    <span class="meta-value">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        {{ is_object($photo->location) ? $photo->location->name : ($photo->location ?: '—') }}
                    </span>
                </div>
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
                @endif
                <button id="btnShare" class="btn-action btn-action-primary" onclick="openShareModal()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                    Compartir
                </button>
            </div>
            <div id="shareToast" class="share-toast">✓ Enlace copiado al portapapeles</div>
        </div>
    </div>
</div>

<!-- ── SHARE MODAL ── -->
<div id="shareModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.8);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:1rem;" onclick="if(event.target===this)closeShareModal()">
    <div style="background:#1c1c1c;border:1px solid #2e2e2e;border-radius:14px;width:100%;max-width:400px;padding:1.5rem;box-shadow:0 24px 64px rgba(0,0,0,0.7);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.4rem;">
            <span style="font-family:'Playfair Display',serif;font-size:1rem;color:#fff;font-weight:500;">Compartir fotografía</span>
            <button onclick="closeShareModal()" style="background:none;border:none;color:#888;cursor:pointer;padding:0.3rem;border-radius:6px;display:flex;align-items:center;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <p style="font-size:0.75rem;color:#666;margin-bottom:1.25rem;border-bottom:1px solid #2a2a2a;padding-bottom:0.75rem;line-height:1.4;">{{ $photo->title }}</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.65rem;">
            <a id="share-facebook" href="#" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:0.6rem;padding:0.7rem 0.9rem;border-radius:8px;background:#1877f2;color:#fff;text-decoration:none;font-size:0.82rem;font-weight:500;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                Facebook
            </a>
            <a id="share-twitter" href="#" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:0.6rem;padding:0.7rem 0.9rem;border-radius:8px;background:#0f0f0f;color:#fff;text-decoration:none;font-size:0.82rem;font-weight:500;border:1px solid #333;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                X / Twitter
            </a>
            <a id="share-whatsapp" href="#" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:0.6rem;padding:0.7rem 0.9rem;border-radius:8px;background:#25d366;color:#fff;text-decoration:none;font-size:0.82rem;font-weight:500;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM11.999 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.878-1.404A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.522 2 12 2z"/></svg>
                WhatsApp
            </a>
            <button onclick="copyShareLink()" style="display:flex;align-items:center;gap:0.6rem;padding:0.7rem 0.9rem;border-radius:8px;background:#2a2a2a;color:#ccc;font-size:0.82rem;font-weight:500;border:1px solid #3a3a3a;cursor:pointer;transition:opacity 0.2s;width:100%;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                Copiar enlace
            </button>
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
    <div class="related-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;">
        @foreach($related as $rel)
        <a href="{{ route('fototeca.galeria.show', $rel->id) }}" class="related-card">
            <div class="related-card-img-wrap">
                @if($rel->thumbnail_url || $rel->image_url)
                    <img src="{{ $rel->thumbnail_url ?? $rel->image_url }}" alt="{{ $rel->title }}" class="related-card-img" loading="lazy">
                @endif
                <div class="related-card-overlay">
                    <span class="related-card-year">{{ $rel->year_type === 'range' && $rel->year_from ? $rel->year_from.'–'.($rel->year_to ?? '?') : ($rel->year ?? 'S/F') }}</span>
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

    function openShareModal() {
        const url  = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ addslashes($photo->title) }} · Fototeca Digital Ancashina');
        document.getElementById('share-facebook').href  = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
        document.getElementById('share-twitter').href   = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
        document.getElementById('share-whatsapp').href  = `https://wa.me/?text=${text}%20${url}`;
        const modal = document.getElementById('shareModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeShareModal() {
        document.getElementById('shareModal').style.display = 'none';
        document.body.style.overflow = '';
    }
    function copyShareLink() {
        const url   = window.location.href;
        const toast = document.getElementById('shareToast');
        navigator.clipboard.writeText(url).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = url; document.body.appendChild(ta); ta.select();
            document.execCommand('copy'); document.body.removeChild(ta);
        }).finally(() => {
            closeShareModal();
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 2500);
        });
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeShareModal();
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
