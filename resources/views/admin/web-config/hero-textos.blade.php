@extends('layouts.admin')
@section('title', 'Textos Principales — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[860px] mx-auto px-4">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Textos Principales</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Edita los títulos y subtítulos del hero en el portal, biblioteca y fototeca.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="space-y-5">

        {{-- Portal Principal --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20">
                <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="home" class="w-4 h-4 text-amber-500"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 dark:text-white text-sm">Portal Principal</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Texto del hero en la página de inicio</p>
                </div>
            </div>
            <form action="{{ route('admin.web-config.hero-textos.update') }}" method="POST">
                @csrf
                <input type="hidden" name="section" value="portal">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Subtítulo superior <span class="font-normal text-slate-400 text-xs">(eyebrow)</span></label>
                        <input type="text" name="hero_portal_eyebrow" value="{{ $values['hero_portal_eyebrow'] }}" placeholder="{{ $defaults['hero_portal_eyebrow'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título principal <span class="text-red-500">*</span></label>
                        <input type="text" name="hero_portal_title" value="{{ $values['hero_portal_title'] }}" placeholder="{{ $defaults['hero_portal_title'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Descripción</label>
                        <textarea name="hero_portal_subtitle" rows="3" placeholder="{{ $defaults['hero_portal_subtitle'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ $values['hero_portal_subtitle'] }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Texto del botón CTA</label>
                        <input type="text" name="hero_portal_cta" value="{{ $values['hero_portal_cta'] }}" placeholder="{{ $defaults['hero_portal_cta'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div class="flex justify-end pt-1">
                        <button type="submit"
                            class="px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-sm font-medium shadow-lg shadow-brand-500/30 transition-all flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Guardar Portal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Biblioteca --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20">
                <div class="w-8 h-8 rounded-lg bg-brand-50 dark:bg-brand-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="book-open" class="w-4 h-4 text-brand-500"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 dark:text-white text-sm">Biblioteca Digital</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Texto del hero en la portada de la biblioteca</p>
                </div>
            </div>
            <form action="{{ route('admin.web-config.hero-textos.update') }}" method="POST">
                @csrf
                <input type="hidden" name="section" value="biblioteca">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título principal <span class="text-red-500">*</span></label>
                        <input type="text" name="hero_biblioteca_title" value="{{ $values['hero_biblioteca_title'] }}" placeholder="{{ $defaults['hero_biblioteca_title'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Subtítulo</label>
                        <input type="text" name="hero_biblioteca_subtitle" value="{{ $values['hero_biblioteca_subtitle'] }}" placeholder="{{ $defaults['hero_biblioteca_subtitle'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div class="flex justify-end pt-1">
                        <button type="submit"
                            class="px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-sm font-medium shadow-lg shadow-brand-500/30 transition-all flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Guardar Biblioteca
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Fototeca --}}
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="camera" class="w-4 h-4 text-emerald-500"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 dark:text-white text-sm">Fototeca Digital</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Texto del hero en la portada de la fototeca</p>
                </div>
            </div>
            <form action="{{ route('admin.web-config.hero-textos.update') }}" method="POST">
                @csrf
                <input type="hidden" name="section" value="fototeca">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Subtítulo superior <span class="font-normal text-slate-400 text-xs">(eyebrow)</span></label>
                        <input type="text" name="hero_fototeca_eyebrow" value="{{ $values['hero_fototeca_eyebrow'] }}" placeholder="{{ $defaults['hero_fototeca_eyebrow'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título principal <span class="text-red-500">*</span></label>
                        <input type="text" name="hero_fototeca_title" value="{{ $values['hero_fototeca_title'] }}" placeholder="{{ $defaults['hero_fototeca_title'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Descripción</label>
                        <textarea name="hero_fototeca_subtitle" rows="3" placeholder="{{ $defaults['hero_fototeca_subtitle'] }}"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ $values['hero_fototeca_subtitle'] }}</textarea>
                    </div>
                    <div class="flex justify-end pt-1">
                        <button type="submit"
                            class="px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-sm font-medium shadow-lg shadow-brand-500/30 transition-all flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Guardar Fototeca
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
