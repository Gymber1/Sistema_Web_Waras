<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];
    protected $table = 'photo_categories';
    
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
