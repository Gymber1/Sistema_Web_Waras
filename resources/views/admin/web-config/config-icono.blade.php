@extends('layouts.admin')

@section('title', 'Iconos del Navbar — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[720px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Iconos del Navbar</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configura un icono diferente para cada módulo. Aparece a la izquierda del nombre en el navbar.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    @php
    $modules = [
        'nav_logo_portal'     => ['label' => 'Portal Principal', 'key' => 'nav_logo_portal',     'icon' => 'home',   'color' => 'amber'],
        'nav_logo_biblioteca' => ['label' => 'Biblioteca',        'key' => 'nav_logo_biblioteca', 'icon' => 'book',   'color' => 'emerald'],
        'nav_logo_fototeca'   => ['label' => 'Fototeca',          'key' => 'nav_logo_fototeca',   'icon' => 'camera', 'color' => 'blue'],
    ];
    $colorMap = [
        'amber'   => ['bg' => 'bg-amber-50 dark:bg-amber-500/10',   'icon' => 'text-amber-500',   'hover_border' => 'hover:border-amber-400 dark:hover:border-amber-500', 'btn' => 'bg-amber-500 hover:bg-amber-600'],
        'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10','icon' => 'text-emerald-500', 'hover_border' => 'hover:border-emerald-400 dark:hover:border-emerald-500','btn' => 'bg-emerald-600 hover:bg-emerald-700'],
        'blue'    => ['bg' => 'bg-blue-50 dark:bg-blue-500/10',     'icon' => 'text-blue-500',    'hover_border' => 'hover:border-blue-400 dark:hover:border-blue-500',   'btn' => 'bg-blue-600 hover:bg-blue-700'],
    ];
    @endphp

    <div class="space-y-5">
    @foreach($modules as $slug => $mod)
    @php $c = $colorMap[$mod['color']]; $current = $icons[$mod['key']] ?? null; @endphp

    <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $c['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="{{ $mod['icon'] }}" class="w-5 h-5 {{ $c['icon'] }}"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 dark:text-white text-sm">{{ $mod['label'] }}</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Clave: <code class="bg-slate-100 dark:bg-slate-700 px-1 rounded text-slate-600 dark:text-slate-300">{{ $mod['key'] }}</code></p>
                </div>
            </div>
            @if($current)
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/' . $current) }}" alt="Icono actual" class="w-8 h-8 object-contain">
                </div>
                <form action="{{ route('admin.web-config.icono.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <input type="hidden" name="key" value="{{ $mod['key'] }}">
                    <button type="submit"
                            onclick="confirmDelete(this.closest('form'), '¿Eliminar el icono de {{ $mod['label'] }}?'); return false;"
                            class="inline-flex items-center gap-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-xs font-medium px-3 py-2 rounded-lg transition-colors">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
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

                <label class="block w-full cursor-pointer border-2 border-dashed border-slate-200 dark:border-slate-700 {{ $c['hover_border'] }} rounded-xl px-6 py-5 transition-colors group" id="dropzone-{{ $slug }}">
                    <input type="file" name="icono" accept="image/*" class="hidden" onchange="previewIcon(this, '{{ $slug }}')">
                    <div id="preview-{{ $slug }}" class="hidden mb-3 flex justify-center">
                        <img id="preview-img-{{ $slug }}" src="" alt="Preview" class="w-14 h-14 object-contain rounded-xl border border-slate-200 dark:border-slate-700">
                    </div>
                    <div class="flex items-center gap-4">
                        <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-300 dark:text-slate-600 group-hover:{{ $c['icon'] }} transition-colors flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 transition-colors">{{ $current ? 'Haz clic para reemplazar el icono' : 'Haz clic para subir un icono' }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">PNG, JPG, WEBP o SVG · Máx. 1 MB · Recomendado: 64×64 px</p>
                        </div>
                    </div>
                </label>

                @error('icono')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                <button type="submit"
                        class="mt-4 px-5 py-2.5 {{ $c['btn'] }} text-white font-medium text-sm rounded-lg transition-colors shadow-sm">
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
