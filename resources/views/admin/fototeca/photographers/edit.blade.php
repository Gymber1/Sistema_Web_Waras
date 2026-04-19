@extends('layouts.admin')

@section('section', 'Fototeca > Fotógrafos > Editar')

@section('content')
<div class="p-6 md:p-10 max-w-[720px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.fototeca.photographers') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Editar información</h1>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase tracking-wider">FOTÓGRAFO</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Modifica los campos necesarios y guarda los cambios.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.fototeca.photographers.update', $photographer) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            {{-- Foto actual --}}
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-slate-200 flex-shrink-0 cursor-zoom-in"
                    @if($photographer->photo_path) onclick="openLightbox('{{ Storage::url($photographer->photo_path) }}', '{{ addslashes($photographer->full_name) }}')" @endif>
                    @if($photographer->photo_path)
                    <img src="{{ Storage::url($photographer->photo_path) }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-slate-100 flex items-center justify-center\'><svg class=\'w-7 h-7 text-slate-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'/></svg></div>'">
                    @else
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                        <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-700">{{ $photographer->full_name }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">ID #{{ $photographer->id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre completo <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name', $photographer->full_name) }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Lugar de nacimiento</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $photographer->birth_place) }}" placeholder="Ej. Huaraz, Áncash"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Fecha de nacimiento</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $photographer->birth_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Lugar de fallecimiento</label>
                    <input type="text" name="death_place" value="{{ old('death_place', $photographer->death_place) }}" placeholder="Dejar vacío si aún vive"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Fecha de fallecimiento</label>
                    <input type="date" name="death_date" value="{{ old('death_date', $photographer->death_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Foto del fotógrafo</label>
                    @if($photographer->photo_path)
                    <div class="flex items-center gap-2 mb-3 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-xs font-bold text-blue-700">Archivo actual cargado · sube una nueva para reemplazar</p>
                    </div>
                    @endif
                    <input type="file" name="photo" accept="image/*"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 file:font-semibold hover:file:bg-blue-200">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Reseña biográfica</label>
                    <textarea name="biography" rows="4"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y">{{ old('biography', $photographer->biography) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Estudios o crítica a su obra</label>
                    <textarea name="studies_critique" rows="3" placeholder="Análisis, publicaciones o crítica académica sobre su obra..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y">{{ old('studies_critique', $photographer->studies_critique) }}</textarea>
                </div>

            </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.photographers') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-200 transition-all">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
