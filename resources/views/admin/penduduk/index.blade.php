<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Master Penduduk') }}
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

                    <a href="{{ route('admin.penduduk.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Tambah Penduduk
                    </a>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-200 px-4 py-2">NIK</th>
                                    <th class="border border-gray-200 px-4 py-2">Nama Lengkap</th>
                                    <th class="border border-gray-200 px-4 py-2">Jenis Kelamin</th>
                                    <th class="border border-gray-200 px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penduduks as $p)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $p->nik }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $p->nama_lengkap }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <a href="{{ route('admin.penduduk.edit', $p->id) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">Edit</a>
                                        <form action="{{ route('admin.penduduk.destroy', $p->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $penduduks->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>