<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Akun Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
                @endif

                <a href="{{ route('superadmin.admins.create') }}" class="inline-block mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Admin Baru</a>

                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Terdaftar Pada</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td class="border px-4 py-2">{{ $admin->name }}</td>
                            <td class="border px-4 py-2">{{ $admin->email }}</td>
                            <td class="border px-4 py-2">{{ $admin->created_at->format('d M Y') }}</td>
                            <td class="border px-4 py-2 text-center">
                                <form action="{{ route('superadmin.admins.destroy', $admin->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Hapus Admin ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $admins->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>