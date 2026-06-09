<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'penduduk_id', 'surat_template_id', 'user_id', 'jenis_pengajuan',
        'isian_dinamis', 'lampiran_syarat', 'status', 'nomor_surat', 'file_hasil',
        'tanggal_surat', 'link_gdrive', 'catatan_koreksi' // <--- Tambahan Revisi
    ];

    protected $casts = [
        'isian_dinamis' => 'array',
        'lampiran_syarat' => 'array',
    ];

    public function penduduk() { return $this->belongsTo(Penduduk::class); }
    public function template() { return $this->belongsTo(SuratTemplate::class, 'surat_template_id'); }
    public function user() { return $this->belongsTo(User::class); }
}