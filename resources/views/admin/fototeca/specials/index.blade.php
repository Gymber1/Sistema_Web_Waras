@extends('layouts.admin')

@section('section', 'Fototeca > Especiales')

@section('content')
<div class="p-6 md:p-10 max-w-[1400px] mx-auto">

    <div id="toast" class="hidden mb-4 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold text-sm"></div>

    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Especiales</h1>
        <p class="text-slate-500 mt-1">Marca fotografías para destacarlas como "especiales" en el portal público de la Fototeca.</p>
    </div>

    {{-- Tabs (preparado para futuros tipos) --}}
    <div class="flex gap-2 mb-6 border-b border-slate-200">
        <button id="tab-fotografias"
            class="px-5 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-blue-500 text-blue-700 bg-white -mb-px">
            Fotografías
            <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">{{ $photos->where('is_special', true)->count() }} especiales</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-blue-500">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <span class="text-sm font-bold bg-blue-50 text-blue-700 px-4 py-2 rounded-lg">{{ $photos->count() }} fotografías</span>
            <input type="text" id="searchInput" placeholder="Buscar fotografía..."
                oninput="filterTable(this.value)"
                class="px-4 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-400 w-72">
        </div>

        <div class="overflow-x-auto">
            <table id="photosTable" class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Miniatura</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Título</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Fotógrafo</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Categoría</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Especial</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($photos as $photo)
                    <tr class="hover:bg-slate-50 transition-colors" data-name="{{ strtolower($photo->title) }}">
                        {{-- Miniatura horizontal --}}
                        <td class="py-3 px-6">
                            @if($photo->thumbnail_path || $photo->full_image_path)
                                <img src="{{ Storage::url($photo->thumbnail_path ?? $photo->full_image_path) }}"
                                     alt="{{ $photo->title }}"
                                     class="w-24 h-16 object-cover rounded-lg border border-slate-100">
                            @else
                                <div class="w-24 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xl border border-slate-200">📷</div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-sm font-semibold text-slate-800 max-w-[200px] truncate">{{ $photo->title }}</td>
                        <td class="py-3 px-6 text-sm text-slate-600">
                            {{ $photo->photographers->first()?->full_name ?? '—' }}
                        </td>
                        <td class="py-3 px-6 text-sm text-slate-600">
                            {{ $photo->categories->first()?->name ?? '—' }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <button type="button"
                                class="toggle-btn relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $photo->is_special ? 'bg-blue-500' : 'bg-slate-200' }}"
                                data-id="{{ $photo->id }}"
                                data-state="{{ $photo->is_special ? '1' : '0' }}"
                                data-url="{{ route('admin.fototeca.specials.toggle', $photo) }}"
                                title="{{ $photo->is_special ? 'Quitar de especiales' : 'Marcar como especial' }}">
                                <span class="toggle-knob inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $photo->is_special ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-16 text-center text-slate-400">No hay fotografías registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterTable(q) {
    document.querySelectorAll('#photosTable tbody tr[data-name]').forEach(row => {
        row.style.display = row.dataset.name.includes(q.toLowerCase()) ? '' : 'none';
    });
}

const csrfToken = '{{ csrf_token() }}';

document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const url   = this.dataset.url;
        const knob  = this.querySelector('.toggle-knob');
        const isOn  = this.dataset.state === '1';

        // Optimistic update
        this.dataset.state = isOn ? '0' : '1';
        this.classList.toggle('bg-blue-500', !isOn);
        this.classList.toggle('bg-slate-200', isOn);
        knob.classList.toggle('translate-x-6', !isOn);
        knob.classList.toggle('translate-x-1', isOn);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            const toast = document.getElementById('toast');
            toast.textContent = data.is_special ? '✓ Marcada como especial' : '✓ Desmarcada como especial';
            toast.classList.remove('hidden');
            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(() => toast.classList.add('hidden'), 2500);
        })
        .catch(() => {
            // Revert on error
            this.dataset.state = isOn ? '1' : '0';
            this.classList.toggle('bg-blue-500', isOn);
            this.classList.toggle('bg-slate-200', !isOn);
            knob.classList.toggle('translate-x-6', isOn);
            knob.classList.toggle('translate-x-1', !isOn);
        });
    });
});
</script>
@endsection
