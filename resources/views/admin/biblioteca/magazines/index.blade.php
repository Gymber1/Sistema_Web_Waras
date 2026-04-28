@extends('layouts.admin')

@section('section', 'Biblioteca > Revistas')

@section('content')
<div class="max-w-[1400px] mx-auto">

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gestión de Revistas</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Biblioteca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Revistas</span>
            </div>
        </div>
        <a href="{{ route('admin.biblioteca.magazines.create') }}"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Agregar Revista
        </a>
    </div>

    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="bulk-bar"></div>

        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-dark-surface">
            <div class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input id="search-input" type="text" placeholder="Buscar revistas..."
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
            </div>
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $magazines->total() }} registros</span>
        </div>

        <div class="overflow-x-auto">
            <table id="table-magazines" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Portada</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Autores</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Categorías</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Editorial</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Año</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($magazines as $mag)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group mag-row">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $mag->id }}"></td>
                        <td class="px-6 py-4">
                            @if($mag->cover_image_path)
                                <div class="w-10 h-14 rounded-lg shadow-sm overflow-hidden ring-1 ring-slate-200 dark:ring-slate-700">
                                    <img src="{{ Storage::url($mag->cover_image_path) }}" alt="{{ $mag->title }}"
                                        class="w-full h-full object-cover cursor-zoom-in hover:opacity-90 transition-opacity"
                                        onclick="openLightbox('{{ Storage::url($mag->cover_image_path) }}', '{{ addslashes($mag->title) }}')"
                                        onerror="this.style.display='none'">
                                </div>
                            @else
                                <div class="w-10 h-14 rounded-lg bg-brand-50 dark:bg-brand-500/10 flex items-center justify-center ring-1 ring-slate-200 dark:ring-slate-700">
                                    <i data-lucide="newspaper" class="w-4 h-4 text-brand-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 dark:text-white mag-title">{{ $mag->title }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $mag->authors->pluck('name')->join(', ') ?: '—' }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $mag->categories->pluck('name')->join(', ') ?: '—' }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $mag->publisher->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                            {{ $mag->publication_date ? $mag->publication_date->format('Y') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.biblioteca.magazines.edit', $mag) }}"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.biblioteca.magazines.destroy', $mag) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar esta revista?'); return false;"
                                        class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i data-lucide="newspaper" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay revistas registradas</p>
                                <a href="{{ route('admin.biblioteca.magazines.create') }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Agregar la primera →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($magazines->isNotEmpty())
        <x-admin-pagination :paginator="$magazines" />
        @endif
    </div>
</div>

<script>
document.getElementById('search-input').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.mag-row').forEach(row => {
        row.style.display = row.querySelector('.mag-title').textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection
