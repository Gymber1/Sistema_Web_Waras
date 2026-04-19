@extends('layouts.admin')

@section('title', 'Fondos de Sitios — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="p-8 max-w-5xl mx-auto">

    {{-- Volver --}}
    <a href="{{ route('admin.web-config.index') }}"
       class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-medium mb-8 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver a Configuraciones
    </a>

    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Fondos de Sitios Web</h1>
        <p class="text-slate-500 text-sm mt-1">Personaliza las imágenes de fondo de cada módulo del portal. Formatos: JPG, PNG, WebP — máx. 5 MB.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        <div>{{ $errors->first() }}</div>
    </div>
    @endif

    <div class="flex flex-col gap-6">
        @foreach($settings as $key => $site)
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $site['icon'] }}</span>
                    <div>
                        <h2 class="font-bold text-slate-800 text-base leading-tight">{{ $site['label'] }}</h2>
                        <span class="text-xs text-slate-400 font-mono">{{ $site['route_hint'] }}</span>
                    </div>
                </div>
                @if($site['value'])
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                        Imagen personalizada
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 inline-block"></span>
                        Fondo por defecto
                    </span>
                @endif
            </div>

            <div class="p-6 flex flex-col lg:flex-row gap-6">

                <div class="lg:w-72 shrink-0">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Vista previa actual</p>
                    <div class="relative rounded-xl overflow-hidden border border-slate-200 bg-slate-100" style="aspect-ratio:16/7;">
                        @if($site['value'])
                            <img src="{{ Storage::url($site['value']) }}" alt="Fondo {{ $site['label'] }}"
                                 class="w-full h-full object-cover" id="preview-img-{{ $key }}"
                                 onerror="this.style.display='none'">
                            <div class="absolute inset-0 bg-black/30 flex items-end p-3 pointer-events-none">
                                <span class="text-white text-xs font-medium truncate max-w-full bg-black/40 px-2 py-0.5 rounded" id="preview-name-{{ $key }}">{{ basename($site['value']) }}</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-slate-400 gap-2" id="preview-empty-{{ $key }}">
                                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs text-center px-2">Usando fondo por defecto</span>
                            </div>
                            <img src="" alt="" class="w-full h-full object-cover hidden" id="preview-img-{{ $key }}">
                            <div class="absolute inset-0 bg-black/30 flex items-end p-3 pointer-events-none hidden" id="preview-overlay-{{ $key }}">
                                <span class="text-white text-xs font-medium truncate max-w-full bg-black/40 px-2 py-0.5 rounded" id="preview-name-{{ $key }}"></span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex-1 flex flex-col gap-4">
                    <form method="POST" action="{{ route('admin.web-config.update', $key) }}"
                          enctype="multipart/form-data" id="form-upload-{{ $key }}">
                        @csrf
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Subir nueva imagen</p>
                        <label for="img-{{ $key }}"
                               class="group flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50 hover:bg-indigo-50 rounded-xl p-5 cursor-pointer transition-all"
                               id="dropzone-{{ $key }}">
                            <svg class="w-7 h-7 text-slate-300 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-sm text-slate-500 group-hover:text-indigo-600 font-medium transition-colors text-center" id="label-{{ $key }}">
                                Haz clic o arrastra una imagen aquí
                            </span>
                            <span class="text-xs text-slate-400">JPG · PNG · WebP — máx. 5 MB</span>
                            <input type="file" name="image" id="img-{{ $key }}"
                                   accept="image/jpeg,image/png,image/webp" class="hidden"
                                   data-key="{{ $key }}" onchange="handleFileSelect(this)">
                        </label>
                        <div class="flex items-center gap-3 mt-4 flex-wrap">
                            <button type="submit" id="btn-upload-{{ $key }}" disabled
                                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-40 disabled:cursor-not-allowed text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Guardar fondo
                            </button>
                            @if($site['value'])
                            <button type="button" onclick="deleteBg('{{ $key }}', '{{ $site['label'] }}')"
                                    class="flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-bold px-5 py-2.5 rounded-xl transition-colors border border-red-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
    document.getElementById('dropzone-' + key).classList.add('border-indigo-500', 'bg-indigo-50');
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
