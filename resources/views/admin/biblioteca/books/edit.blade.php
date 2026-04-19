@extends('layouts.admin')

@section('section', 'Biblioteca > Libros > Editar')

@section('content')
<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    {{-- Header --}}
    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.books') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Editar información</h1>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">LIBROS</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Modifica los campos necesarios y guarda los cambios.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            {{-- Título --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Autores (tag input) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Autores</label>
                    <div id="chips-authors" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]">
                        @foreach($book->authors as $author)
                        <span class="chip flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full">
                            {{ $author->name }}
                            <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-base leading-none">×</button>
                            <input type="hidden" name="authors[]" value="{{ $author->id }}">
                        </span>
                        @endforeach
                    </div>
                    <div class="relative mt-2">
                        <input type="text" id="search-authors" placeholder="Buscar y agregar autor..."
                            oninput="filterDropdown(this, 'dropdown-authors')" onfocus="showDropdown('dropdown-authors')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">
                        <div id="dropdown-authors" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($authors as $author)
                            <button type="button" data-id="{{ $author->id }}" data-name="{{ $author->name }}"
                                onclick="addChip(this, 'chips-authors', 'authors')"
                                class="w-full text-left px-4 py-2.5 hover:bg-emerald-50 text-sm border-b border-slate-50 last:border-0">
                                {{ $author->name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Categorías (tag input) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Categorías</label>
                    <div id="chips-categories" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]">
                        @foreach($book->categories as $cat)
                        <span class="chip flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-full">
                            {{ $cat->name }}
                            <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-base leading-none">×</button>
                            <input type="hidden" name="categories[]" value="{{ $cat->id }}">
                        </span>
                        @endforeach
                    </div>
                    <div class="relative mt-2">
                        <input type="text" id="search-categories" placeholder="Buscar y agregar categoría..."
                            oninput="filterDropdown(this, 'dropdown-categories')" onfocus="showDropdown('dropdown-categories')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">
                        <div id="dropdown-categories" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($categories as $cat)
                            <button type="button" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}"
                                onclick="addChip(this, 'chips-categories', 'categories')"
                                class="w-full text-left px-4 py-2.5 hover:bg-emerald-50 text-sm border-b border-slate-50 last:border-0"
                                style="padding-left: {{ 16 + $cat->depth * 16 }}px">
                                {{ $cat->depth > 0 ? str_repeat('— ', $cat->depth) : '' }}{{ $cat->name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Editorial --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Editorial</label>
                    <select name="publisher_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">Sin editorial</option>
                        @foreach($publishers as $pub)
                        <option value="{{ $pub->id }}" @selected(old('publisher_id', $book->publisher_id) == $pub->id)>{{ $pub->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha de publicación --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Fecha de publicación</label>
                    <input type="date" name="publication_date" value="{{ old('publication_date', $book->publication_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- ISBN --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Páginas --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Páginas</label>
                    <input type="number" name="pages" value="{{ old('pages', $book->pages) }}" min="1"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Idioma --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Idioma</label>
                    <input type="text" name="language" value="{{ old('language', $book->language) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Tipo de acceso --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Tipo de acceso <span class="text-red-500">*</span></label>
                    <select name="source_type" id="source_type" onchange="toggleSourceFields()"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="none" @selected(old('source_type', $book->source_type) === 'none')>Sin acceso</option>
                        <option value="external" @selected(old('source_type', $book->source_type) === 'external')>URL externa</option>
                        <option value="pdf" @selected(old('source_type', $book->source_type) === 'pdf')>Archivo PDF</option>
                    </select>
                </div>

                {{-- URL externa --}}
                <div id="field-external">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">URL externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url', $book->external_url) }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Sinopsis --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Sinopsis / Resumen</label>
                    <textarea name="summary" rows="4"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-y">{{ old('summary', $book->summary) }}</textarea>
                </div>

                {{-- Portada --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Imagen de portada</label>
                    @if($book->cover_image_path)
                    <div class="flex items-center gap-3 mb-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                        <img src="{{ Storage::url($book->cover_image_path) }}" class="w-12 h-16 object-cover rounded-lg border border-emerald-200 cursor-zoom-in"
                            onclick="openLightbox('{{ Storage::url($book->cover_image_path) }}', '{{ addslashes($book->title) }}')"
                            onerror="this.style.display='none'">
                        <div>
                            <p class="text-xs font-bold text-emerald-700">Archivo actual cargado</p>
                            <p class="text-xs text-emerald-600 mt-0.5">Sube una nueva imagen para reemplazarla</p>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="cover_image" accept="image/*"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold hover:file:bg-emerald-200">
                </div>

                {{-- PDF --}}
                <div id="field-pdf">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Archivo PDF</label>
                    @if($book->pdf_file_path)
                    <div class="flex items-center gap-3 mb-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                        <svg class="w-8 h-8 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <div>
                            <p class="text-xs font-bold text-emerald-700">Archivo actual cargado</p>
                            <p class="text-xs text-emerald-600 mt-0.5">Sube un nuevo PDF para reemplazarlo</p>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="pdf_file" accept=".pdf"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold hover:file:bg-emerald-200">
                </div>

            </div>
        </div>

        {{-- Acciones --}}
        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.books') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">
                Guardar cambios
            </button>
        </div>
    </form>
</div>

<script>
function removeChip(btn) {
    btn.closest('.chip').remove();
}

function showDropdown(id) {
    document.getElementById(id).classList.remove('hidden');
}

function filterDropdown(input, dropdownId) {
    const q = input.value.toLowerCase();
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden', q.length === 0);
    dropdown.querySelectorAll('button').forEach(btn => {
        btn.style.display = btn.dataset.name?.toLowerCase().includes(q) ? '' : 'none';
    });
    dropdown.querySelectorAll('div').forEach(div => { div.style.display = ''; });
}

function addChip(btn, chipsId, field) {
    const id = btn.dataset.id;
    const name = btn.dataset.name;
    const chips = document.getElementById(chipsId);
    if (chips.querySelector(`input[value="${id}"]`)) return;
    const chip = document.createElement('span');
    chip.className = 'chip flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full';
    chip.innerHTML = `${name} <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-base leading-none">×</button><input type="hidden" name="${field}[]" value="${id}">`;
    chips.appendChild(chip);
    const searchInput = document.getElementById('search-' + field);
    if (searchInput) { searchInput.value = ''; }
    document.getElementById('dropdown-' + field).classList.add('hidden');
}

function toggleSourceFields() {
    const val = document.getElementById('source_type').value;
    document.getElementById('field-external').style.display = val === 'external' ? '' : 'none';
    document.getElementById('field-pdf').style.display = val === 'pdf' ? '' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
    }
});

toggleSourceFields();
</script>
@endsection
