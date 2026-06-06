<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminManagementService
{
    public function getAllAdmins()
    {
        // Menampilkan user yang memiliki role admin
        return User::where('role', 'admin')->latest()->paginate(10);
    }

    public function storeAdmin(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Enkripsi Bcrypt sesuai requirement
            'role' => 'admin',
            'status_validasi' => 'approved', // Admin otomatis approved
        ]);
    }

    public function deleteAdmin(User $admin)
    {
        $admin->delete();
    }
}