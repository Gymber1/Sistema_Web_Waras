@extends('layouts.admin')

@section('title', 'Iconos Flotantes — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="p-8 max-w-4xl mx-auto">

    <a href="{{ route('admin.web-config.index') }}"
       class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-medium mb-8 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver a Configuraciones
    </a>

    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Iconos Flotantes de Contacto</h1>
        <p class="text-slate-500 text-sm mt-1">Edita los botones flotantes del portal. Yape y WhatsApp son fijos y no se pueden eliminar.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- ── Botones existentes (cada uno con su propio form) ── --}}
    <div class="space-y-6 mb-8">
    @foreach($buttons as $btn)
    @php
        $isWa   = $btn->slug === 'whatsapp';
        $isYape = $btn->slug === 'yape';
        $waNum  = $isWa ? preg_replace('/^51/', '', $btn->descripcion ?? '') : '';

        $logoSrc = $btn->logo
            ? asset('storage/' . $btn->logo)
            : ($isYape ? asset('Yape.png') : ($isWa ? asset('Whatsapp.png') : null));

        $qrSrc = $btn->imagen ? asset('storage/' . $btn->imagen) : null;

        $glowColors  = ['morado'=>'#742364','verde'=>'#128C7E','indigo'=>'#4f46e5','azul'=>'#2563eb','rojo'=>'#dc2626','naranja'=>'#ea580c','amarillo'=>'#ca8a04','rosa'=>'#db2777','cian'=>'#0891b2','blanco'=>'#64748b'];
        $selectedGlow = old("glow_color", $btn->glow_color ?? 'indigo');
    @endphp

    <form method="POST" action="{{ route('admin.web-config.floating-btn.update', $btn) }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $btn->nombre }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                    @else
                        <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-sm font-bold">{{ substr($btn->nombre,0,1) }}</div>
                    @endif
                    <div>
                        <span class="font-bold text-slate-800">{{ $btn->nombre }}</span>
                        @if($btn->is_default)
                            <span class="ml-2 text-[10px] font-bold uppercase tracking-wider bg-slate-200 text-slate-500 px-2 py-0.5 rounded-full">Por defecto</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if(!$btn->is_default)
                    <button type="button" onclick="deleteFb('del-fb-{{ $btn->id }}')"
                            class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar botón
                    </button>
                    @endif
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Guardar
                    </button>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ① Logo del botón circular --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Logo del botón</p>
                        <p class="text-xs text-slate-400 mt-0.5">Imagen circular que flota en el portal.</p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-indigo-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('logo-{{ $btn->id }}').click()">
                        <img id="prev-logo-{{ $btn->id }}" src="{{ $logoSrc ?? '' }}"
                             class="w-20 h-20 object-contain rounded-full border border-slate-200 {{ $logoSrc ? '' : 'hidden' }}">
                        <div id="logo-ph-{{ $btn->id }}" class="{{ $logoSrc ? 'hidden' : '' }} text-slate-400 text-xs text-center">
                            <svg class="w-8 h-8 mx-auto mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Sin logo
                        </div>
                        <span class="text-xs text-slate-400">Clic para cambiar</span>
                    </div>
                    <input id="logo-{{ $btn->id }}" type="file" name="logo" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-logo-{{ $btn->id }}','logo-ph-{{ $btn->id }}')">
                    {{-- Botón borrar logo (solo si tiene logo personalizado en storage) --}}
                    @if($btn->logo)
                    <button type="button" onclick="deleteImg('del-logo-{{ $btn->id }}')"
                            class="text-xs text-red-400 hover:text-red-600 font-medium flex items-center justify-center gap-1 mt-1 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Quitar logo personalizado
                    </button>
                    @endif
                </div>

                {{-- ② QR / imagen del popover --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ ($isYape || $isWa) ? 'QR del popover' : 'Imagen del popover' }}
                        </p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ ($isYape || $isWa) ? 'Se muestra al hacer clic en el botón.' : 'Imagen que aparece en el globo de información.' }}
                        </p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-indigo-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('qr-{{ $btn->id }}').click()">
                        <img id="prev-qr-{{ $btn->id }}" src="{{ $qrSrc ?? '' }}"
                             class="w-24 h-24 object-contain rounded-lg {{ $qrSrc ? '' : 'hidden' }}">
                        <div id="qr-ph-{{ $btn->id }}" class="{{ $qrSrc ? 'hidden' : '' }} text-slate-400 text-xs text-center">
                            <svg class="w-8 h-8 mx-auto mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            Sin imagen
                        </div>
                        <span class="text-xs text-slate-400">Clic para cambiar</span>
                    </div>
                    <input id="qr-{{ $btn->id }}" type="file" name="imagen" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-qr-{{ $btn->id }}','qr-ph-{{ $btn->id }}')">
                    {{-- Botón borrar imagen/QR --}}
                    @if($btn->imagen)
                    <button type="button" onclick="deleteImg('del-img-{{ $btn->id }}')"
                            class="text-xs text-red-400 hover:text-red-600 font-medium flex items-center justify-center gap-1 mt-1 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Quitar {{ ($isYape || $isWa) ? 'QR' : 'imagen' }}
                    </button>
                    @endif
                </div>

                {{-- ③ Campos de texto --}}
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $btn->nombre) }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    @if($isWa)
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Número de WhatsApp</label>
                        <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-green-400">
                            <span class="px-3 py-2.5 bg-slate-100 text-slate-500 text-sm font-mono border-r border-slate-200 select-none">+51</span>
                            <input type="text" name="whatsapp_number" value="{{ $waNum }}"
                                   placeholder="987654321" maxlength="9" inputmode="numeric"
                                   oninput="this.value=this.value.replace(/\D/g,'')"
                                   class="flex-1 px-3 py-2.5 text-sm font-mono outline-none bg-white">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">9 dígitos. Se guarda como <code class="bg-slate-100 px-1 rounded">51xxxxxxxxx</code></p>
                    </div>
                    @else
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Descripción del popover</label>
                        <textarea name="descripcion" rows="3"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
                        >{{ old('descripcion', $btn->descripcion) }}</textarea>
                    </div>
                    @endif

                    @if(!$isWa && !$isYape)
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Enlace (URL)</label>
                        <input type="text" name="link" value="{{ old('link', $btn->link) }}"
                               placeholder="https://..."
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    @endif

                    {{-- Color de brillo --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Color de brillo</label>
                        <input type="hidden" name="glow_color" id="glow-val-{{ $btn->id }}" value="{{ $selectedGlow }}">
                        <div class="flex flex-wrap gap-2" id="glow-swatches-{{ $btn->id }}">
                            @foreach($glowColors as $colorKey => $colorHex)
                            <div onclick="selectGlow('{{ $btn->id }}','{{ $colorKey }}',this)"
                                 title="{{ ucfirst($colorKey) }}"
                                 data-color="{{ $colorKey }}"
                                 style="width:28px;height:28px;border-radius:50%;background:{{ $colorHex }};cursor:pointer;transition:transform .15s,box-shadow .15s;flex-shrink:0;
                                        {{ $selectedGlow === $colorKey ? 'box-shadow:0 0 0 2px #fff,0 0 0 4px #1e293b;transform:scale(1.15)' : '' }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    @endforeach
    </div>

    {{-- ── Agregar nuevo botón ── --}}
    <form method="POST" action="{{ route('admin.web-config.contact.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-white border-2 border-dashed border-slate-300 rounded-2xl overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-700">Agregar nuevo botón flotante</h2>
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Agregar botón
                </button>
            </div>
            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Logo nuevo --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Logo del botón</p>
                        <p class="text-xs text-slate-400 mt-0.5">Imagen circular que flotará en el portal.</p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-indigo-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('new-logo').click()">
                        <img id="prev-new-logo" src="" class="w-20 h-20 object-contain rounded-full border border-slate-200 hidden">
                        <div id="new-logo-ph" class="text-slate-400 text-xs text-center">
                            <svg class="w-8 h-8 mx-auto mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Sin logo
                        </div>
                        <span class="text-xs text-slate-400">Clic para subir</span>
                    </div>
                    <input id="new-logo" type="file" name="new_logo" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-new-logo','new-logo-ph')">
                </div>

                {{-- QR/imagen nuevo --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Imagen del popover</p>
                        <p class="text-xs text-slate-400 mt-0.5">Imagen que aparece al hacer clic en el botón.</p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-indigo-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('new-img').click()">
                        <img id="prev-new-img" src="" class="w-24 h-24 object-contain rounded-lg hidden">
                        <div id="new-img-ph" class="text-slate-400 text-xs text-center">
                            <svg class="w-8 h-8 mx-auto mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            Sin imagen
                        </div>
                        <span class="text-xs text-slate-400">Clic para subir</span>
                    </div>
                    <input id="new-img" type="file" name="new_imagen" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-new-img','new-img-ph')">
                </div>

                {{-- Campos texto nuevo --}}
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nombre</label>
                        <input type="text" name="new_nombre" value="{{ old('new_nombre') }}"
                               placeholder="Ej. Facebook"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Descripción</label>
                        <textarea name="new_descripcion" rows="2" placeholder="Texto del popover..."
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
                        >{{ old('new_descripcion') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Enlace (URL)</label>
                        <input type="text" name="new_link" value="{{ old('new_link') }}"
                               placeholder="https://..."
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Color de brillo</label>
                        @php $newGlowColors = ['morado'=>'#742364','verde'=>'#128C7E','indigo'=>'#4f46e5','azul'=>'#2563eb','rojo'=>'#dc2626','naranja'=>'#ea580c','amarillo'=>'#ca8a04','rosa'=>'#db2777','cian'=>'#0891b2','blanco'=>'#64748b']; @endphp
                        <input type="hidden" name="new_glow_color" id="glow-val-new" value="{{ old('new_glow_color', 'indigo') }}">
                        <div class="flex flex-wrap gap-2" id="glow-swatches-new">
                            @foreach($newGlowColors as $colorKey => $colorHex)
                            <div onclick="selectGlow('new','{{ $colorKey }}',this)"
                                 title="{{ ucfirst($colorKey) }}"
                                 data-color="{{ $colorKey }}"
                                 style="width:28px;height:28px;border-radius:50%;background:{{ $colorHex }};cursor:pointer;transition:transform .15s,box-shadow .15s;flex-shrink:0;
                                        {{ old('new_glow_color','indigo') === $colorKey ? 'box-shadow:0 0 0 2px #fff,0 0 0 4px #1e293b;transform:scale(1.15)' : '' }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-2">
        <a href="{{ route('admin.web-config.index') }}"
           class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors border border-slate-200 bg-white px-5 py-3 rounded-xl hover:bg-slate-50 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver a Configuraciones
        </a>
    </div>
</div>

{{-- Forms ocultos para eliminar botón completo --}}
@foreach($buttons as $btn)
@if(!$btn->is_default)
<form id="del-fb-{{ $btn->id }}" method="POST"
      action="{{ route('admin.web-config.floating-btn.destroy', $btn) }}"
      style="display:none;">
    @csrf @method('DELETE')
</form>
@endif
@endforeach

{{-- Forms ocultos para borrar imagen y logo --}}
@foreach($buttons as $btn)
<form id="del-img-{{ $btn->id }}" method="POST"
      action="{{ route('admin.web-config.floating-btn.imagen.destroy', $btn) }}"
      style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="del-logo-{{ $btn->id }}" method="POST"
      action="{{ route('admin.web-config.floating-btn.logo.destroy', $btn) }}"
      style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach

<script>
function deleteFb(formId) {
    if (!confirm('¿Eliminar este botón flotante?')) return;
    document.getElementById(formId).submit();
}

function deleteImg(formId) {
    if (!confirm('¿Eliminar esta imagen?')) return;
    document.getElementById(formId).submit();
}

function selectGlow(btnId, colorKey, el) {
    document.getElementById('glow-val-' + btnId).value = colorKey;
    const swatches = document.getElementById('glow-swatches-' + btnId);
    swatches.querySelectorAll('div[data-color]').forEach(function(s) {
        s.style.boxShadow = '';
        s.style.transform = '';
    });
    el.style.boxShadow = '0 0 0 2px #fff, 0 0 0 4px #1e293b';
    el.style.transform = 'scale(1.15)';
}

function previewFb(input, previewId, placeholderId) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        img.classList.remove('hidden');
        if (placeholderId) {
            const ph = document.getElementById(placeholderId);
            if (ph) ph.classList.add('hidden');
        }
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
