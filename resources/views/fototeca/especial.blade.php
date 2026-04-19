<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $special->title }} — Fototeca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{font-family:'Poppins',sans-serif;color:#333;line-height:1.6;background:#f5f5f7}
        :root{--primary:#111;--accent:#E53935}
        .header{position:fixed;top:0;width:100%;z-index:1000;background:rgba(0,0,0,.95);backdrop-filter:blur(10px);border-bottom:1px solid rgba(255,255,255,.1);padding:.5rem 2rem}
        .header-container{max-width:1600px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:56px}
        .logo{display:flex;align-items:center;gap:.75rem;text-decoration:none;color:white}
        .logo-icon{width:32px;height:32px;border:2px solid white;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:transform .3s}
        .logo:hover .logo-icon{transform:scale(1.1)}
        .logo-main{font-size:1.25rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase}
        .logo-sub{font-size:1.25rem;font-weight:300;color:#9ca3af}
        .nav-menu{display:flex;gap:2rem;list-style:none}
        .nav-item{color:#9ca3af;font-weight:700;font-size:.75rem;text-transform:uppercase;letter-spacing:1px;text-decoration:none;padding:.5rem 0;border-bottom:2px solid transparent;transition:color .3s}
        .nav-item:hover{color:white}.nav-item.active{color:white;border-bottom-color:white}
        @media(max-width:768px){.nav-menu{display:none}}
        .page-body{max-width:1100px;margin:0 auto;padding:5.5rem 1.5rem 4rem}
        .back-btn{display:inline-flex;align-items:center;gap:.5rem;background:white;border:1px solid #e5e7eb;color:#374151;font-size:.875rem;font-weight:600;padding:.5rem 1rem;border-radius:.375rem;margin-bottom:1.75rem;transition:all .2s;text-decoration:none}
        .back-btn:hover{background:black;color:white;border-color:black}
        .breadcrumbs{display:flex;align-items:center;gap:.5rem;font-size:.825rem;color:#9ca3af;margin-bottom:2rem}
        .breadcrumb-link{color:#6b7280;text-decoration:none}.breadcrumb-link:hover{color:black}
        .breadcrumb-current{color:black;font-weight:600}
        .hero-card{background:white;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:2.5rem}
        .hero-cover{width:100%;height:320px;object-fit:cover;display:block}
        .hero-cover-placeholder{width:100%;height:320px;background:linear-gradient(135deg,#111,#333);display:flex;align-items:center;justify-content:center;font-size:5rem;color:#555}
        .hero-body{padding:2rem}
        .special-badge{display:inline-block;background:#f3f4f6;color:#374151;font-size:.7rem;font-weight:700;padding:.25rem .75rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:.75rem}
        .special-title{font-size:2rem;font-weight:800;color:black;letter-spacing:-.5px;margin-bottom:1rem;line-height:1.2}
        .special-desc{font-size:.925rem;color:#4b5563;line-height:1.75}
        .section-title{font-size:1.25rem;font-weight:800;color:black;letter-spacing:-.3px;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid #e5e7eb;text-transform:uppercase;letter-spacing:.05em}
        .photos-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem}
        .photo-card{background:white;border:1px solid #e5e7eb;overflow:hidden;transition:all .25s;text-decoration:none;display:block}
        .photo-card:hover{transform:translateY(-4px);box-shadow:0 8px 20px rgba(0,0,0,.12)}
        .photo-cover{width:100%;aspect-ratio:4/3;background:#111;position:relative;overflow:hidden}
        .photo-cover img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
        .photo-card:hover .photo-cover img{transform:scale(1.05)}
        .photo-cover-ph{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:#555}
        .photo-info{padding:.875rem}
        .photo-title{font-size:.875rem;font-weight:700;color:black;margin-bottom:.25rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .photo-meta{font-size:.75rem;color:#9ca3af}
        .no-items{text-align:center;color:#9ca3af;padding:3rem;background:white;border:1px solid #e5e7eb}
    </style>
</head>
<body>
<header class="header">
    <div class="header-container">
        <a href="{{ route('fototeca.dashboard') }}" class="logo">
            <div class="logo-icon"><i class="fas fa-camera"></i></div>
            <div style="display:flex;align-items:center;gap:.5rem">
                <span class="logo-main">Fototeca</span>
                <span class="logo-sub">Ancashina</span>
            </div>
        </a>
        <nav><ul class="nav-menu">
            <li><a href="{{ route('fototeca.dashboard') }}" class="nav-item">Inicio</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Galería" class="nav-item">Galería</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Fotógrafos" class="nav-item">Fotógrafos</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Especiales" class="nav-item active">Destacados</a></li>
        </ul></nav>
    </div>
</header>

<div class="page-body">
    <a href="{{ route('fototeca.dashboard') }}#Especiales" class="back-btn" onclick="sessionStorage.setItem('fototeca_tab','Especiales')">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <div class="breadcrumbs">
        <a href="{{ route('fototeca.dashboard') }}" class="breadcrumb-link">Inicio</a><span>›</span>
        <a href="{{ route('fototeca.dashboard') }}#Especiales" class="breadcrumb-link" onclick="sessionStorage.setItem('fototeca_tab','Especiales')">Especiales</a><span>›</span>
        <span class="breadcrumb-current">{{ Str::limit($special->title, 50) }}</span>
    </div>

    <div class="hero-card">
        @if($special->cover_image_path)
            <img src="{{ Storage::url($special->cover_image_path) }}" alt="{{ $special->title }}" class="hero-cover" onerror="this.style.display='none'">
        @else
            <div class="hero-cover-placeholder"><i class="fas fa-star"></i></div>
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
            <a href="{{ route('fototeca.galeria.show', $photo) }}" class="photo-card">
                <div class="photo-cover">
                    @if($photo->thumbnail_path || $photo->full_image_path)
                        <img src="{{ Storage::url($photo->thumbnail_path ?? $photo->full_image_path) }}" alt="{{ $photo->title }}" onerror="this.style.display='none'">
                    @else
                        <div class="photo-cover-ph"><i class="fas fa-image"></i></div>
                    @endif
                </div>
                <div class="photo-info">
                    <p class="photo-title">{{ $photo->title }}</p>
                    <p class="photo-meta">
                        {{ $photo->year ?? 'S/F' }}
                        @if($photo->photographers->first())
                            · {{ $photo->photographers->first()->full_name }}
                        @endif
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="no-items">
            <i class="fas fa-images" style="font-size:2rem;display:block;margin-bottom:.75rem;color:#d1d5db"></i>
            Sin fotografías en este especial.
        </div>
    @endif
</div>

<footer style="background:black;color:white;padding:2rem;text-align:center">
    <p style="font-size:.85rem;color:#9ca3af">© 2024 FOTOTECA WARAS — Archivo Visual Ancashino</p>
</footer>

<script>
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function() {
            const tab = this.getAttribute('href').split('#')[1];
            if (tab) sessionStorage.setItem('fototeca_tab', tab);
        });
    });
</script>
</body>
</html>
