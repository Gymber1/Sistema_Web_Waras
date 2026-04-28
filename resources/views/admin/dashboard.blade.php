@extends('layouts.admin')

@section('section', 'Dashboard General')

@section('content')
<div class="max-w-[1200px] mx-auto">

    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Panel de Control</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitorea el estado general de WARAS.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            Ver Portal
        </a>
    </div>

    {{-- ── Stat Widgets ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Libros Totales --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl p-6 shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border relative overflow-hidden group">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Libros Totales</p>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['biblioteca']['books'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-500 dark:text-indigo-400">
                    <i data-lucide="book-open" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm relative z-10">
                <span class="text-emerald-500 font-medium flex items-center">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>Catálogo activo
                </span>
            </div>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-indigo-50 dark:bg-indigo-500/5 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        </div>

        {{-- Fotografías --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl p-6 shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border relative overflow-hidden group">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Fotografías</p>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['fototeca']['photos'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-sky-50 dark:bg-sky-500/10 flex items-center justify-center text-sky-500 dark:text-sky-400">
                    <i data-lucide="camera" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm relative z-10">
                <span class="text-emerald-500 font-medium flex items-center">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>Archivo digital
                </span>
            </div>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-sky-50 dark:bg-sky-500/5 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        </div>

        {{-- Usuarios Activos --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl p-6 shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border relative overflow-hidden group">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Usuarios Activos</p>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['usuarios']['total'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500 dark:text-emerald-400">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm relative z-10">
                <span class="text-slate-500 dark:text-slate-400">{{ $stats['usuarios']['admins'] ?? 0 }} admin · {{ $stats['usuarios']['moderators'] ?? 0 }} mod</span>
            </div>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-50 dark:bg-emerald-500/5 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        </div>

        {{-- Estado del Sistema --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl p-6 shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border relative overflow-hidden group">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Estado del Sistema</p>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mt-3">Óptimo</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500 dark:text-amber-400">
                    <i data-lucide="activity" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-5 relative z-10">
                <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width:100%"></div>
                </div>
            </div>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-50 dark:bg-amber-500/5 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        </div>

    </div>

    {{-- ── Secciones de módulos ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Biblioteca Digital --}}
        @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca'))
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border flex flex-col">
            <div class="p-6 border-b border-slate-100 dark:border-dark-border flex justify-between items-center">
                <h4 class="font-bold text-slate-800 dark:text-white text-lg">Biblioteca Digital</h4>
                <a href="{{ route('admin.biblioteca.index') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 transition-colors border border-brand-200 dark:border-brand-500/20">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    Detalles
                </a>
            </div>
            <div class="p-6 flex-1">
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['label'=>'Libros',      'value'=>$stats['biblioteca']['books']       ?? 0],
                        ['label'=>'Autores',     'value'=>$stats['biblioteca']['authors']     ?? 0],
                        ['label'=>'Editoriales', 'value'=>$stats['biblioteca']['publishers']  ?? 0],
                        ['label'=>'Revistas',    'value'=>$stats['biblioteca']['magazines']   ?? 0],
                    ] as $s)
                    <div class="p-4 rounded-xl border border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                        <span class="text-2xl font-bold text-slate-700 dark:text-slate-200">{{ $s['value'] }}</span>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-1">{{ $s['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="p-5 border-t border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/10 rounded-b-xl flex gap-3">
                <a href="{{ route('admin.biblioteca.books') }}"
                    class="flex-1 bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    Administrar Catálogo <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('biblioteca.dashboard') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm shadow-emerald-500/30 transition-colors">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Ver sitio público
                </a>
            </div>
        </div>
        @endif

        {{-- Fototeca Digital --}}
        @if(auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca'))
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border flex flex-col">
            <div class="p-6 border-b border-slate-100 dark:border-dark-border flex justify-between items-center">
                <h4 class="font-bold text-slate-800 dark:text-white text-lg">Fototeca Digital</h4>
                <a href="{{ route('admin.fototeca.index') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400 hover:bg-sky-100 dark:hover:bg-sky-500/20 transition-colors border border-sky-200 dark:border-sky-500/20">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    Detalles
                </a>
            </div>
            <div class="p-6 flex-1">
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['label'=>'Fotografías',  'value'=>$stats['fototeca']['photos']        ?? 0],
                        ['label'=>'Fotógrafos',   'value'=>$stats['fototeca']['photographers'] ?? 0],
                        ['label'=>'Categorías',   'value'=>$stats['fototeca']['categories']    ?? 0],
                        ['label'=>'Subcategorías','value'=>$stats['fototeca']['subcategories'] ?? 0],
                    ] as $s)
                    <div class="p-4 rounded-xl border border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                        <span class="text-2xl font-bold text-slate-700 dark:text-slate-200">{{ $s['value'] }}</span>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-1">{{ $s['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="p-5 border-t border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/10 rounded-b-xl flex gap-3">
                <a href="{{ route('admin.fototeca.photos') }}"
                    class="flex-1 bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    Administrar Archivo <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('fototeca.dashboard') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm shadow-emerald-500/30 transition-colors">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Ver sitio público
                </a>
            </div>
        </div>
        @endif

        {{-- Usuarios --}}
        @if(auth()->user()->is_admin_global)
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border flex flex-col">
            <div class="p-6 border-b border-slate-100 dark:border-dark-border flex justify-between items-center">
                <h4 class="font-bold text-slate-800 dark:text-white text-lg">Gestión de Usuarios</h4>
                <a href="{{ route('admin.usuarios.index') }}" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors text-slate-400">
                    <i data-lucide="more-vertical" class="w-5 h-5"></i>
                </a>
            </div>
            <div class="p-6 flex-1">
                <div class="grid grid-cols-3 gap-4">
                    @foreach([
                        ['label'=>'Total',       'value'=>$stats['usuarios']['total']      ?? 0],
                        ['label'=>'Admins',      'value'=>$stats['usuarios']['admins']     ?? 0],
                        ['label'=>'Moderadores', 'value'=>$stats['usuarios']['moderators'] ?? 0],
                    ] as $s)
                    <div class="p-4 rounded-xl border border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                        <span class="text-2xl font-bold text-slate-700 dark:text-slate-200">{{ $s['value'] }}</span>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-1">{{ $s['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="p-5 border-t border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/10 rounded-b-xl">
                <a href="{{ route('admin.usuarios.index') }}"
                    class="w-full bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    Administrar Usuarios <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
        @endif

        {{-- Módulos futuros --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border flex flex-col">
            <div class="p-6 border-b border-slate-100 dark:border-dark-border">
                <h4 class="font-bold text-slate-800 dark:text-white text-lg">En Desarrollo</h4>
            </div>
            <div class="p-6 flex-1 space-y-3">
                @foreach([
                    ['icon'=>'music',        'label'=>'Musicoteca Digital',     'desc'=>'Álbumes y artistas ancashinos'],
                    ['icon'=>'palette',       'label'=>'Pinacoteca Digital',      'desc'=>'Obras de arte regionales'],
                    ['icon'=>'calendar-days', 'label'=>'Efemeridades Ancashinas', 'desc'=>'Eventos históricos'],
                    ['icon'=>'database',      'label'=>'Catálogo KOHA',           'desc'=>'Integración sistema KOHA'],
                ] as $m)
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-700/50">
                    <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-700 border border-slate-100 dark:border-slate-600 flex items-center justify-center shrink-0">
                        <i data-lucide="{{ $m['icon'] }}" class="w-4 h-4 text-slate-400 dark:text-slate-500"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 truncate">{{ $m['label'] }}</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 truncate">{{ $m['desc'] }}</p>
                    </div>
                    <span class="text-[10px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 px-2 py-0.5 rounded uppercase tracking-wide shrink-0">Pronto</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
