@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales > Gestionar')

@section('content')
@php $isRevista = $special->type === 'revista'; @endphp
<div class="p-6 md:p-10 max-w-[960px] mx-auto">

    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.biblioteca.specials.assign-books') }}"
            class="mt-1 p-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-black text-slate-900">{{ $special->title }}</h1>
                <span class="px-3 py-1 text-xs font-black uppercase rounded-full {{ $isRevista ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                    {{ $isRevista ? 'Revistas' : 'Libros' }}
                </span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Gestiona el contenido vinculado a esta colección especial.</p>
        </div>
        @if($special->cover_image_path)
        <img src="{{ Storage::url($special->cover_image_path) }}"
            class="w-14 h-14 object-cover rounded-xl border border-slate-200 shadow-sm flex-shrink-0"
            onerror="this.style.display='none'">
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Panel izquierdo: elementos asignados --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                    <h2 class="font-bold text-slate-700 text-sm">Contenido asignado</h2>
                    <span id="counter-badge"
                        class="px-2.5 py-1 text-xs font-bold rounded-full {{ $isRevista ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $special->books->count() }} {{ $isRevista ? 'revistas' : 'libros' }}
                    </span>
                </div>

                <div id="assigned-list" class="divide-y divide-slate-50 max-h-[480px] overflow-y-auto">
                    @forelse($special->books as $item)
                    <div class="assigned-item flex items-center justify-between px-5 py-3 hover:bg-slate-50 group" data-id="{{ $item->id }}">
                        <span class="text-sm font-semibold text-slate-700 truncate pr-3">{{ $item->title }}</span>
                        <button type="button"
                            onclick="removeItem({{ $special->id }}, {{ $item->id }}, this)"
                            class="flex-shrink-0 w-7 h-7 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @empty
                    <div id="empty-msg" class="py-12 text-center text-slate-400 text-sm">
                        No hay {{ $isRevista ? 'revistas' : 'libros' }} asignados aún.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Panel derecho: agregar --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-6">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                    <h2 class="font-bold text-slate-700 text-sm">Agregar {{ $isRevista ? 'revista' : 'libro' }}</h2>
                </div>
                <div class="p-5 space-y-3">
                    {{-- Buscador en vivo --}}
                    <input type="text" id="search-available" placeholder="Buscar por título..."
                        oninput="filterAvailable(this.value)"
                        class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50">

                    <div id="available-list" class="max-h-[380px] overflow-y-auto divide-y divide-slate-50 border border-slate-100 rounded-xl">
                        @forelse($available as $item)
                        <div class="available-item flex items-center justify-between px-4 py-2.5 hover:bg-emerald-50 transition-colors cursor-pointer group"
                             data-id="{{ $item->id }}" data-title="{{ $item->title }}"
                             data-title-lower="{{ strtolower($item->title) }}"
                             onclick="addItem({{ $special->id }}, {{ $item->id }}, '{{ addslashes($item->title) }}', this)">
                            <span class="text-sm text-slate-700 truncate pr-2 group-hover:text-emerald-800 group-hover:font-semibold">{{ $item->title }}</span>
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        @empty
                        <div class="py-8 text-center text-slate-400 text-sm">
                            No hay {{ $isRevista ? 'revistas' : 'libros' }} disponibles.
                        </div>
                        @endforelse
                    </div>

                    <div id="feedback" class="hidden px-4 py-2.5 rounded-xl text-sm font-semibold text-center"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
const assignUrl   = '/admin/biblioteca/specials/{{ $special->id }}/assign';
const unassignBase = '/admin/biblioteca/specials/{{ $special->id }}/books/';
const csrfToken   = '{{ csrf_token() }}';
const isRevista   = {{ $isRevista ? 'true' : 'false' }};

function updateCounter() {
    const count = document.querySelectorAll('.assigned-item').length;
    const badge = document.getElementById('counter-badge');
    badge.textContent = count + ' ' + (isRevista ? (count === 1 ? 'revista' : 'revistas') : (count === 1 ? 'libro' : 'libros'));
}

function showFeedback(msg, ok) {
    const el = document.getElementById('feedback');
    el.textContent = msg;
    el.className = 'px-4 py-2.5 rounded-xl text-sm font-semibold text-center ' + (ok ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700');
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
    // Deshabilitar mientras procesa
    rowEl.style.pointerEvents = 'none';
    rowEl.style.opacity = '0.5';

    fetch(assignUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ book_id: bookId }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Ocultar de disponibles
            rowEl.style.display = 'none';

            // Quitar mensaje vacío si existe
            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.remove();

            // Agregar a la lista asignada
            const list = document.getElementById('assigned-list');
            const div = document.createElement('div');
            div.className = 'assigned-item flex items-center justify-between px-5 py-3 hover:bg-slate-50 group';
            div.dataset.id = bookId;
            div.innerHTML = `
                <span class="text-sm font-semibold text-slate-700 truncate pr-3">${title}</span>
                <button type="button"
                    onclick="removeItem(${specialId}, ${bookId}, this)"
                    class="flex-shrink-0 w-7 h-7 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>`;
            list.appendChild(div);

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
    const title = row.querySelector('span').textContent.trim();

    row.style.opacity = '0.4';
    row.style.pointerEvents = 'none';

    fetch(unassignBase + bookId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            row.remove();
            updateCounter();
            showFeedback('Eliminado de la colección', true);

            // Restaurar en lista de disponibles si existe el elemento oculto
            const availableItem = document.querySelector(`.available-item[data-id="${bookId}"]`);
            if (availableItem) {
                availableItem.style.display = '';
                availableItem.style.pointerEvents = '';
                availableItem.style.opacity = '';
            }

            // Mostrar mensaje vacío si no quedan items
            if (document.querySelectorAll('.assigned-item').length === 0) {
                const list = document.getElementById('assigned-list');
                list.innerHTML = `<div id="empty-msg" class="py-12 text-center text-slate-400 text-sm">No hay ${isRevista ? 'revistas' : 'libros'} asignados aún.</div>`;
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
