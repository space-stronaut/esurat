<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\Penduduk;
use App\Models\SuratTemplate;
use App\Services\PengajuanService;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class PemrosesanSuratController extends Controller
{
    protected $pengajuanService;

    public function __construct(PengajuanService $pengajuanService)
    {
        $this->pengajuanService = $pengajuanService;
    }

    // =========================================================================
    // FITUR UTAMA: PEMROSESAN SURAT MASUK
    // =========================================================================

    public function index()
    {
        $pengajuans = PengajuanSurat::with(['penduduk', 'template'])->latest()->paginate(15);
        return view('admin.pemrosesan.index', compact('pengajuans'));
    }

    public function edit(PengajuanSurat $pemrosesan)
    {
        return view('admin.pemrosesan.edit', compact('pemrosesan'));
    }

    // public function update(Request $request, PengajuanSurat $pemrosesan)
    // {
    //     $request->validate([
    //         'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
    //         'nomor_surat' => 'required_if:status,selesai',
    //         'file_hasil' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
    //         'link_hasil' => 'nullable|url'
    //     ]);

    //     $this->pengajuanService->updateStatus($pemrosesan, $request);

    //     return redirect()->route('admin.pemrosesan.index')->with('success', 'Status surat berhasil diperbarui.');
    // }

    public function update(Request $request, PengajuanSurat $pemrosesan)
    {
        // Validasi disederhanakan: Hapus Link, Wajibkan File jika selesai.
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $this->pengajuanService->updateStatus($pemrosesan, $request);

        return redirect()->route('admin.pemrosesan.index')->with('success', 'Status surat berhasil diperbarui.');
    }

    public function generateDocx(PengajuanSurat $pemrosesan)
    {
        $templatePath = storage_path('app/public/' . $pemrosesan->template->file_template);
        if (!file_exists($templatePath)) {
            return back()->with('error', 'Gagal: File template kosong (.docx) tidak ditemukan di server.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);
        $penduduk = $pemrosesan->penduduk;

        $templateProcessor->setValue('statis.nama_lengkap', $penduduk->nama_lengkap);
        $templateProcessor->setValue('statis.nik', $penduduk->nik);
        $templateProcessor->setValue('statis.tempat_lahir', $penduduk->tempat_lahir);
        
        Carbon::setLocale('id');
        $templateProcessor->setValue('statis.tanggal_lahir', Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y'));
        $templateProcessor->setValue('statis.jenis_kelamin', $penduduk->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan');
        $templateProcessor->setValue('statis.agama', $penduduk->agama);
        $templateProcessor->setValue('statis.pekerjaan', $penduduk->pekerjaan);
        $templateProcessor->setValue('statis.alamat', $penduduk->alamat . ' RT ' . $penduduk->rt . ' RW ' . $penduduk->rw);

        if ($pemrosesan->isian_dinamis) {
            foreach ($pemrosesan->isian_dinamis as $parameter => $jawaban) {
                $templateProcessor->setValue($parameter, $jawaban);
            }
        }

        $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '_', $penduduk->nama_lengkap);
        $fileName = 'Draft_Surat_' . $cleanName . '_' . time() . '.docx';
        $tempPath = storage_path('app/public/' . $fileName);
        
        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    // =========================================================================
    // FITUR PENGAJUAN OFFLINE (WALK-IN OLEH ADMIN)
    // =========================================================================

    public function createOffline()
    {
        $penduduks = Penduduk::orderBy('nama_lengkap')->get();
        $templates = SuratTemplate::all();
        return view('admin.pemrosesan.create_offline', compact('penduduks', 'templates'));
    }

    public function getTemplateData($id)
    {
        return response()->json(SuratTemplate::findOrFail($id));
    }

    public function storeOffline(Request $request)
    {
        $rules = [
            'penduduk_id' => 'required|exists:penduduks,id',
            'surat_template_id' => 'required|exists:surat_templates,id',
        ];

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'file_lampiran_')) {
                $rules[$key] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }
            if (str_starts_with($key, 'link_lampiran_')) {
                $rules[$key] = 'nullable|url';
            }
        }

        $request->validate($rules);

        // Panggil Service Pengajuan dengan mode 'offline'
        $this->pengajuanService->storePengajuan($request, null, 'offline', $request->penduduk_id);

        return redirect()->route('admin.pemrosesan.index')->with('success', 'Pengajuan surat offline berhasil ditambahkan dan masuk ke antrean.');
    }
}