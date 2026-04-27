@extends('layouts.admin')

@section('section', 'Fototeca > Etiquetas')

@section('content')
<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Etiquetas</h1>
        <p class="text-slate-500 mt-1">Palabras clave visibles en la galería pública de la Fototeca para filtrar fotografías.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Formulario agregar --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-6">
                <h2 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4">Agregar etiqueta</h2>
                <form action="{{ route('admin.fototeca.tags.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Ej. huaraz, siglo xx, retrato"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <p class="text-xs text-slate-400 mt-1.5">Se guardará en minúsculas automáticamente.</p>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-colors">
                        + Agregar etiqueta
                    </button>
                </form>
            </div>
        </div>

        {{-- Lista de etiquetas --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden border-t-4 border-blue-500">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-bold bg-blue-50 text-blue-700 px-4 py-2 rounded-lg">{{ $tags->count() }} etiquetas</span>
                    <input type="text" id="search-tag" placeholder="Buscar..."
                        oninput="filterTags(this.value)"
                        class="px-3 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-400 w-48">
                </div>

                <div class="p-5">
                    @if($tags->isEmpty())
                    <p class="text-center text-slate-400 py-8">No hay etiquetas registradas.</p>
                    @else
                    <div id="tags-container" class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <div class="tag-item flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-full transition-colors group"
                            data-name="{{ $tag->name }}">
                            <span class="text-sm font-semibold text-slate-700">{{ $tag->name }}</span>
                            @if($tag->photos_count > 0)
                            <span class="text-[10px] font-bold text-slate-400 bg-white px-1.5 py-0.5 rounded-full">{{ $tag->photos_count }}</span>
                            @endif
                            <form action="{{ route('admin.fototeca.tags.destroy', $tag) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('¿Eliminar la etiqueta «{{ addslashes($tag->name) }}»?')"
                                    class="text-slate-400 hover:text-red-500 font-bold text-base leading-none ml-0.5 opacity-0 group-hover:opacity-100 transition-opacity"
                                    title="Eliminar">×</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function filterTags(q) {
    document.querySelectorAll('#tags-container .tag-item').forEach(tag => {
        tag.style.display = tag.dataset.name.includes(q.toLowerCase()) ? '' : 'none';
    });
}
</script>
@endsection
