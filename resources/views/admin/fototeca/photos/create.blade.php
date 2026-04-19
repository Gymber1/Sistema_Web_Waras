@extends('layouts.admin')

@section('section', 'Fototeca > Fotografías > Nueva')

@section('content')
<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.fototeca.photos') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Agregar nueva</h1>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase tracking-wider">FOTOGRAFÍA</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Completa los campos y guarda para registrar la nueva fotografía.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.fototeca.photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Fotógrafos --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Fotógrafos</label>
                    <div id="chips-photographers" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-photographers" placeholder="Buscar y agregar fotógrafo..."
                            oninput="filterDropdown(this,'dropdown-photographers')" onfocus="showDropdown('dropdown-photographers')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50">
                        <div id="dropdown-photographers" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($photographers as $ph)
                            <button type="button" data-id="{{ $ph->id }}" data-name="{{ $ph->full_name }}"
                                onclick="addChip(this,'chips-photographers','photographers')"
                                class="w-full text-left px-4 py-2.5 hover:bg-blue-50 text-sm border-b border-slate-50 last:border-0">{{ $ph->full_name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Categorías --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Categorías</label>
                    <div id="chips-categories" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-categories" placeholder="Buscar y agregar categoría..."
                            oninput="filterDropdown(this,'dropdown-categories')" onfocus="showDropdown('dropdown-categories')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50">
                        <div id="dropdown-categories" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($categories as $cat)
                            <button type="button" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}"
                                onclick="addChip(this,'chips-categories','categories')"
                                class="w-full text-left px-4 py-2.5 hover:bg-blue-50 text-sm border-b border-slate-50 last:border-0"
                                style="padding-left: {{ 16 + $cat->depth * 16 }}px">
                                {{ $cat->depth > 0 ? str_repeat('— ', $cat->depth) : '' }}{{ $cat->name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Año --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Año de la fotografía</label>
                    <input type="number" name="year" value="{{ old('year') }}" min="1800" max="{{ date('Y') }}" placeholder="Ej. 1970"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Ubicación --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Ubicación</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Ej. Huaraz, Áncash"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Proveedor --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Archivo o proveedor de la foto</label>
                    <input type="text" name="provider" value="{{ old('provider') }}" placeholder="Institución o persona que provee la fotografía"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Resolución --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Resolución</label>
                    <input type="text" name="resolution" value="{{ old('resolution') }}" placeholder="Ej. 4000x3000"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Formato --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Formato</label>
                    <input type="text" name="format" value="{{ old('format') }}" placeholder="JPG, PNG, RAW..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Tipo de acceso --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Tipo de acceso <span class="text-red-500">*</span></label>
                    <select name="source_type" id="source_type" onchange="toggleSourceFields()"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="none" @selected(old('source_type','none')==='none')>Sin acceso</option>
                        <option value="local" @selected(old('source_type')==='local')>Archivo local</option>
                        <option value="external" @selected(old('source_type')==='external')>URL externa</option>
                    </select>
                </div>

                {{-- URL externa --}}
                <div id="field-external" style="display:none">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">URL externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url') }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Descripción</label>
                    <textarea name="description" rows="3" placeholder="Lugar, persona o acontecimiento que muestra la fotografía..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y">{{ old('description') }}</textarea>
                </div>

                {{-- Imagen --}}
                <div class="md:col-span-2" id="field-image" style="display:none">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Imagen</label>
                    <input type="file" name="image_file" accept="image/*"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 file:font-semibold hover:file:bg-blue-200">
                </div>

            </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.photos') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-200 transition-all">Guardar fotografía</button>
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
    dropdown.querySelectorAll('div').forEach(div => { div.style.display = ''; });
}
function addChip(btn, chipsId, field) {
    const id = btn.dataset.id, name = btn.dataset.name;
    const chips = document.getElementById(chipsId);
    if (chips.querySelector(`input[value="${id}"]`)) return;
    const chip = document.createElement('span');
    chip.className = 'chip flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full';
    chip.innerHTML = `${name} <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-base leading-none">×</button><input type="hidden" name="${field}[]" value="${id}">`;
    chips.appendChild(chip);
    const s = document.getElementById('search-' + field); if (s) s.value = '';
    document.getElementById('dropdown-' + field).classList.add('hidden');
}
function toggleSourceFields() {
    const val = document.getElementById('source_type').value;
    document.getElementById('field-external').style.display = val === 'external' ? '' : 'none';
    document.getElementById('field-image').style.display = val === 'local' ? '' : 'none';
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
});
toggleSourceFields();
</script>
@endsection
