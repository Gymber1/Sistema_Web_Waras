<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} — Biblioteca WARAS</title>
    <link rel="icon" type="image/png" href="/Logo-Biblioteca-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/biblioteca-libro.css')
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
        <a href="{{ route('biblioteca.libros.index') }}" class="mobile-nav-item active">Biblioteca Digital</a>
        <a href="{{ route('biblioteca.editorial.index') }}" class="mobile-nav-item">Waras Editorial</a>
        <a href="{{ route('biblioteca.revistas.index') }}" class="mobile-nav-item">Revistas</a>
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
            <a href="{{ route('biblioteca.libros.index') }}" class="nav-item active">Biblioteca Digital</a>
            <a href="{{ route('biblioteca.revistas.index') }}" class="nav-item">Revistas</a>
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
        <a id="breadcrumbSection" href="{{ route('biblioteca.dashboard') }}" class="breadcrumb-link">Libros</a>
        <span>›</span>
        <span class="breadcrumb-current">{{ Str::limit($book->title, 50) }}</span>
    </div>

    <div class="detail-card">
        <div class="cover-box">
            @if($book->cover_image_path)
                <img src="{{ Storage::url($book->cover_image_path) }}" alt="{{ $book->title }}" class="cover-img"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cover-placeholder" style="display:none;background:linear-gradient(135deg,#5c4033,#3a2a1e)">📚</div>
            @else
                <div class="cover-placeholder" style="background:linear-gradient(135deg,#5c4033,#3a2a1e)">📚</div>
            @endif
        </div>

        <div class="info-box">
            <span class="book-type-badge">{{ $book->document_type ?? 'Libro' }}</span>
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
                @if($book->city)
                <span class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $book->city }}</span>
                @endif
                @if($book->editorial_name)
                <span class="meta-item"><i class="fas fa-building"></i> {{ $book->editorial_name }}</span>
                @endif
                @if($book->publication_year)
                <span class="meta-item"><i class="fas fa-calendar-alt"></i> {{ $book->publication_year }}</span>
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

            @if($book->descriptors->count())
            <p class="section-label">Descriptores</p>
            <div class="cats">
                @foreach($book->descriptors as $desc)
                    <a href="{{ route('biblioteca.libros.index', ['descriptor' => $desc->name]) }}"
                       class="cat-badge cat-badge-link" style="background:#f0fdf4;color:#166534;border-color:#bbf7d0;text-decoration:none;"
                       title="Ver libros con el descriptor «{{ $desc->name }}»">{{ $desc->name }}</a>
                @endforeach
            </div>
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

                <button id="btnShare" class="btn-icon" title="Compartir">
                    <i class="fas fa-share-alt"></i>
                </button>
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
        const returnUrl  = sessionStorage.getItem('biblioteca_return_url'); // URL exacta del catálogo (con ?descriptor=)
        const tab  = sessionStorage.getItem('biblioteca_tab') || 'Libros';
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
            // Contexto explícito (p. ej. desde una colección/especial)
            backBtn.href = backUrl;
            bc.href = backUrl;
            bc.textContent = backLabel || 'Especiales';
            sessionStorage.removeItem('back_url');
            sessionStorage.removeItem('back_label');
        }

        else if (returnUrl) {
            // Regresar exactamente al catálogo desde donde se abrió el libro
            // (conserva el filtro por descriptor u otra vista).
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

    // ═══ COMPARTIR ═══
    function openShareModal() {
        const url  = encodeURIComponent(window.location.href);
        const text = encodeURIComponent(@json($book->title) + ' · Biblioteca Digital Ancashina');
        document.getElementById('share-facebook').href = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
        document.getElementById('share-twitter').href  = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + text;
        document.getElementById('share-whatsapp').href = 'https://wa.me/?text=' + text + '%20' + url;
        const m = document.getElementById('shareModal');
        m.hidden = false;
        document.body.style.overflow = 'hidden';
    }
    function closeShareModal() {
        const m = document.getElementById('shareModal');
        if (m) m.hidden = true;
        document.body.style.overflow = '';
    }
    function copyShareLink() {
        const url = window.location.href;
        const toast = document.getElementById('shareToast');
        navigator.clipboard.writeText(url).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = url; document.body.appendChild(ta); ta.select();
            document.execCommand('copy'); document.body.removeChild(ta);
        }).finally(() => {
            closeShareModal();
            if (toast) {
                toast.style.display = 'block';
                setTimeout(() => { toast.style.display = 'none'; }, 2500);
            }
        });
    }
    document.getElementById('btnShare').addEventListener('click', openShareModal);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeShareModal(); });
</script>
    
<!-- ═══ MODAL COMPARTIR ═══ -->
<div id="shareModal" class="bib-share-overlay" hidden onclick="if(event.target===this)closeShareModal()">
    <div class="bib-share-box" role="dialog" aria-modal="true" aria-labelledby="shareModalTitle">
        <div class="bib-share-head">
            <span class="bib-share-title" id="shareModalTitle">Compartir libro</span>
            <button onclick="closeShareModal()" class="bib-share-close" aria-label="Cerrar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <p class="bib-share-sub">{{ $book->title }}</p>
        <div class="bib-share-grid">
            <a id="share-facebook" href="#" target="_blank" rel="noopener" class="bib-share-btn bib-share-fb">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                Facebook
            </a>
            <a id="share-twitter" href="#" target="_blank" rel="noopener" class="bib-share-btn bib-share-x">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                X / Twitter
            </a>
            <a id="share-whatsapp" href="#" target="_blank" rel="noopener" class="bib-share-btn bib-share-wa">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM11.999 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.878-1.404A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.522 2 12 2z"/></svg>
                WhatsApp
            </a>
            <button onclick="copyShareLink()" class="bib-share-btn bib-share-copy">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                Copiar enlace
            </button>
        </div>
    </div>
</div>

    <x-floating-buttons />

<script>
    // ═══ PANEL DE FILTROS EN LA FICHA ═══
    (function () {
        const CATS      = @json($categoriesForFilters ?? []);
        const CATALOG   = '{{ route('biblioteca.libros.index') }}';
        const TAB       = 'Libros';
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
