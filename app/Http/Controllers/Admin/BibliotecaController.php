<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Special;
use App\Models\Descriptor;
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
            ->paginate(10);
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
        $authors     = Author::orderBy('name')->get();
        $categories  = Category::where('type', 'biblioteca')->whereNull('parent_id')->with('subcategories')->orderBy('name')->get();
        $descriptors = Descriptor::orderBy('name')->get();
        return view('admin.biblioteca.books.create', compact('authors', 'categories', 'descriptors'));
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'document_type'    => 'required|in:Libro,Revista,Artículo,Tesis',
            'section'          => 'required|in:Biblioteca Digital,Waras Editorial',
            'category_id'      => 'nullable|exists:categories,id',
            'subcategory_id'   => 'nullable|exists:categories,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'imprint'          => 'nullable|string|max:500',
            'descriptors'      => 'nullable|array',
            'descriptors.*'    => 'exists:descriptors,id',
            'provider'         => 'nullable|string|max:500',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'            => $request->title,
            'slug'             => $this->uniqueSlug($request->title, Book::class),
            'document_type'    => $request->document_type,
            'section'          => $request->input('section', 'Biblioteca Digital'),
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'imprint'          => $request->imprint,
            'provider'         => $request->provider,
            'source_type'      => $request->source_type,
            'external_url'     => $request->source_type === 'external' ? $request->external_url : null,
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('covers', 'public');
        }
        if ($request->hasFile('pdf_file') && $request->source_type === 'pdf') {
            $data['pdf_file_path'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $book = Book::create($data);
        $book->authors()->sync($this->withOrder($request->authors ?? []));
        $book->descriptors()->sync($request->descriptors ?? []);
        $catIds = array_filter([$request->category_id, $request->subcategory_id]);
        $book->categories()->sync($catIds);

        return redirect()->route('admin.biblioteca.books')->with('success', 'Libro agregado correctamente.');
    }

    public function updateBook(Request $request, Book $book)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'document_type'    => 'required|in:Libro,Revista,Artículo,Tesis',
            'section'          => 'required|in:Biblioteca Digital,Waras Editorial',
            'category_id'      => 'nullable|exists:categories,id',
            'subcategory_id'   => 'nullable|exists:categories,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'imprint'          => 'nullable|string|max:500',
            'descriptors'      => 'nullable|array',
            'descriptors.*'    => 'exists:descriptors,id',
            'provider'         => 'nullable|string|max:500',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'            => $request->title,
            'document_type'    => $request->document_type,
            'section'          => $request->section,
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'imprint'          => $request->imprint,
            'provider'         => $request->provider,
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
        $book->descriptors()->sync($request->descriptors ?? []);
        $catIds = array_filter([$request->category_id, $request->subcategory_id]);
        $book->categories()->sync($catIds);

        return redirect()->route('admin.biblioteca.books')->with('success', 'Libro actualizado correctamente.');
    }

    public function editBook(Book $book)
    {
        $book->load(['authors', 'categories', 'descriptors']);
        $authors     = Author::orderBy('name')->get();
        $categories  = Category::where('type', 'biblioteca')->whereNull('parent_id')->with('subcategories')->orderBy('name')->get();
        $descriptors = Descriptor::orderBy('name')->get();
        return view('admin.biblioteca.books.edit', compact('book', 'authors', 'categories', 'descriptors'));
    }

    public function destroyBook(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.biblioteca.books')->with('success', 'Libro eliminado.');
    }

    // ============= AUTORES =============

    public function indexAuthors()
    {
        $authors    = Author::withCount('books')->paginate(10);
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
        $publishers = Publisher::withCount('books')->paginate(10);
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
        $allCategories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->paginate(10);
        return view('admin.biblioteca.categories.index', compact('allCategories'));
    }

    public function createCategory()
    {
        return view('admin.biblioteca.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Category::create([
            'name'      => $request->name,
            'slug'      => $this->uniqueSlug($request->name, Category::class),
            'type'      => 'biblioteca',
            'parent_id' => null,
        ]);

        return redirect()->route('admin.biblioteca.categories')->with('success', 'Categoría agregada correctamente.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $category->update(['name' => $request->name]);

        return redirect()->route('admin.biblioteca.categories')->with('success', 'Categoría actualizada correctamente.');
    }

    public function editCategory(Category $category)
    {
        return view('admin.biblioteca.categories.edit', compact('category'));
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.biblioteca.categories')->with('success', 'Categoría eliminada.');
    }

    // ============= SUBCATEGORÍAS =============

    public function createSubcategory()
    {
        $parentCategories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
        return view('admin.biblioteca.subcategories.create', compact('parentCategories'));
    }

    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
        ]);

        Category::create([
            'name'      => $request->name,
            'slug'      => $this->uniqueSlug($request->name, Category::class),
            'type'      => 'biblioteca',
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.biblioteca.subcategories')->with('success', 'Subcategoría agregada correctamente.');
    }

    public function editSubcategory(Category $category)
    {
        $parentCategories = Category::where('type', 'biblioteca')
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();
        return view('admin.biblioteca.subcategories.edit', compact('category', 'parentCategories'));
    }

    public function updateSubcategory(Request $request, Category $category)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
        ]);

        $category->update([
            'name'      => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.biblioteca.subcategories')->with('success', 'Subcategoría actualizada correctamente.');
    }

    public function destroySubcategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.biblioteca.subcategories')->with('success', 'Subcategoría eliminada.');
    }

    // ============= REVISTAS =============

    public function indexMagazines()
    {
        $magazines  = Book::where('document_type', 'Revista')
            ->with(['authors', 'publisher', 'categories'])
            ->paginate(10);
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
        $authors     = Author::orderBy('name')->get();
        $categories  = Category::where('type', 'biblioteca')->whereNull('parent_id')->with('subcategories')->orderBy('name')->get();
        $descriptors = Descriptor::orderBy('name')->get();
        return view('admin.biblioteca.magazines.create', compact('authors', 'categories', 'descriptors'));
    }

    public function storeMagazine(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'document_type'    => 'required|in:Libro,Revista,Artículo,Tesis',
            'category_id'      => 'nullable|exists:categories,id',
            'subcategory_id'   => 'nullable|exists:categories,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'imprint'          => 'nullable|string|max:500',
            'descriptors'      => 'nullable|array',
            'descriptors.*'    => 'exists:descriptors,id',
            'provider'         => 'nullable|string|max:500',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'            => $request->title,
            'slug'             => $this->uniqueSlug($request->title, Book::class),
            'document_type'    => $request->document_type,
            'section'          => 'Biblioteca Digital',
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'imprint'          => $request->imprint,
            'provider'         => $request->provider,
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
        $magazine->descriptors()->sync($request->descriptors ?? []);
        $catIds = array_filter([$request->category_id, $request->subcategory_id]);
        $magazine->categories()->sync($catIds);

        return redirect()->route('admin.biblioteca.magazines')->with('success', 'Revista agregada correctamente.');
    }

    public function updateMagazine(Request $request, Book $book)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'document_type'    => 'required|in:Libro,Revista,Artículo,Tesis',
            'category_id'      => 'nullable|exists:categories,id',
            'subcategory_id'   => 'nullable|exists:categories,id',
            'publication_date' => 'nullable|date',
            'pages'            => 'nullable|integer|min:1',
            'summary'          => 'nullable|string',
            'imprint'          => 'nullable|string|max:500',
            'descriptors'      => 'nullable|array',
            'descriptors.*'    => 'exists:descriptors,id',
            'provider'         => 'nullable|string|max:500',
            'source_type'      => 'required|in:external,pdf,none',
            'external_url'     => 'nullable|url',
            'pdf_file'         => 'nullable|file|mimes:pdf|max:51200',
            'cover_image'      => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'            => $request->title,
            'document_type'    => $request->document_type,
            'section'          => 'Biblioteca Digital',
            'publication_date' => $request->publication_date,
            'pages'            => $request->pages,
            'summary'          => $request->summary,
            'imprint'          => $request->imprint,
            'provider'         => $request->provider,
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
        $book->descriptors()->sync($request->descriptors ?? []);
        $catIds = array_filter([$request->category_id, $request->subcategory_id]);
        $book->categories()->sync($catIds);

        return redirect()->route('admin.biblioteca.magazines')->with('success', 'Revista actualizada correctamente.');
    }

    public function editMagazine(Book $book)
    {
        $book->load(['authors', 'categories', 'descriptors']);
        $authors     = Author::orderBy('name')->get();
        $categories  = Category::where('type', 'biblioteca')->whereNull('parent_id')->with('subcategories')->orderBy('name')->get();
        $descriptors = Descriptor::orderBy('name')->get();
        return view('admin.biblioteca.magazines.edit', compact('book', 'authors', 'categories', 'descriptors'));
    }

    public function destroyMagazine(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.biblioteca.magazines')->with('success', 'Revista eliminada.');
    }

    // ============= DESCRIPTORES =============

    public function indexDescriptors()
    {
        $descriptors = Descriptor::withCount('books')->orderBy('name')->paginate(10);
        return view('admin.biblioteca.descriptors.index', compact('descriptors'));
    }

    public function storeDescriptor(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:descriptors,name']);

        Descriptor::create([
            'name' => strtolower(trim($request->name)),
            'slug' => $this->uniqueSlug($request->name, Descriptor::class),
        ]);

        return back()->with('success', 'Descriptor agregado correctamente.');
    }

    public function destroyDescriptor(Descriptor $descriptor)
    {
        $descriptor->delete();
        return back()->with('success', 'Descriptor eliminado.');
    }

    // ============= SUBCATEGORÍAS =============

    public function indexSubcategories()
    {
        $subcategories = Category::where('type', 'biblioteca')
            ->whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->paginate(10);
        return view('admin.biblioteca.subcategories.index', compact('subcategories'));
    }

    // ============= ESPECIALES =============

    public function indexSpecials()
    {
        $specials = Special::withCount('books')->orderBy('order')->orderBy('title')->paginate(10);
        return view('admin.biblioteca.specials.index', compact('specials'));
    }

    public function createSpecial()
    {
        return view('admin.biblioteca.specials.create');
    }

    public function storeSpecial(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:libro,revista',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'     => $request->title,
            'slug'      => $this->uniqueSlug($request->title, Special::class),
            'type'      => $request->type,
            'is_active' => true,
        ];
        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('specials', 'public');
        }

        Special::create($data);
        return redirect()->route('admin.biblioteca.specials')->with('success', 'Colección especial creada correctamente.');
    }

    public function editSpecial(Special $special)
    {
        return view('admin.biblioteca.specials.edit', compact('special'));
    }

    public function updateSpecial(Request $request, Special $special)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:libro,revista',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'title' => $request->title,
            'type'  => $request->type,
        ];
        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('specials', 'public');
        }

        $special->update($data);
        return redirect()->route('admin.biblioteca.specials')->with('success', 'Colección especial actualizada.');
    }

    public function destroySpecial(Special $special)
    {
        $special->delete();
        return redirect()->route('admin.biblioteca.specials')->with('success', 'Colección eliminada.');
    }

    public function assignBooksIndex()
    {
        $specials = Special::withCount('books')->orderBy('order')->orderBy('title')->get();
        return view('admin.biblioteca.specials.assign', compact('specials'));
    }

    public function manageSpecial(Special $special)
    {
        $special->load('books');
        $isRevista    = $special->type === 'revista';
        $assignedIds  = $special->books->pluck('id')->toArray();
        $available    = $isRevista
            ? Book::where('document_type', 'Revista')->whereNotIn('id', $assignedIds)->orderBy('title')->get(['id', 'title'])
            : Book::where('document_type', '!=', 'Revista')->whereNotIn('id', $assignedIds)->orderBy('title')->get(['id', 'title']);
        return view('admin.biblioteca.specials.manage', compact('special', 'available'));
    }

    public function assignBook(Request $request, Special $special)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);
        $maxOrder = $special->books()->max('book_special.order') ?? 0;
        $special->books()->syncWithoutDetaching([$request->book_id => ['order' => $maxOrder + 1]]);

        if ($request->expectsJson()) {
            $book = Book::find($request->book_id);
            return response()->json(['success' => true, 'title' => $book->title, 'book_id' => $book->id]);
        }
        return back()->with('success', 'Elemento agregado a la colección.');
    }

    public function unassignBook(Special $special, Book $book)
    {
        $special->books()->detach($book->id);

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Elemento quitado de la colección.');
    }

    public function clearSpecial(Special $special)
    {
        $special->books()->detach();
        return redirect()->route('admin.biblioteca.specials.edit', $special)
            ->with('success', 'Todos los elementos han sido quitados de la colección.');
    }

    public function destroySpecialCover(Special $special)
    {
        if ($special->cover_image_path) {
            \Storage::disk('public')->delete($special->cover_image_path);
            $special->update(['cover_image_path' => null]);
        }
        return redirect()->route('admin.biblioteca.specials.edit', $special)
            ->with('success', 'Imagen de portada eliminada.');
    }

    // ============= BULK DELETE =============

    public function bulkDestroyBooks(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Book::whereIn('id', $ids)->where('type', 'libro')->each(function($b) {
            if ($b->cover_image_path) \Storage::disk('public')->delete($b->cover_image_path);
            $b->delete();
        });
        return back()->with('success', count($ids) . ' libro(s) eliminado(s).');
    }

    public function bulkDestroyMagazines(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Book::whereIn('id', $ids)->where('type', 'revista')->each(function($b) {
            if ($b->cover_image_path) \Storage::disk('public')->delete($b->cover_image_path);
            $b->delete();
        });
        return back()->with('success', count($ids) . ' revista(s) eliminada(s).');
    }

    public function bulkDestroyAuthors(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Author::whereIn('id', $ids)->each(function($a) {
            if ($a->photo_path) \Storage::disk('public')->delete($a->photo_path);
            $a->delete();
        });
        return back()->with('success', count($ids) . ' autor(es) eliminado(s).');
    }

    public function bulkDestroyPublishers(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Publisher::whereIn('id', $ids)->each(function($p) {
            if ($p->logo_path) \Storage::disk('public')->delete($p->logo_path);
            $p->delete();
        });
        return back()->with('success', count($ids) . ' editorial(es) eliminada(s).');
    }

    public function bulkDestroyCategories(Request $request)
    {
        $ids     = array_filter(explode(',', $request->input('ids', '')));
        $cascade = $request->boolean('cascade');
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        foreach ($ids as $id) {
            $cat = Category::where('type', 'biblioteca')->whereNull('parent_id')->find($id);
            if (!$cat) continue;
            if ($cascade) {
                // delete all subcategories (level 2) and their children (level 3)
                foreach ($cat->subcategories as $sub) {
                    Category::where('parent_id', $sub->id)->delete();
                    $sub->delete();
                }
            }
            $cat->delete();
        }
        return back()->with('success', count($ids) . ' categoría(s) eliminada(s).');
    }

    public function bulkDestroySubcategories(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Category::whereIn('id', $ids)->where('type', 'biblioteca')->whereNotNull('parent_id')->delete();
        return back()->with('success', count($ids) . ' subcategoría(s) eliminada(s).');
    }

    public function bulkDestroySpecials(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Special::whereIn('id', $ids)->each(function($s) {
            if ($s->cover_image_path) \Storage::disk('public')->delete($s->cover_image_path);
            $s->books()->detach();
            $s->delete();
        });
        return back()->with('success', count($ids) . ' colección(es) eliminada(s).');
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
