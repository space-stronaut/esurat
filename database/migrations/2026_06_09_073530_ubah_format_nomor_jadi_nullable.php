<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Mengubah kolom agar mengizinkan nilai NULL jika tidak dicentang
        DB::statement("ALTER TABLE surat_templates MODIFY COLUMN format_nomor_baku VARCHAR(255) NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE surat_templates MODIFY COLUMN format_nomor_baku VARCHAR(255) NOT NULL");
    }
};