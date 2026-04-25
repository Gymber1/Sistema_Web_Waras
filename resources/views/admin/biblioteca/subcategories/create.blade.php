@extends('layouts.admin')

@section('section', 'Biblioteca > SubCategorías > Nueva')

@section('content')
<div class="p-6 md:p-10 max-w-[720px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.subcategories') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Agregar subcategoría</h1>
                <span class="px-3 py-1 bg-teal-100 text-teal-700 text-xs font-bold rounded-full uppercase tracking-wider">SUBCATEGORÍA</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Elige la categoría padre a la que pertenece esta subcategoría.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.subcategories.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">
                    Categoría padre <span class="text-red-500">*</span>
                </label>
                <select name="parent_id" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 outline-none bg-white">
                    <option value="">— Seleccionar categoría —</option>
                    @foreach($parentCategories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('parent_id', request('parent_id')) == $cat->id)>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.subcategories') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-bold shadow-lg shadow-teal-200 transition-all">Guardar subcategoría</button>
        </div>
    </form>
</div>
@endsection
