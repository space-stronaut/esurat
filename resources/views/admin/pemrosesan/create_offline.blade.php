<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengajuan Warga (Offline)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" x-data="pengajuanOfflineForm()">
                    
                    <form action="{{ route('admin.pemrosesan.store_offline') }}" method="POST">
                        @csrf
                        
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Pemohon (Berdasarkan Master Penduduk)</label>
                            <select name="penduduk_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Warga yang Datang --</option>
                                @foreach($penduduks as $penduduk)
                                    <option value="{{ $penduduk->id }}">{{ $penduduk->nik }} - {{ $penduduk->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Jenis Surat yang Dibuat</label>
                            <select name="surat_template_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" @change="fetchTemplateData($event.target.value)" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->nama_surat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div x-show="templateData" x-transition class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-600 pl-3">Pengisian Data & Verifikasi</h3>

                            <template x-if="templateData && templateData.parameter_dinamis && templateData.parameter_dinamis.length > 0">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-5 border border-gray-200 rounded-lg bg-gray-50">
                                    <template x-for="(param, index) in templateData.parameter_dinamis" :key="index">
                                        <div :class="param.startsWith('statis.') ? 'hidden' : ''">
                                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1" x-text="param.replace(/_/g, ' ')"></label>
                                            <input type="text" :required="!param.startsWith('statis.')" :name="'parameter_dinamis[' + param + ']'" class="w-full rounded text-sm border-gray-300 shadow-sm focus:border-indigo-500">
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="templateData && templateData.syarat_dokumen && templateData.syarat_dokumen.length > 0">
                                <div class="mb-6 p-5 border border-indigo-200 bg-indigo-50 rounded-lg shadow-sm">
                                    <h3 class="text-sm font-bold text-indigo-800 mb-1">Verifikasi Berkas Fisik Warga</h3>
                                    <p class="text-xs text-indigo-600 mb-4">Centang pada kolom di bawah ini jika dokumen fisik telah Anda periksa keasliannya di tempat.</p>
                                    
                                    <div class="overflow-hidden border border-indigo-200 rounded-md">
                                        <table class="min-w-full bg-white text-sm">
                                            <thead class="bg-indigo-100 border-b border-indigo-200">
                                                <tr>
                                                    <th class="px-4 py-3 text-left font-bold text-indigo-800">Nama Dokumen Syarat</th>
                                                    <th class="px-4 py-3 text-center font-bold text-indigo-800 w-40">Telah Diverifikasi?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(syarat, index) in templateData.syarat_dokumen" :key="index">
                                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                                        <td class="px-4 py-3 text-gray-800 font-medium" x-text="syarat"></td>
                                                        <td class="px-4 py-3 text-center">
                                                            <input type="checkbox" :name="'verifikasi_dokumen_' + index" value="1" class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer shadow-sm" required>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" name="syarat_dokumen_keys" :value="JSON.stringify(templateData.syarat_dokumen)">
                                </div>
                            </template>

                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 transition font-bold shadow-md text-sm mt-2">
                                Simpan Pengajuan Surat (Offline)
                            </button>
                        </div>
                    </form>

                </div>
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
                        const response = await fetch(`{{ url('admin/pengajuan-offline/get-template') }}/${id}`);
                        this.templateData = await response.json();
                    } catch (error) {
                        console.error('Error fetching template:', error);
                    }
                }
            }
        }
    </script>
</x-app-layout>