@extends('layouts.admin')

@section('title', 'Configurar Web — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[900px] mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Configurar Web</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Selecciona qué aspecto deseas configurar.</p>
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Fondos --}}
        <a href="{{ route('admin.web-config.fondos') }}"
            class="group bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border hover:border-brand-200 dark:hover:border-brand-500/30 p-6 flex items-start gap-4 transition-all hover:-translate-y-0.5">
            <div class="w-12 h-12 bg-brand-50 dark:bg-brand-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-brand-100 dark:group-hover:bg-brand-500/20 transition-colors">
                <i data-lucide="image" class="w-6 h-6 text-brand-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-slate-800 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">Fondos de Sitios Web</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Personaliza las imágenes de fondo del portal, biblioteca y fototeca.</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-brand-400 transition-colors flex-shrink-0 mt-1"></i>
        </a>

        {{-- Iconos Flotantes --}}
        <a href="{{ route('admin.web-config.contacto') }}"
            class="group bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border hover:border-emerald-200 dark:hover:border-emerald-500/30 p-6 flex items-start gap-4 transition-all hover:-translate-y-0.5">
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-500/20 transition-colors">
                <i data-lucide="phone" class="w-6 h-6 text-emerald-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Iconos Flotantes de Contacto</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Actualiza los QR y el número de WhatsApp del portal.</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-emerald-400 transition-colors flex-shrink-0 mt-1"></i>
        </a>

        {{-- Icono Navbar --}}
        <a href="{{ route('admin.web-config.icono') }}"
            class="group bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border hover:border-violet-200 dark:hover:border-violet-500/30 p-6 flex items-start gap-4 transition-all hover:-translate-y-0.5">
            <div class="w-12 h-12 bg-violet-50 dark:bg-violet-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-violet-100 dark:group-hover:bg-violet-500/20 transition-colors">
                <i data-lucide="layout" class="w-6 h-6 text-violet-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-slate-800 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">Editar Icono del Navbar</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Sube el icono que aparece en el navbar del portal, biblioteca y fototeca.</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-violet-400 transition-colors flex-shrink-0 mt-1"></i>
        </a>

        {{-- Aportantes --}}
        <a href="{{ route('admin.web-config.aportantes') }}"
            class="group bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border hover:border-amber-200 dark:hover:border-amber-500/30 p-6 flex items-start gap-4 transition-all hover:-translate-y-0.5">
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-amber-100 dark:group-hover:bg-amber-500/20 transition-colors">
                <i data-lucide="users" class="w-6 h-6 text-amber-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-slate-800 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">Editar Aportantes</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Gestiona los aportantes, aliados y el director del portal.</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-amber-400 transition-colors flex-shrink-0 mt-1"></i>
        </a>

        {{-- Contacto --}}
        <a href="{{ route('admin.web-config.edit-contacto') }}"
            class="group bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border hover:border-rose-200 dark:hover:border-rose-500/30 p-6 flex items-start gap-4 transition-all hover:-translate-y-0.5 md:col-span-2 lg:col-span-1">
            <div class="w-12 h-12 bg-rose-50 dark:bg-rose-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-rose-100 dark:group-hover:bg-rose-500/20 transition-colors">
                <i data-lucide="map-pin" class="w-6 h-6 text-rose-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-slate-800 dark:text-white group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">Editar Información de Contacto</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Actualiza la dirección, teléfono y correo de la página de contacto.</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-rose-400 transition-colors flex-shrink-0 mt-1"></i>
        </a>

        <a href="{{ route('admin.web-config.hero-textos') }}"
            class="group bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border hover:border-sky-200 dark:hover:border-sky-500/30 p-6 flex items-start gap-4 transition-all hover:-translate-y-0.5 md:col-span-2 lg:col-span-1">
            <div class="w-12 h-12 bg-sky-50 dark:bg-sky-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-sky-100 dark:group-hover:bg-sky-500/20 transition-colors">
                <i data-lucide="type" class="w-6 h-6 text-sky-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-slate-800 dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">Textos Principales</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Edita los títulos y subtítulos del hero en el portal, biblioteca y fototeca.</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-sky-400 transition-colors flex-shrink-0 mt-1"></i>
        </a>

    </div>
</div>
@endsection
