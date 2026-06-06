<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengajuan Surat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="pengajuanForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Pengajuan Gagal!</strong>
                        <ul class="list-disc ml-5 mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pilih Jenis Surat</label>
                        <select name="surat_template_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" @change="fetchTemplateData($event.target.value)" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($templates as $t)
                                <option value="{{ $t->id }}">{{ $t->nama_surat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="templateData?.parameter_dinamis?.length > 0">
    <h3 class="font-bold text-lg text-gray-800 border-b mb-4 pb-2 mt-6">
        Form Isian Surat
    </h3>

    <template x-for="(param, index) in templateData?.parameter_dinamis" :key="'param'+index">
        <div class="mb-4" :class="param.startsWith('statis.') ? 'hidden' : ''">

            <label class="block text-sm font-medium text-gray-700" x-text="param"></label>

            <input
                type="text"
                :name="'parameter_dinamis[' + param + ']'"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                :required="!param.startsWith('statis.')"
            >
        </div>
    </template>
</div>

                        <div x-show="templateData?.syarat_dokumen?.length > 0">
                            <h3 class="font-bold text-lg text-gray-800 border-b mb-4 pb-2 mt-6">Persyaratan Lampiran</h3>
                            <input type="hidden" name="syarat_dokumen_keys" :value="JSON.stringify(templateData?.syarat_dokumen)">
                            
                            <template x-for="(syarat, index) in templateData?.syarat_dokumen" :key="'syarat'+index">
                                <div class="mb-4 p-4 border border-gray-200 rounded-md bg-gray-50">
                                    <label class="block text-sm font-bold text-gray-800 mb-2" x-text="syarat"></label>
                                    
                                    <div class="flex space-x-6 mb-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" :name="'tipe_lampiran_' + index" value="file" checked class="text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">Upload File (PDF/JPG max 2MB)</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" :name="'tipe_lampiran_' + index" value="link" class="text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">Link Google Drive</span>
                                        </label>
                                    </div>

                                    <input type="file" :name="'file_lampiran_' + index" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept=".pdf,.jpg,.jpeg,.png">
                                    <input type="url" :name="'link_lampiran_' + index" class="mt-3 block w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="Masukkan URL Google Drive (Hanya jika memilih opsi Link)">
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition font-medium shadow-sm">
                            Kirim Pengajuan Surat
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function pengajuanForm() {
            return {
                templateData: null,
                async fetchTemplateData(id) {
                    if(!id) { 
                        this.templateData = null; 
                        return; 
                    }
                    try {
                        const response = await fetch(`/user/get-template/${id}`);
                        this.templateData = await response.json();
                    } catch (error) {
                        console.error('Gagal mengambil data template:', error);
                        alert('Terjadi kesalahan saat memuat form surat.');
                    }
                }
            }
        }
    </script>
</x-app-layout>