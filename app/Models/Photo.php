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
        return $path ? Storage::url($path) : null;
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
