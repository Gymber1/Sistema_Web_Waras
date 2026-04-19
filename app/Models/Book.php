<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'publication_date',
        'document_type',
        'isbn',
        'pages',
        'language',
        'descriptors',
        'provider',
        'cover_image_path',
        'source_type',
        'external_url',
        'pdf_file_path',
        'publisher_id',
        'is_special',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'is_special'       => 'boolean',
    ];

    /**
     * Relación: un libro pertenece a una editorial.
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * Relación: un libro puede ser escrito por muchos autores.
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(
            Author::class,
            'book_author',
            'book_id',
            'author_id'
        )->withPivot('order')->withTimestamps()->orderBy('order');
    }

    /**
     * Relación: un libro puede estar en muchas categorías.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'book_category',
            'book_id',
            'category_id'
        )->withTimestamps();
    }

    /**
     * Relación: un libro puede tener muchas reseñas.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Acceso a archivos: retorna la URL o ruta según el tipo de fuente.
     */
    public function getSourcePath()
    {
        return match ($this->source_type) {
            'external' => $this->external_url,
            'pdf' => $this->pdf_file_path,
            default => null,
        };
    }
}
