<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $author->name }} — Biblioteca WARAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; }
        body { background: #f9f8f6; }

        :root {
            --primary: #1b2a47;
            --primary-dark: #121d33;
            --accent: #c5a059;
            --bg-light: #f9f8f6;
        }

        /* ── Header (idéntico al dashboard) ── */
        .header {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            background: rgba(27, 42, 71, 1);
            padding: 0.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .header-container {
            max-width: 1600px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            height: 64px;
        }
        .logo {
            display: flex; align-items: center; gap: 0.75rem;
            cursor: pointer; text-decoration: none; color: white;
            transition: transform 0.3s ease;
        }
        .logo:hover { transform: scale(1.05); }
        .logo-squares { display: flex; gap: 0.25rem; }
        .logo-square { width: 10px; border-radius: 2px; }
        .logo-square-1 { height: 28px; background: #60a5fa; }
        .logo-square-2 { height: 22px; background: #f87171; margin-top: 6px; }
        .logo-square-3 { height: 16px; background: var(--accent); margin-top: 12px; }
        .logo-text { font-size: 1.5rem; font-weight: 800; letter-spacing: 0.05em; font-family: 'Playfair Display', serif; }
        .logo-text-sub { font-size: 0.85rem; font-weight: 300; margin-left: 0.5rem; font-style: italic; opacity: 0.9; }
        .nav-menu { display: flex; gap: 0.25rem; }
        .nav-item {
            color: #e2e8f0; font-size: 0.875rem; font-weight: 500;
            padding: 0.5rem 1rem; border-radius: 0.375rem;
            transition: all 0.2s ease; cursor: pointer; border: none;
            background: transparent; letter-spacing: 0.05em; text-transform: uppercase;
            text-decoration: none;
        }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: var(--accent); }
        .nav-item.active { background: rgba(255,255,255,0.1); color: var(--accent); }
        @media (max-width: 1024px) { .nav-menu { display: none; } }

        /* ── Page body ── */
        .page-body {
            max-width: 900px; margin: 0 auto;
            padding: 6rem 1.5rem 4rem;
        }

        /* Back button — same style as book detail */
        .back-btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: none; border: none;
            color: var(--primary); font-size: 0.95rem; font-weight: 600;
            cursor: pointer; margin-bottom: 1.5rem;
            transition: color 0.2s; text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }
        .back-btn:hover { color: var(--accent); }

        /* Breadcrumbs */
        .breadcrumbs {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.875rem; color: #9ca3af; margin-bottom: 2rem;
        }
        .breadcrumb-link { color: #6b7280; text-decoration: none; }
        .breadcrumb-link:hover { color: var(--accent); }
        .breadcrumb-current { color: var(--accent); font-weight: 600; }

        /* Profile card */
        .profile-card {
            background: white; border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            padding: 2rem;
            display: flex; gap: 2rem; align-items: flex-start;
            margin-bottom: 2.5rem;
        }
        .profile-avatar {
            width: 110px; height: 110px; flex-shrink: 0;
            border-radius: 50%; overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, #2d4a6e 100%);
            display: flex; align-items: center; justify-content: center;
            border: 3px solid var(--accent);
        }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .profile-avatar-svg {
            width: 52px; height: 52px; fill: rgba(255,255,255,0.55);
        }
        .profile-info { flex: 1; min-width: 0; }
        .profile-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.875rem; font-weight: 700; color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .profile-meta { display: flex; gap: 1.25rem; flex-wrap: wrap; margin-bottom: 1rem; }
        .profile-meta-item {
            display: flex; align-items: center; gap: 0.4rem;
            font-size: 0.875rem; color: #6b7280;
        }
        .profile-meta-item i { color: var(--accent); width: 14px; }
        .profile-bio { font-size: 0.925rem; color: #4b5563; line-height: 1.75; }
        .no-bio { color: #9ca3af; font-style: italic; font-size: 0.9rem; }

        /* Books */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; font-weight: 700; color: var(--primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e1d8;
        }
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 1.5rem;
        }
        .book-card {
            background: white; border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: all 0.25s ease;
            display: flex; flex-direction: column;
        }
        .book-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(27,42,71,0.15); }
        .book-cover {
            width: 100%; aspect-ratio: 2 / 3;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .book-cover img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; display: block; }
        .book-cover-icon { font-size: 2.5rem; opacity: 0.7; position: relative; z-index: 1; }
        .book-type-badge {
            position: absolute; top: 0.6rem; left: 0.6rem; z-index: 2;
            background: rgba(255,255,255,0.9); color: var(--primary);
            font-size: 0.65rem; font-weight: 700;
            padding: 0.25rem 0.5rem; border-radius: 0.25rem;
            text-transform: uppercase;
        }
        .book-info { padding: 1rem; flex: 1; display: flex; flex-direction: column; }
        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 0.925rem; font-weight: 700; color: var(--primary);
            margin-bottom: 0.35rem;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .book-year { font-size: 0.75rem; color: #9ca3af; }
        .book-publisher { font-size: 0.75rem; color: #6b7280; margin-top: auto; padding-top: 0.5rem; }

        .no-books {
            text-align: center; color: #9ca3af; padding: 3rem 2rem;
            background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0;
        }
        .no-books i { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; color: #d1d5db; }

        @media (max-width: 640px) {
            .profile-card { flex-direction: column; align-items: center; text-align: center; }
            .profile-meta { justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- Header idéntico al del dashboard -->
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
                <a href="{{ route('biblioteca.dashboard') }}" class="nav-item">Inicio</a>
                <a href="{{ route('biblioteca.dashboard') }}#Libros" class="nav-item">Libros</a>
                <a href="{{ route('biblioteca.dashboard') }}#Revistas" class="nav-item">Revistas</a>
                <a href="{{ route('biblioteca.dashboard') }}#Editoriales" class="nav-item">Editoriales</a>
                <a href="{{ route('biblioteca.dashboard') }}#Especiales" class="nav-item">Especiales</a>
                <a href="{{ route('biblioteca.dashboard') }}#Autores" class="nav-item active">Autores</a>
                <a href="{{ route('biblioteca.dashboard') }}#Aportantes" class="nav-item">Aportantes</a>
            </nav>
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
                        <p class="book-year">{{ $book->publication_date ? $book->publication_date->format('Y') : 'S/F' }}</p>
                        @if($book->publisher)
                            <p class="book-publisher">{{ $book->publisher->name }}</p>
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
</body>
</html>
