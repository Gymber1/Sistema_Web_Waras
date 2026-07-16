<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';

    protected $fillable = [
        'name',
        'slug',
        'birth_place',
        'birth_date',
        'death_place',
        'death_date',
        'occupation',
        'biography',
        'studies_critique',
        'nationality',
        'email',
        'website',
        'photo_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    /**
     * Relación: un autor puede haber escrito muchos libros.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(
            Book::class,
            'book_author',
            'author_id',
            'book_id'
        )->withPivot('order')->withTimestamps();
    }

    /**
     * Relación: un autor puede estar asociado a múltiples categorías.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'author_category',
            'author_id',
            'category_id'
        )->withTimestamps();
    }
}
