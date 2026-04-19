<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BibliotecaController extends Controller
{
    // ============= DASHBOARD DEL MÓDULO =============

    public function adminIndex()
    {
        $stats = [
            'books'      => Book::where('document_type', '!=', 'Revista')->count(),
            'magazines'  => Book::where('document_type', 'Revista')->count(),
            'authors'    => Author::count(),
            'categories' => Category::where('type', 'biblioteca')->count(),
            'publishers' => Publisher::count(),
            'specials'   => Book::where('is_special', true)->count(),
        ];

        return view('admin.biblioteca.index', compact('stats'));
    }

    // ============= LIBROS =============

    public function indexBooks()
    {
        $books = Book::where('document_type', '!=', 'Revista')
            ->with(['authors', 'publisher', 'categories'])
            ->get();
        $authors    = Author::orderBy('name')->get();
        $categories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();
        $publishers = Publisher::orderBy('name')->get();
        return view('admin.biblioteca.books.index', compact('books', 'authors', 'categories', 'publishers'));
    }

    public function createBook()
    {
        $authors    = Author::orderBy('name')->get();
        $categories = Category::flatTree('biblioteca');
        $publishers = Publisher::orderBy('name')->get();
        return view('admin.biblioteca.books.create', compact('authors', 'categories', 'publishers'));
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'categories'       => 'nullable|array',
            'categories.*'     => 'exists:categories,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
            'isbn'             => 'nullable|string|max:50',
            'language'         => 'nullable|string|max:50',
        ]);

        $slug = $this->uniqueSlug($request->title, Book::class);

        $data = [
            'title'            => $request->title,
            'slug'             => $slug,
            'document_type'    => 'Libro',
            'publisher_id'     => $request->publisher_id,
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'source_type'      => $request->source_type,
            'external_url'     => $request->source_type === 'external' ? $request->external_url : null,
            'isbn'             => $request->isbn,
            'language'         => $request->language ?? 'Español',
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('covers', 'public');
        }
        if ($request->hasFile('pdf_file') && $request->source_type === 'pdf') {
            $data['pdf_file_path'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $book = Book::create($data);
        $book->authors()->sync($this->withOrder($request->authors ?? []));
        $book->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.biblioteca.books')->with('success', 'Libro agregado correctamente.');
    }

    public function updateBook(Request $request, Book $book)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'categories'       => 'nullable|array',
            'categories.*'     => 'exists:categories,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
            'isbn'             => 'nullable|string|max:50',
            'language'         => 'nullable|string|max:50',
        ]);

        $data = [
            'title'            => $request->title,
            'publisher_id'     => $request->publisher_id,
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'source_type'      => $request->source_type,
            'external_url'     => $request->source_type === 'external' ? $request->external_url : null,
            'isbn'             => $request->isbn,
            'language'         => $request->language ?? 'Español',
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('covers', 'public');
        }
        if ($request->hasFile('pdf_file') && $request->source_type === 'pdf') {
            $data['pdf_file_path'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $book->update($data);
        $book->authors()->sync($this->withOrder($request->authors ?? []));
        $book->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.biblioteca.books')->with('success', 'Libro actualizado correctamente.');
    }

    public function editBook(Book $book)
    {
        $book->load(['authors', 'publisher', 'categories']);
        $authors    = Author::orderBy('name')->get();
        $categories = Category::flatTree('biblioteca');
        $publishers = Publisher::orderBy('name')->get();
        return view('admin.biblioteca.books.edit', compact('book', 'authors', 'categories', 'publishers'));
    }

    public function destroyBook(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.biblioteca.books')->with('success', 'Libro eliminado.');
    }

    // ============= AUTORES =============

    public function indexAuthors()
    {
        $authors    = Author::withCount('books')->get();
        $books      = Book::orderBy('title')->get(['id', 'title', 'document_type']);
        $categories = Category::where('type', 'biblioteca')->whereNull('parent_id')->get();
        return view('admin.biblioteca.authors.index', compact('authors', 'books', 'categories'));
    }

    public function createAuthor()
    {
        $books      = Book::orderBy('title')->get(['id', 'title', 'document_type']);
        $categories = Category::where('type', 'biblioteca')->whereNull('parent_id')->get();
        return view('admin.biblioteca.authors.create', compact('books', 'categories'));
    }

    public function storeAuthor(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'biography'   => 'nullable|string',
            'nationality' => 'nullable|string|max:100',
            'books'       => 'nullable|array',
            'books.*'     => 'exists:books,id',
            'categories'  => 'nullable|array',
            'categories.*'=> 'exists:categories,id',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'slug'        => $this->uniqueSlug($request->name, Author::class),
            'biography'   => $request->biography,
            'nationality' => $request->nationality,
        ];
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('authors', 'public');
        }

        $author = Author::create($data);
        $author->books()->sync($this->withOrder($request->books ?? []));
        $author->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.biblioteca.authors')->with('success', 'Autor agregado correctamente.');
    }

    public function updateAuthor(Request $request, Author $author)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'biography'   => 'nullable|string',
            'nationality' => 'nullable|string|max:100',
            'books'       => 'nullable|array',
            'books.*'     => 'exists:books,id',
            'categories'  => 'nullable|array',
            'categories.*'=> 'exists:categories,id',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'biography'   => $request->biography,
            'nationality' => $request->nationality,
        ];
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('authors', 'public');
        }

        $author->update($data);
        $author->books()->sync($this->withOrder($request->books ?? []));
        $author->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.biblioteca.authors')->with('success', 'Autor actualizado correctamente.');
    }

    public function editAuthor(Author $author)
    {
        $author->load(['books', 'categories']);
        $books      = Book::orderBy('title')->get(['id', 'title', 'document_type']);
        $categories = Category::where('type', 'biblioteca')->whereNull('parent_id')->get();
        return view('admin.biblioteca.authors.edit', compact('author', 'books', 'categories'));
    }

    public function destroyAuthor(Author $author)
    {
        $author->delete();
        return redirect()->route('admin.biblioteca.authors')->with('success', 'Autor eliminado.');
    }

    // ============= EDITORIALES =============

    public function indexPublishers()
    {
        $publishers = Publisher::withCount('books')->get();
        $books      = Book::orderBy('title')->get(['id', 'title', 'document_type']);
        return view('admin.biblioteca.publishers.index', compact('publishers', 'books'));
    }

    public function createPublisher()
    {
        return view('admin.biblioteca.publishers.create');
    }

    public function storePublisher(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:50',
            'website'     => 'nullable|url|max:255',
            'address'     => 'nullable|string|max:500',
            'logo'        => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'slug'        => $this->uniqueSlug($request->name, Publisher::class),
            'description' => $request->description,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'website'     => $request->website,
            'address'     => $request->address,
        ];
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('publishers', 'public');
        }

        Publisher::create($data);
        return redirect()->route('admin.biblioteca.publishers')->with('success', 'Editorial agregada correctamente.');
    }

    public function updatePublisher(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:50',
            'website'     => 'nullable|url|max:255',
            'address'     => 'nullable|string|max:500',
            'logo'        => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'website'     => $request->website,
            'address'     => $request->address,
        ];
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('publishers', 'public');
        }

        $publisher->update($data);
        return redirect()->route('admin.biblioteca.publishers')->with('success', 'Editorial actualizada correctamente.');
    }

    public function editPublisher(Publisher $publisher)
    {
        return view('admin.biblioteca.publishers.edit', compact('publisher'));
    }

    public function destroyPublisher(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('admin.biblioteca.publishers')->with('success', 'Editorial eliminada.');
    }

    // ============= CATEGORÍAS =============

    public function indexCategories()
    {
        $allCategories = Category::flatTree('biblioteca');
        return view('admin.biblioteca.categories.index', compact('allCategories'));
    }

    public function createCategory()
    {
        $allCategories = Category::flatTree('biblioteca');
        return view('admin.biblioteca.categories.create', compact('allCategories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => $this->uniqueSlug($request->name, Category::class),
            'description' => $request->description,
            'type'        => 'biblioteca',
            'parent_id'   => $request->parent_id,
        ]);

        return redirect()->route('admin.biblioteca.categories')->with('success', 'Categoría agregada correctamente.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
        ]);

        return redirect()->route('admin.biblioteca.categories')->with('success', 'Categoría actualizada correctamente.');
    }

    public function editCategory(Category $category)
    {
        $allCategories = Category::flatTree('biblioteca');
        return view('admin.biblioteca.categories.edit', compact('category', 'allCategories'));
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.biblioteca.categories')->with('success', 'Categoría eliminada.');
    }

    // ============= REVISTAS =============

    public function indexMagazines()
    {
        $magazines  = Book::where('document_type', 'Revista')
            ->with(['authors', 'publisher', 'categories'])
            ->get();
        $authors    = Author::orderBy('name')->get();
        $categories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();
        $publishers = Publisher::orderBy('name')->get();
        return view('admin.biblioteca.magazines.index', compact('magazines', 'authors', 'categories', 'publishers'));
    }

    public function createMagazine()
    {
        $authors    = Author::orderBy('name')->get();
        $categories = Category::flatTree('biblioteca');
        $publishers = Publisher::orderBy('name')->get();
        return view('admin.biblioteca.magazines.create', compact('authors', 'categories', 'publishers'));
    }

    public function storeMagazine(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'categories'       => 'nullable|array',
            'categories.*'     => 'exists:categories,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'            => $request->title,
            'slug'             => $this->uniqueSlug($request->title, Book::class),
            'document_type'    => 'Revista',
            'publisher_id'     => $request->publisher_id,
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'source_type'      => $request->source_type,
            'external_url'     => $request->source_type === 'external' ? $request->external_url : null,
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('covers', 'public');
        }
        if ($request->hasFile('pdf_file') && $request->source_type === 'pdf') {
            $data['pdf_file_path'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $magazine = Book::create($data);
        $magazine->authors()->sync($this->withOrder($request->authors ?? []));
        $magazine->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.biblioteca.magazines')->with('success', 'Revista agregada correctamente.');
    }

    public function updateMagazine(Request $request, Book $book)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'categories'       => 'nullable|array',
            'categories.*'     => 'exists:categories,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'            => $request->title,
            'publisher_id'     => $request->publisher_id,
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'source_type'      => $request->source_type,
            'external_url'     => $request->source_type === 'external' ? $request->external_url : null,
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('covers', 'public');
        }
        if ($request->hasFile('pdf_file') && $request->source_type === 'pdf') {
            $data['pdf_file_path'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $book->update($data);
        $book->authors()->sync($this->withOrder($request->authors ?? []));
        $book->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.biblioteca.magazines')->with('success', 'Revista actualizada correctamente.');
    }

    public function editMagazine(Book $book)
    {
        $book->load(['authors', 'publisher', 'categories']);
        $authors    = Author::orderBy('name')->get();
        $categories = Category::flatTree('biblioteca');
        $publishers = Publisher::orderBy('name')->get();
        return view('admin.biblioteca.magazines.edit', compact('book', 'authors', 'categories', 'publishers'));
    }

    public function destroyMagazine(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.biblioteca.magazines')->with('success', 'Revista eliminada.');
    }

    // ============= ESPECIALES =============

    public function indexSpecials()
    {
        $books     = Book::where('document_type', '!=', 'Revista')->orderBy('title')->get(['id', 'title', 'document_type', 'is_special']);
        $magazines = Book::where('document_type', 'Revista')->orderBy('title')->get(['id', 'title', 'document_type', 'is_special']);
        return view('admin.biblioteca.specials.index', compact('books', 'magazines'));
    }

    public function toggleSpecial(Request $request, Book $book)
    {
        $book->update(['is_special' => !$book->is_special]);
        return back()->with('success', $book->is_special ? 'Marcado como especial.' : 'Desmarcado como especial.');
    }

    // ============= HELPERS =============

    private function uniqueSlug(string $name, string $model): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;
        while ($model::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function withOrder(array $ids): array
    {
        $result = [];
        foreach ($ids as $i => $id) {
            $result[$id] = ['order' => $i + 1];
        }
        return $result;
    }
}
