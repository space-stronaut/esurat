<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="{{ route('admin.pemrosesan.index') }}" class="text-gray-500 hover:text-blue-600 transition mr-3">
                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            {{ __('Proses Surat:') }} {{ $pemrosesan->template->nama_surat ?? 'Template Tidak Diketahui' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Pemohon
                    </h3>
                    <table class="w-full text-sm mb-2">
                        <tr><td class="py-1 text-gray-600 w-1/3">Nama Lengkap</td><td class="font-bold text-gray-900">: {{ $pemrosesan->penduduk->nama_lengkap ?? '-' }}</td></tr>
                        <tr><td class="py-1 text-gray-600">NIK</td><td class="font-bold text-gray-900">: {{ $pemrosesan->penduduk->nik ?? '-' }}</td></tr>
                        <tr><td class="py-1 text-gray-600">Tanggal Pengajuan</td><td class="font-medium">: {{ $pemrosesan->created_at->format('d F Y, H:i') }} WIB</td></tr>
                        <tr><td class="py-1 text-gray-600">Jalur Pengajuan</td><td class="font-medium">: <span class="uppercase bg-gray-100 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-600">{{ $pemrosesan->jenis_pengajuan }}</span></td></tr>
                    </table>
                </div>

                @if($pemrosesan->isian_dinamis && count($pemrosesan->isian_dinamis) > 0)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Isian Surat Warga
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        @foreach($pemrosesan->isian_dinamis as $parameter => $jawaban)
                            <div class="bg-blue-50 p-3 rounded border border-blue-100">
                                <span class="block text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">{{ str_replace('_', ' ', $parameter) }}</span>
                                <span class="text-gray-900 font-medium">{{ $jawaban }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($pemrosesan->lampiran_syarat && count($pemrosesan->lampiran_syarat) > 0)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Berkas Persyaratan Dilampirkan
                    </h3>
                    <ul class="space-y-3">
                        @foreach($pemrosesan->lampiran_syarat as $namaSyarat => $dataLampiran)
                            <li class="flex flex-col sm:flex-row sm:items-center justify-between bg-gray-50 p-3 rounded border border-gray-200">
                                <div class="text-sm font-bold text-gray-700 mb-2 sm:mb-0">{{ $namaSyarat }}</div>
                                <div>
                                    @if($dataLampiran['tipe'] == 'file')
                                        <a href="{{ asset('storage/' . $dataLampiran['path']) }}" target="_blank" class="inline-flex items-center text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1.5 rounded font-bold transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Lihat File Berkas
                                        </a>
                                    @elseif($dataLampiran['tipe'] == 'link')
                                        <a href="{{ $dataLampiran['path'] }}" target="_blank" class="inline-flex items-center text-xs bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded font-bold transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            Buka Link GDrive
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div>
                <div class="sticky top-6 space-y-6">
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                            <strong class="font-bold">Gagal Menyimpan!</strong>
                            <ul class="list-disc ml-5 mt-2 text-xs">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="bg-gradient-to-br from-green-50 to-emerald-100 p-6 rounded-lg shadow-sm border border-green-200">
                        <h3 class="text-sm font-bold text-green-800 uppercase tracking-wider mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Pembuatan Dokumen
                        </h3>
                        <p class="text-xs text-green-700 mb-4 font-medium">Sistem akan menyatukan Biodata Warga dan Isian Form ke dalam Template Word secara otomatis.</p>
                        
                        <a href="{{ route('admin.pemrosesan.generate_docx', $pemrosesan->id) }}" class="w-full flex items-center justify-center bg-green-600 text-white px-4 py-3 rounded-md hover:bg-green-700 transition font-bold shadow-md">
                            Unduh Draft Surat (.docx)
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Ubah Status Pengajuan</h3>
                        
                        <form action="{{ route('admin.pemrosesan.update', $pemrosesan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-5">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Posisi Berkas Saat Ini</label>
                                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" onchange="toggleHasilForm(this.value)">
                                    <option value="menunggu" {{ $pemrosesan->status == 'menunggu' ? 'selected' : '' }}>Menunggu (Baru Masuk)</option>
                                    <option value="diproses" {{ $pemrosesan->status == 'diproses' ? 'selected' : '' }}>Diproses (Sedang Dikerjakan/Dicetak)</option>
                                    <option value="selesai" {{ $pemrosesan->status == 'selesai' ? 'selected' : '' }}>Selesai (Surat Sudah Jadi)</option>
                                    <option value="dibatalkan" {{ $pemrosesan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan (Berkas Ditolak)</option>
                                </select>
                            </div>

                            
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-md hover:bg-blue-700 transition font-bold mt-4 shadow-md">
                                Simpan Perubahan Status
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleHasilForm(status) {
            document.getElementById('hasil_form').style.display = status === 'selesai' ? 'block' : 'none';
        }
    </script>
</x-app-layout>