<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $special->title }} — Fototeca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/fototeca-especial.css')
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
        <a href="{{ route('fototeca.donadores.index') }}" class="g-mobile-link">Donadores</a>
        <a href="{{ route('fototeca.colecciones.index') }}" class="g-mobile-link">Colecciones</a>
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
        <span class="nav-sep-foto" style="color:rgba(255,255,255,.25);font-size:.85rem;user-select:none;">|</span>
        <a href="{{ route('fototeca.galeria.index') }}" class="g-nav-link">Galería</a>
        <a href="{{ route('fototeca.fotografos.index') }}" class="g-nav-link">Fotógrafos</a>
        <a href="{{ route('fototeca.donadores.index') }}" class="g-nav-link">Donadores</a>
        <a href="{{ route('fototeca.colecciones.index') }}" class="g-nav-link">Colecciones</a>
        <span class="nav-sep-foto" style="color:rgba(255,255,255,.25);font-size:.85rem;user-select:none;">|</span>
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

<div class="page-body">
    <a href="{{ route('fototeca.dashboard') }}#Especiales" class="back-btn" onclick="sessionStorage.setItem('fototeca_tab','Especiales')">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <div class="breadcrumbs">
        <a href="{{ route('fototeca.dashboard') }}" class="breadcrumb-link">Inicio</a><span>›</span>
        <a href="{{ route('fototeca.dashboard') }}#Especiales" class="breadcrumb-link" onclick="sessionStorage.setItem('fototeca_tab','Especiales')">Especiales</a><span>›</span>
        <span class="breadcrumb-current">{{ Str::limit($special->title, 50) }}</span>
    </div>

    <div class="hero-card">
        @if($special->cover_image_path)
            <img src="{{ Storage::url($special->cover_image_path) }}" alt="{{ $special->title }}" class="hero-cover" onerror="this.style.display='none'">
        @else
            <div class="hero-cover-placeholder"><i class="fas fa-star"></i></div>
        @endif
        <div class="hero-body">
            <span class="special-badge">Especial</span>
            <h1 class="special-title">{{ $special->title }}</h1>
            @if($special->description)
            <p class="special-desc">{{ $special->description }}</p>
            @endif
        </div>
    </div>

    @if($special->photos->count())
        <h2 class="section-title">Fotografías del especial</h2>
        <div class="photos-grid">
            @foreach($special->photos as $photo)
            <a href="{{ route('fototeca.galeria.show', $photo) }}" class="photo-card">
                <div class="photo-cover">
                    @if($photo->thumbnail_path || $photo->full_image_path)
                        <img src="{{ Storage::url($photo->thumbnail_path ?? $photo->full_image_path) }}" alt="{{ $photo->title }}" onerror="this.style.display='none'">
                    @else
                        <div class="photo-cover-ph"><i class="fas fa-image"></i></div>
                    @endif
                </div>
                <div class="photo-info">
                    <p class="photo-title">{{ $photo->title }}</p>
                    <p class="photo-meta">
                        {{ $photo->year_type === 'range' && $photo->year_from ? $photo->year_from.'–'.($photo->year_to ?? '?') : ($photo->year ?? 'S/F') }}
                        @if($photo->photographers->first())
                            · {{ $photo->photographers->first()->full_name }}
                        @endif
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="no-items">
            <i class="fas fa-images" style="font-size:2rem;display:block;margin-bottom:.75rem;color:#d1d5db"></i>
            Sin fotografías en este especial.
        </div>
    @endif
</div>

<footer style="background:black;color:white;padding:2rem;text-align:center">
    <p style="font-size:.85rem;color:#9ca3af">© 2024 FOTOTECA WARAS — Archivo Visual Ancashino</p>
</footer>

<script>
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function() {
            const tab = this.getAttribute('href').split('#')[1];
            if (tab) sessionStorage.setItem('fototeca_tab', tab);
        });
    });
</script>
    <x-floating-buttons />
</body>
</html>
