<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Photo;
use App\Models\Photographer;
use App\Models\User;
use App\Models\Special;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ============= BIBLIOTECA =============
        $booksCount = Book::where('document_type', 'Libro')->count();
        $authorsCount = Author::count();
        $categoriesCount = Category::where('type', 'biblioteca')->whereNull('parent_id')->count();
        $subcategoriesCount = Category::where('type', 'biblioteca')->whereNotNull('parent_id')->count();
        $publishersCount = Publisher::count();
        $magazinesCount = Book::where('document_type', 'Revista')->count();
        $specialsCount = Special::where('type', 'book')->where('is_active', true)->count();

        // ============= FOTOTECA =============
        $photosCount = Photo::count();
        $photographersCount = Photographer::count();
        $photoCategoriesCount = Category::where('type', 'fototeca')->whereNull('parent_id')->count();
        $photoSubcategoriesCount = Category::where('type', 'fototeca')->whereNotNull('parent_id')->count();
        $photoSpecialsCount = Special::where('type', 'photo')->where('is_active', true)->count();

        // ============= USUARIOS =============
        $totalUsers = User::count();
        $adminsCount = User::where('is_admin_global', true)->count();
        $moderatorsCount = User::whereHas('modules')->count();

        // Datos compilados para pasar a la vista
        $stats = [
            'biblioteca' => [
                'books' => $booksCount,
                'authors' => $authorsCount,
                'categories' => $categoriesCount,
                'subcategories' => $subcategoriesCount,
                'publishers' => $publishersCount,
                'magazines' => $magazinesCount,
                'specials' => $specialsCount,
            ],
            'fototeca' => [
                'photos' => $photosCount,
                'photographers' => $photographersCount,
                'categories' => $photoCategoriesCount,
                'subcategories' => $photoSubcategoriesCount,
                'specials' => $photoSpecialsCount,
            ],
            'usuarios' => [
                'total' => $totalUsers,
                'admins' => $adminsCount,
                'moderators' => $moderatorsCount,
            ],
        ];

        return view('admin.dashboard', ['stats' => $stats]);
    }
}
