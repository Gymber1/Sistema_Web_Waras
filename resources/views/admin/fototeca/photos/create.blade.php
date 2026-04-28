@extends('layouts.admin')

@section('section', 'Fototeca > Fotografías > Nueva')

@section('content')
<div class="max-w-[960px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.fototeca.photos') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Agregar nueva fotografía</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">FOTOGRAFÍA</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Completa los campos y guarda para registrar la nueva fotografía.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.fototeca.photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required autofocus
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Fotógrafos</label>
                    <div id="chips-photographers" class="flex flex-wrap gap-2 p-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-photographers" placeholder="Buscar y agregar fotógrafo..."
                            oninput="filterDropdown(this,'dropdown-photographers')" onfocus="showDropdown('dropdown-photographers')"
                            class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <div id="dropdown-photographers" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border rounded-lg shadow-lg max-h-52 overflow-y-auto">
                            @foreach($photographers as $ph)
                            <button type="button" data-id="{{ $ph->id }}" data-name="{{ $ph->full_name }}"
                                onclick="addChip(this,'chips-photographers','photographers')"
                                class="w-full text-left px-4 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 text-sm text-slate-700 dark:text-slate-300 border-b border-slate-50 dark:border-dark-border last:border-0 transition-colors">{{ $ph->full_name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Categoría</label>
                    <select id="sel-category" onchange="cascadeSubcategory()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="">— Seleccionar —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" data-name="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-category">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Subcategoría</label>
                    <select id="sel-subcategory" onchange="cascadeSublevel()" disabled
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50">
                        <option value="">— Primero elige categoría —</option>
                        @foreach($subcategories as $sub)
                        <option value="{{ $sub->id }}" data-parent="{{ $sub->parent_id }}" data-name="{{ $sub->name }}">{{ $sub->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-subcategory">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">SubNivel</label>
                    <select id="sel-sublevel" disabled
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50">
                        <option value="">— Primero elige subcategoría —</option>
                        @foreach($sublevels as $sub)
                        <option value="{{ $sub->id }}" data-parent="{{ $sub->parent_id }}" data-name="{{ $sub->name }}">{{ $sub->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-sublevel">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Etiqueta</label>
                    <select name="tag_id"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="">— Sin etiqueta —</option>
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ old('tag_id') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Año de la fotografía</label>
                    <input type="number" name="year" value="{{ old('year') }}" min="1800" max="{{ date('Y') }}" placeholder="Ej. 1970"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Ubicación</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Ej. Huaraz, Áncash"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Archivo o proveedor de la foto</label>
                    <input type="text" name="provider" value="{{ old('provider') }}" placeholder="Institución o persona que provee la fotografía"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Resolución</label>
                    <input type="text" name="resolution" value="{{ old('resolution') }}" placeholder="Ej. 4000x3000"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Formato</label>
                    <select name="format"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="">— Sin especificar —</option>
                        @foreach(['JPG','PNG','RAW','TIFF','WEBP','BMP','GIF','HEIC','SVG'] as $fmt)
                        <option value="{{ $fmt }}" @selected(old('format') === $fmt)>{{ $fmt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tipo de acceso <span class="text-red-500">*</span></label>
                    <select name="source_type" id="source_type" onchange="toggleSourceFields()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="none"     @selected(old('source_type','none')==='none')>Sin acceso</option>
                        <option value="local"    @selected(old('source_type')==='local')>Archivo local</option>
                        <option value="external" @selected(old('source_type')==='external')>URL externa</option>
                    </select>
                </div>

                <div id="field-external" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">URL externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url') }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Descripción</label>
                    <textarea name="description" rows="3" placeholder="Lugar, persona o acontecimiento que muestra la fotografía..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ old('description') }}</textarea>
                </div>

                <div class="md:col-span-3" id="field-image" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Imagen</label>
                    <input type="file" name="image_file" accept="image/*"
                        class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                </div>

            </div>
        </div>

        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.photos') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar fotografía</button>
        </div>
    </form>
</div>

<script>
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
    chip.innerHTML = `${name} <button type="button" onclick="removeChip(this)" class="hover:text-red-500 font-bold text-sm leading-none">×</button><input type="hidden" name="${field}[]" value="${id}">`;
    chips.appendChild(chip);
    const s = document.getElementById('search-' + field); if (s) s.value = '';
    document.getElementById('dropdown-' + field).classList.add('hidden');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
});

function cascadeSubcategory() {
    const catId  = document.getElementById('sel-category').value;
    const selSub = document.getElementById('sel-subcategory');
    const selLvl = document.getElementById('sel-sublevel');
    document.getElementById('hid-category').value    = catId;
    document.getElementById('hid-subcategory').value = '';
    document.getElementById('hid-sublevel').value    = '';
    selSub.innerHTML = '<option value="">— Seleccionar —</option>';
    selSub.disabled  = !catId;
    selLvl.innerHTML = '<option value="">— Primero elige subcategoría —</option>';
    selLvl.disabled  = true;
    if (!catId) return;
    document.querySelectorAll('#sel-subcategory-all option').forEach(opt => {
        if (opt.dataset.parent == catId) selSub.appendChild(opt.cloneNode(true));
    });
    if (selSub.options.length <= 1) { selSub.innerHTML = '<option value="">— Sin subcategorías —</option>'; selSub.disabled = true; }
}

function cascadeSublevel() {
    const subId  = document.getElementById('sel-subcategory').value;
    const selLvl = document.getElementById('sel-sublevel');
    document.getElementById('hid-subcategory').value = subId;
    document.getElementById('hid-sublevel').value    = '';
    selLvl.innerHTML = '<option value="">— Seleccionar —</option>';
    selLvl.disabled  = !subId;
    if (!subId) return;
    document.querySelectorAll('#sel-sublevel-all option').forEach(opt => {
        if (opt.dataset.parent == subId) selLvl.appendChild(opt.cloneNode(true));
    });
    if (selLvl.options.length <= 1) { selLvl.innerHTML = '<option value="">— Sin subniveles —</option>'; selLvl.disabled = true; }
}

document.getElementById('sel-sublevel').addEventListener('change', function() {
    document.getElementById('hid-sublevel').value = this.value;
});

function toggleSourceFields() {
    const val = document.getElementById('source_type').value;
    document.getElementById('field-external').style.display = val === 'external' ? '' : 'none';
    document.getElementById('field-image').style.display    = val === 'local'    ? '' : 'none';
}
toggleSourceFields();
</script>

<select id="sel-subcategory-all" class="hidden">
    @foreach($subcategories as $sub)
    <option value="{{ $sub->id }}" data-parent="{{ $sub->parent_id }}">{{ $sub->name }}</option>
    @endforeach
</select>
<select id="sel-sublevel-all" class="hidden">
    @foreach($sublevels as $lvl)
    <option value="{{ $lvl->id }}" data-parent="{{ $lvl->parent_id }}">{{ $lvl->name }}</option>
    @endforeach
</select>
@endsection
