<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Profil Kantor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded border border-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('superadmin.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nama Kantor / Instansi</label>
                                <input type="text" name="nama_kantor" value="{{ old('nama_kantor', $profil->nama_kantor ?? '') }}" class="w-full mt-1 rounded border-gray-300 shadow-sm" required placeholder="Contoh: Kelurahan Suka Maju">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Kontak (Telepon/Email)</label>
                                <input type="text" name="kontak" value="{{ old('kontak', $profil->kontak ?? '') }}" class="w-full mt-1 rounded border-gray-300 shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" class="w-full mt-1 rounded border-gray-300 shadow-sm" required>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nama Kepala Kantor</label>
                                <input type="text" name="nama_kepala" value="{{ old('nama_kepala', $profil->nama_kepala ?? '') }}" class="w-full mt-1 rounded border-gray-300 shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">NIP Kepala Kantor (Opsional)</label>
                                <input type="text" name="nip_kepala" value="{{ old('nip_kepala', $profil->nip_kepala ?? '') }}" class="w-full mt-1 rounded border-gray-300 shadow-sm">
                            </div>
                            <div class="mb-4 p-4 border rounded bg-gray-50">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Instansi</label>
                                @if(isset($profil) && $profil->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo" class="h-20 object-contain">
                                    </div>
                                @endif
                                <input type="file" name="logo" accept=".jpg,.jpeg,.png" class="w-full text-sm">
                                <span class="text-xs text-gray-500">Maks 2MB. Format: JPG/PNG. Kosongkan jika tidak ingin mengubah.</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4 text-right">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-medium">Simpan Profil</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>