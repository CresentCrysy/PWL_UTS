<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName; // 1. Tambahkan import ini
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements FilamentUser, HasName // 2. Tambahkan HasName di sini
{
    use Notifiable;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'level_id', 
        'username', 
        'nama', 
        'email', 
        'password',
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed'
    ];

    /**
     * Beritahu Filament kolom mana yang digunakan sebagai Nama User
     */
    public function getFilamentName(): string
    {
        return $this->nama ?? $this->username;
    }

    /**
     * Izin akses ke Panel Filament
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Berikan akses ke semua user yang terdaftar
        return true; 
    }

    /**
     * Relasi ke Level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }

    /**
     * Relasi ke Stok
     */
    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke Penjualan
     */
    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'user_id');
    }
}