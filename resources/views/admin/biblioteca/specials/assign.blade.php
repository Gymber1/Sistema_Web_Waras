@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Agregar a Especiales')

@section('content')
<div class="max-w-[1400px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.biblioteca.specials') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Agregar a Especiales</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Selecciona una colección para gestionar su contenido.</p>
        </div>
    </div>

    @if($specials->isEmpty())
    <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl p-10 text-center">
        <i data-lucide="layers" class="w-10 h-10 text-amber-400 mx-auto mb-3 opacity-60"></i>
        <p class="text-amber-700 dark:text-amber-400 font-semibold mb-4">No hay colecciones especiales creadas.</p>
        <a href="{{ route('admin.biblioteca.specials.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-sm font-medium shadow-lg shadow-brand-500/30 transition-all">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Crear primera colección
        </a>
    </div>
    @else

    <div class="mb-5">
        <div class="relative w-full sm:w-80">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
            <input type="text" id="search-collections" placeholder="Buscar colección por nombre..."
                oninput="filterCollections(this.value)"
                class="w-full pl-9 pr-4 py-2 bg-white dark:bg-dark-surface border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all shadow-premium dark:shadow-premium-dark">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="collections-grid">
        @foreach($specials as $special)
        @php $isRevista = $special->type === 'revista'; @endphp
        <div class="collection-card bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden hover:shadow-lg dark:hover:shadow-xl transition-shadow flex flex-col"
             data-name="{{ strtolower($special->title) }}">

            <div class="relative h-40 {{ $isRevista ? 'bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-500/10 dark:to-blue-500/5' : 'bg-gradient-to-br from-brand-50 to-brand-100 dark:from-brand-500/10 dark:to-brand-500/5' }} flex items-center justify-center overflow-hidden">
                @if($special->cover_image_path)
                <img src="{{ Storage::url($special->cover_image_path) }}"
                    class="w-full h-full object-cover"
                    onerror="this.style.display='none'">
                @else
                <i data-lucide="layers" class="w-14 h-14 {{ $isRevista ? 'text-blue-200 dark:text-blue-500/30' : 'text-brand-200 dark:text-brand-500/30' }}"></i>
                @endif
                <span class="absolute top-2 right-2 px-2 py-0.5 text-[10px] font-bold uppercase rounded-md {{ $isRevista ? 'bg-blue-600 text-white' : 'bg-brand-600 text-white' }}">
                    {{ $isRevista ? 'Revistas' : 'Libros' }}
                </span>
            </div>

            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-bold text-slate-800 dark:text-white text-sm leading-snug mb-1">{{ $special->title }}</h3>
                @if($special->description)
                <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 mb-1">
                    <i data-lucide="user" class="w-3 h-3 flex-shrink-0"></i>
                    {{ $special->description }}
                </p>
                @else
                <p class="text-xs text-amber-500 dark:text-amber-400 flex items-center gap-1 mb-1">
                    <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i>
                    Sin autor
                </p>
                @endif
                <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">
                    <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $special->books_count }}</span>
                    {{ $isRevista ? ($special->books_count === 1 ? 'revista' : 'revistas') : ($special->books_count === 1 ? 'libro' : 'libros') }} asignados
                </p>
                <div class="mt-auto">
                    <a href="{{ route('admin.biblioteca.specials.manage', $special) }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-lg transition-colors shadow-sm shadow-brand-500/20">
                        <i data-lucide="settings-2" class="w-3.5 h-3.5"></i>
                        Gestionar contenido
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @endif
</div>
<script>
function filterCollections(q) {
    q = q.toLowerCase().trim();
    document.querySelectorAll('.collection-card').forEach(card => {
        card.style.display = (!q || card.dataset.name.includes(q)) ? '' : 'none';
    });
}
</script>
@endsection
