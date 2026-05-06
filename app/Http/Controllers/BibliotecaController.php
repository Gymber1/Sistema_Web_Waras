<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Special;
use App\Models\Descriptor;
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
        $allBooks        = Book::with(['authors', 'publisher', 'categories', 'descriptors'])->get();
        $booksByType     = $allBooks->groupBy('document_type');

        $specials = Special::where('module', 'biblioteca')->withCount('books')->with('books.authors')->orderBy('order')->orderBy('title')->get();

        $booksData = [
            'Libros'          => $allBooks->where('document_type', '!=', 'Revista')->values()->toArray(),
            'Revistas'        => $booksByType->get('Revista', collect())->values()->toArray(),
            'Editoriales'     => Publisher::with('books')->get()->toArray(),
            'Especiales'      => $specials->toArray(),
            'Autores'         => Author::all()->toArray(),
            'Waras Editorial' => $allBooks->where('section', 'Waras Editorial')->values()->toArray(),
            'Aportantes'      => [],
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

        $topDescriptors = Descriptor::withCount('books')
            ->having('books_count', '>', 0)
            ->orderByDesc('books_count')
            ->limit(20)
            ->get(['id', 'name', 'books_count']);

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
            'topDescriptors'       => $topDescriptors,
            'canEditPanel'         => auth()->check() && (auth()->user()->is_admin_global || auth()->user()->canAccessModule('biblioteca')),
            'heroBg'               => ($p = SiteSetting::get('bg_biblioteca')) ? asset('storage/' . $p) : null,
        ];
    }

    public function indexLibros()     { return view('biblioteca.dashboard', $this->dashboardData('Libros')); }
    public function indexRevistas()   { return view('biblioteca.dashboard', $this->dashboardData('Revistas')); }
    public function indexEditoriales(){ return view('biblioteca.dashboard', $this->dashboardData('Editoriales')); }
    public function indexAutores()    { return view('biblioteca.dashboard', $this->dashboardData('Autores')); }
    public function indexEspeciales() { return view('biblioteca.dashboard', $this->dashboardData('Especiales')); }
    public function indexEditorial()  { return view('biblioteca.dashboard', $this->dashboardData('Waras Editorial')); }
    public function indexAportantes() { return view('biblioteca.dashboard', $this->dashboardData('Aportantes')); }

    public function showEspecial(Special $special)
    {
        $special->load(['books.authors', 'books.categories', 'books.descriptors']);
        return view('biblioteca.especial', compact('special'));
    }

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

        // Sugerencias de descriptores para autocompletar
        if ($request->get('type') === 'descriptors') {
            $descriptors = Descriptor::where('name', 'like', "%{$query}%")
                ->withCount('books')
                ->orderByDesc('books_count')
                ->limit(8)
                ->get(['id', 'name', 'books_count']);
            return response()->json($descriptors);
        }

        // Libros que coinciden por descriptor (prioridad alta)
        $byDescriptor = Book::whereHas('descriptors', fn($q) => $q->where('name', 'like', "%{$query}%"))
            ->with(['authors', 'publisher'])
            ->get();

        // Libros que coinciden por título/resumen
        $byText = Book::where('title', 'like', "%{$query}%")
            ->orWhere('summary', 'like', "%{$query}%")
            ->with(['authors', 'publisher'])
            ->get();

        // Prioridad: descriptor primero, luego texto (sin duplicados)
        $books = $byDescriptor->merge($byText)->unique('id')->values();

        return response()->json($books);
    }
}
