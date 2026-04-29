@extends('layouts.admin')

@section('section', 'Fototeca > Categorías')

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
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Categorías</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Fototeca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Categorías</span>
            </div>
        </div>
        <a href="{{ route('admin.fototeca.categories.create') }}"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Agregar Categoría
        </a>
    </div>

    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="bulk-bar"></div>
        <div class="p-5 border-b border-slate-100 dark:border-dark-border">
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $categories->total() }} categorías</span>
        </div>
        <div class="overflow-x-auto">
            <table id="table-foto-categories" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $cat->id }}"></td>
                        <td class="px-6 py-4 font-semibold text-slate-800 dark:text-white">{{ $cat->name }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.fototeca.categories.edit', $cat) }}"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.fototeca.categories.destroy', $cat) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar «{{ addslashes($cat->name) }}» y todas sus subcategorías?'); return false;"
                                        class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i data-lucide="tag" class="w-8 h-8 opacity-30"></i>
                                <p class="text-sm font-medium">No hay categorías registradas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-admin-pagination :paginator="$categories" />
    </div>
</div>
@endsection
