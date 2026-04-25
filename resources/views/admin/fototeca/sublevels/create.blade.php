@extends('layouts.admin')

@section('section', 'Fototeca > SubNivel > Nuevo')

@section('content')
<div class="p-6 md:p-10 max-w-[720px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.fototeca.sublevels') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Agregar SubNivel</h1>
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full uppercase tracking-wider">NIVEL 3</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Elige la subcategoría a la que pertenece este subnivel.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.fototeca.sublevels.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">SubCategoría padre <span class="text-red-500">*</span></label>
                <select name="parent_id" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                    <option value="">— Seleccionar subcategoría —</option>
                    @foreach($parentCategories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('parent_id') == $cat->id)>
                        {{ $cat->parent?->name ? $cat->parent->name . ' › ' : '' }}{{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.fototeca.sublevels') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all">Guardar subnivel</button>
        </div>
    </form>
</div>
@endsection
