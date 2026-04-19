@extends('layouts.admin')

@section('section', 'Fototeca > Fotógrafos')

@section('content')
<div class="p-6 md:p-10 max-w-[1600px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl font-semibold text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Fotógrafos</h1>
            <p class="text-slate-500 mt-1">Administra todos los fotógrafos registrados en el archivo.</p>
        </div>
        <a href="{{ route('admin.fototeca.photographers.create') }}"
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar Fotógrafo
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-blue-500">
        <div class="p-5 border-b border-slate-100 flex flex-wrap justify-between items-center gap-4">
            <div class="relative w-full sm:w-80">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input id="search-input" type="text" placeholder="Buscar fotógrafos..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <span class="text-sm font-bold bg-blue-50 text-blue-700 px-4 py-2 rounded-lg">{{ $photographers->count() }} Registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Foto</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre Completo</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Fotografías</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Nac. / Fallec.</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    {{-- Fila nueva --}}
                    <tr id="new-photo-row" class="hidden bg-blue-50/60 border-b-2 border-blue-200">
                        <td colspan="5" class="py-4 px-6">
                            <form action="{{ route('admin.fototeca.photographers.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                                        <input type="text" name="full_name" required placeholder="Ej. Juan Ríos Sánchez"
                                            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Nacimiento</label>
                                        <input type="date" name="birth_date"
                                            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Fallecimiento</label>
                                        <input type="date" name="death_date"
                                            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Biografía</label>
                                        <textarea name="biography" rows="2" placeholder="Reseña biográfica..."
                                            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Foto</label>
                                        <input type="file" name="photo" accept="image/*"
                                            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-100 file:text-blue-700 file:font-semibold">
                                    </div>
                                </div>
                                <div class="flex gap-2 justify-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg">Guardar</button>
                                    <button type="button" onclick="hideNewRow()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-bold rounded-lg">Cancelar</button>
                                </div>
                            </form>
                        </td>
                    </tr>

                    @forelse($photographers as $p)
                    {{-- Fila vista --}}
                    <tr id="view-ph-{{ $p->id }}" class="hover:bg-slate-50 group photo-row transition-opacity">
                        <td class="py-3 px-6">
                            @if($p->photo_path)
                                <img src="{{ Storage::url($p->photo_path) }}" alt="{{ $p->full_name }}"
                                    class="w-10 h-10 rounded-full object-cover border border-slate-200 cursor-zoom-in hover:opacity-80 transition-opacity"
                                    onclick="openLightbox('{{ Storage::url($p->photo_path) }}', '{{ addslashes($p->full_name) }}')"
                                    onerror="this.style.display='none'">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-sm font-semibold text-slate-800 photo-name">{{ $p->full_name }}</td>
                        <td class="py-3 px-6 text-sm text-slate-600">{{ $p->photos_count }}</td>
                        <td class="py-3 px-6 text-sm text-slate-600">
                            {{ $p->birth_date ? $p->birth_date->format('Y') : '—' }}
                            @if($p->death_date) / {{ $p->death_date->format('Y') }} @endif
                        </td>
                        <td class="py-3 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100">
                                <a href="{{ route('admin.fototeca.photographers.edit', $p) }}"
                                    class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg bg-white border border-slate-100" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.fototeca.photographers.destroy', $p) }}" method="POST" onsubmit="return confirm('¿Eliminar este fotógrafo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg bg-white border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    {{-- Fila edición inline --}}
                    <tr id="edit-ph-{{ $p->id }}" class="hidden bg-amber-50/40 border-l-4 border-amber-400">
                        <td colspan="5" class="py-4 px-6">
                            <form action="{{ route('admin.fototeca.photographers.update', $p) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                                        <input type="text" name="full_name" value="{{ $p->full_name }}" required
                                            class="w-full px-3 py-2 bg-white border border-amber-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-400 outline-none font-semibold">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Nacimiento</label>
                                        <input type="date" name="birth_date" value="{{ $p->birth_date ? $p->birth_date->format('Y-m-d') : '' }}"
                                            class="w-full px-3 py-2 bg-white border border-amber-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-400 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Fallecimiento</label>
                                        <input type="date" name="death_date" value="{{ $p->death_date ? $p->death_date->format('Y-m-d') : '' }}"
                                            class="w-full px-3 py-2 bg-white border border-amber-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-400 outline-none">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Biografía</label>
                                        <textarea name="biography" rows="2"
                                            class="w-full px-3 py-2 bg-white border border-amber-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-400 outline-none resize-none">{{ $p->biography }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Nueva Foto</label>
                                        <input type="file" name="photo" accept="image/*"
                                            class="w-full px-3 py-2 bg-white border border-amber-300 rounded-lg text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-amber-100 file:text-amber-700 file:font-semibold">
                                    </div>
                                </div>
                                <div class="flex gap-2 justify-end">
                                    <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-lg">Actualizar</button>
                                    <button type="button" onclick="cancelPh({{ $p->id }})" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-bold rounded-lg">Cancelar</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-16 text-center text-slate-400">No hay fotógrafos registrados.</td></tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function showNewRow() {
    closeAllEdits();
    document.getElementById('new-photo-row').classList.remove('hidden');
    document.getElementById('new-photo-row').querySelector('input[name="full_name"]').focus();
}
function hideNewRow() { document.getElementById('new-photo-row').classList.add('hidden'); }

function editPh(id) {
    closeAllEdits();
    document.getElementById('view-ph-' + id).classList.add('opacity-30');
    document.getElementById('edit-ph-' + id).classList.remove('hidden');
    document.getElementById('edit-ph-' + id).querySelector('input[name="full_name"]').focus();
}
function cancelPh(id) {
    document.getElementById('view-ph-' + id).classList.remove('opacity-30');
    document.getElementById('edit-ph-' + id).classList.add('hidden');
}
function closeAllEdits() {
    document.querySelectorAll('[id^="edit-ph-"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id^="view-ph-"]').forEach(el => el.classList.remove('opacity-30'));
    hideNewRow();
}

document.getElementById('search-input').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.photo-row').forEach(row => {
        row.style.display = row.querySelector('.photo-name').textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection
