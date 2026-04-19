<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $photographer->full_name }} — Fototeca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; background: #f5f5f7; }

        :root {
            --primary: #111111;
            --accent: #E53935;
            --bg-gray: #f5f5f7;
        }

        /* Header idéntico a fototeca/dashboard */
        .header {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            background: rgba(0,0,0,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 0.5rem 2rem;
        }
        .header-container {
            max-width: 1600px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            height: 56px;
        }
        .logo {
            display: flex; align-items: center; gap: 0.75rem;
            cursor: pointer; text-decoration: none; color: white; background: none; border: none;
        }
        .logo-icon { width: 32px; height: 32px; border: 2px solid white; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: transform 0.3s; }
        .logo:hover .logo-icon { transform: scale(1.1); }
        .logo-main { font-size: 1.25rem; font-weight: 800; letter-spacing: 0.2em; text-transform: uppercase; }
        .logo-sub  { font-size: 1.25rem; font-weight: 300; color: #9ca3af; }

        .nav-menu { display: flex; gap: 2rem; list-style: none; }
        .nav-item {
            color: #9ca3af; font-weight: 700; font-size: 0.75rem;
            text-transform: uppercase; letter-spacing: 1px;
            text-decoration: none; padding: 0.5rem 0;
            border-bottom: 2px solid transparent;
            transition: color 0.3s ease;
        }
        .nav-item:hover { color: white; }
        .nav-item.active { color: white; border-bottom-color: white; }
        .hamburger-btn{display:none;background:none;border:none;cursor:pointer;color:white;padding:.5rem;min-width:44px;min-height:44px;align-items:center;justify-content:center}
        .mobile-nav{display:none;position:fixed;inset:0;background:rgba(0,0,0,.97);z-index:2000;flex-direction:column;align-items:center;justify-content:center;gap:2rem}
        .mobile-nav.open{display:flex}
        .mobile-nav-close{position:absolute;top:1.5rem;right:1.5rem;background:none;border:none;color:white;cursor:pointer;font-size:1.5rem;min-width:44px;min-height:44px;display:flex;align-items:center;justify-content:center}
        .mobile-nav-item{color:white;text-decoration:none;font-size:1.3rem;font-weight:700;text-transform:uppercase;letter-spacing:2px;min-height:44px;display:flex;align-items:center}
        @media (max-width: 768px) { .nav-menu { display: none; } .hamburger-btn{display:flex} .page-body{padding:5rem 1rem 3rem} }

        /* Page */
        .page-body {
            max-width: 960px; margin: 0 auto;
            padding: 5.5rem 1.5rem 4rem;
        }

        /* Back */
        .back-btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: white; border: 1px solid #e5e7eb;
            color: #374151; font-size: 0.875rem; font-weight: 600;
            cursor: pointer; padding: 0.5rem 1rem; border-radius: 0.375rem;
            margin-bottom: 1.75rem; transition: all 0.2s; text-decoration: none;
        }
        .back-btn:hover { background: black; color: white; border-color: black; }

        /* Breadcrumbs */
        .breadcrumbs {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.825rem; color: #9ca3af; margin-bottom: 2rem;
        }
        .breadcrumb-link { color: #6b7280; text-decoration: none; }
        .breadcrumb-link:hover { color: black; }
        .breadcrumb-current { color: black; font-weight: 600; }

        /* Profile card */
        .profile-card {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 2.5rem;
            display: flex; gap: 2.5rem; align-items: flex-start;
            margin-bottom: 2.5rem;
        }
        .profile-avatar {
            width: 120px; height: 120px; flex-shrink: 0;
            border-radius: 50%; overflow: hidden;
            background: #111;
            display: flex; align-items: center; justify-content: center;
            border: 3px solid #e5e7eb;
        }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .avatar-icon { font-size: 3rem; color: #555; }

        .profile-info { flex: 1; min-width: 0; }
        .profile-name {
            font-size: 2rem; font-weight: 800; color: black;
            letter-spacing: -0.5px; margin-bottom: 0.75rem;
        }
        .profile-meta { display: flex; flex-wrap: wrap; gap: 1.25rem; margin-bottom: 1rem; }
        .profile-meta-item {
            display: flex; align-items: center; gap: 0.4rem;
            font-size: 0.85rem; color: #6b7280;
        }
        .profile-meta-item i { color: #374151; width: 14px; }
        .profile-bio { font-size: 0.925rem; color: #4b5563; line-height: 1.75; }
        .no-bio { color: #9ca3af; font-style: italic; font-size: 0.9rem; }

        /* Studies / critique */
        .profile-studies {
            margin-top: 1.25rem; padding-top: 1.25rem;
            border-top: 1px solid #f3f4f6;
            font-size: 0.9rem; color: #4b5563; line-height: 1.7;
        }
        .profile-studies-label {
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: #9ca3af; margin-bottom: 0.4rem;
        }

        /* Photos grid */
        .section-title {
            font-size: 1.25rem; font-weight: 800; color: black;
            text-transform: uppercase; letter-spacing: 1px;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #111;
        }
        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        .photo-card {
            background: white; border: 1px solid #e5e7eb;
            overflow: hidden; transition: all 0.25s ease;
            display: flex; flex-direction: column;
        }
        .photo-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
        .photo-cover {
            width: 100%; aspect-ratio: 4/3;
            background: #111; overflow: hidden; position: relative;
        }
        .photo-cover img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s ease; }
        .photo-card:hover .photo-cover img { transform: scale(1.05); }
        .photo-cover-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
        }
        .photo-cover-placeholder i { font-size: 2.5rem; color: #444; }
        .photo-badge {
            position: absolute; top: 0.6rem; left: 0.6rem;
            background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);
            color: white; font-size: 0.65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            padding: 0.2rem 0.5rem;
        }
        .photo-info { padding: 0.875rem 1rem; flex: 1; }
        .photo-title {
            font-size: 0.9rem; font-weight: 700; color: black;
            margin-bottom: 0.25rem;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .photo-year { font-size: 0.75rem; color: #9ca3af; font-family: monospace; }

        .no-photos {
            text-align: center; color: #9ca3af; padding: 3rem 2rem;
            background: white; border: 1px solid #e5e7eb;
        }
        .no-photos i { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; color: #d1d5db; }

        @media (max-width: 640px) {
            .profile-card { flex-direction: column; align-items: center; text-align: center; }
            .profile-meta { justify-content: center; }
        }
    </style>
</head>
<body>
<div class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open');document.body.style.overflow=''"><i class="fas fa-times"></i></button>
    <a href="{{ route('fototeca.inicio') }}" class="mobile-nav-item">Inicio</a>
    <a href="{{ route('fototeca.galeria.index') }}" class="mobile-nav-item">Galería</a>
    <a href="{{ route('fototeca.fotografos.index') }}" class="mobile-nav-item">Fotógrafos</a>
    <a href="{{ route('fototeca.especiales.index') }}" class="mobile-nav-item">Destacados</a>
</div>

    <header class="header">
        <div class="header-container">
            <a href="{{ route('fototeca.dashboard') }}" class="logo">
                <div class="logo-icon"><i class="fas fa-camera"></i></div>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <span class="logo-main">Fototeca</span>
                    <span class="logo-sub">Ancashina</span>
                </div>
            </a>
            <nav>
                <ul class="nav-menu">
                    <li><a href="{{ route('fototeca.inicio') }}" class="nav-item">Inicio</a></li>
                    <li><a href="{{ route('fototeca.galeria.index') }}" class="nav-item">Galería</a></li>
                    <li><a href="{{ route('fototeca.fotografos.index') }}" class="nav-item active">Fotógrafos</a></li>
                    <li><a href="{{ route('fototeca.especiales.index') }}" class="nav-item">Especiales</a></li>
                </ul>
            </nav>
            <button class="hamburger-btn" onclick="document.getElementById('mobileNav').classList.add('open');document.body.style.overflow='hidden'" aria-label="Menú">
                <i class="fas fa-bars" style="font-size:1.3rem"></i>
            </button>
        </div>
    </header>

    <div class="page-body">

        <a href="{{ route('fototeca.dashboard') }}#Fotógrafos" class="back-btn">
            <i class="fas fa-arrow-left"></i> Atrás
        </a>

        <div class="breadcrumbs">
            <a href="{{ route('fototeca.dashboard') }}" class="breadcrumb-link">Inicio</a>
            <span>›</span>
            <a href="{{ route('fototeca.dashboard') }}#Fotógrafos" class="breadcrumb-link">Fotógrafos</a>
            <span>›</span>
            <span class="breadcrumb-current">{{ $photographer->full_name }}</span>
        </div>

        <!-- Perfil -->
        <div class="profile-card">
            <div class="profile-avatar">
                @if($photographer->photo_path)
                    <img src="{{ Storage::url($photographer->photo_path) }}"
                         alt="{{ $photographer->full_name }}"
                         onerror="this.parentElement.innerHTML='<i class=\'fas fa-user avatar-icon\'></i>'">
                @else
                    <i class="fas fa-user avatar-icon"></i>
                @endif
            </div>

            <div class="profile-info">
                <h1 class="profile-name">{{ $photographer->full_name }}</h1>

                <div class="profile-meta">
                    @if($photographer->birth_place)
                    <span class="profile-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $photographer->birth_place }}
                        @if($photographer->death_place && $photographer->death_place !== $photographer->birth_place)
                            — {{ $photographer->death_place }}
                        @endif
                    </span>
                    @endif

                    @if($photographer->birth_date)
                    <span class="profile-meta-item">
                        <i class="far fa-calendar-alt"></i>
                        {{ $photographer->birth_date->format('Y') }}
                        @if($photographer->death_date)
                            – {{ $photographer->death_date->format('Y') }}
                        @endif
                    </span>
                    @endif

                    <span class="profile-meta-item">
                        <i class="fas fa-camera"></i>
                        {{ $photographer->photos->count() }} foto{{ $photographer->photos->count() !== 1 ? 's' : '' }}
                    </span>
                </div>

                @if($photographer->biography)
                    <p class="profile-bio">{{ $photographer->biography }}</p>
                @else
                    <p class="no-bio">Sin biografía disponible.</p>
                @endif

                @if($photographer->studies_critique)
                <div class="profile-studies">
                    <p class="profile-studies-label">Estudios / Crítica</p>
                    <p>{{ $photographer->studies_critique }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Fotografías -->
        @if($photographer->photos->count() > 0)
            <h2 class="section-title">Fotografías de {{ $photographer->full_name }}</h2>
            <div class="photos-grid">
                @foreach($photographer->photos as $photo)
                <div class="photo-card">
                    <div class="photo-cover">
                        @if($photo->thumbnail_path || $photo->full_image_path)
                            <img src="{{ Storage::url($photo->thumbnail_path ?? $photo->full_image_path) }}"
                                 alt="{{ $photo->title }}"
                                 onerror="this.parentElement.innerHTML='<div class=\'photo-cover-placeholder\'><i class=\'fas fa-image\'></i></div>'">
                        @else
                            <div class="photo-cover-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <span class="photo-badge">{{ $photo->format ?: ($photo->source_type ?: 'Archivo') }}</span>
                    </div>
                    <div class="photo-info">
                        <p class="photo-title">{{ $photo->title }}</p>
                        <p class="photo-year">{{ $photo->year ?? 'S/F' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="no-photos">
                <i class="fas fa-camera"></i>
                <p>No hay fotografías registradas para este fotógrafo.</p>
            </div>
        @endif

    </div>

    <footer style="background:black;color:white;padding:2rem;text-align:center;margin-top:4rem;">
        <p style="font-size:0.85rem;color:#9ca3af;">© 2024 FOTOTECA WARAS — Archivo Visual Ancashino</p>
    </footer>

    <script>
        // Guardar tab en sessionStorage al volver
        document.querySelectorAll('a[href*="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const hashIdx = href.indexOf('#');
                if (hashIdx !== -1) {
                    const base = href.substring(0, hashIdx);
                    const tab  = href.substring(hashIdx + 1);
                    if (tab) {
                        e.preventDefault();
                        sessionStorage.setItem('fototeca_tab', tab);
                        window.location.href = base;
                    }
                }
            });
        });
    </script>
</body>
</html>
