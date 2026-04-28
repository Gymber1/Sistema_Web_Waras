@extends('layouts.admin')

@section('section', 'Biblioteca > Descriptores')

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

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Descriptores</h2>
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
            <span>Biblioteca</span>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-slate-700 dark:text-slate-200">Descriptores</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 sticky top-6">
                <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Agregar descriptor</h3>
                <form action="{{ route('admin.biblioteca.descriptors.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Ej. historia, cultura, ancash"
                            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Se guardará en minúsculas automáticamente.</p>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-sm font-medium shadow-lg shadow-brand-500/30 transition-all">
                        Agregar descriptor
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
                <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <span class="text-sm text-slate-500 dark:text-slate-400">{{ $descriptors->total() }} descriptores</span>
                    <div class="relative w-full sm:w-48">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" id="search-desc" placeholder="Buscar..."
                            oninput="filterTags(this.value)"
                            class="w-full pl-8 pr-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                </div>

                <div class="p-5">
                    @if($descriptors->isEmpty())
                    <div class="py-12 text-center text-slate-400 dark:text-slate-500">
                        <i data-lucide="tag" class="w-8 h-8 mx-auto mb-3 opacity-30"></i>
                        <p class="text-sm">No hay descriptores registrados.</p>
                    </div>
                    @else
                    <div id="tags-container" class="flex flex-wrap gap-2">
                        @foreach($descriptors as $descriptor)
                        <div class="tag-item group inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 dark:bg-slate-800/50 hover:bg-slate-200 dark:hover:bg-slate-700/50 rounded-full transition-colors border border-slate-200 dark:border-slate-700"
                            data-name="{{ $descriptor->name }}">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $descriptor->name }}</span>
                            @if($descriptor->books_count > 0)
                            <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-900/50 px-1.5 py-0.5 rounded-full border border-slate-200 dark:border-slate-700">{{ $descriptor->books_count }}</span>
                            @endif
                            <form action="{{ route('admin.biblioteca.descriptors.destroy', $descriptor) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="confirmDelete(this.closest('form'), '¿Eliminar el descriptor «{{ addslashes($descriptor->name) }}»?'); return false;"
                                    class="text-slate-300 dark:text-slate-600 hover:text-red-500 font-bold text-sm leading-none ml-0.5 opacity-0 group-hover:opacity-100 transition-opacity"
                                    title="Eliminar">×</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <x-admin-pagination :paginator="$descriptors" />
    </div>
</div>

<script>
function filterTags(q) {
    document.querySelectorAll('#tags-container .tag-item').forEach(tag => {
        tag.style.display = tag.dataset.name.includes(q.toLowerCase()) ? '' : 'none';
    });
}
</script>
@endsection
