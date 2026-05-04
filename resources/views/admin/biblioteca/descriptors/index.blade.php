@extends('layouts.admin')

@section('section', 'Biblioteca > Descriptores')

@section('content')
<div class="max-w-[900px] mx-auto">

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Descriptores</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Biblioteca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Descriptores</span>
            </div>
        </div>
        <button onclick="openModal('modal-create')"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30 whitespace-nowrap">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Agregar Descriptor
        </button>
    </div>

    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="bulk-bar"></div>
        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $descriptors->total() }} descriptores</span>
            <div class="relative w-full sm:w-60">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" id="search-input" placeholder="Buscar descriptores..."
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="table-descriptors" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Libros</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($descriptors as $descriptor)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group desc-row"
                        data-name="{{ strtolower($descriptor->name) }}">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $descriptor->id }}"></td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 dark:text-white">{{ $descriptor->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($descriptor->books_count > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">
                                    {{ $descriptor->books_count }}
                                </span>
                            @else
                                <span class="text-slate-400 dark:text-slate-500 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button
                                    onclick="openEditModal({{ $descriptor->id }}, '{{ addslashes($descriptor->name) }}')"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.biblioteca.descriptors.destroy', $descriptor) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar el descriptor «{{ addslashes($descriptor->name) }}»?'); return false;"
                                        class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i data-lucide="tag" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay descriptores registrados</p>
                                <button onclick="openModal('modal-create')" class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Agregar el primero →</button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-admin-pagination :paginator="$descriptors" />
    </div>
</div>

<script>
document.getElementById('search-input').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.desc-row').forEach(row => {
        row.style.display = row.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>
@endsection

@push('modals')
<div id="modal-create" class="hidden fixed inset-0 z-[9998] overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-create')"></div>
    <div class="relative bg-white dark:bg-dark-surface rounded-2xl shadow-2xl w-full max-w-md border border-slate-200/50 dark:border-dark-border">
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100 dark:border-dark-border">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Agregar Descriptor</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Se guardará en minúsculas automáticamente.</p>
            </div>
            <button onclick="closeModal('modal-create')" class="p-2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('admin.biblioteca.descriptors.store') }}" method="POST" class="p-8 space-y-5">
            @csrf
            @if($errors->any())
            <div class="flex items-start gap-3 px-4 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
                <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Ej. historia, cultura, ancash"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-create')"
                    class="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-lg shadow-brand-500/30 rounded-lg transition-all flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    Guardar
                </button>
            </div>
        </form>
    </div>
    </div>
</div>

{{-- ===== MODAL EDITAR DESCRIPTOR ===== --}}
<div id="modal-edit" class="hidden fixed inset-0 z-[9998] overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-edit')"></div>
    <div class="relative bg-white dark:bg-dark-surface rounded-2xl shadow-2xl w-full max-w-md border border-slate-200/50 dark:border-dark-border">
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100 dark:border-dark-border">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Editar Descriptor</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Se guardará en minúsculas automáticamente.</p>
            </div>
            <button onclick="closeModal('modal-edit')" class="p-2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="edit-form" method="POST" class="p-8 space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                <input type="text" id="edit-name" name="name" required
                    placeholder="Ej. historia, cultura, ancash"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-edit')"
                    class="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-lg shadow-brand-500/30 rounded-lg transition-all flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function openEditModal(id, name) {
    document.getElementById('edit-form').action = `/admin/biblioteca/descriptors/${id}`;
    document.getElementById('edit-name').value = name;
    openModal('modal-edit');
}

@if($errors->any())
    openModal('modal-create');
@endif
</script>
@endpush
