@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Editar')

@section('content')
<div class="max-w-[720px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.biblioteca.specials') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Editar colección</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">ESPECIAL</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Modifica el nombre, tipo o portada de esta colección especial.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.biblioteca.specials.update', $special) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre de la colección <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $special->title) }}" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Tipo <span class="text-red-500">*</span></label>
                @php $hasItems = $special->books()->exists(); @endphp
                @if($hasItems)
                {{-- Tipo bloqueado: hay items asignados --}}
                <input type="hidden" name="type" value="{{ $special->type }}">
                <div class="flex gap-3 opacity-60 pointer-events-none select-none">
                    <div class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl flex-1 {{ $special->type === 'libro' ? 'border-brand-500 bg-brand-50 dark:bg-brand-500/10' : 'border-slate-200 dark:border-slate-700' }}">
                        <input type="radio" value="libro" {{ $special->type === 'libro' ? 'checked' : '' }} disabled class="accent-indigo-600 w-4 h-4">
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">Libros</span>
                    </div>
                    <div class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl flex-1 {{ $special->type === 'revista' ? 'border-blue-500 bg-blue-50 dark:bg-blue-500/10' : 'border-slate-200 dark:border-slate-700' }}">
                        <input type="radio" value="revista" {{ $special->type === 'revista' ? 'checked' : '' }} disabled class="accent-blue-600 w-4 h-4">
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">Revistas</span>
                    </div>
                </div>
                @php $itemCount = $special->books()->count(); @endphp
                <div class="mt-2 flex items-center justify-between gap-3 px-4 py-3 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl">
                    <div class="flex items-start gap-2 text-xs text-amber-700 dark:text-amber-400 min-w-0">
                        <i data-lucide="lock" class="w-3.5 h-3.5 flex-shrink-0 mt-0.5"></i>
                        <span>El tipo está bloqueado: esta colección tiene <strong>{{ $itemCount }} elemento{{ $itemCount !== 1 ? 's' : '' }}</strong> asignado{{ $itemCount !== 1 ? 's' : '' }}. Quítalos todos para poder cambiar el tipo.</span>
                    </div>
                    @php $clearMsg = 'Se eliminarán los ' . $itemCount . ' elemento' . ($itemCount !== 1 ? 's' : '') . ' de esta colección. Esta acción no se puede deshacer.'; @endphp
                    <form action="{{ route('admin.biblioteca.specials.clear', $special) }}" method="POST" class="flex-shrink-0">
                        @csrf @method('DELETE')
                        <button type="button"
                            onclick="confirmDelete(this.closest('form'), '{{ $clearMsg }}'); return false;"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-500 hover:bg-red-600 text-white transition-colors whitespace-nowrap">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            Limpiar colección
                        </button>
                    </form>
                </div>
                @else
                {{-- Tipo editable: colección vacía --}}
                <div class="flex gap-3" id="type-options">
                    <label id="label-libro" class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all flex-1 {{ old('type', $special->type) === 'libro' ? 'border-brand-500 bg-brand-50 dark:bg-brand-500/10' : 'border-slate-200 dark:border-slate-700 hover:border-brand-300' }}">
                        <input type="radio" name="type" value="libro" {{ old('type', $special->type) === 'libro' ? 'checked' : '' }} class="accent-indigo-600 w-4 h-4">
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">Libros</span>
                    </label>
                    <label id="label-revista" class="flex items-center gap-3 px-5 py-3.5 border-2 rounded-xl cursor-pointer transition-all flex-1 {{ old('type', $special->type) === 'revista' ? 'border-blue-500 bg-blue-50 dark:bg-blue-500/10' : 'border-slate-200 dark:border-slate-700 hover:border-blue-300' }}">
                        <input type="radio" name="type" value="revista" {{ old('type', $special->type) === 'revista' ? 'checked' : '' }} class="accent-blue-600 w-4 h-4">
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">Revistas</span>
                    </label>
                </div>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Imagen de portada</label>
                @if($special->cover_image_path)
                <div class="flex items-center justify-between gap-3 mb-3 p-3 bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 rounded-lg">
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="{{ Storage::url($special->cover_image_path) }}"
                            class="w-14 h-14 object-cover rounded-lg border border-brand-200 dark:border-brand-500/30 flex-shrink-0"
                            onerror="this.style.display='none'">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-brand-700 dark:text-brand-300">Imagen actual cargada</p>
                            <p class="text-xs text-brand-600 dark:text-brand-400 mt-0.5">Sube una nueva para reemplazarla</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.biblioteca.specials.cover.destroy', $special) }}" method="POST" class="flex-shrink-0">
                        @csrf @method('DELETE')
                        <button type="button"
                            onclick="confirmDelete(this.closest('form'), 'Se eliminará la imagen de portada. La colección quedará sin imagen.'); return false;"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 border border-red-200 dark:border-red-500/20 transition-colors">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            Eliminar foto
                        </button>
                    </form>
                </div>
                @endif
                <input type="file" name="cover_image" accept="image/*"
                    class="w-full px-3 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-500/10 dark:file:text-brand-400 file:font-semibold hover:file:bg-brand-100">
            </div>

        </div>

        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.biblioteca.specials') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all">Guardar cambios</button>
        </div>
    </form>
</div>
@push('scripts')
<script>
(function () {
    const opts = document.getElementById('type-options');
    if (!opts) return;

    const labelLibro   = document.getElementById('label-libro');
    const labelRevista = document.getElementById('label-revista');

    const activeLibro   = ['border-brand-500', 'bg-brand-50', 'dark:bg-brand-500/10'];
    const activeRevista = ['border-blue-500',  'bg-blue-50',  'dark:bg-blue-500/10'];
    const inactive      = ['border-slate-200', 'dark:border-slate-700'];

    function refresh() {
        const val = opts.querySelector('input[name="type"]:checked')?.value;

        activeLibro.forEach(c => labelLibro.classList.toggle(c, val === 'libro'));
        activeRevista.forEach(c => labelRevista.classList.toggle(c, val === 'revista'));
        inactive.forEach(c => {
            labelLibro.classList.toggle(c, val !== 'libro');
            labelRevista.classList.toggle(c, val !== 'revista');
        });
    }

    opts.querySelectorAll('input[name="type"]').forEach(r => r.addEventListener('change', refresh));
    refresh();
})();
</script>
@endpush
@endsection
