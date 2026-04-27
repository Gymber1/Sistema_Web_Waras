@extends('layouts.admin')

@section('title', 'Configurar Web — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="p-8 max-w-4xl mx-auto">

    <div class="mb-10">
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Configurar Web</h1>
        <p class="text-slate-500 text-sm mt-1">Selecciona qué aspecto deseas configurar.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Tarjeta 1: Fondos --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
            <div class="p-8 flex-1">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-content mb-5 flex items-center justify-center">
                    <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-800 mb-2">Configurar Fondos de sitios web</h2>
                <p class="text-slate-500 text-sm leading-relaxed">Personaliza las imágenes de fondo del portal principal, biblioteca y fototeca.</p>
            </div>
            <div class="px-8 pb-8">
                <a href="{{ route('admin.web-config.fondos') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                    Ingresar
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Tarjeta 2: Iconos flotantes --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
            <div class="p-8 flex-1">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-800 mb-2">Configurar información de iconos flotantes</h2>
                <p class="text-slate-500 text-sm leading-relaxed">Actualiza los códigos QR y el número de WhatsApp para contacto directo desde el portal.</p>
            </div>
            <div class="px-8 pb-8">
                <a href="{{ route('admin.web-config.contacto') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                    Ingresar
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Tarjeta 3: Icono Navbar --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
            <div class="p-8 flex-1">
                <div class="w-14 h-14 bg-violet-50 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-800 mb-2">Editar Icono</h2>
                <p class="text-slate-500 text-sm leading-relaxed">Sube el icono que aparece junto al nombre en el navbar del Portal Principal, Biblioteca y Fototeca.</p>
            </div>
            <div class="px-8 pb-8">
                <a href="{{ route('admin.web-config.icono') }}"
                   class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                    Ingresar
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Tarjeta 4: Aportantes --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
            <div class="p-8 flex-1">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-800 mb-2">Editar Aportantes</h2>
                <p class="text-slate-500 text-sm leading-relaxed">Gestiona los aportantes, aliados y el director que se muestran en la sección Aportantes del portal principal.</p>
            </div>
            <div class="px-8 pb-8">
                <a href="{{ route('admin.web-config.aportantes') }}"
                   class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                    Ingresar
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Tarjeta 5: Editar Contacto --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
            <div class="p-8 flex-1">
                <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-800 mb-2">Editar Contacto</h2>
                <p class="text-slate-500 text-sm leading-relaxed">Actualiza la dirección, teléfono, correo electrónico e íconos que aparecen en la página de contacto del portal.</p>
            </div>
            <div class="px-8 pb-8">
                <a href="{{ route('admin.web-config.edit-contacto') }}"
                   class="inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                    Ingresar
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
