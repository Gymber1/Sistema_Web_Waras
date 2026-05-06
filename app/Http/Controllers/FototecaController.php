<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\PhotoTag;
use App\Models\Photographer;
use App\Models\Category;
use App\Models\SiteSetting;

class FototecaController extends Controller
{
    private function dashboardData(string $activeSection): array
    {
        $totalPhotos        = Photo::count();
        $totalPhotographers = Photographer::count();
        $totalCategories    = Category::where('type', 'fototeca')->count();

        $allPhotos = Photo::with(['photographers', 'categories', 'tag'])->get();

        $photosByCategory = [];
        foreach ($allPhotos as $photo) {
            $photographerName = $photo->photographers->first()?->full_name ?? 'Desconocido';
            $photoData = [
                'id'           => $photo->id,
                'title'        => $photo->title,
                'photographer' => $photographerName,
                'year'         => $photo->year_type === 'range' && $photo->year_from
                                    ? $photo->year_from . '–' . ($photo->year_to ?? '?')
                                    : ($photo->year ?? 'S/F'),
                'source_type'  => $photo->source_type ?? 'local',
                'image_url'    => $photo->thumbnail_url,
                'description'  => $photo->description ?? '',
                'location'     => $photo->location ?? '',
                'external_url' => $photo->external_url ?? '',
                'detail_url'   => '/fototeca/galeria/' . $photo->id,
                'tag_id'       => $photo->tag_id,
                'tag_name'     => $photo->tag?->name ?? '',
                'categories'   => $photo->categories->pluck('name')->toArray(),
            ];
            foreach ($photo->categories as $cat) {
                $photosByCategory[$cat->name][] = $photoData;
            }
            if ($photo->categories->isEmpty()) {
                $photosByCategory['Sin Categoría'][] = $photoData;
            }
        }

        $photographersData = Photographer::withCount('photos')->get()->map(fn($p) => [
            'id'           => $p->id,
            'full_name'    => $p->full_name,
            'photos_count' => $p->photos_count,
            'biography'    => $p->biography ?? '',
            'photo_path'   => $p->photo_path ? '/storage/' . $p->photo_path : null,
        ])->values()->toArray();

        $allCategories = Category::where('type', 'fototeca')
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

        $tagsData = PhotoTag::withCount('photos')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'photos_count'])
            ->toArray();

        return [
            'totalPhotos'          => $totalPhotos,
            'totalPhotographers'   => $totalPhotographers,
            'totalCategories'      => $totalCategories,
            'photosByCategory'     => $photosByCategory,
            'photographersData'    => $photographersData,
            'categoriesForFilters' => $buildTree($allCategories),
            'tagsData'             => $tagsData,
            'activeSection'        => $activeSection,
            'canEditPanel'         => auth()->check() && (auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca')),
            'heroBg'               => ($p = SiteSetting::get('bg_fototeca')) ? asset('storage/' . $p) : null,
        ];
    }

    public function index()
    {
        return view('fototeca.dashboard', $this->dashboardData('Inicio'));
    }

    public function indexGaleria()    { return view('fototeca.dashboard', $this->dashboardData('Galería')); }
    public function indexFotografos() { return view('fototeca.dashboard', $this->dashboardData('Fotógrafos')); }
    public function indexAportantes() { return view('fototeca.dashboard', $this->dashboardData('Aportantes')); }

    public function showPhoto(\App\Models\Photo $photo)
    {
        $photo->load(['photographers', 'categories']);

        $catIds = $photo->categories->pluck('id');
        $related = \App\Models\Photo::where('id', '!=', $photo->id)
            ->when($catIds->isNotEmpty(), fn($q) =>
                $q->whereHas('categories', fn($q2) => $q2->whereIn('categories.id', $catIds))
            )
            ->with(['photographers', 'categories'])
            ->inRandomOrder()
            ->limit(6)
            ->get();

        if ($related->count() < 4) {
            $extra = \App\Models\Photo::where('id', '!=', $photo->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->with(['photographers', 'categories'])
                ->inRandomOrder()
                ->limit(6 - $related->count())
                ->get();
            $related = $related->merge($extra);
        }

        return view('fototeca.foto', compact('photo', 'related'));
    }

    public function showPhotographer(\App\Models\Photographer $photographer)
    {
        $photographer->load(['collections.photos', 'photos.categories']);
        return view('fototeca.fotografo', compact('photographer'));
    }

    public function indexColecciones()
    {
        $colecciones = \App\Models\Special::where('module', 'fototeca')
            ->where('is_active', true)
            ->withCount('photos')
            ->orderBy('order')
            ->orderBy('title')
            ->get();
        return view('fototeca.colecciones', compact('colecciones'));
    }

    public function showColeccion(\App\Models\Special $special)
    {
        abort_if($special->module !== 'fototeca', 404);
        $special->load(['photos.photographers', 'photos.categories']);
        return view('fototeca.coleccion', compact('special'));
    }

    public function getPhotosByCategory($categoryId)
    {
        $photos = Photo::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->with(['photographers', 'categories', 'tag'])->paginate(20);

        return response()->json($photos);
    }

    public function getPhotosByTag(\App\Models\PhotoTag $photoTag)
    {
        $photos = $photoTag->photos()
            ->with(['photographers', 'categories', 'tag'])
            ->paginate(20);

        return response()->json($photos);
    }

    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        $photos = Photo::where(function ($query) use ($q) {
            $query->where('title', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhere('location', 'like', "%{$q}%")
                  ->orWhereHas('photographers', fn($pq) => $pq->where('full_name', 'like', "%{$q}%"))
                  ->orWhereHas('tag', fn($tq) => $tq->where('name', 'like', "%{$q}%"));
        })
        ->with(['photographers', 'categories', 'tag'])
        ->paginate(20);

        return response()->json($photos);
    }
}
