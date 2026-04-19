<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
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

        $allPhotos = Photo::with(['photographers', 'categories'])->get();

        $photosByCategory = [];
        foreach ($allPhotos as $photo) {
            $photographerName = $photo->photographers->first()?->full_name ?? 'Desconocido';
            $photoData = [
                'id'           => $photo->id,
                'title'        => $photo->title,
                'photographer' => $photographerName,
                'year'         => $photo->year ?? 'S/F',
                'source_type'  => $photo->source_type ?? 'local',
                'image_url'    => $photo->thumbnail_path ? '/storage/' . $photo->thumbnail_path : ($photo->full_image_path ? '/storage/' . $photo->full_image_path : null),
                'description'  => $photo->description ?? '',
                'resolution'   => $photo->resolution ?? 'N/A',
                'location'     => $photo->location ?? '',
                'format'       => $photo->format ?? '',
                'external_url' => $photo->external_url ?? '',
                'detail_url'   => '/fototeca/galeria/' . $photo->id,
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

        $especialesData = Photo::where('is_special', true)
            ->with(['photographers', 'categories'])
            ->get()
            ->map(fn($p) => [
                'id'           => $p->id,
                'title'        => $p->title,
                'photographer' => $p->photographers->first()?->full_name ?? 'Desconocido',
                'year'         => $p->year ?? 'S/F',
                'source_type'  => $p->source_type ?? 'local',
                'image_url'    => $p->thumbnail_path ? '/storage/' . $p->thumbnail_path : ($p->full_image_path ? '/storage/' . $p->full_image_path : null),
                'description'  => $p->description ?? '',
                'resolution'   => $p->resolution ?? 'N/A',
                'location'     => $p->location ?? '',
                'format'       => $p->format ?? '',
                'external_url' => $p->external_url ?? '',
                'detail_url'   => '/fototeca/galeria/' . $p->id,
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

        return [
            'totalPhotos'          => $totalPhotos,
            'totalPhotographers'   => $totalPhotographers,
            'totalCategories'      => $totalCategories,
            'photosByCategory'     => $photosByCategory,
            'photographersData'    => $photographersData,
            'especialesData'       => $especialesData,
            'categoriesForFilters' => $buildTree($allCategories),
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
    public function indexEspeciales() { return view('fototeca.dashboard', $this->dashboardData('Especiales')); }
    public function indexAportantes() { return view('fototeca.dashboard', $this->dashboardData('Aportantes')); }

    public function showPhoto(\App\Models\Photo $photo)
    {
        $photo->load(['photographers', 'categories']);
        return view('fototeca.foto', compact('photo'));
    }

    public function showEspecial(\App\Models\Special $special)
    {
        $special->load(['photos.photographers', 'photos.categories']);
        return view('fototeca.especial', compact('special'));
    }

    public function showPhotographer(\App\Models\Photographer $photographer)
    {
        $photographer->load('photos.categories');
        return view('fototeca.fotografo', compact('photographer'));
    }

    public function getPhotosByCategory($categoryId)
    {
        $photos = Photo::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->with(['photographers', 'categories'])->paginate(20);

        return response()->json($photos);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $photos = Photo::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with(['photographers', 'categories'])
            ->paginate(20);

        return response()->json($photos);
    }
}
