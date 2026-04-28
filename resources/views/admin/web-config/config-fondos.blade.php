@extends('layouts.admin')

@section('title', 'Fondos de Sitios — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[900px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Fondos de Sitios Web</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Personaliza las imágenes de fondo de cada módulo. Formatos: JPG, PNG, WebP — máx. 5 MB.</p>
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
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <div class="space-y-5">
        @foreach($settings as $key => $site)
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">

            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20">
                <div class="flex items-center gap-3">
                    <span class="text-xl">{{ $site['icon'] }}</span>
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-white text-sm">{{ $site['label'] }}</h3>
                        <span class="text-xs text-slate-400 dark:text-slate-500 font-mono">{{ $site['route_hint'] }}</span>
                    </div>
                </div>
                @if($site['value'])
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 px-2.5 py-1 rounded-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                        Personalizada
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 px-2.5 py-1 rounded-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 inline-block"></span>
                        Por defecto
                    </span>
                @endif
            </div>

            <div class="p-6 flex flex-col lg:flex-row gap-6">

                {{-- Vista previa --}}
                <div class="lg:w-64 shrink-0">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Vista previa</p>
                    <div class="relative rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800" style="aspect-ratio:16/7;">
                        @if($site['value'])
                            <img src="{{ Storage::url($site['value']) }}" alt="Fondo {{ $site['label'] }}"
                                class="w-full h-full object-cover" id="preview-img-{{ $key }}"
                                onerror="this.style.display='none'">
                            <div class="absolute inset-0 bg-black/30 flex items-end p-3 pointer-events-none">
                                <span class="text-white text-xs font-medium truncate max-w-full bg-black/40 px-2 py-0.5 rounded" id="preview-name-{{ $key }}">{{ basename($site['value']) }}</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-slate-400 dark:text-slate-500 gap-2" id="preview-empty-{{ $key }}">
                                <i data-lucide="image" class="w-8 h-8 opacity-40"></i>
                                <span class="text-xs text-center px-2">Fondo por defecto</span>
                            </div>
                            <img src="" alt="" class="w-full h-full object-cover hidden" id="preview-img-{{ $key }}">
                            <div class="absolute inset-0 bg-black/30 flex items-end p-3 pointer-events-none hidden" id="preview-overlay-{{ $key }}">
                                <span class="text-white text-xs font-medium truncate max-w-full bg-black/40 px-2 py-0.5 rounded" id="preview-name-{{ $key }}"></span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Upload --}}
                <div class="flex-1 flex flex-col gap-4">
                    <form method="POST" action="{{ route('admin.web-config.update', $key) }}"
                          enctype="multipart/form-data" id="form-upload-{{ $key }}">
                        @csrf
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Subir nueva imagen</p>
                        <label for="img-{{ $key }}"
                               class="group flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-brand-400 dark:hover:border-brand-500 bg-slate-50 dark:bg-slate-800/30 hover:bg-brand-50 dark:hover:bg-brand-500/5 rounded-xl p-5 cursor-pointer transition-all"
                               id="dropzone-{{ $key }}">
                            <i data-lucide="upload-cloud" class="w-7 h-7 text-slate-300 dark:text-slate-600 group-hover:text-brand-400 transition-colors"></i>
                            <span class="text-sm text-slate-500 dark:text-slate-400 group-hover:text-brand-600 dark:group-hover:text-brand-400 font-medium transition-colors text-center" id="label-{{ $key }}">
                                Haz clic o arrastra una imagen aquí
                            </span>
                            <span class="text-xs text-slate-400 dark:text-slate-500">JPG · PNG · WebP — máx. 5 MB</span>
                            <input type="file" name="image" id="img-{{ $key }}"
                                   accept="image/jpeg,image/png,image/webp" class="hidden"
                                   data-key="{{ $key }}" onchange="handleFileSelect(this)">
                        </label>
                        <div class="flex items-center gap-3 mt-4 flex-wrap">
                            <button type="submit" id="btn-upload-{{ $key }}" disabled
                                    class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 disabled:opacity-40 disabled:cursor-not-allowed text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors shadow-lg shadow-brand-500/30">
                                <i data-lucide="upload" class="w-4 h-4"></i>
                                Guardar fondo
                            </button>
                            @if($site['value'])
                            <button type="button" onclick="deleteBg('{{ $key }}', '{{ $site['label'] }}')"
                                    class="inline-flex items-center gap-2 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 text-sm font-medium px-5 py-2.5 rounded-lg transition-colors border border-red-200 dark:border-red-500/20">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                Eliminar fondo
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@foreach($settings as $key => $site)
    @if($site['value'])
    <form method="POST" action="{{ route('admin.web-config.destroy', $key) }}"
          id="form-delete-{{ $key }}" style="display:none;">
        @csrf @method('DELETE')
    </form>
    @endif
@endforeach

<script>
function handleFileSelect(input) {
    const key = input.dataset.key;
    const file = input.files[0];
    if (!file) return;
    document.getElementById('label-' + key).textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
    document.getElementById('dropzone-' + key).classList.add('border-brand-500', 'bg-brand-50');
    document.getElementById('btn-upload-' + key).disabled = false;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('preview-img-' + key);
        img.src = e.target.result;
        img.classList.remove('hidden');
        const empty = document.getElementById('preview-empty-' + key);
        if (empty) empty.classList.add('hidden');
        const overlay = document.getElementById('preview-overlay-' + key);
        if (overlay) overlay.classList.remove('hidden');
        const name = document.getElementById('preview-name-' + key);
        if (name) name.textContent = file.name;
    };
    reader.readAsDataURL(file);
}
function deleteBg(key, label) {
    if (!confirm('¿Eliminar el fondo personalizado de ' + label + '? Se restaurará el fondo por defecto.')) return;
    document.getElementById('form-delete-' + key).submit();
}
</script>
@endsection
