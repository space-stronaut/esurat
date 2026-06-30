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

                    {{-- Search Bar --}}
                    <div class="mb-4">
                        <form action="{{ route('admin.penduduk.index') }}" method="GET" class="flex items-center gap-3">
                            <div class="relative flex-1 max-w-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan NIK atau Nama..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-sm font-medium shadow-sm">Cari</button>
                            @if(!empty($search))
                                <a href="{{ route('admin.penduduk.index') }}" class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-medium">Reset</a>
                            @endif
                        </form>
                        @if(!empty($search))
                            <p class="text-sm text-gray-500 mt-2">Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong> ({{ $penduduks->total() }} data ditemukan)</p>
                        @endif
                    </div>

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