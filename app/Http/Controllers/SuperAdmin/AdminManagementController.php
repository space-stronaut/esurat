<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminManagementService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class AdminManagementController extends Controller
{
    protected $adminService;

    public function __construct(AdminManagementService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $admins = $this->adminService->getAllAdmins();
        return view('superadmin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('superadmin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $this->adminService->storeAdmin($validated);

        return redirect()->route('superadmin.admins.index')->with('success', 'Akun Admin berhasil ditambahkan.');
    }

    public function destroy(User $admin)
    {
        if ($admin->role === 'admin') {
            $this->adminService->deleteAdmin($admin);
            return redirect()->route('superadmin.admins.index')->with('success', 'Akun Admin berhasil dihapus.');
        }
        return back()->with('error', 'Hanya akun Admin yang dapat dihapus.');
    }
}