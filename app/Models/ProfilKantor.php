<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilKantor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kantor',
        'alamat',
        'kontak',
        'nama_kepala',
        'nip_kepala',
        'logo'
    ];
}