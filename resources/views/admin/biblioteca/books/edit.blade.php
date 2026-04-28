@extends('layouts.admin')

@section('section', 'Biblioteca > Libros > Editar')

@section('content')
<div class="max-w-[960px] mx-auto">

    {{-- Header --}}
    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.biblioteca.books') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Editar libro</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">LIBRO</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Modifica los campos necesarios y guarda los cambios.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">

            {{-- Título --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Autores --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Autores</label>
                    <div id="chips-authors" class="flex flex-wrap gap-2 p-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800/50 min-h-[48px]">
                        @foreach($book->authors as $author)
                        <span class="chip inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-50 dark:bg-brand-500/10 text-brand-700 dark:text-brand-300 text-xs font-semibold rounded-full border border-brand-100 dark:border-brand-500/20">
                            {{ $author->name }}
                            <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-sm leading-none">×</button>
                            <input type="hidden" name="authors[]" value="{{ $author->id }}">
                        </span>
                        @endforeach
                    </div>
                    <div class="relative mt-2">
                        <input type="text" id="search-authors" placeholder="Buscar y agregar autor..."
                            oninput="filterDropdown(this,'dropdown-authors')" onfocus="showDropdown('dropdown-authors')"
                            class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <div id="dropdown-authors" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($authors as $author)
                            <button type="button" data-id="{{ $author->id }}" data-name="{{ $author->name }}"
                                onclick="addChip(this,'chips-authors','authors')"
                                class="w-full text-left px-4 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 text-sm text-slate-700 dark:text-slate-300 border-b border-slate-50 dark:border-dark-border last:border-0">{{ $author->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Tipo de documento --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tipo de documento <span class="text-red-500">*</span></label>
                    <select name="document_type" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="Libro"    @selected(old('document_type', $book->document_type)==='Libro')>Libros y artículos</option>
                        <option value="Revista"  @selected(old('document_type', $book->document_type)==='Revista')>Revista</option>
                        <option value="Artículo" @selected(old('document_type', $book->document_type)==='Artículo')>Artículo</option>
                        <option value="Tesis"    @selected(old('document_type', $book->document_type)==='Tesis')>Tesis</option>
                    </select>
                </div>

                {{-- Sección --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Sección <span class="text-red-500">*</span></label>
                    <select name="section" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="Biblioteca Digital" @selected(old('section', $book->section)==='Biblioteca Digital')>Biblioteca Digital</option>
                        <option value="Waras Editorial"    @selected(old('section', $book->section)==='Waras Editorial')>Waras Editorial</option>
                    </select>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Los libros de <strong class="text-slate-600 dark:text-slate-300">Waras Editorial</strong> también aparecen en Biblioteca Digital.</p>
                </div>

                {{-- Categoría --}}
                @php
                    $bookCatParent = $book->categories->firstWhere('parent_id', null);
                    $bookCatChild  = $book->categories->firstWhere('parent_id', '!=', null);
                    $currentCatId  = old('category_id', $bookCatParent?->id ?? '');
                    $currentSubId  = old('subcategory_id', $bookCatChild?->id ?? '');
                @endphp
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Categoría</label>
                    <select name="category_id" id="category_id" onchange="loadSubcategories(this.value)"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="">— Sin categoría —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($currentCatId == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- SubCategoría --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">SubCategoría</label>
                    <select name="subcategory_id" id="subcategory_id"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50"
                        {{ $currentCatId ? '' : 'disabled' }}>
                        <option value="">— Sin subcategoría —</option>
                    </select>
                </div>

                {{-- Resumen --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Resumen</label>
                    <textarea name="summary" rows="4"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ old('summary', $book->summary) }}</textarea>
                </div>

                {{-- Pie de Imprenta --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Pie de Imprenta <span class="text-slate-400 dark:text-slate-500 font-normal">(Lugar, editorial, año)</span></label>
                    <input type="text" name="imprint" value="{{ old('imprint', $book->imprint) }}" placeholder="Ej. Huaraz: UNASAM, 2020"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- N° Páginas --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">N° Páginas</label>
                    <input type="number" name="pages" value="{{ old('pages', $book->pages) }}" min="1"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Fecha de publicación --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Fecha de publicación</label>
                    <input type="date" name="publication_date" value="{{ old('publication_date', $book->publication_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Descriptores --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Descriptores</label>
                    <div id="chips-descriptors" class="flex flex-wrap gap-2 p-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800/50 min-h-[48px]">
                        @foreach($book->descriptors as $descriptor)
                        <span class="chip inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 dark:bg-slate-700/50 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-full">
                            {{ $descriptor->name }}
                            <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-sm leading-none">×</button>
                            <input type="hidden" name="descriptors[]" value="{{ $descriptor->id }}">
                        </span>
                        @endforeach
                    </div>
                    <div class="relative mt-2">
                        <input type="text" id="search-descriptors" placeholder="Buscar y agregar descriptor..."
                            oninput="filterDropdown(this,'dropdown-descriptors')" onfocus="showDropdown('dropdown-descriptors')"
                            class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <div id="dropdown-descriptors" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($descriptors as $descriptor)
                            <button type="button" data-id="{{ $descriptor->id }}" data-name="{{ $descriptor->name }}"
                                onclick="addChip(this,'chips-descriptors','descriptors')"
                                class="w-full text-left px-4 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 text-sm text-slate-700 dark:text-slate-300 border-b border-slate-50 dark:border-dark-border last:border-0">{{ $descriptor->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Proveído --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Proveído <span class="text-slate-400 dark:text-slate-500 font-normal">(origen o donante del material)</span></label>
                    <input type="text" name="provider" value="{{ old('provider', $book->provider) }}" placeholder="Ej. Donación Familia Alba"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Tipo de acceso --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tipo de Acceso <span class="text-red-500">*</span></label>
                    <select name="source_type" id="source_type" onchange="toggleSourceFields()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="none"     @selected(old('source_type', $book->source_type)==='none')>Sin acceso</option>
                        <option value="external" @selected(old('source_type', $book->source_type)==='external')>URL externa</option>
                        <option value="pdf"      @selected(old('source_type', $book->source_type)==='pdf')>Carga de archivo PDF</option>
                    </select>
                </div>

                {{-- URL externa (condicional) --}}
                <div id="field-external" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">URL externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url', $book->external_url) }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- PDF (condicional) --}}
                <div id="field-pdf" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Archivo PDF</label>
                    @if($book->pdf_file_path)
                    <div class="flex items-center gap-3 mb-3 p-3 bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 rounded-lg">
                        <i data-lucide="file-text" class="w-5 h-5 text-brand-500 dark:text-brand-400 flex-shrink-0"></i>
                        <div>
                            <p class="text-xs font-semibold text-brand-700 dark:text-brand-300">Archivo actual cargado</p>
                            <p class="text-xs text-brand-600 dark:text-brand-400 mt-0.5">Sube un nuevo PDF para reemplazarlo</p>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="pdf_file" accept=".pdf"
                        class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                </div>

                {{-- Imagen de portada --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Imagen de portada</label>
                    @if($book->cover_image_path)
                    <div class="flex items-center gap-3 mb-3 p-3 bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 rounded-lg">
                        <img src="{{ Storage::url($book->cover_image_path) }}" class="w-10 h-14 object-cover rounded-md border border-brand-200 dark:border-brand-500/30" onerror="this.style.display='none'">
                        <div>
                            <p class="text-xs font-semibold text-brand-700 dark:text-brand-300">Imagen actual cargada</p>
                            <p class="text-xs text-brand-600 dark:text-brand-400 mt-0.5">Sube una nueva imagen para reemplazarla</p>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="cover_image" accept="image/*"
                        class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                </div>

            </div>
        </div>

        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.books') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar cambios</button>
        </div>
    </form>
</div>
<script>
const subcatsMap = @json(
    $categories->mapWithKeys(fn($cat) => [
        $cat->id => $cat->subcategories->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values()
    ])
);

function loadSubcategories(catId, selectedId) {
    const sel = document.getElementById('subcategory_id');
    sel.innerHTML = '<option value="">— Sin subcategoría —</option>';
    if (!catId || !subcatsMap[catId] || subcatsMap[catId].length === 0) { sel.disabled = true; return; }
    subcatsMap[catId].forEach(sub => {
        const opt = document.createElement('option');
        opt.value = sub.id; opt.textContent = sub.name;
        if (selectedId && sub.id == selectedId) opt.selected = true;
        sel.appendChild(opt);
    });
    sel.disabled = false;
}

document.addEventListener('DOMContentLoaded', function() {
    const catId = document.getElementById('category_id').value;
    if (catId) loadSubcategories(catId, '{{ $currentSubId }}');
});

function removeChip(btn) { btn.closest('.chip').remove(); }
function showDropdown(id) { document.getElementById(id).classList.remove('hidden'); }
function filterDropdown(input, dropdownId) {
    const q = input.value.toLowerCase();
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden', q.length === 0);
    dropdown.querySelectorAll('button').forEach(btn => { btn.style.display = btn.dataset.name?.toLowerCase().includes(q) ? '' : 'none'; });
}
function addChip(btn, chipsId, field) {
    const id = btn.dataset.id, name = btn.dataset.name;
    const chips = document.getElementById(chipsId);
    if (chips.querySelector(`input[value="${id}"]`)) return;
    const chip = document.createElement('span');
    chip.className = 'chip inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-50 dark:bg-brand-500/10 text-brand-700 dark:text-brand-300 text-xs font-semibold rounded-full border border-brand-100 dark:border-brand-500/20';
    chip.innerHTML = `${name} <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-sm leading-none">×</button><input type="hidden" name="${field}[]" value="${id}">`;
    chips.appendChild(chip);
    const s = document.getElementById('search-' + field); if (s) s.value = '';
    document.getElementById('dropdown-' + field).classList.add('hidden');
}
function toggleSourceFields() {
    const val = document.getElementById('source_type').value;
    document.getElementById('field-external').style.display = val === 'external' ? '' : 'none';
    document.getElementById('field-pdf').style.display = val === 'pdf' ? '' : 'none';
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
});
toggleSourceFields();
</script>
@endsection
