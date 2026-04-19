@extends('layouts.admin')

@section('title', 'Iconos Flotantes — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="p-8 max-w-3xl mx-auto">

    {{-- Volver --}}
    <a href="{{ route('admin.web-config.index') }}"
       class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-medium mb-8 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver a Configuraciones
    </a>

    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Iconos Flotantes de Contacto</h1>
        <p class="text-slate-500 text-sm mt-1">Actualiza los códigos QR y el número de WhatsApp que aparecen en el portal público.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        <div>{{ $errors->first() }}</div>
    </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 bg-slate-50">
            <span class="text-2xl">📱</span>
            <div>
                <h2 class="font-bold text-slate-800 text-base leading-tight">Información de Contacto Flotante</h2>
                <span class="text-xs text-slate-400">QRs y número para los botones de Yape y WhatsApp en el portal público</span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.web-config.contact.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- QR Yape --}}
                <div class="flex flex-col gap-3">
                    <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full inline-block flex-shrink-0" style="background:#742364;"></span>
                        QR de Yape
                    </label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center gap-3 hover:border-purple-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('input-yape-qr').click()">
                        @if($contact['yape_qr'])
                            <img id="preview-yape-qr" src="{{ asset('storage/' . $contact['yape_qr']) }}" alt="QR Yape" class="w-32 h-32 object-contain rounded-lg">
                        @else
                            <img id="preview-yape-qr" src="" alt="" class="w-32 h-32 object-contain rounded-lg hidden">
                            <div class="text-slate-400 text-center">
                                <svg class="w-10 h-10 mx-auto mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                <p class="text-xs">Sin imagen</p>
                            </div>
                        @endif
                        <span class="text-xs text-slate-500">Clic para cambiar</span>
                    </div>
                    <input id="input-yape-qr" type="file" name="yape_qr" accept="image/*" class="hidden"
                           onchange="previewContactQr(this, 'preview-yape-qr')">
                    @if($contact['yape_qr'])
                    <button type="button" onclick="deleteContactQr('yape_qr')"
                            class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar QR actual
                    </button>
                    @endif
                </div>

                {{-- QR WhatsApp --}}
                <div class="flex flex-col gap-3">
                    <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full inline-block flex-shrink-0" style="background:#25d366;"></span>
                        QR de WhatsApp
                    </label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center gap-3 hover:border-green-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('input-whatsapp-qr').click()">
                        @if($contact['whatsapp_qr'])
                            <img id="preview-whatsapp-qr" src="{{ asset('storage/' . $contact['whatsapp_qr']) }}" alt="QR WhatsApp" class="w-32 h-32 object-contain rounded-lg">
                        @else
                            <img id="preview-whatsapp-qr" src="" alt="" class="w-32 h-32 object-contain rounded-lg hidden">
                            <div class="text-slate-400 text-center">
                                <svg class="w-10 h-10 mx-auto mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                <p class="text-xs">Sin imagen</p>
                            </div>
                        @endif
                        <span class="text-xs text-slate-500">Clic para cambiar</span>
                    </div>
                    <input id="input-whatsapp-qr" type="file" name="whatsapp_qr" accept="image/*" class="hidden"
                           onchange="previewContactQr(this, 'preview-whatsapp-qr')">
                    @if($contact['whatsapp_qr'])
                    <button type="button" onclick="deleteContactQr('whatsapp_qr')"
                            class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar QR actual
                    </button>
                    @endif
                </div>

                {{-- Número WhatsApp --}}
                <div class="flex flex-col gap-3">
                    <label for="whatsapp_number" class="text-sm font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full inline-block flex-shrink-0" style="background:#25d366;"></span>
                        Número de WhatsApp
                    </label>
                    <p class="text-xs text-slate-400">Solo ingresa los 9 dígitos de tu número peruano.</p>
                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-green-400 focus-within:border-transparent">
                        <span class="px-3 py-3 bg-slate-100 text-slate-500 text-sm font-mono border-r border-slate-200 select-none">+51</span>
                        <input type="text" id="whatsapp_number" name="whatsapp_number"
                               value="{{ ltrim($contact['whatsapp_number'] ?? '', '51') }}"
                               placeholder="987654321"
                               maxlength="9"
                               pattern="\d{9}"
                               inputmode="numeric"
                               oninput="this.value=this.value.replace(/\D/g,'')"
                               class="flex-1 px-3 py-3 text-sm font-mono outline-none bg-white">
                    </div>
                    <p class="text-xs text-slate-400">Se guardará como <code class="bg-slate-100 px-1 rounded">51 + tu número</code> para <code class="bg-slate-100 px-1 rounded">wa.me/51xxxxxxxxx</code></p>
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Guardar información de contacto
                </button>
            </div>
        </form>
    </div>
</div>

<form method="POST" action="{{ route('admin.web-config.contact.destroy', 'yape_qr') }}" id="form-delete-yape_qr" style="display:none;">
    @csrf @method('DELETE')
</form>
<form method="POST" action="{{ route('admin.web-config.contact.destroy', 'whatsapp_qr') }}" id="form-delete-whatsapp_qr" style="display:none;">
    @csrf @method('DELETE')
</form>

<script>
function previewContactQr(input, previewId) {
    if (!input.files || !input.files[0]) return;
    const img = document.getElementById(previewId);
    const reader = new FileReader();
    reader.onload = e => { img.src = e.target.result; img.classList.remove('hidden'); };
    reader.readAsDataURL(input.files[0]);
}
function deleteContactQr(key) {
    if (!confirm('¿Eliminar este QR?')) return;
    document.getElementById('form-delete-' + key).submit();
}
</script>
@endsection
