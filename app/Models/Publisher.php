<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Concerns\HasThumbnail;

class Publisher extends Model
{
    use HasFactory;
    use HasThumbnail;

    protected $table = 'publishers';


    /** URL de la imagen reducida, para grillas y tablas. */
    public function getLogoThumbUrlAttribute(): ?string
    {
        return self::thumbUrl($this->logo_path);
    }

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
