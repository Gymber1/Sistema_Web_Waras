<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoTag extends Model
{
    protected $table = 'photo_tags';
    protected $fillable = ['name', 'slug'];

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Photo::class, 'tag_id');
    }
}
