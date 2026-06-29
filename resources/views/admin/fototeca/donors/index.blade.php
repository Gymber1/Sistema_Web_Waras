@extends('layouts.admin')

@section('section', 'Fototeca > Donadores')

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
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gestión de Donadores</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Fototeca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Donadores</span>
            </div>
        </div>
        <a href="{{ route('admin.fototeca.donors.create') }}"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Agregar Donador
        </a>
    </div>

    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="bulk-bar"></div>

        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-dark-surface">
            <form method="GET" action="{{ route('admin.fototeca.donors') }}" class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input id="search-input" name="search" type="text" value="{{ $q ?? '' }}" placeholder="Buscar donadores..."
                    class="w-full pl-9 pr-9 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
                @if(!empty($q))
                <a href="{{ route('admin.fototeca.donors') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200" title="Limpiar búsqueda">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
                @endif
            </form>
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $donors->total() }} registros</span>
        </div>

        <div class="overflow-x-auto">
            <table id="table-photographers" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nombre Completo</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Fotografías</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nac. / Fallec.</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($donors as $p)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group photo-row">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $p->id }}"></td>
                        <td class="px-6 py-4">
                            @if($p->photo_path)
                                <img src="{{ Storage::url($p->photo_path) }}" alt="{{ $p->full_name }}"
                                    class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-100 dark:ring-slate-700 cursor-zoom-in hover:opacity-80 transition-opacity"
                                    onclick="openLightbox('{{ Storage::url($p->photo_path) }}', '{{ addslashes($p->full_name) }}')"
                                    onerror="this.style.display='none'">
                            @else
                                <div class="w-10 h-10 rounded-full bg-brand-50 dark:bg-brand-500/10 flex items-center justify-center text-brand-500 font-bold text-sm">
                                    {{ mb_substr($p->full_name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 dark:text-white photo-name">{{ $p->full_name }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $p->photos_count }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                            {{ $p->birth_date ? $p->birth_date->format('Y') : '—' }}
                            @if($p->death_date) / {{ $p->death_date->format('Y') }} @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.fototeca.donors.edit', $p) }}"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.fototeca.donors.destroy', $p) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar este donador?'); return false;"
                                        class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i data-lucide="camera" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay donadores registrados</p>
                                <a href="{{ route('admin.fototeca.donors.create') }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Agregar el primero →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($donors->isNotEmpty())
        <x-admin-pagination :paginator="$donors" />
        @endif
    </div>
</div>
@endsection
