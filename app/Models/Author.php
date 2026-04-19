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
        'biography',
        'nationality',
        'email',
        'website',
        'photo_path',
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
