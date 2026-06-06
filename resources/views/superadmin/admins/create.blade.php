<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Buat Akun Admin Baru</h2>
                
                <form action="{{ route('superadmin.admins.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full mt-1 rounded border-gray-300" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" class="w-full mt-1 rounded border-gray-300" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" name="password" class="w-full mt-1 rounded border-gray-300" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full mt-1 rounded border-gray-300" required>
                    </div>
                    
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Akun Admin</button>
                    <a href="{{ route('superadmin.admins.index') }}" class="ml-2 text-gray-600">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>