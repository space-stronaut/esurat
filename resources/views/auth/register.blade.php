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
            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required autofocus maxlength="16" placeholder="Masukkan 16 Digit NIK" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" pattern="[0-9]*" />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
            <div id="nik-error-custom" class="text-sm text-red-600 mt-2 hidden"></div>
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
            <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG (Maksimal 300KB).</p>
            <x-input-error :messages="$errors->get('foto_ktp')" class="mt-2" />
            <div id="foto_ktp-error-custom" class="text-sm text-red-600 mt-2 hidden"></div>
        </div>

        <div class="mt-4 p-4 border border-gray-200 rounded-md bg-gray-50">
            <x-input-label for="foto_selfie" :value="__('Upload Foto Selfie Memegang KTP')" class="font-bold text-indigo-700" />
            <input type="file" id="foto_selfie" name="foto_selfie" required accept=".jpg,.jpeg,.png" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer">
            <p class="text-xs text-gray-500 mt-1">Pastikan wajah dan tulisan pada KTP terlihat jelas (Maksimal 300KB).</p>
            <x-input-error :messages="$errors->get('foto_selfie')" class="mt-2" />
            <div id="foto_selfie-error-custom" class="text-sm text-red-600 mt-2 hidden"></div>
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
            <div id="password-match-indicator" class="text-sm mt-2 hidden"></div>
        </div>

        <div class="mt-4 flex items-start">
            <div class="flex items-center h-5">
                <input id="terms" name="terms" type="checkbox" required class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer" {{ old('terms') ? 'checked' : '' }}>
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="font-medium text-gray-700 cursor-pointer select-none">
                    Saya menyatakan bahwa seluruh data yang diinputkan adalah benar dan dapat dipertanggungjawabkan di kemudian hari.
                </label>
                <x-input-error :messages="$errors->get('terms')" class="mt-1" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition" href="{{ route('login') }}">
                {{ __('Sudah punya akun? Login') }}
            </a>

            <x-primary-button id="submit_btn" class="ml-4 bg-indigo-600 hover:bg-indigo-700 px-6 py-2.5 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const termsCheckbox = document.getElementById('terms');
            const submitBtn = document.getElementById('submit_btn');
            const nikInput = document.getElementById('nik');
            const nameInput = document.getElementById('name');
            const nikErrorCustom = document.getElementById('nik-error-custom');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const passwordMatchIndicator = document.getElementById('password-match-indicator');

            let isNikValid = false;

            // Make name input readonly by default on load if it's empty
            if (!nameInput.value) {
                nameInput.setAttribute('readonly', 'readonly');
                nameInput.classList.add('bg-gray-100', 'cursor-not-allowed');
            } else {
                // If it already has a value (e.g. old() value after validation error), keep it readonly
                nameInput.setAttribute('readonly', 'readonly');
                nameInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                isNikValid = true;
            }

            function toggleSubmitBtn() {
                const pass = passwordInput.value;
                const confirmPass = passwordConfirmInput.value;
                const passwordsMatch = pass.length > 0 && pass === confirmPass;

                if (isNikValid && termsCheckbox.checked && passwordsMatch) {
                    submitBtn.removeAttribute('disabled');
                } else {
                    submitBtn.setAttribute('disabled', 'disabled');
                }
            }

            function validatePasswordMatch() {
                const pass = passwordInput.value;
                const confirmPass = passwordConfirmInput.value;

                if (confirmPass.length === 0) {
                    passwordMatchIndicator.classList.add('hidden');
                    passwordMatchIndicator.textContent = '';
                } else if (pass === confirmPass) {
                    passwordMatchIndicator.textContent = 'Password cocok';
                    passwordMatchIndicator.className = 'text-sm mt-2 text-green-600 font-semibold block';
                } else {
                    passwordMatchIndicator.textContent = 'Password konfirmasi tidak cocok.';
                    passwordMatchIndicator.className = 'text-sm mt-2 text-red-600 font-semibold block';
                }

                toggleSubmitBtn();
            }

            async function checkNikRealtime() {
                const nik = nikInput.value.trim();
                
                if (nik.length === 16) {
                    try {
                        const response = await fetch(`/check-nik/${nik}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            nameInput.value = data.nama_lengkap;
                            nameInput.setAttribute('readonly', 'readonly');
                            nameInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                            
                            nikErrorCustom.classList.add('hidden');
                            nikErrorCustom.textContent = '';
                            isNikValid = true;
                        } else {
                            nameInput.value = '';
                            nameInput.setAttribute('readonly', 'readonly');
                            nameInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                            
                            nikErrorCustom.textContent = data.message || "Data NIK Anda belum terdaftar di sistem. Silakan hubungi Admin untuk mendaftarkan data penduduk Anda terlebih dahulu.";
                            nikErrorCustom.classList.remove('hidden');
                            isNikValid = false;
                        }
                    } catch (error) {
                        console.error('Error checking NIK:', error);
                    }
                } else {
                    nameInput.value = '';
                    isNikValid = false;
                    
                    if (nik.length > 0) {
                        nikErrorCustom.textContent = 'NIK harus terdiri dari 16 digit.';
                        nikErrorCustom.classList.remove('hidden');
                    } else {
                        nikErrorCustom.classList.add('hidden');
                        nikErrorCustom.textContent = '';
                    }
                }
                
                toggleSubmitBtn();
            }

            // Run initial check if NIK on load is already 16 characters
            if (nikInput.value.trim().length === 16) {
                checkNikRealtime();
            } else {
                toggleSubmitBtn();
            }

            // Listen to NIK inputs (typing)
            nikInput.addEventListener('input', function() {
                if (nikInput.value.trim().length === 16) {
                    checkNikRealtime();
                } else {
                    isNikValid = false;
                    nameInput.value = '';
                    toggleSubmitBtn();
                    nikErrorCustom.classList.add('hidden');
                }
            });

            // Listen to blur to enforce 16 digit warning
            nikInput.addEventListener('blur', function() {
                const nik = nikInput.value.trim();
                if (nik.length > 0 && nik.length !== 16) {
                    nikErrorCustom.textContent = 'NIK harus terdiri dari 16 digit.';
                    nikErrorCustom.classList.remove('hidden');
                    isNikValid = false;
                    toggleSubmitBtn();
                }
            });

            // Listen for password input changes
            passwordInput.addEventListener('input', validatePasswordMatch);
            passwordInput.addEventListener('blur', validatePasswordMatch);
            passwordConfirmInput.addEventListener('input', validatePasswordMatch);
            passwordConfirmInput.addEventListener('blur', validatePasswordMatch);

            // Listen for terms checkbox changes
            termsCheckbox.addEventListener('change', toggleSubmitBtn);
        });
    </script>
</x-guest-layout>