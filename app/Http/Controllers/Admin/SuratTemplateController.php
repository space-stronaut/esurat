<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratTemplate;
use App\Services\SuratTemplateService;
use Illuminate\Http\Request;

class SuratTemplateController extends Controller
{
    protected $suratTemplateService;

    public function __construct(SuratTemplateService $suratTemplateService)
    {
        $this->suratTemplateService = $suratTemplateService;
    }

    public function index()
    {
        $templates = $this->suratTemplateService->getAllPaginated(10);
        return view('admin.template.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.template.create');
    }

    public function store(Request $request)
    {
        // Validasi parameter_dinamis DIHAPUS karena sekarang di-generate otomatis oleh PhpWord
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'file_template' => 'required|file|mimes:docx|max:5120', // Maks 5MB
            'format_nomor_baku' => 'nullable|string|max:100',
            'syarat_dokumen' => 'nullable|string',
        ]);

        // Lempar semua input beserta file ke Service
        $this->suratTemplateService->store(
            $request->all(), 
            $request->file('file_template')
        );

        return redirect()->route('admin.template.index')
                         ->with('success', 'Template berhasil diunggah dan parameter surat terdeteksi otomatis.');
    }

    public function destroy(SuratTemplate $template)
    {
        $this->suratTemplateService->delete($template);

        return redirect()->route('admin.template.index')
                         ->with('success', 'Template Surat berhasil dihapus.');
    }
}