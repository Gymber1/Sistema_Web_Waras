<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Special;
use App\Models\Photo;
use App\Models\Photographer;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'biblioteca' => [
                'books'      => Book::where('document_type', '!=', 'Revista')->count(),
                'authors'    => Author::count(),
                'categories' => Category::where('type', 'biblioteca')->count(),
                'publishers' => Publisher::count(),
                'magazines'  => Book::where('document_type', 'Revista')->count(),
                'specials'   => Special::count(),
            ],
            'fototeca' => [
                'photos'        => Photo::count(),
                'photographers' => Photographer::count(),
                'categories'    => Category::where('type', 'fototeca')->count(),
            ],
            'usuarios' => [
                'total'      => User::count(),
                'admins'     => User::where('is_admin_global', true)->count(),
                'moderators' => User::where('is_admin_global', false)->count(),
            ],
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
