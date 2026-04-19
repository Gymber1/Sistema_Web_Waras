@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales')

@section('content')
<div class="p-6 md:p-10 max-w-[1600px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Especiales</h1>
            <p class="text-slate-500 mt-1">Gestiona los libros y revistas destacados que aparecen en la sección Especiales del portal público.</p>
        </div>
        <button onclick="openModal('modal-special','create')"
            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar Especial
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-emerald-500">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <span class="text-sm font-bold bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg">{{ $specials->count() }} Registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Título</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Libro / Revista asociada</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Orden</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Estado</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($specials as $special)
                    <tr class="hover:bg-slate-50 group">
                        <td class="py-3 px-6 text-sm font-semibold text-slate-800">{{ $special->title }}</td>
                        <td class="py-3 px-6 text-sm text-slate-600">
                            @if($special->book)
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-xs font-bold mr-1">{{ $special->book->document_type }}</span>
                                {{ $special->book->title }}
                            @else
                                <span class="text-slate-400">Sin libro asociado</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-sm text-slate-600">{{ $special->order }}</td>
                        <td class="py-3 px-6">
                            @if($special->is_active)
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold">Activo</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold">Inactivo</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100">
                                <button onclick="openModal('modal-special','edit',{{ $special->toJson() }})"
                                    class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg bg-white border border-slate-100" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.biblioteca.specials.destroy', $special) }}" method="POST" onsubmit="return confirm('¿Eliminar este especial?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg bg-white border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-16 text-center text-slate-400">No hay especiales registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL ESPECIAL -->
<div id="modal-special" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-special')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl flex flex-col">
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100">
            <h2 id="modal-special-title" class="text-xl font-black text-slate-900">Agregar Especial</h2>
            <button onclick="closeModal('modal-special')" class="p-2 text-slate-400 hover:bg-slate-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
            </button>
        </div>

        <form id="form-special" method="POST" class="flex flex-col">
            @csrf
            <input type="hidden" name="_method" id="form-special-method" value="POST">

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Título del Especial <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="fs-title" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Seleccionar Libros y/o Revistas</label>
                    <p class="text-xs text-slate-400 mb-2">Mantén Ctrl/Cmd para seleccionar varios. El primero seleccionado será el principal.</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs font-bold text-slate-600 mb-1">Libros</p>
                            <select name="book_ids[]" id="fs-books" multiple
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 text-sm h-36">
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-600 mb-1">Revistas</p>
                            <select name="book_ids[]" id="fs-magazines" multiple
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 text-sm h-36">
                                @foreach($magazines as $mag)
                                    <option value="{{ $mag->id }}">{{ $mag->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Orden</label>
                    <input type="number" name="order" id="fs-order" min="0" value="0"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800">
                </div>

                <div class="flex items-center gap-3 mt-2">
                    <input type="checkbox" name="is_active" id="fs-active" value="1" checked class="w-5 h-5 accent-emerald-600 rounded">
                    <label for="fs-active" class="text-sm font-bold text-slate-700 cursor-pointer">Activo (visible en el portal)</label>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Descripción</label>
                    <textarea name="description" id="fs-description" rows="3"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 resize-none"></textarea>
                </div>
            </div>

            <div class="px-8 py-5 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modal-special')"
                    class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Cancelar</button>
                <button type="submit"
                    class="px-7 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg shadow-emerald-200">
                    <span id="modal-special-btn">Guardar Especial</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const storeUrl = "{{ route('admin.biblioteca.specials.store') }}";

function openModal(id, mode, special) {
    document.getElementById(id).classList.remove('hidden');
    if (mode === 'create') {
        document.getElementById('modal-special-title').textContent = 'Agregar Especial';
        document.getElementById('modal-special-btn').textContent   = 'Guardar Especial';
        document.getElementById('form-special').action             = storeUrl;
        document.getElementById('form-special-method').value       = 'POST';
        document.getElementById('form-special').reset();
        document.getElementById('fs-order').value  = '0';
        document.getElementById('fs-active').checked = true;
    } else {
        document.getElementById('modal-special-title').textContent = 'Editar Especial';
        document.getElementById('modal-special-btn').textContent   = 'Actualizar Especial';
        document.getElementById('form-special').action             = `/admin/biblioteca/specials/${special.id}`;
        document.getElementById('form-special-method').value       = 'PUT';
        document.getElementById('fs-title').value       = special.title ?? '';
        document.getElementById('fs-order').value       = special.order ?? 0;
        document.getElementById('fs-description').value = special.description ?? '';
        document.getElementById('fs-active').checked    = special.is_active == 1;
        if (special.book_id) {
            const sel = document.getElementById('fs-books');
            for (const opt of sel.options) opt.selected = (parseInt(opt.value) === special.book_id);
        }
    }
}

function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
@endsection
