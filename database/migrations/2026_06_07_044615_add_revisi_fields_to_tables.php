<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Penambahan di tabel surat_templates
        Schema::table('surat_templates', function (Blueprint $table) {
            $table->boolean('gunakan_nomor')->default(true)->after('format_nomor_baku');
            $table->boolean('gunakan_perihal')->default(false)->after('gunakan_nomor');
            $table->boolean('gunakan_lampiran')->default(false)->after('gunakan_perihal');
        });

        // Penambahan di tabel pengajuan_surats
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->date('tanggal_surat')->nullable()->after('file_hasil');
            $table->string('link_gdrive')->nullable()->after('tanggal_surat');
        });
    }

    public function down()
    {
        Schema::table('surat_templates', function (Blueprint $table) {
            $table->dropColumn(['gunakan_nomor', 'gunakan_perihal', 'gunakan_lampiran']);
        });

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn(['tanggal_surat', 'link_gdrive']);
        });
    }
};