<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\SiteSetting;

class BibliotecaController extends Controller
{
    /**
     * Mostrar dashboard de Biblioteca
     * Acceso público - cualquier visitante puede ver, moderadores ven todo
     */
    public function index()
    {
        return view('biblioteca.dashboard', $this->dashboardData('Inicio'));
    }

    private function dashboardData(string $activeSection): array
    {
        $totalBooks      = Book::count();
        $totalAuthors    = Author::count();
        $totalPublishers = Publisher::count();
        $totalCategories = Category::count();
        $allBooks        = Book::with(['authors', 'publisher', 'categories'])->get();
        $booksByType     = $allBooks->groupBy('document_type');

        $booksData = [
            'Libros'      => $booksByType->get('Libro', collect())->values()->toArray(),
            'Revistas'    => $booksByType->get('Revista', collect())->values()->toArray(),
            'Editoriales' => Publisher::with('books')->get()->toArray(),
            'Especiales'  => Book::where('is_special', true)->with(['authors', 'publisher', 'categories'])->get()->toArray(),
            'Autores'     => Author::all()->toArray(),
            'Aportantes'  => [],
        ];

        $allCategories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();

        $buildTree = function ($categories) use (&$buildTree) {
            return $categories->map(fn($cat) => [
                'id'       => $cat->id,
                'name'     => $cat->name,
                'slug'     => $cat->slug,
                'children' => $buildTree($cat->subcategories),
            ])->toArray();
        };

        return [
            'totalBooks'           => $totalBooks,
            'totalAuthors'         => $totalAuthors,
            'totalPublishers'      => $totalPublishers,
            'totalCategories'      => $totalCategories,
            'allBooks'             => $allBooks,
            'booksData'            => $booksData,
            'booksByCategory'      => Category::with('books')->get(),
            'categoriesForFilters' => $buildTree($allCategories),
            'activeSection'        => $activeSection,
            'canEditPanel'         => auth()->check() && (auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca')),
            'heroBg'               => ($p = SiteSetting::get('bg_biblioteca')) ? asset('storage/' . $p) : null,
        ];
    }

    public function indexLibros()     { return view('biblioteca.dashboard', $this->dashboardData('Libros')); }
    public function indexRevistas()   { return view('biblioteca.dashboard', $this->dashboardData('Revistas')); }
    public function indexEditoriales(){ return view('biblioteca.dashboard', $this->dashboardData('Editoriales')); }
    public function indexAutores()    { return view('biblioteca.dashboard', $this->dashboardData('Autores')); }
    public function indexEspeciales() { return view('biblioteca.dashboard', $this->dashboardData('Especiales')); }
    public function indexAportantes() { return view('biblioteca.dashboard', $this->dashboardData('Aportantes')); }

    public function showAuthor(Author $author)
    {
        $author->load(['books.publisher', 'books.categories']);
        return view('biblioteca.autor', compact('author'));
    }

    public function showBook(Book $book)
    {
        $book->load(['authors', 'publisher', 'categories']);
        return view('biblioteca.libro', compact('book'));
    }

    public function showRevista(Book $book)
    {
        $book->load(['authors', 'publisher', 'categories']);
        return view('biblioteca.revista', compact('book'));
    }

    public function showEditorial(Publisher $publisher)
    {
        $publisher->load(['books.authors', 'books.categories']);
        return view('biblioteca.editorial', compact('publisher'));
    }


    public function getBooksByCategory($categoryId)
    {
        $books = Book::where('category_id', $categoryId)
            ->with(['authors', 'publisher'])
            ->paginate(20);

        return response()->json($books);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $books = Book::where('title', 'like', "%{$query}%")
            ->orWhere('summary', 'like', "%{$query}%")
            ->with(['authors', 'publisher'])
            ->paginate(20);

        return response()->json($books);
    }
}
