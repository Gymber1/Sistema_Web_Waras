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
<header class="header">
    <div class="header-container">
        <a href="{{ route('fototeca.dashboard') }}" class="logo">
            <div class="logo-icon"><i class="fas fa-camera"></i></div>
            <div style="display:flex;align-items:center;gap:.5rem">
                <span class="logo-main">Fototeca</span>
                <span class="logo-sub">Ancashina</span>
            </div>
        </a>
        <nav><ul class="nav-menu">
            <li><a href="{{ route('fototeca.dashboard') }}" class="nav-item">Inicio</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Galería" class="nav-item">Galería</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Fotógrafos" class="nav-item">Fotógrafos</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Especiales" class="nav-item active">Destacados</a></li>
        </ul></nav>
    </div>
</header>

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
