@extends('layouts.admin')

@section('section', 'Dashboard')

@section('content')
<div class="p-6 md:p-10 max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Panel Administrativo</h1>
        <p class="text-slate-500 mt-2 text-lg">Resumen general y control de acceso a los módulos de WARAS.</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- BIBLIOTECA CARD -->
        @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
        <div class="bg-white rounded-2xl border border-emerald-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-emerald-50 to-white -z-10 transition-opacity group-hover:opacity-100"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-emerald-100 shadow-inner">
                        <span class="text-2xl">📚</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-emerald-800">Biblioteca Digital</h3>
                        <p class="text-sm text-slate-500">Gestión de módulo</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700 border border-white/50 shadow-sm">✓ Operativo</span>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-emerald-800 mb-1">{{ $stats['biblioteca']['books'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Libros</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-emerald-800 mb-1">{{ $stats['biblioteca']['authors'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Autores</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-emerald-800 mb-1">{{ $stats['biblioteca']['publishers'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Editoriales</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-emerald-800 mb-1">{{ $stats['biblioteca']['magazines'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Revistas</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-emerald-800 mb-1">{{ $stats['biblioteca']['specials'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Especiales</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-emerald-800 mb-1">{{ $stats['biblioteca']['descriptors'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Descriptores</span>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.biblioteca.books') }}" class="flex-1 py-3 rounded-xl text-sm font-bold transition-all shadow-sm bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white shadow-emerald-200 text-center">
                    Administrar Módulo →
                </a>
                <a href="{{ route('biblioteca.dashboard') }}" target="_blank" class="py-3 px-4 rounded-xl text-sm font-bold transition-all border border-emerald-300 text-emerald-700 hover:bg-emerald-50 bg-white shadow-sm whitespace-nowrap">
                    Ver Sitio Público
                </a>
            </div>
        </div>
        @endif

        <!-- FOTOTECA CARD -->
        @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
        <div class="bg-white rounded-2xl border border-blue-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-blue-50 to-white -z-10 transition-opacity group-hover:opacity-100"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-blue-100 shadow-inner">
                        <span class="text-2xl">📷</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-blue-800">Fototeca Digital</h3>
                        <p class="text-sm text-slate-500">Gestión de módulo</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-blue-100 text-blue-700 border border-white/50 shadow-sm">✓ Operativo</span>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-blue-800 mb-1">{{ $stats['fototeca']['photos'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Fotos</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-blue-800 mb-1">{{ $stats['fototeca']['photographers'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Fotógrafos</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-blue-800 mb-1">{{ $stats['fototeca']['categories'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Categorías</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-blue-800 mb-1">{{ $stats['fototeca']['subcategories'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">SubCategorías</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-blue-800 mb-1">{{ $stats['fototeca']['sublevels'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">SubNiveles</span>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.fototeca.photos') }}" class="flex-1 py-3 rounded-xl text-sm font-bold transition-all shadow-sm bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white shadow-blue-200 text-center">
                    Administrar Módulo →
                </a>
                <a href="{{ route('fototeca.dashboard') }}" target="_blank" class="py-3 px-4 rounded-xl text-sm font-bold transition-all border border-blue-300 text-blue-700 hover:bg-blue-50 bg-white shadow-sm whitespace-nowrap">
                    Ver Sitio Público
                </a>
            </div>
        </div>
        @endif

        <!-- USUARIOS CARD -->
        @if(auth()->user()->is_admin_global)
        <div class="bg-white rounded-2xl border border-violet-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-violet-50 to-white -z-10 transition-opacity group-hover:opacity-100"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-violet-100 shadow-inner">
                        <span class="text-2xl">👥</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-violet-800">Gestión de Usuarios</h3>
                        <p class="text-sm text-slate-500">Administración del sistema</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-violet-100 text-violet-700 border border-white/50 shadow-sm">✓ Operativo</span>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-violet-800 mb-1">{{ $stats['usuarios']['total'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-violet-800 mb-1">{{ $stats['usuarios']['admins'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Admins</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-violet-800 mb-1">{{ $stats['usuarios']['moderators'] ?? 0 }}</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Moderadores</span>
                </div>
            </div>

            <div class="mb-6 p-4 bg-white/50 rounded-xl border border-violet-100">
                <span class="text-sm font-bold text-violet-800">{{ auth()->user()->is_admin_global ? '🔑 Admin Global' : '🛡️ Moderador' }}</span>
                <p class="text-xs text-slate-500 font-medium mt-1">Tu Rol Actual</p>
            </div>

            <a href="{{ route('admin.usuarios.index') }}" class="w-full py-3 rounded-xl text-sm font-bold transition-all shadow-sm bg-gradient-to-r from-violet-600 to-violet-700 hover:from-violet-700 hover:to-violet-800 text-white shadow-violet-200 text-center block">
                Administrar Módulo →
            </a>
        </div>
        @endif

        <!-- MUSICOTECA CARD (Próximamente) -->
        <div class="bg-white rounded-2xl border border-amber-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group opacity-75">
            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-amber-50 to-white -z-10 transition-opacity group-hover:opacity-100"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-amber-100 shadow-inner">
                        <span class="text-2xl">🎵</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-amber-800">Musicoteca Digital</h3>
                        <p class="text-sm text-slate-500">Gestión de módulo</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-amber-100 text-amber-700 border border-white/50 shadow-sm">En Desarrollo</span>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-amber-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Álbumes</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-amber-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Canciones</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-amber-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Artistas</span>
                </div>
            </div>

            <button disabled class="w-full py-3 rounded-xl text-sm font-bold text-slate-400 bg-slate-100 cursor-not-allowed shadow-sm">
                Próximamente
            </button>
        </div>

        <!-- PINACOTECA CARD (Planificado) -->
        <div class="bg-white rounded-2xl border border-rose-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group opacity-75">
            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-rose-50 to-white -z-10 transition-opacity group-hover:opacity-100"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-rose-100 shadow-inner">
                        <span class="text-2xl">🎨</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-rose-800">Pinacoteca Digital</h3>
                        <p class="text-sm text-slate-500">Gestión de módulo</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-rose-100 text-rose-700 border border-white/50 shadow-sm">Planificado</span>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-rose-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Obras</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-rose-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Artistas</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-rose-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Colecciones</span>
                </div>
            </div>

            <button disabled class="w-full py-3 rounded-xl text-sm font-bold text-slate-400 bg-slate-100 cursor-not-allowed shadow-sm">
                Próximamente
            </button>
        </div>

        <!-- EFEMERIDADES CARD (Planificado) -->
        <div class="bg-white rounded-2xl border border-cyan-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group opacity-75">
            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-cyan-50 to-white -z-10 transition-opacity group-hover:opacity-100"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-cyan-100 shadow-inner">
                        <span class="text-2xl">📅</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-cyan-800">Efemeridades Ancashinas</h3>
                        <p class="text-sm text-slate-500">Gestión de módulo</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-cyan-100 text-cyan-700 border border-white/50 shadow-sm">Planificado</span>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-cyan-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Eventos</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-cyan-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Fechas</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-cyan-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Categorías</span>
                </div>
            </div>

            <button disabled class="w-full py-3 rounded-xl text-sm font-bold text-slate-400 bg-slate-100 cursor-not-allowed shadow-sm">
                Próximamente
            </button>
        </div>

        <!-- KOHA CARD (Planificado) -->
        <div class="bg-white rounded-2xl border border-slate-300 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group opacity-75">
            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-slate-50 to-white -z-10 transition-opacity group-hover:opacity-100"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-slate-100 shadow-inner">
                        <span class="text-2xl">📚</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Catálogo KOHA</h3>
                        <p class="text-sm text-slate-500">Gestión de módulo</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 border border-white/50 shadow-sm">Planificado</span>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-slate-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Registros</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-slate-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Usuarios</span>
                </div>
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center shadow-sm">
                    <span class="text-2xl font-black text-slate-800 mb-1">0</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Préstamos</span>
                </div>
            </div>

            <button disabled class="w-full py-3 rounded-xl text-sm font-bold text-slate-400 bg-slate-100 cursor-not-allowed shadow-sm">
                Próximamente
            </button>
        </div>
    </div>
</div>
@endsection