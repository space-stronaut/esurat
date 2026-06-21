<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Wizard Verifikasi: {{ $pemrosesan->template->nama_surat }}</h2>
    </x-slot>
{{-- {{ $pemrosesan->ditujukan }} --}}
    <div class="py-12" x-data="{ 
        step: 1, 
        checks: [], 
        totalFiles: {{ count($pemrosesan->lampiran_syarat ?? []) }},
        catatan: ''
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between border-b pb-4 mb-6 text-sm font-bold text-gray-400">
                    <span :class="step === 1 ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : (step > 1 ? 'text-green-600' : '')">1. Info Pemohon</span>
                    <span :class="step === 2 ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : (step > 2 ? 'text-green-600' : '')">2. Detail Data</span>
                    <span :class="step === 3 ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : (step > 3 ? 'text-green-600' : '')">3. Isian Surat</span>
                    <span :class="step === 4 ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : ''">4. Berkas & Verifikasi</span>
                </div>

                <form action="{{ route('admin.pemrosesan.process_verifikasi', $pemrosesan->id) }}" method="POST">
                    @csrf

                    <div x-show="step === 1" x-transition>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-500 pl-3">Informasi Pemohon</h3>
                        <table class="w-full text-sm mb-6 border">
                            <tr class="border-b"><td class="py-3 px-4 bg-gray-50 w-1/3 font-bold">Nama Lengkap</td><td class="py-3 px-4">{{ $pemrosesan->penduduk->nama_lengkap }}</td></tr>
                            <tr class="border-b"><td class="py-3 px-4 bg-gray-50 font-bold">NIK</td><td class="py-3 px-4">{{ $pemrosesan->penduduk->nik }}</td></tr>
                            <tr><td class="py-3 px-4 bg-gray-50 font-bold">Jalur Pengajuan</td><td class="py-3 px-4 uppercase">{{ $pemrosesan->jenis_pengajuan }}</td></tr>
                            <tr><td class="py-3 px-4 bg-gray-50 font-bold">NO KK</td><td class="py-3 px-4 uppercase">{{ $pemrosesan->penduduk->no_kk }}</td></tr>
                        </table>

                        @if ($pemrosesan->ditujukan_id != $pemrosesan->penduduk_id)
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-500 pl-3">Ditujukan Untuk</h3>
                            <table class="w-full text-sm mb-6 border">
                                <tr class="border-b"><td class="py-3 px-4 bg-gray-50 w-1/3 font-bold">Nama Lengkap</td><td class="py-3 px-4">{{ $pemrosesan->ditujukan->nama_lengkap }}</td></tr>
                                <tr class="border-b"><td class="py-3 px-4 bg-gray-50 font-bold">NIK</td><td class="py-3 px-4">{{ $pemrosesan->ditujukan->nik }}</td></tr>
                                <tr><td class="py-3 px-4 bg-gray-50 font-bold">Hubungan Keluarga</td><td class="py-3 px-4 uppercase">{{ $pemrosesan->ditujukan->hub_keluarga }}</td></tr>
                            </table>
                            
                        @endif
                        <div class="flex justify-end"><button type="button" @click="step = 2" class="bg-indigo-600 text-white px-5 py-2 rounded font-bold">Lanjut: Detail Data &raquo;</button></div>
                    </div>

                    <div x-show="step === 2" style="display: none;" x-transition>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-500 pl-3">Detail Data Kependudukan</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm mb-6 bg-gray-50 p-4 border rounded">
                            <div><strong class="block text-gray-500">Tempat, Tgl Lahir</strong>{{ $pemrosesan->penduduk->tempat_lahir }}, {{ $pemrosesan->penduduk->tanggal_lahir }}</div>
                            <div><strong class="block text-gray-500">Agama</strong>{{ $pemrosesan->penduduk->agama }}</div>
                            <div><strong class="block text-gray-500">Pekerjaan</strong>{{ $pemrosesan->penduduk->pekerjaan }}</div>
                            <div><strong class="block text-gray-500">Alamat</strong>{{ $pemrosesan->penduduk->alamat }} RT {{ $pemrosesan->penduduk->rt }}/{{ $pemrosesan->penduduk->rw }}</div>
                        </div>
                        <div class="flex justify-between">
                            <button type="button" @click="step = 1" class="bg-gray-300 px-5 py-2 rounded font-bold">&laquo; Kembali</button>
                            <button type="button" @click="step = 3" class="bg-indigo-600 text-white px-5 py-2 rounded font-bold">Lanjut: Isian Surat &raquo;</button>
                        </div>
                    </div>

                    <div x-show="step === 3" style="display: none;" x-transition>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-500 pl-3">Isian Spesifik Surat</h3>
                        @if($pemrosesan->isian_dinamis)
                            <div class="grid grid-cols-1 gap-4 text-sm mb-6">
                                @foreach($pemrosesan->isian_dinamis as $k => $v)
                                <div
                                    class="bg-blue-50 p-3 rounded border border-blue-100"
                                    @if(str_contains($k, 'statis.'))
                                        style="display: none;"
                                    @endif
                                >
                                    <span class="block text-xs font-bold text-blue-800 uppercase">
                                        {{ str_replace('_', ' ', $k) }}
                                    </span>
                                    <span class="font-medium">{{ $v }}</span>
                                </div>
                            @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic mb-6">Tidak ada isian tambahan dari warga.</p>
                        @endif
                        <div class="flex justify-between">
                            <button type="button" @click="step = 2" class="bg-gray-300 px-5 py-2 rounded font-bold">&laquo; Kembali</button>
                            <button type="button" @click="step = 4" class="bg-indigo-600 text-white px-5 py-2 rounded font-bold">Lanjut: Verifikasi Berkas &raquo;</button>
                        </div>
                    </div>

                    <div x-show="step === 4" style="display: none;" x-transition>
                        <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-indigo-500 pl-3">Verifikasi Berkas Pendukung</h3>
                        <p class="text-xs text-red-600 font-bold mb-4">*Admin wajib memeriksa dan mencentang semua berkas sebelum bisa menerima pengajuan ini.</p>
                        
                        <div class="overflow-x-auto border rounded mb-6">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100"><tr><th class="p-3 text-left">Nama Berkas</th><th class="p-3 text-center">Aksi / Lihat</th><th class="p-3 text-center bg-indigo-50">Valid & Sesuai?</th></tr></thead>
                                <tbody>
                                    @if($pemrosesan->lampiran_syarat)
                                        @foreach($pemrosesan->lampiran_syarat as $k => $v)
                                            <tr class="border-t hover:bg-gray-50">
                                                <td class="p-3 font-bold">{{ $k }}</td>
                                                <td class="p-3 text-center">
                                                    @if($v['tipe'] == 'file') <a href="{{ asset('storage/'.$v['path']) }}" target="_blank" class="text-white bg-blue-500 px-3 py-1 rounded text-xs font-bold">Buka File</a>
                                                    @elseif($v['tipe'] == 'link') <a href="{{ $v['path'] }}" target="_blank" class="text-white bg-blue-500 px-3 py-1 rounded text-xs font-bold">Buka Link</a>
                                                    @else <span class="text-xs text-green-700 font-bold">Cek Fisik</span> @endif
                                                </td>
                                                <td class="p-3 text-center bg-indigo-50">
                                                    <input type="checkbox" x-model="checks" value="{{ $k }}" class="w-6 h-6 text-green-600 rounded cursor-pointer">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-red-700 mb-1">Catatan Koreksi (Bila Ada Kesalahan)</label>
                            <textarea name="catatan_koreksi" x-model="catatan" rows="3" class="w-full rounded border-red-300 shadow-sm focus:border-red-500" placeholder="Tulis alasan penolakan atau perbaikan berkas di sini..."></textarea>
                        </div>

                        <div class="flex justify-between items-center bg-gray-100 p-4 rounded border">
                            <button type="button" @click="step = 3" class="bg-gray-400 text-white px-5 py-2 rounded font-bold">&laquo; Kembali</button>
                            <div class="space-x-3">
                                <button type="submit" name="aksi" value="tolak" :disabled="catatan === ''" :class="catatan === '' ? 'bg-red-300 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700'" class="text-white px-5 py-2 rounded font-bold transition">Berkas Tidak Lengkap</button>
                                
                                <button type="submit" name="aksi" value="terima" :disabled="checks.length < totalFiles" :class="checks.length < totalFiles ? 'bg-green-300 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'" class="text-white px-5 py-2 rounded font-bold transition">Berkas Diterima (Lanjut)</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>