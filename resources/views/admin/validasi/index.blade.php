<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validasi Pendaftaran Warga') }}
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
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-200 px-4 py-2">Nama & NIK</th>
                                    <th class="border border-gray-200 px-4 py-2">Email</th>
                                    <th class="border border-gray-200 px-4 py-2">Foto KTP</th>
                                    <th class="border border-gray-200 px-4 py-2">Foto Selfie</th>
                                    <th class="border border-gray-200 px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <strong>{{ $u->name }}</strong><br>
                                        <span class="text-sm text-gray-600">{{ $u->nik }}</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $u->email }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <a href="{{ asset('storage/' . $u->foto_ktp) }}" target="_blank" class="text-blue-600 underline">Lihat KTP</a>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <a href="{{ asset('storage/' . $u->foto_selfie) }}" target="_blank" class="text-blue-600 underline">Lihat Selfie</a>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-center space-x-2">
                                        <form action="{{ route('admin.validasi.approve', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Terima</button>
                                        </form>
                                        <form action="{{ route('admin.validasi.reject', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada pendaftar yang menunggu validasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>