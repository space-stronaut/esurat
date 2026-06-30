<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Services\PendudukService;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    protected $pendudukService;

    public function __construct(PendudukService $pendudukService)
    {
        $this->pendudukService = $pendudukService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $penduduks = $this->pendudukService->getAllPaginated(10, $search);
        return view('admin.penduduk.index', compact('penduduks', 'search'));
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduks',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string',
            'no_kk' => 'required|string|size:16',
            'goldar' => 'required|string',
            'hub_keluarga' => 'required|string',
            'status_perkawinan' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'kewarganegaraan' => 'required|string',
            'no_hp' => 'nullable|string',
            'email' => 'nullable|email|max:255'
        ]);

        $this->pendudukService->store($validated);

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/|unique:penduduks,nik,' . $penduduk->id,
            'nama_lengkap' => 'required|string|max:255|regex:/^[^0-9]+$/',
            'tempat_lahir' => 'required|string|max:100|regex:/^[^0-9]+$/',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3|regex:/^[0-9]+$/',
            'rw' => 'required|string|max:3|regex:/^[0-9]+$/',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string|in:Belum/Tidak Bekerja,Mengurus Rumah Tangga,Pelajar/Mahasiswa,Pensiunan,Pegawai Negeri Sipil (PNS),Tentara Nasional Indonesia (TNI),Kepolisian RI (POLRI),Karyawan Swasta,Karyawan BUMN,Karyawan BUMD,Buruh Harian Lepas,Buruh Tani/Perkebunan,Buruh Nelayan/Perikanan,Buruh Peternakan,Pembantu Rumah Tangga,Tukang Cukur,Tukang Listrik,Tukang Batu,Tukang Kayu,Tukang Sol Sepatu,Tukang Las/Pandai Besi,Tukang Jahit,Tukang Gigi,Penata Rias,Penata Busana,Penata Rambut,Mekanik,Seniman,Wartawan,Olahragawan,Dokter,Bidan,Perawat,Apoteker,Psikiater/Psikolog,Penyiar Televisi,Penyiar Radio,Promotor,Filmografi/Sutradara,Fotografer,Desainer,Arsitek,Akuntan,Konsultan,Notaris,Pengacara,Penilai,Juru Sita,Aktuaris,Kurator,Jurnalis,Karyawan Honorer,Wakil Presiden,Anggota DPR-RI,Anggota DPD,Anggota BPK,Anggota Mahkamah Konstitusi,Anggota Kabinet/Menteri,Duta Besar,Gubernur,Wakil Gubernur,Bupati,Wakil Bupati,Walikota,Wakil Walikota,Anggota DPRD Provinsi,Anggota DPRD Kabupaten/Kota,Dosen,Guru,Pilot,Pramugari/Pramugara,Navigator,Masinis,Nakhoda,Masinis Kapal,Pilot Pesawat Tempur,Kepala Desa,Perangkat Desa,Anggota BPD,Pendeta,Pastor,Ustadz/Mubaligh,Biksu,Monik,Penginjil,Penatua,Syamas,Wiraswasta,Lainnya',
            'no_kk' => 'required|string|size:16|regex:/^[0-9]+$/',
            'goldar' => 'required|string',
            'hub_keluarga' => 'required|string',
            'status_perkawinan' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'kewarganegaraan' => 'required|string',
            'no_hp' => 'nullable|string|regex:/^(\+62|0)[0-9]{8,13}$/',
            'email' => 'nullable|email|max:255'
        ]);

        $this->pendudukService->update($penduduk, $validated);

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $this->pendudukService->delete($penduduk);
        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }
}