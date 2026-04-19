<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_url',
        'is_active',
        'config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'json',
    ];

    /**
     * Relación: un módulo puede tener muchos moderadores.
     */
    public function moderators(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'module_moderators',
            'module_id',
            'user_id'
        );
    }
}
