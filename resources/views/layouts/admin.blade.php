<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WARAS Admin')</title>
    <link rel="icon" type="image/png" href="/Logo-Panel-Waras.png">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Public Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#eef2ff',
                            100: '#e0e7ff',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        },
                        dark: {
                            bg:      '#0f172a',
                            surface: '#1e293b',
                            border:  '#334155',
                        }
                    },
                    boxShadow: {
                        'premium':      '0 2px 6px 0 rgba(67,89,113,0.12)',
                        'premium-dark': '0 2px 6px 0 rgba(0,0,0,0.25)',
                    }
                }
            }
        }

        // Anti-FOUC
        if (localStorage.getItem('theme') === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite('resources/css/admin.css')

    <style>
        /* Scrollbar Premium */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Transiciones globales */
        body, aside, header, div, span, button, p, h1, h2, h3, h4, a,
        table, th, td, input, select, textarea, label {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.2s ease;
        }

        /* Animación de entrada para el contenido */
        .admin-content-wrap {
            animation: fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Accordion sidebar */
        .nav-submenu { overflow: hidden; max-height: 0; transition: max-height 0.3s ease; }
        .nav-submenu.open { max-height: 600px; }
        .nav-chevron { transition: transform 0.25s ease; }
        .nav-chevron.open { transform: rotate(180deg); }

        /* Mobile overlay */
        #sidebar-overlay { transition: opacity 0.25s ease; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-dark-bg text-slate-600 dark:text-slate-400 font-sans h-screen flex overflow-hidden selection:bg-brand-500/30">

    {{-- Overlay móvil --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 opacity-0 pointer-events-none lg:hidden" onclick="closeSidebar()"></div>

    {{-- ═══════════════════════════════════════════════════════════
         SIDEBAR — exactamente como Nuevo_Panel.txt
    ═══════════════════════════════════════════════════════════ --}}
    <aside id="sidebar"
        class="fixed lg:relative z-50 lg:z-auto w-64 bg-[#0b1120] flex flex-col h-full border-r border-[#1e293b] flex-shrink-0 shadow-[0_0_15px_0_rgba(0,0,0,0.5)] -translate-x-full lg:translate-x-0"
        style="transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);">

        {{-- Logo --}}
        <div class="h-20 flex items-center px-6 border-b border-[#1e293b]/50 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shadow-lg shadow-brand-500/30">
                    <i data-lucide="library" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="font-bold text-white tracking-wide text-xl leading-tight">WARAS</p>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest leading-tight">Admin Portal</p>
                </div>
            </div>
            <button onclick="closeSidebar()" class="ml-auto lg:hidden p-1.5 text-slate-500 hover:text-white rounded-lg hover:bg-[#1e293b]">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        {{-- Navegación --}}
        <div class="flex-1 overflow-y-auto py-4 px-4 space-y-6">

            {{-- Dashboard --}}
            <div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg font-medium transition-colors
                            {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-slate-300 hover:bg-[#1e293b] hover:text-white' }}">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Módulos --}}
            <div>
                <p class="px-4 text-[11px] font-semibold text-slate-500 uppercase tracking-widest mb-3">Módulos</p>
                <ul class="space-y-1">

                    {{-- Biblioteca --}}
                    @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
                    <li>
                        <button type="button" onclick="toggleNav('bib')"
                            class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                            {{ request()->routeIs('admin.biblioteca.*') ? 'bg-[#1e293b] text-white' : 'text-slate-300 hover:bg-[#1e293b] hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <i data-lucide="book-open" class="w-5 h-5 flex-shrink-0 text-slate-400"></i>
                                <span>Biblioteca</span>
                            </div>
                            <i data-lucide="chevron-down" id="chevron-bib"
                                class="w-4 h-4 text-slate-500 nav-chevron {{ request()->routeIs('admin.biblioteca.*') ? 'open' : '' }}"></i>
                        </button>
                        <ul id="submenu-bib" class="nav-submenu pl-12 pr-3 pt-1 space-y-1 {{ request()->routeIs('admin.biblioteca.*') ? 'open' : '' }}">
                            @php $bibLinks = [
                                ['route'=>'admin.biblioteca.index',        'pattern'=>'admin.biblioteca.index',         'label'=>'Detalles'],
                                ['route'=>'admin.biblioteca.books',        'pattern'=>'admin.biblioteca.books*',        'label'=>'Libros'],
                                ['route'=>'admin.biblioteca.authors',      'pattern'=>'admin.biblioteca.authors*',      'label'=>'Autores'],
                                ['route'=>'admin.biblioteca.categories',   'pattern'=>'admin.biblioteca.categories*',   'label'=>'Categorías'],
                                ['route'=>'admin.biblioteca.subcategories','pattern'=>'admin.biblioteca.subcategories*','label'=>'SubCategorías'],
                                ['route'=>'admin.biblioteca.magazines',    'pattern'=>'admin.biblioteca.magazines*',    'label'=>'Revistas'],
                                ['route'=>'admin.biblioteca.specials',            'pattern'=>'admin.biblioteca.specials',            'label'=>'Especiales'],
                                ['route'=>'admin.biblioteca.specials.assign-books','pattern'=>'admin.biblioteca.specials.assign-books','label'=>'Agregar a Especiales'],
                                ['route'=>'admin.biblioteca.descriptors',  'pattern'=>'admin.biblioteca.descriptors*', 'label'=>'Descriptores'],
                            ]; @endphp
                            @foreach($bibLinks as $l)
                            <li>
                                <a href="{{ route($l['route']) }}"
                                    class="relative block px-3 py-2 rounded-md text-sm transition-colors
                                    {{ request()->routeIs($l['pattern']) ? 'text-white font-semibold bg-[#1e293b]' : 'text-slate-400 hover:text-white hover:bg-[#1e293b]' }}">
                                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full
                                        {{ request()->routeIs($l['pattern']) ? 'bg-brand-500' : 'bg-slate-600' }}"></span>
                                    {{ $l['label'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    {{-- Fototeca --}}
                    @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
                    <li>
                        <button type="button" onclick="toggleNav('foto')"
                            class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                            {{ request()->routeIs('admin.fototeca.*') ? 'bg-[#1e293b] text-white' : 'text-slate-300 hover:bg-[#1e293b] hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <i data-lucide="image" class="w-5 h-5 flex-shrink-0 text-slate-400"></i>
                                <span>Fototeca</span>
                            </div>
                            <i data-lucide="chevron-down" id="chevron-foto"
                                class="w-4 h-4 text-slate-500 nav-chevron {{ request()->routeIs('admin.fototeca.*') ? 'open' : '' }}"></i>
                        </button>
                        <ul id="submenu-foto" class="nav-submenu pl-12 pr-3 pt-1 space-y-1 {{ request()->routeIs('admin.fototeca.*') ? 'open' : '' }}">
                            @php $fotoLinks = [
                                ['route'=>'admin.fototeca.index',        'pattern'=>'admin.fototeca.index',         'label'=>'Detalles'],
                                ['route'=>'admin.fototeca.photos',       'pattern'=>'admin.fototeca.photos*',       'label'=>'Fotos'],
                                ['route'=>'admin.fototeca.photographers','pattern'=>'admin.fototeca.photographers*','label'=>'Fotógrafos'],
                                ['route'=>'admin.fototeca.categories',   'pattern'=>'admin.fototeca.categories*',   'label'=>'Categorías'],
                                ['route'=>'admin.fototeca.subcategories','pattern'=>'admin.fototeca.subcategories*','label'=>'SubCategorías'],
                                ['route'=>'admin.fototeca.sublevels',    'pattern'=>'admin.fototeca.sublevels*',    'label'=>'1er Nivel'],
                                ['route'=>'admin.fototeca.secondlevels', 'pattern'=>'admin.fototeca.secondlevels*','label'=>'2do Nivel'],
                                ['route'=>'admin.fototeca.thirdlevels',  'pattern'=>'admin.fototeca.thirdlevels*', 'label'=>'3er Nivel'],
                                ['route'=>'admin.fototeca.tags',         'pattern'=>'admin.fototeca.tags*',         'label'=>'Etiquetas'],
                                ['route'=>'admin.fototeca.collections',        'pattern'=>'admin.fototeca.collections*',        'label'=>'Colecciones'],
                                ['route'=>'admin.fototeca.assign-collections',  'pattern'=>'admin.fototeca.assign-collections*', 'label'=>'Agregar a Colecciones'],
                            ]; @endphp
                            @foreach($fotoLinks as $l)
                            <li>
                                <a href="{{ route($l['route']) }}"
                                    class="relative block px-3 py-2 rounded-md text-sm transition-colors
                                    {{ request()->routeIs($l['pattern']) ? 'text-white font-semibold bg-[#1e293b]' : 'text-slate-400 hover:text-white hover:bg-[#1e293b]' }}">
                                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full
                                        {{ request()->routeIs($l['pattern']) ? 'bg-brand-500' : 'bg-slate-600' }}"></span>
                                    {{ $l['label'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                </ul>
            </div>

            {{-- Próximamente --}}
            <div>
                <p class="px-4 text-[11px] font-semibold text-slate-500 uppercase tracking-widest mb-3">Próximamente</p>
                <ul class="space-y-1">
                    @foreach([
                        ['icon'=>'music',        'label'=>'Musicoteca'],
                        ['icon'=>'palette',       'label'=>'Pinacoteca'],
                        ['icon'=>'calendar-days', 'label'=>'Efemeridades'],
                        ['icon'=>'database',      'label'=>'Catálogo KOHA'],
                    ] as $item)
                    <li>
                        <span class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-500 cursor-not-allowed">
                            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 flex-shrink-0 opacity-50"></i>
                            <span>{{ $item['label'] }}</span>
                            <span class="ml-auto text-[9px] font-bold bg-slate-800 text-slate-400 px-1.5 py-0.5 rounded uppercase tracking-wide">Pronto</span>
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Ajustes --}}
            @if(auth()->user()->is_admin_global)
            <div>
                <p class="px-4 text-[11px] font-semibold text-slate-500 uppercase tracking-widest mb-3">Ajustes</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.usuarios.index') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                            {{ request()->routeIs('admin.usuarios.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-slate-300 hover:bg-[#1e293b] hover:text-white' }}">
                            <i data-lucide="users" class="w-5 h-5 flex-shrink-0 text-slate-400"></i>
                            <span>Usuarios y Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.web-config.index') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                            {{ request()->routeIs('admin.web-config.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-slate-300 hover:bg-[#1e293b] hover:text-white' }}">
                            <i data-lucide="settings" class="w-5 h-5 flex-shrink-0 text-slate-400"></i>
                            <span>Configurar Web</span>
                        </a>
                    </li>
                </ul>
            </div>
            @endif

        </div>

    </aside>

    {{-- ═══════════════════════════════════════════════════════════
         ÁREA PRINCIPAL
    ═══════════════════════════════════════════════════════════ --}}
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

        {{-- Header flotante premium — fiel al prototipo --}}
        <div class="px-6 pt-6 pb-2 flex-shrink-0">
            <header class="h-16 bg-white dark:bg-dark-surface rounded-xl flex items-center justify-between px-6 shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border z-10">

                {{-- Izquierda: hamburger + breadcrumb --}}
                <div class="flex items-center gap-3 min-w-0">
                    <button onclick="openSidebar()" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex-shrink-0">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div class="flex items-center gap-2 text-sm min-w-0">
                        <span class="font-bold text-brand-600 dark:text-brand-400 flex-shrink-0 tracking-wide">WARAS PANEL</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                        <span class="font-medium text-slate-700 dark:text-slate-200 truncate">@yield('section', 'Dashboard')</span>
                    </div>
                </div>

                {{-- Derecha --}}
                <div class="flex items-center gap-2 flex-shrink-0">

                    {{-- Theme toggle --}}
                    <button id="theme-toggle" title="Cambiar tema"
                        class="p-2 rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <i id="icon-moon" data-lucide="moon" class="w-5 h-5"></i>
                        <i id="icon-sun"  data-lucide="sun"  class="w-5 h-5 hidden"></i>
                    </button>

                    {{-- Portal público --}}
                    <a href="{{ route('home') }}" target="_blank"
                        class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/10 hover:bg-brand-100 dark:hover:bg-brand-500/20 border border-brand-100 dark:border-brand-500/20 transition-colors">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        <span>Portal Principal</span>
                    </a>

                    {{-- Separador + sesión --}}
                    <div class="flex items-center gap-3 pl-3 ml-1 border-l border-slate-200 dark:border-slate-700">
                        <div class="w-9 h-9 rounded-full bg-brand-500 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 leading-tight">{{ auth()->user()->name }}</span>
                            <span class="text-[11px] font-bold text-brand-500 dark:text-brand-400 uppercase tracking-wide leading-tight">{{ auth()->user()->is_admin_global ? 'Admin Global' : 'Moderador' }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 border border-red-200 dark:border-red-500/30 transition-colors">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </header>
        </div>

        {{-- Contenido dinámico con scroll interno --}}
        <div class="flex-1 overflow-y-auto px-6 pb-8 pt-4">
            <div class="admin-content-wrap">
                @yield('content')
            </div>
        </div>
        @stack('modals')
    </main>

    {{-- Modal de confirmación global --}}
    <div id="confirm-modal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="confirmCancel()"></div>
            <div class="relative bg-white dark:bg-dark-surface rounded-2xl shadow-2xl w-full max-w-md border border-slate-200/50 dark:border-dark-border">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-semibold text-slate-800 dark:text-white">Confirmar eliminación</h3>
                            <p id="confirm-message" class="mt-1 text-sm text-slate-500 dark:text-slate-400"></p>
                        </div>
                    </div>
                </div>
                <div class="px-6 pb-6 flex justify-end gap-3">
                    <button onclick="confirmCancel()"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button id="confirm-ok" onclick="confirmProceed()"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors shadow-lg shadow-red-500/20">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Lightbox global --}}
    <div id="lightbox" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4" onclick="closeLightbox()">
        <div class="absolute inset-0 bg-black/85 backdrop-blur-sm"></div>
        <div class="relative max-w-5xl max-h-[90vh] flex flex-col items-center" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between w-full mb-3 px-1">
                <span id="lightbox-title" class="text-white font-semibold text-sm truncate max-w-[80%]"></span>
                <div class="flex items-center gap-2">
                    <a id="lightbox-open" href="#" target="_blank"
                        class="text-slate-300 hover:text-white text-xs flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition-colors">
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i> Ver original
                    </a>
                    <button onclick="closeLightbox()"
                        class="text-slate-300 hover:text-white p-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
        </div>
    </div>

    <script>
        lucide.createIcons();

        // ── Dark Mode ────────────────────────────────────────────
        const themeToggleBtn = document.getElementById('theme-toggle');
        const iconMoon       = document.getElementById('icon-moon');
        const iconSun        = document.getElementById('icon-sun');
        const htmlEl         = document.documentElement;

        function updateThemeIcon() {
            const isDark = htmlEl.classList.contains('dark');
            iconMoon.classList.toggle('hidden', isDark);
            iconSun.classList.toggle('hidden', !isDark);
        }
        updateThemeIcon();

        themeToggleBtn.addEventListener('click', () => {
            htmlEl.classList.toggle('dark');
            localStorage.setItem('theme', htmlEl.classList.contains('dark') ? 'dark' : 'light');
            updateThemeIcon();
        });

        // ── Sidebar móvil ────────────────────────────────────────
        function openSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebar-overlay');
            sb.classList.remove('-translate-x-full');
            ov.classList.remove('pointer-events-none');
            ov.classList.replace('opacity-0', 'opacity-100');
        }
        function closeSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebar-overlay');
            sb.classList.add('-translate-x-full');
            ov.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => ov.classList.add('pointer-events-none'), 250);
        }
        document.getElementById('sidebar').addEventListener('click', function(e) {
            if (window.innerWidth < 1024 && e.target.closest('a[href]')) closeSidebar();
        });

        // ── Accordion sidebar ────────────────────────────────────
        function toggleNav(key) {
            document.getElementById('submenu-' + key).classList.toggle('open');
            document.getElementById('chevron-' + key).classList.toggle('open');
        }

        // ── Lightbox ─────────────────────────────────────────────
        function openLightbox(src, title) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-title').textContent = title || '';
            document.getElementById('lightbox-open').href = src;
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox-img').src = '';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeLightbox(); confirmCancel(); } });

        // ── Modal de confirmación global ─────────────────────────
        let _confirmForm = null;
        function confirmDelete(form, message) {
            _confirmForm = form;
            document.getElementById('confirm-message').textContent = message;
            document.getElementById('confirm-modal').classList.remove('hidden');
        }
        function confirmProceed() {
            if (_confirmForm) _confirmForm.submit();
            confirmCancel();
        }
        function confirmCancel() {
            document.getElementById('confirm-modal').classList.add('hidden');
            _confirmForm = null;
        }
    </script>
    @stack('scripts')

    {{-- ── Modal eliminación masiva ── --}}
    <div id="bulk-delete-modal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeBulkModal()"></div>
            <div class="relative bg-white dark:bg-dark-surface rounded-2xl shadow-2xl w-full max-w-lg border border-slate-200/50 dark:border-dark-border">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-dark-border">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-red-100 dark:bg-red-500/10 flex items-center justify-center">
                            <i data-lucide="trash-2" class="w-4 h-4 text-red-600 dark:text-red-400"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-white" id="bulk-modal-title">Eliminar seleccionados</h3>
                    </div>
                    <button onclick="closeBulkModal()" class="p-1.5 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="px-6 py-5" id="bulk-modal-body">
                    {{-- filled by JS --}}
                </div>
                <div class="px-6 py-4 border-t border-slate-100 dark:border-dark-border flex justify-end gap-3">
                    <button onclick="closeBulkModal()" class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button id="bulk-confirm-btn" class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors shadow-lg shadow-red-500/30 flex items-center gap-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span id="bulk-confirm-label">Eliminar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    /* ── Bulk-select global ── */
    const TRASH_SVG = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>`;
    const CHECKSQ_SVG = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>`;

    function initBulkSelect(tableId) {
        const table   = document.getElementById(tableId);
        if (!table) return;
        const selectAll = table.querySelector('.check-all');
        const rows      = () => table.querySelectorAll('.row-check:not(.check-all)');
        const wrapper   = table.closest('.bulk-wrapper');
        const bar       = wrapper?.querySelector('.bulk-bar');

        // Build the bar contents matching Nuevo_Panel design
        if (bar) {
            bar.innerHTML = `
                <div class="bulk-counter">
                    <span>${CHECKSQ_SVG}</span>
                    <span><span class="bulk-count">0</span> seleccionados</span>
                </div>
                <span class="bulk-sep"></span>
                <div class="bulk-actions disabled">
                    <button type="button" class="bulk-delete-btn" title="Eliminar seleccionados">
                        ${TRASH_SVG} Eliminar seleccionados
                    </button>
                </div>`;
            bar.querySelector('.bulk-delete-btn').addEventListener('click', () => openBulkDeleteModal(table));
        }

        const countEl = bar?.querySelector('.bulk-count');

        function update() {
            const checked = table.querySelectorAll('.row-check:not(.check-all):checked');
            if (selectAll) selectAll.checked = rows().length > 0 && checked.length === rows().length;
            if (countEl) countEl.textContent = checked.length;
            // Toggle disabled state on actions group
            const actionsGroup = bar?.querySelector('.bulk-actions');
            if (actionsGroup) {
                actionsGroup.classList.toggle('disabled', checked.length === 0);
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', () => {
                rows().forEach(cb => { cb.checked = selectAll.checked; });
                update();
            });
        }
        table.addEventListener('change', e => {
            if (e.target.classList.contains('row-check')) update();
        });

        // Initial state
        update();
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('table[id]').forEach(t => initBulkSelect(t.id));
    });

    /* ── Bulk delete modal ── */
    let _bulkAction = null;

    function openBulkDeleteModal(table) {
        const checked = Array.from(table.querySelectorAll('.row-check:not(.check-all):checked'));
        const ids     = checked.map(cb => cb.value);
        const count   = ids.length;
        const tableId = table.id;

        // Detect context from table id
        const isBibCategories    = tableId === 'table-bib-categories';
        const isBibSubcategories = tableId === 'table-sub';
        const isFotoCategories   = tableId === 'table-foto-categories';
        const isFotoSubcategories= tableId === 'table-foto-subcategories';

        const modal     = document.getElementById('bulk-delete-modal');
        const body      = document.getElementById('bulk-modal-body');
        const title     = document.getElementById('bulk-modal-title');
        const confirmBtn= document.getElementById('bulk-confirm-btn');
        const confirmLbl= document.getElementById('bulk-confirm-label');

        lucide.createIcons();

        // ── Categorías Biblioteca ──
        if (isBibCategories) {
            // Fetch child counts via data attributes on rows
            const rowsWithChildren = [];
            checked.forEach(cb => {
                const row  = cb.closest('tr');
                const name = row?.querySelector('td:nth-child(2)')?.textContent?.trim() ?? '';
                // We'll ask the server via a hidden approach — but simpler: rely on row data
                // Actually read from the DOM: if we stored child count we could use it
                // Since we don't have it rendered, we show a generic cascade option
                rowsWithChildren.push({ id: cb.value, name });
            });

            title.textContent = `Eliminar ${count} categoría(s)`;
            body.innerHTML = `
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-4">Estás a punto de eliminar <strong>${count}</strong> categoría(s). Las categorías pueden tener subcategorías conectadas.</p>
                <div class="mb-4 max-h-36 overflow-y-auto space-y-1">
                    ${rowsWithChildren.map(r => `<div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/40 px-3 py-1.5 rounded-lg"><i data-lucide="folder" class="w-3.5 h-3.5 text-brand-400 shrink-0"></i>${r.name}</div>`).join('')}
                </div>
                <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl p-4">
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-3">¿Qué deseas hacer con las subcategorías conectadas?</p>
                    <label class="flex items-start gap-2.5 cursor-pointer mb-2">
                        <input type="radio" name="bulk-cascade" value="0" checked class="mt-0.5 accent-brand-500">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Eliminar <strong>solo la(s) categoría(s)</strong> seleccionada(s) (las subcategorías quedan huérfanas)</span>
                    </label>
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="radio" name="bulk-cascade" value="1" class="mt-0.5 accent-brand-500">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Eliminar la(s) categoría(s) <strong>y todas sus subcategorías conectadas</strong></span>
                    </label>
                </div>`;
            lucide.createIcons({ node: body });
            confirmLbl.textContent = `Eliminar ${count} categoría(s)`;
            _bulkAction = () => submitBulk('{{ route("admin.biblioteca.categories.bulk-destroy") }}', ids, () => document.querySelector('input[name="bulk-cascade"]:checked')?.value === '1');
        }

        // ── Subcategorías Biblioteca ──
        else if (isBibSubcategories) {
            const names = checked.map(cb => cb.closest('tr')?.querySelector('td:nth-child(2)')?.textContent?.trim() ?? '');
            title.textContent = `Eliminar ${count} subcategoría(s)`;
            body.innerHTML = `
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-3">¿Eliminar las siguientes <strong>${count}</strong> subcategoría(s)?</p>
                <div class="max-h-48 overflow-y-auto space-y-1">
                    ${names.map(n => `<div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/40 px-3 py-1.5 rounded-lg"><i data-lucide="chevron-right" class="w-3.5 h-3.5 text-brand-400 shrink-0"></i>${n}</div>`).join('')}
                </div>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-3">Esta acción no se puede deshacer.</p>`;
            lucide.createIcons({ node: body });
            confirmLbl.textContent = `Eliminar ${count} subcategoría(s)`;
            _bulkAction = () => submitBulk('{{ route("admin.biblioteca.subcategories.bulk-destroy") }}', ids, () => false);
        }

        // ── Categorías Fototeca ──
        else if (isFotoCategories) {
            const rowsInfo = checked.map(cb => ({ id: cb.value, name: cb.closest('tr')?.querySelector('td:nth-child(2)')?.textContent?.trim() ?? '' }));
            title.textContent = `Eliminar ${count} categoría(s)`;
            body.innerHTML = `
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-4">Estás a punto de eliminar <strong>${count}</strong> categoría(s) de fototeca. Cada categoría puede tener subcategorías y subniveles.</p>
                <div class="mb-4 max-h-36 overflow-y-auto space-y-1">
                    ${rowsInfo.map(r => `<div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/40 px-3 py-1.5 rounded-lg"><i data-lucide="folder" class="w-3.5 h-3.5 text-brand-400 shrink-0"></i>${r.name}</div>`).join('')}
                </div>
                <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl p-4">
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-3">¿Qué deseas hacer con las subcategorías y subniveles conectados?</p>
                    <label class="flex items-start gap-2.5 cursor-pointer mb-2">
                        <input type="radio" name="bulk-cascade" value="0" checked class="mt-0.5 accent-brand-500">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Eliminar <strong>solo la(s) categoría(s)</strong> (subcategorías y subniveles quedan huérfanos)</span>
                    </label>
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="radio" name="bulk-cascade" value="1" class="mt-0.5 accent-brand-500">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Eliminar la(s) categoría(s) <strong>y todos sus subcategorías + subniveles</strong></span>
                    </label>
                </div>`;
            lucide.createIcons({ node: body });
            confirmLbl.textContent = `Eliminar ${count} categoría(s)`;
            _bulkAction = () => submitBulk('{{ route("admin.fototeca.categories.bulk-destroy") }}', ids, () => document.querySelector('input[name="bulk-cascade"]:checked')?.value === '1');
        }

        // ── Subcategorías Fototeca ──
        else if (isFotoSubcategories) {
            const rowsInfo = checked.map(cb => ({ id: cb.value, name: cb.closest('tr')?.querySelector('td:nth-child(2)')?.textContent?.trim() ?? '' }));
            title.textContent = `Eliminar ${count} subcategoría(s)`;
            body.innerHTML = `
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-4">Las subcategorías pueden tener subniveles conectados.</p>
                <div class="mb-4 max-h-36 overflow-y-auto space-y-1">
                    ${rowsInfo.map(r => `<div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/40 px-3 py-1.5 rounded-lg"><i data-lucide="chevron-right" class="w-3.5 h-3.5 text-brand-400 shrink-0"></i>${r.name}</div>`).join('')}
                </div>
                <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl p-4">
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-3">¿Qué deseas hacer con los subniveles conectados?</p>
                    <label class="flex items-start gap-2.5 cursor-pointer mb-2">
                        <input type="radio" name="bulk-cascade" value="0" checked class="mt-0.5 accent-brand-500">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Eliminar <strong>solo la(s) subcategoría(s)</strong> (subniveles quedan huérfanos)</span>
                    </label>
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="radio" name="bulk-cascade" value="1" class="mt-0.5 accent-brand-500">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Eliminar subcategoría(s) <strong>y todos sus subniveles</strong></span>
                    </label>
                </div>`;
            lucide.createIcons({ node: body });
            confirmLbl.textContent = `Eliminar ${count} subcategoría(s)`;
            _bulkAction = () => submitBulk('{{ route("admin.fototeca.subcategories.bulk-destroy") }}', ids, () => document.querySelector('input[name="bulk-cascade"]:checked')?.value === '1');
        }

        // ── Genérico (sin reglas especiales) ──
        else {
            const routeMap = {
                'table-books':           '{{ route("admin.biblioteca.books.bulk-destroy") }}',
                'table-magazines':       '{{ route("admin.biblioteca.magazines.bulk-destroy") }}',
                'table-authors':         '{{ route("admin.biblioteca.authors.bulk-destroy") }}',
                'table-publishers':      '{{ route("admin.biblioteca.publishers.bulk-destroy") }}',
                'table-specials':        '{{ route("admin.biblioteca.specials.bulk-destroy") }}',
                'table-photos':          '{{ route("admin.fototeca.photos.bulk-destroy") }}',
                'table-photographers':   '{{ route("admin.fototeca.photographers.bulk-destroy") }}',
                'table-sublevels':       '{{ route("admin.fototeca.sublevels.bulk-destroy") }}',
                'table-secondlevels':    '{{ route("admin.fototeca.secondlevels.bulk-destroy") }}',
                'table-thirdlevels':     '{{ route("admin.fototeca.thirdlevels.bulk-destroy") }}',
                'table-foto-collections':'{{ route("admin.fototeca.collections.bulk-destroy") }}',
                'table-descriptors':     '{{ route("admin.biblioteca.descriptors.bulk-destroy") }}',
                'table-tags':            '{{ route("admin.fototeca.tags.bulk-destroy") }}',
                'table-users':           '{{ route("admin.usuarios.bulk-destroy") }}',
            };
            const actionUrl = routeMap[tableId];
            const labelMap  = {
                'table-books': 'libro(s)', 'table-magazines': 'revista(s)', 'table-authors': 'autor(es)',
                'table-publishers': 'editorial(es)', 'table-specials': 'colección(es)',
                'table-photos': 'fotografía(s)', 'table-photographers': 'fotógrafo(s)',
                'table-sublevels': 'subnivel(es)', 'table-secondlevels': '2do nivel(es)', 'table-thirdlevels': '3er nivel(es)',
                'table-foto-collections': 'colección(es)', 'table-descriptors': 'descriptor(es)', 'table-tags': 'etiqueta(s)', 'table-users': 'usuario(s)',
            };
            const item = labelMap[tableId] ?? 'elemento(s)';
            title.textContent = `Eliminar ${count} ${item}`;
            body.innerHTML = `
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-3">¿Confirmas la eliminación de <strong>${count}</strong> ${item}?</p>
                <p class="text-xs text-red-600 dark:text-red-400 font-medium">⚠ Esta acción no se puede deshacer.</p>`;
            confirmLbl.textContent = `Eliminar ${count} ${item}`;
            _bulkAction = () => submitBulk(actionUrl, ids, () => false);
        }

        confirmBtn.onclick = () => { if (_bulkAction) _bulkAction(); };
        modal.classList.remove('hidden');
        lucide.createIcons();
    }

    function submitBulk(url, ids, getCascade) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.style.display = 'none';

        const csrf = document.createElement('input');
        csrf.type = 'hidden'; csrf.name = '_token';
        csrf.value = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
        form.appendChild(csrf);

        const method = document.createElement('input');
        method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
        form.appendChild(method);

        const idsInput = document.createElement('input');
        idsInput.type = 'hidden'; idsInput.name = 'ids'; idsInput.value = ids.join(',');
        form.appendChild(idsInput);

        if (getCascade()) {
            const cas = document.createElement('input');
            cas.type = 'hidden'; cas.name = 'cascade'; cas.value = '1';
            form.appendChild(cas);
        }

        document.body.appendChild(form);
        form.submit();
    }

    function closeBulkModal() {
        document.getElementById('bulk-delete-modal').classList.add('hidden');
        _bulkAction = null;
    }
    </script>
</body>
</html>
