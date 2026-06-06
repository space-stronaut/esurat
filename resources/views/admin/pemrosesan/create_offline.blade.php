<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="{{ route('admin.pemrosesan.index') }}" class="text-gray-500 hover:text-indigo-600 transition mr-3">
                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            {{ __('Buat Pengajuan Warga (Walk-in / Offline)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="pengajuanOfflineForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border border-gray-100">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                        <strong class="font-bold">Gagal Menyimpan Data!</strong>
                        <ul class="list-disc ml-5 mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-8 p-4 border-l-4 border-indigo-500 bg-indigo-50 rounded-r-md">
                    <p class="text-sm text-indigo-800">
                        <strong class="font-bold">Mode Admin (Walk-in):</strong> Gunakan form ini untuk memproses permohonan surat bagi warga yang datang langsung ke kantor. Data akan langsung masuk ke antrean pemrosesan.
                    </p>
                </div>

                <form action="{{ route('admin.pemrosesan.store_offline') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-bold text-gray-800 mb-2">1. Pilih Warga (Pemohon)</label>
                            <select name="penduduk_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Cari Nama / NIK Warga --</option>
                                @foreach($penduduks as $p)
                                    <option value="{{ $p->id }}">{{ $p->nik }} - {{ $p->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2 italic">*Hanya warga yang terdaftar di Master Data yang akan muncul.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-bold text-gray-800 mb-2">2. Pilih Template Surat</label>
                            <select name="surat_template_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" @change="fetchTemplateData($event.target.value)" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($templates as $t)
                                    <option value="{{ $t->id }}">{{ $t->nama_surat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div x-show="templateData" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                        
                        <div x-show="templateData?.parameter_dinamis?.length > 0">
                            <h3 class="font-bold text-lg text-gray-800 border-b-2 border-gray-100 mb-5 pb-2 mt-2">Form Isian Surat</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                                <template x-for="(param, index) in templateData?.parameter_dinamis" :key="'param'+index">
                                    <div :class="param.startsWith('statis.') ? 'hidden' : ''">
                                        <label class="block text-sm font-bold text-gray-700 mb-1 capitalize" x-text="param.replace(/_/g, ' ')"></label>
                                        <input type="text" :name="'parameter_dinamis[' + param + ']'" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :required="!param.startsWith('statis.')">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="templateData?.syarat_dokumen?.length > 0" class="mt-8">
                            <h3 class="font-bold text-lg text-gray-800 border-b-2 border-gray-100 mb-2 pb-2">Berkas Fisik (Lampiran)</h3>
                            <p class="text-sm text-gray-600 mb-5">Warga membawa berkas fisik? Anda dapat memfoto/scan dan mengunggahnya ke sini sebagai arsip digital.</p>
                            
                            <input type="hidden" name="syarat_dokumen_keys" :value="JSON.stringify(templateData?.syarat_dokumen)">
                            
                            <div class="space-y-4">
                                <template x-for="(syarat, index) in templateData?.syarat_dokumen" :key="'syarat'+index">
                                    <div class="p-5 border border-indigo-100 rounded-lg bg-indigo-50/30">
                                        <label class="block text-base font-bold text-indigo-900 mb-3" x-text="syarat"></label>
                                        
                                        <div class="flex flex-wrap gap-4 mb-4">
                                            <label class="inline-flex items-center cursor-pointer bg-white px-3 py-2 border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 transition">
                                                <input type="radio" :name="'tipe_lampiran_' + index" value="file" checked class="text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                                <span class="ml-2 text-sm font-medium text-gray-700">Upload File / Scan</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer bg-white px-3 py-2 border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 transition">
                                                <input type="radio" :name="'tipe_lampiran_' + index" value="link" class="text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                                <span class="ml-2 text-sm font-medium text-gray-700">Link GDrive (Opsional)</span>
                                            </label>
                                        </div>

                                        <input type="file" :name="'file_lampiran_' + index" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer" accept=".pdf,.jpg,.jpeg,.png">
                                        
                                        <input type="url" :name="'link_lampiran_' + index" class="mt-3 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan URL Google Drive (Hanya jika memilih opsi Link GDrive)">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-5 border-t border-gray-200 flex items-center justify-end">
                        <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-8 py-3 rounded-md hover:bg-indigo-700 transition font-bold shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Pengajuan Masuk
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function pengajuanOfflineForm() {
            return {
                templateData: null,
                async fetchTemplateData(id) {
                    if(!id) { 
                        this.templateData = null; 
                        return; 
                    }
                    try {
                        const response = await fetch(`/admin/pengajuan-offline/get-template/${id}`);
                        this.templateData = await response.json();
                    } catch (error) {
                        console.error('Gagal mengambil data:', error);
                        alert('Terjadi kesalahan saat memuat form surat.');
                    }
                }
            }
        }
    </script>
</x-app-layout>