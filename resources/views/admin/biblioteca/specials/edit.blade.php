@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Editar')

@section('content')
<div class="p-6 md:p-10 max-w-[720px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.specials') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Editar colección</h1>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">ESPECIAL</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Modifica el nombre, tipo o portada de esta colección especial.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.specials.update', $special) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre de la colección <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $special->title) }}" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3">Tipo <span class="text-red-500">*</span></label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all {{ old('type', $special->type) === 'libro' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-emerald-300' }}">
                        <input type="radio" name="type" value="libro" {{ old('type', $special->type) === 'libro' ? 'checked' : '' }} class="accent-emerald-600 w-4 h-4">
                        <span class="text-sm font-bold text-slate-800">Libros</span>
                    </label>
                    <label class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all {{ old('type', $special->type) === 'revista' ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-300' }}">
                        <input type="radio" name="type" value="revista" {{ old('type', $special->type) === 'revista' ? 'checked' : '' }} class="accent-blue-600 w-4 h-4">
                        <span class="text-sm font-bold text-slate-800">Revistas</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Imagen de portada</label>
                @if($special->cover_image_path)
                <div class="flex items-center gap-4 mb-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                    <img src="{{ Storage::url($special->cover_image_path) }}" class="w-16 h-16 object-cover rounded-xl border border-emerald-200"
                        onerror="this.style.display='none'">
                    <div>
                        <p class="text-xs font-bold text-emerald-700">Imagen actual</p>
                        <p class="text-xs text-emerald-600 mt-0.5">Sube una nueva para reemplazarla</p>
                    </div>
                </div>
                @endif
                <input type="file" name="cover_image" accept="image/*"
                    class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold hover:file:bg-emerald-200">
            </div>

        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.specials') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
