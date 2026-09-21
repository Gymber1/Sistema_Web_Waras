<?php

namespace App\Models;

use App\Models\Special;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Concerns\HasThumbnail;

class Photographer extends Model
{
    use HasFactory;
    use HasThumbnail;

    protected $table = 'photographers';


    /** URL de la imagen reducida, para grillas y tablas. */
    public function getPhotoThumbUrlAttribute(): ?string
    {
        return self::thumbUrl($this->photo_path);
    }

    protected $fillable = [
        'full_name',
        'slug',
        'birth_place',
        'birth_date',
        'death_place',
        'death_date',
        'biography',
        'studies_critique',
        'photo_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(
            Photo::class,
            'photo_photographer',
            'photographer_id',
            'photo_id'
        )->withPivot('order')->withTimestamps()->orderByPivot('order');
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Special::class, 'photographer_special');
    }
}
