<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{font-family:'Poppins',sans-serif;color:#333;line-height:1.6;background:#f9f8f6}
        :root{--primary:#1b2a47;--primary-dark:#121d33;--accent:#c5a059;--bg-light:#f9f8f6}
        .header{position:fixed;top:0;width:100%;z-index:1000;background:rgba(27,42,71,1);padding:.5rem 2rem;box-shadow:0 2px 10px rgba(0,0,0,.1)}
        .header-container{max-width:1600px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:64px}
        .logo{display:flex;align-items:center;gap:.75rem;text-decoration:none;color:white;transition:transform .3s}
        .logo:hover{transform:scale(1.05)}
        .logo-squares{display:flex;gap:.25rem}
        .logo-square{width:10px;border-radius:2px}
        .logo-square-1{height:28px;background:#60a5fa}
        .logo-square-2{height:22px;background:#f87171;margin-top:6px}
        .logo-square-3{height:16px;background:var(--accent);margin-top:12px}
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
        @media(max-width:1024px){.nav-menu{display:none}.hamburger-btn{display:flex}.page-body{padding:5.5rem 1rem 3rem}}
        .page-body{max-width:960px;margin:0 auto;padding:6rem 1.5rem 4rem}
        .back-btn{display:inline-flex;align-items:center;gap:.5rem;background:none;border:none;color:var(--primary);font-size:.95rem;font-weight:600;cursor:pointer;margin-bottom:1.5rem;transition:color .2s;text-decoration:none;font-family:'Poppins',sans-serif}
        .back-btn:hover{color:var(--accent)}
        .breadcrumbs{display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:#9ca3af;margin-bottom:2rem}
        .breadcrumb-link{color:#6b7280;text-decoration:none}
        .breadcrumb-link:hover{color:var(--accent)}
        .breadcrumb-current{color:var(--accent);font-weight:600}
        .detail-card{background:white;border-radius:.75rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.08);padding:2rem;display:flex;gap:2.5rem;margin-bottom:2.5rem}
        .cover-box{flex-shrink:0;width:220px}
        .cover-img{width:220px;aspect-ratio:2/3;border-radius:.5rem;object-fit:cover;box-shadow:0 8px 24px rgba(0,0,0,.18);display:block}
        .cover-placeholder{width:220px;aspect-ratio:2/3;border-radius:.5rem;display:flex;align-items:center;justify-content:center;font-size:4rem;box-shadow:0 8px 24px rgba(0,0,0,.18)}
        .info-box{flex:1;min-width:0}
        .book-type-badge{display:inline-block;background:#f0f4f8;color:var(--primary);font-size:.7rem;font-weight:700;padding:.25rem .75rem;border-radius:.25rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem}
        .book-title{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--primary);margin-bottom:.75rem;line-height:1.2}
        .book-authors{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.25rem}
        .author-link{color:var(--accent);font-weight:600;font-size:.95rem;text-decoration:none}
        .author-link:hover{text-decoration:underline}
        .meta-row{display:flex;flex-wrap:wrap;gap:1.5rem;margin-bottom:1.5rem;padding-bottom:1.25rem;border-bottom:1px solid #e5e1d8}
        .meta-item{display:flex;align-items:center;gap:.4rem;font-size:.875rem;color:#6b7280}
        .meta-item i{color:var(--accent);width:14px}
        .section-label{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;margin-bottom:.5rem}
        .section-text{font-size:.925rem;color:#4b5563;line-height:1.75;margin-bottom:1.5rem}
        .cats{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.5rem}
        .cat-badge{background:#f0f4f8;color:var(--primary);font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px}
        .actions{display:flex;gap:.75rem;margin-top:1.5rem;flex-wrap:wrap}
        .btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;border-radius:.5rem;font-weight:600;font-size:.875rem;cursor:pointer;border:none;transition:all .2s;text-decoration:none}
        .btn-primary{background:var(--primary);color:white}
        .btn-primary:hover{background:var(--primary-dark);transform:translateY(-2px)}
        .btn-primary.disabled{opacity:.4;pointer-events:none}
        .btn-icon{width:2.75rem;height:2.75rem;padding:0;display:inline-flex;align-items:center;justify-content:center;background:white;border:1px solid #e2e8f0;color:#6b7280;border-radius:.5rem}
        .btn-icon:hover{border-color:var(--accent);color:var(--accent)}
        .toast{display:none;font-size:.8rem;color:#6b7280;margin-top:.75rem}
        @media(max-width:640px){.detail-card{flex-direction:column;align-items:center}.cover-box{width:160px}.cover-img,.cover-placeholder{width:160px}}
        @media(max-width:1024px){.nav-menu{display:none}.hamburger-btn{display:flex}.header-actions{margin-left:0}.page-body{padding:5.5rem 1rem 3rem}}
    </style>
</head>
<body>
<div class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''"><i class="fas fa-times"></i></button>
    <a href="{{ route('biblioteca.inicio') }}" class="mobile-nav-item">Inicio</a>
    <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item">Libros</a>
    <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item">Revistas</a>
    <a href="{{ route('biblioteca.editoriales.index') }}" class="mobile-nav-item">Editoriales</a>
    <a href="{{ route('biblioteca.especiales.index') }}" class="mobile-nav-item">Especiales</a>
    <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item">Autores</a>
    <a href="{{ route('biblioteca.aportantes.index') }}" class="mobile-nav-item">Aportantes</a>
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
            <a href="{{ route('biblioteca.dashboard') }}" class="nav-item">Inicio</a>
            <a href="{{ route('biblioteca.libros.index') }}" class="nav-item">Libros</a>
            <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item active">Revistas</a>
            <a href="{{ route('biblioteca.editoriales.index') }}" class="nav-item">Editoriales</a>
            <a href="{{ route('biblioteca.especiales.index') }}" class="nav-item">Especiales</a>
            <a href="{{ route('biblioteca.autores.index') }}" class="nav-item">Autores</a>
            <a href="{{ route('biblioteca.aportantes.index') }}" class="nav-item">Aportantes</a>
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

            @if($book->publisher)
            <p class="section-label">Editorial</p>
            <p class="section-text">
                <a href="{{ route('biblioteca.editoriales.show', $book->publisher) }}" style="color:var(--accent);text-decoration:none;font-weight:600">
                    {{ $book->publisher->name }}
                </a>
            </p>
            @endif

            @if($book->categories->count())
            <p class="section-label">Categorías</p>
            <div class="cats">
                @foreach($book->categories as $cat)
                    <span class="cat-badge">{{ $cat->name }}</span>
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
        const tab = sessionStorage.getItem('biblioteca_tab') || 'Revistas';
        const base = '{{ route('biblioteca.dashboard') }}';
        document.getElementById('backBtn').href = base + '#' + tab;
        const bc = document.getElementById('breadcrumbSection');
        bc.href = base + '#' + tab;
        bc.textContent = tab;
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
