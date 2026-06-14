<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            $table->string('no_kk')->nullable();
            $table->string('goldar')->nullable();
            $table->string('hub_keluarga')->nullable();
            $table->string('status_perkawinan')->nullable();
            // $table->string('agama')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            // $table->string('pekerjaan')->nullable();
            $table->string('kewarganegaraan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            //
        });
    }
};
