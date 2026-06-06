<?php

namespace App\Services;

use App\Models\ProfilKantor;
use Illuminate\Support\Facades\Storage;

class ProfilKantorService
{
    // Mengambil data profil pertama (karena hanya ada 1 kantor)
    public function getProfil()
    {
        return ProfilKantor::first();
    }

    public function updateOrCreateProfil(array $data, $logoFile = null)
    {
        $profil = $this->getProfil();
        
        $updateData = [
            'nama_kantor' => $data['nama_kantor'],
            'alamat' => $data['alamat'],
            'kontak' => $data['kontak'],
            'nama_kepala' => $data['nama_kepala'],
            'nip_kepala' => $data['nip_kepala'],
        ];

        // Handle upload logo baru jika ada
        if ($logoFile) {
            // Hapus logo lama jika ada
            if ($profil && $profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }
            // Simpan logo baru maks 2MB (.png / .jpg)
            $updateData['logo'] = $logoFile->store('profil_kantor', 'public');
        }

        if ($profil) {
            $profil->update($updateData);
            return $profil;
        } else {
            return ProfilKantor::create($updateData);
        }
    }
}