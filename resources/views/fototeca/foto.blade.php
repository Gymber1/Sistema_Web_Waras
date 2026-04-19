<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $photo->title }} — Fototeca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{font-family:'Poppins',sans-serif;color:#333;line-height:1.6;background:#f5f5f7}
        :root{--primary:#111;--accent:#E53935}
        .header{position:fixed;top:0;width:100%;z-index:1000;background:rgba(0,0,0,.95);backdrop-filter:blur(10px);border-bottom:1px solid rgba(255,255,255,.1);padding:.5rem 2rem}
        .header-container{max-width:1600px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:56px}
        .logo{display:flex;align-items:center;gap:.75rem;text-decoration:none;color:white;background:none;border:none;cursor:pointer}
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
        .detail-layout{display:flex;gap:0;background:white;border:1px solid #e5e7eb;margin-bottom:3rem}
        .photo-panel{flex:2;background:black;min-height:500px;display:flex;align-items:center;justify-content:center;padding:2rem;position:relative}
        .main-photo{max-width:100%;max-height:75vh;object-fit:contain;display:block}
        .photo-placeholder{display:flex;align-items:center;justify-content:center;width:100%;height:500px;color:#555;font-size:4rem}
        .info-panel{flex:1;min-width:320px;padding:2.5rem;display:flex;flex-direction:column}
        .photo-badge{background:#f3f4f6;color:#374151;padding:.25rem .75rem;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;display:inline-block;width:fit-content;margin-bottom:1rem}
        .photo-title{font-size:1.75rem;font-weight:800;color:black;letter-spacing:-.5px;margin-bottom:1rem;line-height:1.2}
        .photographer-line{display:flex;align-items:center;gap:.5rem;color:#4b5563;font-size:.95rem;font-weight:500;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid #e5e7eb}
        .meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.75rem}
        .meta-label{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;margin-bottom:.2rem}
        .meta-value{font-size:.875rem;color:#374151;font-weight:500;display:flex;align-items:center;gap:.4rem}
        .desc-label{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;margin-bottom:.4rem}
        .desc-text{font-size:.9rem;color:#374151;line-height:1.65}
        .cats{display:flex;flex-wrap:wrap;gap:.4rem;margin-top:1.25rem}
        .cat-badge{background:#f3f4f6;color:#374151;font-size:.7rem;font-weight:600;padding:.2rem .6rem;border-radius:999px}
        .actions{display:flex;gap:.75rem;margin-top:auto;padding-top:1.5rem;border-top:1px solid #e5e7eb}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;padding:.75rem 1.5rem;border:none;font-weight:700;font-size:.8rem;cursor:pointer;text-transform:uppercase;letter-spacing:1px}
        .btn-primary{background:black;color:white;flex:1}.btn-primary:hover{background:#333}
        .btn-icon{width:3rem;padding:0;background:white;border:1px solid #e5e7eb;color:#4b5563}.btn-icon:hover{border-color:black;color:black}
        .toast{display:none;font-size:.8rem;color:#6b7280;margin-top:.75rem}
        @media(max-width:768px){.detail-layout{flex-direction:column}.info-panel{min-width:unset}}
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
            <li><a href="{{ route('fototeca.dashboard') }}#Galería" class="nav-item active">Galería</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Fotógrafos" class="nav-item">Fotógrafos</a></li>
            <li><a href="{{ route('fototeca.dashboard') }}#Especiales" class="nav-item">Especiales</a></li>
        </ul></nav>
    </div>
</header>

<div class="page-body">
    <a href="{{ route('fototeca.dashboard') }}#Galería" class="back-btn" onclick="sessionStorage.setItem('fototeca_tab','Galería')">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <div class="breadcrumbs">
        <a href="{{ route('fototeca.dashboard') }}" class="breadcrumb-link">Inicio</a><span>›</span>
        <a href="{{ route('fototeca.dashboard') }}#Galería" class="breadcrumb-link" onclick="sessionStorage.setItem('fototeca_tab','Galería')">Galería</a><span>›</span>
        <span class="breadcrumb-current">{{ Str::limit($photo->title, 50) }}</span>
    </div>

    <div class="detail-layout">
        <div class="photo-panel">
            @if($photo->full_image_path || $photo->thumbnail_path)
                <img src="{{ Storage::url($photo->full_image_path ?? $photo->thumbnail_path) }}"
                     alt="{{ $photo->title }}" class="main-photo"
                     onerror="this.style.display='none'">
            @else
                <div class="photo-placeholder"><i class="fas fa-image"></i></div>
            @endif
        </div>

        <div class="info-panel">
            <span class="photo-badge">{{ $photo->format ?: ($photo->source_type ?: 'Archivo') }}</span>
            <h1 class="photo-title">{{ $photo->title }}</h1>

            @if($photo->photographers->count())
            <div class="photographer-line">
                <i class="fas fa-user-circle"></i>
                <span>{{ $photo->photographers->map->full_name->join(', ') }}</span>
            </div>
            @endif

            <div class="meta-grid">
                <div>
                    <p class="meta-label">Año / Fecha</p>
                    <p class="meta-value"><i class="far fa-calendar-alt"></i> {{ $photo->year ?? 'S/F' }}</p>
                </div>
                <div>
                    <p class="meta-label">Ubicación</p>
                    <p class="meta-value"><i class="fas fa-map-marker-alt"></i> {{ $photo->location ?: '—' }}</p>
                </div>
                <div>
                    <p class="meta-label">Resolución</p>
                    <p class="meta-value"><i class="fas fa-expand"></i> {{ $photo->resolution ?: '—' }}</p>
                </div>
                <div>
                    <p class="meta-label">Formato</p>
                    <p class="meta-value"><i class="fas fa-camera"></i> {{ $photo->format ?: '—' }}</p>
                </div>
            </div>

            @if($photo->description)
            <p class="desc-label">Descripción del archivo</p>
            <p class="desc-text">{{ $photo->description }}</p>
            @endif

            @if($photo->categories->count())
            <div class="cats">
                @foreach($photo->categories as $cat)
                    <span class="cat-badge">{{ $cat->name }}</span>
                @endforeach
            </div>
            @endif

            <div class="actions">
                @if($photo->source_type === 'external' && $photo->external_url)
                    <a href="{{ $photo->external_url }}" target="_blank" rel="noopener" class="btn btn-primary">
                        <i class="fas fa-external-link-alt"></i> Ver Original
                    </a>
                @else
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-download"></i> Imprimir / Guardar
                    </button>
                @endif
                <button id="btnShare" class="btn btn-icon" title="Copiar enlace"><i class="fas fa-share-alt"></i></button>
            </div>
            <div id="shareToast" class="toast">✓ Enlace copiado al portapapeles</div>
        </div>
    </div>
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
</body>
</html>
