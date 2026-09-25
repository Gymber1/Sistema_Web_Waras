@extends('layouts.admin')
@section('title', 'Carrusel — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[860px] mx-auto px-4">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Carrusel del Portal</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Elige qué tarjetas se muestran en la sección «Patrimonio Cultural Ancashino» de la página de inicio.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm font-medium">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('admin.web-config.carrusel.update') }}" method="POST">
        @csrf
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">

            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="gallery-horizontal-end" class="w-4 h-4 text-indigo-500"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 dark:text-white text-sm">Tarjetas disponibles</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Desmarca las que aún no estén listas para el público.</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-dark-border">
                @foreach($items as $key => $label)
                @php $visible = ! in_array($key, $ocultos, true); @endphp
                <label class="flex items-center gap-4 px-6 py-4 cursor-pointer hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                    <input type="checkbox" name="visibles[]" value="{{ $key }}" {{ $visible ? 'checked' : '' }}
                        class="carrusel-check w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-brand-500 focus:ring-brand-500/50 cursor-pointer">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-800 dark:text-white text-sm">{{ $label }}</p>
                    </div>
                    <span class="state-badge inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium border
                        {{ $visible
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20'
                            : 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-700/40 dark:text-slate-400 dark:border-slate-600' }}">
                        {{ $visible ? 'Visible' : 'Oculta' }}
                    </span>
                </label>
                @endforeach
            </div>

            <div class="px-6 py-5 border-t border-slate-100 dark:border-dark-border">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                    Enlace del Catálogo KOHA
                </label>
                <input type="url" name="koha_url" value="{{ old('koha_url', $kohaUrl) }}"
                    placeholder="{{ \App\Models\SiteSetting::KOHA_URL_DEFAULT }}"
                    class="w-full px-4 py-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">
                    Se abre en una pestaña nueva. Si lo dejas vacío se usa
                    <span class="font-mono">{{ \App\Models\SiteSetting::KOHA_URL_DEFAULT }}</span>
                </p>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Guardar cambios
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// La etiqueta refleja el estado antes de guardar, para que se vea el efecto al marcar.
document.querySelectorAll('.carrusel-check').forEach(function (check) {
    check.addEventListener('change', function () {
        var badge = this.closest('label').querySelector('.state-badge');
        var on  = 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20';
        var off = 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-700/40 dark:text-slate-400 dark:border-slate-600';
        badge.className = 'state-badge inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium border ' + (this.checked ? on : off);
        badge.textContent = this.checked ? 'Visible' : 'Oculta';
    });
});
</script>
@endsection
