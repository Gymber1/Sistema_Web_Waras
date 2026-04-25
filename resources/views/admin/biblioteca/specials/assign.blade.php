@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Agregar a Especiales')

@section('content')
<div class="p-6 md:p-10 max-w-[1200px] mx-auto">

    <div class="flex items-start gap-4 mb-6">
        <a href="{{ route('admin.biblioteca.specials') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900">Agregar a Especiales</h1>
            <p class="text-slate-500 text-sm mt-1">Selecciona una colección para gestionar su contenido.</p>
        </div>
    </div>

    @if($specials->isEmpty())
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center">
        <p class="text-amber-700 font-bold mb-2">No hay colecciones especiales creadas.</p>
        <a href="{{ route('admin.biblioteca.specials.create') }}"
            class="inline-block px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold transition-colors">
            Crear primera colección
        </a>
    </div>
    @else

    {{-- Buscador --}}
    <div class="mb-6">
        <input type="text" id="search-collections" placeholder="Buscar colección por nombre..."
            oninput="filterCollections(this.value)"
            class="w-full max-w-sm px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white shadow-sm">
    </div>

    {{-- Galería de tarjetas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="collections-grid">
        @foreach($specials as $special)
        @php $isRevista = $special->type === 'revista'; @endphp
        <div class="collection-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col"
             data-name="{{ strtolower($special->title) }}">

            {{-- Portada --}}
            <div class="relative h-40 bg-gradient-to-br {{ $isRevista ? 'from-blue-50 to-blue-100' : 'from-emerald-50 to-emerald-100' }} flex items-center justify-center overflow-hidden">
                @if($special->cover_image_path)
                <img src="{{ Storage::url($special->cover_image_path) }}"
                    class="w-full h-full object-cover"
                    onerror="this.style.display='none'">
                @else
                <svg class="w-16 h-16 {{ $isRevista ? 'text-blue-200' : 'text-emerald-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C6.5 6.253 2 9.75 2 14s4.5 7.747 10 7.747m0-13c5.5 0 10 3.503 10 7.747m-10-7.747V2"/>
                </svg>
                @endif
                <span class="absolute top-2 right-2 px-2 py-0.5 text-[10px] font-black uppercase rounded-full {{ $isRevista ? 'bg-blue-600 text-white' : 'bg-emerald-600 text-white' }}">
                    {{ $isRevista ? 'Revistas' : 'Libros' }}
                </span>
            </div>

            {{-- Info --}}
            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-black text-slate-800 text-sm leading-snug mb-1">{{ $special->title }}</h3>
                <p class="text-xs text-slate-400 mb-4">
                    <span class="font-bold text-slate-600">{{ $special->books_count }}</span>
                    {{ $isRevista ? ($special->books_count === 1 ? 'revista' : 'revistas') : ($special->books_count === 1 ? 'libro' : 'libros') }} asignados
                </p>
                <div class="mt-auto">
                    <a href="{{ route('admin.biblioteca.specials.manage', $special) }}"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Gestionar contenido
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @endif
</div>
<script>
function filterCollections(q) {
    q = q.toLowerCase().trim();
    document.querySelectorAll('.collection-card').forEach(card => {
        card.style.display = (!q || card.dataset.name.includes(q)) ? '' : 'none';
    });
}
</script>
@endsection
