@extends('layouts.admin')

@section('section', 'Biblioteca > Libros > Nuevo')

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
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Agregar nuevo libro</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">LIBRO</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Completa los campos y guarda para registrar el nuevo libro.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">

            {{-- Título --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Autores (multiselect chips) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Autores</label>
                    <div id="chips-authors" class="flex flex-wrap gap-2 p-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800/50 min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-authors" placeholder="Buscar y agregar autor..."
                            oninput="filterDropdown(this,'dropdown-authors')" onclick="showDropdown('dropdown-authors')"
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
                        <option value="Libro"    @selected(old('document_type','Libro')==='Libro')>Libros y artículos</option>
                        <option value="Revista"  @selected(old('document_type')==='Revista')>Revista</option>
                        <option value="Artículo" @selected(old('document_type')==='Artículo')>Artículo</option>
                        <option value="Tesis"    @selected(old('document_type')==='Tesis')>Tesis</option>
                    </select>
                </div>

                {{-- Sección --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Sección <span class="text-red-500">*</span></label>
                    <select name="section" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="Biblioteca Digital" @selected(old('section','Biblioteca Digital')==='Biblioteca Digital')>Biblioteca Digital</option>
                        <option value="Waras Editorial"    @selected(old('section')==='Waras Editorial')>Waras Editorial</option>
                    </select>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Los libros de <strong class="text-slate-600 dark:text-slate-300">Waras Editorial</strong> también aparecen en Biblioteca Digital.</p>
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Categoría</label>
                    <select name="category_id" id="category_id" onchange="loadSubcategories(this.value)"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="">— Sin categoría —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- SubCategoría --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">SubCategoría</label>
                    <select name="subcategory_id" id="subcategory_id" onchange="loadFirstlevels(this.value)"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50"
                        {{ old('category_id') ? '' : 'disabled' }}>
                        <option value="">— Selecciona primero una categoría —</option>
                    </select>
                </div>

                {{-- 1er Nivel --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">1er Nivel</label>
                    <select name="firstlevel_id" id="firstlevel_id"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50"
                        disabled>
                        <option value="">— Selecciona primero una subcategoría —</option>
                    </select>
                </div>

                {{-- Resumen --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Resumen</label>
                    <textarea name="summary" rows="4"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ old('summary') }}</textarea>
                </div>

                {{-- Ciudad --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Ciudad</label>
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="Ej. Huaraz"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Editorial --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Editorial</label>
                    <input type="text" name="editorial_name" value="{{ old('editorial_name') }}" placeholder="Ej. UNASAM"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Año de publicación --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Año de publicación</label>
                    <input type="number" name="publication_year" value="{{ old('publication_year') }}" min="1800" max="2100" placeholder="Ej. 2020"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- N° Páginas --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">N° Páginas</label>
                    <input type="number" name="pages" value="{{ old('pages') }}" min="1"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Descriptores --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Descriptores</label>
                    <div id="chips-descriptors" class="flex flex-wrap gap-2 p-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800/50 min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-descriptors" placeholder="Buscar y agregar descriptor..."
                            oninput="filterDropdown(this,'dropdown-descriptors')" onclick="showDropdown('dropdown-descriptors')"
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
                    <input type="text" name="provider" value="{{ old('provider') }}" placeholder="Ej. Donación Familia Alba"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Tipo de acceso --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tipo de Acceso <span class="text-red-500">*</span></label>
                    <select name="source_type" id="source_type" onchange="toggleSourceFields()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="none"     @selected(old('source_type','none')==='none')>Sin acceso</option>
                        <option value="external" @selected(old('source_type')==='external')>URL externa</option>
                        <option value="pdf"      @selected(old('source_type')==='pdf')>Carga de archivo PDF</option>
                    </select>
                </div>

                {{-- URL externa (condicional) --}}
                <div id="field-external" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">URL externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url') }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- PDF (condicional) --}}
                <div id="field-pdf" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Archivo PDF</label>
                    <input type="file" name="pdf_file" accept=".pdf"
                        class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                </div>

                {{-- Imagen de portada --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Imagen de portada</label>
                    <input type="file" name="cover_image" accept="image/*"
                        class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                </div>

            </div>
        </div>

        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.books') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar libro</button>
        </div>
    </form>
</div>
<script>
const subcatsMap = @json(
    $categories->mapWithKeys(fn($cat) => [
        $cat->id => $cat->subcategories->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values()
    ])
);
const firstlevelsMap = @json(
    $categories->flatMap(fn($cat) => $cat->subcategories)->mapWithKeys(fn($sub) => [
        $sub->id => $sub->subcategories->map(fn($f) => ['id' => $f->id, 'name' => $f->name])->values()
    ])
);

function loadSubcategories(catId) {
    const sel = document.getElementById('subcategory_id');
    const selF = document.getElementById('firstlevel_id');
    sel.innerHTML = '<option value="">— Sin subcategoría —</option>';
    selF.innerHTML = '<option value="">— Selecciona primero una subcategoría —</option>';
    selF.disabled = true;
    if (!catId || !subcatsMap[catId] || subcatsMap[catId].length === 0) { sel.disabled = true; return; }
    subcatsMap[catId].forEach(sub => {
        const opt = document.createElement('option');
        opt.value = sub.id; opt.textContent = sub.name;
        sel.appendChild(opt);
    });
    sel.disabled = false;
}

function loadFirstlevels(subId) {
    const sel = document.getElementById('firstlevel_id');
    sel.innerHTML = '<option value="">— Sin 1er nivel —</option>';
    if (!subId || !firstlevelsMap[subId] || firstlevelsMap[subId].length === 0) { sel.disabled = true; return; }
    firstlevelsMap[subId].forEach(f => {
        const opt = document.createElement('option');
        opt.value = f.id; opt.textContent = f.name;
        sel.appendChild(opt);
    });
    sel.disabled = false;
}

@if(old('category_id'))
document.addEventListener('DOMContentLoaded', function() {
    loadSubcategories('{{ old('category_id') }}');
    document.getElementById('subcategory_id').value = '{{ old('subcategory_id') }}';
    if ('{{ old('subcategory_id') }}') {
        loadFirstlevels('{{ old('subcategory_id') }}');
        document.getElementById('firstlevel_id').value = '{{ old('firstlevel_id') }}';
    }
});
@endif

function removeChip(btn) { btn.closest('.chip').remove(); }

function showDropdown(id) {
    document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
    document.getElementById(id).classList.remove('hidden');
}

function filterDropdown(input, dropdownId) {
    const q = input.value.toLowerCase();
    const dd = document.getElementById(dropdownId);
    let visible = 0;
    dd.querySelectorAll('button').forEach(btn => {
        const match = !q || btn.dataset.name?.toLowerCase().includes(q);
        btn.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    dd.classList.toggle('hidden', visible === 0);
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

document.addEventListener('mousedown', function(e) {
    const inDropdown = e.target.closest('.tag-dropdown');
    const inSearchInput = e.target.tagName === 'INPUT' && e.target.id && e.target.id.startsWith('search-');
    if (!inDropdown && !inSearchInput) {
        document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
    }
});

function toggleSourceFields() {
    const val = document.getElementById('source_type').value;
    document.getElementById('field-external').style.display = val === 'external' ? '' : 'none';
    document.getElementById('field-pdf').style.display = val === 'pdf' ? '' : 'none';
}
toggleSourceFields();
</script>
@endsection
