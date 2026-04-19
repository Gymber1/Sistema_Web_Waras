<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Publisher extends Model
{
    use HasFactory;

    protected $table = 'publishers';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_path',
        'email',
        'website',
        'phone',
        'address',
    ];

    /**
     * Relación: una editorial puede publicar muchos libros.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
