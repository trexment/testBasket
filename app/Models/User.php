<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'user_type',
        'email_verified_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function attempts()
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function getApplicableRoles()
    {
        // Map user_type to applicable roles for question filtering
        $roleMap = [
            'arbitro' => ['arbitro'],
            'oficial' => ['oficial'],
            'entrenador' => ['entrenador'],
        ];
        return $roleMap[$this->user_type] ?? [];
    }

    public function getUserTypeLabel()
    {
        $labels = [
            'arbitro' => 'Árbitro',
            'oficial' => 'Oficial de Mesa',
            'entrenador' => 'Entrenador',
        ];
        return $labels[$this->user_type] ?? $this->user_type;
    }
}
