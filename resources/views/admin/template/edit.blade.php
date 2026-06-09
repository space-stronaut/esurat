<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="{{ route('admin.template.index') }}" class="text-gray-500 hover:text-indigo-600 mr-3">&larr;</a> 
            {{ __('Edit Template:') }} {{ $template->nama_surat }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-sm">
                        <strong class="font-bold">Gagal Menyimpan!</strong>
                        <ul class="list-disc ml-5 mt-2 text-sm">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.template.update', $template->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Surat</label>
                        <input type="text" name="nama_surat" value="{{ old('nama_surat', $template->nama_surat) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi / Kegunaan</label>
                        <textarea name="deskripsi" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $template->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-6 p-4 border border-indigo-100 bg-indigo-50 rounded-lg">
                        <label class="block text-sm font-bold text-indigo-800 mb-2">Ganti File Template (.docx)</label>
                        <p class="text-xs text-gray-500 mb-2">*Abaikan (jangan upload apapun) jika Anda tidak ingin mengubah file Word yang sudah ada.</p>
                        <input type="file" name="file_template" accept=".docx" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-white file:text-indigo-700 file:border file:border-indigo-300 hover:file:bg-indigo-100 cursor-pointer">
                    </div>

                    <div x-data="{ gunakanNomor: {{ $template->gunakan_nomor ? 'true' : 'false' }} }" class="p-5 border border-gray-200 bg-gray-50 rounded-lg mb-6">
                        <div class="mb-4 border-b border-gray-200 pb-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="hidden" name="gunakan_nomor" value="0">
                                <input type="checkbox" name="gunakan_nomor" x-model="gunakanNomor" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm w-5 h-5 focus:ring-indigo-500">
                                <span class="ml-3 text-base font-bold text-gray-800">Gunakan Nomor Surat Otomatis</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-8 italic">Jika tidak dicentang, surat ini tidak memiliki nomor, dan fitur Perihal serta Lampiran otomatis dinonaktifkan.</p>
                        </div>

                        <div x-show="gunakanNomor" x-transition class="ml-8 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Format Nomor Baku (Wajib Diisi)</label>
                                <input type="text" name="format_nomor_baku" value="{{ old('format_nomor_baku', $template->format_nomor_baku) }}" x-bind:required="gunakanNomor" placeholder="Contoh: B-[NOMOR]/Surket/[BULAN]/[TAHUN]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <p class="text-xs text-blue-600 font-medium mt-1">Sistem akan mengganti <b>[NOMOR]</b>, <b>[BULAN]</b>, dan <b>[TAHUN]</b> saat Admin memproses surat.</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-6 mt-4">
                                <label class="inline-flex items-center bg-white px-4 py-2 border border-gray-200 rounded-md shadow-sm cursor-pointer hover:bg-gray-50">
                                    <input type="hidden" name="gunakan_perihal" value="0">
                                    <input type="checkbox" name="gunakan_perihal" value="1" {{ $template->gunakan_perihal ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 w-4 h-4 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700 font-bold">Aktifkan Isian Perihal</span>
                                </label>
                                <label class="inline-flex items-center bg-white px-4 py-2 border border-gray-200 rounded-md shadow-sm cursor-pointer hover:bg-gray-50">
                                    <input type="hidden" name="gunakan_lampiran" value="0">
                                    <input type="checkbox" name="gunakan_lampiran" value="1" {{ $template->gunakan_lampiran ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 w-4 h-4 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700 font-bold">Aktifkan Isian Lampiran</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-white p-4 border border-gray-200 rounded-lg shadow-sm">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Form Isian Tambahan Warga</label>
                            <p class="text-[11px] text-gray-500 mb-2">Pisahkan dengan koma (Contoh: <i>keperluan, tujuan_instansi</i>).</p>
                            <textarea name="parameter_dinamis" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 text-sm">{{ is_array($template->parameter_dinamis) ? implode(', ', $template->parameter_dinamis) : $template->parameter_dinamis }}</textarea>
                        </div>

                        <div class="bg-white p-4 border border-gray-200 rounded-lg shadow-sm">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Syarat Berkas Pendukung</label>
                            <p class="text-[11px] text-gray-500 mb-2">Pisahkan dengan koma (Contoh: <i>Foto KTP, KK</i>).</p>
                            <textarea name="syarat_dokumen" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 text-sm">{{ is_array($template->syarat_dokumen) ? implode(', ', $template->syarat_dokumen) : $template->syarat_dokumen }}</textarea>
                        </div>
                    </div>

                    <div class="border-t pt-5">
                        <button type="submit" class="bg-amber-500 text-white px-6 py-2.5 rounded-md hover:bg-amber-600 font-bold shadow-md transition">
                            Simpan Perubahan Template
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>