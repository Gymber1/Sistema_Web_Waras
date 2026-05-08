@extends('layouts.admin')

@section('section', 'Fototeca > 3er Nivel > Nuevo')

@section('content')
<div class="max-w-[600px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.fototeca.thirdlevels') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Agregar 3er Nivel</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">NIVEL 5</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Elige el 2do nivel al que pertenece este 3er nivel.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.fototeca.thirdlevels.store') }}" method="POST">
        @csrf
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>
            <x-searchable-select
                name="parent_id"
                label="2do Nivel padre"
                :required="true"
                placeholder="— Seleccionar 2do nivel —"
                :selected="old('parent_id', '')"
                :options="$parentCategories->map(fn($c) => ['value'=>$c->id, 'text'=>($c->parent?->parent?->parent?->name ? $c->parent->parent->parent->name.' › ' : '').($c->parent?->parent?->name ? $c->parent->parent->name.' › ' : '').($c->parent?->name ? $c->parent->name.' › ' : '').$c->name])" />
        </div>
        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.thirdlevels') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar 3er nivel</button>
        </div>
    </form>
</div>
@endsection
