@extends('layouts.admin')

@section('section', 'Biblioteca > Especiales')

@section('content')
<div class="p-6 md:p-10 max-w-[1400px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Especiales</h1>
        <p class="text-slate-500 mt-1">Marca libros y revistas para destacarlos como "especiales" en el portal público.</p>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-2 mb-6 border-b border-slate-200">
        <button onclick="switchTab('libros')" id="tab-libros"
            class="tab-btn px-5 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-emerald-500 text-emerald-700 bg-white -mb-px">
            Libros
            <span class="ml-2 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-full">{{ $books->where('is_special', true)->count() }} especiales</span>
        </button>
        <button onclick="switchTab('revistas')" id="tab-revistas"
            class="tab-btn px-5 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-transparent text-slate-500 hover:text-slate-700 -mb-px">
            Revistas
            <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">{{ $magazines->where('is_special', true)->count() }} especiales</span>
        </button>
    </div>

    {{-- Tab: Libros --}}
    <div id="panel-libros">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-emerald-500">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <span class="text-sm font-bold bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg">{{ $books->count() }} libros</span>
                <input type="text" id="search-libros" placeholder="Buscar libro..."
                    oninput="filterTable('table-libros', this.value)"
                    class="px-4 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-400 w-64">
            </div>
            <div class="overflow-x-auto">
                <table id="table-libros" class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200">
                            <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Título</th>
                            <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Tipo</th>
                            <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Especial</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($books as $book)
                        <tr class="hover:bg-slate-50 transition-colors" data-name="{{ strtolower($book->title) }}">
                            <td class="py-3 px-6 text-sm font-semibold text-slate-800">{{ $book->title }}</td>
                            <td class="py-3 px-6">
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold uppercase">{{ $book->document_type }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <form action="{{ route('admin.biblioteca.specials.toggle', $book) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $book->is_special ? 'bg-emerald-500' : 'bg-slate-200' }}"
                                        title="{{ $book->is_special ? 'Quitar de especiales' : 'Marcar como especial' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $book->is_special ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="py-16 text-center text-slate-400">No hay libros registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tab: Revistas --}}
    <div id="panel-revistas" class="hidden">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border-t-4 border-blue-500">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <span class="text-sm font-bold bg-blue-50 text-blue-700 px-4 py-2 rounded-lg">{{ $magazines->count() }} revistas</span>
                <input type="text" id="search-revistas" placeholder="Buscar revista..."
                    oninput="filterTable('table-revistas', this.value)"
                    class="px-4 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-400 w-64">
            </div>
            <div class="overflow-x-auto">
                <table id="table-revistas" class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200">
                            <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Título</th>
                            <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Tipo</th>
                            <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Especial</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($magazines as $mag)
                        <tr class="hover:bg-slate-50 transition-colors" data-name="{{ strtolower($mag->title) }}">
                            <td class="py-3 px-6 text-sm font-semibold text-slate-800">{{ $mag->title }}</td>
                            <td class="py-3 px-6">
                                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-bold uppercase">{{ $mag->document_type }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <form action="{{ route('admin.biblioteca.specials.toggle', $mag) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $mag->is_special ? 'bg-blue-500' : 'bg-slate-200' }}"
                                        title="{{ $mag->is_special ? 'Quitar de especiales' : 'Marcar como especial' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $mag->is_special ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="py-16 text-center text-slate-400">No hay revistas registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(name) {
    document.getElementById('panel-libros').classList.toggle('hidden', name !== 'libros');
    document.getElementById('panel-revistas').classList.toggle('hidden', name !== 'revistas');

    const librosTab   = document.getElementById('tab-libros');
    const revistasTab = document.getElementById('tab-revistas');

    if (name === 'libros') {
        librosTab.className   = 'tab-btn px-5 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-emerald-500 text-emerald-700 bg-white -mb-px';
        revistasTab.className = 'tab-btn px-5 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-transparent text-slate-500 hover:text-slate-700 -mb-px';
    } else {
        revistasTab.className = 'tab-btn px-5 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-blue-500 text-blue-700 bg-white -mb-px';
        librosTab.className   = 'tab-btn px-5 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-transparent text-slate-500 hover:text-slate-700 -mb-px';
    }
}

function filterTable(tableId, q) {
    document.querySelectorAll(`#${tableId} tbody tr[data-name]`).forEach(row => {
        row.style.display = row.dataset.name.includes(q.toLowerCase()) ? '' : 'none';
    });
}
</script>
@endsection
