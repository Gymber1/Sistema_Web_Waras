@extends('layouts.admin')

@section('title', 'Fototeca Digital — Centro de Control')
@section('section', 'Fototeca Digital')

@section('content')
<div class="max-w-[1400px] mx-auto">

    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Fototeca Digital</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Centro de control del módulo · WARAS Admin Panel</p>
        </div>
        <a href="{{ route('fototeca.dashboard') }}" target="_blank"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            Ver sitio público
        </a>
    </div>

    {{-- Métricas rápidas --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @php
        $metrics = [
            ['label' => 'Fotografías',   'value' => $stats['photos'],        'icon' => 'image',       'color' => 'brand'],
            ['label' => 'Fotógrafos',    'value' => $stats['photographers'], 'icon' => 'camera',      'color' => 'violet'],
            ['label' => 'Categorías',    'value' => $stats['categories'],    'icon' => 'tag',         'color' => 'sky'],
            ['label' => 'SubCategorías', 'value' => $stats['subcategories'], 'icon' => 'tags',        'color' => 'cyan'],
            ['label' => 'SubNiveles',    'value' => $stats['sublevels'],     'icon' => 'folder-tree', 'color' => 'indigo'],
            ['label' => 'Etiquetas',     'value' => $stats['tags'],          'icon' => 'hash',        'color' => 'rose'],
        ];
        $colorMap = [
            'brand'  => ['bg' => 'bg-brand-50 dark:bg-brand-500/10',   'text' => 'text-brand-500 dark:text-brand-400'],
            'violet' => ['bg' => 'bg-violet-50 dark:bg-violet-500/10', 'text' => 'text-violet-500 dark:text-violet-400'],
            'sky'    => ['bg' => 'bg-sky-50 dark:bg-sky-500/10',       'text' => 'text-sky-500 dark:text-sky-400'],
            'cyan'   => ['bg' => 'bg-cyan-50 dark:bg-cyan-500/10',     'text' => 'text-cyan-500 dark:text-cyan-400'],
            'indigo' => ['bg' => 'bg-indigo-50 dark:bg-indigo-500/10', 'text' => 'text-indigo-500 dark:text-indigo-400'],
            'rose'   => ['bg' => 'bg-rose-50 dark:bg-rose-500/10',     'text' => 'text-rose-500 dark:text-rose-400'],
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
            ['title' => 'Fotografías',   'desc' => 'Sube y gestiona el archivo fotográfico: imágenes, metadatos, fotógrafos y categorías.',   'icon' => 'image',       'color' => 'brand',  'route' => 'admin.fototeca.photos',        'count' => $stats['photos'],        'label' => 'Administrar Fotografías'],
            ['title' => 'Fotógrafos',    'desc' => 'Administra los perfiles de fotógrafos: nombre, biografía y fotografía de perfil.',         'icon' => 'camera',      'color' => 'violet', 'route' => 'admin.fototeca.photographers', 'count' => $stats['photographers'], 'label' => 'Administrar Fotógrafos'],
            ['title' => 'Categorías',    'desc' => 'Define el primer nivel de clasificación temática del archivo fotográfico.',                 'icon' => 'tag',         'color' => 'sky',    'route' => 'admin.fototeca.categories',    'count' => $stats['categories'],    'label' => 'Administrar Categorías'],
            ['title' => 'SubCategorías', 'desc' => 'Segundo nivel de clasificación. Cada subcategoría pertenece a una categoría principal.',   'icon' => 'tags',        'color' => 'cyan',   'route' => 'admin.fototeca.subcategories', 'count' => $stats['subcategories'], 'label' => 'Administrar SubCategorías'],
            ['title' => 'SubNiveles',    'desc' => 'Tercer nivel de clasificación. Cada subnivel pertenece a una subcategoría.',               'icon' => 'folder-tree', 'color' => 'indigo', 'route' => 'admin.fototeca.sublevels',     'count' => $stats['sublevels'],     'label' => 'Administrar SubNiveles'],
            ['title' => 'Etiquetas',     'desc' => 'Palabras clave visibles en la galería pública para filtrar y descubrir fotografías.',       'icon' => 'hash',        'color' => 'rose',   'route' => 'admin.fototeca.tags',          'count' => $stats['tags'],          'label' => 'Administrar Etiquetas'],
        ];
        $sectionColorMap = [
            'brand'  => ['icon_bg' => 'bg-brand-50 dark:bg-brand-500/10',   'icon_text' => 'text-brand-500 dark:text-brand-400',   'btn' => 'bg-brand-500 hover:bg-brand-600 shadow-brand-500/30'],
            'violet' => ['icon_bg' => 'bg-violet-50 dark:bg-violet-500/10', 'icon_text' => 'text-violet-500 dark:text-violet-400', 'btn' => 'bg-violet-500 hover:bg-violet-600 shadow-violet-500/30'],
            'sky'    => ['icon_bg' => 'bg-sky-50 dark:bg-sky-500/10',       'icon_text' => 'text-sky-500 dark:text-sky-400',       'btn' => 'bg-sky-500 hover:bg-sky-600 shadow-sky-500/30'],
            'cyan'   => ['icon_bg' => 'bg-cyan-50 dark:bg-cyan-500/10',     'icon_text' => 'text-cyan-500 dark:text-cyan-400',     'btn' => 'bg-cyan-500 hover:bg-cyan-600 shadow-cyan-500/30'],
            'indigo' => ['icon_bg' => 'bg-indigo-50 dark:bg-indigo-500/10', 'icon_text' => 'text-indigo-500 dark:text-indigo-400', 'btn' => 'bg-indigo-500 hover:bg-indigo-600 shadow-indigo-500/30'],
            'rose'   => ['icon_bg' => 'bg-rose-50 dark:bg-rose-500/10',     'icon_text' => 'text-rose-500 dark:text-rose-400',     'btn' => 'bg-rose-500 hover:bg-rose-600 shadow-rose-500/30'],
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
