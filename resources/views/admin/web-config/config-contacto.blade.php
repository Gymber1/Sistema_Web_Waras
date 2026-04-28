@extends('layouts.admin')

@section('title', 'Editar Contacto — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[760px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Editar Contacto</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Modifica los datos e íconos de contacto que aparecen en el portal.</p>
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
        <ul class="space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    @php
        $fields = [
            'direccion' => ['label' => 'Dirección',  'type' => 'textarea', 'placeholder' => "Esq. Av. Luzuriaga con Av. 28 de Julio\nHuaraz, Áncash, Perú", 'hint' => 'Puedes usar saltos de línea para dividir en dos filas.', 'default_img' => '/Direccion.png', 'lucide' => 'map-pin'],
            'telefono'  => ['label' => 'Teléfono',   'type' => 'input',    'placeholder' => '952 845 942',           'hint' => '',                                                          'default_img' => '/Telefono.png',  'lucide' => 'phone'],
            'email'     => ['label' => 'Email',      'type' => 'input',    'placeholder' => 'correo@ejemplo.com',     'hint' => 'Este correo también recibirá los mensajes del formulario.', 'default_img' => '/Email.png',     'lucide' => 'mail'],
        ];
    @endphp

    <form method="POST" action="{{ route('admin.web-config.edit-contacto.update') }}"
          enctype="multipart/form-data" class="space-y-5">
        @csrf

        @foreach($fields as $key => $field)
        @php
            $iconVal = $data["contact_icon_{$key}"] ?? null;
            $hasIcon = !empty($iconVal);
            $imgSrc  = $hasIcon ? asset('storage/' . $iconVal) : $field['default_img'];
        @endphp
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20 flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-50 dark:bg-brand-500/10 rounded-lg flex items-center justify-center">
                    <i data-lucide="{{ $field['lucide'] }}" class="w-4 h-4 text-brand-500"></i>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 text-sm">{{ $field['label'] }}</h3>
            </div>

            <div class="p-6 space-y-5">
                {{-- Texto --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                        Texto de {{ $field['label'] }}
                    </label>
                    @if($field['type'] === 'textarea')
                        <textarea name="contact_{{ $key }}" rows="2"
                            class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 resize-none transition-all"
                        >{{ old("contact_{$key}", $data["contact_{$key}"]) }}</textarea>
                    @else
                        <input type="text" name="contact_{{ $key }}"
                            value="{{ old("contact_{$key}", $data["contact_{$key}"]) }}"
                            placeholder="{{ $field['placeholder'] }}"
                            class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    @endif
                    @if($field['hint'])
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $field['hint'] }}</p>
                    @endif
                </div>

                {{-- Ícono --}}
                <div class="flex items-start gap-6">
                    <div class="shrink-0 flex flex-col items-center gap-2">
                        <div class="w-20 h-20 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 flex items-center justify-center overflow-hidden">
                            <img id="preview-{{ $key }}" src="{{ $imgSrc }}" alt="ícono" class="w-14 h-14 object-contain">
                        </div>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                            {{ $hasIcon ? 'Personalizado' : 'Por defecto' }}
                        </span>
                    </div>

                    <div class="flex-1 space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Subir nuevo ícono</label>
                            <input type="file" name="contact_icon_{{ $key }}"
                                   accept="image/*"
                                   onchange="previewIcon(this, 'preview-{{ $key }}')"
                                   class="block w-full text-sm text-slate-500 dark:text-slate-400
                                          file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                          file:text-sm file:font-medium file:bg-brand-50 dark:file:bg-brand-500/10 file:text-brand-700 dark:file:text-brand-400
                                          hover:file:bg-brand-100 dark:hover:file:bg-brand-500/20 cursor-pointer">
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">JPG, PNG o WEBP. Recomendado: fondo transparente.</p>
                        </div>

                        @if($hasIcon)
                        <form method="POST"
                              action="{{ route('admin.web-config.edit-contacto.icon-destroy', $key) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                onclick="confirmDelete(this.closest('form'), '¿Eliminar ícono personalizado y volver al por defecto?'); return false;"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 border border-red-200 dark:border-red-500/20 px-3 py-2 rounded-lg transition-colors">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                Eliminar ícono (restaurar por defecto)
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="flex justify-end mt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm px-6 py-2.5 rounded-lg transition-colors shadow-lg shadow-brand-500/30">
                <i data-lucide="check" class="w-4 h-4"></i>
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script>
function previewIcon(input, previewId) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => document.getElementById(previewId).src = e.target.result;
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
