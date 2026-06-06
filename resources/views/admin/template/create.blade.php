<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Template Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nama Jenis Surat</label>
                            <input type="text" name="nama_surat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required placeholder="Contoh: Surat Keterangan Domisili">
                        </div>

                        <div class="mb-4 p-4 border border-blue-200 bg-blue-50 rounded-md">
                            <label class="block text-sm font-medium text-gray-700">File Template (.docx)</label>
                            <input type="file" name="file_template" accept=".docx" class="mt-1 block w-full text-sm text-gray-500" required>
                            <p class="text-xs text-gray-500 mt-1">Hanya menerima file berekstensi .docx (Maks 5MB)</p>
                        </div>

                        <div class="mb-6 p-4 border-l-4 border-yellow-400 bg-yellow-50 rounded-r-md">
                            <h4 class="font-bold text-sm text-yellow-800 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path></svg>
                                Parameter Dinamis Auto-Detect Aktif
                            </h4>
                            <p class="text-sm text-yellow-700 mt-2">
                                Sistem menggunakan library <b>PhpWord</b> untuk membaca file <b>.docx</b> secara otomatis.<br>
                                <b>PENTING:</b> Pastikan form isian di dalam template Word Anda diketik menggunakan format kurung kurawal dan tanda dolar <code>${Nama_Parameter}</code>. Jangan gunakan spasi pada nama parameter.
                                <br><br>
                                <i>Contoh penulisan di dalam Word:</i><br>
                                <span class="inline-block bg-white px-2 py-1 mt-1 rounded border border-yellow-200">
                                    "Bahwa orang tersebut benar berdomisili di <b>${Alamat_Sekarang}</b> dengan keperluan <b>${Tujuan_Pembuatan}</b>..."
                                </span>
                            </p>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mt-6 mb-2 border-b pb-2">Pengaturan Atribut Surat</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Format Nomor Baku</label>
                                <input type="text" name="format_nomor_baku" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: /Kec.TA/V/2026">
                            </div>
                            <div class="flex flex-col space-y-2 mt-6">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_pakai_nomor" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" checked>
                                    <span class="ml-2 text-sm text-gray-600">Gunakan Nomor Surat</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_pakai_perihal" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                    <span class="ml-2 text-sm text-gray-600">Gunakan Perihal</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_pakai_lampiran" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                    <span class="ml-2 text-sm text-gray-600">Gunakan Lampiran</span>
                                </label>
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mt-6 mb-2 border-b pb-2">Syarat Dokumen Tambahan</h3>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Syarat Lampiran Pemohon (Pisahkan dengan Koma)</label>
                            <input type="text" name="syarat_dokumen" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: Scan KK, Surat Pengantar RT/RW">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika surat ini tidak membutuhkan dokumen persyaratan dari pemohon.</p>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.template.index') }}" class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-medium">Simpan Template</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>