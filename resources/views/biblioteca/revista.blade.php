<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/biblioteca-revista.css')
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
            <div class="logo-squares">
                <div class="logo-square logo-square-1"></div>
                <div class="logo-square logo-square-2"></div>
                <div class="logo-square logo-square-3"></div>
            </div>
            <span class="logo-text">WARAS</span>
            <span class="logo-sub">Biblioteca</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ route('biblioteca.inicio') }}" class="nav-item">Inicio</a>
            <a href="{{ route('biblioteca.libros.index') }}" class="nav-item">Biblioteca Digital</a>
            <a href="{{ route('biblioteca.editorial.index') }}" class="nav-item">Waras Editorial</a>
            <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item active">Revistas</a>
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
    <a id="backBtn" href="{{ route('biblioteca.dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <div class="breadcrumbs">
        <a href="{{ route('biblioteca.dashboard') }}" class="breadcrumb-link">Inicio</a>
        <span>›</span>
        <a id="breadcrumbSection" href="{{ route('biblioteca.dashboard') }}" class="breadcrumb-link">Revistas</a>
        <span>›</span>
        <span class="breadcrumb-current">{{ Str::limit($book->title, 50) }}</span>
    </div>

    <div class="detail-card">
        <div class="cover-box">
            @if($book->cover_image_path)
                <img src="{{ Storage::url($book->cover_image_path) }}" alt="{{ $book->title }}" class="cover-img"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cover-placeholder" style="display:none;background:linear-gradient(135deg,#2d4a6e,#1a2d42)">📰</div>
            @else
                <div class="cover-placeholder" style="background:linear-gradient(135deg,#2d4a6e,#1a2d42)">📰</div>
            @endif
        </div>

        <div class="info-box">
            <span class="book-type-badge">{{ $book->document_type ?? 'Revista' }}</span>
            <h1 class="book-title">{{ $book->title }}</h1>

            @if($book->authors->count())
            <div class="book-authors">
                @foreach($book->authors as $author)
                    <a href="{{ route('biblioteca.autores.show', $author) }}" class="author-link">
                        <i class="fas fa-user" style="font-size:.8rem;margin-right:.25rem"></i>{{ $author->name }}
                    </a>
                @endforeach
            </div>
            @endif

            <div class="meta-row">
                @if($book->publication_date)
                <span class="meta-item"><i class="fas fa-calendar-alt"></i> {{ $book->publication_date->format('Y') }}</span>
                @endif
                @if($book->pages)
                <span class="meta-item"><i class="fas fa-file-alt"></i> {{ $book->pages }} páginas</span>
                @endif
                @if($book->language)
                <span class="meta-item"><i class="fas fa-globe"></i> {{ $book->language }}</span>
                @endif
                @if($book->isbn)
                <span class="meta-item"><i class="fas fa-barcode"></i> ISBN: {{ $book->isbn }}</span>
                @endif
            </div>

            @if($book->summary)
            <p class="section-label">Sinopsis / Descripción</p>
            <p class="section-text">{{ $book->summary }}</p>
            @endif

            @if($book->categories->count())
            <p class="section-label">Categorías</p>
            <div class="cats">
                @foreach($book->categories as $cat)
                    <span class="cat-badge">{{ $cat->name }}</span>
                @endforeach
            </div>
            @endif

            @if($book->descriptors->count())
            <p class="section-label">Descriptores</p>
            <div class="cats">
                @foreach($book->descriptors as $desc)
                    <span class="cat-badge" style="background:#f0fdf4;color:#166534;border-color:#bbf7d0;">{{ $desc->name }}</span>
                @endforeach
            </div>
            @endif

            <div class="actions">
                @if($book->source_type === 'external' && $book->external_url)
                    <a href="{{ $book->external_url }}" target="_blank" rel="noopener" class="btn btn-primary">
                        <i class="fas fa-book-open"></i> Leer en línea
                    </a>
                @elseif($book->source_type === 'pdf' && $book->pdf_file_path)
                    <a href="{{ Storage::url($book->pdf_file_path) }}" target="_blank" rel="noopener" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Ver PDF
                    </a>
                @else
                    <span class="btn btn-primary disabled"><i class="fas fa-book-open"></i> Sin acceso disponible</span>
                @endif
                <button id="btnShare" class="btn-icon" title="Copiar enlace"><i class="fas fa-share-alt"></i></button>
            </div>
            <div id="shareToast" class="toast">✓ Enlace copiado al portapapeles</div>
        </div>
    </div>
</div>

<script>
    (function() {
        const backUrl   = sessionStorage.getItem('back_url');
        const backLabel = sessionStorage.getItem('back_label');
        const tab  = sessionStorage.getItem('biblioteca_tab') || 'Revistas';
        const base = '{{ route('biblioteca.dashboard') }}';
        if (backUrl) {
            document.getElementById('backBtn').href = backUrl;
            const bc = document.getElementById('breadcrumbSection');
            bc.href = backUrl;
            bc.textContent = backLabel || 'Especiales';
            sessionStorage.removeItem('back_url');
            sessionStorage.removeItem('back_label');
        } else {
            document.getElementById('backBtn').href = base + '#' + tab;
            const bc = document.getElementById('breadcrumbSection');
            bc.href = base + '#' + tab;
            bc.textContent = tab;
        }
    })();
    document.getElementById('btnShare').addEventListener('click', () => {
        const url = window.location.href;
        const toast = document.getElementById('shareToast');
        navigator.clipboard.writeText(url).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = url; document.body.appendChild(ta); ta.select();
            document.execCommand('copy'); document.body.removeChild(ta);
        }).finally(() => { toast.style.display='block'; setTimeout(()=>{toast.style.display='none'},2500); });
    });
</script>
    <x-floating-buttons />
</body>
</html>
