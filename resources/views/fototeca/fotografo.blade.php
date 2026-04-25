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
        <a href="{{ route('fototeca.galeria.index') }}" class="g-nav-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-nav-link active" onclick="sessionStorage.setItem('fototeca_tab','Fotógrafos')">Fotógrafos</a>
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
