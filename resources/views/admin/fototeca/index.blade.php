@extends('layouts.admin')

@section('title', 'Fototeca Digital — Centro de Control')
@section('section', 'Fototeca Digital')

@section('content')
<div class="p-6 md:p-10 max-w-7xl mx-auto">

    {{-- Encabezado del módulo --}}
    <div class="bg-white rounded-2xl border border-blue-200 p-8 mb-8 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-blue-50 to-transparent -z-0 rounded-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-start gap-5 mb-6">
                <div class="p-4 rounded-2xl bg-blue-100 shadow-inner shrink-0">
                    <span class="text-4xl">📷</span>
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-black text-slate-900">Fototeca Digital</h1>
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-blue-100 text-blue-700 border border-blue-200">✓ Operativo</span>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">Centro de Control del Módulo · WARAS Admin Panel</p>
                </div>
            </div>

            <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed space-y-3">
                <p>
                    La <strong class="text-slate-800">Fototeca Digital WARAS</strong> es el archivo visual de la región Ancash.
                    Su misión es preservar y difundir el patrimonio fotográfico ancashino — imágenes históricas, documentales, paisajes y retratos —
                    organizadas por fotógrafos, temáticas y colecciones especiales.
                </p>
                <p>
                    Desde este panel puedes gestionar el archivo fotográfico completo: cargar nuevas imágenes con sus metadatos y derechos de autor,
                    administrar perfiles de fotógrafos, organizar el árbol de categorías, y publicar galerías especiales.
                    Todos los cambios se reflejan en tiempo real en el sitio público de la Fototeca.
                </p>
            </div>
        </div>
    </div>

    {{-- Métricas rápidas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @php
        $metrics = [
            ['label' => 'Fotografías', 'value' => $stats['photos'], 'icon' => '🖼️'],
            ['label' => 'Fotógrafos', 'value' => $stats['photographers'], 'icon' => '📸'],
            ['label' => 'Categorías', 'value' => $stats['categories'], 'icon' => '🏷️'],
        ];
        @endphp
        @foreach($metrics as $m)
        <div class="bg-white rounded-xl border border-slate-100 p-6 flex items-center gap-4 shadow-sm">
            <span class="text-3xl">{{ $m['icon'] }}</span>
            <div>
                <span class="text-3xl font-black text-slate-800">{{ $m['value'] }}</span>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $m['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Acciones de gestión --}}
    <h2 class="text-lg font-black text-slate-700 uppercase tracking-widest mb-4 px-1">Gestión del Módulo</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- Fotografías --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">🖼️</span>
                <div>
                    <h3 class="font-black text-slate-800">Fotografías</h3>
                    <p class="text-xs text-slate-400">{{ $stats['photos'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Sube y gestiona el archivo fotográfico: imágenes, títulos, descripciones, fechas, fotógrafos y categorías asociadas.</p>
            <a href="{{ route('admin.fototeca.photos') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                Administrar Fotografías
            </a>
        </div>

        {{-- Fotógrafos --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">📸</span>
                <div>
                    <h3 class="font-black text-slate-800">Fotógrafos</h3>
                    <p class="text-xs text-slate-400">{{ $stats['photographers'] }} registros</p>
                </div>
            </div>
            <p class="text-sm text-slate-500 mb-4">Administra los perfiles de fotógrafos: nombre, biografía, fotografía de perfil y su obra dentro del archivo.</p>
            <a href="{{ route('admin.fototeca.photographers') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                Administrar Fotógrafos
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
            <p class="text-sm text-slate-500 mb-4">Define la taxonomía del archivo fotográfico: crea categorías temáticas y subcategorías para una exploración ordenada.</p>
            <a href="{{ route('admin.fototeca.categories') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                Administrar Categorías
            </a>
        </div>

    </div>

    {{-- Enlace al sitio público --}}
    <div class="mt-8 p-5 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between">
        <div>
            <p class="text-sm font-bold text-slate-700">Vista del sitio público</p>
            <p class="text-xs text-slate-400 mt-0.5">Verifica cómo se ve la Fototeca para los visitantes</p>
        </div>
        <a href="{{ route('fototeca.dashboard') }}" target="_blank"
           class="text-sm font-bold text-blue-700 bg-blue-50 border border-blue-200 px-5 py-2.5 rounded-xl hover:bg-blue-100 transition-colors">
            Ver Fototeca Pública →
        </a>
    </div>

</div>
@endsection
