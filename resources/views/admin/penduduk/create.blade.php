<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="{{ route('admin.penduduk.index') }}" class="text-gray-500 hover:text-blue-600 transition mr-3">
                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            {{ __('Tambah Data Master Penduduk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                            <strong class="font-bold">Gagal Menyimpan Data!</strong>
                            <ul class="list-disc ml-5 mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.penduduk.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" name="nik" value="{{ old('nik') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required maxlength="16" placeholder="Wajib 16 Digit" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" pattern="[0-9]*">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NO KK</label>
                                <input type="text" name="no_kk" value="{{ old('no_kk') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required maxlength="16" placeholder="Wajib 16 Digit" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" pattern="[0-9]*">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required oninput="this.value = this.value.replace(/[0-9]/g, '')" placeholder="Hanya huruf, tanpa angka">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required oninput="this.value = this.value.replace(/[0-9]/g, '')" placeholder="Hanya huruf, tanpa angka">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Agama</label>
                                <select name="agama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    <option value="Penghayat Kepercayaan" {{ old('agama') == 'Penghayat Kepercayaan' ? 'selected' : '' }}>Penghayat Kepercayaan</option>
                                    <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="alamat" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">RT (Maks 3 Digit)</label>
                                <input type="text" name="rt" value="{{ old('rt') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required maxlength="3" placeholder="Contoh: 001" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" pattern="[0-9]*">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">RW (Maks 3 Digit)</label>
                                <input type="text" name="rw" value="{{ old('rw') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required maxlength="3" placeholder="Contoh: 002" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" pattern="[0-9]*">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                {{-- Strict Searchable Select for Pekerjaan --}}
                                <input type="hidden" name="pekerjaan" id="pekerjaan-value" value="{{ old('pekerjaan') }}" required>
                                <div class="relative mt-1" id="pekerjaan-container">
                                    <div id="pekerjaan-display" class="block w-full border border-gray-300 rounded-md shadow-sm bg-white px-3 py-2 cursor-pointer focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 flex items-center justify-between min-h-[42px]">
                                        <span id="pekerjaan-text" class="truncate {{ old('pekerjaan') ? 'text-gray-900' : 'text-gray-400' }}">{{ old('pekerjaan') ?: '-- Ketik untuk mencari pekerjaan --' }}</span>
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div id="pekerjaan-dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-hidden">
                                        <div class="sticky top-0 bg-white border-b border-gray-200 p-2">
                                            <input type="text" id="pekerjaan-search" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-1.5" placeholder="Ketik untuk mencari..." autocomplete="off">
                                        </div>
                                        <ul id="pekerjaan-options" class="overflow-y-auto max-h-48"></ul>
                                        <div id="pekerjaan-no-result" class="hidden p-3 text-sm text-gray-500 text-center">Tidak ada hasil ditemukan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                {{-- <input type="text" name="goldar" value="{{ old('goldar') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required placeholder="Contoh: A, B"> --}}
                                <select name="goldar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="A" {{ old('goldar') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('goldar') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('goldar') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('goldar') == 'O' ? 'selected' : '' }}>O</option>
                                    <option value="Tidak Tahu" {{ old('goldar') == 'Tidak Tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Hubungan Keluarga</label>
                                {{-- <input type="text" name="hub_keluarga" value="{{ old('hub_keluarga') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required placeholder="Contoh: Istri, Kepala Keluarga"> --}}
                                <select name="hub_keluarga" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Kepala Keluarga" {{ old('hub_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                    <option value="Menantu" {{ old('hub_keluarga') == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                                    <option value="Cucu" {{ old('hub_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                    <option value="Orang Tua" {{ old('hub_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                    <option value="Lainnya" {{ old('hub_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                {{-- <input type="text" name="status_perkawinan" value="{{ old('status_perkawinan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required placeholder="Contoh: Kawin, Belum Menikah"> --}}
                                <select name="status_perkawinan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Kawin Belum Tercatat" {{ old('status_perkawinan') == 'Kawin Belum Tercatat' ? 'selected' : '' }}>Kawin Belum Tercatat</option>
                                    <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                                {{-- <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required placeholder="Contoh: SMA, SMP"> --}}
                                <select name="pendidikan_terakhir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Tidak / Belum Sekolah" {{ old('pendidikan_terakhir') == 'Tidak / Belum Sekolah' ? 'selected' : '' }}>Tidak / Belum Sekolah</option>
                                    <option value="Belum Tamat SD / Sederajat" {{ old('pendidikan_terakhir') == 'Belum Tamat SD / Sederajat' ? 'selected' : '' }}>Belum Tamat SD / Sederajat</option>
                                    <option value="Tamat SD / Sederajat" {{ old('pendidikan_terakhir') == 'Tamat SD / Sederajat' ? 'selected' : '' }}>Tamat SD / Sederajat</option>
                                    <option value="SLTP / Sederajat" {{ old('pendidikan_terakhir') == 'SLTP / Sederajat' ? 'selected' : '' }}>SLTP / Sederajat</option>
                                    <option value="SLTA / Sederajat" {{ old('pendidikan_terakhir') == 'SLTA / Sederajat' ? 'selected' : '' }}>SLTA / Sederajat</option>
                                    <option value="Diploma I / II" {{ old('pendidikan_terakhir') == 'Diploma I / II' ? 'selected' : '' }}>Diploma I / II</option>
                                    <option value="Akademi / Diploma III / Sarjana Muda" {{ old('pendidikan_terakhir') == 'Akademi / Diploma III / Sarjana Muda' ? 'selected' : '' }}>Akademi / Diploma III / Sarjana Muda</option>
                                    <option value="Diploma IV / Strata I (D4/S1)" {{ old('pendidikan_terakhir') == 'Diploma IV / Strata I (D4/S1)' ? 'selected' : '' }}>Diploma IV / Strata I (D4/S1)</option>
                                    <option value="Strata II (S2)" {{ old('pendidikan_terakhir') == 'Strata II (S2)' ? 'selected' : '' }}>Strata II (S2)</option>
                                    <option value="Strata III (S3)" {{ old('pendidikan_terakhir') == 'Strata III (S3)' ? 'selected' : '' }}>Strata III (S3)</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                {{-- <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required placeholder="Contoh: WNI, WNA"> --}}
                                <select name="kewarganegaraan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="WNI" {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                    <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: 08123456789 atau +628123456789" oninput="this.value = this.value.replace(/[^0-9+]/g, '')" maxlength="15">
                                <p class="text-xs text-gray-500 mt-1">Format: diawali 0 atau +62</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: nama@email.com">
                            </div>
                        </div>

                        <div class="mt-6 border-t pt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold shadow-sm">Simpan Data Penduduk</button>
                            <a href="{{ route('admin.penduduk.index') }}" class="ml-3 text-gray-600 hover:text-gray-900">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // === Strict Searchable Select for Pekerjaan ===
    const pekerjaanOptions = [
        'Belum/Tidak Bekerja','Mengurus Rumah Tangga','Pelajar/Mahasiswa','Pensiunan',
        'Pegawai Negeri Sipil (PNS)','Tentara Nasional Indonesia (TNI)','Kepolisian RI (POLRI)',
        'Karyawan Swasta','Karyawan BUMN','Karyawan BUMD',
        'Buruh Harian Lepas','Buruh Tani/Perkebunan','Buruh Nelayan/Perikanan','Buruh Peternakan',
        'Pembantu Rumah Tangga','Tukang Cukur','Tukang Listrik','Tukang Batu','Tukang Kayu',
        'Tukang Sol Sepatu','Tukang Las/Pandai Besi','Tukang Jahit','Tukang Gigi',
        'Penata Rias','Penata Busana','Penata Rambut','Mekanik','Seniman','Wartawan','Olahragawan',
        'Dokter','Bidan','Perawat','Apoteker','Psikiater/Psikolog',
        'Penyiar Televisi','Penyiar Radio','Promotor','Filmografi/Sutradara','Fotografer',
        'Desainer','Arsitek','Akuntan','Konsultan','Notaris','Pengacara','Penilai',
        'Juru Sita','Aktuaris','Kurator','Jurnalis','Karyawan Honorer',
        'Wakil Presiden','Anggota DPR-RI','Anggota DPD','Anggota BPK',
        'Anggota Mahkamah Konstitusi','Anggota Kabinet/Menteri','Duta Besar',
        'Gubernur','Wakil Gubernur','Bupati','Wakil Bupati','Walikota','Wakil Walikota',
        'Anggota DPRD Provinsi','Anggota DPRD Kabupaten/Kota',
        'Dosen','Guru','Pilot','Pramugari/Pramugara','Navigator','Masinis','Nakhoda',
        'Masinis Kapal','Pilot Pesawat Tempur',
        'Kepala Desa','Perangkat Desa','Anggota BPD',
        'Pendeta','Pastor','Ustadz/Mubaligh','Biksu','Monik','Penginjil','Penatua','Syamas',
        'Wiraswasta','Lainnya'
    ];

    const container = document.getElementById('pekerjaan-container');
    const display = document.getElementById('pekerjaan-display');
    const textSpan = document.getElementById('pekerjaan-text');
    const dropdown = document.getElementById('pekerjaan-dropdown');
    const searchInput = document.getElementById('pekerjaan-search');
    const optionsList = document.getElementById('pekerjaan-options');
    const noResult = document.getElementById('pekerjaan-no-result');
    const hiddenInput = document.getElementById('pekerjaan-value');

    function renderOptions(filter = '') {
        optionsList.innerHTML = '';
        const lowerFilter = filter.toLowerCase();
        const filtered = pekerjaanOptions.filter(o => o.toLowerCase().includes(lowerFilter));

        if (filtered.length === 0) {
            noResult.classList.remove('hidden');
            return;
        }
        noResult.classList.add('hidden');

        filtered.forEach(option => {
            const li = document.createElement('li');
            li.className = 'px-3 py-2 text-sm cursor-pointer hover:bg-blue-50 hover:text-blue-700 transition-colors';
            li.textContent = option;
            if (option === hiddenInput.value) {
                li.classList.add('bg-blue-100', 'font-semibold', 'text-blue-700');
            }
            li.addEventListener('click', function() {
                hiddenInput.value = option;
                textSpan.textContent = option;
                textSpan.classList.remove('text-gray-400');
                textSpan.classList.add('text-gray-900');
                closeDropdown();
            });
            optionsList.appendChild(li);
        });
    }

    function openDropdown() {
        dropdown.classList.remove('hidden');
        searchInput.value = '';
        renderOptions();
        setTimeout(() => searchInput.focus(), 50);
    }

    function closeDropdown() {
        dropdown.classList.add('hidden');
        searchInput.value = '';
    }

    display.addEventListener('click', function(e) {
        e.stopPropagation();
        if (dropdown.classList.contains('hidden')) {
            openDropdown();
        } else {
            closeDropdown();
        }
    });

    searchInput.addEventListener('input', function() {
        renderOptions(this.value);
    });

    searchInput.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!container.contains(e.target)) {
            closeDropdown();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDropdown();
    });

    // Form validation: prevent submit if no pekerjaan selected
    const form = hiddenInput.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!hiddenInput.value) {
                e.preventDefault();
                display.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                textSpan.textContent = 'Wajib pilih pekerjaan dari daftar!';
                textSpan.classList.add('text-red-500');
                textSpan.classList.remove('text-gray-400', 'text-gray-900');
                openDropdown();
            }
        });
    }
});
</script>
</x-app-layout>