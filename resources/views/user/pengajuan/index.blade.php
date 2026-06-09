<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pengajuan Surat Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm font-bold shadow-sm">{{ session('success') }}</div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Daftar Pengajuan</h3>
                        <a href="{{ route('user.pengajuan.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-md hover:bg-blue-700 transition font-bold text-sm">+ Buat Pengajuan Baru</a>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Surat</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuans as $p)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-blue-800">{{ $p->template->nama_surat }}</div>
                                        <div class="text-xs text-gray-500">No: {{ $p->nomor_surat ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm">
                                        @if($p->status == 'pengajuan_baru') <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-[10px] font-bold uppercase">Pengajuan Baru</span>
                                        @elseif($p->status == 'sedang_diproses') <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-[10px] font-bold uppercase">Sedang Diproses</span>
                                        @elseif($p->status == 'dikembalikan') 
                                            <span class="block px-2 py-1 bg-red-100 text-red-800 rounded-full text-[10px] font-bold uppercase mb-1">Dikembalikan (Perlu Perbaikan)</span>
                                            <p class="text-[10px] text-red-600 italic">"{{ Str::limit($p->catatan_koreksi, 30) }}"</p>
                                        @elseif($p->status == 'menunggu_ttd') <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[10px] font-bold uppercase">Menunggu TTD</span>
                                        @elseif($p->status == 'siap_diambil') <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-bold uppercase">Siap Diambil</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($p->status == 'dikembalikan')
                                            <a href="{{ route('user.pengajuan.edit', $p->id) }}" class="text-white bg-amber-500 hover:bg-amber-600 px-3 py-1.5 rounded-md font-bold text-xs">Perbaiki Data</a>
                                        @elseif($p->status == 'siap_diambil' && $p->link_gdrive)
                                            <a href="{{ $p->link_gdrive }}" target="_blank" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-md font-bold text-xs">Unduh Surat</a>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-6 py-10 text-center text-gray-500">Belum ada pengajuan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>