<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_surat',
        'file_template',
        'format_nomor_baku',
        'is_pakai_nomor',
        'is_pakai_perihal',
        'is_pakai_lampiran',
        'parameter_dinamis',
        'syarat_dokumen'
    ];

    protected function casts(): array
    {
        return [
            'is_pakai_nomor' => 'boolean',
            'is_pakai_perihal' => 'boolean',
            'is_pakai_lampiran' => 'boolean',
            'parameter_dinamis' => 'array',
            'syarat_dokumen' => 'array',
        ];
    }
}