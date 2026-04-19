<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - WARAS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 8px; height: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        
        /* Colores temáticos por módulo */
        .theme-emerald { --theme-color: #10b981; }
        .theme-blue { --theme-color: #3b82f6; }
        .theme-violet { --theme-color: #a855f7; }
    </style>
</head>
<body class="bg-slate-100">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-72 bg-[#0b1120] text-slate-300 flex flex-col border-r border-slate-800 shadow-2xl">
            <!-- Logo -->
            <div class="h-20 flex items-center px-6 border-b border-white/5 bg-[#0f172a]">
                <div class="flex gap-3 items-center">
                    <div class="flex gap-1">
                        <div class="w-2.5 h-7 bg-blue-500 rounded-sm"></div>
                        <div class="w-2.5 h-7 bg-red-500 rounded-sm mt-1.5"></div>
                        <div class="w-2.5 h-7 bg-amber-500 rounded-sm mt-3"></div>
                    </div>
                    <div class="flex flex-col ml-1">
                        <span class="text-2xl font-black text-white tracking-wider leading-none">WARAS</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Admin Portal</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto px-4 py-4 custom-scrollbar">
                <!-- Dashboard -->
                <div class="mb-8">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path></svg>
                        <span class="text-sm font-medium">Dashboard General</span>
                    </a>
                </div>

                <!-- Módulos Operativos -->
                <div class="mb-8">
                    <h3 class="px-4 text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3">Módulos Operativos</h3>
                    
                    <!-- Biblioteca -->
                    <details class="group mb-1.5" {{ request()->routeIs('admin.biblioteca.*') ? 'open' : '' }}>
                        <summary class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer transition-all hover:bg-slate-800/50 hover:text-slate-200 {{ request()->routeIs('admin.biblioteca.*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C6.5 6.253 2 9.75 2 14s4.5 7.747 10 7.747m0-13c5.5 0 10 3.503 10 7.747m-10-7.747V2m0 13c-5.5 0-10 3.503-10 7.747m10-7.747c5.5 0 10 3.503 10 7.747M9 19h6"></path></svg>
                                <span class="text-sm font-medium">Biblioteca</span>
                            </div>
                        </summary>
                        <div class="ml-11 mt-2 flex flex-col gap-1 border-l-2 border-slate-700/50 pl-3">
                            <a href="{{ route('admin.biblioteca.books') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.biblioteca.books*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Libros</a>
                            <a href="{{ route('admin.biblioteca.authors') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.biblioteca.authors*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Autores</a>
                            <a href="{{ route('admin.biblioteca.categories') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.biblioteca.categories*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Categorías</a>
                            <a href="{{ route('admin.biblioteca.publishers') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.biblioteca.publishers*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Editoriales</a>
                            <a href="{{ route('admin.biblioteca.magazines') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.biblioteca.magazines*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Revistas</a>
                        </div>
                    </details>

                    <!-- Fototeca -->
                    <details class="group mb-1.5" {{ request()->routeIs('admin.fototeca.*') ? 'open' : '' }}>
                        <summary class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer transition-all hover:bg-slate-800/50 hover:text-slate-200 {{ request()->routeIs('admin.fototeca.*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-medium">Fototeca</span>
                            </div>
                        </summary>
                        <div class="ml-11 mt-2 flex flex-col gap-1 border-l-2 border-slate-700/50 pl-3">
                            <a href="{{ route('admin.fototeca.photos') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.fototeca.photos*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Fotografías</a>
                            <a href="{{ route('admin.fototeca.photographers') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.fototeca.photographers*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Fotógrafos</a>
                            <a href="{{ route('admin.fototeca.categories') }}" class="text-left text-[13px] font-medium px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.fototeca.categories*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">Categorías</a>
                        </div>
                    </details>
                </div>

                <!-- Próximamente -->
                <div class="mb-8">
                    <h3 class="px-4 text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3">Próximamente</h3>
                    
                    <div class="px-4 py-3 rounded-xl text-slate-400 text-sm font-medium flex items-center gap-3 opacity-60 cursor-not-allowed">
                        <span class="text-lg">🎵</span>
                        <span>Musicoteca</span>
                        <span class="ml-auto text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-400">EN DESARROLLO</span>
                    </div>
                    <div class="px-4 py-3 rounded-xl text-slate-400 text-sm font-medium flex items-center gap-3 opacity-60 cursor-not-allowed">
                        <span class="text-lg">🎨</span>
                        <span>Pinacoteca</span>
                        <span class="ml-auto text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-400">PRONTO</span>
                    </div>
                    <div class="px-4 py-3 rounded-xl text-slate-400 text-sm font-medium flex items-center gap-3 opacity-60 cursor-not-allowed">
                        <span class="text-lg">📅</span>
                        <span>Efemeridades</span>
                        <span class="ml-auto text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-400">PRONTO</span>
                    </div>
                    <div class="px-4 py-3 rounded-xl text-slate-400 text-sm font-medium flex items-center gap-3 opacity-60 cursor-not-allowed">
                        <span class="text-lg">📚</span>
                        <span>Catálogo KOHA</span>
                        <span class="ml-auto text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-400">PRONTO</span>
                    </div>
                </div>

                <!-- Gestión Sistema -->
                <div class="mb-8">
                    <h3 class="px-4 text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3">Gestión del Sistema</h3>
                    <a href="{{ route('admin.usuarios.index') }}" 
                       class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.usuarios.*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 8 4 4 0 010-8zM3 8a8 8 0 1116 0 8 8 0 01-16 0z"></path></svg>
                        <span class="text-sm font-medium">Usuarios y Roles</span>
                    </a>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-5 border-t border-white/5 bg-[#0f172a]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-white">{{ auth()->user()->name }}</span>
                        <span class="text-xs font-medium text-slate-500">{{ auth()->user()->is_admin_global ? '🔑 Admin Global' : '🛡️ Moderador' }}</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Topbar -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0 shadow-sm">
                <div class="flex items-center gap-2 text-sm font-bold text-slate-400 uppercase tracking-wider">
                    <span class="text-indigo-600">WARAS Panel</span>
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-slate-700">@yield('section', 'Dashboard')</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="text-sm font-bold text-indigo-600 bg-indigo-50 border border-indigo-200 px-5 py-2.5 rounded-xl hover:bg-indigo-100 transition-colors shadow-sm">
                        Portal Principal
                    </a>
                    <a href="/" class="text-sm font-bold text-slate-600 border border-slate-200 px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                        Ir al Sitio Web
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-red-600 bg-red-50 px-5 py-2.5 rounded-xl hover:bg-red-100 transition-colors">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto custom-scrollbar">
                @yield('content')
            </main>
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
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Ver original
                    </a>
                    <button onclick="closeLightbox()"
                        class="text-slate-300 hover:text-white p-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
        </div>
    </div>

    <script>
    function openLightbox(src, title) {
        const lb = document.getElementById('lightbox');
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-title').textContent = title || '';
        document.getElementById('lightbox-open').href = src;
        lb.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.getElementById('lightbox-img').src = '';
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
    });
    </script>
</body>
</html>
