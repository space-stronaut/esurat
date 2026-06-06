<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\UserValidationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ValidationController extends Controller
{
    public function index()
    {
        // Menampilkan user yang statusnya masih pending
        $users = User::where('role', 'user')->where('status_validasi', 'pending')->latest()->get();
        return view('admin.validasi.index', compact('users'));
    }

    public function approve(User $user)
    {
        $user->update(['status_validasi' => 'approved']);
        
        // Kirim email notifikasi
        Mail::to($user->email)->send(new UserValidationMail($user, 'Diterima'));

        return redirect()->back()->with('success', 'Akun warga berhasil divalidasi dan disetujui.');
    }

    public function reject(User $user)
    {
        $user->update(['status_validasi' => 'rejected']);
        
        // Kirim email notifikasi
        Mail::to($user->email)->send(new UserValidationMail($user, 'Ditolak'));

        return redirect()->back()->with('error', 'Akun warga ditolak.');
    }
}