@extends('layouts.admin')

@section('section', 'Fototeca > Colecciones > Gestionar')

@section('content')
<div class="max-w-[960px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.fototeca.assign-collections', ['tipo' => $featuredType]) }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $special->title }}</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">Colección</span>
            </div>
            @if($featured)
            <p class="text-sm text-slate-600 dark:text-slate-300 mt-1 flex items-center gap-1.5">
                <i data-lucide="{{ $esDonadores ? 'heart-handshake' : 'user' }}" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                <span class="font-medium">{{ $featuredLabel }}:</span> {{ $featured }}
                <a href="{{ route('admin.fototeca.collections.edit', $special) }}"
                    class="ml-1 inline-flex items-center gap-1 px-2.5 py-1 bg-brand-500 hover:bg-brand-600 text-white rounded-md text-xs font-medium transition-colors flex-shrink-0">
                    <i data-lucide="user-check" class="w-3 h-3"></i>
                    Cambiar {{ strtolower($featuredLabel) }}
                </a>
            </p>
            @else
            <div class="flex items-center gap-2 mt-1.5">
                <p class="text-sm text-amber-600 dark:text-amber-400 flex items-center gap-1.5">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                    Sin {{ strtolower($featuredLabel) }} asignado
                </p>
                <a href="{{ route('admin.fototeca.collections.edit', $special) }}"
                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-brand-500 hover:bg-brand-600 text-white rounded-md text-xs font-medium transition-colors">
                    <i data-lucide="user-plus" class="w-3 h-3"></i>
                    Asignar {{ strtolower($featuredLabel) }}
                </a>
            </div>
            @endif
        </div>
        @if($special->cover_image_path)
        <img src="{{ Storage::url($special->cover_image_path) }}"
            class="w-12 h-12 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm flex-shrink-0"
            onerror="this.style.display='none'">
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Panel izquierdo: fotos asignadas --}}
        <div>
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 dark:border-dark-border flex items-center justify-between bg-slate-50/60 dark:bg-slate-800/30">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-300 text-sm">Contenido en la colección</h3>
                    <span id="counter-badge"
                        class="px-2.5 py-1 text-xs font-semibold rounded-md bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">
                        {{ $special->photos->count() }} items
                    </span>
                </div>

                <div id="assigned-list" class="divide-y divide-slate-50 dark:divide-dark-border max-h-[520px] overflow-y-auto">
                    @forelse($special->photos as $photo)
                    <div class="assigned-item flex items-center gap-3 px-5 py-3 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 group transition-colors" data-id="{{ $photo->id }}">
                        <div class="w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden bg-slate-100 dark:bg-slate-800">
                            @if($photo->thumbnail_url)
                                <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-slate-400\'><svg width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\'><path d=\'M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z\'/><circle cx=\'12\' cy=\'13\' r=\'4\'/></svg></div>'">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <i data-lucide="camera" class="w-4 h-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate">{{ $photo->title }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 truncate">
                                {{ ($esDonadores ? $photo->donors : $photo->photographers)->pluck('full_name')->join(', ') ?: '—' }}
                                @php $y = $photo->year_type === 'range' && $photo->year_from ? $photo->year_from.'–'.($photo->year_to ?? '?') : ($photo->year ?? null); @endphp
                                @if($y) · {{ $y }} @endif
                            </p>
                        </div>
                        <button type="button"
                            onclick="removeItem({{ $special->id }}, {{ $photo->id }}, this)"
                            class="flex-shrink-0 w-7 h-7 flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                    @empty
                    <div id="empty-msg" class="py-14 text-center text-slate-400 dark:text-slate-500 text-sm">
                        No hay fotografías asignadas aún.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Panel derecho: agregar --}}
        <div>
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden sticky top-6">
                <div class="px-5 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/60 dark:bg-slate-800/30">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-300 text-sm">Agregar catálogo</h3>
                </div>
                <div class="p-4 space-y-3">
                    {{-- Buscador --}}
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" id="search-available" placeholder="Buscar por título, {{ strtolower($featuredLabel) }}..."
                            oninput="filterAvailable(this.value)"
                            class="w-full pl-8 pr-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>

                    {{-- Tabs --}}
                    @if($featured)
                    <div class="flex gap-2">
                        <button type="button" id="tab-suggested" onclick="switchTab('suggested')"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-500 text-white transition-colors min-w-0" style="max-width:160px;" title="Sugeridos de {{ $featured }}">
                            <i data-lucide="check" class="w-3 h-3 flex-shrink-0"></i>
                            <span class="truncate">Sugeridos de {{ Str::limit($featured, 18) }}</span>
                        </button>
                        <button type="button" id="tab-all" onclick="switchTab('all')"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 transition-colors">
                            Todo el catálogo
                        </button>
                    </div>
                    @endif

                    {{-- Lista --}}
                    <div id="available-list" class="max-h-[360px] overflow-y-auto divide-y divide-slate-50 dark:divide-dark-border border border-slate-100 dark:border-dark-border rounded-lg">

                        {{-- Sugeridos --}}
                        <div id="section-suggested">
                            @forelse($suggested as $photo)
                            @php $year = $photo->year_type === 'range' && $photo->year_from ? $photo->year_from.'–'.($photo->year_to ?? '?') : ($photo->year ?? null); @endphp
                            <div class="available-item available-suggested flex items-center gap-3 px-3 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-colors cursor-pointer group"
                                 data-id="{{ $photo->id }}"
                                 data-title="{{ addslashes($photo->title) }}"
                                 data-photographer="{{ ($esDonadores ? $photo->donors : $photo->photographers)->pluck('full_name')->join(', ') }}"
                                 data-year="{{ $year }}"
                                 data-title-lower="{{ strtolower($photo->title.' '.$photo->photographers->pluck('full_name')->join(' ').' '.$photo->donors->pluck('full_name')->join(' ')) }}"
                                 onclick="addItem({{ $special->id }}, {{ $photo->id }}, '{{ addslashes($photo->title) }}', '{{ addslashes(($esDonadores ? $photo->donors : $photo->photographers)->pluck('full_name')->join(', ')) }}', '{{ $year }}', '{{ $photo->thumbnail_url ?? '' }}', this)">
                                <div class="w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden bg-slate-100 dark:bg-slate-800">
                                    @if($photo->thumbnail_url)
                                        <img src="{{ $photo->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-brand-400 text-xs font-bold">{{ $year ? substr($year, -2) : '?' }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 font-medium truncate group-hover:text-brand-700 dark:group-hover:text-brand-300">{{ $photo->title }}</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-xs text-slate-400 truncate">{{ ($esDonadores ? $photo->donors : $photo->photographers)->pluck('full_name')->first() ?: '—' }}</span>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 flex-shrink-0">Sugerido</span>
                                    </div>
                                </div>
                                <span class="flex-shrink-0 flex items-center gap-1 px-2.5 py-1.5 bg-brand-500 text-white rounded-lg text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                    <i data-lucide="plus" class="w-3 h-3"></i> Agregar
                                </span>
                            </div>
                            @empty
                            <div class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs">No hay sugerencias para este {{ strtolower($featuredLabel) }}.</div>
                            @endforelse
                        </div>

                        {{-- Todo el catálogo --}}
                        <div id="section-all" style="display:none">
                            @forelse($available as $photo)
                            @php $year = $photo->year_type === 'range' && $photo->year_from ? $photo->year_from.'–'.($photo->year_to ?? '?') : ($photo->year ?? null); @endphp
                            <div class="available-item available-all flex items-center gap-3 px-3 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-colors cursor-pointer group"
                                 data-id="{{ $photo->id }}"
                                 data-title="{{ addslashes($photo->title) }}"
                                 data-title-lower="{{ strtolower($photo->title.' '.$photo->photographers->pluck('full_name')->join(' ').' '.$photo->donors->pluck('full_name')->join(' ')) }}"
                                 onclick="addItem({{ $special->id }}, {{ $photo->id }}, '{{ addslashes($photo->title) }}', '{{ addslashes(($esDonadores ? $photo->donors : $photo->photographers)->pluck('full_name')->join(', ')) }}', '{{ $year }}', '{{ $photo->thumbnail_url ?? '' }}', this)">
                                <div class="w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden bg-slate-100 dark:bg-slate-800">
                                    @if($photo->thumbnail_url)
                                        <img src="{{ $photo->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs font-bold">{{ $year ? substr($year, -2) : '?' }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 font-medium truncate group-hover:text-brand-700 dark:group-hover:text-brand-300">{{ $photo->title }}</p>
                                    <span class="text-xs text-slate-400 truncate">{{ ($esDonadores ? $photo->donors : $photo->photographers)->pluck('full_name')->first() ?: '—' }}</span>
                                </div>
                                <span class="flex-shrink-0 flex items-center gap-1 px-2.5 py-1.5 bg-brand-500 text-white rounded-lg text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                    <i data-lucide="plus" class="w-3 h-3"></i> Agregar
                                </span>
                            </div>
                            @empty
                            <div class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs">No hay fotografías disponibles.</div>
                            @endforelse
                        </div>

                        <div id="no-results" style="display:none" class="py-6 text-center text-slate-400 text-xs">Sin resultados</div>
                    </div>

                    <div id="feedback" class="hidden px-4 py-2.5 rounded-lg text-sm font-medium text-center"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
const assignUrl    = '/admin/fototeca/assign-collections/{{ $special->id }}/assign';
const unassignBase = '/admin/fototeca/assign-collections/{{ $special->id }}/photos/';
const csrfToken    = '{{ csrf_token() }}';
const hasFeatured  = {{ $featured ? 'true' : 'false' }};
let activeTab      = 'suggested';

function switchTab(tab) {
    activeTab = tab;
    document.getElementById('section-suggested').style.display = tab === 'suggested' ? '' : 'none';
    document.getElementById('section-all').style.display       = tab === 'all' ? '' : 'none';
    const btnS = document.getElementById('tab-suggested');
    const btnA = document.getElementById('tab-all');
    if (btnS && btnA) {
        btnS.className = tab === 'suggested'
            ? 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-500 text-white transition-colors'
            : 'px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 transition-colors';
        btnA.className = tab === 'all'
            ? 'px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-500 text-white transition-colors'
            : 'px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 transition-colors';
    }
    filterAvailable(document.getElementById('search-available').value);
}

function updateCounter() {
    const count = document.querySelectorAll('.assigned-item').length;
    document.getElementById('counter-badge').textContent = count + ' items';
}

function showFeedback(msg, ok) {
    const el = document.getElementById('feedback');
    el.textContent = msg;
    el.className = 'px-4 py-2.5 rounded-lg text-sm font-medium text-center ' + (ok
        ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400'
        : 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400');
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 2500);
}

function filterAvailable(q) {
    q = q.toLowerCase().trim();
    const selector = activeTab === 'suggested' ? '.available-suggested' : '.available-all';
    let visible = 0;
    document.querySelectorAll(selector).forEach(el => {
        const match = !q || el.dataset.titleLower.includes(q);
        el.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('no-results').style.display = (visible === 0 && q) ? '' : 'none';
}

function addItem(specialId, photoId, title, photographer, year, cover, rowEl) {
    rowEl.style.pointerEvents = 'none';
    rowEl.style.opacity = '0.5';

    fetch(assignUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ photo_id: photoId }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll(`.available-item[data-id="${photoId}"]`).forEach(el => el.style.display = 'none');
            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.remove();
            const list = document.getElementById('assigned-list');
            const div = document.createElement('div');
            div.className = 'assigned-item flex items-center gap-3 px-5 py-3 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 group transition-colors';
            div.dataset.id = photoId;
            const thumbHtml = cover
                ? `<img src="${cover}" alt="" class="w-full h-full object-cover">`
                : `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-400"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>`;
            div.innerHTML = `
                <div class="w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden bg-slate-200 dark:bg-slate-700 flex items-center justify-center">${thumbHtml}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate">${title}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 truncate">${photographer || '—'}${year ? ' · ' + year : ''}</p>
                </div>
                <button type="button" onclick="removeItem(${specialId}, ${photoId}, this)"
                    class="flex-shrink-0 w-7 h-7 flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </button>`;
            list.appendChild(div);
            if (window.lucide) lucide.createIcons();
            updateCounter();
            showFeedback('Fotografía agregada correctamente', true);
        }
    })
    .catch(() => {
        rowEl.style.pointerEvents = '';
        rowEl.style.opacity = '';
        showFeedback('Error al agregar', false);
    });
}

function removeItem(specialId, photoId, btn) {
    const row = btn.closest('.assigned-item');
    row.style.opacity = '0.4';
    row.style.pointerEvents = 'none';

    fetch(unassignBase + photoId, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            row.remove();
            updateCounter();
            showFeedback('Fotografía quitada de la colección', true);
            document.querySelectorAll(`.available-item[data-id="${photoId}"]`).forEach(el => {
                el.style.pointerEvents = '';
                el.style.opacity = '';
                const isInActive = activeTab === 'suggested'
                    ? el.classList.contains('available-suggested')
                    : el.classList.contains('available-all');
                el.style.display = (isInActive || !hasFeatured) ? '' : 'none';
            });
            if (document.querySelectorAll('.assigned-item').length === 0) {
                document.getElementById('assigned-list').innerHTML =
                    `<div id="empty-msg" class="py-14 text-center text-slate-400 dark:text-slate-500 text-sm">No hay fotografías asignadas aún.</div>`;
            }
        }
    })
    .catch(() => {
        row.style.opacity = '';
        row.style.pointerEvents = '';
        showFeedback('Error al quitar la fotografía', false);
    });
}

if (!hasFeatured) switchTab('all');
</script>
@endsection
