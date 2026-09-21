<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photos';

    /** Se incluye en el JSON para que las grillas usen la miniatura. */
    protected $appends = ['thumbnail_url'];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'year',
        'year_type',
        'year_from',
        'year_to',
        'provider',
        'location',
        'resolution',
        'format',
        'descriptors',
        'tag_id',
        'thumbnail_path',
        'full_image_path',
        'source_type',
        'external_url',
        'is_special',
    ];

    protected $casts = [
        'is_special' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->source_type === 'external') {
            return $this->external_url ?: null;
        }
        $path = $this->full_image_path ?? $this->thumbnail_path;
        return $path ? Storage::url($path) : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->source_type === 'external') {
            return $this->external_url ?: null;
        }

        $path = $this->thumbnail_path ?? $this->full_image_path;
        if (! $path) {
            return null;
        }

        // Si existe la miniatura generada al optimizar (carpeta thumbs/), usarla:
        // pesa una fracción de la imagen completa y es lo que hace ágil la galería.
        // thumbnail_path suele apuntar al mismo archivo que full_image_path, así que
        // sin esto la grilla descargaría las fotos a tamaño completo.
        $thumb = dirname($path) . '/thumbs/' . basename($path);
        if (Storage::disk('public')->exists($thumb)) {
            return Storage::url($thumb);
        }

        return Storage::url($path);
    }

    public function photographers(): BelongsToMany
    {
        return $this->belongsToMany(
            Photographer::class,
            'photo_photographer',
            'photo_id',
            'photographer_id'
        )->withPivot('order')->withTimestamps()->orderByPivot('order');
    }

    public function donors(): BelongsToMany
    {
        return $this->belongsToMany(
            Donor::class,
            'photo_donor',
            'photo_id',
            'donor_id'
        )->withPivot('order')->withTimestamps()->orderByPivot('order');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'photo_category',
            'photo_id',
            'category_id'
        )->withTimestamps();
    }

    public function specials(): BelongsToMany
    {
        return $this->belongsToMany(
            Special::class,
            'photo_special',
            'photo_id',
            'special_id'
        )->withPivot('order')->withTimestamps();
    }

    public function tag(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PhotoTag::class, 'tag_id');
    }
}
