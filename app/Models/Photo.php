<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photos';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'year',
        'provider',
        'location',
        'resolution',
        'format',
        'descriptors',
        'thumbnail_path',
        'full_image_path',
        'source_type',
        'external_url',
        'is_special',
    ];

    protected $casts = [
        'is_special' => 'boolean',
    ];

    public function photographers(): BelongsToMany
    {
        return $this->belongsToMany(
            Photographer::class,
            'photo_photographer',
            'photo_id',
            'photographer_id'
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
}
