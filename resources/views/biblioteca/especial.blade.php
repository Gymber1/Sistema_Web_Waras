<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $special->title }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/biblioteca-especial.css')
</head>
<body>
<div class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''"><i class="fas fa-times"></i></button>
    <a href="{{ route('biblioteca.inicio') }}" class="mobile-nav-item">Inicio</a>
    <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item">Biblioteca Digital</a>
    <a href="{{ route('biblioteca.editorial.index') }}" class="mobile-nav-item">Waras Editorial</a>
    <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item">Revistas</a>
    <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item">Autores</a>
    <a href="{{ route('biblioteca.especiales.index') }}" class="mobile-nav-item active">Especiales</a>
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
            <span class="logo-text">WARAS</span><span class="logo-sub">Biblioteca</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ route('biblioteca.inicio') }}" class="nav-item">Inicio</a>
            <a href="{{ route('biblioteca.libros.index') }}" class="nav-item">Biblioteca Digital</a>
            <a href="{{ route('biblioteca.editorial.index') }}" class="nav-item">Waras Editorial</a>
            <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item">Revistas</a>
            <a href="{{ route('biblioteca.autores.index') }}" class="nav-item">Autores</a>
            <a href="{{ route('biblioteca.especiales.index') }}" class="nav-item active">Especiales</a>
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

    <a href="{{ route('biblioteca.especiales.index') }}" class="back-btn"
        onclick="sessionStorage.setItem('biblioteca_tab','Especiales')">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>

    <div class="breadcrumbs">
        <a href="{{ route('biblioteca.dashboard') }}" class="breadcrumb-link">Inicio</a><span>›</span>
        <a href="{{ route('biblioteca.especiales.index') }}" class="breadcrumb-link"
            onclick="sessionStorage.setItem('biblioteca_tab','Especiales')">Especiales</a><span>›</span>
        <span class="breadcrumb-current">{{ Str::limit($special->title, 60) }}</span>
    </div>

    {{-- Hero --}}
    <div class="hero-card">
        <div class="hero-cover-wrap">
            @if($special->cover_image_path)
                <img src="{{ Storage::url($special->cover_image_path) }}" alt="{{ $special->title }}"
                    onerror="this.style.display='none'">
            @else
                <div class="hero-cover-placeholder"><i class="fas fa-star"></i></div>
            @endif
        </div>
        <div class="hero-body">
            <span class="special-badge {{ $special->type === 'revista' ? 'badge-revista' : 'badge-libro' }}">
                Colección {{ $special->type === 'revista' ? 'de Revistas' : 'de Libros' }}
            </span>
            <h1 class="special-title">{{ $special->title }}</h1>
            @if($special->description)
            <p style="font-size:.9rem;color:#4b5563;line-height:1.75;">{{ $special->description }}</p>
            @endif
            <div class="special-meta">
                <span class="special-meta-item">
                    <i class="fas fa-{{ $special->type === 'revista' ? 'newspaper' : 'book' }}"></i>
                    {{ $special->books->count() }}
                    {{ $special->type === 'revista' ? ($special->books->count() === 1 ? 'revista' : 'revistas') : ($special->books->count() === 1 ? 'libro' : 'libros') }}
                    en esta colección
                </span>
            </div>
        </div>
    </div>

    {{-- Buscador --}}
    @if($special->books->count() > 0)
    <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Buscar en esta colección..." oninput="filterItems(this.value)">
    </div>
    @endif

    {{-- Listado --}}
    @php $isRevista = $special->type === 'revista'; @endphp
    <div class="section-header">
        <h2 class="section-title">
            {{ $isRevista ? 'Revistas' : 'Libros' }} de la colección
        </h2>
        <span class="count-badge" id="itemCount">{{ $special->books->count() }} elementos</span>
    </div>

    @if($special->books->isEmpty())
        <div class="no-items">
            <i class="fas fa-{{ $isRevista ? 'newspaper' : 'book-open' }}" style="font-size:2rem;display:block;margin-bottom:.75rem;color:#d1d5db"></i>
            Esta colección no tiene {{ $isRevista ? 'revistas' : 'libros' }} asignados aún.
        </div>
    @else
        <div class="books-grid" id="booksGrid">
            @foreach($special->books as $book)
            @php
                $detailRoute = $book->document_type === 'Revista'
                    ? route('biblioteca.revistas.show', $book)
                    : route('biblioteca.libros.show', $book);
                $colors = ['#5c4033','#2d4a6e','#3a5a40','#6b3a2a','#1a3a5c','#4a3a6b'];
                $color  = $colors[$loop->index % count($colors)];
                $year   = $book->publication_year ?? ($book->publication_date ? \Carbon\Carbon::parse($book->publication_date)->format('Y') : 'S/F');
                $author = $book->authors->first()?->name ?? 'Anónimo';
            @endphp
            <div class="book-card" data-title="{{ strtolower($book->title) }} {{ strtolower($author) }}"
                onclick="sessionStorage.setItem('back_url','{{ url()->current() }}');sessionStorage.setItem('back_label','{{ addslashes($special->title) }}');window.location.href='{{ $detailRoute }}'">
                <div class="book-cover" style="background:linear-gradient(135deg,{{ $color }},{{ $color }}cc)">
                    @if($book->cover_image_path)
                        <img src="{{ Storage::url($book->cover_image_path) }}" alt="{{ $book->title }}"
                            onerror="this.style.display='none'" loading="lazy">
                    @endif
                    <span class="book-cover-icon">{{ $book->document_type === 'Revista' ? '📰' : '📚' }}</span>
                    <span class="book-type-badge"
                        style="background:{{ $book->document_type === 'Revista' ? 'rgba(37,99,235,.85)' : 'rgba(5,150,105,.85)' }};color:#fff;">
                        {{ $book->document_type }}
                    </span>
                </div>
                <div class="book-info">
                    <p class="book-title">{{ $book->title }}</p>
                    <p class="book-author">{{ $author }}</p>
                    <p class="book-year">{{ $year }}</p>
                    <div class="book-footer">
                        <a href="{{ $detailRoute }}" class="book-link" onclick="event.stopPropagation();sessionStorage.setItem('back_url','{{ url()->current() }}');sessionStorage.setItem('back_label','{{ addslashes($special->title) }}')">
                            {{ $book->source_type !== 'none' ? 'Ver →' : 'Detalle →' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

<script>
function filterItems(q) {
    q = q.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('#booksGrid .book-card').forEach(card => {
        const match = !q || card.dataset.title.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('itemCount').textContent = visible + ' elementos';
}
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
