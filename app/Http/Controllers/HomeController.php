<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    /**
     * Mostrar página de inicio
     */
    public function index()
    {
        $bgPath = SiteSetting::get('bg_portal_principal');

        return view('home', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global ||
                auth()->user()->modules()->exists()
            ),
            'user'           => auth()->user(),
            'heroBg'         => $bgPath ? asset('storage/' . $bgPath) : asset('Fondo.png'),
        ]);
    }

    public function nosotros()
    {
        return view('nosotros', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global ||
                auth()->user()->modules()->exists()
            ),
        ]);
    }

    public function contacto()
    {
        return view('contacto', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global ||
                auth()->user()->modules()->exists()
            ),
        ]);
    }
}
