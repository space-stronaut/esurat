<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // super_admin, admin, user
            $table->enum('role', ['super_admin', 'admin', 'user'])->default('user');
            $table->string('nik', 16)->nullable()->unique();
            // pending, approved, rejected
            $table->enum('status_validasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('foto_ktp')->nullable();
            $table->string('foto_selfie')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nik', 'status_validasi', 'foto_ktp', 'foto_selfie']);
        });
    }
};