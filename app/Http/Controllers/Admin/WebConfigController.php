<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebConfigController extends Controller
{
    private const SITES = [
        'bg_portal_principal' => ['label' => 'Portal Principal', 'icon' => '🌐', 'route_hint' => '/'],
        'bg_biblioteca'       => ['label' => 'Biblioteca',       'icon' => '📚', 'route_hint' => '/biblioteca'],
        'bg_fototeca'         => ['label' => 'Fototeca',         'icon' => '📷', 'route_hint' => '/fototeca'],
    ];

    // Image-based contact keys
    private const CONTACT_IMAGES = ['yape_qr', 'whatsapp_qr'];

    public function index()
    {
        return view('admin.web-config.index');
    }

    public function fondos()
    {
        $settings = [];
        foreach (self::SITES as $key => $meta) {
            $settings[$key] = array_merge($meta, ['value' => SiteSetting::get($key)]);
        }
        return view('admin.web-config.config-fondos', compact('settings'));
    }

    public function contacto()
    {
        $contact = [
            'yape_qr'         => SiteSetting::get('yape_qr'),
            'whatsapp_qr'     => SiteSetting::get('whatsapp_qr'),
            'whatsapp_number' => SiteSetting::get('whatsapp_number'),
        ];
        return view('admin.web-config.config-flotantes', compact('contact'));
    }

    public function update(Request $request, string $key)
    {
        abort_unless(array_key_exists($key, self::SITES), 404);

        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        $path = $request->file('image')->store('backgrounds', 'public');
        SiteSetting::set($key, $path);

        return back()->with('success', 'Fondo de ' . self::SITES[$key]['label'] . ' actualizado correctamente.');
    }

    public function destroy(string $key)
    {
        abort_unless(array_key_exists($key, self::SITES), 404);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        SiteSetting::set($key, null);

        return back()->with('success', 'Fondo de ' . self::SITES[$key]['label'] . ' eliminado. Se usará el fondo por defecto.');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'yape_qr'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'whatsapp_qr'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'whatsapp_number' => ['nullable', 'string', 'digits_between:0,9'],
        ]);

        foreach (self::CONTACT_IMAGES as $field) {
            if ($request->hasFile($field)) {
                $old = SiteSetting::get($field);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $path = $request->file($field)->store('contact', 'public');
                SiteSetting::set($field, $path);
            }
        }

        $number = preg_replace('/\D/', '', $request->input('whatsapp_number', ''));
        if ($number !== '') {
            if (!str_starts_with($number, '51')) {
                $number = '51' . $number;
            }
        }
        SiteSetting::set('whatsapp_number', $number ?: null);

        return back()->with('success', 'Información de contacto actualizada correctamente.');
    }

    public function destroyContact(string $key)
    {
        abort_unless(in_array($key, self::CONTACT_IMAGES), 404);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        SiteSetting::set($key, null);

        return back()->with('success', 'QR eliminado correctamente.');
    }
}
