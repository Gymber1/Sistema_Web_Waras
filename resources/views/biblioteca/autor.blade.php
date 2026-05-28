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
<div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="document.getElementById('mobileNav').classList.remove('open');document.getElementById('mobileNavOverlay').classList.remove('open');document.body.style.overflow=''"></div>
<div class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-header">
        <a href="{{ route('biblioteca.dashboard') }}" class="logo">
            <div class="logo-squares">
                <div class="logo-square logo-square-1"></div>
                <div class="logo-square logo-square-2"></div>
                <div class="logo-square logo-square-3"></div>
            </div>
            <span class="logo-text">BIBLIOTECA</span>
            <span class="logo-text-sub">Digital Ancashina</span>
        </a>
        <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.getElementById('mobileNavOverlay').classList.remove('open');document.body.style.overflow=''">✕</button>
    </div>
    <nav class="mobile-nav-links">
        <a href="{{ route('biblioteca.inicio') }}" class="mobile-nav-item">Inicio</a>
        <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item">Biblioteca Digital</a>
        <a href="{{ route('biblioteca.editorial.index') }}" class="mobile-nav-item">Waras Editorial</a>
        <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item">Revistas</a>
        <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item active">Autores</a>
        <a href="{{ route('biblioteca.especiales.index') }}" class="mobile-nav-item">Especiales</a>
        <a href="{{ route('home') }}" class="mobile-nav-item mobile-nav-portal">Portal Principal</a>
        @auth
            @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item mobile-nav-admin">Panel Admin</a>
            @endif
        @endauth
    </nav>
</div>

    <header class="header">
        <div class="header-container">
            <a href="{{ route('biblioteca.dashboard') }}" class="logo">
                @php $navLogo = \App\Models\SiteSetting::get('nav_logo_biblioteca'); @endphp
                @if($navLogo)
                    <img src="{{ asset('storage/' . $navLogo) }}" alt="Logo" class="logo-icon">
                @else
                    <div class="logo-squares">
                        <div class="logo-square logo-square-1"></div>
                        <div class="logo-square logo-square-2"></div>
                        <div class="logo-square logo-square-3"></div>
                    </div>
                @endif
                <div class="logo-brand">
                    <span class="logo-text">BIBLIOTECA</span>
                    <span class="logo-text-sub">Digital Ancashina</span>
                </div>
            </a>
            <nav class="nav-menu">
                <a href="{{ route('biblioteca.inicio') }}" class="nav-item">Inicio</a>
                <span class="nav-sep-bib">|</span>
                <a href="{{ route('biblioteca.libros.index') }}" class="nav-item">Biblioteca Digital</a>
                <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item">Revistas</a>
                <a href="{{ route('biblioteca.autores.index') }}" class="nav-item active">Autores</a>
                <span class="nav-sep-bib">|</span>
                <a href="{{ route('biblioteca.especiales.index') }}" class="nav-item">Especiales</a>
                <span class="nav-sep-bib">|</span>
                <a href="{{ route('biblioteca.editorial.index') }}" class="nav-item">Waras Editorial</a>
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
            <button class="hamburger-btn" onclick="document.getElementById('mobileNav').classList.add('open');document.getElementById('mobileNavOverlay').classList.add('open');document.body.style.overflow='hidden'" aria-label="Menú">
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
            @php
                $colors = ['#5c4033','#2d4a6e','#3a5a40','#6b3a2a','#1a3a5c','#4a3a6b'];
                $allBooks = $author->books->map(function($book, $i) use ($colors) {
                    return [
                        'url'           => $book->document_type === 'Revista'
                                            ? route('biblioteca.revistas.show', $book)
                                            : route('biblioteca.libros.show', $book),
                        'color'         => $colors[$i % count($colors)],
                        'type'          => $book->document_type ?? 'Libro',
                        'cover'         => $book->cover_image_path ? Storage::url($book->cover_image_path) : null,
                        'title'         => $book->title,
                        'year'          => $book->publication_year ?? ($book->publication_date ? \Carbon\Carbon::parse($book->publication_date)->format('Y') : 'S/F'),
                        'publisher'     => $book->editorial_name ?? null,
                    ];
                })->values()->toArray();
            @endphp
            <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1rem; flex-wrap:wrap;">
                <h2 class="section-title" style="margin:0;">Obras del autor</h2>
                <div style="position:relative; min-width:220px;">
                    <i class="fas fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#999;font-size:0.8rem;pointer-events:none;"></i>
                    <input type="text" id="books-search" placeholder="Buscar obra..." oninput="searchBooks(this.value)"
                        style="width:100%;padding:7px 12px 7px 30px;border:1px solid #ddd;border-radius:8px;font-size:0.85rem;outline:none;color:#333;background:#fafafa;transition:border .2s;"
                        onfocus="this.style.borderColor='#b8860b'" onblur="this.style.borderColor='#ddd'">
                </div>
            </div>
            <div id="books-no-results" style="display:none; text-align:center; padding:2rem 0; color:#999; font-size:0.95rem;">
                <i class="fas fa-search" style="font-size:1.5rem; opacity:0.3; display:block; margin-bottom:0.5rem;"></i>
                No se encontraron obras con ese término.
            </div>
            <div id="books-grid" class="books-grid"></div>
            <div id="books-pagination" style="display:none; text-align:center; margin-top:1.5rem; margin-bottom:1rem;"></div>
        @else
            <div class="no-books">
                <i class="fas fa-book-open"></i>
                <p>No hay obras registradas para este autor.</p>
            </div>
        @endif

    </div>

    <script>
        // ── Paginación + búsqueda de obras ──────────────────────────
        (function() {
            const allBooks   = @json($allBooks ?? []);
            const PER_PAGE   = 8;
            const authorName = @json($author->name);
            let filtered     = allBooks.slice();
            let currentPage  = 1;

            function cardHtml(b) {
                return `<a href="${b.url}" class="book-card" style="text-decoration:none;color:inherit;display:block;"
                    onclick="sessionStorage.setItem('back_url',window.location.href);sessionStorage.setItem('back_label',${JSON.stringify(authorName)});">
                    <div class="book-cover" style="background:linear-gradient(135deg,${b.color} 0%,${b.color}cc 100%);">
                        <span class="book-type-badge">${b.type}</span>
                        ${b.cover ? `<img src="${b.cover}" alt="${b.title}" onerror="this.style.display='none'">` : '<span class="book-cover-icon">📚</span>'}
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">${b.title}</h3>
                        <p class="book-year">${b.year}</p>
                        ${b.publisher ? `<p class="book-publisher">${b.publisher}</p>` : ''}
                    </div>
                </a>`;
            }

            function render() {
                const grid      = document.getElementById('books-grid');
                const noResults = document.getElementById('books-no-results');
                const pagCont   = document.getElementById('books-pagination');
                if (!grid) return;

                if (filtered.length === 0) {
                    grid.innerHTML = '';
                    noResults.style.display = 'block';
                    pagCont.style.display   = 'none';
                    return;
                }

                noResults.style.display = 'none';
                const start = (currentPage - 1) * PER_PAGE;
                grid.innerHTML = filtered.slice(start, start + PER_PAGE).map(cardHtml).join('');

                const totalPages = Math.ceil(filtered.length / PER_PAGE);
                if (totalPages <= 1) { pagCont.style.display = 'none'; return; }
                pagCont.style.display = 'block';
                pagCont.innerHTML = Array.from({length: totalPages}, (_, i) => i + 1).map(p => {
                    const active = p === currentPage;
                    return `<button onclick="goPage(${p})" style="margin:0 3px;padding:6px 14px;border-radius:6px;
                        border:1px solid ${active?'#b8860b':'#ddd'};background:${active?'#b8860b':'#fff'};
                        color:${active?'#fff':'#555'};font-size:0.85rem;cursor:pointer;
                        font-weight:${active?'600':'400'};transition:all .2s;">${p}</button>`;
                }).join('');
            }

            window.goPage = function(p) {
                currentPage = p;
                render();
                document.getElementById('books-search')?.closest('div')?.previousElementSibling?.scrollIntoView({behavior:'smooth', block:'start'});
            };

            window.searchBooks = function(q) {
                const term = q.toLowerCase().trim();
                filtered = term
                    ? allBooks.filter(b =>
                        b.title.toLowerCase().includes(term) ||
                        (b.publisher && b.publisher.toLowerCase().includes(term)) ||
                        b.type.toLowerCase().includes(term) ||
                        String(b.year).includes(term))
                    : allBooks.slice();
                currentPage = 1;
                render();
            };

            render();
        })();

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
