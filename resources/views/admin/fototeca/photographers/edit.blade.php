@extends('layouts.admin')

@section('section', 'Fototeca > Fotógrafos > Editar')

@section('content')
<div class="max-w-[720px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.fototeca.photographers') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Editar fotógrafo</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">FOTÓGRAFO</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Modifica los campos necesarios y guarda los cambios.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.fototeca.photographers.update', $photographer) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">

            <div class="flex items-center gap-4 p-4 bg-slate-50/80 dark:bg-slate-800/30 rounded-lg border border-slate-100 dark:border-dark-border">
                <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-slate-200 dark:border-slate-600 flex-shrink-0 cursor-zoom-in"
                    @if($photographer->photo_path) onclick="openLightbox('{{ Storage::url($photographer->photo_path) }}', '{{ addslashes($photographer->full_name) }}')" @endif>
                    @if($photographer->photo_path)
                    <img src="{{ Storage::url($photographer->photo_path) }}" class="w-full h-full object-cover" onerror="this.parentElement.className='w-14 h-14 rounded-full bg-brand-50 dark:bg-brand-500/10 flex items-center justify-center text-brand-500 font-bold text-xl'">
                    @else
                    <div class="w-full h-full bg-brand-50 dark:bg-brand-500/10 flex items-center justify-center text-brand-500 font-bold text-xl">{{ mb_substr($photographer->full_name, 0, 1) }}</div>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-slate-800 dark:text-white">{{ $photographer->full_name }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">ID #{{ $photographer->id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre completo <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name', $photographer->full_name) }}" required
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Lugar de nacimiento</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $photographer->birth_place) }}" placeholder="Ej. Huaraz, Áncash"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Fecha de nacimiento</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $photographer->birth_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Lugar de fallecimiento</label>
                    <input type="text" name="death_place" value="{{ old('death_place', $photographer->death_place) }}" placeholder="Dejar vacío si aún vive"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Fecha de fallecimiento</label>
                    <input type="date" name="death_date" value="{{ old('death_date', $photographer->death_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Foto del fotógrafo</label>
                    @if($photographer->photo_path)
                    <div class="flex items-center gap-3 mb-3 p-3 bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 rounded-lg">
                        <i data-lucide="image" class="w-4 h-4 text-brand-500 shrink-0"></i>
                        <p class="text-xs font-semibold text-brand-700 dark:text-brand-300">Foto actual cargada · sube una nueva para reemplazar</p>
                    </div>
                    @endif
                    <input type="file" name="photo" accept="image/*"
                        class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Reseña biográfica</label>
                    <textarea name="biography" rows="4"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ old('biography', $photographer->biography) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Crítica a sus fotografias</label>
                    <textarea name="studies_critique" rows="3" placeholder="Análisis, publicaciones o crítica académica sobre su fotografias..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all resize-y">{{ old('studies_critique', $photographer->studies_critique) }}</textarea>
                </div>

            </div>
        </div>

        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.photographers') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
