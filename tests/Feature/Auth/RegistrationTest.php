<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        \App\Models\Penduduk::create([
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Test User',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Test No. 1',
            'rt' => '001',
            'rw' => '002',
            'agama' => 'Islam',
            'pekerjaan' => 'Karyawan',
        ]);

        $response = $this->post('/register', [
            'nik' => '1234567890123456',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'foto_ktp' => \Illuminate\Http\UploadedFile::fake()->image('ktp.jpg'),
            'foto_selfie' => \Illuminate\Http\UploadedFile::fake()->image('selfie.jpg'),
            'terms' => 'accepted',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'nik' => '1234567890123456',
            'email' => 'test@example.com',
            'role' => 'user',
            'status_validasi' => 'pending',
        ]);
    }
}
