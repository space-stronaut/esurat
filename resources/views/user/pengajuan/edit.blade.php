<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Perbaiki Pengajuan Surat') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <div class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded shadow-sm">
                    <p class="text-sm font-bold text-red-800">Catatan Admin:</p>
                    <p class="text-sm text-red-700 italic">"{{ $pengajuan->catatan_koreksi }}"</p>
                </div>

                <form action="{{ route('user.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="hidden">
                        @foreach($pengajuan->isian_dinamis as $param => $val)
                            @if(str_contains($param, 'statis.'))
                                <input type="text" name="parameter_dinamis[{{$param}}]" value="{{ $val }}">
                            @endif
                        @endforeach
                    </div>

                    <div class="mb-6 p-4 border rounded bg-gray-50">
                        <h3 class="font-bold mb-3">Edit Data Surat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($pengajuan->isian_dinamis as $param => $val)
                                @if(!str_contains($param, 'statis.'))
                                    <div>
                                        <label class="block text-xs font-bold uppercase">{{ str_replace('_', ' ', $param) }}</label>
                                        <input type="text" name="parameter_dinamis[{{$param}}]" value="{{ $val }}" class="w-full rounded border-gray-300" required>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @php $syaratKeys = array_keys($pengajuan->lampiran_syarat ?? []); @endphp
                    <input type="hidden" name="syarat_dokumen_keys" value="{{ json_encode($syaratKeys) }}">

                    <div x-data="{ lampiranTipe: {} }" class="mb-6">
                        <h3 class="font-bold mb-3">Unggah Ulang Berkas</h3>
                        @foreach($pengajuan->lampiran_syarat as $syarat => $data)
                            @php $index = $loop->index; @endphp
                            <div class="mb-4 p-4 border rounded bg-white" x-init="lampiranTipe[{{$index}}] = 'file'">
                                <label class="block font-bold mb-2">{{ $syarat }}</label>
                                
                                <select name="tipe_lampiran_{{$index}}" x-model="lampiranTipe[{{$index}}]" class="w-full rounded border-gray-300 mb-2">
                                    <option value="file">Upload File Baru</option>
                                    <option value="link">Ganti Link Google Drive</option>
                                </select>

                                <div x-show="lampiranTipe[{{$index}}] === 'file'">
                                    <input type="file" name="file_lampiran_{{$index}}" class="w-full">
                                </div>
                                <div x-show="lampiranTipe[{{$index}}] === 'link'">
                                    <input type="url" name="link_lampiran_{{$index}}" class="w-full rounded border-gray-300" placeholder="https://drive.google.com/...">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded font-bold">Kirim Perbaikan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>