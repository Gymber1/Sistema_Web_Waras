@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Gestionar')

@section('content')
<div class="max-w-[960px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.biblioteca.specials.assign-books') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $special->title }}</h2>
                @if($isRevista)
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">Revistas</span>
                @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">Libros</span>
                @endif
            </div>
            @if($featuredAuthor)
            <p class="text-sm text-slate-600 dark:text-slate-300 mt-1 flex items-center gap-1.5">
                <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                <span class="font-medium">Autor:</span> {{ $featuredAuthor }}
                <a href="{{ route('admin.biblioteca.specials.edit', $special) }}"
                    class="ml-1 inline-flex items-center gap-1 px-2.5 py-1 bg-brand-500 hover:bg-brand-600 text-white rounded-md text-xs font-medium transition-colors flex-shrink-0">
                    <i data-lucide="user-check" class="w-3 h-3"></i>
                    Cambiar autor
                </a>
            </p>
            @else
            <div class="flex items-center gap-2 mt-1.5">
                <p class="text-sm text-amber-600 dark:text-amber-400 flex items-center gap-1.5">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                    Sin autor asignado
                </p>
                <a href="{{ route('admin.biblioteca.specials.edit', $special) }}"
                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-brand-500 hover:bg-brand-600 text-white rounded-md text-xs font-medium transition-colors">
                    <i data-lucide="user-plus" class="w-3 h-3"></i>
                    Asignar autor
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

        {{-- Panel izquierdo: contenido asignado --}}
        <div>
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 dark:border-dark-border flex items-center justify-between bg-slate-50/60 dark:bg-slate-800/30">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-300 text-sm">Contenido en la colección</h3>
                    <span id="counter-badge"
                        class="px-2.5 py-1 text-xs font-semibold rounded-md {{ $isRevista ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20' }}">
                        {{ $special->books->count() }} items
                    </span>
                </div>

                <div id="assigned-list" class="divide-y divide-slate-50 dark:divide-dark-border max-h-[520px] overflow-y-auto">
                    @forelse($special->books as $item)
                    <div class="assigned-item flex items-center gap-3 px-5 py-3 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 group transition-colors" data-id="{{ $item->id }}">
                        <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center text-xs font-bold text-white"
                             style="background: {{ $isRevista ? '#3b82f6' : '#ef4444' }};">
                            {{ $isRevista ? 'R' : 'L' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate">{{ $item->title }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 truncate">
                                {{ $item->authors->pluck('name')->join(', ') ?: '—' }}
                                @if($item->publication_year) · {{ $item->publication_year }} @endif
                            </p>
                        </div>
                        <button type="button"
                            onclick="removeItem({{ $special->id }}, {{ $item->id }}, this)"
                            class="flex-shrink-0 w-7 h-7 flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                    @empty
                    <div id="empty-msg" class="py-14 text-center text-slate-400 dark:text-slate-500 text-sm">
                        No hay {{ $isRevista ? 'revistas' : 'libros' }} asignados aún.
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
                        <input type="text" id="search-available" placeholder="Buscar por título, autor o palabra clave..."
                            oninput="filterAvailable(this.value)"
                            class="w-full pl-8 pr-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>

                    {{-- Tabs: Sugeridos / Todo --}}
                    @if($featuredAuthor)
                    <div class="flex gap-2" id="catalog-tabs">
                        <button type="button" id="tab-suggested"
                            onclick="switchTab('suggested')"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-brand-500 text-white min-w-0 truncate" style="max-width:160px;" title="Sugeridos de {{ $featuredAuthor }}">
                            <i data-lucide="check" class="w-3 h-3 flex-shrink-0"></i>
                            <span class="truncate">Sugeridos de {{ Str::limit($featuredAuthor, 18) }}</span>
                        </button>
                        <button type="button" id="tab-all"
                            onclick="switchTab('all')"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600">
                            Todo el catálogo
                        </button>
                    </div>
                    @endif

                    {{-- Lista de disponibles --}}
                    <div id="available-list" class="max-h-[360px] overflow-y-auto divide-y divide-slate-50 dark:divide-dark-border border border-slate-100 dark:border-dark-border rounded-lg">

                        {{-- Sugeridos --}}
                        <div id="section-suggested">
                            @forelse($suggested as $item)
                            <div class="available-item available-suggested flex items-center gap-3 px-3 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-colors cursor-pointer group"
                                 data-id="{{ $item->id }}"
                                 data-title="{{ addslashes($item->title) }}"
                                 data-author="{{ $item->authors->pluck('name')->join(', ') }}"
                                 data-year="{{ $item->publication_year }}"
                                 data-cover="{{ $item->cover_image_path ? Storage::url($item->cover_image_path) : '' }}"
                                 data-title-lower="{{ strtolower($item->title . ' ' . $item->authors->pluck('name')->join(' ')) }}"
                                 onclick="addItem({{ $special->id }}, {{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->authors->pluck('name')->join(', ')) }}', '{{ $item->publication_year }}', '{{ $item->cover_image_path ? Storage::url($item->cover_image_path) : '' }}', this)">
                                <div class="w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden bg-brand-50 dark:bg-brand-500/10">
                                    @if($item->cover_image_path)
                                        <img src="{{ Storage::url($item->cover_image_path) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-brand-400">{{ $item->publication_year ? substr($item->publication_year, -2) : '?' }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 font-medium truncate group-hover:text-brand-700 dark:group-hover:text-brand-300">{{ $item->title }}</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-xs text-slate-400 truncate">{{ $item->authors->pluck('name')->first() ?: '—' }}</span>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 flex-shrink-0">Sugerido</span>
                                    </div>
                                </div>
                                <span class="flex-shrink-0 flex items-center gap-1 px-2.5 py-1.5 bg-brand-500 text-white rounded-lg text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                    <i data-lucide="plus" class="w-3 h-3"></i> Agregar
                                </span>
                            </div>
                            @empty
                            <div id="empty-suggested" class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs">
                                No hay sugerencias para este autor.
                            </div>
                            @endforelse
                        </div>

                        {{-- Todo el catálogo --}}
                        <div id="section-all" style="display:none">
                            @forelse($available as $item)
                            <div class="available-item available-all flex items-center gap-3 px-3 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-colors cursor-pointer group"
                                 data-id="{{ $item->id }}"
                                 data-title="{{ addslashes($item->title) }}"
                                 data-author="{{ $item->authors->pluck('name')->join(', ') }}"
                                 data-year="{{ $item->publication_year }}"
                                 data-cover="{{ $item->cover_image_path ? Storage::url($item->cover_image_path) : '' }}"
                                 data-title-lower="{{ strtolower($item->title . ' ' . $item->authors->pluck('name')->join(' ')) }}"
                                 onclick="addItem({{ $special->id }}, {{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->authors->pluck('name')->join(', ')) }}', '{{ $item->publication_year }}', '{{ $item->cover_image_path ? Storage::url($item->cover_image_path) : '' }}', this)">
                                <div class="w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden bg-slate-100 dark:bg-slate-700">
                                    @if($item->cover_image_path)
                                        <img src="{{ Storage::url($item->cover_image_path) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-slate-400">{{ $item->publication_year ? substr($item->publication_year, -2) : '?' }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 font-medium truncate group-hover:text-brand-700 dark:group-hover:text-brand-300">{{ $item->title }}</p>
                                    <span class="text-xs text-slate-400 truncate">{{ $item->authors->pluck('name')->first() ?: '—' }}</span>
                                </div>
                                <span class="flex-shrink-0 flex items-center gap-1 px-2.5 py-1.5 bg-brand-500 text-white rounded-lg text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                    <i data-lucide="plus" class="w-3 h-3"></i> Agregar
                                </span>
                            </div>
                            @empty
                            <div class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs">
                                No hay {{ $isRevista ? 'revistas' : 'libros' }} disponibles.
                            </div>
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
const assignUrl    = '/admin/biblioteca/specials/{{ $special->id }}/assign';
const unassignBase = '/admin/biblioteca/specials/{{ $special->id }}/books/';
const csrfToken    = '{{ csrf_token() }}';
const isRevista    = {{ $isRevista ? 'true' : 'false' }};
const hasFeatured  = {{ $featuredAuthor ? 'true' : 'false' }};
let activeTab      = 'suggested';

function switchTab(tab) {
    activeTab = tab;
    document.getElementById('section-suggested').style.display = tab === 'suggested' ? '' : 'none';
    document.getElementById('section-all').style.display       = tab === 'all' ? '' : 'none';

    const btnS = document.getElementById('tab-suggested');
    const btnA = document.getElementById('tab-all');
    if (btnS && btnA) {
        btnS.className = tab === 'suggested'
            ? 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-brand-500 text-white'
            : 'px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200';
        btnA.className = tab === 'all'
            ? 'px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-brand-500 text-white'
            : 'px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200';
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

function addItem(specialId, bookId, title, author, year, cover, rowEl) {
    rowEl.style.pointerEvents = 'none';
    rowEl.style.opacity = '0.5';

    fetch(assignUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ book_id: bookId }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll(`.available-item[data-id="${bookId}"]`).forEach(el => el.style.display = 'none');
            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.remove();
            const list = document.getElementById('assigned-list');
            const color = isRevista ? '#3b82f6' : '#ef4444';
            const letter = isRevista ? 'R' : 'L';
            const thumbHtml = cover
                ? `<img src="${cover}" alt="" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<span class=\\'text-xs font-bold text-white\\'>${letter}</span>'">`
                : `<span class="text-xs font-bold text-white">${letter}</span>`;
            const div = document.createElement('div');
            div.className = 'assigned-item flex items-center gap-3 px-5 py-3 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 group transition-colors';
            div.dataset.id = bookId;
            div.innerHTML = `
                <div class="w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden flex items-center justify-center" style="background:${color}">${thumbHtml}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate">${title}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 truncate">${author || '—'}${year ? ' · ' + year : ''}</p>
                </div>
                <button type="button" onclick="removeItem(${specialId}, ${bookId}, this)"
                    class="flex-shrink-0 w-7 h-7 flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </button>`;
            list.appendChild(div);
            if (window.lucide) lucide.createIcons();
            updateCounter();
            showFeedback('Agregado correctamente', true);
        }
    })
    .catch(() => {
        rowEl.style.pointerEvents = '';
        rowEl.style.opacity = '';
        showFeedback('Error al agregar', false);
    });
}

function removeItem(specialId, bookId, btn) {
    const row = btn.closest('.assigned-item');
    row.style.opacity = '0.4';
    row.style.pointerEvents = 'none';

    fetch(unassignBase + bookId, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            row.remove();
            updateCounter();
            showFeedback('Eliminado de la colección', true);
            // Mostrar en las secciones disponibles, respetando visibilidad del tab
            document.querySelectorAll(`.available-item[data-id="${bookId}"]`).forEach(el => {
                el.style.pointerEvents = '';
                el.style.opacity = '';
                // Solo mostrar si pertenece al tab activo o si no hay tabs
                const isInActive = activeTab === 'suggested'
                    ? el.classList.contains('available-suggested')
                    : el.classList.contains('available-all');
                el.style.display = (isInActive || !hasFeatured) ? '' : 'none';
            });
            if (document.querySelectorAll('.assigned-item').length === 0) {
                document.getElementById('assigned-list').innerHTML =
                    `<div id="empty-msg" class="py-14 text-center text-slate-400 dark:text-slate-500 text-sm">No hay ${isRevista ? 'revistas' : 'libros'} asignados aún.</div>`;
            }
        }
    })
    .catch(() => {
        row.style.opacity = '';
        row.style.pointerEvents = '';
        showFeedback('Error al eliminar', false);
    });
}

// Si no hay autor, mostrar directo "Todo el catálogo"
if (!hasFeatured) switchTab('all');
</script>
@endsection
