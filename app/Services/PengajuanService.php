<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PengajuanService
{
    public function storePengajuan($request, $user, $jenis = 'online', $pendudukIdOffline = null)
    {
        $pendudukId = null;

        if ($jenis === 'online') {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
            if (!$penduduk) {
                throw ValidationException::withMessages([
                    'error' => 'Gagal mengajukan surat. NIK Anda (' . $user->nik . ') tidak ditemukan di Master Data Penduduk. Silakan hubungi Admin.'
                ]);
            }
            $pendudukId = $penduduk->id;
        } else {
            $pendudukId = $pendudukIdOffline;
        }

        $lampiran = [];
        $syaratDokumen = json_decode($request->syarat_dokumen_keys, true) ?? [];

        foreach ($syaratDokumen as $index => $syarat) {
            $inputType = $request->input("tipe_lampiran_{$index}");
            
            if ($inputType === 'file' && $request->hasFile("file_lampiran_{$index}")) {
                $path = $request->file("file_lampiran_{$index}")->store('lampiran_syarat', 'public');
                $lampiran[$syarat] = ['tipe' => 'file', 'path' => $path];
            } elseif ($inputType === 'link' && $request->filled("link_lampiran_{$index}")) {
                $lampiran[$syarat] = ['tipe' => 'link', 'path' => $request->input("link_lampiran_{$index}")];
            }
        }

        $isianDinamis = [];
        if ($request->has('parameter_dinamis')) {
            $isianDinamis = $request->input('parameter_dinamis');
        }

        return PengajuanSurat::create([
            'penduduk_id' => $pendudukId,
            'surat_template_id' => $request->surat_template_id,
            'user_id' => $jenis === 'online' ? $user->id : null,
            'jenis_pengajuan' => $jenis,
            'isian_dinamis' => $isianDinamis,
            'lampiran_syarat' => $lampiran,
            'status' => 'menunggu',
        ]);
    }

    public function updateStatus(PengajuanSurat $pengajuan, $request)
    {
        $data = ['status' => $request->status];

        // LOGIKA PENOMORAN OTOMATIS (Tanpa upload file)
        if ($request->status === 'selesai') {
            if (!$pengajuan->nomor_surat) {
                // Hitung urutan surat yang selesai tahun ini
                $countSelesai = PengajuanSurat::where('status', 'selesai')
                                ->whereYear('updated_at', date('Y'))
                                ->count();
                
                $urutan = str_pad($countSelesai + 1, 3, '0', STR_PAD_LEFT);
                $formatBaku = $pengajuan->template->format_nomor_baku ?? '/Kec/'.date('Y');
                
                // Gabungkan menjadi nomor surat resmi
                $data['nomor_surat'] = $urutan . $formatBaku;
            }
        }

        $pengajuan->update($data);
    }
}