<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->text('catatan_koreksi')->nullable()->after('status');
        });
    }
    public function down() {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn('catatan_koreksi');
        });
    }
};