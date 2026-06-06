<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Template Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('admin.template.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Tambah Template Baru
                    </a>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-200 px-4 py-2">Nama Surat</th>
                                    <th class="border border-gray-200 px-4 py-2">Format Nomor</th>
                                    <th class="border border-gray-200 px-4 py-2">Syarat Dokumen</th>
                                    <th class="border border-gray-200 px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $t)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <strong>{{ $t->nama_surat }}</strong><br>
                                        <a href="{{ asset('storage/' . $t->file_template) }}" class="text-xs text-blue-600 underline" download>Unduh .docx</a>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-sm">{{ $t->format_nomor_baku ?? '-' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-sm">
                                        @if($t->syarat_dokumen)
                                            <ul class="list-disc ml-4">
                                                @foreach($t->syarat_dokumen as $syarat)
                                                    <li>{{ $syarat }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <form action="{{ route('admin.template.destroy', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Hapus template ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-4">Belum ada template surat.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">{{ $templates->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>