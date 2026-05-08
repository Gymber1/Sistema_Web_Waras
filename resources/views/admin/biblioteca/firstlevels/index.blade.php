@extends('layouts.admin')

@section('section', 'Biblioteca > 1er Nivel')

@section('content')
<div class="max-w-[900px] mx-auto">

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">1er Nivel</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Tercer nivel de clasificación. Cada elemento pertenece a una subcategoría.</p>
        </div>
        <a href="{{ route('admin.biblioteca.firstlevels.create') }}"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30 whitespace-nowrap">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Agregar 1er Nivel
        </a>
    </div>

    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="bulk-bar"></div>
        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex items-center justify-between gap-4">
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $firstlevels->total() }} 1er niveles</span>
            <div class="relative w-64">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" id="search-first" placeholder="Buscar 1er nivel..."
                    oninput="filterTable(this.value)"
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="table-first" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Subcategoría padre</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Categoría raíz</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($firstlevels as $cat)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group" data-name="{{ strtolower($cat->name) }}">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $cat->id }}"></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="chevron-right" class="w-3 h-3 text-brand-400 flex-shrink-0"></i>
                                <span class="font-medium text-slate-800 dark:text-white">{{ $cat->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300">{{ $cat->parent?->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400">{{ $cat->parent?->parent?->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.biblioteca.firstlevels.edit', $cat) }}"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.biblioteca.firstlevels.destroy', $cat) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar «{{ addslashes($cat->name) }}»?'); return false;"
                                        class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i data-lucide="tags" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay 1er niveles registrados</p>
                                <a href="{{ route('admin.biblioteca.firstlevels.create') }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Agregar el primero →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-admin-pagination :paginator="$firstlevels" />
    </div>
</div>

<script>
function filterTable(q) {
    document.querySelectorAll('#table-first tbody tr[data-name]').forEach(row => {
        row.style.display = row.dataset.name.includes(q.toLowerCase()) ? '' : 'none';
    });
}
</script>
@endsection
