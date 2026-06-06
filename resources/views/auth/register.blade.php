<x-guest-layout>
    
    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
            <strong class="font-bold">Registrasi Gagal!</strong>
            <ul class="list-disc ml-5 mt-2 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="nik" :value="__('NIK (Nomor Induk Kependudukan)')" />
            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required autofocus maxlength="16" placeholder="Masukkan 16 Digit NIK" />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="name" :value="__('Nama Lengkap (Sesuai KTP)')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 p-4 border border-gray-200 rounded-md bg-gray-50">
            <x-input-label for="foto_ktp" :value="__('Upload Foto KTP Asli')" class="font-bold text-indigo-700" />
            <input type="file" id="foto_ktp" name="foto_ktp" required accept=".jpg,.jpeg,.png" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG (Maksimal 2MB).</p>
            <x-input-error :messages="$errors->get('foto_ktp')" class="mt-2" />
        </div>

        <div class="mt-4 p-4 border border-gray-200 rounded-md bg-gray-50">
            <x-input-label for="foto_selfie" :value="__('Upload Foto Selfie Memegang KTP')" class="font-bold text-indigo-700" />
            <input type="file" id="foto_selfie" name="foto_selfie" required accept=".jpg,.jpeg,.png" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer">
            <p class="text-xs text-gray-500 mt-1">Pastikan wajah dan tulisan pada KTP terlihat jelas.</p>
            <x-input-error :messages="$errors->get('foto_selfie')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password (Minimal 8 Karakter)')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition" href="{{ route('login') }}">
                {{ __('Sudah punya akun? Login') }}
            </a>

            <x-primary-button class="ml-4 bg-indigo-600 hover:bg-indigo-700 px-6 py-2.5">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>