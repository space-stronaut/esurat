<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'agama',
        'pekerjaan',
        'no_kk',
        'goldar',
        'hub_keluarga',
        'status_perkawinan',
        'pendidikan_terakhir',
        'kewarganegaraan',
        'no_hp',
        'email'
    ];

    public function user() { return $this->belongsTo(User::class, 'nik', 'nik'); }
}