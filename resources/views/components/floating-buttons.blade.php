@php
    $yapeQr     = \App\Models\SiteSetting::get('yape_qr');
    $waQr       = \App\Models\SiteSetting::get('whatsapp_qr');
    $waNumber   = \App\Models\SiteSetting::get('whatsapp_number', '51000000000');
    $yapeUrl    = $yapeQr  ? asset('storage/' . $yapeQr)  : null;
    $waUrl      = $waQr    ? asset('storage/' . $waQr)    : null;
@endphp

<!-- Botones flotantes Yape / WhatsApp -->
<div style="position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;gap:0.75rem;align-items:flex-end;">

    {{-- YAPE --}}
    <div style="position:relative;" id="fb-yape-wrap">
        {{-- Popover --}}
        <div id="fb-yape-popover"
             style="display:none;position:absolute;bottom:70px;right:0;background:white;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.2);padding:1rem;width:180px;text-align:center;z-index:10000;">
            <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#742364;margin-bottom:.75rem;">Pagar con Yape</div>
            @if($yapeUrl)
                <img src="{{ $yapeUrl }}" alt="QR Yape" style="width:148px;height:148px;object-fit:contain;border-radius:8px;border:1px solid #f3e8ff;">
            @else
                <div style="width:148px;height:148px;background:#f9f0ff;border-radius:8px;display:flex;align-items:center;justify-content:center;border:1px dashed #d8b4fe;">
                    <span style="font-size:.75rem;color:#a855f7;">Sin QR configurado</span>
                </div>
            @endif
            {{-- Flecha apuntando al botón --}}
            <div style="position:absolute;bottom:-8px;right:20px;width:16px;height:16px;background:white;transform:rotate(45deg);box-shadow:3px 3px 6px rgba(0,0,0,.08);"></div>
        </div>

        {{-- Botón --}}
        <a href="https://yape.com.pe" target="_blank" rel="noopener" id="fb-yape-btn"
           style="display:block;width:56px;height:56px;border-radius:50%;overflow:hidden;box-shadow:0 0 15px rgba(116,35,101,0.8);transition:transform .3s,box-shadow .3s;cursor:pointer;"
           onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 0 25px rgba(116,35,101,1)'"
           onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 0 15px rgba(116,35,101,0.8)'"
           onclick="toggleFbPopover(event,'fb-yape-popover','fb-whatsapp-popover')">
            <img src="{{ asset('Yape.png') }}" alt="Yape" style="width:100%;height:100%;object-fit:cover;">
        </a>
    </div>

    {{-- WHATSAPP --}}
    <div style="position:relative;" id="fb-wa-wrap">
        {{-- Popover --}}
        <div id="fb-whatsapp-popover"
             style="display:none;position:absolute;bottom:70px;right:0;background:white;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.2);padding:1rem;width:180px;text-align:center;z-index:10000;">
            <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#128C7E;margin-bottom:.75rem;">WhatsApp</div>
            @if($waUrl)
                <img src="{{ $waUrl }}" alt="QR WhatsApp" style="width:148px;height:148px;object-fit:contain;border-radius:8px;border:1px solid #dcfce7;">
            @else
                <div style="width:148px;height:148px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;border:1px dashed #86efac;">
                    <span style="font-size:.75rem;color:#22c55e;">Sin QR configurado</span>
                </div>
            @endif
            <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"
               style="display:inline-block;margin-top:.75rem;font-size:.8rem;font-weight:700;color:#128C7E;font-family:monospace;letter-spacing:.02em;text-decoration:none;">
                +{{ $waNumber }}
            </a>
            {{-- Flecha --}}
            <div style="position:absolute;bottom:-8px;right:20px;width:16px;height:16px;background:white;transform:rotate(45deg);box-shadow:3px 3px 6px rgba(0,0,0,.08);"></div>
        </div>

        {{-- Botón --}}
        <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" id="fb-wa-btn"
           style="display:block;width:56px;height:56px;border-radius:50%;overflow:hidden;box-shadow:0 0 15px rgba(37,211,102,0.8);transition:transform .3s,box-shadow .3s;cursor:pointer;"
           onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 0 25px rgba(37,211,102,1)'"
           onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 0 15px rgba(37,211,102,0.8)'"
           onclick="toggleFbPopover(event,'fb-whatsapp-popover','fb-yape-popover')">
            <img src="{{ asset('Whatsapp.png') }}" alt="WhatsApp" style="width:100%;height:100%;object-fit:cover;">
        </a>
    </div>
</div>

<script>
function toggleFbPopover(e, showId, hideId) {
    e.preventDefault();
    const show = document.getElementById(showId);
    const hide = document.getElementById(hideId);
    const isVisible = show.style.display === 'block';
    if (hide) hide.style.display = 'none';
    show.style.display = isVisible ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
    const wrap1 = document.getElementById('fb-yape-wrap');
    const wrap2 = document.getElementById('fb-wa-wrap');
    if (wrap1 && !wrap1.contains(e.target)) document.getElementById('fb-yape-popover').style.display = 'none';
    if (wrap2 && !wrap2.contains(e.target)) document.getElementById('fb-whatsapp-popover').style.display = 'none';
});
</script>
