@extends('layouts.admin')

@section('section', 'Biblioteca > Autores > Nuevo')

@section('content')
<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.authors') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">Agregar nuevo</h1>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">AUTOR</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Completa los campos y guarda para registrar el nuevo autor.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.authors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nombre completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nacionalidad</label>
                    <input type="text" name="nationality" value="{{ old('nationality') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Foto del autor</label>
                    <input type="file" name="photo" accept="image/*"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 file:font-semibold hover:file:bg-emerald-200">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Biografía</label>
                    <textarea name="biography" rows="4"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-y">{{ old('biography') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Libros asociados</label>
                    <div id="chips-books" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-books" placeholder="Buscar y agregar libro..."
                            oninput="filterDropdown(this,'dropdown-books')" onfocus="showDropdown('dropdown-books')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">
                        <div id="dropdown-books" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($books as $book)
                            <button type="button" data-id="{{ $book->id }}" data-name="{{ $book->title }}"
                                onclick="addChip(this,'chips-books','books')"
                                class="w-full text-left px-4 py-2.5 hover:bg-emerald-50 text-sm border-b border-slate-50 last:border-0">
                                {{ $book->title }} <span class="text-xs text-slate-400">({{ $book->document_type }})</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Categorías</label>
                    <div id="chips-categories" class="flex flex-wrap gap-2 p-3 border border-slate-300 rounded-xl bg-white min-h-[48px]"></div>
                    <div class="relative mt-2">
                        <input type="text" id="search-categories" placeholder="Buscar y agregar categoría..."
                            oninput="filterDropdown(this,'dropdown-categories')" onfocus="showDropdown('dropdown-categories')"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">
                        <div id="dropdown-categories" class="tag-dropdown hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                            @foreach($categories as $cat)
                            <button type="button" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}"
                                onclick="addChip(this,'chips-categories','categories')"
                                class="w-full text-left px-4 py-2.5 hover:bg-emerald-50 text-sm border-b border-slate-50 last:border-0">{{ $cat->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.authors') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">Cancelar</a>
            <button type="submit"
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">Guardar autor</button>
        </div>
    </form>
</div>
<script>
function removeChip(btn) { btn.closest('.chip').remove(); }
function showDropdown(id) { document.getElementById(id).classList.remove('hidden'); }
function filterDropdown(input, dropdownId) {
    const q = input.value.toLowerCase();
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden', q.length === 0);
    dropdown.querySelectorAll('button').forEach(btn => { btn.style.display = btn.dataset.name?.toLowerCase().includes(q) ? '' : 'none'; });
}
function addChip(btn, chipsId, field) {
    const id = btn.dataset.id, name = btn.dataset.name;
    const chips = document.getElementById(chipsId);
    if (chips.querySelector(`input[value="${id}"]`)) return;
    const chip = document.createElement('span');
    chip.className = 'chip flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full';
    chip.innerHTML = `${name} <button type="button" onclick="removeChip(this)" class="hover:text-red-600 font-bold text-base leading-none">×</button><input type="hidden" name="${field}[]" value="${id}">`;
    chips.appendChild(chip);
    const s = document.getElementById('search-' + field); if (s) s.value = '';
    document.getElementById('dropdown-' + field).classList.add('hidden');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) document.querySelectorAll('.tag-dropdown').forEach(d => d.classList.add('hidden'));
});
</script>
@endsection
