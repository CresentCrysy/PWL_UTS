<?php

namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
 
class User extends Authenticatable implements FilamentUser
{
    use Notifiable;
 
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
 
    protected $fillable = [
        'level_id', 'username', 'nama', 'email', 'password',
    ];
 
    protected $hidden = ['password', 'remember_token'];
 
    protected $casts = ['password' => 'hashed'];
 
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
 
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }
 
    public function stoks()
    {
        return $this->hasMany(Stok::class, 'user_id', 'user_id');
    }
 
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'user_id');
    }
}