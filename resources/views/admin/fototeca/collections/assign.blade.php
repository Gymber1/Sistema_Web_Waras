@extends('layouts.admin')

@section('section', 'Fototeca > Agregar a Colecciones')

@section('content')
<div class="max-w-[1200px] mx-auto">

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Agregar a Colecciones</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Fototeca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Agregar a Colecciones</span>
            </div>
        </div>
        <a href="{{ route('admin.fototeca.collections.create') }}"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva colección
        </a>
    </div>

    <div class="mb-5 flex flex-col sm:flex-row sm:items-center gap-3">
        <form method="GET" action="{{ route('admin.fototeca.assign-collections') }}" class="relative w-full sm:w-80">
            <input type="hidden" name="tipo" value="{{ $tipo }}">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input type="text" id="search-collections" name="search" value="{{ $q ?? '' }}" placeholder="Buscar colección..."
                class="w-full pl-9 pr-9 py-2 bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all shadow-premium dark:shadow-premium-dark">
            @if(!empty($q))
            <a href="{{ route('admin.fototeca.assign-collections', ['tipo' => $tipo]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200" title="Limpiar búsqueda">
                <i data-lucide="x" class="w-4 h-4"></i>
            </a>
            @endif
        </form>

        {{-- Botones de filtro: Fotógrafos / Donadores --}}
        <div class="inline-flex rounded-lg border border-slate-200 dark:border-dark-border bg-white dark:bg-dark-surface p-1 self-start shadow-premium dark:shadow-premium-dark">
            <a href="{{ route('admin.fototeca.assign-collections', ['tipo' => 'fotografos', 'search' => $q]) }}"
                class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors {{ $tipo === 'fotografos' ? 'bg-brand-500 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50' }}">
                Fotógrafos
            </a>
            <a href="{{ route('admin.fototeca.assign-collections', ['tipo' => 'donadores', 'search' => $q]) }}"
                class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors {{ $tipo === 'donadores' ? 'bg-brand-500 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50' }}">
                Donadores
            </a>
        </div>
    </div>

    @if($collections->isEmpty())
    <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-16 text-center">
        <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
            <i data-lucide="image" class="w-10 h-10 opacity-30"></i>
            @if(!empty($q))
                <p class="text-sm font-medium">No se encontraron colecciones para «{{ $q }}»</p>
                <a href="{{ route('admin.fototeca.assign-collections', ['tipo' => $tipo]) }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Limpiar búsqueda →</a>
            @else
                <p class="text-sm font-medium">No hay colecciones con {{ $tipo === 'donadores' ? 'donador' : 'fotógrafo' }} destacado</p>
                <a href="{{ route('admin.fototeca.collections.create') }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Crear la primera colección →</a>
            @endif
        </div>
    </div>
    @else
    <div id="collections-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($collections as $collection)
        <div class="collection-card bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden flex flex-col transition-all hover:shadow-md hover:-translate-y-0.5"
             data-title="{{ strtolower($collection->title) }}">
            <div class="aspect-video bg-slate-100 dark:bg-slate-800 overflow-hidden relative">
                @if($collection->cover_image_path)
                <img src="{{ Storage::url($collection->cover_image_path) }}"
                    class="w-full h-full object-cover"
                    onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'32\' height=\'32\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.5\' class=\'text-slate-300\'><rect width=\'18\' height=\'18\' x=\'3\' y=\'3\' rx=\'2\' ry=\'2\'/><circle cx=\'9\' cy=\'9\' r=\'2\'/><path d=\'m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21\'/></svg></div>'">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <i data-lucide="image" class="w-8 h-8 text-slate-300"></i>
                </div>
                @endif
                <div class="absolute top-2 right-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-[11px] font-bold bg-black/50 text-white backdrop-blur-sm">
                        {{ $collection->photos_count }} fotos
                    </span>
                </div>
            </div>
            <div class="p-4 flex flex-col gap-2 flex-1">
                <h3 class="font-semibold text-slate-800 dark:text-white text-sm leading-snug">{{ $collection->title }}</h3>
                @if($tipo === 'donadores')
                    @if($collection->featured_donor)
                    <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                        <i data-lucide="heart-handshake" class="w-3 h-3 flex-shrink-0"></i>
                        {{ $collection->featured_donor }}
                    </p>
                    @else
                    <p class="text-xs text-amber-500 dark:text-amber-400 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i>
                        Sin donador
                    </p>
                    @endif
                @else
                    @if($collection->description)
                    <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                        <i data-lucide="user" class="w-3 h-3 flex-shrink-0"></i>
                        {{ $collection->description }}
                    </p>
                    @else
                    <p class="text-xs text-amber-500 dark:text-amber-400 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i>
                        Sin fotógrafo
                    </p>
                    @endif
                @endif
                <div class="mt-auto">
                    <a href="{{ route('admin.fototeca.collections.manage', ['special' => $collection, 'tipo' => $tipo]) }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-xs font-medium transition-colors">
                        <i data-lucide="settings-2" class="w-3.5 h-3.5"></i>
                        Gestionar contenido
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($collections->hasPages())
    <div class="mt-6">
        <x-admin-pagination :paginator="$collections" />
    </div>
    @endif
    @endif
</div>

<script>
(function () {
    const input = document.getElementById('search-collections');
    if (!input) return;
    const form = input.closest('form');
    let timer;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            form.requestSubmit ? form.requestSubmit() : form.submit();
        }, 450);
    });
})();
</script>
@endsection
