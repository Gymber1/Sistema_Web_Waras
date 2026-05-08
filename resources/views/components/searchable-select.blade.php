@props([
    'name',
    'label',
    'options',      // Collection of ['value'=>id, 'text'=>'display text']
    'selected' => '',
    'placeholder' => '— Seleccionar —',
    'required' => false,
])

@php
    $uid = 'ss_' . substr(md5($name . rand()), 0, 8);
    $optionsArr = $options instanceof \Illuminate\Support\Collection
        ? $options->values()->toArray()
        : (array) $options;
@endphp

<div class="relative" id="{{ $uid }}_wrap">
    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
        {{ $label }}@if($required) <span class="text-red-500">*</span>@endif
    </label>

    {{-- Hidden input for form submission --}}
    <input type="hidden" name="{{ $name }}" id="{{ $uid }}_val" value="{{ $selected }}">

    {{-- Trigger --}}
    <button type="button" id="{{ $uid }}_btn"
        class="w-full flex items-center justify-between px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-left outline-none transition-all hover:border-brand-400">
        <span id="{{ $uid }}_label" class="text-slate-400 dark:text-slate-500 truncate pr-2">{{ $placeholder }}</span>
        <div class="flex items-center gap-1 flex-shrink-0">
            <span id="{{ $uid }}_clear" onclick="ss_clear('{{ $uid }}')" style="display:none"
                class="text-slate-400 hover:text-red-500 transition-colors cursor-pointer p-0.5">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </span>
            <svg id="{{ $uid }}_chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-400 transition-transform duration-200"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
    </button>

    {{-- Dropdown --}}
    <div id="{{ $uid }}_dropdown" style="display:none"
        class="absolute z-50 mt-1 w-full bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border rounded-lg shadow-xl overflow-hidden">

        {{-- Search --}}
        <div class="p-2 border-b border-slate-100 dark:border-dark-border">
            <div class="relative">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="{{ $uid }}_search" placeholder="Buscar..."
                    oninput="ss_filter('{{ $uid }}')"
                    onkeydown="if(event.key==='Escape') ss_close('{{ $uid }}')"
                    class="w-full pl-8 pr-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-brand-500 text-slate-800 dark:text-white placeholder-slate-400">
            </div>
        </div>

        {{-- Options --}}
        <ul id="{{ $uid }}_list" class="max-h-56 overflow-y-auto py-1">
            @if(!$required)
            <li>
                <button type="button" onclick="ss_select('{{ $uid }}', '', '{{ $placeholder }}')"
                    class="w-full text-left px-4 py-2 text-sm text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                    {{ $placeholder }}
                </button>
            </li>
            @endif
            @foreach($optionsArr as $opt)
            <li data-text="{{ strtolower($opt['text']) }}">
                <button type="button"
                    onclick="ss_select('{{ $uid }}', '{{ $opt['value'] }}', {{ Js::from($opt['text']) }})"
                    class="w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-brand-50 dark:hover:bg-brand-500/10 hover:text-brand-700 dark:hover:text-brand-300 transition-colors ss-opt {{ (string)$opt['value'] === (string)$selected ? 'bg-brand-50 dark:bg-brand-500/10 text-brand-700 dark:text-brand-300 font-medium' : '' }}"
                    data-val="{{ $opt['value'] }}">
                    {{ $opt['text'] }}
                </button>
            </li>
            @endforeach
            <li id="{{ $uid }}_empty" style="display:none" class="px-4 py-3 text-sm text-slate-400 text-center">Sin resultados</li>
        </ul>
    </div>
</div>

@once
<script>
function ss_open(id) {
    const dd = document.getElementById(id+'_dropdown');
    const chevron = document.getElementById(id+'_chevron');
    dd.style.display = 'block';
    chevron.style.transform = 'rotate(180deg)';
    setTimeout(() => document.getElementById(id+'_search')?.focus(), 50);
}
function ss_close(id) {
    document.getElementById(id+'_dropdown').style.display = 'none';
    document.getElementById(id+'_chevron').style.transform = '';
    document.getElementById(id+'_search').value = '';
    ss_filter(id);
}
function ss_toggle(id) {
    const dd = document.getElementById(id+'_dropdown');
    dd.style.display === 'none' ? ss_open(id) : ss_close(id);
}
function ss_select(id, val, text) {
    document.getElementById(id+'_val').value = val;
    const lbl = document.getElementById(id+'_label');
    lbl.textContent = text || document.getElementById(id+'_btn').dataset.placeholder;
    lbl.classList.toggle('text-slate-400', !val);
    lbl.classList.toggle('dark:text-slate-500', !val);
    lbl.classList.toggle('text-slate-800', !!val);
    lbl.classList.toggle('dark:text-white', !!val);
    document.getElementById(id+'_clear').style.display = val ? '' : 'none';
    // highlight selected
    document.querySelectorAll('#'+id+'_list .ss-opt').forEach(btn => {
        const active = btn.dataset.val == val;
        btn.classList.toggle('bg-brand-50', active);
        btn.classList.toggle('dark:bg-brand-500/10', active);
        btn.classList.toggle('text-brand-700', active);
        btn.classList.toggle('dark:text-brand-300', active);
        btn.classList.toggle('font-medium', active);
    });
    ss_close(id);
}
function ss_clear(id) {
    ss_select(id, '', document.getElementById(id+'_btn').querySelector('span').dataset.ph || '');
}
function ss_filter(id) {
    const q = document.getElementById(id+'_search').value.toLowerCase();
    let visible = 0;
    document.querySelectorAll('#'+id+'_list li[data-text]').forEach(li => {
        const match = !q || li.dataset.text.includes(q);
        li.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById(id+'_empty').style.display = visible === 0 ? '' : 'none';
}
// Close on outside click
document.addEventListener('click', function(e) {
    document.querySelectorAll('[id$="_dropdown"]').forEach(dd => {
        const id = dd.id.replace('_dropdown','');
        if (!document.getElementById(id+'_wrap')?.contains(e.target)) {
            dd.style.display = 'none';
            const chev = document.getElementById(id+'_chevron');
            if (chev) chev.style.transform = '';
        }
    });
});
</script>
@endonce

<script>
(function() {
    const btn = document.getElementById('{{ $uid }}_btn');
    btn.addEventListener('click', function() { ss_toggle('{{ $uid }}'); });
    // pre-select label if value exists
    const val = '{{ $selected }}';
    if (val) {
        const opt = btn.closest('[id$="_wrap"]')?.querySelector(`.ss-opt[data-val="${val}"]`);
        if (opt) {
            const lbl = document.getElementById('{{ $uid }}_label');
            lbl.textContent = opt.textContent.trim();
            lbl.classList.remove('text-slate-400','dark:text-slate-500');
            lbl.classList.add('text-slate-800','dark:text-white');
            document.getElementById('{{ $uid }}_clear').style.display = '';
        }
    }
})();
</script>
