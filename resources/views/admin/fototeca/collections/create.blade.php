@extends('layouts.admin')

@section('section', 'Fototeca > Colecciones > Nueva')

@section('content')
<div class="max-w-[600px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.fototeca.collections') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Nueva Colección</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">FOTOTECA</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Crea una nueva colección para agrupar fotografías.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.fototeca.collections.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required autofocus
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Fotógrafo destacado <span class="text-xs font-normal text-slate-400">(opcional)</span></label>
                <x-searchable-select
                    name="featured_photographer"
                    label=""
                    placeholder="— Sin fotógrafo destacado —"
                    :selected="old('featured_photographer', '')"
                    :options="$photographers->map(fn($p) => ['value' => $p->full_name, 'text' => $p->full_name])" />
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Fotógrafo principal o representativo de esta colección.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Donador destacado <span class="text-xs font-normal text-slate-400">(opcional)</span></label>
                <x-searchable-select
                    name="featured_donor"
                    label=""
                    placeholder="— Sin donador destacado —"
                    :selected="old('featured_donor', '')"
                    :options="$donors->map(fn($d) => ['value' => $d->full_name, 'text' => $d->full_name])" />
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Donador principal o representativo de esta colección.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Imagen de portada</label>
                <input type="file" name="cover_image" accept="image/*"
                    class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Opcional. Máx. 5MB.</p>
            </div>
        </div>
        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.collections') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar colección</button>
        </div>
    </form>
</div>
@endsection
