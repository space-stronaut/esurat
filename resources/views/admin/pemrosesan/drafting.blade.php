<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Proses Selesai (Drafting)</h2>
    </x-slot>

    <div class="py-12" x-data="{ step: 1 }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between border-b pb-4 mb-6 text-sm font-bold text-gray-400">
                    <span :class="step === 1 ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-green-600'">1. Info Pemohon</span>
                    <span :class="step === 2 ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : (step > 2 ? 'text-green-600' : '')">2. Detail Data</span>
                    <span :class="step === 3 ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : ''">3. Proses Selesai (Drafting)</span>
                </div>

                <form action="{{ route('admin.pemrosesan.process_drafting', $pemrosesan->id) }}" method="POST">
                    @csrf

                    <div x-show="step === 1" x-transition>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Pemohon</h3>
                        <p class="mb-6 font-medium text-gray-700">Nama: {{ $pemrosesan->penduduk->nama_lengkap }} <br> NIK: {{ $pemrosesan->penduduk->nik }}</p>
                        <div class="flex justify-end"><button type="button" @click="step = 2" class="bg-indigo-600 text-white px-5 py-2 rounded font-bold">Lanjut &raquo;</button></div>
                    </div>

                    <div x-show="step === 2" style="display:none;" x-transition>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Detail Isian Surat</h3>
                        <p class="mb-6 text-gray-600 italic">Pastikan data isian warga sudah benar sebelum dibuatkan nomor surat.</p>
                        <div class="flex justify-between">
                            <button type="button" @click="step = 1" class="bg-gray-300 px-5 py-2 rounded font-bold">&laquo; Kembali</button>
                            <button type="button" @click="step = 3" class="bg-indigo-600 text-white px-5 py-2 rounded font-bold">Lanjut: Buat Nomor Surat &raquo;</button>
                        </div>
                    </div>

                    <div x-show="step === 3" style="display:none;" x-transition>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-green-500 pl-3">Pengaturan Nomor & Tanggal Surat</h3>
                        <div class="p-5 border border-green-200 bg-green-50 rounded-lg mb-6">
                            @if($pemrosesan->template->gunakan_nomor)
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Urut Surat (Wajib)</label>
                                    <input type="text" name="nomor_urut" required class="w-full rounded border-gray-300 shadow-sm focus:border-green-500">
                                    <p class="text-[11px] text-gray-500 mt-1">Format Baku: <b>{{ $pemrosesan->template->format_nomor_baku }}</b></p>
                                </div>
                            @endif
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" required value="{{ date('Y-m-d') }}" class="w-full rounded border-gray-300 shadow-sm focus:border-green-500">
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <button type="button" @click="step = 2" class="bg-gray-300 px-5 py-2 rounded font-bold">&laquo; Kembali</button>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-bold shadow-md">Simpan Data & Lanjut Menunggu TTD</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>