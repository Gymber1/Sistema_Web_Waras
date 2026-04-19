<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Photographer;
use App\Models\Category;

class FototecaController extends Controller
{
    public function index()
    {
        if (auth()->check() && !auth()->user()->canAccessModule('fototeca')) {
            abort(403, 'Acceso denegado a este módulo');
        }

        $totalPhotos        = Photo::count();
        $totalPhotographers = Photographer::count();
        $totalCategories    = Category::where('type', 'fototeca')->count();

        // All photos with their relations
        $allPhotos = Photo::with(['photographer', 'photographers', 'categories'])->get();

        // Group photos by their actual DB category names
        $photosByCategory = [];
        foreach ($allPhotos as $photo) {
            foreach ($photo->categories as $cat) {
                $photosByCategory[$cat->name][] = [
                    'id'             => $photo->id,
                    'title'          => $photo->title,
                    'photographer'   => $photo->photographer ? $photo->photographer->full_name : ($photo->photographers->first()?->full_name ?? 'Desconocido'),
                    'year'           => $photo->capture_date ? $photo->capture_date->format('Y') : 'S/F',
                    'source_type'    => $photo->source_type ?? 'local',
                    'image_url'      => $photo->thumbnail_path ? '/storage/' . $photo->thumbnail_path : ($photo->full_image_path ? '/storage/' . $photo->full_image_path : null),
                    'description'    => $photo->description ?? '',
                    'resolution'     => $photo->resolution ?? 'N/A',
                    'location'       => $photo->location ?? '',
                    'format'         => $photo->format ?? '',
                    'external_url'   => $photo->external_url ?? '',
                ];
            }
            // Photos with no categories go to 'Sin Categoría'
            if ($photo->categories->isEmpty()) {
                $photosByCategory['Sin Categoría'][] = [
                    'id'           => $photo->id,
                    'title'        => $photo->title,
                    'photographer' => $photo->photographer ? $photo->photographer->full_name : 'Desconocido',
                    'year'         => $photo->capture_date ? $photo->capture_date->format('Y') : 'S/F',
                    'source_type'  => $photo->source_type ?? 'local',
                    'image_url'    => $photo->thumbnail_path ? '/storage/' . $photo->thumbnail_path : ($photo->full_image_path ? '/storage/' . $photo->full_image_path : null),
                    'description'  => $photo->description ?? '',
                    'resolution'   => $photo->resolution ?? 'N/A',
                    'location'     => $photo->location ?? '',
                    'format'       => $photo->format ?? '',
                    'external_url' => $photo->external_url ?? '',
                ];
            }
        }

        // Photographers data for the Fotógrafos section
        $photographersData = Photographer::withCount('photos')->get()->map(fn($p) => [
            'id'          => $p->id,
            'full_name'   => $p->full_name,
            'photos_count'=> $p->photos_count,
            'biography'   => $p->biography ?? '',
            'photo_path'  => $p->photo_path ? '/storage/' . $p->photo_path : null,
        ])->values()->toArray();

        // Categories for sidebar filters (fototeca type only)
        $allCategories = Category::where('type', 'fototeca')
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();

        $categoriesForFilters = $allCategories->map(fn($cat) => [
            'id'       => $cat->id,
            'name'     => $cat->name,
            'slug'     => $cat->slug,
            'children' => $cat->subcategories->map(fn($sub) => [
                'id'   => $sub->id,
                'name' => $sub->name,
                'slug' => $sub->slug,
            ])->toArray(),
        ])->toArray();

        return view('fototeca.dashboard', [
            'totalPhotos'         => $totalPhotos,
            'totalPhotographers'  => $totalPhotographers,
            'totalCategories'     => $totalCategories,
            'photosByCategory'    => $photosByCategory,
            'photographersData'   => $photographersData,
            'categoriesForFilters'=> $categoriesForFilters,
            'canEditPanel'        => auth()->check() && (auth()->user()->is_admin_global || auth()->user()->canAccessModule('fototeca')),
        ]);
    }

    public function getPhotosByCategory($categoryId)
    {
        if (auth()->check() && !auth()->user()->canAccessModule('fototeca')) {
            abort(403);
        }

        $photos = Photo::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->with(['photographer', 'categories'])->paginate(20);

        return response()->json($photos);
    }

    public function search(Request $request)
    {
        if (auth()->check() && !auth()->user()->canAccessModule('fototeca')) {
            abort(403);
        }

        $query = $request->get('q');

        $photos = Photo::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with(['photographer', 'categories'])
            ->paginate(20);

        return response()->json($photos);
    }
}
