<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar página de inicio
     */
    public function index()
    {
        return view('home', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global || 
                auth()->user()->modules()->exists()
            ),
            'user' => auth()->user(),
        ]);
    }
}
