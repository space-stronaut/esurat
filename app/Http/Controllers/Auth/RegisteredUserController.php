<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input + File Foto
        $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'foto_ktp' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'foto_selfie' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // 2. Simpan File ke Storage
        $ktpPath = $request->file('foto_ktp')->store('validasi_warga/ktp', 'public');
        $selfiePath = $request->file('foto_selfie')->store('validasi_warga/selfie', 'public');

        // 3. Simpan Data User Baru ke Database
        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_ktp' => $ktpPath,
            'foto_selfie' => $selfiePath,
            'role' => 'user',
            'status_validasi' => 'pending', // Menggunakan 'pending' sesuai database Anda
        ]);

        event(new Registered($user));

        // PENTING: Auth::login($user) sengaja DIHAPUS agar tidak langsung masuk ke sistem

        // 4. Redirect ke halaman Login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Akun Anda berstatus PENDING. Silakan tunggu Admin memvalidasi berkas Anda sebelum dapat Login.');
    }
}