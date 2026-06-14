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

    public function __construct(PengajuanService $pengajuanService) {
        $this->pengajuanService = $pengajuanService;
    }

    public function index(Request $request)
{
    $search = $request->search;
    
    // Menghitung statistik untuk Card
    $stats = [
        'masuk' => \App\Models\PengajuanSurat::count(),
        'dikembalikan' => \App\Models\PengajuanSurat::where('status', 'dikembalikan')->count(),
        'menunggu_ttd' => \App\Models\PengajuanSurat::where('status', 'menunggu_ttd')->count(),
        'selesai' => \App\Models\PengajuanSurat::where('status', 'siap_diambil')->count(),
    ];

    $pengajuans = \App\Models\PengajuanSurat::with(['penduduk', 'template'])
        ->when($search, function($q) use ($search) {
            $q->whereHas('penduduk', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")->orWhere('nik', 'like', "%{$search}%");
            });
        })
        ->latest()->paginate(15);

    return view('admin.pemrosesan.index', compact('pengajuans', 'stats', 'search'));
}

    // ============================================
    // TAHAP WIZARD 1: VERIFIKASI DOKUMEN
    // ============================================
    public function verifikasi(PengajuanSurat $pemrosesan)
    {
        if ($pemrosesan->status !== 'pengajuan_baru') abort(403, 'Akses ditolak.');
        return view('admin.pemrosesan.verifikasi', compact('pemrosesan'));
    }

    public function processVerifikasi(Request $request, PengajuanSurat $pemrosesan)
    {
        if ($request->aksi == 'terima') {
            $pemrosesan->update(['status' => 'sedang_diproses', 'catatan_koreksi' => null]);
            return redirect()->route('admin.pemrosesan.index')->with('success', 'Dokumen terverifikasi. Status: Sedang Diproses.');
        } else {
            $request->validate(['catatan_koreksi' => 'required'], ['catatan_koreksi.required' => 'Catatan wajib diisi jika ditolak!']);
            $pemrosesan->update(['status' => 'dikembalikan', 'catatan_koreksi' => $request->catatan_koreksi]);
            return redirect()->route('admin.pemrosesan.index')->with('error', 'Surat dikembalikan ke warga untuk diperbaiki.');
        }
    }

    // ============================================
    // TAHAP WIZARD 2: DRAFTING (NOMOR & TANGGAL)
    // ============================================
    public function drafting(PengajuanSurat $pemrosesan)
    {
        if ($pemrosesan->status !== 'sedang_diproses') abort(403);
        return view('admin.pemrosesan.drafting', compact('pemrosesan'));
    }

    public function processDrafting(Request $request, PengajuanSurat $pemrosesan)
    {
        $template = $pemrosesan->template;
        $nomorSuratFormatted = null;

        if ($template->gunakan_nomor) {
            $request->validate(['nomor_urut' => 'required', 'tanggal_surat' => 'required|date']);
            $tanggal = $request->tanggal_surat;
            $bulanRomawi = $this->getRomawiBulan(date('m', strtotime($tanggal)));
            $tahun = date('Y', strtotime($tanggal));
            $format = $template->format_nomor_baku;
            $nomorSuratFormatted = str_replace(['[NOMOR]', '[BULAN]', '[TAHUN]'], [$request->nomor_urut, $bulanRomawi, $tahun], $format);
        } else {
            $request->validate(['tanggal_surat' => 'required|date']);
            $tanggal = $request->tanggal_surat;
        }

        $pemrosesan->update([
            'nomor_surat' => $nomorSuratFormatted, 
            'tanggal_surat' => $tanggal,
            'status' => 'menunggu_ttd' // Lanjut ke status berikutnya
        ]);

        return redirect()->route('admin.pemrosesan.index')->with('success', 'Drafting Selesai! Surat masuk ke tahap Menunggu TTD.');
    }

    // ============================================
    // TAHAP 3: MENUNGGU TTD -> SELESAI (SIAP DIAMBIL)
    // ============================================
    public function unduhDraft(PengajuanSurat $pemrosesan)
    {
        $templatePath = storage_path('app/public/' . $pemrosesan->template->file_template);
        $templateProcessor = new TemplateProcessor($templatePath);
        $penduduk = $pemrosesan->penduduk;

        $templateProcessor->setValue('statis.nomor_surat', $pemrosesan->nomor_surat ?? '');
        Carbon::setLocale('id');
        $templateProcessor->setValue('statis.tanggal_surat', Carbon::parse($pemrosesan->tanggal_surat)->translatedFormat('d F Y'));
        $templateProcessor->setValue('statis.nama_lengkap', $penduduk->nama_lengkap);
        $templateProcessor->setValue('statis.agama', $penduduk->agama);
        $templateProcessor->setValue('statis.nik', $penduduk->nik);
        $templateProcessor->setValue('statis.tempat_lahir', $penduduk->tempat_lahir);
        $templateProcessor->setValue('statis.tanggal_lahir', Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y'));
        
        if ($pemrosesan->isian_dinamis) {
            foreach ($pemrosesan->isian_dinamis as $parameter => $jawaban) {
                $templateProcessor->setValue($parameter, $jawaban);
            }
        }

        $fileName = 'Draft_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $penduduk->nama_lengkap) . '.docx';
        $tempPath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function selesaiTtd(Request $request, PengajuanSurat $pemrosesan)
    {
        // Fitur keamanan ganda dari frontend dan backend
        if ($request->konfirmasi !== 'KONFIRMASI') {
            return back()->with('error', 'Kata kunci konfirmasi salah!');
        }

        $pemrosesan->update(['status' => 'siap_diambil']);
        return redirect()->route('admin.pemrosesan.index')->with('success', 'Status diubah ke Siap Diambil. Silakan unggah file final dari GDrive.');
    }

    public function uploadGdrive(Request $request, PengajuanSurat $pemrosesan)
    {
        $request->validate(['link_gdrive' => 'required|url']);
        $pemrosesan->update(['link_gdrive' => $request->link_gdrive]);
        return back()->with('success', 'Surat Final berhasil diunggah! Warga dapat mengunduhnya sekarang.');
    }

    private function getRomawiBulan($bulan) {
        $map = ['01'=>'I','02'=>'II','03'=>'III','04'=>'IV','05'=>'V','06'=>'VI','07'=>'VII','08'=>'VIII','09'=>'IX','10'=>'X','11'=>'XI','12'=>'XII'];
        return $map[$bulan];
    }

    // ============================================
    // FUNGSI OFFLINE (Tetap Sama)
    // ============================================
    public function createOffline() {
        $penduduks = Penduduk::orderBy('nama_lengkap')->get();
        $templates = SuratTemplate::all();
        return view('admin.pemrosesan.create_offline', compact('penduduks', 'templates'));
    }
    public function getTemplateData($id) {
        return response()->json(SuratTemplate::findOrFail($id));
    }
    public function storeOffline(Request $request) {
        $request->validate(['penduduk_id' => 'required', 'surat_template_id' => 'required']);
        $this->pengajuanService->storePengajuan($request, null, 'offline', $request->penduduk_id);
        return redirect()->route('admin.pemrosesan.index')->with('success', 'Pengajuan offline berhasil dibuat.');
    }
}