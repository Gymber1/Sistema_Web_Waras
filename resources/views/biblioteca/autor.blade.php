<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $author->name }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/biblioteca-autor.css')
</head>
<body>
<div class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''"><i class="fas fa-times"></i></button>
    <a href="{{ route('biblioteca.inicio') }}" class="mobile-nav-item">Inicio</a>
    <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item">Biblioteca Digital</a>
    <a href="{{ route('biblioteca.editorial.index') }}" class="mobile-nav-item">Waras Editorial</a>
    <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item">Revistas</a>
    <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item active">Autores</a>
    <a href="{{ route('biblioteca.especiales.index') }}" class="mobile-nav-item">Especiales</a>
    <a href="{{ route('home') }}" class="mobile-nav-item" style="font-size:1rem;opacity:0.6">Portal Principal</a>
</div>

    <header class="header">
        <div class="header-container">
            <a href="{{ route('biblioteca.dashboard') }}" class="logo">
                <div class="logo-squares">
                    <div class="logo-square logo-square-1"></div>
                    <div class="logo-square logo-square-2"></div>
                    <div class="logo-square logo-square-3"></div>
                </div>
                <span class="logo-text">WARAS</span>
                <span class="logo-text-sub">Biblioteca</span>
            </a>
            <nav class="nav-menu">
                <a href="{{ route('biblioteca.inicio') }}" class="nav-item">Inicio</a>
                <a href="{{ route('biblioteca.libros.index') }}" class="nav-item">Biblioteca Digital</a>
                <a href="{{ route('biblioteca.editorial.index') }}" class="nav-item">Waras Editorial</a>
                <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item">Revistas</a>
                <a href="{{ route('biblioteca.autores.index') }}" class="nav-item active">Autores</a>
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

        <!-- Botón Atrás (mismo estilo que el book detail) -->
        <a href="{{ route('biblioteca.dashboard') }}#Autores" class="back-btn">
            <i class="fas fa-arrow-left"></i> Atrás
        </a>

        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <a href="{{ route('biblioteca.dashboard') }}" class="breadcrumb-link">Inicio</a>
            <span>›</span>
            <a href="{{ route('biblioteca.dashboard') }}#Autores" class="breadcrumb-link">Autores</a>
            <span>›</span>
            <span class="breadcrumb-current">{{ $author->name }}</span>
        </div>

        <!-- Perfil -->
        <div class="profile-card">
            <div class="profile-avatar">
                @if($author->photo_path)
                    <img src="{{ Storage::url($author->photo_path) }}"
                         alt="{{ $author->name }}"
                         onerror="this.parentElement.innerHTML='<svg class=\'profile-avatar-svg\' viewBox=\'0 0 24 24\'><path d=\'M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z\'/></svg>'">
                @else
                    <svg class="profile-avatar-svg" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                @endif
            </div>
            <div class="profile-info">
                <h1 class="profile-name">{{ $author->name }}</h1>
                <div class="profile-meta">
                    @if($author->nationality)
                    <span class="profile-meta-item">
                        <i class="fas fa-globe-americas"></i> {{ $author->nationality }}
                    </span>
                    @endif
                    <span class="profile-meta-item">
                        <i class="fas fa-book"></i> {{ $author->books->count() }} obra{{ $author->books->count() !== 1 ? 's' : '' }}
                    </span>
                    @if($author->email)
                    <span class="profile-meta-item">
                        <i class="fas fa-envelope"></i> {{ $author->email }}
                    </span>
                    @endif
                </div>
                @if($author->biography)
                    <p class="profile-bio">{{ $author->biography }}</p>
                @else
                    <p class="no-bio">Sin biografía disponible.</p>
                @endif
            </div>
        </div>

        <!-- Obras -->
        @if($author->books->count() > 0)
            <h2 class="section-title">Obras del autor</h2>
            @php $colors = ['#5c4033','#2d4a6e','#3a5a40','#6b3a2a','#1a3a5c','#4a3a6b']; @endphp
            <div class="books-grid">
                @foreach($author->books as $i => $book)
                <div class="book-card">
                    <div class="book-cover" style="background: linear-gradient(135deg, {{ $colors[$i % count($colors)] }} 0%, {{ $colors[$i % count($colors)] }}cc 100%);">
                        <span class="book-type-badge">{{ $book->document_type ?? 'Libro' }}</span>
                        @if($book->cover_image_path)
                            <img src="{{ Storage::url($book->cover_image_path) }}"
                                 alt="{{ $book->title }}"
                                 onerror="this.style.display='none'">
                        @else
                            <span class="book-cover-icon">📚</span>
                        @endif
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-year">{{ $book->publication_year ?? ($book->publication_date ? \Carbon\Carbon::parse($book->publication_date)->format('Y') : 'S/F') }}</p>
                        @if($book->editorial_name)
                            <p class="book-publisher">{{ $book->editorial_name }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="no-books">
                <i class="fas fa-book-open"></i>
                <p>No hay obras registradas para este autor.</p>
            </div>
        @endif

    </div>

    <script>
        // Navegación con hash para abrir sección correcta al volver
        document.querySelectorAll('a[href*="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const hashIdx = href.indexOf('#');
                if (hashIdx !== -1) {
                    const base = href.substring(0, hashIdx);
                    const tab = href.substring(hashIdx + 1);
                    if (base === '{{ route('biblioteca.dashboard') }}' && tab) {
                        e.preventDefault();
                        sessionStorage.setItem('biblioteca_tab', tab);
                        window.location.href = base;
                    }
                }
            });
        });
    </script>
    <x-floating-buttons />
</body>
</html>
