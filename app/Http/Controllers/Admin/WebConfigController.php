<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebConfigController extends Controller
{
    // Keys and their display labels — add more sites here
    private const SITES = [
        'bg_portal_principal' => ['label' => 'Portal Principal', 'icon' => '🌐', 'route_hint' => '/'],
        'bg_biblioteca'       => ['label' => 'Biblioteca',       'icon' => '📚', 'route_hint' => '/biblioteca'],
        'bg_fototeca'         => ['label' => 'Fototeca',         'icon' => '📷', 'route_hint' => '/fototeca'],
    ];

    public function index()
    {
        $settings = [];
        foreach (self::SITES as $key => $meta) {
            $settings[$key] = array_merge($meta, [
                'value' => SiteSetting::get($key),
            ]);
        }

        return view('admin.web-config.index', compact('settings'));
    }

    public function update(Request $request, string $key)
    {
        abort_unless(array_key_exists($key, self::SITES), 404);

        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        // Delete previous file
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
}
