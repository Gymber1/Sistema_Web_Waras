<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Concerns\HasThumbnail;

class Donor extends Model
{
    use HasThumbnail;
    protected $table = 'donors';


    /** URL de la imagen reducida, para grillas y tablas. */
    public function getPhotoThumbUrlAttribute(): ?string
    {
        return self::thumbUrl($this->photo_path);
    }

    protected $fillable = [
        'full_name', 'slug', 'birth_place', 'birth_date',
        'death_place', 'death_date', 'biography', 'studies_critique', 'photo_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(
            Photo::class,
            'photo_donor',
            'donor_id',
            'photo_id'
        )->withPivot('order')->withTimestamps()->orderByPivot('order');
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Special::class, 'donor_special');
    }
}
