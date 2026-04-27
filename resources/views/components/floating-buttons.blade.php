@php
    use App\Models\FloatingButton;
    $buttons = FloatingButton::orderBy('orden')->get();
    $waNumber = \App\Models\SiteSetting::get('whatsapp_number', '51000000000');
@endphp

<div style="position:fixed;bottom:5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;gap:0.75rem;align-items:flex-end;">
@foreach($buttons as $i => $btn)
@php
    $isYape = $btn->slug === 'yape';
    $isWa   = $btn->slug === 'whatsapp';
    // Logo para el botón circular
    $imgSrc = $btn->logo
        ? asset('storage/' . $btn->logo)
        : ($isYape ? asset('Yape.png') : ($isWa ? asset('Whatsapp.png') : null));

    $popId  = 'fb-pop-' . $btn->id;
    $wrapId = 'fb-wrap-' . $btn->id;
    $btnId  = 'fb-btn-' . $btn->id;

    // Colores de glow desde el modelo
    $glowKey   = $btn->glow_color ?? 'indigo';
    $glowOpts  = \App\Models\FloatingButton::$GLOW_OPTIONS[$glowKey] ?? \App\Models\FloatingButton::$GLOW_OPTIONS['indigo'];
    $glow      = $glowOpts[0];
    $glowHover = $glowOpts[1];
    $headColor = $glowOpts[2];
@endphp

<div style="position:relative;" id="{{ $wrapId }}">
    {{-- Popover --}}
    <div id="{{ $popId }}"
         style="display:none;position:absolute;bottom:70px;right:0;background:white;border-radius:14px;
                box-shadow:0 20px 60px rgba(0,0,0,.2);padding:1.25rem;width:240px;text-align:center;z-index:10000;">
        <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:{{ $headColor }};margin-bottom:.75rem;">
            {{ $btn->nombre }}
        </div>

        @if($isYape || $isWa)
            {{-- QR --}}
            @if($btn->imagen)
                <img src="{{ asset('storage/' . $btn->imagen) }}" alt="QR {{ $btn->nombre }}"
                     style="width:200px;height:200px;object-fit:contain;border-radius:8px;border:1px solid #f0f0f0;">
            @else
                <div style="width:200px;height:200px;background:#f8f8f8;border-radius:8px;display:flex;
                            align-items:center;justify-content:center;border:1px dashed #d1d5db;">
                    <span style="font-size:.75rem;color:#9ca3af;">Sin QR configurado</span>
                </div>
            @endif
            @if($isWa)
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"
                   style="display:inline-block;margin-top:.75rem;font-size:.8rem;font-weight:700;
                          color:#128C7E;font-family:monospace;text-decoration:none;">
                    +{{ $waNumber }}
                </a>
            @endif
            @if($btn->descripcion && !$isWa)
                <div style="margin-top:.85rem;font-size:.85rem;font-weight:600;color:#222;line-height:1.5;">
                    {{ $btn->descripcion }}
                </div>
            @endif
        @else
            {{-- Botón extra --}}
            @if($btn->imagen)
                <img src="{{ asset('storage/' . $btn->imagen) }}" alt="{{ $btn->nombre }}"
                     style="width:200px;height:200px;object-fit:contain;border-radius:8px;border:1px solid #f0f0f0;">
            @endif
            @if($btn->descripcion)
                <div style="margin-top:.85rem;font-size:.85rem;font-weight:500;color:#374151;line-height:1.5;">
                    {{ $btn->descripcion }}
                </div>
            @endif
            @if($btn->link)
                <a href="{{ $btn->link }}" target="_blank" rel="noopener"
                   style="display:inline-block;margin-top:.75rem;font-size:.8rem;font-weight:700;
                          color:#4f46e5;text-decoration:none;">
                    Visitar →
                </a>
            @endif
        @endif

        <div style="position:absolute;bottom:-8px;right:20px;width:16px;height:16px;background:white;
                    transform:rotate(45deg);box-shadow:3px 3px 6px rgba(0,0,0,.08);"></div>
    </div>

    {{-- Botón circular --}}
    @if($imgSrc)
    <a href="{{ $btn->link ?? '#' }}"
       @if(!$isYape && !$isWa && $btn->link) target="_blank" rel="noopener" @endif
       id="{{ $btnId }}"
       style="display:block;width:56px;height:56px;border-radius:50%;overflow:hidden;
              box-shadow:0 0 15px {{ $glow }};transition:transform .3s,box-shadow .3s;cursor:pointer;"
       onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 0 25px {{ $glowHover }}'"
       onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 0 15px {{ $glow }}'"
       onclick="toggleFbPop(event,'{{ $popId }}',{{ $buttons->pluck('id')->map(fn($id)=> "'fb-pop-{$id}'")->join(',') }})">
        <img src="{{ $imgSrc }}" alt="{{ $btn->nombre }}" style="width:100%;height:100%;object-fit:cover;">
    </a>
    @endif
</div>
@endforeach
</div>

<script>
function toggleFbPop(e, showId, ...allIds) {
    e.preventDefault();
    const show = document.getElementById(showId);
    const isVisible = show.style.display === 'block';
    allIds.forEach(id => { const el = document.getElementById(id); if (el) el.style.display = 'none'; });
    show.style.display = isVisible ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
    @foreach($buttons as $btn)
    (function() {
        const wrap = document.getElementById('fb-wrap-{{ $btn->id }}');
        const pop  = document.getElementById('fb-pop-{{ $btn->id }}');
        if (wrap && pop && !wrap.contains(e.target)) pop.style.display = 'none';
    })();
    @endforeach
});
</script>
