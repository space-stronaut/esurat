<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduks')->cascadeOnDelete();
            $table->foreignId('surat_template_id')->constrained('surat_templates')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Null jika offline
            
            $table->enum('jenis_pengajuan', ['online', 'offline'])->default('online');
            
            // Simpan isian form dan file lampiran dalam format JSON
            $table->json('isian_dinamis')->nullable(); 
            $table->json('lampiran_syarat')->nullable(); 
            
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->string('nomor_surat')->nullable();
            
            // Path file PDF hasil akhir atau link Google Drive
            $table->string('file_hasil')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};