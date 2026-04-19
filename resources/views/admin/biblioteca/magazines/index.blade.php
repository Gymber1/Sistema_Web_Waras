@extends('layouts.admin')

@section('section', 'Biblioteca > Revistas')

@section('content')
<div class="p-6 md:p-10 max-w-[1600px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Revistas</h1>
            <p class="text-slate-500 mt-1">Administra todas las revistas del catálogo de la Biblioteca Digital.</p>
        </div>
        <a href="{{ route('admin.biblioteca.magazines.create') }}"
            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar Revista
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-emerald-500">
        <div class="p-5 border-b border-slate-100 flex flex-wrap justify-between items-center gap-4">
            <div class="relative w-full sm:w-80">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input id="search-input" type="text" placeholder="Buscar revistas..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <span class="text-sm font-bold bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg">{{ $magazines->count() }} Registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Portada</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Título</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Autores</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Categorías</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Editorial</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Año</th>
                        <th class="py-4 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($magazines as $mag)
                    <tr class="hover:bg-slate-50 group mag-row">
                        <td class="py-3 px-4">
                            @if($mag->cover_image_path)
                                <img src="{{ Storage::url($mag->cover_image_path) }}" alt="{{ $mag->title }}"
                                    class="w-10 h-14 object-cover rounded-md shadow cursor-zoom-in hover:opacity-80 transition-opacity"
                                    onclick="openLightbox('{{ Storage::url($mag->cover_image_path) }}', '{{ addslashes($mag->title) }}')"
                                    onerror="this.parentElement.innerHTML='<div class=\'w-10 h-14 bg-emerald-100 rounded-md flex items-center justify-center text-emerald-400 text-xl\'>📰</div>'">
                            @else
                                <div class="w-10 h-14 bg-emerald-100 rounded-md flex items-center justify-center text-emerald-400 text-xl">📰</div>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm font-semibold text-slate-800 mag-title">{{ $mag->title }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $mag->authors->pluck('name')->join(', ') ?: '—' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $mag->categories->pluck('name')->join(', ') ?: '—' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $mag->publisher->name ?? '—' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $mag->publication_date ? $mag->publication_date->format('Y') : '—' }}
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100">
                                <a href="{{ route('admin.biblioteca.magazines.edit', $mag) }}"
                                    class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg bg-white border border-slate-100" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.biblioteca.magazines.destroy', $mag) }}" method="POST" onsubmit="return confirm('¿Eliminar esta revista?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg bg-white border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-16 text-center text-slate-400">No hay revistas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL REVISTA -->
<div id="modal-mag" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-mag')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[92vh] flex flex-col">
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100">
            <h2 id="modal-mag-title" class="text-xl font-black text-slate-900">Agregar Revista</h2>
            <button onclick="closeModal('modal-mag')" class="p-2 text-slate-400 hover:bg-slate-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
            </button>
        </div>

        <form id="form-mag" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" name="_method" id="form-mag-method" value="POST">

            <div class="p-8 overflow-y-auto grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Título <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="fm-title" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Portada (imagen)</label>
                    <input type="file" name="cover_image" accept="image/*"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Número de Páginas</label>
                    <input type="number" name="pages" id="fm-pages" min="1"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Autores</label>
                    <select name="authors[]" id="fm-authors" multiple
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 h-28">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Ctrl/Cmd + clic para seleccionar varios</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Categorías / Subcategorías</label>
                    <select name="categories[]" id="fm-categories" multiple
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 h-28">
                        @foreach($categories as $cat)
                            <optgroup label="{{ $cat->name }}">
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @foreach($cat->subcategories as $sub)
                                    <option value="{{ $sub->id }}">— {{ $sub->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Ctrl/Cmd + clic para seleccionar varios</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Editorial</label>
                    <select name="publisher_id" id="fm-publisher"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800">
                        <option value="">Sin editorial</option>
                        @foreach($publishers as $pub)
                            <option value="{{ $pub->id }}">{{ $pub->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Fecha de Publicación</label>
                    <input type="date" name="publication_date" id="fm-date"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Descripción</label>
                    <textarea name="summary" id="fm-summary" rows="3"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 resize-none"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Fuente del documento</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="source_type" value="none" class="accent-emerald-600" checked onchange="toggleSource()"> Sin fuente
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="source_type" value="external" class="accent-emerald-600" onchange="toggleSource()"> Link externo
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="source_type" value="pdf" class="accent-emerald-600" onchange="toggleSource()"> Archivo PDF
                        </label>
                    </div>
                    <div id="field-url" class="mt-3 hidden">
                        <input type="url" name="external_url" id="fm-url"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800" placeholder="https://...">
                    </div>
                    <div id="field-pdf" class="mt-3 hidden">
                        <input type="file" name="pdf_file" accept=".pdf"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold">
                    </div>
                </div>
            </div>

            <div class="px-8 py-5 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modal-mag')"
                    class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Cancelar</button>
                <button type="submit"
                    class="px-7 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg shadow-emerald-200 flex items-center gap-2">
                    <span id="modal-mag-btn">Guardar Revista</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const storeUrl = "{{ route('admin.biblioteca.magazines.store') }}";

function toggleSource() {
    const val = document.querySelector('input[name="source_type"]:checked').value;
    document.getElementById('field-url').classList.toggle('hidden', val !== 'external');
    document.getElementById('field-pdf').classList.toggle('hidden', val !== 'pdf');
}

function openModal(id, mode, mag, authorIds, categoryIds) {
    document.getElementById(id).classList.remove('hidden');
    if (mode === 'create') {
        document.getElementById('modal-mag-title').textContent = 'Agregar Revista';
        document.getElementById('modal-mag-btn').textContent   = 'Guardar Revista';
        document.getElementById('form-mag').action             = storeUrl;
        document.getElementById('form-mag-method').value       = 'POST';
        document.getElementById('form-mag').reset();
        document.getElementById('field-url').classList.add('hidden');
        document.getElementById('field-pdf').classList.add('hidden');
        setMulti('fm-authors', []);
        setMulti('fm-categories', []);
    } else {
        document.getElementById('modal-mag-title').textContent = 'Editar Revista';
        document.getElementById('modal-mag-btn').textContent   = 'Actualizar Revista';
        document.getElementById('form-mag').action             = `/admin/biblioteca/magazines/${mag.id}`;
        document.getElementById('form-mag-method').value       = 'PUT';
        document.getElementById('fm-title').value     = mag.title ?? '';
        document.getElementById('fm-pages').value     = mag.pages ?? '';
        document.getElementById('fm-date').value      = mag.publication_date ? mag.publication_date.split('T')[0] : '';
        document.getElementById('fm-summary').value   = mag.summary ?? '';
        document.getElementById('fm-url').value       = mag.external_url ?? '';
        document.getElementById('fm-publisher').value = mag.publisher_id ?? '';
        const src = mag.source_type ?? 'none';
        document.querySelector(`input[name="source_type"][value="${src}"]`).checked = true;
        toggleSource();
        setMulti('fm-authors', authorIds);
        setMulti('fm-categories', categoryIds);
    }
}

function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function setMulti(id, ids) {
    const sel = document.getElementById(id);
    for (const opt of sel.options) opt.selected = ids.includes(parseInt(opt.value));
}

document.getElementById('search-input').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.mag-row').forEach(row => {
        row.style.display = row.querySelector('.mag-title').textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection
