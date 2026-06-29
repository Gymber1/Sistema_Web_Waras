@extends('layouts.admin')

@section('section', 'Fototeca > Fotografías')

@section('content')
<div class="max-w-[1400px] mx-auto">

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gestión de Fotografías</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Fototeca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Fotografías</span>
            </div>
        </div>
        <a href="{{ route('admin.fototeca.photos.create') }}"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Agregar Fotografía
        </a>
    </div>

    {{-- Tabla Card --}}
    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="bulk-bar"></div>

        {{-- Toolbar --}}
        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-dark-surface">
            <form method="GET" action="{{ route('admin.fototeca.photos') }}" class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input id="search-input" name="search" type="text" value="{{ $q ?? '' }}" placeholder="Buscar fotografías..."
                    class="w-full pl-9 pr-9 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
                @if(!empty($q))
                <a href="{{ route('admin.fototeca.photos') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200" title="Limpiar búsqueda">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
                @endif
            </form>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500 dark:text-slate-400">{{ $photos->total() }} registros</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="table-photos" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Imagen</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Fotógrafos</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Etiqueta</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Ubicación</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Fecha</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($photos as $photo)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group photo-row">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $photo->id }}"></td>

                        {{-- Thumbnail --}}
                        <td class="px-6 py-4">
                            @if($photo->thumbnail_url)
                                <div class="photo-thumb-wrap w-16 h-11 rounded-lg shadow-sm overflow-hidden ring-1 ring-slate-200 dark:ring-slate-700 relative">
                                    {{-- Skeleton shimmer --}}
                                    <div class="photo-skeleton absolute inset-0 bg-slate-200 dark:bg-slate-700 animate-pulse"></div>
                                    <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}"
                                        loading="lazy"
                                        class="photo-img w-full h-full object-cover cursor-zoom-in hover:opacity-90 transition-all duration-300 opacity-0 relative z-10"
                                        onclick="openLightbox('{{ $photo->image_url }}', '{{ addslashes($photo->title) }}')"
                                        onload="this.classList.remove('opacity-0'); this.previousElementSibling.style.display='none';"
                                        onerror="this.closest('.photo-thumb-wrap').innerHTML='<div class=\'w-full h-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center\'><svg class=\'w-4 h-4 text-slate-400\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>';">
                                </div>
                            @else
                                <div class="w-16 h-11 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center ring-1 ring-slate-200 dark:ring-slate-700">
                                    <i data-lucide="image" class="w-4 h-4 text-slate-400"></i>
                                </div>
                            @endif
                        </td>

                        {{-- Título --}}
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 dark:text-white photo-title">{{ $photo->title }}</span>
                        </td>

                        {{-- Fotógrafos --}}
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                            {{ $photo->photographers->pluck('full_name')->join(', ') ?: ($photo->photographer->full_name ?? '—') }}
                        </td>

                        {{-- Etiqueta --}}
                        <td class="px-6 py-4">
                            @if($photo->tag)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">
                                    {{ $photo->tag->name }}
                                </span>
                            @else
                                <span class="text-slate-400 dark:text-slate-500 text-xs">—</span>
                            @endif
                        </td>

                        {{-- Ubicación --}}
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $photo->location ?? '—' }}</td>

                        {{-- Fecha --}}
                        <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                            @if($photo->year_type === 'range' && $photo->year_from)
                                {{ $photo->year_from }}–{{ $photo->year_to }}
                            @else
                                {{ $photo->year ?? '—' }}
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.fototeca.photos.edit', $photo) }}"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.fototeca.photos.destroy', $photo) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar «{{ addslashes($photo->title) }}»?'); return false;"
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
                                <i data-lucide="camera" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay fotografías registradas</p>
                                <a href="{{ route('admin.fototeca.photos.create') }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Agregar la primera →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer tabla --}}
        @if($photos->isNotEmpty())
        <x-admin-pagination :paginator="$photos" />
        @endif
    </div>
</div>

@endsection
