<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_templates', function (Blueprint $table) {
            $table->id();
            $table->string('nama_surat'); // Contoh: Surat Keterangan Domisili
            $table->string('file_template'); // Path file .docx
            
            // Pengaturan Atribut Surat
            $table->string('format_nomor_baku')->nullable(); // Contoh: /Kec.TA/V/2026
            $table->boolean('is_pakai_nomor')->default(true);
            $table->boolean('is_pakai_perihal')->default(false);
            $table->boolean('is_pakai_lampiran')->default(false);
            
            // Disimpan dalam format JSON untuk fleksibilitas
            $table->json('parameter_dinamis')->nullable(); // Contoh: ["Keperluan", "Masa Berlaku"]
            $table->json('syarat_dokumen')->nullable(); // Contoh: ["Scan KK", "Pengantar RT/RW"]
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_templates');
    }
};