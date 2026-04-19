@extends('layouts.admin')

@section('title', 'Biblioteca Digital — Centro de Control')
@section('section', 'Biblioteca Digital')

@section('content')
<div class="p-6 md:p-10 max-w-7xl mx-auto">

    {{-- Encabezado del módulo --}}
    <div class="bg-white rounded-2xl border border-emerald-200 p-8 mb-8 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-50 to-transparent -z-0 rounded-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-start gap-5 mb-6">
                <div class="p-4 rounded-2xl bg-emerald-100 shadow-inner shrink-0">
                    <span class="text-4xl">📚</span>
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-black text-slate-900">Biblioteca Digital</h1>
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">✓ Operativo</span>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">Centro de Control del Módulo · WARAS Admin Panel</p>
                </div>
            </div>

            <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed space-y-3">
                <p>
                    La <strong class="text-slate-800">Biblioteca Digital WARAS</strong> es el repositorio central de documentos bibliográficos de la región Ancash.
                    Su misión es preservar, organizar y democratizar el acceso al patrimonio cultural escrito — libros, revistas, publicaciones especiales —
                    de autores ancashinos y obras relacionadas con la región.
                </p>
                <p>
                    Desde este panel puedes gestionar el catálogo completo: registrar nuevos títulos con sus metadatos, administrar autores y editoriales,
                    organizar el árbol de categorías y subcategorías, y publicar ediciones especiales. Todos los cambios se reflejan en tiempo real
                    en el sitio público de la Biblioteca.
                </p>
            </div>
        </div>
    </div>

    {{-- Métricas rápidas --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @php
        $metrics = [
            ['label' => 'Libros', 'value' => $stats['books'], 'color' => 'emerald', 'icon' => '📖'],
            ['label' => 'Revistas', 'value' => $stats['magazines'], 'color' => 'teal', 'icon' => '📰'],
            ['label' => 'Autores', 'value' => $stats['authors'], 'color' => 'green', 'icon' => '✍️'],
            ['label' => 'Categorías', 'value' => $stats['categories'], 'color' => 'emerald', 'icon' => '🏷️'],
            ['label' => 'Editoriales', 'value' => $stats['publishers'], 'color' => 'teal', 'icon' => '🏢'],
            ['label' => 'Especiales', 'value' => $stats['specials'], 'color' => 'green', 'icon' => '⭐'],
        ];
        @endphp
        @foreach($metrics as $m)
        <div class="bg-white rounded-xl border border-slate-100 p-4 flex flex-col items-center text-center shadow-sm">
            <span class="text-2xl mb-1">{{ $m['icon'] }}</span>
            <span class="text-2xl font-black text-slate-800">{{ $m['value'] }}</span>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $m['label'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- Acciones de gestión --}}
    <h2 class="text-lg font-black text-slate-700 uppercase tracking-widest mb-4 px-1">Gestión del Módulo</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- Libros --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">📖</span>
                <div>
                    <h3 class="font-black text-slate-800">Libros</h3>
                    <p class="text-xs text-slate-400">{{ $stats['books'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Gestiona el catálogo principal de libros: títulos, portadas, PDFs, ISBNs, autores y categorías asociadas.</p>
            <a href="{{ route('admin.biblioteca.books') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors">
                Administrar Libros
            </a>
        </div>

        {{-- Revistas --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">📰</span>
                <div>
                    <h3 class="font-black text-slate-800">Revistas</h3>
                    <p class="text-xs text-slate-400">{{ $stats['magazines'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Administra publicaciones periódicas: números, volúmenes, fechas de edición y archivos digitales asociados.</p>
            <a href="{{ route('admin.biblioteca.magazines') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors">
                Administrar Revistas
            </a>
        </div>

        {{-- Autores --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">✍️</span>
                <div>
                    <h3 class="font-black text-slate-800">Autores</h3>
                    <p class="text-xs text-slate-400">{{ $stats['authors'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Registra y edita los perfiles de autores: biografías, fotografías y su vínculo con los títulos del catálogo.</p>
            <a href="{{ route('admin.biblioteca.authors') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors">
                Administrar Autores
            </a>
        </div>

        {{-- Categorías --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">🏷️</span>
                <div>
                    <h3 class="font-black text-slate-800">Categorías</h3>
                    <p class="text-xs text-slate-400">{{ $stats['categories'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Define la taxonomía jerárquica del catálogo: crea categorías padre y subcategorías para una navegación estructurada.</p>
            <a href="{{ route('admin.biblioteca.categories') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors">
                Administrar Categorías
            </a>
        </div>

        {{-- Editoriales --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">🏢</span>
                <div>
                    <h3 class="font-black text-slate-800">Editoriales</h3>
                    <p class="text-xs text-slate-400">{{ $stats['publishers'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Administra los sellos editoriales: nombre, logo, descripción y el listado de títulos que han publicado.</p>
            <a href="{{ route('admin.biblioteca.publishers') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors">
                Administrar Editoriales
            </a>
        </div>

        {{-- Especiales --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">⭐</span>
                <div>
                    <h3 class="font-black text-slate-800">Colecciones Especiales</h3>
                    <p class="text-xs text-slate-400">{{ $stats['specials'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Gestiona selecciones curadas de documentos: compilaciones temáticas, colecciones de autor, y fondos especiales.</p>
            <a href="{{ route('admin.biblioteca.specials') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors">
                Administrar Especiales
            </a>
        </div>

    </div>

    {{-- Enlace al sitio público --}}
    <div class="mt-8 p-5 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between">
        <div>
            <p class="text-sm font-bold text-slate-700">Vista del sitio público</p>
            <p class="text-xs text-slate-400 mt-0.5">Verifica cómo se ve la Biblioteca para los visitantes</p>
        </div>
        <a href="{{ route('biblioteca.dashboard') }}" target="_blank"
           class="text-sm font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-5 py-2.5 rounded-xl hover:bg-emerald-100 transition-colors">
            Ver Biblioteca Pública →
        </a>
    </div>

</div>
@endsection
