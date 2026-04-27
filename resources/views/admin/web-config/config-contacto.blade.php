@extends('layouts.admin')

@section('title', 'Editar Contacto — WARAS Panel')
@section('section', 'Editar Contacto')

@section('content')
<div class="p-8 max-w-3xl mx-auto">

    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.web-config.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Editar Contacto</h1>
            <p class="text-slate-500 text-sm mt-0.5">Modifica los datos e íconos de contacto que aparecen en el portal.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Macros de tarjeta de campo con ícono --}}
    @php
        $fields = [
            'direccion' => [
                'label'       => 'Dirección',
                'type'        => 'textarea',
                'placeholder' => "Esq. Av. Luzuriaga con Av. 28 de Julio\nHuaraz, Áncash, Perú",
                'hint'        => 'Puedes usar saltos de línea para dividir en dos filas.',
                'default_img' => '/Direccion.png',
                'color'       => 'rose',
            ],
            'telefono' => [
                'label'       => 'Teléfono',
                'type'        => 'input',
                'placeholder' => '952 845 942',
                'hint'        => '',
                'default_img' => '/Telefono.png',
                'color'       => 'emerald',
            ],
            'email' => [
                'label'       => 'Email',
                'type'        => 'input',
                'placeholder' => 'correo@ejemplo.com',
                'hint'        => 'Este correo también recibirá los mensajes del formulario de contacto.',
                'default_img' => '/Email.png',
                'color'       => 'blue',
            ],
        ];
        $colorMap = [
            'rose'    => ['bg' => 'bg-rose-50',    'ring' => 'focus:ring-rose-400',    'border' => 'border-rose-200'],
            'emerald' => ['bg' => 'bg-emerald-50',  'ring' => 'focus:ring-emerald-400', 'border' => 'border-emerald-200'],
            'blue'    => ['bg' => 'bg-blue-50',     'ring' => 'focus:ring-blue-400',    'border' => 'border-blue-200'],
        ];
    @endphp

    <form method="POST" action="{{ route('admin.web-config.edit-contacto.update') }}"
          enctype="multipart/form-data" class="space-y-6">
        @csrf

        @foreach($fields as $key => $field)
        @php
            $c       = $colorMap[$field['color']];
            $iconVal = $data["contact_icon_{$key}"] ?? null;
            $hasIcon = !empty($iconVal);
            $imgSrc  = $hasIcon ? asset('storage/' . $iconVal) : $field['default_img'];
        @endphp
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                <div class="w-8 h-8 {{ $c['bg'] }} rounded-lg flex items-center justify-center">
                    <img src="{{ $imgSrc }}" alt="{{ $field['label'] }}" class="w-5 h-5 object-contain">
                </div>
                <h2 class="font-bold text-slate-700">{{ $field['label'] }}</h2>
            </div>

            <div class="p-6 space-y-5">
                {{-- Texto --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                        Texto de {{ $field['label'] }}
                    </label>
                    @if($field['type'] === 'textarea')
                        <textarea name="contact_{{ $key }}" rows="2"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 {{ $c['ring'] }} resize-none"
                        >{{ old("contact_{$key}", $data["contact_{$key}"]) }}</textarea>
                    @else
                        <input type="text" name="contact_{{ $key }}"
                            value="{{ old("contact_{$key}", $data["contact_{$key}"]) }}"
                            placeholder="{{ $field['placeholder'] }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 {{ $c['ring'] }}">
                    @endif
                    @if($field['hint'])
                        <p class="text-xs text-slate-400 mt-1">{{ $field['hint'] }}</p>
                    @endif
                </div>

                {{-- Ícono --}}
                <div class="flex items-start gap-6">
                    {{-- Vista previa --}}
                    <div class="shrink-0 flex flex-col items-center gap-2">
                        <div class="w-20 h-20 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden">
                            <img id="preview-{{ $key }}" src="{{ $imgSrc }}" alt="ícono"
                                 class="w-14 h-14 object-contain">
                        </div>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider">
                            {{ $hasIcon ? 'Personalizado' : 'Por defecto' }}
                        </span>
                    </div>

                    {{-- Acciones --}}
                    <div class="flex-1 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                                Subir nuevo ícono
                            </label>
                            <input type="file" name="contact_icon_{{ $key }}"
                                   accept="image/*"
                                   onchange="previewIcon(this, 'preview-{{ $key }}')"
                                   class="block w-full text-sm text-slate-500
                                          file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                          file:text-sm file:font-bold file:bg-slate-100 file:text-slate-700
                                          hover:file:bg-slate-200 cursor-pointer">
                            <p class="text-xs text-slate-400 mt-1">JPG, PNG o WEBP. Recomendado: fondo transparente.</p>
                        </div>

                        @if($hasIcon)
                        <form method="POST"
                              action="{{ route('admin.web-config.edit-contacto.icon-destroy', $key) }}"
                              onsubmit="return confirm('¿Eliminar ícono personalizado y volver al por defecto?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-4 py-2 rounded-lg transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar ícono (restaurar por defecto)
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-8 py-3 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
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
