@extends('layouts.admin')

@section('title', 'Editar Aportantes — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[960px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Editar Aportantes</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Gestiona quiénes aparecen en la sección Aportantes del portal principal.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.web-config.aportantes.update') }}" enctype="multipart/form-data" id="aportantesForm">
        @csrf

        {{-- ── CATEGORÍAS ── --}}
        <div id="categoriasContainer">
        @foreach($aportantes['categorias'] as $ci => $cat)
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 mb-5 categoria-block" data-ci="{{ $ci }}">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                    <i data-lucide="layers" class="w-5 h-5 text-brand-500"></i>
                    Categoría {{ $ci + 1 }}
                </h3>
                <button type="button" onclick="removeCategoria(this)"
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    Eliminar categoría
                </button>
            </div>
            <div class="grid grid-cols-1 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título de la categoría</label>
                    <input type="text" name="categorias[{{ $ci }}][titulo]" value="{{ $cat['titulo'] }}"
                           class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Icono de categoría</label>
                    @php $isCustomIcon = $cat['icono'] && !in_array($cat['icono'], ['building','heart','landmark','star','users','book','globe','leaf','award','briefcase']); @endphp
                    @if($isCustomIcon)
                    <div class="flex items-center gap-3 mb-2 p-2 bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-lg">
                        <img src="{{ $cat['icono'] }}" alt="icono actual" class="w-10 h-10 object-contain rounded">
                        <span class="text-xs text-slate-500 dark:text-slate-400">Icono actual</span>
                    </div>
                    @endif
                    <input type="hidden" name="categorias[{{ $ci }}][icono]" value="{{ $cat['icono'] }}" class="icono-hidden">
                    <div class="mb-2">
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Elegir predeterminado</p>
                        <select onchange="setIconoFromSelect(this)"
                                class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all icono-select">
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
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">O subir imagen personalizada</p>
                        <input type="file" name="categorias[{{ $ci }}][icono_file]" accept="image/*"
                               onchange="setIconoFromFile(this)"
                               class="text-sm text-slate-500 dark:text-slate-400
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                      file:text-xs file:font-medium file:bg-brand-50 dark:file:bg-brand-500/10 file:text-brand-700 dark:file:text-brand-400
                                      hover:file:bg-brand-100 dark:hover:file:bg-brand-500/20 icono-file">
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Si subes una imagen, se usará en lugar del icono predeterminado.</p>
                    </div>
                </div>
            </div>

            <div class="items-container space-y-4">
            @foreach($cat['items'] as $ii => $item)
            <div class="item-block bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl p-5">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aportante {{ $ii + 1 }}</span>
                    <button type="button" onclick="removeItem(this)"
                            class="text-xs text-red-400 dark:text-red-500 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors">✕ Quitar</button>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Nombre</label>
                        <input type="text" name="categorias[{{ $ci }}][items][{{ $ii }}][nombre]" value="{{ $item['nombre'] }}"
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Foto actual</label>
                        <div class="flex items-center gap-3">
                            @if($item['foto'])
                                <img src="{{ $item['foto'] }}" alt="foto"
                                     class="w-12 h-12 object-cover rounded-lg border border-slate-200 dark:border-slate-700 flex-shrink-0">
                            @endif
                            <input type="hidden" name="categorias[{{ $ci }}][items][{{ $ii }}][foto]" value="{{ $item['foto'] }}">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Subir nueva foto <span class="font-normal text-slate-400 dark:text-slate-500">(deja vacío para mantener la actual)</span></label>
                        <input type="file" name="categorias[{{ $ci }}][items][{{ $ii }}][foto_file]" accept="image/*"
                               class="text-sm text-slate-500 dark:text-slate-400
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                      file:text-xs file:font-medium file:bg-brand-50 dark:file:bg-brand-500/10 file:text-brand-700 dark:file:text-brand-400
                                      hover:file:bg-brand-100 dark:hover:file:bg-brand-500/20">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Descripción</label>
                        <textarea name="categorias[{{ $ci }}][items][{{ $ii }}][descripcion]" rows="2"
                                  class="w-full bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 resize-none transition-all">{{ $item['descripcion'] }}</textarea>
                    </div>
                </div>
            </div>
            @endforeach
            </div>

            <button type="button" onclick="addItem(this)"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-brand-600 dark:text-brand-400 hover:text-brand-800 dark:hover:text-brand-300 border border-dashed border-brand-300 dark:border-brand-500/40 rounded-xl px-4 py-2.5 w-full justify-center hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Agregar aportante a esta categoría
            </button>
        </div>
        @endforeach
        </div>

        <button type="button" onclick="addCategoria()"
                class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 border border-dashed border-slate-300 dark:border-slate-600 rounded-xl px-6 py-4 w-full justify-center hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Agregar nueva categoría
        </button>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.web-config.index') }}"
               class="px-5 py-2.5 bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border text-slate-700 dark:text-slate-300 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm px-6 py-2.5 rounded-lg transition-colors shadow-lg shadow-brand-500/30">
                <i data-lucide="check" class="w-4 h-4"></i>
                Guardar cambios
            </button>
        </div>
    </form>
</div>

<script>
let catCount = {{ count($aportantes['categorias']) }};

function setIconoFromSelect(sel) {
    const block = sel.closest('.categoria-block');
    const hidden = block.querySelector('.icono-hidden');
    const fileInput = block.querySelector('.icono-file');
    if (sel.value) {
        hidden.value = sel.value;
        if (fileInput) fileInput.value = '';
    }
}

function setIconoFromFile(fileInput) {
    const block = fileInput.closest('.categoria-block');
    const hidden = block.querySelector('.icono-hidden');
    const selectEl = block.querySelector('.icono-select');
    if (fileInput.files && fileInput.files[0]) {
        hidden.value = '__file__';
        if (selectEl) selectEl.value = '';
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
    const container = btn.previousElementSibling;
    const ci = btn.closest('.categoria-block').dataset.ci;
    const ii = container.querySelectorAll('.item-block').length;
    const html = `
    <div class="item-block bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl p-5">
        <div class="flex justify-between items-center mb-4">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aportante ${ii + 1}</span>
            <button type="button" onclick="removeItem(this)" class="text-xs text-red-400 hover:text-red-600 font-medium transition-colors">✕ Quitar</button>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Nombre</label>
                <input type="text" name="categorias[${ci}][items][${ii}][nombre]" value=""
                       class="w-full bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 text-slate-800 dark:text-white transition-all">
            </div>
            <div><input type="hidden" name="categorias[${ci}][items][${ii}][foto]" value=""></div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Foto</label>
                <input type="file" name="categorias[${ci}][items][${ii}][foto_file]" accept="image/*"
                       class="text-sm text-slate-500 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Descripción</label>
                <textarea name="categorias[${ci}][items][${ii}][descripcion]" rows="2"
                          class="w-full bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 resize-none text-slate-800 dark:text-white transition-all"></textarea>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    renumberAll();
}

function addCategoria() {
    const ci = catCount++;
    const html = `
    <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 mb-5 categoria-block" data-ci="${ci}">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                <span class="w-5 h-5 text-brand-500">☰</span> Nueva Categoría
            </h3>
            <button type="button" onclick="removeCategoria(this)" class="inline-flex items-center gap-1.5 text-xs font-medium text-red-500 hover:text-red-700 transition-colors">
                🗑 Eliminar categoría
            </button>
        </div>
        <div class="grid grid-cols-1 gap-5 mb-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Título de la categoría</label>
                <input type="text" name="categorias[${ci}][titulo]" value=""
                       class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 text-slate-800 dark:text-white transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Icono de categoría</label>
                <input type="hidden" name="categorias[${ci}][icono]" value="building" class="icono-hidden">
                <select onchange="setIconoFromSelect(this)"
                        class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 text-slate-800 dark:text-white transition-all icono-select">
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
                <input type="file" name="categorias[${ci}][icono_file]" accept="image/*"
                       onchange="setIconoFromFile(this)"
                       class="mt-2 text-sm text-slate-500 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 icono-file">
            </div>
        </div>
        <div class="items-container space-y-4"></div>
        <button type="button" onclick="addItem(this)"
                class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-brand-600 dark:text-brand-400 border border-dashed border-brand-300 dark:border-brand-500/40 rounded-xl px-4 py-2.5 w-full justify-center hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-colors">
            + Agregar aportante a esta categoría
        </button>
    </div>`;
    document.getElementById('categoriasContainer').insertAdjacentHTML('beforeend', html);
}

function renumberAll() {
    document.querySelectorAll('.categoria-block').forEach((catEl, ci) => {
        catEl.dataset.ci = ci;
        catEl.querySelectorAll('[name]').forEach(inp => {
            inp.name = inp.name.replace(/categorias\[\d+\]\[items\]\[(\d+)\]/, (_, ii) => `categorias[${ci}][items][${ii}]`);
            if (!inp.name.includes('[items]')) {
                inp.name = inp.name.replace(/^categorias\[\d+\]/, `categorias[${ci}]`);
            }
        });
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
