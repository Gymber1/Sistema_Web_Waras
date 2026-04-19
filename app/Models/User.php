<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin_global',
        'is_deletable',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin_global' => 'boolean',
            'is_deletable' => 'boolean',
        ];
    }

    /**
     * Relación muchos-a-muchos: un usuario puede ser moderador de varios módulos.
     * Solo aplicable a usuarios que NO son admin global.
     */
    public function modules()
    {
        return $this->belongsToMany(
            'App\Models\Module',
            'module_moderators',
            'user_id',
            'module_id'
        );
    }

    /**
     * Determina si el usuario puede acceder a un módulo específico.
     * Acceso permitido si:
     * - Es admin global, O
     * - Es moderador asignado a ese módulo
     * 
     * @param string $moduleSlugOrId Slug o ID del módulo
     * @return bool
     */
    public function canAccessModule($moduleSlugOrId)
    {
        if ($this->is_admin_global) {
            return true;
        }

        return $this->modules()
            ->where(function ($query) use ($moduleSlugOrId) {
                $query->where('modules.slug', $moduleSlugOrId)
                    ->orWhere('modules.id', $moduleSlugOrId);
            })
            ->exists();
    }
}
