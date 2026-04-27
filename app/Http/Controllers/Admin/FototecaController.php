<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\PhotoTag;
use App\Models\Photographer;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FototecaController extends Controller
{
    // ============= DASHBOARD DEL MÓDULO =============

    public function adminIndex()
    {
        $stats = [
            'photos'        => Photo::count(),
            'photographers' => Photographer::count(),
            'categories'    => Category::where('type', 'fototeca')->count(),
        ];

        return view('admin.fototeca.index', compact('stats'));
    }

    // ============= FOTOGRAFÍAS =============

    public function indexPhotos()
    {
        $photos = Photo::with(['photographers', 'categories'])->get();
        $photographers = Photographer::orderBy('full_name')->get();
        $categories = Category::flatTree('fototeca');
        return view('admin.fototeca.photos.index', compact('photos', 'photographers', 'categories'));
    }

    public function createPhoto()
    {
        $photographers    = Photographer::orderBy('full_name')->get();
        $categories       = Category::where('type', 'fototeca')->whereNull('parent_id')->orderBy('name')->get();
        $subcategories    = Category::where('type', 'fototeca')->whereNotNull('parent_id')
                                ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
                                ->orderBy('name')->get();
        $sublevels        = Category::where('type', 'fototeca')->whereNotNull('parent_id')
                                ->whereHas('parent', fn($q) => $q->whereNotNull('parent_id'))
                                ->orderBy('name')->get();
        $tags = PhotoTag::orderBy('name')->get();
        return view('admin.fototeca.photos.create', compact('photographers', 'categories', 'subcategories', 'sublevels', 'tags'));
    }

    public function storePhoto(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'photographers'   => 'nullable|array',
            'photographers.*' => 'exists:photographers,id',
            'categories'      => 'nullable|array',
            'categories.*'    => 'exists:categories,id',
            'tag_id'          => 'nullable|exists:photo_tags,id',
            'year'            => 'nullable|integer|min:1800|max:' . date('Y'),
            'provider'        => 'nullable|string|max:255',
            'resolution'      => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'format'          => 'nullable|string|max:50',
            'source_type'     => 'required|in:local,external,none',
            'external_url'    => 'nullable|url',
            'image_file'      => 'nullable|image|max:10240',
        ]);

        $data = [
            'title'        => $request->title,
            'slug'         => $this->uniqueSlug($request->title, Photo::class),
            'description'  => $request->description,
            'year'         => $request->year,
            'provider'     => $request->provider,
            'resolution'   => $request->resolution,
            'location'     => $request->location,
            'format'       => $request->format,
            'tag_id'       => $request->tag_id ?: null,
            'source_type'  => $request->source_type,
            'external_url' => $request->source_type === 'external' ? $request->external_url : null,
        ];

        if ($request->source_type === 'external') {
            $data['full_image_path'] = null;
            $data['thumbnail_path']  = null;
        } elseif ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('photos', 'public');
            $data['full_image_path'] = $path;
            $data['thumbnail_path']  = $path;
        }

        $photo = Photo::create($data);
        $photo->photographers()->sync($this->withOrder($request->photographers ?? []));
        $photo->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.fototeca.photos')->with('success', 'Fotografía agregada correctamente.');
    }

    public function editPhoto(Photo $photo)
    {
        $photo->load(['photographers', 'categories']);
        $photographers = Photographer::orderBy('full_name')->get();
        $categories    = Category::where('type', 'fototeca')->whereNull('parent_id')->orderBy('name')->get();
        $subcategories = Category::where('type', 'fototeca')->whereNotNull('parent_id')
                            ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
                            ->orderBy('name')->get();
        $sublevels     = Category::where('type', 'fototeca')->whereNotNull('parent_id')
                            ->whereHas('parent', fn($q) => $q->whereNotNull('parent_id'))
                            ->orderBy('name')->get();

        // Determina qué categoría/subcategoría/subnivel tiene la foto actualmente
        $photoCatIds = $photo->categories->pluck('id')->toArray();
        $selCategory    = $photo->categories->first(fn($c) => $categories->contains('id', $c->id));
        $selSubcategory = $photo->categories->first(fn($c) => $subcategories->contains('id', $c->id));
        $selSublevel    = $photo->categories->first(fn($c) => $sublevels->contains('id', $c->id));

        $tags = PhotoTag::orderBy('name')->get();
        return view('admin.fototeca.photos.edit', compact(
            'photo', 'photographers', 'categories', 'subcategories', 'sublevels',
            'selCategory', 'selSubcategory', 'selSublevel', 'tags'
        ));
    }

    public function updatePhoto(Request $request, Photo $photo)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'photographers'   => 'nullable|array',
            'photographers.*' => 'exists:photographers,id',
            'categories'      => 'nullable|array',
            'categories.*'    => 'exists:categories,id',
            'tag_id'          => 'nullable|exists:photo_tags,id',
            'year'            => 'nullable|integer|min:1800|max:' . date('Y'),
            'provider'        => 'nullable|string|max:255',
            'resolution'      => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'format'          => 'nullable|string|max:50',
            'source_type'     => 'required|in:local,external,none',
            'external_url'    => 'nullable|url',
            'image_file'      => 'nullable|image|max:10240',
        ]);

        $data = [
            'title'        => $request->title,
            'description'  => $request->description,
            'year'         => $request->year,
            'provider'     => $request->provider,
            'resolution'   => $request->resolution,
            'location'     => $request->location,
            'format'       => $request->format,
            'tag_id'       => $request->tag_id ?: null,
            'source_type'  => $request->source_type,
            'external_url' => $request->source_type === 'external' ? $request->external_url : null,
        ];

        if ($request->source_type === 'external') {
            $data['full_image_path'] = null;
            $data['thumbnail_path']  = null;
        } elseif ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('photos', 'public');
            $data['full_image_path'] = $path;
            $data['thumbnail_path']  = $path;
        }

        $photo->update($data);
        $photo->photographers()->sync($this->withOrder($request->photographers ?? []));
        $photo->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.fototeca.photos')->with('success', 'Fotografía actualizada correctamente.');
    }

    public function destroyPhoto(Photo $photo)
    {
        $photo->delete();
        return redirect()->route('admin.fototeca.photos')->with('success', 'Fotografía eliminada.');
    }

    // ============= FOTÓGRAFOS =============

    public function indexPhotographers()
    {
        $photographers = Photographer::withCount('photos as photos_count')->get();
        return view('admin.fototeca.photographers.index', compact('photographers'));
    }

    public function createPhotographer()
    {
        return view('admin.fototeca.photographers.create');
    }

    public function storePhotographer(Request $request)
    {
        $request->validate([
            'full_name'       => 'required|string|max:255',
            'birth_place'     => 'nullable|string|max:255',
            'birth_date'      => 'nullable|date',
            'death_place'     => 'nullable|string|max:255',
            'death_date'      => 'nullable|date',
            'biography'       => 'nullable|string',
            'studies_critique'=> 'nullable|string',
            'photo'           => 'nullable|image|max:2048',
        ]);

        $data = [
            'full_name'        => $request->full_name,
            'slug'             => $this->uniqueSlug($request->full_name, Photographer::class),
            'birth_place'      => $request->birth_place,
            'birth_date'       => $request->birth_date,
            'death_place'      => $request->death_place,
            'death_date'       => $request->death_date,
            'biography'        => $request->biography,
            'studies_critique' => $request->studies_critique,
        ];
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('photographers', 'public');
        }

        Photographer::create($data);
        return redirect()->route('admin.fototeca.photographers')->with('success', 'Fotógrafo agregado correctamente.');
    }

    public function editPhotographer(Photographer $photographer)
    {
        return view('admin.fototeca.photographers.edit', compact('photographer'));
    }

    public function updatePhotographer(Request $request, Photographer $photographer)
    {
        $request->validate([
            'full_name'        => 'required|string|max:255',
            'birth_place'      => 'nullable|string|max:255',
            'birth_date'       => 'nullable|date',
            'death_place'      => 'nullable|string|max:255',
            'death_date'       => 'nullable|date',
            'biography'        => 'nullable|string',
            'studies_critique' => 'nullable|string',
            'photo'            => 'nullable|image|max:2048',
        ]);

        $data = [
            'full_name'        => $request->full_name,
            'birth_place'      => $request->birth_place,
            'birth_date'       => $request->birth_date,
            'death_place'      => $request->death_place,
            'death_date'       => $request->death_date,
            'biography'        => $request->biography,
            'studies_critique' => $request->studies_critique,
        ];
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('photographers', 'public');
        }

        $photographer->update($data);
        return redirect()->route('admin.fototeca.photographers')->with('success', 'Fotógrafo actualizado correctamente.');
    }

    public function destroyPhotographer(Photographer $photographer)
    {
        $photographer->delete();
        return redirect()->route('admin.fototeca.photographers')->with('success', 'Fotógrafo eliminado.');
    }

    // ============= CATEGORÍAS (Nivel 1) =============

    public function indexCategories()
    {
        $categories = Category::where('type', 'fototeca')->whereNull('parent_id')->orderBy('name')->get();
        return view('admin.fototeca.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.fototeca.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => $this->uniqueSlug($request->name, Category::class),
            'description' => $request->description,
            'type'        => 'fototeca',
            'parent_id'   => null,
        ]);

        return redirect()->route('admin.fototeca.categories')->with('success', 'Categoría agregada correctamente.');
    }

    public function editCategory(Category $category)
    {
        return view('admin.fototeca.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.fototeca.categories')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.fototeca.categories')->with('success', 'Categoría eliminada.');
    }

    // ============= SUBCATEGORÍAS (Nivel 2) =============

    public function indexSubcategories()
    {
        $subcategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
            ->with('parent')
            ->orderBy('name')
            ->get();
        $parentCategories = Category::where('type', 'fototeca')->whereNull('parent_id')->orderBy('name')->get();
        return view('admin.fototeca.subcategories.index', compact('subcategories', 'parentCategories'));
    }

    public function createSubcategory()
    {
        $parentCategories = Category::where('type', 'fototeca')->whereNull('parent_id')->orderBy('name')->get();
        return view('admin.fototeca.subcategories.create', compact('parentCategories'));
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
            'type'      => 'fototeca',
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.fototeca.subcategories')->with('success', 'SubCategoría agregada correctamente.');
    }

    public function editSubcategory(Category $category)
    {
        $parentCategories = Category::where('type', 'fototeca')->whereNull('parent_id')->orderBy('name')->get();
        return view('admin.fototeca.subcategories.edit', compact('category', 'parentCategories'));
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

        return redirect()->route('admin.fototeca.subcategories')->with('success', 'SubCategoría actualizada correctamente.');
    }

    public function destroySubcategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.fototeca.subcategories')->with('success', 'SubCategoría eliminada.');
    }

    // ============= SUBNIVEL (Nivel 3) =============

    public function indexSublevels()
    {
        $sublevels = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNotNull('parent_id'))
            ->with(['parent', 'parent.parent'])
            ->orderBy('name')
            ->get();
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
            ->with('parent')
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.sublevels.index', compact('sublevels', 'parentCategories'));
    }

    public function createSublevel()
    {
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
            ->with('parent')
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.sublevels.create', compact('parentCategories'));
    }

    public function storeSublevel(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
        ]);

        Category::create([
            'name'      => $request->name,
            'slug'      => $this->uniqueSlug($request->name, Category::class),
            'type'      => 'fototeca',
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.fototeca.sublevels')->with('success', 'SubNivel agregado correctamente.');
    }

    public function editSublevel(Category $category)
    {
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
            ->with('parent')
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.sublevels.edit', compact('category', 'parentCategories'));
    }

    public function updateSublevel(Request $request, Category $category)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
        ]);

        $category->update([
            'name'      => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.fototeca.sublevels')->with('success', 'SubNivel actualizado correctamente.');
    }

    public function destroySublevel(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.fototeca.sublevels')->with('success', 'SubNivel eliminado.');
    }

    // ============= ETIQUETAS =============

    public function indexTags()
    {
        $tags = PhotoTag::withCount('photos')->orderBy('name')->get();
        return view('admin.fototeca.tags.index', compact('tags'));
    }

    public function storeTag(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:photo_tags,name']);
        $name = mb_strtolower(trim($request->name));
        PhotoTag::create([
            'name' => $name,
            'slug' => $this->uniqueSlug($name, PhotoTag::class),
        ]);
        return redirect()->route('admin.fototeca.tags')->with('success', 'Etiqueta agregada correctamente.');
    }

    public function destroyTag(PhotoTag $photoTag)
    {
        $photoTag->delete();
        return redirect()->route('admin.fototeca.tags')->with('success', 'Etiqueta eliminada.');
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
