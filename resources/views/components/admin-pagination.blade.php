<div class="px-6 py-4 border-t border-slate-100 dark:border-dark-border flex flex-col sm:flex-row items-center justify-between gap-3">
    <p class="text-sm text-slate-500 dark:text-slate-400">
        Mostrando <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $paginator->firstItem() ?? 0 }}</span>
        a <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $paginator->lastItem() ?? 0 }}</span>
        de <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $paginator->total() }}</span> resultados
    </p>
    @if($paginator->lastPage() > 1)
    <div class="flex items-center gap-1">
        {{-- Anterior --}}
        @if($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-300 dark:text-slate-600 cursor-not-allowed">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </a>
        @endif

        {{-- Páginas --}}
        @foreach($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
            @if($page == $paginator->currentPage())
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-semibold bg-brand-500 text-white shadow-sm">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Puntos suspensivos + última página --}}
        @if($paginator->currentPage() + 2 < $paginator->lastPage())
            <span class="inline-flex items-center justify-center w-8 h-8 text-sm text-slate-400">…</span>
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">{{ $paginator->lastPage() }}</a>
        @endif

        {{-- Siguiente --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-300 dark:text-slate-600 cursor-not-allowed">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </span>
        @endif
    </div>
    @endif
</div>
