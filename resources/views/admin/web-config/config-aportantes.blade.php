@extends('layouts.admin')

@section('title', 'Editar Aportantes — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="p-8 max-w-5xl mx-auto">

    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.web-config.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Editar Aportantes</h1>
            <p class="text-slate-500 text-sm mt-1">Gestiona quiénes aparecen en la sección Aportantes del portal principal.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.web-config.aportantes.update') }}" enctype="multipart/form-data" id="aportantesForm">
        @csrf

        {{-- ── DIRECTOR ── --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 mb-8">
            <h2 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Director
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nombre</label>
                    <input type="text" name="director_nombre" value="{{ $aportantes['director']['nombre'] }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Cargo</label>
                    <input type="text" name="director_cargo" value="{{ $aportantes['director']['cargo'] }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Biografía</label>
                    <textarea name="director_bio" rows="3"
                              class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none">{{ $aportantes['director']['bio'] }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Foto del director</label>
                    <div class="flex items-center gap-4">
                        @if($aportantes['director']['foto'])
                            <img src="{{ $aportantes['director']['foto'] }}" alt="Director"
                                 class="w-16 h-16 rounded-full object-cover border border-slate-200">
                        @endif
                        <input type="file" name="director_foto" accept="image/*"
                               class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                        <input type="hidden" name="director_foto_actual" value="{{ $aportantes['director']['foto'] }}">
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Deja vacío para mantener la foto actual. Acepta JPG, PNG, WebP.</p>
                </div>
            </div>
        </div>

        {{-- ── CATEGORÍAS Y APORTANTES ── --}}
        <div id="categoriasContainer">
        @foreach($aportantes['categorias'] as $ci => $cat)
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 mb-6 categoria-block" data-ci="{{ $ci }}">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Categoría {{ $ci + 1 }}
                </h2>
                <button type="button" onclick="removeCategoria(this)"
                        class="text-xs font-bold text-red-500 hover:text-red-700 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Eliminar categoría
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Título de la categoría</label>
                    <input type="text" name="categorias[{{ $ci }}][titulo]" value="{{ $cat['titulo'] }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Icono de categoría</label>
                    {{-- Mostrar icono actual si es imagen personalizada --}}
                    @php $isCustomIcon = $cat['icono'] && !in_array($cat['icono'], ['building','heart','landmark','star','users','book','globe','leaf','award','briefcase']); @endphp
                    @if($isCustomIcon)
                    <div class="flex items-center gap-3 mb-2 p-2 bg-slate-50 border border-slate-200 rounded-lg">
                        <img src="{{ $cat['icono'] }}" alt="icono actual" class="w-10 h-10 object-contain rounded">
                        <span class="text-xs text-slate-500">Icono actual (imagen personalizada)</span>
                    </div>
                    @endif
                    <input type="hidden" name="categorias[{{ $ci }}][icono]" value="{{ $cat['icono'] }}" class="icono-hidden">
                    {{-- Opción 1: predeterminado --}}
                    <div class="mb-2">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Elegir predeterminado</p>
                        <select onchange="setIconoFromSelect(this)"
                                class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 icono-select">
                            <option value="">— mantener actual —</option>
                            <option value="building"  {{ $cat['icono'] === 'building'  ? 'selected' : '' }}>🏠 Empresa / Edificio</option>
                            <option value="heart"     {{ $cat['icono'] === 'heart'     ? 'selected' : '' }}>❤️ Donante / Corazón</option>
                            <option value="landmark"  {{ $cat['icono'] === 'landmark'  ? 'selected' : '' }}>🏛️ Institución / Monumento</option>
                            <option value="star"      {{ $cat['icono'] === 'star'      ? 'selected' : '' }}>⭐ Destacado / Estrella</option>
                            <option value="users"     {{ $cat['icono'] === 'users'     ? 'selected' : '' }}>👥 Comunidad / Personas</option>
                            <option value="book"      {{ $cat['icono'] === 'book'      ? 'selected' : '' }}>📖 Libros / Conocimiento</option>
                            <option value="globe"     {{ $cat['icono'] === 'globe'     ? 'selected' : '' }}>🌐 Internacional / Global</option>
                            <option value="leaf"      {{ $cat['icono'] === 'leaf'      ? 'selected' : '' }}>🌿 Ambiental / Naturaleza</option>
                            <option value="award"     {{ $cat['icono'] === 'award'     ? 'selected' : '' }}>🏆 Premio / Reconocimiento</option>
                            <option value="briefcase" {{ $cat['icono'] === 'briefcase' ? 'selected' : '' }}>💼 Trabajo / Profesional</option>
                        </select>
                    </div>
                    {{-- Opción 2: imagen personalizada --}}
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">O subir imagen personalizada</p>
                        <input type="file" name="categorias[{{ $ci }}][icono_file]" accept="image/*"
                               onchange="setIconoFromFile(this)"
                               class="text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 icono-file">
                        <p class="text-xs text-slate-400 mt-1">Si subes una imagen, se usará en lugar del icono predeterminado.</p>
                    </div>
                </div>
            </div>

            {{-- Items de esta categoría --}}
            <div class="items-container space-y-4">
            @foreach($cat['items'] as $ii => $item)
            <div class="item-block border border-slate-100 rounded-xl p-5 bg-slate-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aportante {{ $ii + 1 }}</span>
                    <button type="button" onclick="removeItem(this)"
                            class="text-xs text-red-400 hover:text-red-600 font-bold">✕ Quitar</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Nombre</label>
                        <input type="text" name="categorias[{{ $ci }}][items][{{ $ii }}][nombre]" value="{{ $item['nombre'] }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Foto actual</label>
                        <div class="flex items-center gap-3">
                            @if($item['foto'])
                                <img src="{{ $item['foto'] }}" alt="foto"
                                     class="w-12 h-12 object-cover rounded-lg border border-slate-200 flex-shrink-0">
                            @endif
                            <input type="hidden" name="categorias[{{ $ci }}][items][{{ $ii }}][foto]" value="{{ $item['foto'] }}">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-1">Subir nueva foto <span class="font-normal text-slate-400">(deja vacío para mantener la actual)</span></label>
                        <input type="file" name="categorias[{{ $ci }}][items][{{ $ii }}][foto_file]" accept="image/*"
                               class="text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-1">Descripción</label>
                        <textarea name="categorias[{{ $ci }}][items][{{ $ii }}][descripcion]" rows="2"
                                  class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none">{{ $item['descripcion'] }}</textarea>
                    </div>
                </div>
            </div>
            @endforeach
            </div>

            <button type="button" onclick="addItem(this)"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 border border-dashed border-indigo-300 rounded-xl px-4 py-2.5 w-full justify-center hover:bg-indigo-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Agregar aportante a esta categoría
            </button>
        </div>
        @endforeach
        </div>

        <button type="button" onclick="addCategoria()"
                class="mb-8 inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-slate-800 border border-dashed border-slate-300 rounded-2xl px-6 py-4 w-full justify-center hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar nueva categoría
        </button>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.web-config.index') }}"
               class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm px-8 py-3 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Guardar cambios
            </button>
        </div>
    </form>
</div>

<script>
// Contadores para índices únicos
let catCount = {{ count($aportantes['categorias']) }};

// Cuando se elige un icono predeterminado del select, limpia el file y actualiza el hidden
function setIconoFromSelect(sel) {
    const block = sel.closest('.categoria-block');
    const hidden = block.querySelector('.icono-hidden');
    const fileInput = block.querySelector('.icono-file');
    if (sel.value) {
        hidden.value = sel.value;
        if (fileInput) fileInput.value = ''; // limpia el file si se elige predeterminado
    }
}

// Cuando se sube un archivo, marca el hidden con '__file__' para que el controlador sepa usar el upload
function setIconoFromFile(fileInput) {
    const block = fileInput.closest('.categoria-block');
    const hidden = block.querySelector('.icono-hidden');
    const selectEl = block.querySelector('.icono-select');
    if (fileInput.files && fileInput.files[0]) {
        hidden.value = '__file__'; // señal para el controlador
        if (selectEl) selectEl.value = ''; // deselecciona el predeterminado
    }
}

function removeCategoria(btn) {
    if (!confirm('¿Eliminar esta categoría completa?')) return;
    btn.closest('.categoria-block').remove();
    renumberAll();
}

function removeItem(btn) {
    btn.closest('.item-block').remove();
    renumberAll();
}

function addItem(btn) {
    const container = btn.previousElementSibling; // .items-container
    const ci = btn.closest('.categoria-block').dataset.ci;
    const ii = container.querySelectorAll('.item-block').length;
    const html = `
    <div class="item-block border border-slate-100 rounded-xl p-5 bg-slate-50">
        <div class="flex justify-between items-center mb-4">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aportante ${ii + 1}</span>
            <button type="button" onclick="removeItem(this)" class="text-xs text-red-400 hover:text-red-600 font-bold">✕ Quitar</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Nombre</label>
                <input type="text" name="categorias[${ci}][items][${ii}][nombre]" value=""
                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
            <div>
                <input type="hidden" name="categorias[${ci}][items][${ii}][foto]" value="">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-1">Foto <span class="font-normal text-slate-400">(sube una imagen)</span></label>
                <input type="file" name="categorias[${ci}][items][${ii}][foto_file]" accept="image/*"
                       class="text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-1">Descripción</label>
                <textarea name="categorias[${ci}][items][${ii}][descripcion]" rows="2"
                          class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"></textarea>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    renumberAll();
}

function addCategoria() {
    const ci = catCount++;
    const html = `
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 mb-6 categoria-block" data-ci="${ci}">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Nueva Categoría
            </h2>
            <button type="button" onclick="removeCategoria(this)" class="text-xs font-bold text-red-500 hover:text-red-700 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Eliminar categoría
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Título de la categoría</label>
                <input type="text" name="categorias[${ci}][titulo]" value=""
                       class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Icono de categoría</label>
                <input type="hidden" name="categorias[${ci}][icono]" value="building" class="icono-hidden">
                <div class="mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Elegir predeterminado</p>
                    <select onchange="setIconoFromSelect(this)"
                            class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 icono-select">
                        <option value="building" selected>🏠 Empresa / Edificio</option>
                        <option value="heart">❤️ Donante / Corazón</option>
                        <option value="landmark">🏛️ Institución / Monumento</option>
                        <option value="star">⭐ Destacado / Estrella</option>
                        <option value="users">👥 Comunidad / Personas</option>
                        <option value="book">📖 Libros / Conocimiento</option>
                        <option value="globe">🌐 Internacional / Global</option>
                        <option value="leaf">🌿 Ambiental / Naturaleza</option>
                        <option value="award">🏆 Premio / Reconocimiento</option>
                        <option value="briefcase">💼 Trabajo / Profesional</option>
                    </select>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">O subir imagen personalizada</p>
                    <input type="file" name="categorias[${ci}][icono_file]" accept="image/*"
                           onchange="setIconoFromFile(this)"
                           class="text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 icono-file">
                    <p class="text-xs text-slate-400 mt-1">Si subes una imagen, se usará en lugar del icono predeterminado.</p>
                </div>
            </div>
        </div>
        <div class="items-container space-y-4"></div>
        <button type="button" onclick="addItem(this)"
                class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 border border-dashed border-indigo-300 rounded-xl px-4 py-2.5 w-full justify-center hover:bg-indigo-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar aportante a esta categoría
        </button>
    </div>`;
    document.getElementById('categoriasContainer').insertAdjacentHTML('beforeend', html);
}

function renumberAll() {
    document.querySelectorAll('.categoria-block').forEach((catEl, ci) => {
        catEl.dataset.ci = ci;
        // Re-index all inputs inside this category block
        catEl.querySelectorAll('[name]').forEach(inp => {
            // Item-level fields (nombre, foto, foto_file, descripcion)
            inp.name = inp.name.replace(/categorias\[\d+\]\[items\]\[(\d+)\]/, (_, ii) => `categorias[${ci}][items][${ii}]`);
            // Category-level fields (titulo, icono) — only replace category index
            if (!inp.name.includes('[items]')) {
                inp.name = inp.name.replace(/^categorias\[\d+\]/, `categorias[${ci}]`);
            }
        });
        // Re-number item labels
        catEl.querySelectorAll('.item-block').forEach((itemEl, ii) => {
            itemEl.querySelectorAll('[name]').forEach(inp => {
                inp.name = inp.name.replace(/categorias\[(\d+)\]\[items\]\[\d+\]/, `categorias[${ci}][items][${ii}]`);
            });
            const label = itemEl.querySelector('span');
            if (label) label.textContent = `Aportante ${ii + 1}`;
        });
    });
}
</script>
@endsection
