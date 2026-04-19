<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;

class BibliotecaController extends Controller
{
    /**
     * Mostrar dashboard de Biblioteca
     * Acceso público - cualquier visitante puede ver, moderadores ven todo
     */
    public function index()
    {
        // Verificar que el usuario tiene acceso (solo si está autenticado)
        if (auth()->check() && !auth()->user()->canAccessModule('biblioteca')) {
            abort(403, 'Acceso denegado a este módulo');
        }

        // Obtener estadísticas optimizadas
        $totalBooks = Book::count();
        $totalAuthors = Author::count();
        $totalPublishers = Publisher::count();
        $totalCategories = Category::count();

        // Obtener TODOS los libros con relaciones eager-loaded
        $allBooks = Book::with(['authors', 'publisher', 'categories'])->get();

        // Agrupar por tipo de documento
        $booksByType = $allBooks->groupBy('document_type');
        
        // Preparar datos por sección (Libros, Revistas, etc.)
        $booksData = [
            'Libros' => $booksByType->get('Libro', collect())->values()->toArray(),
            'Revistas' => $booksByType->get('Revista', collect())->values()->toArray(),
            'Editoriales' => [], // Placeholder para futura expansión
            'Especiales' => [], // Placeholder para futura expansión
            'Autores' => Author::all()->toArray(),
            'Aportantes' => [], // Placeholder para futura expansión
        ];

        // Obtener categorías de biblioteca para filtros dinámicos
        $allCategories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();
        
        // Convertir a array con estructura: [{ id, name, children: [...] }]
        $categoriesForFilters = $allCategories->map(function($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'children' => $cat->subcategories->map(function($sub) {
                    return [
                        'id' => $sub->id,
                        'name' => $sub->name,
                        'slug' => $sub->slug,
                    ];
                })->toArray(),
            ];
        })->toArray();

        // Agrupar libros por categoría para la vista
        $booksByCategory = Category::with('books')->get();

        return view('biblioteca.dashboard', [
            'totalBooks' => $totalBooks,
            'totalAuthors' => $totalAuthors,
            'totalPublishers' => $totalPublishers,
            'totalCategories' => $totalCategories,
            'allBooks' => $allBooks,
            'booksData' => $booksData,
            'booksByCategory' => $booksByCategory,
            'categoriesForFilters' => $categoriesForFilters,
            'canEditPanel' => auth()->check() && (auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca')),
        ]);
    }

    /**
     * Perfil público de un autor
     */
    public function showAuthor(Author $author)
    {
        if (auth()->check() && !auth()->user()->canAccessModule('biblioteca')) {
            abort(403);
        }

        $author->load(['books.publisher', 'books.categories']);

        return view('biblioteca.autor', compact('author'));
    }

    /**
     * API - Obtener libros por categoría
     */
    public function getBooksByCategory($categoryId)
    {
        // Público, pero verificar si está autenticado
        if (auth()->check() && !auth()->user()->canAccessModule('biblioteca')) {
            abort(403);
        }

        $books = Book::where('category_id', $categoryId)
            ->with(['authors', 'publisher'])
            ->paginate(20);

        return response()->json($books);
    }

    /**
     * API - Buscar libros
     */
    public function search(Request $request)
    {
        // Público, pero verificar si está autenticado
        if (auth()->check() && !auth()->user()->canAccessModule('biblioteca')) {
            abort(403);
        }

        $query = $request->get('q');
        
        $books = Book::where('title', 'like', "%{$query}%")
            ->orWhere('summary', 'like', "%{$query}%")
            ->with(['authors', 'publisher'])
            ->paginate(20);

        return response()->json($books);
    }
}
