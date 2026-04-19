<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    protected $fillable = ['title', 'slug', 'issue_number', 'publication_date', 'description', 'cover_image'];
    
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
