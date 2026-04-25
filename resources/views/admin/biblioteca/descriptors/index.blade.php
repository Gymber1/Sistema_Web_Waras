@extends('layouts.admin')

@section('section', 'Biblioteca > Descriptores')

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
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Descriptores</h1>
        <p class="text-slate-500 mt-1">Palabras clave que actúan como etiquetas en Biblioteca Digital y Waras Editorial.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Formulario agregar --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-6">
                <h2 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4">Agregar descriptor</h2>
                <form action="{{ route('admin.biblioteca.descriptors.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Ej. historia, cultura, ancash"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        <p class="text-xs text-slate-400 mt-1.5">Se guardará en minúsculas automáticamente.</p>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-colors">
                        + Agregar descriptor
                    </button>
                </form>
            </div>
        </div>

        {{-- Lista de descriptores --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden border-t-4 border-emerald-500">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-bold bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg">{{ $descriptors->count() }} descriptores</span>
                    <input type="text" id="search-desc" placeholder="Buscar..."
                        oninput="filterTags(this.value)"
                        class="px-3 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-400 w-48">
                </div>

                <div class="p-5">
                    @if($descriptors->isEmpty())
                    <p class="text-center text-slate-400 py-8">No hay descriptores registrados.</p>
                    @else
                    <div id="tags-container" class="flex flex-wrap gap-2">
                        @foreach($descriptors as $descriptor)
                        <div class="tag-item flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-full transition-colors group"
                            data-name="{{ $descriptor->name }}">
                            <span class="text-sm font-semibold text-slate-700">{{ $descriptor->name }}</span>
                            @if($descriptor->books_count > 0)
                            <span class="text-[10px] font-bold text-slate-400 bg-white px-1.5 py-0.5 rounded-full">{{ $descriptor->books_count }}</span>
                            @endif
                            <form action="{{ route('admin.biblioteca.descriptors.destroy', $descriptor) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('¿Eliminar el descriptor «{{ addslashes($descriptor->name) }}»?')"
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
