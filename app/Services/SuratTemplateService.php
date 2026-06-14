<?php

namespace App\Services;

use App\Models\SuratTemplate;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratTemplateService
{
    public function getAllPaginated($perPage = 10)
    {
        return SuratTemplate::latest()->paginate($perPage);
    }

    public function store(array $data, $file)
    {
        // 1. Simpan file template
        $filePath = $file->store('templates', 'public');
        $fullPath = storage_path('app/public/' . $filePath);
        
        // 2. AUTO DETECT MENGGUNAKAN LIBRARY PHPWORD
        $templateProcessor = new TemplateProcessor($fullPath);
        
        // Fitur sakti PhpWord: getVariables() otomatis mencari semua string dengan format ${...}
        $rawVariables = $templateProcessor->getVariables();
        
        // Hilangkan duplikat jika ada parameter yang dipakai berulang di dalam surat
        $paramDinamis = array_values(array_unique($rawVariables));
            
        // 3. Proses syarat dokumen
        $syaratDokumen = !empty($data['syarat_dokumen']) 
            ? array_map('trim', explode(',', $data['syarat_dokumen'])) 
            : [];

        // 4. Simpan ke Database
        return SuratTemplate::create([
            'nama_surat' => $data['nama_surat'],
            'file_template' => $filePath,
            'format_nomor_baku' => $data['format_nomor_baku'] ?? null,
            'gunakan_nomor' => $data['gunakan_nomor'] ?? null,
            'gunakan_perihal' => $data['gunakan_perihal'] ?? null,
            'gunakan_lampiran' => $data['gunakan_lampiran'] ?? null,
            'is_pakai_nomor' => isset($data['is_pakai_nomor']),
            'is_pakai_perihal' => isset($data['is_pakai_perihal']),
            'is_pakai_lampiran' => isset($data['is_pakai_lampiran']),
            'parameter_dinamis' => $paramDinamis, // Hasil dari library
            'syarat_dokumen' => $syaratDokumen,
        ]);
    }

    public function delete(SuratTemplate $template)
    {
        if (Storage::disk('public')->exists($template->file_template)) {
            Storage::disk('public')->delete($template->file_template);
        }
        $template->delete();
    }
}