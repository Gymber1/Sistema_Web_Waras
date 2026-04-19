@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Editar')

@section('content')
@php $currentType = old('type', $special->type ?? 'libro'); @endphp

<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.specials') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Editar</h1>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">ESPECIAL</span>
                <span class="text-slate-400 font-normal text-lg">— {{ $special->title }}</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Modifica los datos de esta colección especial.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.specials.update', $special) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">

            {{-- Título --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Título <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $special->title) }}" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Descripción</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-y">{{ old('description', $special->description) }}</textarea>
            </div>

            {{-- Tipo de Especial --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3">Tipo de Especial <span class="text-red-500">*</span></label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all {{ $currentType === 'libro' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-emerald-300' }}" id="label-libro">
                        <input type="radio" name="type" value="libro" onchange="toggleType(this)"
                            {{ $currentType === 'libro' ? 'checked' : '' }}
                            class="accent-emerald-600 w-4 h-4">
                        <div>
                            <span class="text-sm font-bold text-slate-800">Libros</span>
                            <p class="text-xs text-slate-400 mt-0.5">Agrupa libros del catálogo</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all {{ $currentType === 'revista' ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-300' }}" id="label-revista">
                        <input type="radio" name="type" value="revista" onchange="toggleType(this)"
                            {{ $currentType === 'revista' ? 'checked' : '' }}
                            class="accent-blue-600 w-4 h-4">
                        <div>
                            <span class="text-sm font-bold text-slate-800">Revistas</span>
                            <p class="text-xs text-slate-400 mt-0.5">Agrupa revistas del catálogo</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Selector de Libros --}}
            <div id="section-libro" {{ $currentType !== 'libro' ? 'style=display:none' : '' }}>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Libros asociados</label>
                <div id="chips-books" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px] mb-2">
                    @if($currentType === 'libro')
                        @foreach($special->books as $book)
                        <span class="chip flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full">
                            {{ $book->title }}
                            <button type="button" onclick="this.closest('.chip').remove()" class="hover:text-red-600 font-bold text-base leading-none ml-1">×</button>
                            <input type="hidden" name="book_ids[]" value="{{ $book->id }}">
                        </span>
                        @endforeach
                    @endif
                </div>
                <div class="relative">
                    <input type="text" id="search-books" placeholder="Buscar libro..."
                        oninput="filterDropdown('dropdown-books', this.value)" onfocus="showDropdown('dropdown-books')"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">
                    <div id="dropdown-books" class="hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-64 overflow-y-auto">
                        @foreach($books as $book)
                        <button type="button" data-id="{{ $book->id }}" data-name="{{ $book->title }}"
                            onclick="addChip(this, 'chips-books', 'search-books', 'dropdown-books', 'emerald')"
                            class="doc-option w-full text-left px-4 py-2.5 hover:bg-emerald-50 text-sm border-b border-slate-50 last:border-0 flex items-center gap-2">
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 shrink-0">L</span>
                            {{ $book->title }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Selector de Revistas --}}
            <div id="section-revista" {{ $currentType !== 'revista' ? 'style=display:none' : '' }}>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Revistas asociadas</label>
                <div id="chips-magazines" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px] mb-2">
                    @if($currentType === 'revista')
                        @foreach($special->books as $mag)
                        <span class="chip flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                            {{ $mag->title }}
                            <button type="button" onclick="this.closest('.chip').remove()" class="hover:text-red-600 font-bold text-base leading-none ml-1">×</button>
                            <input type="hidden" name="book_ids[]" value="{{ $mag->id }}">
                        </span>
                        @endforeach
                    @endif
                </div>
                <div class="relative">
                    <input type="text" id="search-magazines" placeholder="Buscar revista..."
                        oninput="filterDropdown('dropdown-magazines', this.value)" onfocus="showDropdown('dropdown-magazines')"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50">
                    <div id="dropdown-magazines" class="hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-64 overflow-y-auto">
                        @foreach($magazines as $mag)
                        <button type="button" data-id="{{ $mag->id }}" data-name="{{ $mag->title }}"
                            onclick="addChip(this, 'chips-magazines', 'search-magazines', 'dropdown-magazines', 'blue')"
                            class="doc-option w-full text-left px-4 py-2.5 hover:bg-blue-50 text-sm border-b border-slate-50 last:border-0 flex items-center gap-2">
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 shrink-0">R</span>
                            {{ $mag->title }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Estado --}}
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $special->is_active) ? 'checked' : '' }}
                    class="w-5 h-5 accent-emerald-600 rounded">
                <label for="is_active" class="text-sm font-bold text-slate-700 cursor-pointer">Activo (visible en el portal)</label>
            </div>

        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.specials') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">Actualizar Especial</button>
        </div>
    </form>
</div>

<script>
function toggleType(radio) {
    const isLibro = radio.value === 'libro';
    document.getElementById('section-libro').style.display   = isLibro ? '' : 'none';
    document.getElementById('section-revista').style.display = isLibro ? 'none' : '';
    if (isLibro) {
        document.getElementById('chips-magazines').innerHTML = '';
    } else {
        document.getElementById('chips-books').innerHTML = '';
    }
    document.getElementById('label-libro').className   = isLibro
        ? 'flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all border-emerald-500 bg-emerald-50'
        : 'flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all border-slate-200 hover:border-emerald-300';
    document.getElementById('label-revista').className = !isLibro
        ? 'flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all border-blue-500 bg-blue-50'
        : 'flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all border-slate-200 hover:border-blue-300';
}

function showDropdown(id) { document.getElementById(id).classList.remove('hidden'); }

function filterDropdown(dropdownId, q) {
    const dd = document.getElementById(dropdownId);
    dd.classList.toggle('hidden', q.length === 0);
    dd.querySelectorAll('.doc-option').forEach(btn => {
        btn.style.display = btn.dataset.name.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
}

function addChip(btn, chipsId, searchId, dropdownId, color) {
    const id = btn.dataset.id, name = btn.dataset.name;
    const chips = document.getElementById(chipsId);
    if (chips.querySelector(`input[value="${id}"]`)) return;
    const chip = document.createElement('span');
    chip.className = `chip flex items-center gap-1.5 px-3 py-1.5 bg-${color}-100 text-${color}-800 text-sm font-semibold rounded-full`;
    chip.innerHTML = `${name} <button type="button" onclick="this.closest('.chip').remove()" class="hover:text-red-600 font-bold text-base leading-none ml-1">×</button><input type="hidden" name="book_ids[]" value="${id}">`;
    chips.appendChild(chip);
    document.getElementById(searchId).value = '';
    document.getElementById(dropdownId).classList.add('hidden');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.getElementById('dropdown-books').classList.add('hidden');
        document.getElementById('dropdown-magazines').classList.add('hidden');
    }
});
</script>
@endsection
