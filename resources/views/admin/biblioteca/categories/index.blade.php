@extends('layouts.admin')

@section('section', 'Biblioteca > Categorías')

@section('content')
<div class="p-6 md:p-10 max-w-[1200px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Categorías</h1>
            <p class="text-slate-500 mt-1">Árbol jerárquico de categorías de la Biblioteca. Puedes tener niveles ilimitados.</p>
        </div>
        <a href="{{ route('admin.biblioteca.categories.create') }}"
            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar Categoría
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-emerald-500">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <span class="text-sm font-bold bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg">{{ $allCategories->count() }} categorías en total</span>
            <div class="text-xs text-slate-400 flex items-center gap-4">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-slate-200 inline-block"></span> Nivel 1 (Categoría)</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-100 inline-block"></span> Nivel 2 (Subcategoría)</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-teal-100 inline-block"></span> Nivel 3+</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Nivel</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Categoría padre</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allCategories as $cat)
                    @php
                        $depth = $cat->depth;
                        $rowBg = $depth === 0 ? '' : ($depth === 1 ? 'bg-emerald-50/30' : 'bg-teal-50/30');
                        $indent = $depth * 24;
                        $levelLabel = $depth === 0 ? 'Categoría' : ($depth === 1 ? 'Subcategoría' : str_repeat('Sub', $depth) . 'categoría');
                        $levelColor = $depth === 0 ? 'bg-slate-100 text-slate-600' : ($depth === 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-teal-100 text-teal-700');
                    @endphp
                    <tr class="hover:bg-slate-50 group transition-colors {{ $rowBg }}">
                        <td class="py-3 px-6">
                            <div class="flex items-center gap-2" style="padding-left: {{ $indent }}px">
                                @if($depth > 0)
                                <svg class="w-3 h-3 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                @endif
                                <span class="text-sm font-{{ $depth === 0 ? 'bold' : 'semibold' }} text-slate-{{ $depth === 0 ? '900' : '700' }}">{{ $cat->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $levelColor }}">{{ $levelLabel }}</span>
                        </td>
                        <td class="py-3 px-6 text-sm text-slate-500">
                            {{ $cat->parent?->name ?? '—' }}
                        </td>
                        <td class="py-3 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100">
                                <a href="{{ route('admin.biblioteca.categories.create') }}?parent_id={{ $cat->id }}"
                                    class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg bg-white border border-slate-100" title="Agregar hijo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </a>
                                <a href="{{ route('admin.biblioteca.categories.edit', $cat) }}"
                                    class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg bg-white border border-slate-100" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.biblioteca.categories.destroy', $cat) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar «{{ addslashes($cat->name) }}» y todas sus subcategorías?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg bg-white border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-16 text-center text-slate-400">No hay categorías registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
