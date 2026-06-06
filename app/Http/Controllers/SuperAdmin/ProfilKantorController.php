<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\ProfilKantorService;
use Illuminate\Http\Request;

class ProfilKantorController extends Controller
{
    protected $profilKantorService;

    public function __construct(ProfilKantorService $profilKantorService)
    {
        $this->profilKantorService = $profilKantorService;
    }

    public function edit()
    {
        $profil = $this->profilKantorService->getProfil();
        return view('superadmin.profil_kantor.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:50',
            'nama_kepala' => 'required|string|max:255',
            'nip_kepala' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $this->profilKantorService->updateOrCreateProfil(
            $request->except('logo'), 
            $request->file('logo')
        );

        return redirect()->back()->with('success', 'Profil Kantor berhasil diperbarui.');
    }
}