@extends('layouts.admin')

@section('section', 'Biblioteca > Revistas > Nueva')

@section('content')
<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.magazines') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Agregar nueva</h1>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">REVISTA</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Completa los campos y guarda para registrar la nueva revista.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.magazines.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            {{-- Título --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Autores (multiselect chips) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Autores</label>
                    <div id="chips-authors" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-authors" placeholder="Buscar y agregar autor..."
                            oninput="filterDropdown(this,'dropdown-authors')" onfocus="showDropdown('dropdown-authors')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">
                        <div id="dropdown-authors" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($authors as $author)
                            <button type="button" data-id="{{ $author->id }}" data-name="{{ $author->name }}"
                                onclick="addChip(this,'chips-authors','authors')"
                                class="w-full text-left px-4 py-2.5 hover:bg-emerald-50 text-sm border-b border-slate-50 last:border-0">{{ $author->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Tipo de documento --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Tipo de documento <span class="text-red-500">*</span></label>
                    <select name="document_type" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="Revista" @selected(old('document_type','Revista')==='Revista')>Revista</option>
                        <option value="Libro"   @selected(old('document_type')==='Libro')>Libros y artículos</option>
                        <option value="Artículo" @selected(old('document_type')==='Artículo')>Artículo</option>
                        <option value="Tesis"   @selected(old('document_type')==='Tesis')>Tesis</option>
                    </select>
                </div>

                {{-- Sección --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Sección <span class="text-red-500">*</span></label>
                    <select name="section" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="Biblioteca Digital" @selected(old('section','Biblioteca Digital')==='Biblioteca Digital')>Biblioteca Digital</option>
                        <option value="Waras Editorial"    @selected(old('section')==='Waras Editorial')>Waras Editorial</option>
                    </select>
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Categoría</label>
                    <select name="category_id" id="category_id" onchange="loadSubcategories(this.value)"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">— Sin categoría —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- SubCategoría --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">SubCategoría</label>
                    <select name="subcategory_id" id="subcategory_id"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white disabled:opacity-50"
                        {{ old('category_id') ? '' : 'disabled' }}>
                        <option value="">— Selecciona primero una categoría —</option>
                    </select>
                </div>

                {{-- Resumen --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Resumen</label>
                    <textarea name="summary" rows="4"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-y">{{ old('summary') }}</textarea>
                </div>

                {{-- Pie de Imprenta --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Pie de Imprenta
                        <span class="text-slate-400 font-normal">(Lugar, editorial, año)</span>
                    </label>
                    <input type="text" name="imprint" value="{{ old('imprint') }}" placeholder="Ej. Huaraz: UNASAM, 2020"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- N° Páginas --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">N° Páginas</label>
                    <input type="number" name="pages" value="{{ old('pages') }}" min="1"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Fecha de publicación --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Fecha de publicación</label>
                    <input type="date" name="publication_date" value="{{ old('publication_date') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Descriptores --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Descriptores</label>
                    <div id="chips-descriptors" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-descriptors" placeholder="Buscar y agregar descriptor..."
                            oninput="filterDropdown(this,'dropdown-descriptors')" onfocus="showDropdown('dropdown-descriptors')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">
                        <div id="dropdown-descriptors" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($descriptors as $descriptor)
                            <button type="button" data-id="{{ $descriptor->id }}" data-name="{{ $descriptor->name }}"
                                onclick="addChip(this,'chips-descriptors','descriptors')"
                                class="w-full text-left px-4 py-2.5 hover:bg-emerald-50 text-sm border-b border-slate-50 last:border-0">{{ $descriptor->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Proveído --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Proveído
                        <span class="text-slate-400 font-normal">(origen o donante del material)</span>
                    </label>
                    <input type="text" name="provider" value="{{ old('provider') }}" placeholder="Ej. Donación Familia Alba"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Tipo de acceso --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Tipo de Acceso <span class="text-red-500">*</span></label>
                    <select name="source_type" id="source_type" onchange="toggleSourceFields()"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="none"     @selected(old('source_type','none')==='none')>Sin acceso</option>
                        <option value="external" @selected(old('source_type')==='external')>URL externa</option>
                        <option value="pdf"      @selected(old('source_type')==='pdf')>Carga de archivo PDF</option>
                    </select>
                </div>

                {{-- URL externa (condicional) --}}
                <div id="field-external" style="display:none">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">URL externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url') }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- PDF (condicional) --}}
                <div id="field-pdf" style="display:none">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Archivo PDF</label>
                    <input type="file" name="pdf_file" accept=".pdf"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold hover:file:bg-emerald-200">
                </div>

                {{-- Imagen de portada --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Imagen de portada</label>
                    <input type="file" name="cover_image" accept="image/*"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold hover:file:bg-emerald-200">
                </div>

            </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.magazines') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">Guardar revista</button>
        </div>
    </form>
</div>
<script>
const subcatsMap = @json(
    $categories->mapWithKeys(fn($cat) => [
        $cat->id => $cat->subcategories->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values()
    ])
);

function loadSubcategories(catId) {
    const sel = document.getElementById('subcategory_id');
    sel.innerHTML = '<option value="">— Sin subcategoría —</option>';
    if (!catId || !subcatsMap[catId] || subcatsMap[catId].length === 0) {
        sel.disabled = true;
        return;
    }
    subcatsMap[catId].forEach(sub => {
        const opt = document.createElement('option');
        opt.value = sub.id;
        opt.textContent = sub.name;
        sel.appendChild(opt);
    });
    sel.disabled = false;
}

// Restaurar subcategorías si hay old() tras error de validación
@if(old('category_id'))
document.addEventListener('DOMContentLoaded', function() {
    loadSubcategories('{{ old('category_id') }}');
    document.getElementById('subcategory_id').value = '{{ old('subcategory_id') }}';
});
@endif

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
    chip.className = 'chip flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full';
    chip.innerHTML = `${name} <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-base leading-none">×</button><input type="hidden" name="${field}[]" value="${id}">`;
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
