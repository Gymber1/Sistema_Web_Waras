<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'parent_id',
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->with('subcategories');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public static function flatTree(string $type, int $parentId = null, int $depth = 0): \Illuminate\Support\Collection
    {
        $items = static::where('type', $type)
            ->where('parent_id', $parentId)
            ->orderBy('name')
            ->get();

        $result = collect();
        foreach ($items as $item) {
            $item->depth = $depth;
            $result->push($item);
            $result = $result->merge(static::flatTree($type, $item->id, $depth + 1));
        }
        return $result;
    }

    /**
     * Relación: una categoría puede estar asociada a muchos libros.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(
            Book::class,
            'book_category',
            'category_id',
            'book_id'
        )->withTimestamps();
    }

    /**
     * Relación: una categoría puede estar asociada a muchas fotos.
     */
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(
            Photo::class,
            'photo_category',
            'category_id',
            'photo_id'
        )->withTimestamps();
    }
}
