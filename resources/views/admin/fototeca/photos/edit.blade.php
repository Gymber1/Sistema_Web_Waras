@extends('layouts.admin')

@section('section', 'Fototeca > Fotografías > Editar')

@section('content')
<div class="max-w-[960px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.fototeca.photos') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Editar fotografía</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">FOTOGRAFÍA</span>
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

    <form action="{{ route('admin.fototeca.photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">

            @if($photo->image_url)
            <div class="flex items-start gap-4 p-4 bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 rounded-lg">
                <img src="{{ $photo->image_url }}" class="w-20 h-20 object-cover rounded-lg border border-brand-200 dark:border-brand-500/30 flex-shrink-0 cursor-zoom-in"
                    onclick="openLightbox('{{ $photo->image_url }}', '{{ addslashes($photo->title) }}')"
                    onerror="this.style.display='none'">
                <div>
                    <p class="text-sm font-semibold text-brand-700 dark:text-brand-300">Imagen actual cargada</p>
                    <p class="text-xs text-brand-600 dark:text-brand-400 mt-0.5">{{ $photo->title }}</p>
                </div>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $photo->title) }}" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Fotógrafos</label>
                    <div id="chips-photographers" class="flex flex-wrap gap-2 p-3 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg min-h-[48px]">
                        @foreach($photo->photographers as $ph)
                        <span class="chip inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-50 dark:bg-brand-500/10 text-brand-700 dark:text-brand-300 text-xs font-semibold rounded-full border border-brand-100 dark:border-brand-500/20">
                            {{ $ph->full_name }}
                            <button type="button" onclick="removeChip(this)" class="hover:text-red-500 font-bold text-sm leading-none">×</button>
                            <input type="hidden" name="photographers[]" value="{{ $ph->id }}">
                        </span>
                        @endforeach
                    </div>
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
                        <option value="{{ $cat->id }}" data-name="{{ $cat->name }}"
                            {{ optional($selCategory)->id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-category" value="{{ optional($selCategory)->id }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Subcategoría</label>
                    <select id="sel-subcategory" onchange="cascadeSublevel()"
                        {{ $selCategory ? '' : 'disabled' }}
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50">
                        <option value="">— Seleccionar —</option>
                        @foreach($subcategories as $sub)
                        @if(!$selCategory || $sub->parent_id == optional($selCategory)->id)
                        <option value="{{ $sub->id }}" data-parent="{{ $sub->parent_id }}"
                            {{ optional($selSubcategory)->id == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-subcategory" value="{{ optional($selSubcategory)->id }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">1er Nivel</label>
                    <select id="sel-sublevel" onchange="cascadeSecondlevel()"
                        {{ $selSubcategory ? '' : 'disabled' }}
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50">
                        <option value="">— Seleccionar —</option>
                        @foreach($sublevels as $lvl)
                        @if(!$selSubcategory || $lvl->parent_id == optional($selSubcategory)->id)
                        <option value="{{ $lvl->id }}" data-parent="{{ $lvl->parent_id }}"
                            {{ optional($selSublevel)->id == $lvl->id ? 'selected' : '' }}>{{ $lvl->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-sublevel" value="{{ optional($selSublevel)->id }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">2do Nivel</label>
                    <select id="sel-secondlevel" onchange="cascadeThirdlevel()"
                        {{ $selSublevel ? '' : 'disabled' }}
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50">
                        <option value="">— Seleccionar —</option>
                        @foreach($secondlevels as $sec)
                        @if(!$selSublevel || $sec->parent_id == optional($selSublevel)->id)
                        <option value="{{ $sec->id }}" data-parent="{{ $sec->parent_id }}"
                            {{ optional($selSecondlevel)->id == $sec->id ? 'selected' : '' }}>{{ $sec->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-secondlevel" value="{{ optional($selSecondlevel)->id }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">3er Nivel</label>
                    <select id="sel-thirdlevel"
                        {{ $selSecondlevel ? '' : 'disabled' }}
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all disabled:opacity-50">
                        <option value="">— Seleccionar —</option>
                        @foreach($thirdlevels as $thr)
                        @if(!$selSecondlevel || $thr->parent_id == optional($selSecondlevel)->id)
                        <option value="{{ $thr->id }}" data-parent="{{ $thr->parent_id }}"
                            {{ optional($selThirdlevel)->id == $thr->id ? 'selected' : '' }}>{{ $thr->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="hidden" name="categories[]" id="hid-thirdlevel" value="{{ optional($selThirdlevel)->id }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Etiqueta</label>
                    <select name="tag_id"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="">— Sin etiqueta —</option>
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ old('tag_id', $photo->tag_id) == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tipo de fecha</label>
                    <select name="year_type" id="year_type" onchange="toggleYearFields()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="exact" {{ old('year_type', $photo->year_type ?? 'exact') === 'exact' ? 'selected' : '' }}>Año exacto</option>
                        <option value="range" {{ old('year_type', $photo->year_type) === 'range'             ? 'selected' : '' }}>Rango de años</option>
                    </select>
                </div>

                {{-- Año exacto --}}
                <div id="field-year-exact">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Año de la fotografía</label>
                    <input type="number" name="year" value="{{ old('year', $photo->year) }}" min="1800" max="{{ date('Y') }}" placeholder="Ej. 1970"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                {{-- Rango de años --}}
                <div id="field-year-range" class="md:col-span-2" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Rango de años</label>
                    <div class="flex items-center gap-3">
                        <input type="number" name="year_from" value="{{ old('year_from', $photo->year_from) }}" min="1800" max="{{ date('Y') }}" placeholder="Desde (Ej. 1920)"
                            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <span class="text-slate-400 dark:text-slate-500 font-medium shrink-0">—</span>
                        <input type="number" name="year_to" value="{{ old('year_to', $photo->year_to) }}" min="1800" max="{{ date('Y') }}" placeholder="Hasta (Ej. 1940)"
                            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Ubicación</label>
                    <input type="text" name="location" value="{{ old('location', $photo->location) }}" placeholder="Ej. Huaraz, Áncash"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Archivo o proveedor de la foto</label>
                    <input type="text" name="provider" value="{{ old('provider', $photo->provider) }}" placeholder="Institución o persona que provee la fotografía"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>


                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tipo de acceso <span class="text-red-500">*</span></label>
                    <select name="source_type" id="source_type" onchange="toggleSourceFields()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="none"     @selected(old('source_type', $photo->source_type) === 'none')>Sin acceso</option>
                        <option value="local"    @selected(old('source_type', $photo->source_type) === 'local')>Archivo local</option>
                        <option value="external" @selected(old('source_type', $photo->source_type) === 'external')>URL externa</option>
                    </select>
                </div>

                <div id="field-external" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">URL externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url', $photo->external_url) }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Descripción</label>
                    <textarea name="description" rows="3" placeholder="Lugar, persona o acontecimiento que muestra la fotografía..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ old('description', $photo->description) }}</textarea>
                </div>

                <div class="md:col-span-3" id="field-image" style="display:none">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Imagen</label>
                    @if($photo->full_image_path)
                    <div class="flex items-center gap-3 mb-3 p-3 bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 rounded-lg">
                        <i data-lucide="image" class="w-4 h-4 text-brand-500 shrink-0"></i>
                        <p class="text-xs font-semibold text-brand-700 dark:text-brand-300">Archivo actual cargado · sube una nueva imagen para reemplazar</p>
                    </div>
                    @endif
                    <input type="file" name="image_file" accept="image/*"
                        class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                </div>

            </div>
        </div>

        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.photos') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar cambios</button>
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
document.addEventListener('mousedown', function(e) {
    const inDropdown = e.target.closest('.tag-dropdown');
    const inSearchInput = e.target.tagName === 'INPUT' && e.target.id && e.target.id.startsWith('search-');
    if (!inDropdown && !inSearchInput) document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
});

function cascadeSubcategory() {
    const catId  = document.getElementById('sel-category').value;
    const selSub = document.getElementById('sel-subcategory');
    const selLvl = document.getElementById('sel-sublevel');
    const selSec = document.getElementById('sel-secondlevel');
    document.getElementById('hid-category').value     = catId;
    document.getElementById('hid-subcategory').value  = '';
    document.getElementById('hid-sublevel').value     = '';
    document.getElementById('hid-secondlevel').value  = '';
    selSub.innerHTML = '<option value="">— Seleccionar —</option>';
    selSub.disabled  = !catId;
    selLvl.innerHTML = '<option value="">— Primero elige subcategoría —</option>';
    selLvl.disabled  = true;
    selSec.innerHTML = '<option value="">— Primero elige 1er nivel —</option>';
    selSec.disabled  = true;
    if (!catId) return;
    document.querySelectorAll('#sel-subcategory-all option').forEach(opt => {
        if (opt.dataset.parent == catId) selSub.appendChild(opt.cloneNode(true));
    });
    if (selSub.options.length <= 1) { selSub.innerHTML = '<option value="">— Sin subcategorías —</option>'; selSub.disabled = true; }
}

function cascadeSublevel() {
    const subId  = document.getElementById('sel-subcategory').value;
    const selLvl = document.getElementById('sel-sublevel');
    const selSec = document.getElementById('sel-secondlevel');
    document.getElementById('hid-subcategory').value = subId;
    document.getElementById('hid-sublevel').value    = '';
    document.getElementById('hid-secondlevel').value = '';
    selLvl.innerHTML = '<option value="">— Seleccionar —</option>';
    selLvl.disabled  = !subId;
    selSec.innerHTML = '<option value="">— Primero elige 1er nivel —</option>';
    selSec.disabled  = true;
    if (!subId) return;
    document.querySelectorAll('#sel-sublevel-all option').forEach(opt => {
        if (opt.dataset.parent == subId) selLvl.appendChild(opt.cloneNode(true));
    });
    if (selLvl.options.length <= 1) { selLvl.innerHTML = '<option value="">— Sin 1er niveles —</option>'; selLvl.disabled = true; }
}

function cascadeSecondlevel() {
    const lvlId  = document.getElementById('sel-sublevel').value;
    const selSec = document.getElementById('sel-secondlevel');
    const selThr = document.getElementById('sel-thirdlevel');
    document.getElementById('hid-sublevel').value    = lvlId;
    document.getElementById('hid-secondlevel').value = '';
    document.getElementById('hid-thirdlevel').value  = '';
    selSec.innerHTML = '<option value="">— Seleccionar —</option>';
    selSec.disabled  = !lvlId;
    selThr.innerHTML = '<option value="">— Primero elige 2do nivel —</option>';
    selThr.disabled  = true;
    if (!lvlId) return;
    document.querySelectorAll('#sel-secondlevel-all option').forEach(opt => {
        if (opt.dataset.parent == lvlId) selSec.appendChild(opt.cloneNode(true));
    });
    if (selSec.options.length <= 1) { selSec.innerHTML = '<option value="">— Sin 2do niveles —</option>'; selSec.disabled = true; }
}

function cascadeThirdlevel() {
    const secId  = document.getElementById('sel-secondlevel').value;
    const selThr = document.getElementById('sel-thirdlevel');
    document.getElementById('hid-secondlevel').value = secId;
    document.getElementById('hid-thirdlevel').value  = '';
    selThr.innerHTML = '<option value="">— Seleccionar —</option>';
    selThr.disabled  = !secId;
    if (!secId) return;
    document.querySelectorAll('#sel-thirdlevel-all option').forEach(opt => {
        if (opt.dataset.parent == secId) selThr.appendChild(opt.cloneNode(true));
    });
    if (selThr.options.length <= 1) { selThr.innerHTML = '<option value="">— Sin 3er niveles —</option>'; selThr.disabled = true; }
}

document.getElementById('sel-thirdlevel').addEventListener('change', function() {
    document.getElementById('hid-thirdlevel').value = this.value;
});

function toggleYearFields() {
    const type = document.getElementById('year_type').value;
    document.getElementById('field-year-exact').style.display = type === 'exact' ? '' : 'none';
    document.getElementById('field-year-range').style.display = type === 'range' ? '' : 'none';
}
toggleYearFields();

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
<select id="sel-secondlevel-all" class="hidden">
    @foreach($secondlevels as $sec)
    <option value="{{ $sec->id }}" data-parent="{{ $sec->parent_id }}">{{ $sec->name }}</option>
    @endforeach
</select>
<select id="sel-thirdlevel-all" class="hidden">
    @foreach($thirdlevels as $thr)
    <option value="{{ $thr->id }}" data-parent="{{ $thr->parent_id }}">{{ $thr->name }}</option>
    @endforeach
</select>
@endsection
