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
        <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item active">Revistas</a>
        <a href="{{ route('biblioteca.autores.index') }}" class="mobile-nav-item">Autores</a>
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
            <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item active">Revistas</a>
            <a href="{{ route('biblioteca.autores.index') }}" class="nav-item">Autores</a>
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

<!-- Overlay del panel en móvil -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

<div class="detail-layout" id="detailLayout">
    <!-- Botón flotante para volver a mostrar el panel -->
    <button class="sidebar-show-btn" id="sidebarShowBtn" onclick="toggleSidebarCollapse()" title="Mostrar panel de materias">
        <i class="fas fa-filter"></i> Materias
    </button>

    <!-- ═══ PANEL DE FILTROS ═══ -->
    <aside class="sidebar" id="mobileSidebar">
        <div class="sidebar-header" style="justify-content:space-between">
            <div style="display:flex;align-items:center;gap:0.75rem">
                <i class="fas fa-filter"></i>
                <span class="sidebar-title">Explorar Catálogo</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.9rem">
                <button onclick="toggleSidebarCollapse()" id="sidebarCollapseBtn" class="sidebar-collapse-btn" title="Ocultar panel"><i class="fas fa-angles-left"></i></button>
                <button onclick="closeMobileSidebar()" id="sidebarCloseBtn" class="sidebar-close-btn"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="categories-section">
            <div class="categories-label">Materias</div>
            <ul class="categories-list" id="categoriesList"></ul>
        </div>
    </aside>

    <div class="page-body">
    <button class="sidebar-toggle-btn" onclick="openMobileSidebar()"><i class="fas fa-filter"></i>&nbsp; Filtrar por materia</button>
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

            @if($book->provider)
            <p class="section-label">Proveedor</p>
            <p class="section-text">{{ $book->provider }}</p>
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

</div><!-- /detail-layout -->

<script>
    (function() {
        const backUrl    = sessionStorage.getItem('back_url');
        const backLabel  = sessionStorage.getItem('back_label');
        const returnUrl  = sessionStorage.getItem('biblioteca_return_url'); // URL exacta del catálogo
        const tab  = sessionStorage.getItem('biblioteca_tab') || 'Revistas';
        const base = '{{ route('biblioteca.dashboard') }}';
        const backBtn = document.getElementById('backBtn');
        const bc      = document.getElementById('breadcrumbSection');

        // Al volver al catálogo, pedirle que restaure el filtro que estaba activo
        function markFilterRestore() {
            try {
                const raw = sessionStorage.getItem('biblioteca_filter_ctx');
                if (!raw) return;
                const c = JSON.parse(raw);
                c.restore = true;
                sessionStorage.setItem('biblioteca_filter_ctx', JSON.stringify(c));
            } catch (e) {}
        }
        [backBtn, bc].forEach(el => el && el.addEventListener('click', markFilterRestore));


        if (backUrl) {
            backBtn.href = backUrl;
            bc.href = backUrl;
            bc.textContent = backLabel || 'Especiales';
            sessionStorage.removeItem('back_url');
            sessionStorage.removeItem('back_label');
        }

        else if (returnUrl) {
            backBtn.href = returnUrl;
            bc.href = returnUrl;
            bc.textContent = tab;
            sessionStorage.removeItem('biblioteca_return_url');
        } else {
            backBtn.href = base + '#' + tab;
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

<script>
    // ═══ PANEL DE FILTROS EN LA FICHA ═══
    (function () {
        const CATS      = @json($categoriesForFilters ?? []);
        const CATALOG   = '{{ route('biblioteca.revistas.index') }}';
        const TAB       = 'Revistas';
        const open      = new Set();   // ramas abiertas

        function nodeHtml(node, depth) {
            const kids = node.children && node.children.length;
            const pad  = (1.5 + depth * 0.875) + 'rem';
            if (kids) {
                const isOpen = open.has(node.id);
                return '<li>' +
                    '<button class="acc-parent-btn' + (isOpen ? ' open' : '') + '" data-parent="' + node.id + '" style="padding-left:' + pad + ';">' +
                        '<span>' + node.name + '</span><i class="fas fa-chevron-right acc-chevron"></i>' +
                    '</button>' +
                    '<div class="acc-children' + (isOpen ? ' open' : '') + '"><ul style="list-style:none;padding:0;margin:0;">' +
                        node.children.map(c => nodeHtml(c, depth + 1)).join('') +
                    '</ul></div></li>';
            }
            const rootStyle = depth === 0 ? 'font-weight:700;color:#374151;' : '';
            return '<li><button class="acc-child-btn" data-cat="' + node.id + '" data-name="' + node.name.replace(/"/g, '&quot;') + '" style="padding-left:' + pad + ';' + rootStyle + '">' +
                   '<span>' + node.name + '</span><i class="fas fa-chevron-right category-icon" style="font-size:0.65rem;flex-shrink:0;"></i></button></li>';
        }

        function render() {
            const list = document.getElementById('categoriesList');
            if (!list) return;
            list.innerHTML =
                '<li><button class="category-btn" data-cat="" data-name="Todos"><span>Todos</span>' +
                '<i class="fas fa-chevron-right category-icon"></i></button></li>' +
                CATS.map(n => nodeHtml(n, 0)).join('');

            list.querySelectorAll('.acc-parent-btn').forEach(b => b.addEventListener('click', () => {
                const id = parseInt(b.dataset.parent);
                open.has(id) ? open.delete(id) : open.add(id);
                render();
            }));
            // Al elegir una materia se vuelve al catálogo con ese filtro puesto
            list.querySelectorAll('.acc-child-btn, .category-btn').forEach(b => b.addEventListener('click', () => {
                const id   = b.dataset.cat;
                const name = b.dataset.name;
                try {
                    sessionStorage.setItem('biblioteca_filter_ctx', JSON.stringify({
                        restore: true, tab: TAB,
                        categoryId: id ? parseInt(id) : null,
                        categoryName: name, page: 1, openAcc: Array.from(open), closedAcc: []
                    }));
                    sessionStorage.setItem('biblioteca_tab', TAB);
                } catch (e) {}
                window.location.href = CATALOG;
            }));
        }
        render();
    })();

    // ── Ocultar / mostrar el panel (se recuerda la preferencia) ──
    function toggleSidebarCollapse() {
        const l = document.getElementById('detailLayout');
        if (!l) return;
        const collapsed = l.classList.toggle('sidebar-collapsed');
        try { localStorage.setItem('biblioteca_sidebar_collapsed', collapsed ? '1' : '0'); } catch (e) {}
    }
    function openMobileSidebar() {
        document.getElementById('mobileSidebar')?.classList.add('open');
        document.getElementById('sidebarOverlay')?.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeMobileSidebar() {
        document.getElementById('mobileSidebar')?.classList.remove('open');
        document.getElementById('sidebarOverlay')?.classList.remove('open');
        document.body.style.overflow = '';
    }
    (function () {
        try {
            if (localStorage.getItem('biblioteca_sidebar_collapsed') === '1') {
                document.getElementById('detailLayout')?.classList.add('sidebar-collapsed');
            }
        } catch (e) {}
    })();
</script>
</body>
</html>
