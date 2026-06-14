<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengajuan Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase">Total Surat Masuk</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['masuk'] }}</h3>
        </div>
        <div class="bg-gray-100 p-3 rounded-full text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-red-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-red-500 uppercase">Total Dikembalikan</p>
            <h3 class="text-2xl font-bold text-red-700">{{ $stats['dikembalikan'] }}</h3>
        </div>
        <div class="bg-red-50 p-3 rounded-full text-red-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-yellow-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-yellow-600 uppercase">Menunggu TTD</p>
            <h3 class="text-2xl font-bold text-yellow-700">{{ $stats['menunggu_ttd'] }}</h3>
        </div>
        <div class="bg-yellow-50 p-3 rounded-full text-yellow-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-green-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-green-600 uppercase">Surat Selesai</p>
            <h3 class="text-2xl font-bold text-green-700">{{ $stats['selesai'] }}</h3>
        </div>
        <div class="bg-green-50 p-3 rounded-full text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm font-bold shadow-sm">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm font-bold shadow-sm">{{ session('error') }}</div>
                    @endif

                    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        <form method="GET" action="{{ route('admin.pemrosesan.index') }}" class="flex w-full md:w-1/2 gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIK / No Surat..." class="rounded-md border-gray-300 w-full shadow-sm text-sm">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md font-bold text-sm shadow-sm hover:bg-gray-700">Cari</button>
                        </form>
                        <a href="{{ route('admin.pemrosesan.create_offline') }}" class="bg-gray-600 text-white px-5 py-2.5 rounded-md hover:bg-indigo-700 transition font-bold text-sm shadow-md whitespace-nowrap">+ Buat Pengajuan (Offline)</a>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full table-auto border-collapse">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Pemohon</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Surat & Nomor</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi Berdasarkan Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengajuans as $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $p->penduduk->nama_lengkap ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">NIK: {{ $p->penduduk->nik ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-blue-800">{{ $p->template->nama_surat ?? 'Dihapus' }}</div>
                                        <div class="text-xs text-gray-500 font-medium mt-1">No: {{ $p->nomor_surat ?? 'Belum Drafting' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        @if($p->status == 'pengajuan_baru')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">Pengajuan Baru</span>
                                        @elseif($p->status == 'sedang_diproses')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Sedang Diproses</span>
                                        @elseif($p->status == 'dikembalikan')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Dikembalikan</span>
                                        @elseif($p->status == 'menunggu_ttd')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Menunggu TTD</span>
                                        @elseif($p->status == 'siap_diambil')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Siap Diambil</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        
                                        @if($p->status == 'pengajuan_baru')
                                            <a href="{{ route('admin.pemrosesan.verifikasi', $p->id) }}" class="text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded-md font-bold text-xs shadow-sm">Verifikasi Dokumen</a>
                                        
                                        @elseif($p->status == 'sedang_diproses')
                                            <a href="{{ route('admin.pemrosesan.drafting', $p->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-md font-bold text-xs shadow-sm">Proses Selesai (Drafting)</a>

                                        @elseif($p->status == 'dikembalikan')
                                            <button onclick="alert('Catatan ke Warga: \n\n{{ addslashes($p->catatan_koreksi) }}')" class="text-white bg-gray-600 hover:bg-gray-700 px-3 py-1.5 rounded-md font-bold text-xs shadow-sm">Lihat Catatan Koreksi</button>

                                        @elseif($p->status == 'menunggu_ttd')
                                            <a href="{{ route('admin.pemrosesan.unduh_draft', $p->id) }}" class="text-white bg-amber-500 hover:bg-amber-600 px-3 py-1.5 rounded-md font-bold text-xs shadow-sm mr-2">Unduh Draft</a>
                                            
                                            <button onclick="document.getElementById('modal-konfirmasi-{{ $p->id }}').classList.remove('hidden')" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-md font-bold text-xs shadow-sm">Selesaikan Proses</button>

                                            <div id="modal-konfirmasi-{{ $p->id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 h-full w-full z-50 flex items-center justify-center">
                                                <div class="relative p-6 border shadow-2xl rounded-lg bg-white w-full max-w-md text-left" x-data="{ captcha: '' }">
                                                    <h3 class="text-lg font-bold mb-2 text-red-600 border-b pb-2">Konfirmasi Selesaikan Proses!</h3>
                                                    <p class="text-xs text-gray-600 mb-4 whitespace-normal">Peringatan: Pastikan draf surat telah disetujui dan ditandatangani. Ketikkan kata <b class="text-red-600">KONFIRMASI</b> (huruf besar semua) di bawah ini untuk melanjutkan.</p>
                                                    
                                                    <form action="{{ route('admin.pemrosesan.selesai_ttd', $p->id) }}" method="POST">
                                                        @csrf
                                                        <input type="text" name="konfirmasi" x-model="captcha" placeholder="Ketik: KONFIRMASI" class="w-full mb-5 border-gray-300 rounded text-sm text-center font-bold tracking-widest uppercase">
                                                        <div class="flex justify-end space-x-3">
                                                            <button type="button" onclick="document.getElementById('modal-konfirmasi-{{ $p->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-200 font-bold rounded text-sm">Batal</button>
                                                            <button type="submit" :disabled="captcha !== 'KONFIRMASI'" :class="captcha === 'KONFIRMASI' ? 'bg-green-600 hover:bg-green-700' : 'bg-green-300 cursor-not-allowed'" class="px-4 py-2 text-white font-bold rounded text-sm transition">Ya, Lanjut</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        @elseif($p->status == 'siap_diambil')
                                            <button onclick="document.getElementById('modal-gdrive-{{ $p->id }}').classList.remove('hidden')" class="text-white bg-purple-600 hover:bg-purple-700 px-3 py-1.5 rounded-md font-bold text-xs shadow-sm">Unggah Surat (Final)</button>

                                            <div id="modal-gdrive-{{ $p->id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 h-full w-full z-50 flex items-center justify-center">
                                                <div class="relative p-6 border shadow-2xl rounded-lg bg-white w-full max-w-md text-left">
                                                    <h3 class="text-lg font-bold mb-2 border-b pb-2">Upload Surat Akhir (Google Drive)</h3>
                                                    <form action="{{ route('admin.pemrosesan.upload_gdrive', $p->id) }}" method="POST">
                                                        @csrf
                                                        <input type="url" name="link_gdrive" value="{{ $p->link_gdrive }}" required placeholder="https://drive.google.com/..." class="w-full mb-4 border-gray-300 rounded text-sm">
                                                        <div class="flex justify-end space-x-3">
                                                            <button type="button" onclick="document.getElementById('modal-gdrive-{{ $p->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-200 font-bold rounded text-sm">Batal</button>
                                                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white font-bold rounded text-sm">Simpan Link</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>