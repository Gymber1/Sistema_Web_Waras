@extends('layouts.admin')

@section('title', 'Biblioteca Digital — Centro de Control')
@section('section', 'Biblioteca Digital')

@section('content')
<div class="max-w-[1400px] mx-auto">

    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Biblioteca Digital</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Centro de control del módulo · WARAS Admin Panel</p>
        </div>
        <a href="{{ route('biblioteca.dashboard') }}" target="_blank"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            Ver sitio público
        </a>
    </div>

    {{-- Métricas rápidas --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @php
        $metrics = [
            ['label' => 'Libros',       'value' => $stats['books'],       'icon' => 'book-open',  'color' => 'indigo'],
            ['label' => 'Revistas',     'value' => $stats['magazines'],   'icon' => 'newspaper',  'color' => 'sky'],
            ['label' => 'Autores',      'value' => $stats['authors'],     'icon' => 'users',      'color' => 'emerald'],
            ['label' => 'Categorías',   'value' => $stats['categories'],  'icon' => 'tag',        'color' => 'violet'],
            ['label' => 'Especiales',   'value' => $stats['specials'],    'icon' => 'star',       'color' => 'rose'],
            ['label' => 'Descriptores', 'value' => $stats['descriptors'], 'icon' => 'hash',       'color' => 'teal'],
        ];
        $colorMap = [
            'indigo'  => ['bg' => 'bg-indigo-50 dark:bg-indigo-500/10',  'text' => 'text-indigo-500 dark:text-indigo-400'],
            'sky'     => ['bg' => 'bg-sky-50 dark:bg-sky-500/10',        'text' => 'text-sky-500 dark:text-sky-400'],
            'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10','text' => 'text-emerald-500 dark:text-emerald-400'],
            'violet'  => ['bg' => 'bg-violet-50 dark:bg-violet-500/10',  'text' => 'text-violet-500 dark:text-violet-400'],
            'rose'    => ['bg' => 'bg-rose-50 dark:bg-rose-500/10',      'text' => 'text-rose-500 dark:text-rose-400'],
            'teal'    => ['bg' => 'bg-teal-50 dark:bg-teal-500/10',      'text' => 'text-teal-500 dark:text-teal-400'],
        ];
        @endphp
        @foreach($metrics as $m)
        @php $c = $colorMap[$m['color']]; @endphp
        <div class="bg-white dark:bg-dark-surface rounded-xl p-4 shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border flex flex-col items-center text-center gap-2">
            <div class="w-9 h-9 rounded-lg {{ $c['bg'] }} flex items-center justify-center {{ $c['text'] }}">
                <i data-lucide="{{ $m['icon'] }}" class="w-4.5 h-4.5"></i>
            </div>
            <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $m['value'] }}</span>
            <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">{{ $m['label'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- Acciones de gestión --}}
    <div class="mb-4">
        <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Gestión del módulo</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        @php
        $sections = [
            ['title' => 'Libros',               'desc' => 'Gestiona el catálogo principal: títulos, portadas, PDFs, ISBNs, autores y categorías.',    'icon' => 'book-open',   'color' => 'indigo',  'route' => 'admin.biblioteca.books',          'count' => $stats['books'],      'label' => 'Administrar Libros'],
            ['title' => 'Revistas',             'desc' => 'Administra publicaciones periódicas: números, volúmenes y archivos digitales.',             'icon' => 'newspaper',   'color' => 'sky',     'route' => 'admin.biblioteca.magazines',      'count' => $stats['magazines'],  'label' => 'Administrar Revistas'],
            ['title' => 'Autores',              'desc' => 'Registra y edita perfiles de autores: biografías, fotografías y libros vinculados.',        'icon' => 'users',       'color' => 'emerald', 'route' => 'admin.biblioteca.authors',        'count' => $stats['authors'],    'label' => 'Administrar Autores'],
            ['title' => 'Categorías',           'desc' => 'Crea y edita las categorías principales del catálogo (nivel 1).',                          'icon' => 'tag',         'color' => 'violet',  'route' => 'admin.biblioteca.categories',     'count' => null,                 'label' => 'Administrar Categorías'],
            ['title' => 'SubCategorías',        'desc' => 'Gestiona las subcategorías asociadas a cada categoría padre (nivel 2).',                   'icon' => 'tags',        'color' => 'purple',  'route' => 'admin.biblioteca.subcategories',  'count' => null,                 'label' => 'Administrar SubCategorías'],
            ['title' => 'Colecciones Especiales','desc' => 'Crea y edita los nombres de colecciones especiales curadas.',                             'icon' => 'star',        'color' => 'rose',    'route' => 'admin.biblioteca.specials',              'count' => $stats['specials'],      'label' => 'Administrar Especiales'],
            ['title' => 'Asignar a Especiales', 'desc' => 'Vincula libros o revistas existentes a las colecciones especiales.',                       'icon' => 'link',        'color' => 'slate',   'route' => 'admin.biblioteca.specials.assign-books', 'count' => null,                    'label' => 'Asignar Contenido'],
            ['title' => 'Descriptores',          'desc' => 'Gestiona las palabras clave que describen el contenido de los documentos.',                'icon' => 'hash',        'color' => 'teal',    'route' => 'admin.biblioteca.descriptors',           'count' => $stats['descriptors'],   'label' => 'Administrar Descriptores'],
        ];
        $sectionColorMap = [
            'indigo'  => ['icon_bg' => 'bg-indigo-50 dark:bg-indigo-500/10',   'icon_text' => 'text-indigo-500 dark:text-indigo-400',  'btn' => 'bg-brand-500 hover:bg-brand-600 shadow-brand-500/30'],
            'sky'     => ['icon_bg' => 'bg-sky-50 dark:bg-sky-500/10',         'icon_text' => 'text-sky-500 dark:text-sky-400',        'btn' => 'bg-sky-500 hover:bg-sky-600 shadow-sky-500/30'],
            'emerald' => ['icon_bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'icon_text' => 'text-emerald-500 dark:text-emerald-400','btn' => 'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-500/30'],
            'violet'  => ['icon_bg' => 'bg-violet-50 dark:bg-violet-500/10',   'icon_text' => 'text-violet-500 dark:text-violet-400',  'btn' => 'bg-violet-500 hover:bg-violet-600 shadow-violet-500/30'],
            'purple'  => ['icon_bg' => 'bg-purple-50 dark:bg-purple-500/10',   'icon_text' => 'text-purple-500 dark:text-purple-400',  'btn' => 'bg-purple-500 hover:bg-purple-600 shadow-purple-500/30'],
            'amber'   => ['icon_bg' => 'bg-amber-50 dark:bg-amber-500/10',     'icon_text' => 'text-amber-500 dark:text-amber-400',    'btn' => 'bg-amber-500 hover:bg-amber-600 shadow-amber-500/30'],
            'rose'    => ['icon_bg' => 'bg-rose-50 dark:bg-rose-500/10',       'icon_text' => 'text-rose-500 dark:text-rose-400',      'btn' => 'bg-rose-500 hover:bg-rose-600 shadow-rose-500/30'],
            'slate'   => ['icon_bg' => 'bg-slate-100 dark:bg-slate-700/40',    'icon_text' => 'text-slate-500 dark:text-slate-400',    'btn' => 'bg-slate-600 hover:bg-slate-700 shadow-slate-500/20'],
            'teal'    => ['icon_bg' => 'bg-teal-50 dark:bg-teal-500/10',       'icon_text' => 'text-teal-500 dark:text-teal-400',      'btn' => 'bg-teal-500 hover:bg-teal-600 shadow-teal-500/30'],
        ];
        @endphp

        @foreach($sections as $sec)
        @php $sc = $sectionColorMap[$sec['color']]; @endphp
        <div class="bg-white dark:bg-dark-surface rounded-xl p-6 shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border flex flex-col gap-4">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg {{ $sc['icon_bg'] }} flex items-center justify-center {{ $sc['icon_text'] }} flex-shrink-0">
                    <i data-lucide="{{ $sec['icon'] }}" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <h3 class="font-semibold text-slate-800 dark:text-white text-sm">{{ $sec['title'] }}</h3>
                        @if($sec['count'] !== null)
                        <span class="text-xs text-slate-400 dark:text-slate-500">{{ $sec['count'] }} registros</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">{{ $sec['desc'] }}</p>
                </div>
            </div>
            <a href="{{ route($sec['route']) }}"
                class="mt-auto inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white shadow-lg {{ $sc['btn'] }} transition-colors">
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                {{ $sec['label'] }}
            </a>
        </div>
        @endforeach

    </div>
</div>
@endsection
