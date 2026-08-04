@props([
    'column',                 // nombre de la columna a ordenar (ej. 'title')
    'label',                  // texto del encabezado (ej. 'Título')
    'align' => 'left',        // left | center | right
])

@php
    $currentSort = request('sort');
    $currentDir  = request('dir', 'asc');
    $isActive    = $currentSort === $column;
    // Al hacer clic: si ya está activa asc → desc; si desc → asc; si no está → asc
    $nextDir = ($isActive && $currentDir === 'asc') ? 'desc' : 'asc';
    // Conservar el resto de parámetros (search, page se resetea a 1)
    $params = array_merge(request()->except('page'), ['sort' => $column, 'dir' => $nextDir]);
    $url = request()->url() . '?' . http_build_query($params);

    $alignCls = $align === 'right' ? 'justify-end text-right' : ($align === 'center' ? 'justify-center text-center' : 'text-left');
@endphp

<th {{ $attributes->merge(['class' => 'px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider']) }}>
    <a href="{{ $url }}" class="sort-link inline-flex items-center gap-1 {{ $alignCls }} hover:text-brand-600 dark:hover:text-brand-400 transition-colors group/sort select-none">
        <span>{{ $label }}</span>
        @if($isActive)
            @if($currentDir === 'asc')
                <i data-lucide="arrow-up" class="w-3.5 h-3.5 text-brand-500"></i>
            @else
                <i data-lucide="arrow-down" class="w-3.5 h-3.5 text-brand-500"></i>
            @endif
        @else
            <i data-lucide="chevrons-up-down" class="w-3.5 h-3.5 opacity-0 group-hover/sort:opacity-40 transition-opacity"></i>
        @endif
    </a>
</th>
