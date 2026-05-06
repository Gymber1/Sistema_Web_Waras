<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Book;

class Special extends Model
{
    use HasFactory;

    protected $table = 'specials';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image_path',
        'type',
        'module',
        'order',
        'is_active',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(
            Book::class,
            'book_special',
            'special_id',
            'book_id'
        )->withPivot('order')->orderByPivot('order');
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(
            Photo::class,
            'photo_special',
            'special_id',
            'photo_id'
        )->withPivot('order')->withTimestamps()->orderByPivot('order');
    }
}
