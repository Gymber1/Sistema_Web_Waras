<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $publisher->name }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{font-family:'Poppins',sans-serif;color:#333;line-height:1.6;background:#f9f8f6}
        :root{--primary:#1b2a47;--primary-dark:#121d33;--accent:#c5a059}
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
        @media(max-width:1024px){.nav-menu{display:none}}
        .page-body{max-width:960px;margin:0 auto;padding:6rem 1.5rem 4rem}
        .back-btn{display:inline-flex;align-items:center;gap:.5rem;background:none;border:none;color:var(--primary);font-size:.95rem;font-weight:600;cursor:pointer;margin-bottom:1.5rem;transition:color .2s;text-decoration:none}
        .back-btn:hover{color:var(--accent)}
        .breadcrumbs{display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:#9ca3af;margin-bottom:2rem}
        .breadcrumb-link{color:#6b7280;text-decoration:none}.breadcrumb-link:hover{color:var(--accent)}
        .breadcrumb-current{color:var(--accent);font-weight:600}
        .profile-card{background:white;border-radius:.75rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.08);padding:2rem;display:flex;gap:2rem;align-items:flex-start;margin-bottom:2.5rem}
        .pub-logo{width:100px;height:100px;flex-shrink:0;border-radius:.5rem;object-fit:contain;background:#f9f8f6;border:1px solid #e2e8f0;padding:.5rem}
        .pub-logo-placeholder{width:100px;height:100px;flex-shrink:0;border-radius:.5rem;background:linear-gradient(135deg,var(--primary),#2d4a6e);display:flex;align-items:center;justify-content:center;font-size:2.5rem}
        .info-box{flex:1}
        .pub-name{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--primary);margin-bottom:.75rem}
        .meta-row{display:flex;flex-wrap:wrap;gap:1.25rem;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid #e5e1d8}
        .meta-item{display:flex;align-items:center;gap:.4rem;font-size:.875rem;color:#6b7280}.meta-item i{color:var(--accent);width:14px}
        .section-label{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;margin-bottom:.5rem}
        .section-text{font-size:.925rem;color:#4b5563;line-height:1.75;margin-bottom:1.5rem}
        .section-title{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--primary);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid #e5e1d8}
        .books-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1.25rem}
        .book-card{background:white;border-radius:.5rem;border:1px solid #e2e8f0;overflow:hidden;transition:all .25s;display:flex;flex-direction:column}
        .book-card:hover{transform:translateY(-4px);box-shadow:0 8px 20px rgba(27,42,71,.12)}
        .book-cover{width:100%;aspect-ratio:2/3;display:flex;align-items:center;justify-content:center;font-size:2rem;position:relative;overflow:hidden}
        .book-cover img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0}
        .book-info{padding:.875rem}
        .book-title{font-family:'Playfair Display',serif;font-size:.875rem;font-weight:700;color:var(--primary);margin-bottom:.25rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .book-year{font-size:.75rem;color:#9ca3af}
        .no-items{text-align:center;color:#9ca3af;padding:3rem;background:white;border-radius:.75rem;border:1px solid #e2e8f0}
        .colors{background:linear-gradient(135deg,#5c4033,#3a2a1e)}
        @media(max-width:640px){.profile-card{flex-direction:column;align-items:center}}
    </style>
</head>
<body>
<header class="header">
    <div class="header-container">
        <a href="{{ route('biblioteca.dashboard') }}" class="logo">
            <div class="logo-squares"><div class="logo-square logo-square-1"></div><div class="logo-square logo-square-2"></div><div class="logo-square logo-square-3"></div></div>
            <span class="logo-text">WARAS</span><span class="logo-sub">Biblioteca</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ route('biblioteca.dashboard') }}" class="nav-item">Inicio</a>
            <a href="{{ route('biblioteca.dashboard') }}#Libros" class="nav-item">Libros</a>
            <a href="{{ route('biblioteca.dashboard') }}#Revistas" class="nav-item">Revistas</a>
            <a href="{{ route('biblioteca.dashboard') }}#Editoriales" class="nav-item active">Editoriales</a>
            <a href="{{ route('biblioteca.dashboard') }}#Especiales" class="nav-item">Especiales</a>
            <a href="{{ route('biblioteca.dashboard') }}#Autores" class="nav-item">Autores</a>
        </nav>
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
</body>
</html>
