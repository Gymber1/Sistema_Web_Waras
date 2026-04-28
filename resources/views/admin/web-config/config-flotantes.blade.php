@extends('layouts.admin')

@section('title', 'Iconos Flotantes — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[960px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Iconos Flotantes de Contacto</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Edita los botones flotantes del portal. Yape y WhatsApp son fijos y no se pueden eliminar.</p>
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

    {{-- ── Botones existentes ── --}}
    <div class="space-y-5 mb-6">
    @foreach($buttons as $btn)
    @php
        $isWa   = $btn->slug === 'whatsapp';
        $isYape = $btn->slug === 'yape';
        $waNum  = $isWa ? preg_replace('/^51/', '', $btn->descripcion ?? '') : '';
        $logoSrc = $btn->logo ? asset('storage/' . $btn->logo) : ($isYape ? asset('Yape.png') : ($isWa ? asset('Whatsapp.png') : null));
        $qrSrc  = $btn->imagen ? asset('storage/' . $btn->imagen) : null;
        $glowColors  = ['morado'=>'#742364','verde'=>'#128C7E','indigo'=>'#4f46e5','azul'=>'#2563eb','rojo'=>'#dc2626','naranja'=>'#ea580c','amarillo'=>'#ca8a04','rosa'=>'#db2777','cian'=>'#0891b2','blanco'=>'#64748b'];
        $selectedGlow = old("glow_color", $btn->glow_color ?? 'indigo');
    @endphp

    <form method="POST" action="{{ route('admin.web-config.floating-btn.update', $btn) }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $btn->nombre }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 dark:border-slate-700">
                    @else
                        <div class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 text-sm font-bold">{{ substr($btn->nombre,0,1) }}</div>
                    @endif
                    <div>
                        <span class="font-semibold text-slate-800 dark:text-white text-sm">{{ $btn->nombre }}</span>
                        @if($btn->is_default)
                            <span class="ml-2 text-[10px] font-medium uppercase tracking-wider bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-md">Por defecto</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if(!$btn->is_default)
                    <button type="button" onclick="deleteFb('del-fb-{{ $btn->id }}')"
                            class="inline-flex items-center gap-1.5 text-xs text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium transition-colors">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        Eliminar
                    </button>
                    @endif
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs px-4 py-2 rounded-lg transition-colors shadow-sm shadow-brand-500/30">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        Guardar
                    </button>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Logo --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Logo del botón</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Imagen circular que flota en el portal.</p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 dark:hover:border-brand-500 transition-colors cursor-pointer"
                         onclick="document.getElementById('logo-{{ $btn->id }}').click()">
                        <img id="prev-logo-{{ $btn->id }}" src="{{ $logoSrc ?? '' }}"
                             class="w-20 h-20 object-contain rounded-full border border-slate-200 dark:border-slate-700 {{ $logoSrc ? '' : 'hidden' }}">
                        <div id="logo-ph-{{ $btn->id }}" class="{{ $logoSrc ? 'hidden' : '' }} text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="image" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin logo
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para cambiar</span>
                    </div>
                    <input id="logo-{{ $btn->id }}" type="file" name="logo" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-logo-{{ $btn->id }}','logo-ph-{{ $btn->id }}')">
                    @if($btn->logo)
                    <button type="button" onclick="deleteImg('del-logo-{{ $btn->id }}')"
                            class="text-xs text-red-400 dark:text-red-500 hover:text-red-600 dark:hover:text-red-400 font-medium flex items-center justify-center gap-1 mt-1 transition-colors">
                        <i data-lucide="x" class="w-3 h-3"></i>
                        Quitar logo personalizado
                    </button>
                    @endif
                </div>

                {{-- QR/imagen --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ ($isYape || $isWa) ? 'QR del popover' : 'Imagen del popover' }}
                        </p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                            {{ ($isYape || $isWa) ? 'Se muestra al hacer clic en el botón.' : 'Imagen que aparece en el globo de información.' }}
                        </p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 dark:hover:border-brand-500 transition-colors cursor-pointer"
                         onclick="document.getElementById('qr-{{ $btn->id }}').click()">
                        <img id="prev-qr-{{ $btn->id }}" src="{{ $qrSrc ?? '' }}"
                             class="w-24 h-24 object-contain rounded-lg {{ $qrSrc ? '' : 'hidden' }}">
                        <div id="qr-ph-{{ $btn->id }}" class="{{ $qrSrc ? 'hidden' : '' }} text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="qr-code" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin imagen
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para cambiar</span>
                    </div>
                    <input id="qr-{{ $btn->id }}" type="file" name="imagen" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-qr-{{ $btn->id }}','qr-ph-{{ $btn->id }}')">
                    @if($btn->imagen)
                    <button type="button" onclick="deleteImg('del-img-{{ $btn->id }}')"
                            class="text-xs text-red-400 dark:text-red-500 hover:text-red-600 dark:hover:text-red-400 font-medium flex items-center justify-center gap-1 mt-1 transition-colors">
                        <i data-lucide="x" class="w-3 h-3"></i>
                        Quitar {{ ($isYape || $isWa) ? 'QR' : 'imagen' }}
                    </button>
                    @endif
                </div>

                {{-- Campos texto --}}
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $btn->nombre) }}"
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>

                    @if($isWa)
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Número de WhatsApp</label>
                        <div class="flex items-center border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-brand-500/50">
                            <span class="px-3 py-2.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-sm font-mono border-r border-slate-300 dark:border-slate-600 select-none">+51</span>
                            <input type="text" name="whatsapp_number" value="{{ $waNum }}"
                                   placeholder="987654321" maxlength="9" inputmode="numeric"
                                   oninput="this.value=this.value.replace(/\D/g,'')"
                                   class="flex-1 px-3 py-2.5 text-sm font-mono outline-none bg-white dark:bg-slate-800/50 text-slate-800 dark:text-white">
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">9 dígitos. Se guarda como <code class="bg-slate-100 dark:bg-slate-700 px-1 rounded text-slate-600 dark:text-slate-300">51xxxxxxxxx</code></p>
                    </div>
                    @else
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Descripción del popover</label>
                        <textarea name="descripcion" rows="3"
                            class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 resize-none transition-all"
                        >{{ old('descripcion', $btn->descripcion) }}</textarea>
                    </div>
                    @endif

                    @if(!$isWa && !$isYape)
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Enlace (URL)</label>
                        <input type="text" name="link" value="{{ old('link', $btn->link) }}"
                               placeholder="https://..."
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Color de brillo</label>
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
        <div class="bg-white dark:bg-dark-surface rounded-xl border-2 border-dashed border-slate-200 dark:border-dark-border overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-brand-50 dark:bg-brand-500/10 rounded-lg flex items-center justify-center">
                        <i data-lucide="plus" class="w-4 h-4 text-brand-500"></i>
                    </div>
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Agregar nuevo botón flotante</h3>
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs px-4 py-2 rounded-lg transition-colors shadow-sm shadow-brand-500/30">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    Agregar botón
                </button>
            </div>
            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="flex flex-col gap-2">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Logo del botón</p>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('new-logo').click()">
                        <img id="prev-new-logo" src="" class="w-20 h-20 object-contain rounded-full border border-slate-200 dark:border-slate-700 hidden">
                        <div id="new-logo-ph" class="text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="image" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin logo
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para subir</span>
                    </div>
                    <input id="new-logo" type="file" name="new_logo" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-new-logo','new-logo-ph')">
                </div>

                <div class="flex flex-col gap-2">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Imagen del popover</p>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('new-img').click()">
                        <img id="prev-new-img" src="" class="w-24 h-24 object-contain rounded-lg hidden">
                        <div id="new-img-ph" class="text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="qr-code" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin imagen
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para subir</span>
                    </div>
                    <input id="new-img" type="file" name="new_imagen" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-new-img','new-img-ph')">
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nombre</label>
                        <input type="text" name="new_nombre" value="{{ old('new_nombre') }}" placeholder="Ej. Facebook"
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Descripción</label>
                        <textarea name="new_descripcion" rows="2" placeholder="Texto del popover..."
                            class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 resize-none transition-all"
                        >{{ old('new_descripcion') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Enlace (URL)</label>
                        <input type="text" name="new_link" value="{{ old('new_link') }}" placeholder="https://..."
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Color de brillo</label>
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
</div>

{{-- Forms ocultos eliminar botón --}}
@foreach($buttons as $btn)
@if(!$btn->is_default)
<form id="del-fb-{{ $btn->id }}" method="POST" action="{{ route('admin.web-config.floating-btn.destroy', $btn) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endif
@endforeach

{{-- Forms ocultos eliminar imagen/logo --}}
@foreach($buttons as $btn)
<form id="del-img-{{ $btn->id }}" method="POST" action="{{ route('admin.web-config.floating-btn.imagen.destroy', $btn) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="del-logo-{{ $btn->id }}" method="POST" action="{{ route('admin.web-config.floating-btn.logo.destroy', $btn) }}" style="display:none;">
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
    document.getElementById('glow-swatches-' + btnId).querySelectorAll('div[data-color]').forEach(s => {
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
        const ph = document.getElementById(placeholderId);
        if (ph) ph.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
