<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="{{ route('admin.pemrosesan.index') }}" class="text-gray-500 hover:text-blue-600 transition mr-3">&larr;</a>
            {{ __('Proses Surat:') }} {{ $pemrosesan->template->nama_surat ?? 'Template Tidak Diketahui' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Informasi Pemohon</h3>
                    <table class="w-full text-sm mb-2">
                        <tr><td class="py-1 text-gray-600 w-1/3">Nama Lengkap</td><td class="font-bold text-gray-900">: {{ $pemrosesan->penduduk->nama_lengkap ?? '-' }}</td></tr>
                        <tr><td class="py-1 text-gray-600">NIK</td><td class="font-bold text-gray-900">: {{ $pemrosesan->penduduk->nik ?? '-' }}</td></tr>
                        <tr>
                            <td class="py-1 text-gray-600">Jalur Pengajuan</td>
                            <td class="font-bold text-gray-900">: 
                                <span class="uppercase px-2 py-0.5 rounded text-xs {{ $pemrosesan->jenis_pengajuan == 'online' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ $pemrosesan->jenis_pengajuan }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>

                @if($pemrosesan->isian_dinamis)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Isian Surat Warga</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        @foreach($pemrosesan->isian_dinamis as $parameter => $jawaban)
                            <div class="bg-blue-50 p-3 rounded border border-blue-100">
                                <span class="block text-xs font-bold text-blue-800 uppercase mb-1">{{ str_replace('_', ' ', $parameter) }}</span>
                                <span class="text-gray-900 font-medium">{{ $jawaban }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($pemrosesan->lampiran_syarat)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Berkas Lampiran & Verifikasi</h3>
                    <ul class="space-y-3">
                        @foreach($pemrosesan->lampiran_syarat as $namaSyarat => $dataLampiran)
                            <li class="flex flex-col sm:flex-row sm:items-center justify-between bg-gray-50 p-3 rounded border border-gray-200">
                                <div class="text-sm font-bold text-gray-700 mb-2 sm:mb-0">{{ $namaSyarat }}</div>
                                <div>
                                    @if($dataLampiran['tipe'] == 'file')
                                        <a href="{{ asset('storage/' . $dataLampiran['path']) }}" target="_blank" class="inline-flex items-center text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1.5 rounded font-bold transition shadow-sm">
                                            Lihat File (.PDF/IMG)
                                        </a>
                                    @elseif($dataLampiran['tipe'] == 'link')
                                        <a href="{{ $dataLampiran['path'] }}" target="_blank" class="inline-flex items-center text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded font-bold transition shadow-sm">
                                            Buka Link GDrive
                                        </a>
                                    
                                    @elseif($dataLampiran['tipe'] == 'verifikasi_fisik')
                                        <span class="inline-flex items-center text-xs px-3 py-1.5 rounded font-bold shadow-sm border {{ $dataLampiran['status'] == 'Telah Diverifikasi Fisik' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200' }}">
                                            @if($dataLampiran['status'] == 'Telah Diverifikasi Fisik')
                                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-4 h-4 mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @endif
                                            {{ $dataLampiran['status'] }}
                                        </span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div class="space-y-6">
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                        <strong class="font-bold">Error Input!</strong>
                        <ul class="list-disc ml-5 mt-2 text-xs">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <div class="bg-gradient-to-br from-green-50 to-emerald-100 p-6 rounded-lg shadow-sm border border-green-200">
                    <h3 class="text-sm font-bold text-green-800 uppercase tracking-wider mb-4">Penerbitan Surat (Drafting)</h3>
                    
                    <form action="{{ route('admin.pemrosesan.generate_docx', $pemrosesan->id) }}" method="POST">
                        @csrf
                        @if($pemrosesan->template->gunakan_nomor)
                            <div class="mb-3 bg-white p-3 rounded border border-green-200 shadow-sm">
                                <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Urut Surat (Manual)</label>
                                <input type="text" name="nomor_urut" required placeholder="Contoh: 005" class="w-full rounded text-sm border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <p class="text-[10px] text-gray-500 mt-1">Disisipkan ke: <b>{{ $pemrosesan->template->format_nomor_baku }}</b></p>
                            </div>
                        @endif
                        
                        <div class="mb-4 bg-white p-3 rounded border border-green-200 shadow-sm">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" required value="{{ $pemrosesan->tanggal_surat ?? date('Y-m-d') }}" class="w-full rounded text-sm border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2.5 rounded-md hover:bg-green-700 transition font-bold shadow-md text-sm">
                            Simpan Data & Unduh DOCX
                        </button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Ubah Status Warga</h3>
                    <form action="{{ route('admin.pemrosesan.update', $pemrosesan->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-5">
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="menunggu" {{ $pemrosesan->status == 'menunggu' ? 'selected' : '' }}>Menunggu (Baru)</option>
                                <option value="diproses" {{ $pemrosesan->status == 'diproses' ? 'selected' : '' }}>Diproses Admin</option>
                                <option value="selesai" {{ $pemrosesan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $pemrosesan->status == 'dibatalkan' ? 'selected' : '' }}>Ditolak / Batal</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition font-bold shadow-sm">
                            Update Status Saja
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>