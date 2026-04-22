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
        $bgBiblioteca = SiteSetting::get('bg_biblioteca');
        $bgFototeca = SiteSetting::get('bg_fototeca');

        return view('home', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global ||
                auth()->user()->modules()->exists()
            ),
            'user'           => auth()->user(),
            'heroBg'         => $bgPath ? asset('storage/' . $bgPath) : asset('Fondo.png'),
            'heroBgBiblioteca' => $bgBiblioteca ? asset('storage/' . $bgBiblioteca) : 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=900&q=80',
            'heroBgFototeca' => $bgFototeca ? asset('storage/' . $bgFototeca) : 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?auto=format&fit=crop&w=900&q=80',
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
