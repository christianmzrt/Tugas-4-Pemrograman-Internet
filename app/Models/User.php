<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Tambah ini untuk API

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // Tambah HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambah role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper function untuk cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}