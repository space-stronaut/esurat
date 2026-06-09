<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_surat', 'deskripsi', 'file_template', 'parameter_dinamis', 
        'syarat_dokumen', 'format_nomor_baku', 
        'gunakan_nomor', 'gunakan_perihal', 'gunakan_lampiran' // <--- Tambahan Revisi
    ];

    protected $casts = [
        'parameter_dinamis' => 'array',
        'syarat_dokumen' => 'array',
        'gunakan_nomor' => 'boolean',
        'gunakan_perihal' => 'boolean',
        'gunakan_lampiran' => 'boolean',
    ];
}