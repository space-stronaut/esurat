<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'status_validasi',
        'foto_ktp',
        'foto_selfie'
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

    // Helper methods untuk cek role
    public function isSuperAdmin() { return $this->role === 'super_admin'; }
    public function isAdmin() { return $this->role === 'admin' || $this->role === 'super_admin'; }
    public function isUser() { return $this->role === 'user'; }
}