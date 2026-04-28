@extends('layouts.admin')

@section('section', 'Biblioteca > Libros')

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
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gestión de Libros</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Biblioteca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Libros</span>
            </div>
        </div>
        <a href="{{ route('admin.biblioteca.books.create') }}"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Libro
        </a>
    </div>

    {{-- Tabla Card --}}
    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">

        {{-- Bulk bar --}}
        <div class="bulk-bar"></div>

        {{-- Toolbar --}}
        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-dark-surface">
            <div class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input id="search-input" type="text" placeholder="Buscar registros..."
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500 dark:text-slate-400">{{ $books->total() }} registros</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="table-books" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Detalles del Libro</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Autor(es)</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Año</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($books as $book)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group book-row">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $book->id }}"></td>

                        {{-- Portada + Título --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-14 bg-slate-200 dark:bg-slate-700 rounded shadow-sm overflow-hidden flex-shrink-0">
                                    @if($book->cover_image_path)
                                        <img src="{{ Storage::url($book->cover_image_path) }}" alt="{{ $book->title }}"
                                            class="w-full h-full object-cover cursor-zoom-in"
                                            onclick="openLightbox('{{ Storage::url($book->cover_image_path) }}', '{{ addslashes($book->title) }}')"
                                            onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><i data-lucide=\'book\' class=\'w-4 h-4 text-slate-400\'></i></div>'; lucide.createIcons()">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-brand-50 dark:bg-brand-500/10">
                                            <i data-lucide="book" class="w-4 h-4 text-brand-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 dark:text-white book-title">{{ $book->title }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $book->publisher->name ?? 'Sin editorial' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Autores --}}
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                            {{ $book->authors->pluck('name')->join(', ') ?: '—' }}
                        </td>

                        {{-- Categorías --}}
                        <td class="px-6 py-4">
                            @if($book->categories->isNotEmpty())
                                @foreach($book->categories->take(1) as $cat)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">
                                    {{ $cat->name }}
                                </span>
                                @endforeach
                                @if($book->categories->count() > 1)
                                    <span class="text-xs text-slate-400 dark:text-slate-500 ml-1">+{{ $book->categories->count() - 1 }}</span>
                                @endif
                            @else
                                <span class="text-slate-400 dark:text-slate-500 text-xs">—</span>
                            @endif
                        </td>

                        {{-- Año --}}
                        <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                            {{ $book->publication_date ? $book->publication_date->format('Y') : '—' }}
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.biblioteca.books.edit', $book) }}"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.biblioteca.books.destroy', $book) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar «{{ addslashes($book->title) }}»?'); return false;"
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
                                <i data-lucide="book-open" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay libros registrados</p>
                                <a href="{{ route('admin.biblioteca.books.create') }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Agregar el primero →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer tabla --}}
        @if($books->isNotEmpty())
        <x-admin-pagination :paginator="$books" />
        @endif
    </div>
</div>

<script>
document.getElementById('search-input').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    let visible = 0;
    document.querySelectorAll('.book-row').forEach(row => {
        const match = row.querySelector('.book-title').textContent.toLowerCase().includes(q);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    const info = document.getElementById('pagination-info');
    if (info) info.textContent = q ? `${visible} resultado(s)` : '';
});
</script>
@endsection
