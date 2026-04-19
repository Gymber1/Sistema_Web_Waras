@extends('layouts.admin')

@section('section', 'Biblioteca > Autores')

@section('content')
<div class="p-6 md:p-10 max-w-[1600px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Autores</h1>
            <p class="text-slate-500 mt-1">Administra todos los autores registrados en el sistema.</p>
        </div>
        <a href="{{ route('admin.biblioteca.authors.create') }}"
            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar Autor
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-emerald-500">
        <div class="p-5 border-b border-slate-100 flex flex-wrap justify-between items-center gap-4">
            <div class="relative w-full sm:w-80">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input id="search-input" type="text" placeholder="Buscar autores..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <span class="text-sm font-bold bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg">{{ $authors->count() }} Registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Foto</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Libros</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Nacionalidad</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Descripción</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($authors as $author)
                    <tr class="hover:bg-slate-50 group author-row">
                        <td class="py-3 px-4">
                            @if($author->photo_path)
                                <img src="{{ Storage::url($author->photo_path) }}" alt="{{ $author->name }}"
                                    class="w-10 h-10 rounded-full object-cover cursor-zoom-in hover:opacity-80 transition-opacity"
                                    onclick="openLightbox('{{ Storage::url($author->photo_path) }}', '{{ addslashes($author->name) }}')"
                                    onerror="this.style.display='none'">
                            @else
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500 font-bold text-sm">
                                    {{ substr($author->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm font-semibold text-slate-800 author-name">{{ $author->name }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $author->books_count }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $author->nationality ?? '—' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-500 max-w-xs truncate">{{ $author->biography ? Str::limit($author->biography, 60) : '—' }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100">
                                <a href="{{ route('admin.biblioteca.authors.edit', $author) }}"
                                    class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg bg-white border border-slate-100" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.biblioteca.authors.destroy', $author) }}" method="POST" onsubmit="return confirm('¿Eliminar este autor?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg bg-white border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-16 text-center text-slate-400">No hay autores registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL AUTOR -->
<div id="modal-author" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-author')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[92vh] flex flex-col">
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100">
            <h2 id="modal-author-title" class="text-xl font-black text-slate-900">Agregar Autor</h2>
            <button onclick="closeModal('modal-author')" class="p-2 text-slate-400 hover:bg-slate-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
            </button>
        </div>

        <form id="form-author" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" name="_method" id="form-author-method" value="POST">

            <div class="p-8 overflow-y-auto grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="fa-name" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800">
                </div>

                <!-- Foto -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Foto del Autor</label>
                    <input type="file" name="photo" accept="image/*"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold">
                </div>

                <!-- Nacionalidad -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nacionalidad</label>
                    <input type="text" name="nationality" id="fa-nationality"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800" placeholder="Ej. Peruana">
                </div>

                <!-- Libros (multi) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Libros Asociados</label>
                    <select name="books[]" id="fa-books" multiple
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 h-32">
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">[{{ $book->document_type }}] {{ $book->title }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Ctrl/Cmd + clic para seleccionar varios</p>
                </div>

                <!-- Categorías (multi) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Categorías</label>
                    <select name="categories[]" id="fa-categories" multiple
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 h-32">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Ctrl/Cmd + clic para seleccionar varios</p>
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Descripción / Biografía</label>
                    <textarea name="biography" id="fa-biography" rows="4"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 resize-none" placeholder="Escriba la biografía..."></textarea>
                </div>
            </div>

            <div class="px-8 py-5 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modal-author')"
                    class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Cancelar</button>
                <button type="submit"
                    class="px-7 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg shadow-emerald-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                    <span id="modal-author-btn">Guardar Autor</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const storeUrl = "{{ route('admin.biblioteca.authors.store') }}";

function openModal(id, mode, author, bookIds, categoryIds) {
    document.getElementById(id).classList.remove('hidden');
    if (mode === 'create') {
        document.getElementById('modal-author-title').textContent = 'Agregar Autor';
        document.getElementById('modal-author-btn').textContent   = 'Guardar Autor';
        document.getElementById('form-author').action             = storeUrl;
        document.getElementById('form-author-method').value       = 'POST';
        document.getElementById('form-author').reset();
        setMulti('fa-books', []);
        setMulti('fa-categories', []);
    } else {
        document.getElementById('modal-author-title').textContent = 'Editar Autor';
        document.getElementById('modal-author-btn').textContent   = 'Actualizar Autor';
        document.getElementById('form-author').action             = `/admin/biblioteca/authors/${author.id}`;
        document.getElementById('form-author-method').value       = 'PUT';
        document.getElementById('fa-name').value        = author.name ?? '';
        document.getElementById('fa-nationality').value = author.nationality ?? '';
        document.getElementById('fa-biography').value   = author.biography ?? '';
        setMulti('fa-books', bookIds);
        setMulti('fa-categories', categoryIds);
    }
}

function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function setMulti(id, ids) {
    const sel = document.getElementById(id);
    for (const opt of sel.options) opt.selected = ids.includes(parseInt(opt.value));
}

document.getElementById('search-input').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.author-row').forEach(row => {
        row.style.display = row.querySelector('.author-name').textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection
