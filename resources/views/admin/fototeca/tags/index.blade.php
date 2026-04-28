@extends('layouts.admin')

@section('section', 'Fototeca > Etiquetas')

@section('content')
<div class="max-w-[960px] mx-auto">

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Etiquetas</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Fototeca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Etiquetas</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Formulario agregar --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 sticky top-6">
                <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Agregar etiqueta</h3>
                <form action="{{ route('admin.fototeca.tags.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Ej. huaraz, siglo xx, retrato"
                            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Se guardará en minúsculas automáticamente.</p>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-sm font-medium shadow-lg shadow-brand-500/30 transition-all">
                        Agregar etiqueta
                    </button>
                </form>
            </div>
        </div>

        {{-- Lista de etiquetas --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
                <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <span class="text-sm text-slate-500 dark:text-slate-400">{{ $tags->total() }} etiquetas</span>
                    <div class="relative w-full sm:w-56">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" id="search-tag" placeholder="Buscar..."
                            class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
                    </div>
                </div>

                <div class="p-5">
                    @if($tags->isEmpty())
                    <div class="flex flex-col items-center gap-3 py-10 text-slate-400 dark:text-slate-500">
                        <i data-lucide="tag" class="w-8 h-8 opacity-30"></i>
                        <p class="text-sm font-medium">No hay etiquetas registradas</p>
                    </div>
                    @else
                    <div id="tags-container" class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <div class="tag-item group flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 dark:bg-slate-700/50 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-full transition-colors"
                            data-name="{{ $tag->name }}">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ $tag->name }}</span>
                            @if($tag->photos_count > 0)
                            <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-800 px-1.5 py-0.5 rounded-full">{{ $tag->photos_count }}</span>
                            @endif
                            <form action="{{ route('admin.fototeca.tags.destroy', $tag) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="confirmDelete(this.closest('form'), '¿Eliminar la etiqueta «{{ addslashes($tag->name) }}»?'); return false;"
                                    class="w-4 h-4 flex items-center justify-center text-slate-400 hover:text-red-500 dark:hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity rounded-full"
                                    title="Eliminar">
                                    <i data-lucide="x" class="w-3 h-3"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <x-admin-pagination :paginator="$tags" />
    </div>
</div>

<script>
document.getElementById('search-tag').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tags-container .tag-item').forEach(tag => {
        tag.style.display = tag.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>
@endsection
