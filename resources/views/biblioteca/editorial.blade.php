<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $publisher->name }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/biblioteca-editorial.css')
</head>
<body>
<div class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''"><i class="fas fa-times"></i></button>
    <a href="{{ route('biblioteca.inicio') }}" class="mobile-nav-item">Inicio</a>
    <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item">Biblioteca Digital</a>
    <a href="{{ route('biblioteca.editorial.index') }}" class="mobile-nav-item">Waras Editorial</a>
    <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item">Revistas</a>
    <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item">Autores</a>
    <a href="{{ route('biblioteca.especiales.index') }}" class="mobile-nav-item">Especiales</a>
    <a href="{{ route('home') }}" class="mobile-nav-item" style="font-size:1rem;opacity:0.6">Portal Principal</a>
</div>
<header class="header">
    <div class="header-container">
        <a href="{{ route('biblioteca.dashboard') }}" class="logo">
            <div class="logo-squares"><div class="logo-square logo-square-1"></div><div class="logo-square logo-square-2"></div><div class="logo-square logo-square-3"></div></div>
            <span class="logo-text">WARAS</span><span class="logo-sub">Biblioteca</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ route('biblioteca.inicio') }}" class="nav-item">Inicio</a>
            <a href="{{ route('biblioteca.libros.index') }}" class="nav-item">Biblioteca Digital</a>
            <a href="{{ route('biblioteca.editorial.index') }}" class="nav-item active">Waras Editorial</a>
            <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item">Revistas</a>
            <a href="{{ route('biblioteca.autores.index') }}" class="nav-item">Autores</a>
            <a href="{{ route('biblioteca.especiales.index') }}" class="nav-item">Especiales</a>
        </nav>
        <div class="header-actions">
            <a href="{{ route('home') }}" class="header-btn header-btn-outline">
                <i class="fas fa-home"></i> Portal Principal
            </a>
            @auth
                @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
                <a href="{{ route('admin.dashboard') }}" class="header-btn header-btn-solid">
                    <i class="fas fa-th-large"></i> Panel
                </a>
                @endif
            @endauth
        </div>
        <button class="hamburger-btn" onclick="document.getElementById('mobileNav').classList.add('open');document.body.style.overflow='hidden'" aria-label="Menú">
            <i class="fas fa-bars" style="font-size:1.3rem"></i>
        </button>
    </div>
</header>

<div class="page-body">
    <a href="{{ route('biblioteca.dashboard') }}#Editoriales" class="back-btn" onclick="sessionStorage.setItem('biblioteca_tab','Editoriales')">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <div class="breadcrumbs">
        <a href="{{ route('biblioteca.dashboard') }}" class="breadcrumb-link">Inicio</a><span>›</span>
        <a href="{{ route('biblioteca.dashboard') }}#Editoriales" class="breadcrumb-link" onclick="sessionStorage.setItem('biblioteca_tab','Editoriales')">Editoriales</a><span>›</span>
        <span class="breadcrumb-current">{{ $publisher->name }}</span>
    </div>

    <div class="profile-card">
        @if($publisher->logo_path)
            <img src="{{ Storage::url($publisher->logo_path) }}" alt="{{ $publisher->name }}" class="pub-logo" onerror="this.style.display='none'">
        @else
            <div class="pub-logo-placeholder">🏢</div>
        @endif
        <div class="info-box">
            <h1 class="pub-name">{{ $publisher->name }}</h1>
            <div class="meta-row">
                <span class="meta-item"><i class="fas fa-book"></i> {{ $publisher->books->count() }} publicación{{ $publisher->books->count() !== 1 ? 'es' : '' }}</span>
                @if($publisher->email)
                <span class="meta-item"><i class="fas fa-envelope"></i> {{ $publisher->email }}</span>
                @endif
                @if($publisher->website)
                <span class="meta-item"><i class="fas fa-globe"></i> <a href="{{ $publisher->website }}" target="_blank" style="color:var(--accent)">{{ $publisher->website }}</a></span>
                @endif
                @if($publisher->phone)
                <span class="meta-item"><i class="fas fa-phone"></i> {{ $publisher->phone }}</span>
                @endif
                @if($publisher->address)
                <span class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $publisher->address }}</span>
                @endif
            </div>
            @if($publisher->description)
            <p class="section-label">Descripción</p>
            <p class="section-text">{{ $publisher->description }}</p>
            @endif
        </div>
    </div>

    @if($publisher->books->count())
        <h2 class="section-title">Publicaciones de {{ $publisher->name }}</h2>
        @php $colors = ['#5c4033','#2d4a6e','#3a5a40','#6b3a2a','#1a3a5c','#4a3a6b']; @endphp
        <div class="books-grid">
            @foreach($publisher->books as $i => $book)
            <a href="{{ $book->document_type === 'Revista' ? route('biblioteca.revistas.show', $book) : route('biblioteca.libros.show', $book) }}" style="text-decoration:none">
            <div class="book-card">
                <div class="book-cover" style="background:linear-gradient(135deg,{{ $colors[$i % count($colors)] }},{{ $colors[$i % count($colors)] }}cc)">
                    @if($book->cover_image_path)
                        <img src="{{ Storage::url($book->cover_image_path) }}" alt="{{ $book->title }}" onerror="this.style.display='none'">
                    @else
                        {{ $book->document_type === 'Revista' ? '📰' : '📚' }}
                    @endif
                </div>
                <div class="book-info">
                    <p class="book-title">{{ $book->title }}</p>
                    <p class="book-year">{{ $book->publication_date?->format('Y') ?? 'S/F' }}</p>
                </div>
            </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="no-items"><i class="fas fa-book" style="font-size:2rem;display:block;margin-bottom:.75rem;color:#d1d5db"></i>Sin publicaciones registradas.</div>
    @endif
</div>

<script>
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function() {
            const tab = this.getAttribute('href').split('#')[1];
            if (tab) sessionStorage.setItem('biblioteca_tab', tab);
        });
    });
</script>
    <x-floating-buttons />
</body>
</html>
