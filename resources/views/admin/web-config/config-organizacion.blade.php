@extends('layouts.admin')

@section('title', 'Nuestra Organización — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[900px] mx-auto px-4">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Nuestra Organización</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Edita todo el contenido de la sección "Nuestra Organización" del portal.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    @php
        $inputCls = 'w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all';
        $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5';
        $cardCls  = 'bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden';
        $headCls  = 'flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20';
    @endphp

    <form action="{{ route('admin.web-config.organizacion.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- ── Encabezado (Hero) ── --}}
        <div class="{{ $cardCls }}">
            <div class="{{ $headCls }}">
                <div class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-500/10 flex items-center justify-center flex-shrink-0"><i data-lucide="heading" class="w-4 h-4 text-teal-500"></i></div>
                <div><p class="font-semibold text-slate-800 dark:text-white text-sm">Encabezado</p><p class="text-xs text-slate-400 dark:text-slate-500">El banner superior de la sección.</p></div>
            </div>
            <div class="p-6 space-y-4">
                <div><label class="{{ $labelCls }}">Título</label><input type="text" name="hero_title" value="{{ $org['hero_title'] }}" class="{{ $inputCls }}"></div>
                <div><label class="{{ $labelCls }}">Subtítulo</label><textarea name="hero_subtitle" rows="2" class="{{ $inputCls }} resize-y">{{ $org['hero_subtitle'] }}</textarea></div>
            </div>
        </div>

        {{-- ── Quiénes Somos ── --}}
        <div class="{{ $cardCls }}">
            <div class="{{ $headCls }}">
                <div class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-500/10 flex items-center justify-center flex-shrink-0"><i data-lucide="info" class="w-4 h-4 text-teal-500"></i></div>
                <div><p class="font-semibold text-slate-800 dark:text-white text-sm">Quiénes Somos</p><p class="text-xs text-slate-400 dark:text-slate-500">Texto, imagen de fundadores y párrafos. Puedes usar &lt;strong&gt; para resaltar.</p></div>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="{{ $labelCls }}">Eyebrow</label><input type="text" name="quienes_eyebrow" value="{{ $org['quienes_eyebrow'] }}" class="{{ $inputCls }}"></div>
                    <div><label class="{{ $labelCls }}">Título</label><input type="text" name="quienes_title" value="{{ $org['quienes_title'] }}" class="{{ $inputCls }}"></div>
                    <div><label class="{{ $labelCls }}">Título (cursiva)</label><input type="text" name="quienes_title_em" value="{{ $org['quienes_title_em'] }}" class="{{ $inputCls }}"></div>
                </div>
                <div><label class="{{ $labelCls }}">Párrafo 1</label><textarea name="quienes_p1" rows="3" class="{{ $inputCls }} resize-y">{{ $org['quienes_p1'] }}</textarea></div>
                <div><label class="{{ $labelCls }}">Párrafo 2</label><textarea name="quienes_p2" rows="3" class="{{ $inputCls }} resize-y">{{ $org['quienes_p2'] }}</textarea></div>
                <div><label class="{{ $labelCls }}">Párrafo 3</label><textarea name="quienes_p3" rows="3" class="{{ $inputCls }} resize-y">{{ $org['quienes_p3'] }}</textarea></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                    <div><label class="{{ $labelCls }}">Etiqueta de la imagen</label><input type="text" name="quienes_img_label" value="{{ $org['quienes_img_label'] }}" class="{{ $inputCls }}"></div>
                    <div>
                        <label class="{{ $labelCls }}">Imagen (Fundadores)</label>
                        <div class="flex items-center gap-3">
                            <img src="{{ $org['quienes_img'] }}" class="w-16 h-16 rounded-lg object-cover border border-slate-200 dark:border-slate-700" onerror="this.style.display='none'">
                            <input type="file" name="quienes_img" accept="image/*" class="text-xs text-slate-600 dark:text-slate-300 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Finalidad + Objetivo General ── --}}
        <div class="{{ $cardCls }}">
            <div class="{{ $headCls }}">
                <div class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-500/10 flex items-center justify-center flex-shrink-0"><i data-lucide="target" class="w-4 h-4 text-teal-500"></i></div>
                <div><p class="font-semibold text-slate-800 dark:text-white text-sm">Finalidad y Objetivo General</p></div>
            </div>
            <div class="p-6 space-y-5">
                {{-- Finalidad --}}
                <div class="space-y-3 pb-5 border-b border-slate-100 dark:border-dark-border">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                        <div><label class="{{ $labelCls }}">Título Finalidad</label><input type="text" name="finalidad_title" value="{{ $org['finalidad_title'] }}" class="{{ $inputCls }}"></div>
                        <div>
                            <label class="{{ $labelCls }}">Ícono Finalidad</label>
                            <div class="flex items-center gap-3">
                                <img src="{{ $org['finalidad_img'] }}" class="w-12 h-12 object-contain border border-slate-200 dark:border-slate-700 rounded" onerror="this.style.display='none'">
                                <input type="file" name="finalidad_img" accept="image/*" class="text-xs text-slate-600 dark:text-slate-300 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold">
                            </div>
                        </div>
                    </div>
                    <div><label class="{{ $labelCls }}">Texto Finalidad</label><textarea name="finalidad_text" rows="3" class="{{ $inputCls }} resize-y">{{ $org['finalidad_text'] }}</textarea></div>
                </div>
                {{-- Objetivo General --}}
                <div class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                        <div><label class="{{ $labelCls }}">Título Objetivo General</label><input type="text" name="objetivo_title" value="{{ $org['objetivo_title'] }}" class="{{ $inputCls }}"></div>
                        <div>
                            <label class="{{ $labelCls }}">Ícono Objetivo</label>
                            <div class="flex items-center gap-3">
                                <img src="{{ $org['objetivo_img'] }}" class="w-12 h-12 object-contain border border-slate-200 dark:border-slate-700 rounded" onerror="this.style.display='none'">
                                <input type="file" name="objetivo_img" accept="image/*" class="text-xs text-slate-600 dark:text-slate-300 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="{{ $labelCls }}">Lista de objetivos</label>
                        <div class="org-list space-y-2" data-name="objetivo_items">
                            @foreach($org['objetivo_items'] as $item)
                            <div class="flex items-center gap-2 org-list-row">
                                <input type="text" name="objetivo_items[]" value="{{ $item }}" class="{{ $inputCls }}">
                                <button type="button" onclick="this.closest('.org-list-row').remove()" class="p-2 text-red-400 hover:text-red-600 shrink-0"><i data-lucide="x" class="w-4 h-4"></i></button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addOrgItem(this,'objetivo_items')" class="mt-2 text-xs text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1"><i data-lucide="plus" class="w-3 h-3"></i> Agregar objetivo</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Líneas de trabajo ── --}}
        <div class="{{ $cardCls }}">
            <div class="{{ $headCls }}">
                <div class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-500/10 flex items-center justify-center flex-shrink-0"><i data-lucide="list-checks" class="w-4 h-4 text-teal-500"></i></div>
                <div><p class="font-semibold text-slate-800 dark:text-white text-sm">Líneas de Trabajo y Beneficiarios</p></div>
            </div>
            <div class="p-6 space-y-4">
                <div><label class="{{ $labelCls }}">Título</label><input type="text" name="lineas_title" value="{{ $org['lineas_title'] }}" class="{{ $inputCls }}"></div>
                <div><label class="{{ $labelCls }}">Subtítulo</label><textarea name="lineas_subtitle" rows="2" class="{{ $inputCls }} resize-y">{{ $org['lineas_subtitle'] }}</textarea></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Objetivos específicos --}}
                    <div>
                        <label class="{{ $labelCls }}">Etiqueta columna izquierda</label>
                        <input type="text" name="objetivos_label" value="{{ $org['objetivos_label'] }}" class="{{ $inputCls }} mb-3">
                        <div class="org-list space-y-2" data-name="objetivos_items">
                            @foreach($org['objetivos_items'] as $item)
                            <div class="flex items-center gap-2 org-list-row">
                                <input type="text" name="objetivos_items[]" value="{{ $item }}" class="{{ $inputCls }}">
                                <button type="button" onclick="this.closest('.org-list-row').remove()" class="p-2 text-red-400 hover:text-red-600 shrink-0"><i data-lucide="x" class="w-4 h-4"></i></button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addOrgItem(this,'objetivos_items')" class="mt-2 text-xs text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1"><i data-lucide="plus" class="w-3 h-3"></i> Agregar</button>
                    </div>
                    {{-- Beneficiarios --}}
                    <div>
                        <label class="{{ $labelCls }}">Etiqueta columna derecha</label>
                        <input type="text" name="beneficiarios_label" value="{{ $org['beneficiarios_label'] }}" class="{{ $inputCls }} mb-3">
                        <div class="org-list space-y-2" data-name="beneficiarios_items">
                            @foreach($org['beneficiarios_items'] as $item)
                            <div class="flex items-center gap-2 org-list-row">
                                <input type="text" name="beneficiarios_items[]" value="{{ $item }}" class="{{ $inputCls }}">
                                <button type="button" onclick="this.closest('.org-list-row').remove()" class="p-2 text-red-400 hover:text-red-600 shrink-0"><i data-lucide="x" class="w-4 h-4"></i></button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addOrgItem(this,'beneficiarios_items')" class="mt-2 text-xs text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1"><i data-lucide="plus" class="w-3 h-3"></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Premio Nacional + Director ── --}}
        <div class="{{ $cardCls }}">
            <div class="{{ $headCls }}">
                <div class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-500/10 flex items-center justify-center flex-shrink-0"><i data-lucide="award" class="w-4 h-4 text-teal-500"></i></div>
                <div><p class="font-semibold text-slate-800 dark:text-white text-sm">Premio Nacional y Director</p></div>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><label class="{{ $labelCls }}">Título</label><input type="text" name="premio_title" value="{{ $org['premio_title'] }}" class="{{ $inputCls }}"></div>
                    <div><label class="{{ $labelCls }}">Eyebrow</label><input type="text" name="premio_eyebrow" value="{{ $org['premio_eyebrow'] }}" class="{{ $inputCls }}"></div>
                </div>
                <div><label class="{{ $labelCls }}">Texto del premio</label><textarea name="premio_text" rows="2" class="{{ $inputCls }} resize-y">{{ $org['premio_text'] }}</textarea></div>
                <div>
                    <label class="{{ $labelCls }}">Video de YouTube <span class="font-normal text-slate-400 text-xs">(URL embed, p. ej. https://www.youtube.com/embed/ID)</span></label>
                    <input type="text" name="premio_video" value="{{ $org['premio_video'] }}" placeholder="https://www.youtube.com/embed/..." class="{{ $inputCls }}">
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Déjalo vacío para ocultar el video.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><label class="{{ $labelCls }}">Etiqueta reconocimiento</label><input type="text" name="premio_rec_label" value="{{ $org['premio_rec_label'] }}" class="{{ $inputCls }}"></div>
                    <div><label class="{{ $labelCls }}">Ministerio / institución</label><input type="text" name="premio_ministerio" value="{{ $org['premio_ministerio'] }}" class="{{ $inputCls }}"></div>
                </div>

                <div class="pt-4 mt-2 border-t border-slate-100 dark:border-dark-border space-y-4">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Director del Proyecto</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="{{ $labelCls }}">Cargo</label><input type="text" name="director_label" value="{{ $org['director_label'] }}" class="{{ $inputCls }}"></div>
                        <div><label class="{{ $labelCls }}">Nombre</label><input type="text" name="director_name" value="{{ $org['director_name'] }}" class="{{ $inputCls }}"></div>
                    </div>
                    <div><label class="{{ $labelCls }}">Biografía</label><textarea name="director_bio" rows="3" class="{{ $inputCls }} resize-y">{{ $org['director_bio'] }}</textarea></div>
                    <div>
                        <label class="{{ $labelCls }}">Foto del director</label>
                        <div class="flex items-center gap-3">
                            <img src="{{ $org['director_img'] }}" class="w-16 h-16 rounded-full object-cover border border-slate-200 dark:border-slate-700" onerror="this.style.display='none'">
                            <input type="file" name="director_img" accept="image/*" class="text-xs text-slate-600 dark:text-slate-300 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pb-8">
            <button type="submit" class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg text-sm font-medium shadow-lg shadow-brand-500/30 transition-all flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Guardar cambios
            </button>
        </div>
    </form>
</div>

<script>
function addOrgItem(btn, name) {
    const list = btn.parentElement.querySelector('.org-list');
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2 org-list-row';
    row.innerHTML = `
        <input type="text" name="${name}[]" value="" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
        <button type="button" class="p-2 text-red-400 hover:text-red-600 shrink-0"><i data-lucide="x" class="w-4 h-4"></i></button>`;
    row.querySelector('button').addEventListener('click', () => row.remove());
    list.appendChild(row);
    if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
    row.querySelector('input').focus();
}
</script>
@endsection
