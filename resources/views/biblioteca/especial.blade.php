<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $special->title }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{font-family:'Poppins',sans-serif;color:#333;line-height:1.6;background:#f9f8f6}
        :root{--primary:#1b2a47;--accent:#c5a059}
        .header{position:fixed;top:0;width:100%;z-index:1000;background:rgba(27,42,71,1);padding:.5rem 2rem;box-shadow:0 2px 10px rgba(0,0,0,.1)}
        .header-container{max-width:1600px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:64px}
        .logo{display:flex;align-items:center;gap:.75rem;text-decoration:none;color:white;transition:transform .3s}.logo:hover{transform:scale(1.05)}
        .logo-squares{display:flex;gap:.25rem}.logo-square{width:10px;border-radius:2px}
        .logo-square-1{height:28px;background:#60a5fa}.logo-square-2{height:22px;background:#f87171;margin-top:6px}.logo-square-3{height:16px;background:var(--accent);margin-top:12px}
        .logo-text{font-size:1.5rem;font-weight:800;letter-spacing:.05em;font-family:'Playfair Display',serif}
        .logo-sub{font-size:.85rem;font-weight:300;margin-left:.5rem;font-style:italic;opacity:.9}
        .nav-menu{display:flex;gap:.25rem}
        .nav-item{color:#e2e8f0;font-size:.875rem;font-weight:500;padding:.5rem 1rem;border-radius:.375rem;transition:all .2s;text-decoration:none;text-transform:uppercase;letter-spacing:.05em}
        .nav-item:hover,.nav-item.active{background:rgba(255,255,255,.1);color:var(--accent)}
        .header-actions{display:flex;align-items:center;gap:.625rem;margin-left:1.5rem}
        .header-btn{display:inline-flex;align-items:center;gap:.4rem;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;padding:.45rem 1rem;border-radius:.375rem;text-decoration:none;transition:all .2s;white-space:nowrap}
        .header-btn-outline{color:#e2e8f0;border:1px solid rgba(255,255,255,.25)}
        .header-btn-outline:hover{background:rgba(255,255,255,.1);color:var(--accent);border-color:var(--accent)}
        .header-btn-solid{background:var(--accent);color:var(--primary);border:1px solid var(--accent)}
        .header-btn-solid:hover{background:#b08d4b;border-color:#b08d4b}
        .hamburger-btn{display:none;background:none;border:none;cursor:pointer;color:white;padding:.5rem;min-width:44px;min-height:44px;align-items:center;justify-content:center}
        .mobile-nav{display:none;position:fixed;inset:0;background:rgba(27,42,71,.98);z-index:2000;flex-direction:column;align-items:center;justify-content:center;gap:1.75rem}
        .mobile-nav.open{display:flex}
        .mobile-nav-close{position:absolute;top:1.5rem;right:1.5rem;background:none;border:none;color:white;cursor:pointer;font-size:1.5rem;min-width:44px;min-height:44px;display:flex;align-items:center;justify-content:center}
        .mobile-nav-item{color:white;text-decoration:none;font-size:1.3rem;font-weight:700;text-transform:uppercase;letter-spacing:2px;min-height:44px;display:flex;align-items:center}
        @media(max-width:1024px){.nav-menu{display:none}.hamburger-btn{display:flex}.header-actions{margin-left:0}.page-body{padding:5.5rem 1rem 3rem}}

        .page-body{max-width:1100px;margin:0 auto;padding:6rem 1.5rem 4rem}

        .back-btn{display:inline-flex;align-items:center;gap:.5rem;background:none;border:none;color:var(--primary);font-size:.95rem;font-weight:600;cursor:pointer;margin-bottom:1.5rem;transition:color .2s;text-decoration:none}
        .back-btn:hover{color:var(--accent)}

        .breadcrumbs{display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:#9ca3af;margin-bottom:2rem;flex-wrap:wrap}
        .breadcrumb-link{color:#6b7280;text-decoration:none}.breadcrumb-link:hover{color:var(--accent)}
        .breadcrumb-current{color:var(--accent);font-weight:600}

        /* Hero */
        .hero-card{background:white;border-radius:1rem;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:2.5rem;display:flex;gap:0}
        .hero-cover-wrap{flex-shrink:0;width:240px;min-height:220px;background:linear-gradient(135deg,var(--primary),#2d4a6e);display:flex;align-items:center;justify-content:center;overflow:hidden}
        .hero-cover-wrap img{width:100%;height:100%;object-fit:cover;display:block}
        .hero-cover-placeholder{font-size:4rem;color:rgba(255,255,255,.25)}
        .hero-body{padding:2rem;flex:1}
        .special-badge{display:inline-block;font-size:.7rem;font-weight:800;padding:.25rem .75rem;border-radius:.25rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem}
        .badge-libro{background:#d1fae5;color:#065f46}
        .badge-revista{background:#dbeafe;color:#1e40af}
        .special-title{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--primary);margin-bottom:.75rem}
        .special-meta{display:flex;gap:1.5rem;flex-wrap:wrap;margin-top:1rem}
        .special-meta-item{display:flex;align-items:center;gap:.4rem;font-size:.85rem;color:#6b7280}
        .special-meta-item i{color:var(--accent)}
        @media(max-width:640px){
            .hero-card{flex-direction:column}
            .hero-cover-wrap{width:100%;height:180px}
        }

        /* Search bar */
        .search-bar{display:flex;align-items:center;gap:.75rem;background:white;border:2px solid var(--accent);border-radius:.5rem;padding:.6rem 1.25rem;margin-bottom:1.5rem}
        .search-bar i{color:var(--accent);flex-shrink:0}
        .search-bar input{flex:1;border:none;outline:none;font-size:.92rem;font-family:'Poppins',sans-serif;color:#333}
        .search-bar input::placeholder{color:#9ca3af}

        /* Section header */
        .section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid #e5e1d8;flex-wrap:wrap;gap:.5rem}
        .section-title{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--primary)}
        .count-badge{font-size:.8rem;font-weight:700;background:#f0f4f8;color:var(--primary);padding:.3rem .8rem;border-radius:999px}

        /* Books grid */
        .books-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1.25rem}
        .book-card{background:white;border-radius:.75rem;border:1px solid #e2e8f0;overflow:hidden;transition:all .25s;cursor:pointer}
        .book-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,.1)}
        .book-cover{aspect-ratio:3/4;position:relative;overflow:hidden;background:linear-gradient(135deg,#1b2a47,#2d4a6e)}
        .book-cover img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0}
        .book-cover-icon{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:2.5rem}
        .book-type-badge{position:absolute;top:.5rem;left:.5rem;font-size:.65rem;font-weight:800;padding:.2rem .5rem;border-radius:.25rem;text-transform:uppercase}
        .book-info{padding:.875rem}
        .book-title{font-size:.82rem;font-weight:700;color:var(--primary);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:.3rem;line-height:1.35}
        .book-author{font-size:.75rem;color:#9ca3af;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden}
        .book-year{font-size:.72rem;color:#d1c5a8;margin-top:.2rem}
        .book-footer{margin-top:.6rem;padding-top:.6rem;border-top:1px solid #f3f4f6;display:flex;justify-content:flex-end}
        .book-link{font-size:.72rem;font-weight:700;color:var(--accent);text-decoration:none}.book-link:hover{text-decoration:underline}

        .no-items{text-align:center;color:#9ca3af;padding:3rem;background:white;border-radius:.75rem;border:1px solid #e2e8f0}
    </style>
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
                    <i class="fas fa-book"></i>
                    {{ $special->books->count() }}
                    {{ $special->type === 'revista' ? ($special->books->count() === 1 ? 'revista' : 'revistas') : ($special->books->count() === 1 ? 'libro' : 'libros') }}
                    en esta colección
                </span>
            </div>
        </div>
    </div>

    {{-- Buscador --}}
    @if($special->books->count() > 4)
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
                $year   = $book->publication_date ? $book->publication_date->format('Y') : 'S/F';
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
