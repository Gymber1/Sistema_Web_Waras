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
        // El catálogo se renderiza en el navegador con estos datos incrustados en
        // la página, así que se piden SOLO las columnas que usa la grilla y, de
        // cada relación, únicamente id y nombre. Traer el modelo completo con
        // todas sus relaciones hacía que el HTML pesara más de 1 MB.
        $allBooks = Book::select([
                'id', 'title', 'summary', 'document_type', 'section',
                'publication_year', 'publication_date', 'pages', 'language', 'isbn',
                'cover_image_path', 'source_type', 'external_url', 'pdf_file_path',
                'publisher_id', 'created_at',
            ])
            ->with([
                'authors:id,name',
                'publisher:id,name',
                'categories:id,name',
                'descriptors:id,name',
            ])
            ->get();
        $booksByType     = $allBooks->groupBy('document_type');

        // Solo se muestran portada, título y cuántos elementos tiene cada colección:
        // no hace falta traer los libros completos de cada una.
        $specials = Special::where('module', 'biblioteca')
            ->select('id', 'title', 'slug', 'type', 'cover_image_path', 'order')
            ->withCount('books')
            ->orderBy('order')->orderBy('title')
            ->get();

        // El catálogo solo usa la sinopsis para buscar texto; la ficha completa
        // la carga aparte. Recortarla evita mandar miles de caracteres por libro.
        $trimSummary = function (array $book) {
            if (! empty($book['summary'])) {
                $book['summary'] = mb_substr($book['summary'], 0, 300);
            }
            return $book;
        };

        $booksData = [
            'Libros'          => array_map($trimSummary, $allBooks->where('document_type', '!=', 'Revista')->values()->toArray()),
            'Revistas'        => array_map($trimSummary, $booksByType->get('Revista', collect())->values()->toArray()),
            // Solo el listado: cargar Publisher::with('books') duplicaba el
            // catálogo entero dentro del HTML.
            'Editoriales'     => Publisher::select('id', 'name')->withCount('books')->get()->toArray(),
            'Especiales'      => $specials->toArray(),
            'Autores'         => Author::select('id', 'name', 'biography', 'nationality', 'photo_path')->get()->toArray(),
            'Waras Editorial' => array_map($trimSummary, $allBooks->where('section', 'Waras Editorial')->values()->toArray()),
            'Aportantes'      => [],
        ];

        $allCategories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();

        $allRevistaCategories = Category::where('type', 'revista')
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

        // Todos los descriptores con libros (para la ventana emergente de Descriptores)
        $allDescriptors = Descriptor::withCount('books')
            ->having('books_count', '>', 0)
            ->orderBy('name')
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
            'revistaCategoriesForFilters' => $buildTree($allRevistaCategories),
            'activeSection'        => $activeSection,
            'topDescriptors'       => $topDescriptors,
            'allDescriptors'       => $allDescriptors,
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
        $book->load(['authors', 'categories', 'descriptors']);
        return view('biblioteca.libro', [
            'book'                 => $book,
            'categoriesForFilters' => $this->categoryTree('biblioteca'),
        ]);
    }

    public function showRevista(Book $book)
    {
        $book->load(['authors', 'categories', 'descriptors']);
        return view('biblioteca.revista', [
            'book'                 => $book,
            'categoriesForFilters' => $this->categoryTree('revista'),
        ]);
    }

    /**
     * Arbol de categorias de un tipo, para el panel de filtros.
     */
    private function categoryTree(string $type): array
    {
        $roots = Category::where('type', $type)
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();

        $build = function ($categories) use (&$build) {
            return $categories->map(fn($cat) => [
                'id'       => $cat->id,
                'name'     => $cat->name,
                'slug'     => $cat->slug,
                'children' => $build($cat->subcategories),
            ])->toArray();
        };

        return $build($roots);
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
