@extends('layouts.admin')

@section('title', 'Iconos del Navbar — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="p-8 max-w-3xl mx-auto">

    <a href="{{ route('admin.web-config.index') }}"
       class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-medium mb-8 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver a Configuraciones
    </a>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-800">Iconos del Navbar</h1>
        <p class="text-slate-500 text-sm mt-1">Configura un icono diferente para cada módulo. Aparece a la izquierda del nombre en el navbar.</p>
    </div>

    @php
    $modules = [
        'portal'    => ['label' => 'Portal Principal', 'color' => 'amber',  'key' => 'nav_logo_portal'],
        'biblioteca'=> ['label' => 'Biblioteca',        'color' => 'emerald','key' => 'nav_logo_biblioteca'],
        'fototeca'  => ['label' => 'Fototeca',          'color' => 'blue',   'key' => 'nav_logo_fototeca'],
    ];
    $colors = [
        'amber'   => ['bg'=>'bg-amber-50',   'icon'=>'text-amber-500',   'btn'=>'bg-amber-500 hover:bg-amber-600',   'border'=>'hover:border-amber-400',   'text'=>'group-hover:text-amber-600'],
        'emerald' => ['bg'=>'bg-emerald-50', 'icon'=>'text-emerald-500', 'btn'=>'bg-emerald-600 hover:bg-emerald-700','border'=>'hover:border-emerald-400', 'text'=>'group-hover:text-emerald-600'],
        'blue'    => ['bg'=>'bg-blue-50',    'icon'=>'text-blue-500',    'btn'=>'bg-blue-600 hover:bg-blue-700',     'border'=>'hover:border-blue-400',    'text'=>'group-hover:text-blue-600'],
    ];
    @endphp

    <div class="flex flex-col gap-6">
    @foreach($modules as $slug => $mod)
    @php $c = $colors[$mod['color']]; $current = $icons[$mod['key']] ?? null; @endphp

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 {{ $c['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-black text-slate-800">{{ $mod['label'] }}</h2>
                <p class="text-xs text-slate-400">Clave: <code class="bg-slate-100 px-1 rounded">{{ $mod['key'] }}</code></p>
            </div>
            @if($current)
            <div class="ml-auto flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/' . $current) }}" alt="Icono actual" class="w-9 h-9 object-contain">
                </div>
                <form action="{{ route('admin.web-config.icono.destroy') }}" method="POST"
                      onsubmit="return confirm('¿Eliminar el icono de {{ $mod['label'] }}?')">
                    @csrf @method('DELETE')
                    <input type="hidden" name="key" value="{{ $mod['key'] }}">
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 text-red-600 hover:text-red-700 border border-red-200 hover:border-red-300 bg-red-50 hover:bg-red-100 text-xs font-semibold px-3 py-2 rounded-xl transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar
                    </button>
                </form>
            </div>
            @endif
        </div>

        <div class="p-6">
            <form action="{{ route('admin.web-config.icono.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="key" value="{{ $mod['key'] }}">

                <label class="block w-full cursor-pointer border-2 border-dashed border-slate-200 {{ $c['border'] }} rounded-2xl px-6 py-5 transition-colors group" id="dropzone-{{ $slug }}">
                    <input type="file" name="icono" accept="image/*" class="hidden" onchange="previewIcon(this, '{{ $slug }}')">
                    <div id="preview-{{ $slug }}" class="hidden mb-3 flex justify-center">
                        <img id="preview-img-{{ $slug }}" src="" alt="Preview" class="w-14 h-14 object-contain rounded-xl border border-slate-200">
                    </div>
                    <div class="flex items-center gap-4">
                        <svg class="w-8 h-8 text-slate-300 {{ $c['text'] }} transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-slate-500 {{ $c['text'] }} transition-colors">{{ $current ? 'Haz clic para reemplazar' : 'Haz clic para subir un icono' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">PNG, JPG, WEBP o SVG · Máx. 1 MB · Recomendado: 64×64 px</p>
                        </div>
                    </div>
                </label>

                @error('icono')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <button type="submit"
                        class="mt-4 px-6 py-2.5 {{ $c['btn'] }} text-white font-bold text-sm rounded-xl transition-colors shadow-sm">
                    Guardar Icono
                </button>
            </form>
        </div>
    </div>
    @endforeach
    </div>
</div>

<script>
function previewIcon(input, slug) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('preview-img-' + slug);
        const wrap = document.getElementById('preview-' + slug);
        img.src = e.target.result;
        wrap.classList.remove('hidden');
        wrap.classList.add('flex');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
