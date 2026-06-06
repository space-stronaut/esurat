<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_kantors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kantor');
            $table->text('alamat');
            $table->string('kontak');
            $table->string('nama_kepala');
            $table->string('nip_kepala')->nullable();
            $table->string('logo')->nullable(); // Path logo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_kantors');
    }
};