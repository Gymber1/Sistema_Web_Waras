@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Gestionar')

@section('content')
@php $isRevista = $special->type === 'revista'; @endphp
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
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Gestiona el contenido vinculado a esta colección especial.</p>
        </div>
        @if($special->cover_image_path)
        <img src="{{ Storage::url($special->cover_image_path) }}"
            class="w-12 h-12 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm flex-shrink-0"
            onerror="this.style.display='none'">
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 dark:border-dark-border flex items-center justify-between bg-slate-50/60 dark:bg-slate-800/30">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-300 text-sm">Contenido asignado</h3>
                    <span id="counter-badge"
                        class="px-2.5 py-1 text-xs font-semibold rounded-md {{ $isRevista ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20' }}">
                        {{ $special->books->count() }} {{ $isRevista ? 'revistas' : 'libros' }}
                    </span>
                </div>

                <div id="assigned-list" class="divide-y divide-slate-50 dark:divide-dark-border max-h-[480px] overflow-y-auto">
                    @forelse($special->books as $item)
                    <div class="assigned-item flex items-center justify-between px-5 py-3 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 group transition-colors" data-id="{{ $item->id }}">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate pr-3">{{ $item->title }}</span>
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

        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden sticky top-6">
                <div class="px-5 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/60 dark:bg-slate-800/30">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-300 text-sm">Agregar {{ $isRevista ? 'revista' : 'libro' }}</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" id="search-available" placeholder="Buscar por título..."
                            oninput="filterAvailable(this.value)"
                            class="w-full pl-8 pr-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    </div>

                    <div id="available-list" class="max-h-[380px] overflow-y-auto divide-y divide-slate-50 dark:divide-dark-border border border-slate-100 dark:border-dark-border rounded-lg">
                        @forelse($available as $item)
                        <div class="available-item flex items-center justify-between px-4 py-2.5 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-colors cursor-pointer group"
                             data-id="{{ $item->id }}" data-title="{{ $item->title }}"
                             data-title-lower="{{ strtolower($item->title) }}"
                             onclick="addItem({{ $special->id }}, {{ $item->id }}, '{{ addslashes($item->title) }}', this)">
                            <span class="text-sm text-slate-700 dark:text-slate-300 truncate pr-2 group-hover:text-brand-700 dark:group-hover:text-brand-300 group-hover:font-medium transition-colors">{{ $item->title }}</span>
                            <i data-lucide="plus" class="w-3.5 h-3.5 text-brand-500 flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        @empty
                        <div class="py-8 text-center text-slate-400 dark:text-slate-500 text-sm">
                            No hay {{ $isRevista ? 'revistas' : 'libros' }} disponibles.
                        </div>
                        @endforelse
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

function updateCounter() {
    const count = document.querySelectorAll('.assigned-item').length;
    const badge = document.getElementById('counter-badge');
    badge.textContent = count + ' ' + (isRevista ? (count === 1 ? 'revista' : 'revistas') : (count === 1 ? 'libro' : 'libros'));
}

function showFeedback(msg, ok) {
    const el = document.getElementById('feedback');
    el.textContent = msg;
    el.className = 'px-4 py-2.5 rounded-lg text-sm font-medium text-center ' + (ok ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400');
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 2500);
}

function filterAvailable(q) {
    q = q.toLowerCase().trim();
    document.querySelectorAll('.available-item').forEach(el => {
        el.style.display = (!q || el.dataset.titleLower.includes(q)) ? '' : 'none';
    });
}

function addItem(specialId, bookId, title, rowEl) {
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
            rowEl.style.display = 'none';
            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.remove();
            const list = document.getElementById('assigned-list');
            const div = document.createElement('div');
            div.className = 'assigned-item flex items-center justify-between px-5 py-3 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 group transition-colors';
            div.dataset.id = bookId;
            div.innerHTML = `
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate pr-3">${title}</span>
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
            const availableItem = document.querySelector(`.available-item[data-id="${bookId}"]`);
            if (availableItem) {
                availableItem.style.display = '';
                availableItem.style.pointerEvents = '';
                availableItem.style.opacity = '';
            }
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
</script>
@endsection
