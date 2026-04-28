@extends('layouts.admin')

@section('section', 'Fototeca > Especiales')

@section('content')
<div class="max-w-[1400px] mx-auto">

    {{-- Toast --}}
    <div id="toast" class="hidden fixed top-5 right-5 z-50 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium shadow-lg">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        <span id="toast-msg"></span>
    </div>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gestión de Especiales</h2>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-1">
                <span>Fototeca</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 dark:text-slate-200">Especiales</span>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">
            <i data-lucide="star" class="w-3.5 h-3.5"></i>
            {{ $photos->where('is_special', true)->count() }} especiales
        </span>
    </div>

    <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $photos->count() }} fotografías</span>
            <div class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" id="search-input" placeholder="Buscar fotografía..."
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Miniatura</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Fotógrafo</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Especial</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($photos as $photo)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors photo-row" data-name="{{ strtolower($photo->title) }}">
                        <td class="px-6 py-3">
                            @if($photo->thumbnail_url)
                                <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}"
                                    class="w-20 h-14 object-cover rounded-lg border border-slate-100 dark:border-slate-700">
                            @else
                                <div class="w-20 h-14 bg-slate-100 dark:bg-slate-700/50 rounded-lg flex items-center justify-center text-slate-400 dark:text-slate-500 border border-slate-200 dark:border-slate-600">
                                    <i data-lucide="image" class="w-5 h-5"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-3 max-w-[200px]">
                            <span class="font-semibold text-slate-800 dark:text-white truncate block photo-title">{{ $photo->title }}</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                            {{ $photo->photographers->first()?->full_name ?? '—' }}
                        </td>
                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                            {{ $photo->categories->first()?->name ?? '—' }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <button type="button"
                                class="toggle-btn relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500/50 {{ $photo->is_special ? 'bg-brand-500' : 'bg-slate-200 dark:bg-slate-600' }}"
                                data-id="{{ $photo->id }}"
                                data-state="{{ $photo->is_special ? '1' : '0' }}"
                                data-url="{{ route('admin.fototeca.specials.toggle', $photo) }}"
                                title="{{ $photo->is_special ? 'Quitar de especiales' : 'Marcar como especial' }}">
                                <span class="toggle-knob inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $photo->is_special ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i data-lucide="camera" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay fotografías registradas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('search-input').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.photo-row').forEach(row => {
        row.style.display = row.querySelector('.photo-title').textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

const csrfToken = '{{ csrf_token() }}';

document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const url  = this.dataset.url;
        const knob = this.querySelector('.toggle-knob');
        const isOn = this.dataset.state === '1';

        this.dataset.state = isOn ? '0' : '1';
        this.classList.toggle('bg-brand-500', !isOn);
        this.classList.toggle('bg-slate-200', isOn);
        this.classList.toggle('dark:bg-slate-600', isOn);
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
            const msg   = document.getElementById('toast-msg');
            msg.textContent = data.is_special ? 'Marcada como especial' : 'Desmarcada como especial';
            toast.classList.remove('hidden');
            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(() => toast.classList.add('hidden'), 2500);
        })
        .catch(() => {
            this.dataset.state = isOn ? '1' : '0';
            this.classList.toggle('bg-brand-500', isOn);
            this.classList.toggle('bg-slate-200', !isOn);
            this.classList.toggle('dark:bg-slate-600', !isOn);
            knob.classList.toggle('translate-x-6', isOn);
            knob.classList.toggle('translate-x-1', !isOn);
        });
    });
});
</script>
@endsection
