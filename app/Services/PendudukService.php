<?php
namespace App\Services;

use App\Models\Penduduk;

class PendudukService
{
    /**
     * Mengambil semua data penduduk dengan paginasi dan pencarian
     */
    public function getAllPaginated($perPage = 10, $search = null)
    {
        $query = Penduduk::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Menyimpan data penduduk baru
     */
    public function store(array $data)
    {
        return Penduduk::create($data);
    }

    /**
     * Memperbarui data penduduk yang ada
     */
    public function update(Penduduk $penduduk, array $data)
    {
        $penduduk->update($data);
        return $penduduk;
    }

    /**
     * Menghapus data penduduk
     */
    public function delete(Penduduk $penduduk)
    {
        $penduduk->delete();
    }
}