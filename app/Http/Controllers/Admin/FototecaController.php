<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\PhotoTag;
use App\Models\Photographer;
use App\Models\Category;
use App\Models\Special;
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
            'categories'    => Category::where('type', 'fototeca')->whereNull('parent_id')->count(),
            'subcategories' => Category::where('type', 'fototeca')->whereNotNull('parent_id')->whereHas('parent', fn($q) => $q->whereNull('parent_id'))->count(),
            'sublevels'     => Category::where('type', 'fototeca')->whereNotNull('parent_id')->whereHas('parent', fn($q) => $q->whereNotNull('parent_id'))->count(),
            'tags'          => PhotoTag::count(),
        ];

        return view('admin.fototeca.index', compact('stats'));
    }

    // ============= FOTOGRAFÍAS =============

    public function indexPhotos()
    {
        $photos = Photo::with(['photographers:id,full_name', 'tag:id,name'])
            ->select('id', 'title', 'slug', 'thumbnail_path', 'full_image_path', 'source_type', 'external_url', 'tag_id', 'location', 'year', 'year_type', 'year_from', 'year_to')
            ->paginate(10);
        return view('admin.fototeca.photos.index', compact('photos'));
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
        $secondlevels     = Category::where('type', 'fototeca')->whereNotNull('parent_id')
                                ->whereHas('parent', fn($q) => $q->whereHas('parent', fn($q2) => $q2->whereNotNull('parent_id')))
                                ->orderBy('name')->get();
        $tags = PhotoTag::orderBy('name')->get();
        return view('admin.fototeca.photos.create', compact('photographers', 'categories', 'subcategories', 'sublevels', 'secondlevels', 'tags'));
    }

    public function storePhoto(Request $request)
    {
        // Filtrar valores vacíos de categories[] antes de validar
        $request->merge([
            'categories' => array_values(array_filter($request->input('categories', []))),
        ]);

        $request->validate([
            'title'           => 'required|string|max:255',
            'photographers'   => 'nullable|array',
            'photographers.*' => 'exists:photographers,id',
            'categories'      => 'nullable|array',
            'categories.*'    => 'integer|exists:categories,id',
            'tag_id'          => 'nullable|exists:photo_tags,id',
            'year_type'       => 'required|in:exact,range',
            'year'            => 'nullable|integer|min:1800|max:' . date('Y'),
            'year_from'       => 'nullable|integer|min:1800|max:' . date('Y'),
            'year_to'         => 'nullable|integer|min:1800|max:' . date('Y'),
            'provider'        => 'nullable|string|max:255',
            'location'        => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'source_type'     => 'required|in:local,external,none',
            'external_url'    => 'nullable|url',
            'image_file'      => 'nullable|image|max:20480',
        ]);

        $yearType = $request->year_type ?? 'exact';
        $data = [
            'title'        => $request->title,
            'slug'         => $this->uniqueSlug($request->title, Photo::class),
            'description'  => $request->description,
            'year_type'    => $yearType,
            'year'         => $yearType === 'exact' ? $request->year : null,
            'year_from'    => $yearType === 'range' ? $request->year_from : null,
            'year_to'      => $yearType === 'range' ? $request->year_to : null,
            'provider'     => $request->provider,
            'location'     => $request->location,
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
        $secondlevels  = Category::where('type', 'fototeca')->whereNotNull('parent_id')
                            ->whereHas('parent', fn($q) => $q->whereHas('parent', fn($q2) => $q2->whereNotNull('parent_id')))
                            ->orderBy('name')->get();

        // Determina qué categoría/subcategoría/subnivel tiene la foto actualmente
        $photoCatIds = $photo->categories->pluck('id')->toArray();
        $selCategory    = $photo->categories->first(fn($c) => $categories->contains('id', $c->id));
        $selSubcategory = $photo->categories->first(fn($c) => $subcategories->contains('id', $c->id));
        $selSublevel    = $photo->categories->first(fn($c) => $sublevels->contains('id', $c->id));
        $selSecondlevel = $photo->categories->first(fn($c) => $secondlevels->contains('id', $c->id));

        $tags = PhotoTag::orderBy('name')->get();
        return view('admin.fototeca.photos.edit', compact(
            'photo', 'photographers', 'categories', 'subcategories', 'sublevels', 'secondlevels',
            'selCategory', 'selSubcategory', 'selSublevel', 'selSecondlevel', 'tags'
        ));
    }

    public function updatePhoto(Request $request, Photo $photo)
    {
        // Filtrar valores vacíos de categories[] antes de validar
        $request->merge([
            'categories' => array_values(array_filter($request->input('categories', []))),
        ]);

        $request->validate([
            'title'           => 'required|string|max:255',
            'photographers'   => 'nullable|array',
            'photographers.*' => 'exists:photographers,id',
            'categories'      => 'nullable|array',
            'categories.*'    => 'integer|exists:categories,id',
            'tag_id'          => 'nullable|exists:photo_tags,id',
            'year_type'       => 'required|in:exact,range',
            'year'            => 'nullable|integer|min:1800|max:' . date('Y'),
            'year_from'       => 'nullable|integer|min:1800|max:' . date('Y'),
            'year_to'         => 'nullable|integer|min:1800|max:' . date('Y'),
            'provider'        => 'nullable|string|max:255',
            'location'        => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'source_type'     => 'required|in:local,external,none',
            'external_url'    => 'nullable|url',
            'image_file'      => 'nullable|image|max:20480',
        ]);

        $yearType = $request->year_type ?? 'exact';
        $data = [
            'title'        => $request->title,
            'description'  => $request->description,
            'year_type'    => $yearType,
            'year'         => $yearType === 'exact' ? $request->year : null,
            'year_from'    => $yearType === 'range' ? $request->year_from : null,
            'year_to'      => $yearType === 'range' ? $request->year_to : null,
            'provider'     => $request->provider,
            'location'     => $request->location,
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
        $photographers = Photographer::withCount('photos as photos_count')->paginate(10);
        return view('admin.fototeca.photographers.index', compact('photographers'));
    }

    public function createPhotographer()
    {
        $collections = Special::where('module', 'fototeca')->orderBy('title')->get(['id', 'title']);
        return view('admin.fototeca.photographers.create', compact('collections'));
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
            'photo'           => 'nullable|image|max:20480',
            'collections'     => 'nullable|array',
            'collections.*'   => 'exists:specials,id',
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

        $p = Photographer::create($data);
        $p->collections()->sync($request->collections ?? []);
        return redirect()->route('admin.fototeca.photographers')->with('success', 'Fotógrafo agregado correctamente.');
    }

    public function editPhotographer(Photographer $photographer)
    {
        $collections = Special::where('module', 'fototeca')->orderBy('title')->get(['id', 'title']);
        return view('admin.fototeca.photographers.edit', compact('photographer', 'collections'));
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
            'photo'            => 'nullable|image|max:20480',
            'collections'      => 'nullable|array',
            'collections.*'    => 'exists:specials,id',
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
        $photographer->collections()->sync($request->collections ?? []);
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
        $categories = Category::where('type', 'fototeca')->whereNull('parent_id')->orderBy('name')->paginate(10);
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
            ->paginate(10);
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
            ->paginate(10);
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
        $tags = PhotoTag::withCount('photos')->orderBy('name')->paginate(10);
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

    public function updateTag(Request $request, PhotoTag $photoTag)
    {
        $request->validate(['name' => 'required|string|max:100|unique:photo_tags,name,' . $photoTag->id]);
        $name = mb_strtolower(trim($request->name));
        $photoTag->update([
            'name' => $name,
            'slug' => $this->uniqueSlug($name, PhotoTag::class, $photoTag->id),
        ]);
        return back()->with('success', 'Etiqueta actualizada correctamente.');
    }

    public function destroyTag(PhotoTag $photoTag)
    {
        $photoTag->delete();
        return redirect()->route('admin.fototeca.tags')->with('success', 'Etiqueta eliminada.');
    }

    public function bulkDestroyTags(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        PhotoTag::whereIn('id', $ids)->delete();
        return back()->with('success', count($ids) . ' etiqueta(s) eliminada(s).');
    }

    // ============= BULK DELETE =============

    public function bulkDestroyPhotos(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Photo::whereIn('id', $ids)->delete();
        return back()->with('success', count($ids) . ' fotografía(s) eliminada(s).');
    }

    public function bulkDestroyPhotographers(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Photographer::whereIn('id', $ids)->each(function($p) {
            if ($p->photo_path) \Storage::disk('public')->delete($p->photo_path);
            $p->delete();
        });
        return back()->with('success', count($ids) . ' fotógrafo(s) eliminado(s).');
    }

    public function bulkDestroyCategories(Request $request)
    {
        $ids     = array_filter(explode(',', $request->input('ids', '')));
        $cascade = $request->boolean('cascade');
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        foreach ($ids as $id) {
            $cat = Category::where('type', 'fototeca')->whereNull('parent_id')->find($id);
            if (!$cat) continue;
            if ($cascade) {
                foreach ($cat->subcategories as $sub) {
                    // delete sublevels (level 3)
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
        $ids     = array_filter(explode(',', $request->input('ids', '')));
        $cascade = $request->boolean('cascade');
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        foreach ($ids as $id) {
            $sub = Category::where('type', 'fototeca')->whereNotNull('parent_id')
                ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
                ->find($id);
            if (!$sub) continue;
            if ($cascade) {
                Category::where('parent_id', $sub->id)->delete();
            }
            $sub->delete();
        }
        return back()->with('success', count($ids) . ' subcategoría(s) eliminada(s).');
    }

    public function bulkDestroySublevels(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Category::whereIn('id', $ids)->where('type', 'fototeca')->delete();
        return back()->with('success', count($ids) . ' subnivel(es) eliminado(s).');
    }

    // ============= 2DO NIVEL (Nivel 4) =============

    public function indexSecondlevels()
    {
        $secondlevels = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereHas('parent', fn($q2) => $q2->whereNotNull('parent_id')))
            ->with(['parent', 'parent.parent', 'parent.parent.parent'])
            ->orderBy('name')
            ->paginate(10);
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNotNull('parent_id')
                ->whereHas('parent', fn($q2) => $q2->whereNull('parent_id')))
            ->with(['parent', 'parent.parent'])
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.secondlevels.index', compact('secondlevels', 'parentCategories'));
    }

    public function createSecondlevel()
    {
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNotNull('parent_id')
                ->whereHas('parent', fn($q2) => $q2->whereNull('parent_id')))
            ->with(['parent', 'parent.parent'])
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.secondlevels.create', compact('parentCategories'));
    }

    public function storeSecondlevel(Request $request)
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

        return redirect()->route('admin.fototeca.secondlevels')->with('success', '2do Nivel agregado correctamente.');
    }

    public function editSecondlevel(Category $category)
    {
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereNotNull('parent_id')
                ->whereHas('parent', fn($q2) => $q2->whereNull('parent_id')))
            ->with(['parent', 'parent.parent'])
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.secondlevels.edit', compact('category', 'parentCategories'));
    }

    public function updateSecondlevel(Request $request, Category $category)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
        ]);

        $category->update([
            'name'      => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.fototeca.secondlevels')->with('success', '2do Nivel actualizado correctamente.');
    }

    public function destroySecondlevel(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.fototeca.secondlevels')->with('success', '2do Nivel eliminado.');
    }

    public function bulkDestroySecondlevels(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Category::whereIn('id', $ids)->where('type', 'fototeca')->delete();
        return back()->with('success', count($ids) . ' 2do nivel(es) eliminado(s).');
    }

    // ============= 3ER NIVEL (Nivel 5) =============

    public function indexThirdlevels()
    {
        $thirdlevels = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereHas('parent', fn($q2) => $q2->whereHas('parent', fn($q3) => $q3->whereNotNull('parent_id'))))
            ->with(['parent', 'parent.parent', 'parent.parent.parent', 'parent.parent.parent.parent'])
            ->orderBy('name')
            ->paginate(10);
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereHas('parent', fn($q2) => $q2->whereNotNull('parent_id')
                ->whereHas('parent', fn($q3) => $q3->whereNull('parent_id'))))
            ->with(['parent', 'parent.parent', 'parent.parent.parent'])
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.thirdlevels.index', compact('thirdlevels', 'parentCategories'));
    }

    public function createThirdlevel()
    {
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereHas('parent', fn($q2) => $q2->whereNotNull('parent_id')
                ->whereHas('parent', fn($q3) => $q3->whereNull('parent_id'))))
            ->with(['parent', 'parent.parent', 'parent.parent.parent'])
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.thirdlevels.create', compact('parentCategories'));
    }

    public function storeThirdlevel(Request $request)
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

        return redirect()->route('admin.fototeca.thirdlevels')->with('success', '3er Nivel agregado correctamente.');
    }

    public function editThirdlevel(Category $category)
    {
        $parentCategories = Category::where('type', 'fototeca')
            ->whereHas('parent', fn($q) => $q->whereHas('parent', fn($q2) => $q2->whereNotNull('parent_id')
                ->whereHas('parent', fn($q3) => $q3->whereNull('parent_id'))))
            ->with(['parent', 'parent.parent', 'parent.parent.parent'])
            ->orderBy('name')
            ->get();
        return view('admin.fototeca.thirdlevels.edit', compact('category', 'parentCategories'));
    }

    public function updateThirdlevel(Request $request, Category $category)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
        ]);

        $category->update([
            'name'      => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.fototeca.thirdlevels')->with('success', '3er Nivel actualizado correctamente.');
    }

    public function destroyThirdlevel(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.fototeca.thirdlevels')->with('success', '3er Nivel eliminado.');
    }

    public function bulkDestroyThirdlevels(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Category::whereIn('id', $ids)->where('type', 'fototeca')->delete();
        return back()->with('success', count($ids) . ' 3er nivel(es) eliminado(s).');
    }

    // ============= COLECCIONES =============

    public function indexCollections()
    {
        $collections = Special::where('module', 'fototeca')->withCount('photos')->orderBy('order')->orderBy('title')->paginate(10);
        return view('admin.fototeca.collections.index', compact('collections'));
    }

    public function createCollection()
    {
        return view('admin.fototeca.collections.create');
    }

    public function storeCollection(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'       => $request->title,
            'slug'        => $this->uniqueSlug($request->title, Special::class),
            'module'      => 'fototeca',
            'type'        => 'libro',
            'description' => $request->description,
            'is_active'   => true,
        ];
        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('collections', 'public');
        }

        Special::create($data);
        return redirect()->route('admin.fototeca.collections')->with('success', 'Colección creada correctamente.');
    }

    public function editCollection(Special $special)
    {
        return view('admin.fototeca.collections.edit', compact('special'));
    }

    public function updateCollection(Request $request, Special $special)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];
        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('collections', 'public');
        }

        $special->update($data);
        return redirect()->route('admin.fototeca.collections')->with('success', 'Colección actualizada correctamente.');
    }

    public function destroyCollection(Special $special)
    {
        $special->delete();
        return redirect()->route('admin.fototeca.collections')->with('success', 'Colección eliminada.');
    }

    public function bulkDestroyCollections(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        Special::whereIn('id', $ids)->where('module', 'fototeca')->delete();
        return back()->with('success', count($ids) . ' colección(es) eliminada(s).');
    }

    public function assignCollectionsIndex()
    {
        $collections = Special::where('module', 'fototeca')->withCount('photos')->orderBy('order')->orderBy('title')->get();
        return view('admin.fototeca.collections.assign', compact('collections'));
    }

    public function manageCollection(Special $special)
    {
        $special->load('photos');
        $assignedIds = $special->photos->pluck('id')->toArray();
        $available   = Photo::whereNotIn('id', $assignedIds)->orderBy('title')->get(['id', 'title', 'year', 'year_type', 'year_from', 'year_to']);
        return view('admin.fototeca.collections.manage', compact('special', 'available'));
    }

    public function assignPhoto(Request $request, Special $special)
    {
        $request->validate(['photo_id' => 'required|exists:photos,id']);
        $maxOrder = $special->photos()->max('photo_special.order') ?? 0;
        $special->photos()->syncWithoutDetaching([$request->photo_id => ['order' => $maxOrder + 1]]);

        if ($request->expectsJson()) {
            $photo = Photo::find($request->photo_id);
            return response()->json(['success' => true, 'title' => $photo->title, 'photo_id' => $photo->id]);
        }
        return back()->with('success', 'Fotografía agregada a la colección.');
    }

    public function unassignPhoto(Special $special, Photo $photo)
    {
        $special->photos()->detach($photo->id);
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Fotografía quitada de la colección.');
    }

    public function clearCollection(Special $special)
    {
        $special->photos()->detach();
        return redirect()->route('admin.fototeca.collections.manage', $special)->with('success', 'Colección vaciada.');
    }

    // ============= HELPERS =============

    private function uniqueSlug(string $name, string $model, ?int $excludeId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;
        while ($model::where('slug', $slug)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
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
