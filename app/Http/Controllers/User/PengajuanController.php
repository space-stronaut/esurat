<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\SuratTemplate;
use App\Services\PengajuanService;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    protected $pengajuanService;

    public function __construct(PengajuanService $pengajuanService)
    {
        $this->pengajuanService = $pengajuanService;
    }

    public function index()
    {
        $pengajuans = PengajuanSurat::with('template')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('user.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $templates = SuratTemplate::all();
        return view('user.pengajuan.create', compact('templates'));
    }

    public function store(Request $request)
    {
        // Validasi dan penyimpanan melalui Service
        $this->pengajuanService->storePengajuan($request, Auth::user(), 'online');

        return redirect()->route('user.pengajuan.index')
            ->with('success', 'Pengajuan surat berhasil dikirim. Silakan tunggu proses dari Admin.');
    }

    public function cancel(PengajuanSurat $pengajuan)
    {
        // Pastikan hanya pemiliknya yang bisa membatalkan dan statusnya masih 'menunggu'
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== 'menunggu') {
            abort(403, 'Akses ditolak.');
        }

        $pengajuan->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    // TAMBAHKAN FUNGSI INI UNTUK AJAX FORM DINAMIS WARGA
    public function getTemplateData($id)
    {
        return response()->json(\App\Models\SuratTemplate::findOrFail($id));
    }

    // =====================================================================
    // FUNGSI BARU: GENERATE DOCX LANGSUNG UNTUK DIDOWNLOAD WARGA
    // =====================================================================
    public function downloadDocx(PengajuanSurat $pengajuan)
    {
        // 1. Validasi Keamanan (Hanya pemilik dan status 'selesai' yang bisa unduh)
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== 'selesai') {
            abort(403, 'Surat belum selesai diproses atau Anda tidak memiliki akses.');
        }

        // 2. Buka Template Asli
        $templatePath = storage_path('app/public/' . $pengajuan->template->file_template);
        if (!file_exists($templatePath)) {
            return back()->with('error', 'Gagal: File template tidak ditemukan di server.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);
        $penduduk = $pengajuan->penduduk;

        // 3. Suntikkan Data Otomatis (Termasuk Nomor Surat)
        $templateProcessor->setValue('nomor_surat', $pengajuan->nomor_surat ?? '-');
        $templateProcessor->setValue('statis.nama_lengkap', $penduduk->nama_lengkap);
        $templateProcessor->setValue('statis.nik', $penduduk->nik);
        $templateProcessor->setValue('statis.tempat_lahir', $penduduk->tempat_lahir);
        
        Carbon::setLocale('id');
        $templateProcessor->setValue('statis.tanggal_lahir', Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y'));
        $templateProcessor->setValue('statis.jenis_kelamin', $penduduk->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan');
        $templateProcessor->setValue('statis.agama', $penduduk->agama);
        $templateProcessor->setValue('statis.pekerjaan', $penduduk->pekerjaan);
        $templateProcessor->setValue('statis.alamat', $penduduk->alamat . ' RT ' . $penduduk->rt . ' RW ' . $penduduk->rw);

        // 4. Suntikkan Parameter Dinamis Form
        if ($pengajuan->isian_dinamis) {
            foreach ($pengajuan->isian_dinamis as $parameter => $jawaban) {
                $templateProcessor->setValue($parameter, $jawaban);
            }
        }

        // 5. Buat File dan Otomatis Download
        $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '_', $penduduk->nama_lengkap);
        $fileName = 'Surat_Jadi_' . $cleanName . '_' . time() . '.docx';
        $tempPath = storage_path('app/public/' . $fileName);
        
        $templateProcessor->saveAs($tempPath);

        // Download ke browser pengguna, lalu hapus file sementaranya dari server
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}