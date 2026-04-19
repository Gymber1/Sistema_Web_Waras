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
        @media(max-width:1024px){.nav-menu{display:none}}
        .page-body{max-width:960px;margin:0 auto;padding:6rem 1.5rem 4rem}
        .back-btn{display:inline-flex;align-items:center;gap:.5rem;background:none;border:none;color:var(--primary);font-size:.95rem;font-weight:600;cursor:pointer;margin-bottom:1.5rem;transition:color .2s;text-decoration:none}
        .back-btn:hover{color:var(--accent)}
        .breadcrumbs{display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:#9ca3af;margin-bottom:2rem}
        .breadcrumb-link{color:#6b7280;text-decoration:none}.breadcrumb-link:hover{color:var(--accent)}
        .breadcrumb-current{color:var(--accent);font-weight:600}
        .hero-card{background:white;border-radius:.75rem;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:2.5rem}
        .hero-cover{width:100%;height:280px;object-fit:cover;display:block}
        .hero-cover-placeholder{width:100%;height:280px;background:linear-gradient(135deg,var(--primary),#2d4a6e);display:flex;align-items:center;justify-content:center;font-size:5rem}
        .hero-body{padding:2rem}
        .special-badge{display:inline-block;background:#f0f4f8;color:var(--primary);font-size:.7rem;font-weight:700;padding:.25rem .75rem;border-radius:.25rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem}
        .special-title{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--primary);margin-bottom:1rem}
        .special-desc{font-size:.925rem;color:#4b5563;line-height:1.75}
        .section-title{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--primary);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid #e5e1d8}
        .photos-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem}
        .photo-card{background:white;border-radius:.5rem;border:1px solid #e2e8f0;overflow:hidden;transition:all .25s}
        .photo-card:hover{transform:translateY(-4px);box-shadow:0 8px 20px rgba(0,0,0,.1)}
        .photo-cover{width:100%;aspect-ratio:4/3;background:#111;position:relative;overflow:hidden}
        .photo-cover img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
        .photo-card:hover .photo-cover img{transform:scale(1.05)}
        .photo-cover-ph{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:#555}
        .photo-info{padding:.875rem}
        .photo-title{font-size:.875rem;font-weight:700;color:var(--primary);margin-bottom:.25rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .photo-meta{font-size:.75rem;color:#9ca3af}
        .no-items{text-align:center;color:#9ca3af;padding:3rem;background:white;border-radius:.75rem;border:1px solid #e2e8f0}
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
            <a href="{{ route('biblioteca.dashboard') }}#Editoriales" class="nav-item">Editoriales</a>
            <a href="{{ route('biblioteca.dashboard') }}#Especiales" class="nav-item active">Especiales</a>
            <a href="{{ route('biblioteca.dashboard') }}#Autores" class="nav-item">Autores</a>
        </nav>
    </div>
</header>

<div class="page-body">
    <a href="{{ route('biblioteca.dashboard') }}#Especiales" class="back-btn" onclick="sessionStorage.setItem('biblioteca_tab','Especiales')">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <div class="breadcrumbs">
        <a href="{{ route('biblioteca.dashboard') }}" class="breadcrumb-link">Inicio</a><span>›</span>
        <a href="{{ route('biblioteca.dashboard') }}#Especiales" class="breadcrumb-link" onclick="sessionStorage.setItem('biblioteca_tab','Especiales')">Especiales</a><span>›</span>
        <span class="breadcrumb-current">{{ Str::limit($special->title, 50) }}</span>
    </div>

    <div class="hero-card">
        @if($special->cover_image_path)
            <img src="{{ Storage::url($special->cover_image_path) }}" alt="{{ $special->title }}" class="hero-cover" onerror="this.style.display='none'">
        @else
            <div class="hero-cover-placeholder">⭐</div>
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
            <a href="{{ route('fototeca.galeria.show', $photo) }}" style="text-decoration:none">
            <div class="photo-card">
                <div class="photo-cover">
                    @if($photo->thumbnail_path || $photo->full_image_path)
                        <img src="{{ Storage::url($photo->thumbnail_path ?? $photo->full_image_path) }}" alt="{{ $photo->title }}" onerror="this.style.display='none'">
                    @else
                        <div class="photo-cover-ph"><i class="fas fa-image"></i></div>
                    @endif
                </div>
                <div class="photo-info">
                    <p class="photo-title">{{ $photo->title }}</p>
                    <p class="photo-meta">{{ $photo->year ?? 'S/F' }}</p>
                </div>
            </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="no-items"><i class="fas fa-images" style="font-size:2rem;display:block;margin-bottom:.75rem;color:#d1d5db"></i>Sin fotografías en este especial.</div>
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
