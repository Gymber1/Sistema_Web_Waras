@extends('layouts.admin')

@section('section', 'Biblioteca > Editoriales > Editar')

@section('content')
<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    {{-- Header --}}
    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.publishers') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Editar información</h1>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">EDITORIALES</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Modifica los campos necesarios y guarda los cambios.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.publishers.update', $publisher) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nombre --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $publisher->name) }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $publisher->email) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone', $publisher->phone) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Sitio Web --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Sitio web</label>
                    <input type="url" name="website" value="{{ old('website', $publisher->website) }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Dirección --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Dirección</label>
                    <input type="text" name="address" value="{{ old('address', $publisher->address) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Descripción</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-y">{{ old('description', $publisher->description) }}</textarea>
                </div>

                {{-- Logo --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Logo</label>
                    @if($publisher->logo_path)
                    <div class="flex items-center gap-3 mb-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                        <img src="{{ Storage::url($publisher->logo_path) }}" class="w-12 h-12 object-contain rounded-lg border border-emerald-200 bg-white p-1">
                        <div>
                            <p class="text-xs font-bold text-emerald-700">Archivo actual cargado</p>
                            <p class="text-xs text-emerald-600 mt-0.5">Sube una nueva imagen para reemplazarla</p>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="logo" accept="image/*"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold hover:file:bg-emerald-200">
                </div>

            </div>
        </div>

        {{-- Acciones --}}
        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.publishers') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">
                Guardar cambios
            </button>
        </div>
    </form>
</div>
@endsection
