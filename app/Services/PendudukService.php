<?php
namespace App\Services;

use App\Models\Penduduk;

class PendudukService
{
    /**
     * Mengambil semua data penduduk dengan paginasi
     */
    public function getAllPaginated($perPage = 10)
    {
        return Penduduk::latest()->paginate($perPage);
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