<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fototeca Digital Ancashina — WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Fototeca-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&family=Libre+Baskerville:ital@0;1&display=swap" rel="stylesheet">
    @vite('resources/css/fototeca.css')
</head>
<body>

    <!-- ── GLOBAL NAV ──────────────────────────────────────────────── -->
    <nav class="global-nav" id="globalNav">
        <button class="global-nav-brand" id="logoBtn">
            @php $navLogo = \App\Models\SiteSetting::get('nav_logo_fototeca'); @endphp
            @if($navLogo)
                <img src="{{ asset('storage/' . $navLogo) }}" alt="Logo">
            @endif
            <div class="global-nav-brand-text">
                <span class="global-nav-brand-main">FOTOTECA</span>
                <span class="global-nav-brand-sub">Digital Ancashina</span>
            </div>
        </button>
        <div class="global-nav-links" id="globalNavLinks">
            <button class="nav-item-btn" data-tab="Inicio">Inicio</button>
            <button class="nav-item-btn" data-tab="Galería">Galería</button>
            <button class="nav-item-btn" data-tab="Fotógrafos">Fotógrafos</button>
            <a href="{{ route('fototeca.colecciones.index') }}" class="nav-item-btn" style="text-decoration:none;">Colecciones</a>
            <button class="nav-item-btn" data-tab="Aportantes">Sobre Nosotros</button>
            <a href="{{ route('home') }}" class="nav-portal-btn">Portal Principal</a>
            @auth
                @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
                <a href="{{ route('admin.dashboard') }}" class="nav-panel-btn">
                    Panel
                </a>
                @endif
            @endauth
        </div>
        <button class="global-nav-hamburger" id="globalNavHamburger" aria-label="Menú">
            <span></span><span></span><span></span>
        </button>
        <div class="global-nav-mobile" id="globalNavMobile">
            <button class="nav-item-btn" data-tab="Inicio">Inicio</button>
            <button class="nav-item-btn" data-tab="Galería">Galería</button>
            <button class="nav-item-btn" data-tab="Fotógrafos">Fotógrafos</button>
            <a href="{{ route('fototeca.colecciones.index') }}" class="nav-item-btn" style="text-decoration:none;">Colecciones</a>
            <button class="nav-item-btn" data-tab="Aportantes">Sobre Nosotros</button>
            <a href="{{ route('home') }}" style="color:var(--text-muted)">Portal Principal</a>
            @auth
                @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
                <a href="{{ route('admin.dashboard') }}" style="color:var(--text-accent)">Panel Admin</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- ── HERO ────────────────────────────────────────────────────── -->
    <section class="hero-section" id="heroSection">
        <div class="hero-bg" style="background-image:url('{{ $heroBg ?? 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?auto=format&fit=crop&w=1920&q=80' }}');"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <p class="hero-eyebrow">Archivo Visual de Áncash</p>
            <h1 class="hero-title">Fototeca<br><em>Ancashina</em></h1>
            <p class="hero-subtitle">Preservando y compartiendo la memoria visual, histórica y cultural de nuestra región.</p>
            <div class="hero-search-container">
                <div class="hero-search-wrap">
                    <div class="hero-search-icon-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </div>
                    <input type="text" class="hero-search-input" id="heroSearchInput" placeholder="Buscar fotografías, autores, años…" autocomplete="off">
                    <button class="hero-search-btn" id="heroSearchBtn">Buscar</button>
                </div>
                <div class="hero-search-dropdown" id="heroDropdown"></div>
            </div>
        </div>
    </section>

    <!-- ── INICIO SECTION ────────────────────────────────────────── -->
    <div class="inicio-section hidden" id="inicioSection">

        <!-- Contadores -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-num">{{ $totalPhotos }}</span>
                <span class="stat-label">Galería</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $totalPhotographers }}</span>
                <span class="stat-label">Fotógrafos</span>
            </div>
        </div>

        <!-- Carrusel: Galería -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Galería</h2>
                <span class="inicio-carousel-count">{{ $totalPhotos }} fotografías</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackGaleria"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveFtcCarousel('galeria',-1)">‹</button>
                <div class="ico-dots" id="dotsGaleria"></div>
                <button class="ico-btn" onclick="moveFtcCarousel('galeria',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Galería')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Carrusel: Fotógrafos -->
        <div class="inicio-carousel-section">
            <div class="inicio-carousel-header">
                <h2 class="inicio-carousel-title">Fotógrafos</h2>
                <span class="inicio-carousel-count">{{ $totalPhotographers }} registrados</span>
            </div>
            <div class="inicio-carousel-track-wrap">
                <div class="inicio-carousel-track" id="trackFotografos"></div>
            </div>
            <div class="inicio-carousel-controls">
                <button class="ico-btn" onclick="moveFtcCarousel('fotografos',-1)">‹</button>
                <div class="ico-dots" id="dotsFotografos"></div>
                <button class="ico-btn" onclick="moveFtcCarousel('fotografos',1)">›</button>
            </div>
            <div class="carousel-ver-mas">
                <button class="carousel-ver-mas-btn" onclick="showSection('Fotógrafos')">
                    Ver más <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>


    </div>

    <!-- ── SIDEBAR OVERLAY (móvil) ────────────────────────────────── -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ── GALLERY LAYOUT ─────────────────────────────────────────── -->
    <div class="gallery-layout hidden" id="galleryLayout">

        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <div>
                    <p class="sidebar-title-text">FOTOTECA</p>
                    <p class="sidebar-subtitle-text">Ancash Digital</p>
                </div>
                <button class="sidebar-close-btn" id="sidebarClose">✕</button>
            </div>

            <!-- Sección categorías -->
            <div class="sidebar-section">
                <h4 class="sidebar-section-label">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                    Distribución Geográfica
                </h4>
                <ul id="sidebarCategories" style="list-style:none;padding:0;margin:0;"></ul>
            </div>

            <div class="sidebar-footer" id="sidebarFooter">
                <p>Archivo Histórico Ancashino</p>
                <p id="sidebarPhotoCount">— fotografías catalogadas</p>
            </div>
        </aside>

        <!-- MAIN GALLERY -->
        <main class="gallery-main" id="galleryMain">
            <div class="topbar" id="galleryTopbar">
                <div class="topbar-left">
                    <button class="hamburger-btn" id="hamburgerBtn">
                        <span></span><span></span><span></span>
                    </button>
                    <div class="topbar-breadcrumb">
                        <span class="topbar-breadcrumb-home">Fototeca</span>
                        <span class="topbar-breadcrumb-sep">›</span>
                        <span class="topbar-breadcrumb-current" id="breadcrumbCurrent">Galería</span>
                    </div>
                </div>
                <div class="topbar-filters" id="topbarFilters">
                    <!-- period pills rendered by JS -->
                </div>
                <div class="sort-select-wrap">
                    <button class="sort-btn" id="sortBtn" aria-haspopup="listbox">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        <span id="sortLabel">Ordenar: A-Z</span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="sort-dropdown" id="sortDropdown" role="listbox">
                        <button class="sort-option active" data-value="az" role="option">A–Z</button>
                        <button class="sort-option" data-value="recent" role="option">Más recientes</button>
                        <button class="sort-option" data-value="old" role="option">Más antiguos</button>
                        <button class="sort-option" data-value="year_asc" role="option">Por año ↑</button>
                        <button class="sort-option" data-value="year_desc" role="option">Por año ↓</button>
                    </div>
                    <!-- hidden select for JS compatibility -->
                    <select id="sortSelect" style="display:none">
                        <option value="az">A-Z</option>
                        <option value="recent">Más recientes</option>
                        <option value="old">Más antiguos</option>
                        <option value="year_asc">Por año ↑</option>
                        <option value="year_desc">Por año ↓</option>
                    </select>
                </div>
            </div>

            <!-- ── GALERÍA HEADER (buscador + tags + título) ── -->
            <div class="gallery-header-area" id="galleryHeaderArea">

                <!-- Fila: título + buscador -->
                <div class="gallery-header-row">
                    <div class="gallery-context-title-row">
                        <div class="gallery-context-line"></div>
                        <h2 class="gallery-context-title" id="sectionTitle">Galería</h2>
                        <div class="gallery-context-line"></div>
                    </div>
                    <div class="gallery-search-wrap">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" id="contentSearchInput" class="gallery-search-input" placeholder="Buscar fotografías, fotógrafos, etiquetas…" autocomplete="off">
                    </div>
                </div>

                <!-- Fila: contador + tags -->
                <div class="gallery-tags-row" id="tagsBar" style="display:none;">
                    <span class="gallery-results-count"><span id="photoCount">0</span> resultado(s)</span>
                    <div id="tagsBarInner" class="tags-bar-inner"></div>
                </div>
                <!-- Contador sin tags -->
                <div class="gallery-results-only" id="galleryResultsOnly">
                    <span class="gallery-results-count"><span id="photoCountAlt">0</span> resultado(s)</span>
                </div>

            </div>

            <!-- Header para secciones sin sidebar (Fotógrafos) -->
            <div class="nosidebar-context-bar" id="nosidebarContextBar" style="display:none;">
                <div class="gallery-context-title-row">
                    <div class="gallery-context-line"></div>
                    <h2 class="gallery-context-title" id="sectionTitleAlt">Fotógrafos</h2>
                    <div class="gallery-context-line"></div>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                    <div class="gallery-results-count"><span id="photoCountNS">0</span> resultado(s)</div>
                    <div style="position:relative;width:260px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:#555;pointer-events:none;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input id="fotografosSearch" type="text" placeholder="Buscar fotógrafo..."
                            oninput="filterFotografosGrid(this.value)"
                            style="width:100%;padding:0.6rem 1rem 0.6rem 2.5rem;background:#111;border:1px solid #2a2a2a;border-radius:8px;color:#fff;font-size:0.83rem;outline:none;transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#c9a84c'" onblur="this.style.borderColor='#2a2a2a'">
                    </div>
                </div>
            </div>

            <div class="photo-grid" id="photosGrid"></div>
            <div id="photosPagination"></div>
        </main>
    </div>

    <!-- ── APORTANTES ──────────────────────────────────────────────── -->
    <div class="aportantes-section" id="aportantesSection">
        <div class="aportantes-inner">
            <div>
                <div class="aportantes-title-row">
                    <h1 class="aportantes-title">Fototeca Digital Ancashina</h1>
                    <div class="aportantes-divider"></div>
                </div>
                <div id="aportantesAccordion" style="display:flex;flex-direction:column;gap:0.4rem;">
                    <div class="aport-item" data-id="inicio">
                        <button class="aport-btn aport-active" onclick="toggleAportante('inicio')">
                            <div class="aport-icon">−</div>
                            <span class="aport-label">Inicio</span>
                        </button>
                        <div class="aport-content" style="max-height:1000px;opacity:1;">
                            <div class="aport-content-inner">
                                Nace con la idea de fortalecer la Identidad Cultural de las nuevas generaciones del Departamento de Ancash. Fue promovido inicialmente por la Sociedad Unión Progreso Soledad, en el año 2010. Luego, fue asumido por la Biblioteca Pública Municipal de Huaraz, como un servicio y producto a desarrollar y difundir, como parte de su función de rescatar y promover Identidad.
                            </div>
                        </div>
                    </div>
                    <div class="aport-item" data-id="antecedentes">
                        <button class="aport-btn" onclick="toggleAportante('antecedentes')">
                            <div class="aport-icon">+</div>
                            <span class="aport-label">Antecedentes</span>
                        </button>
                        <div class="aport-content">
                            <div class="aport-content-inner">
                                El sistema educativo no incluye en su currículo temas de historia, literatura, geografía, ciencias, etc., de manera específica sobre nuestra Región, por lo cual, las nuevas generaciones desconocen de nuestra historia, recursos y cultura. Asimismo, los docentes expresan que, para poder cubrir estas necesidades temáticas carecen de fuentes bibliográficas de donde poder tomar datos, información y conocimientos para incluirlos en la malla curricular, denotando la carencia de bibliotecas y fuentes primarias para obtener física o virtualmente estos conocimientos. Ante esta situación paupérrima y de miseria de fuentes de información sobre nuestra identidad, es que se generó el proyecto denominado "PORTAL DE LA CIENCIA Y CULTURA ANCASHINA".
                            </div>
                        </div>
                    </div>
                    <div class="aport-item" data-id="finalidad">
                        <button class="aport-btn" onclick="toggleAportante('finalidad')">
                            <div class="aport-icon">+</div>
                            <span class="aport-label">Finalidad</span>
                        </button>
                        <div class="aport-content">
                            <div class="aport-content-inner">
                                La Fototeca Digital Ancashina tiene por finalidad recopilar, preservar y difundir el patrimonio fotográfico de la Provincia de Huaraz, cuya concreción ha sido posible gracias a la alianza y cooperación entre la Biblioteca Municipal de Huaraz, la Sociedad Unión Progreso Soledad, el Club de Fotógrafos de Huaraz y La Sociedad Patriotica Sanchez Carrion - Luzuriaga y Mejía.
                            </div>
                        </div>
                    </div>
                    <div class="aport-item" data-id="responsables">
                        <button class="aport-btn" onclick="toggleAportante('responsables')">
                            <div class="aport-icon">+</div>
                            <span class="aport-label">Responsables</span>
                        </button>
                        <div class="aport-content">
                            <div class="aport-content-inner">
                                Giber Garcia Alamo y equipo del archivo fotográfico.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="director-title-row">
                    <h3 class="director-title">Director</h3>
                    <div class="aportantes-divider"></div>
                </div>
                <div class="director-card">
                    <div class="director-avatar">
                        <img src="{{ asset('giber.png') }}" alt="Giber Garcia Alamo">
                    </div>
                    <p class="director-name">Giber Garcia Alamo</p>
                    <p class="director-role">Bibliotecologo</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ── FOOTER ───────────────────────────────────────────────────── -->
    <footer class="site-footer">
        <p>© 2024 FOTOTECA WARAS — Archivo Visual Ancashino</p>
        <p>Preservando, digitalizando y compartiendo la memoria fotográfica e histórica de nuestra región.</p>
    </footer>

    <script>
        const PLACEHOLDER = 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?auto=format&fit=crop&w=800&q=80';

        // ── DATOS DESDE LARAVEL ──────────────────────────────────────
        const photosByCategory  = @json($photosByCategory ?? []);
        const photographersData = @json($photographersData ?? []);
        const categoriesFromDB  = @json($categoriesForFilters ?? []);
        const tagsFromDB        = @json($tagsData ?? []);

        const allPhotosFlat = (() => {
            const seen = new Set(); const result = [];
            Object.values(photosByCategory).flat().forEach(p => {
                if (!seen.has(p.id)) { seen.add(p.id); result.push(p); }
            });
            return result;
        })();

        const serverActiveSection = @json($activeSection ?? 'Inicio');

        const PHOTOS_PER_PAGE = 6; // 3 columnas × 2 filas

        // ── ESTADO ───────────────────────────────────────────────────
        let fotografosSearchQuery = '';
        let state = {
            activeTab:       'Inicio',
            activeCategory:  { id: null, name: 'Todas' },
            activeTagId:     null,
            currentPage:     1,
            openAccordions:  new Set(),
            closedAccordions: new Set()
        };

        // ── FILTRADO ─────────────────────────────────────────────────
        function getCurrentPhotos() {
            if (state.activeTab === 'Fotógrafos') {
                if (!fotografosSearchQuery) return photographersData;
                return photographersData.filter(p =>
                    (p.full_name || '').toLowerCase().includes(fotografosSearchQuery)
                );
            }
            let base = allPhotosFlat;
            if (state.activeCategory.id !== null) {
                const catName = state.activeCategory.name;
                base = photosByCategory[catName] || [];
            }
            if (state.activeTagId !== null) {
                base = base.filter(p => p.tag_id === state.activeTagId);
            }
            const rawQ = document.getElementById('contentSearchInput')?.value?.trim();
            const q = rawQ ? rawQ.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'') : '';
            if (q) {
                const norm = s => (s||'').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');
                base = base.filter(p =>
                    norm(p.title).includes(q)||norm(p.photographer).includes(q)||
                    norm(p.description).includes(q)||norm(p.location).includes(q)||
                    norm(String(p.year)).includes(q)||
                    norm(p.tag_name||'').includes(q)
                );
            }
            return base;
        }

        function getSortedPhotos(items) {
            const sortVal = document.getElementById('sortSelect')?.value ?? 'az';
            const arr = [...items];
            if (sortVal==='az') arr.sort((a,b)=>(a.title||a.full_name||'').localeCompare(b.title||b.full_name||'','es'));
            else if (sortVal==='recent') arr.sort((a,b)=>(parseInt(b.year)||0)-(parseInt(a.year)||0));
            else if (sortVal==='old') arr.sort((a,b)=>(parseInt(a.year)||9999)-(parseInt(b.year)||9999));
            else if (sortVal==='year_asc') arr.sort((a,b)=>(parseInt(a.year)||0)-(parseInt(b.year)||0));
            else if (sortVal==='year_desc') arr.sort((a,b)=>(parseInt(b.year)||0)-(parseInt(a.year)||0));
            return arr;
        }

        // ── RENDER TAGS BAR & SIDEBAR ────────────────────────────────
        function renderTagsBar() {
            const inner = document.getElementById('tagsBarInner');
            if (!inner || !tagsFromDB || tagsFromDB.length === 0) return;
            inner.innerHTML = tagsFromDB.map(tag => {
                const active = state.activeTagId === tag.id;
                return `<button onclick="filterByTag(${tag.id},'${tag.name.replace(/'/g,"\\'")}',this)"
                    class="tag-pill${active ? ' tag-pill-active' : ''}"
                    data-tag-id="${tag.id}">${tag.name}</button>`;
            }).join('');
        }

        function renderSidebarTags() {
            // etiquetas movidas al header principal; no-op
        }

        function filterByTag(tagId, tagName, el) {
            state.activeTagId = state.activeTagId === tagId ? null : tagId;
            state.currentPage = 1;
            renderTagsBar();
            renderSidebarTags();
            renderPhotos();
        }

        // ── PAGINACIÓN ───────────────────────────────────────────────
        function renderPagination(containerId, total, perPage, currentPage, onPageChange) {
            const el = document.getElementById(containerId);
            if (!el) return;
            const totalPages = Math.ceil(total / perPage);
            if (totalPages <= 1) { el.innerHTML = ''; return; }

            const range = (from, to) => Array.from({length: to - from + 1}, (_, i) => from + i);
            let pages = [];
            if (totalPages <= 7) {
                pages = range(1, totalPages);
            } else if (currentPage <= 4) {
                pages = [...range(1, 5), '…', totalPages];
            } else if (currentPage >= totalPages - 3) {
                pages = [1, '…', ...range(totalPages - 4, totalPages)];
            } else {
                pages = [1, '…', currentPage - 1, currentPage, currentPage + 1, '…', totalPages];
            }

            el.innerHTML = pages.map(p => p === '…'
                ? `<span class="foto-page-ellipsis">…</span>`
                : `<button class="foto-page-btn${p === currentPage ? ' foto-page-active' : ''}" onclick="(${onPageChange.toString()})(${p})">${p}</button>`
            ).join('');
        }

        // ── RENDER GRILLA ────────────────────────────────────────────
        function renderPhotos() {
            const grid = document.getElementById('photosGrid');
            const allItems = getSortedPhotos(getCurrentPhotos());
            const hasTags = tagsFromDB && tagsFromDB.length > 0;
            document.getElementById('photoCount').textContent = allItems.length;
            const altCount = document.getElementById('photoCountAlt');
            if (altCount) altCount.textContent = allItems.length;
            const tagsBarEl = document.getElementById('tagsBar');
            const resultsOnly = document.getElementById('galleryResultsOnly');
            if (tagsBarEl) tagsBarEl.style.display = hasTags ? '' : 'none';
            if (resultsOnly) resultsOnly.style.display = hasTags ? 'none' : '';
            document.getElementById('sidebarPhotoCount').textContent = allPhotosFlat.length + ' fotografías catalogadas';

            // no-sidebar context bar (Fotógrafos)
            const nsBar = document.getElementById('nosidebarContextBar');
            const isFotografos = state.activeTab === 'Fotógrafos';
            if (nsBar) nsBar.style.display = isFotografos ? '' : 'none';
            const nsCount = document.getElementById('photoCountNS');
            if (nsCount) nsCount.textContent = allItems.length;
            const nsTitle = document.getElementById('sectionTitleAlt');
            if (nsTitle) nsTitle.textContent = state.activeTab;

            const totalPages = Math.ceil(allItems.length / PHOTOS_PER_PAGE);
            if (state.currentPage > totalPages) state.currentPage = Math.max(1, totalPages);
            const start = (state.currentPage - 1) * PHOTOS_PER_PAGE;
            const items = allItems.slice(start, start + PHOTOS_PER_PAGE);

            // ── Fotógrafos ──
            if (isFotografos) {
                grid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                grid.style.maxWidth = ''; grid.style.margin = '';
                grid.innerHTML = allItems.length === 0
                    ? `<div style="grid-column:1/-1;text-align:center;padding:4rem 0;color:var(--text-muted);">No hay fotógrafos registrados.</div>`
                    : items.map((p, i) => `
                        <div class="photographer-card" onclick="window.location.href='/fototeca/fotografos/${p.id}';sessionStorage.setItem('fototeca_tab','Fotógrafos')" style="animation-delay:${i*0.06}s">
                            <div class="pg-img-wrap">
                                <div class="pg-img-overlay"></div>
                                ${p.photo_path
                                    ? `<img src="${p.photo_path}" alt="${p.full_name}" class="pg-img" loading="lazy" onerror="this.style.display='none'">`
                                    : `<div class="pg-placeholder"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg></div>`}
                            </div>
                            <div class="pg-info">
                                <h3 class="pg-name">${p.full_name}</h3>
                                <p class="pg-bio">${p.biography || 'Sin biografía disponible.'}</p>
                                <div class="pg-footer">
                                    <span class="pg-footer-link">Ver colección</span>
                                    <span class="pg-count-badge">${p.photos_count} foto${p.photos_count!==1?'s':''}</span>
                                </div>
                            </div>
                        </div>`).join('');
                renderPagination('photosPagination', allItems.length, PHOTOS_PER_PAGE, state.currentPage, (p) => {
                    state.currentPage = p;
                    renderPhotos();
                    document.getElementById('photosGrid')?.scrollIntoView({behavior:'smooth', block:'start'});
                });
                return;
            }

            // ── Galería de fotos ──
            grid.style.gridTemplateColumns = 'repeat(3, 1fr)';
            grid.style.maxWidth = ''; grid.style.margin = '';

            if (allItems.length === 0) {
                grid.innerHTML = `<div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;padding:5rem 2rem;gap:1rem;color:var(--text-muted);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    <p style="font-family:'Playfair Display',serif;font-size:1.2rem;">Sin resultados</p>
                    <p style="font-size:0.85rem;">No se encontraron fotografías con los filtros aplicados.</p>
                    </div>`;
                document.getElementById('photosPagination').innerHTML = '';
                return;
            }

            grid.innerHTML = items.map((photo, i) => `
                <div class="photo-card" data-index="${i}" style="animation-delay:${i*0.05}s" onclick="(function(){sessionStorage.setItem('fototeca_tab','${state.activeTab}');window.location.href='${'/fototeca/galeria/'}${photo.id}'})()">
                    <div class="photo-card-inner">
                        <div class="photo-card-img-wrap">
                            <div class="photo-corner photo-corner--tl"></div>
                            <div class="photo-corner photo-corner--br"></div>
                            <img src="${photo.image_url || PLACEHOLDER}" alt="${photo.title}"
                                 class="photo-card-img" loading="lazy"
                                 onerror="this.src='${PLACEHOLDER}'">
                            <div class="photo-card-overlay">
                                <div class="photo-card-overlay-content">
                                    <p class="overlay-year">${photo.year||'S/F'}</p>
                                    ${photo.location ? `<p class="overlay-location"><svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>${photo.location}</p>` : ''}
                                </div>
                            </div>
                            ${photo.year ? `<span class="photo-card-badge">${photo.year}</span>` : ''}
                        </div>
                        <div class="photo-card-info">
                            <h3 class="photo-card-title">${photo.title}</h3>
                            <div class="photo-card-meta">
                                ${photo.photographer ? `<span class="meta-photographer"><svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>${photo.photographer}</span>` : ''}
                                <div class="meta-categories">${(photo.categories||[]).slice(0,2).map(c=>`<span class="cat-badge">${c}</span>`).join('')}</div>
                            </div>
                        </div>
                    </div>
                </div>`).join('');

            renderPagination('photosPagination', allItems.length, PHOTOS_PER_PAGE, state.currentPage, (p) => {
                state.currentPage = p;
                renderPhotos();
                document.getElementById('photosGrid')?.scrollIntoView({behavior:'smooth', block:'start'});
            });
        }

        // ── RENDER SIDEBAR ───────────────────────────────────────────
        function isAncestorOfActive(node, activeId) {
            if (!activeId || !node.children) return false;
            for (const child of node.children) {
                if (child.id === activeId) return true;
                if (isAncestorOfActive(child, activeId)) return true;
            }
            return false;
        }

        function buildNodeHtml(node, depth) {
            const hasChildren = node.children && node.children.length > 0;
            const manuallyClosed = state.closedAccordions.has(node.id);
            const isOpen = !manuallyClosed && (state.openAccordions.has(node.id) || isAncestorOfActive(node, state.activeCategory.id));
            const isActive = state.activeCategory.id === node.id;
            const indent = (2 + depth * 1) + 'rem';

            if (hasChildren) {
                const childrenHtml = node.children.map(child => buildNodeHtml(child, depth+1)).join('');
                return `<li>
                    <button class="accordion-btn ${isActive?'accordion-btn--active':''}" data-parent-id="${node.id}" style="padding-left:${indent}">
                        <svg class="accordion-icon" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                        <span class="accordion-btn-text">${node.name}</span>
                        <svg class="accordion-chevron ${isOpen?'open':''}" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="accordion-panel ${isOpen?'open':''}" style="padding-left:0.5rem;">
                        <ul style="list-style:none;padding:0;margin:0;">${childrenHtml}</ul>
                    </div>
                </li>`;
            } else {
                return `<li>
                    <button class="sidebar-leaf ${isActive?'active':''}" data-cat-id="${node.id}" data-cat-name="${node.name}" style="padding-left:${indent}">
                        <span class="leaf-dot"></span>${node.name}
                    </button>
                </li>`;
            }
        }

        function renderSidebar() {
            const list = document.getElementById('sidebarCategories');
            const todosActive = state.activeCategory.id === null;
            let html = `<li>
                <button class="accordion-btn ${todosActive?'accordion-btn--active':''}" id="acc-todos" style="padding-left:1rem;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span class="accordion-btn-text">Toda la Colección</span>
                </button>
            </li>`;
            if (categoriesFromDB.length > 0) {
                html += categoriesFromDB.map(node => buildNodeHtml(node, 0)).join('');
            } else {
                Object.keys(photosByCategory).forEach(name => {
                    const isActive = state.activeCategory.name === name;
                    html += `<li><button class="accordion-btn ${isActive?'accordion-btn--active':''}" data-cat-name="${name}" style="padding-left:1rem;"><span class="accordion-btn-text">${name}</span></button></li>`;
                });
            }
            list.innerHTML = html;

            list.querySelector('#acc-todos')?.addEventListener('click', () => {
                state.activeCategory = { id: null, name: 'Todas' };
                state.activeTagId = null;
                state.openAccordions.clear(); state.closedAccordions.clear();
                document.getElementById('sectionTitle').textContent = state.activeTab;
                document.getElementById('breadcrumbCurrent').textContent = state.activeTab;
                renderSidebar(); renderPhotos(); renderTagsBar(); renderSidebarTags(); closeSidebar();
            });

            list.querySelectorAll('.accordion-btn[data-parent-id]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const pid = parseInt(btn.getAttribute('data-parent-id'));
                    const isCurrentlyOpen = btn.querySelector('.accordion-chevron')?.classList.contains('open');
                    if (isCurrentlyOpen) { state.openAccordions.delete(pid); state.closedAccordions.add(pid); }
                    else { state.closedAccordions.delete(pid); state.openAccordions.add(pid); }
                    renderSidebar();
                });
            });

            list.querySelectorAll('.sidebar-leaf[data-cat-id]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id   = parseInt(btn.getAttribute('data-cat-id'));
                    const name = btn.getAttribute('data-cat-name');
                    state.activeCategory = { id, name };
                    state.activeTagId = null;
                    document.getElementById('sectionTitle').textContent = name;
                    document.getElementById('breadcrumbCurrent').textContent = name;
                    renderSidebar(); renderPhotos(); renderTagsBar(); renderSidebarTags(); closeSidebar();
                });
            });

            list.querySelectorAll('.accordion-btn[data-cat-name]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const name = btn.getAttribute('data-cat-name');
                    state.activeCategory = { id: null, name };
                    state.activeTagId = null;
                    document.getElementById('sectionTitle').textContent = name;
                    document.getElementById('breadcrumbCurrent').textContent = name;
                    renderSidebar(); renderPhotos(); renderTagsBar(); renderSidebarTags(); closeSidebar();
                });
            });
        }

        // ── SECCIONES ────────────────────────────────────────────────
        function hideAllSections() {
            document.getElementById('heroSection').classList.add('hidden');
            document.getElementById('inicioSection').classList.add('hidden');
            document.getElementById('galleryLayout').classList.add('hidden');
            document.getElementById('aportantesSection').style.display = 'none';
        }

        const TABS_NO_SIDEBAR = new Set(['Fotógrafos']);

        function showSection(tab) {
            state.activeTab = tab;
            state.activeCategory = { id: null, name: 'Todas' };
            state.activeTagId = null;
            fotografosSearchQuery = '';
            const fsInput = document.getElementById('fotografosSearch');
            if (fsInput) fsInput.value = '';
            state.openAccordions.clear(); state.closedAccordions.clear();
            hideAllSections();

            if (tab === 'Aportantes') {
                document.getElementById('aportantesSection').style.display = 'block';
            } else if (tab === 'Inicio') {
                document.getElementById('heroSection').classList.remove('hidden');
                document.getElementById('inicioSection').classList.remove('hidden');
            } else {
                const layout = document.getElementById('galleryLayout');
                layout.classList.remove('hidden');
                layout.classList.toggle('no-sidebar', TABS_NO_SIDEBAR.has(tab));
                document.getElementById('sidebar').classList.toggle('no-sidebar', TABS_NO_SIDEBAR.has(tab));
                document.getElementById('sectionTitle').textContent = tab;
                document.getElementById('breadcrumbCurrent').textContent = tab;
                document.getElementById('contentSearchInput').value = '';
                renderSidebar(); renderPhotos(); renderTagsBar(); renderSidebarTags();
            }
            updateNav();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (window._updateNavBg) window._updateNavBg();
        }

        function updateNav() {
            document.querySelectorAll('.nav-item-btn').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-tab') === state.activeTab);
            });
            const tabUrlMap = {
                'Inicio':     '{{ route('fototeca.dashboard') }}',
                'Galería':    '{{ route('fototeca.galeria.index') }}',
                'Fotógrafos': '{{ route('fototeca.fotografos.index') }}',
                'Aportantes': '{{ route('fototeca.aportantes.index') }}',
            };
            if (tabUrlMap[state.activeTab]) history.replaceState(null, '', tabUrlMap[state.activeTab]);
        }

        // ── BÚSQUEDA HERO ────────────────────────────────────────────
        const heroInput    = document.getElementById('heroSearchInput');
        const heroDropdown = document.getElementById('heroDropdown');
        const heroBtn      = document.getElementById('heroSearchBtn');

        function normalizeStr(s) { return (s||'').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,''); }

        function renderHeroDropdown(q) {
            if (!q) { heroDropdown.classList.remove('open'); return; }
            const nq = normalizeStr(q);
            const seen = new Set();
            const unique = Object.values(photosByCategory).flat().filter(p => { if(seen.has(p.id)) return false; seen.add(p.id); return true; });
            const matchPhotos = unique.filter(p =>
                normalizeStr(p.title).includes(nq)||normalizeStr(p.photographer).includes(nq)||
                normalizeStr(p.location).includes(nq)||normalizeStr(String(p.year)).includes(nq)
            ).slice(0,5);
            const matchPhotographers = photographersData.filter(p =>
                normalizeStr(p.full_name).includes(nq)||normalizeStr(p.biography).includes(nq)
            ).slice(0,3);
            const total = matchPhotos.length + matchPhotographers.length;
            if (total === 0) {
                heroDropdown.innerHTML = `<div class="hsd-empty">Sin resultados para "<strong>${q}</strong>"</div>`;
                heroDropdown.classList.add('open'); return;
            }
            let html = '';
            if (matchPhotos.length) {
                html += `<div class="hsd-section-label">Fotografías</div>`;
                html += matchPhotos.map(p => `
                    <div class="hsd-item" data-action="photo" data-id="${p.id}">
                        <div class="hsd-thumb">${p.image_url ? `<img src="${p.image_url}" alt="" onerror="this.style.display='none'">` : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>'}</div>
                        <div class="hsd-info">
                            <div class="hsd-title">${p.title}</div>
                            <div class="hsd-sub">${p.photographer}${p.year&&p.year!=='S/F'?' · '+p.year:''}</div>
                        </div>
                        <span class="hsd-badge">Foto</span>
                    </div>`).join('');
            }
            if (matchPhotographers.length) {
                html += `<div class="hsd-section-label">Fotógrafos</div>`;
                html += matchPhotographers.map(p => `
                    <a class="hsd-item" href="/fototeca/fotografos/${p.id}">
                        <div class="hsd-thumb">${p.photo_path ? `<img src="${p.photo_path}" alt="">` : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'}</div>
                        <div class="hsd-info">
                            <div class="hsd-title">${p.full_name}</div>
                            <div class="hsd-sub">${p.photos_count} foto${p.photos_count!==1?'s':''}</div>
                        </div>
                        <span class="hsd-badge">Fotógrafo</span>
                    </a>`).join('');
            }
            html += `<button class="hsd-all-btn" id="hsdAllBtn">Ver todos los resultados para "${q}" →</button>`;
            heroDropdown.innerHTML = html;
            heroDropdown.classList.add('open');

            heroDropdown.querySelectorAll('.hsd-item[data-action="photo"]').forEach(el => {
                el.addEventListener('click', () => {
                    const id = parseInt(el.dataset.id);
                    const item = Object.values(photosByCategory).flat().find(p => p.id === id);
                    if (!item) return;
                    heroDropdown.classList.remove('open');
                    heroInput.value = '';
                    if (item.detail_url) { sessionStorage.setItem('fototeca_tab','Galería'); window.location.href = item.detail_url; }
                    else { showSection('Galería'); }
                });
            });

            document.getElementById('hsdAllBtn')?.addEventListener('click', () => {
                heroDropdown.classList.remove('open');
                showSection('Galería');
                const ci = document.getElementById('contentSearchInput');
                ci.value = q; ci.dispatchEvent(new Event('input'));
            });
        }

        heroInput.addEventListener('input', () => renderHeroDropdown(heroInput.value.trim()));
        heroBtn.addEventListener('click', () => {
            const q = heroInput.value.trim();
            heroDropdown.classList.remove('open');
            showSection('Galería');
            if (q) { const ci = document.getElementById('contentSearchInput'); ci.value = q; ci.dispatchEvent(new Event('input')); }
        });
        heroInput.addEventListener('keydown', e => { if(e.key==='Enter') heroBtn.click(); });
        document.addEventListener('click', e => { if (!e.target.closest('.hero-search-container')) heroDropdown.classList.remove('open'); });

        // ── EVENTOS ──────────────────────────────────────────────────
        document.getElementById('contentSearchInput')?.addEventListener('input', () => { state.currentPage = 1; renderPhotos(); });
        document.getElementById('logoBtn')?.addEventListener('click', () => showSection('Inicio'));

        // ── SORT DROPDOWN ─────────────────────────────────────────────
        (function() {
            const btn      = document.getElementById('sortBtn');
            const dropdown = document.getElementById('sortDropdown');
            const label    = document.getElementById('sortLabel');
            const select   = document.getElementById('sortSelect');
            if (!btn) return;

            const labels = { az: 'Ordenar: A–Z', recent: 'Ordenar: Recientes', old: 'Ordenar: Antiguos', year_asc: 'Ordenar: Año ↑', year_desc: 'Ordenar: Año ↓' };

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                btn.classList.toggle('open');
                dropdown.classList.toggle('open');
            });

            dropdown.querySelectorAll('.sort-option').forEach(opt => {
                opt.addEventListener('click', () => {
                    const val = opt.dataset.value;
                    select.value = val;
                    label.textContent = labels[val];
                    dropdown.querySelectorAll('.sort-option').forEach(o => o.classList.remove('active'));
                    opt.classList.add('active');
                    btn.classList.remove('open');
                    dropdown.classList.remove('open');
                    state.currentPage = 1;
                    renderPhotos();
                });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.sort-select-wrap')) {
                    btn.classList.remove('open');
                    dropdown.classList.remove('open');
                }
            });
        })();

        document.querySelectorAll('.nav-item-btn').forEach(btn => {
            btn.addEventListener('click', () => showSection(btn.getAttribute('data-tab')));
        });

        // ── SIDEBAR MÓVIL ────────────────────────────────────────────
        function openSidebar() {
            document.getElementById('sidebar').classList.add('sidebar--open');
            document.getElementById('sidebarOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('sidebar--open');
            document.getElementById('sidebarOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.getElementById('hamburgerBtn')?.addEventListener('click', openSidebar);
        document.getElementById('sidebarClose')?.addEventListener('click', closeSidebar);
        document.getElementById('sidebarOverlay')?.addEventListener('click', closeSidebar);

        // ── NAV TRANSPARENTE EN HERO ─────────────────────────────────
        (function() {
            const nav = document.getElementById('globalNav');

            function updateNavBg() {
                const isInicio = state.activeTab === 'Inicio';
                if (isInicio && window.scrollY < 60) {
                    nav.classList.add('nav-transparent');
                } else {
                    nav.classList.remove('nav-transparent');
                }
            }

            window.addEventListener('scroll', updateNavBg, { passive: true });

            // Exponer para que showSection lo llame al cambiar de tab
            window._updateNavBg = updateNavBg;
            updateNavBg();
        })();

        // ── NAV MÓVIL ────────────────────────────────────────────────
        (function() {
            const btn  = document.getElementById('globalNavHamburger');
            const menu = document.getElementById('globalNavMobile');
            if (!btn||!menu) return;
            btn.addEventListener('click', () => {
                const isOpen = menu.classList.contains('open');
                btn.classList.toggle('open', !isOpen);
                menu.classList.toggle('open', !isOpen);
            });
            document.addEventListener('click', e => {
                if (!btn.contains(e.target)&&!menu.contains(e.target)) {
                    btn.classList.remove('open'); menu.classList.remove('open');
                }
            });
        })();

        // ── APORTANTES ACORDEÓN ───────────────────────────────────────
        function toggleAportante(id) {
            document.querySelectorAll('#aportantesAccordion .aport-item').forEach(item => {
                const isTarget = item.getAttribute('data-id') === id;
                const btn     = item.querySelector('.aport-btn');
                const icon    = item.querySelector('.aport-icon');
                const content = item.querySelector('.aport-content');
                const isOpen  = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';
                if (isTarget) {
                    if (isOpen) {
                        content.style.maxHeight = '0px'; content.style.opacity = '0';
                        icon.textContent = '+'; btn.classList.remove('aport-active');
                    } else {
                        content.style.maxHeight = '1000px'; content.style.opacity = '1';
                        icon.textContent = '−'; btn.classList.add('aport-active');
                    }
                } else {
                    content.style.maxHeight = '0px'; content.style.opacity = '0';
                    icon.textContent = '+'; btn.classList.remove('aport-active');
                }
            });
        }
        window.toggleAportante = toggleAportante;

        // ========== CARRUSELES DE INICIO ==========
        (function() {
            const CARD_W_PHOTO  = 340 + 28;
            const CARD_W_AUTHOR = 150 + 20;

            const rawGaleria    = Object.values(photosByCategory).flat().filter((p, i, a) => a.findIndex(x => x.id === p.id) === i);
            const rawFotografos = photographersData;
            function photoCardHTML(photo) {
                return `<div class="ftc-carousel-card" onclick="window.location.href='${photo.detail_url}'">
                    ${photo.image_url
                        ? `<img class="ftc-card-cover" src="${photo.image_url}" alt="${photo.title}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="ftc-card-cover-placeholder">📷</div>`}
                    <div class="ftc-card-body">
                        <p class="ftc-card-title">${photo.title}</p>
                        <p class="ftc-card-sub">${photo.photographer}</p>
                    </div>
                </div>`;
            }

            function fotografoCardHTML(p) {
                return `<div class="ftc-author-card" onclick="window.location.href='/fototeca/fotografos/${p.id}'">
                    ${p.photo_path
                        ? `<img class="ftc-author-avatar" src="${p.photo_path}" alt="${p.full_name}" loading="lazy" onerror="this.style.display='none'">`
                        : `<div class="ftc-author-placeholder">👤</div>`}
                    <div class="ftc-author-body">
                        <p class="ftc-author-name">${p.full_name}</p>
                        <p class="ftc-author-count">${p.photos_count} foto${p.photos_count !== 1 ? 's' : ''}</p>
                    </div>
                </div>`;
            }

            function shuffle(arr) {
                const a = [...arr];
                for (let i = a.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [a[i], a[j]] = [a[j], a[i]];
                }
                return a;
            }

            function fillTo(base, minLen) {
                let out = [];
                while (out.length < minLen) out = out.concat(base);
                return out;
            }

            function buildCarousel(trackId, dotsId, rawItems, cardFn, cardW) {
                if (!rawItems.length) return null;
                const track  = document.getElementById(trackId);
                const dotsEl = document.getElementById(dotsId);
                if (!track || !dotsEl) return null;

                const base = shuffle(rawItems).slice(0, 20);
                const n    = base.length;

                const visibleCount = Math.ceil(window.innerWidth / cardW) + 2;
                const minTotal     = visibleCount * 7;
                const pool         = fillTo(base, minTotal);
                const total        = pool.length;

                track.innerHTML = pool.map(cardFn).join('');
                track.style.gap = '0';

                let current = Math.floor(total / 2);
                current = Math.round(current / n) * n;
                let busy = false;
                let autoTimer;

                dotsEl.innerHTML = '';
                const dotCount = Math.min(n, 8);
                for (let i = 0; i < dotCount; i++) {
                    const d = document.createElement('div');
                    d.className = 'ico-dot' + (i === 0 ? ' active' : '');
                    const target = current + i;
                    d.addEventListener('click', () => { if (!busy) go(target); });
                    dotsEl.appendChild(d);
                }

                function applyTransform(animated) {
                    track.style.transition = animated ? 'transform 500ms ease-in-out' : 'none';
                    track.style.transform  = `translateX(${-current * cardW}px)`;
                }

                function updateDots() {
                    dotsEl.querySelectorAll('.ico-dot').forEach((d, i) => {
                        d.classList.toggle('active', i === ((current % n + n) % n));
                    });
                }

                function go(next) {
                    if (busy) return;
                    busy = true;
                    current = next;
                    applyTransform(true);
                    updateDots();
                    setTimeout(() => {
                        const safeZone = visibleCount * 2;
                        if (current >= total - safeZone) {
                            current -= Math.floor(total / 2 / n) * n;
                            applyTransform(false);
                            updateDots();
                        } else if (current < safeZone) {
                            current += Math.floor(total / 2 / n) * n;
                            applyTransform(false);
                            updateDots();
                        }
                        busy = false;
                    }, 520);
                }

                function startAuto() {
                    clearInterval(autoTimer);
                    autoTimer = setInterval(() => { if (!busy) go(current + 1); }, 3500);
                }

                applyTransform(false);
                updateDots();
                startAuto();

                return {
                    go,
                    startAuto,
                    get current() { return current; },
                    get autoTimer() { return autoTimer; }
                };
            }

            const ftcCarousels = {};

            function initCarousels() {
                ftcCarousels.galeria    = buildCarousel('trackGaleria',    'dotsGaleria',    rawGaleria,    photoCardHTML,    CARD_W_PHOTO);
                ftcCarousels.fotografos = buildCarousel('trackFotografos', 'dotsFotografos', rawFotografos, fotografoCardHTML, CARD_W_AUTHOR);
            }

            window.moveFtcCarousel = function(name, dir) {
                const c = ftcCarousels[name];
                if (!c) return;
                clearInterval(c.autoTimer);
                c.go(c.current + dir);
                c.startAuto();
            };

            let initialized = false;
            const observer = new MutationObserver(() => {
                const sec = document.getElementById('inicioSection');
                if (sec && !sec.classList.contains('hidden') && !initialized) {
                    initialized = true;
                    initCarousels();
                }
            });
            const sec = document.getElementById('inicioSection');
            if (sec) observer.observe(sec, { attributes: true, attributeFilter: ['class'] });

            if (sec && !sec.classList.contains('hidden')) {
                initialized = true;
                initCarousels();
            }
        })();
        // ========== FIN CARRUSELES ==========

        // ── INICIO ───────────────────────────────────────────────────
        const validTabs = ['Inicio','Galería','Fotógrafos','Aportantes'];
        const pendingTab = sessionStorage.getItem('fototeca_tab');
        if (pendingTab && validTabs.includes(pendingTab)) {
            sessionStorage.removeItem('fototeca_tab');
            showSection(pendingTab);
        } else {
            showSection(validTabs.includes(serverActiveSection) ? serverActiveSection : 'Inicio');
        }

        // Filtro de fotógrafos — filtra datos y re-renderiza con paginación correcta
        function filterFotografosGrid(q) {
            fotografosSearchQuery = q.toLowerCase().trim();
            state.currentPage = 1;
            renderPhotos();
        }
    </script>
    <x-floating-buttons />
</body>
</html>
