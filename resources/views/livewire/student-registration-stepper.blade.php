<div class="max-w-4xl mx-auto py-4 sm:py-8 px-4" x-data="stepperAlpine()">
    <!-- Stepper Navigation Header (5 Steps) -->
    <div class="mb-8">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-slate-200 w-full z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-indigo-600 transition-all duration-300 z-0"
                 style="width: {{ (($currentStep - 1) / 4) * 100 }}%;"></div>

            <!-- Step 1: Register -->
            <button type="button" wire:click="goToStep(1)" :disabled="{{ $currentStep < 1 ? 'true' : 'false' }}"
                    class="relative z-10 flex flex-col items-center group focus:outline-none">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm border-2 transition-all
                    {{ $currentStep > 1 ? 'bg-emerald-600 border-emerald-600 text-white shadow-xs' : ($currentStep == 1 ? 'bg-indigo-600 border-indigo-600 text-white shadow-md ring-4 ring-indigo-100' : 'bg-white border-slate-300 text-slate-400') }}">
                    @if($currentStep > 1) &check; @else 1 @endif
                </div>
                <span class="text-[11px] sm:text-xs font-semibold mt-2 {{ $currentStep >= 1 ? 'text-indigo-900 font-bold' : 'text-slate-400' }} hidden sm:block">
                    1. Register
                </span>
            </button>

            <!-- Step 2: Bayar Seleksi -->
            <button type="button" wire:click="goToStep(2)" :disabled="{{ $currentStep < 2 ? 'true' : 'false' }}"
                    class="relative z-10 flex flex-col items-center group focus:outline-none">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm border-2 transition-all
                    {{ $currentStep > 2 ? 'bg-emerald-600 border-emerald-600 text-white shadow-xs' : ($currentStep == 2 ? 'bg-indigo-600 border-indigo-600 text-white shadow-md ring-4 ring-indigo-100' : 'bg-white border-slate-300 text-slate-400') }}">
                    @if($currentStep > 2) &check; @else 2 @endif
                </div>
                <span class="text-[11px] sm:text-xs font-semibold mt-2 {{ $currentStep >= 2 ? 'text-indigo-900 font-bold' : 'text-slate-400' }} hidden sm:block">
                    2. Pembayaran
                </span>
            </button>

            <!-- Step 3: Biodata Siswa -->
            <button type="button" wire:click="goToStep(3)" :disabled="{{ $currentStep < 3 ? 'true' : 'false' }}"
                    class="relative z-10 flex flex-col items-center group focus:outline-none">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm border-2 transition-all
                    {{ $currentStep > 3 ? 'bg-emerald-600 border-emerald-600 text-white shadow-xs' : ($currentStep == 3 ? 'bg-indigo-600 border-indigo-600 text-white shadow-md ring-4 ring-indigo-100' : 'bg-white border-slate-300 text-slate-400') }}">
                    @if($currentStep > 3) &check; @else 3 @endif
                </div>
                <span class="text-[11px] sm:text-xs font-semibold mt-2 {{ $currentStep >= 3 ? 'text-indigo-900 font-bold' : 'text-slate-400' }} hidden sm:block">
                    3. Data Siswa
                </span>
            </button>

            <!-- Step 4: Biodata Ortu -->
            <button type="button" wire:click="goToStep(4)" :disabled="{{ $currentStep < 4 ? 'true' : 'false' }}"
                    class="relative z-10 flex flex-col items-center group focus:outline-none">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm border-2 transition-all
                    {{ $currentStep > 4 ? 'bg-emerald-600 border-emerald-600 text-white shadow-xs' : ($currentStep == 4 ? 'bg-indigo-600 border-indigo-600 text-white shadow-md ring-4 ring-indigo-100' : 'bg-white border-slate-300 text-slate-400') }}">
                    @if($currentStep > 4) &check; @else 4 @endif
                </div>
                <span class="text-[11px] sm:text-xs font-semibold mt-2 {{ $currentStep >= 4 ? 'text-indigo-900 font-bold' : 'text-slate-400' }} hidden sm:block">
                    4. Data Ortu
                </span>
            </button>

            <!-- Step 5: Akademik & Prestasi -->
            <button type="button" wire:click="goToStep(5)" :disabled="{{ $currentStep < 5 ? 'true' : 'false' }}"
                    class="relative z-10 flex flex-col items-center group focus:outline-none">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm border-2 transition-all
                    {{ $isComplete ? 'bg-emerald-600 border-emerald-600 text-white shadow-xs' : ($currentStep == 5 ? 'bg-indigo-600 border-indigo-600 text-white shadow-md ring-4 ring-indigo-100' : 'bg-white border-slate-300 text-slate-400') }}">
                    @if($isComplete) &check; @else 5 @endif
                </div>
                <span class="text-[11px] sm:text-xs font-semibold mt-2 {{ $currentStep >= 5 ? 'text-indigo-900 font-bold' : 'text-slate-400' }} hidden sm:block">
                    5. Nilai & Prestasi
                </span>
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center space-x-3 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- STEP 1: FORM PENDAFTARAN AWAL -->
    @if($currentStep === 1)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Tahap 1 dari 5</span>
                <h2 class="text-xl font-bold text-slate-900 mt-1">Registrasi Akun Calon Siswa</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Gunakan NISN resmi (10 digit). Password akun login Anda otomatis diatur sama dengan nomor NISN.
                </p>
            </div>

            <form wire:submit.prevent="submitStep1" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            NISN (10 Digit) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" wire:model.defer="nisn" maxlength="10" placeholder="Contoh: 0081234567"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nisn') border-rose-500 @enderror">
                        @error('nisn') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[11px] text-slate-400 mt-1">Akan digunakan sebagai password login Anda.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nama Lengkap Calon Siswa <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" wire:model.defer="nama_lengkap" placeholder="Sesuai Ijazah / Akta Kelahiran"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama_lengkap') border-rose-500 @enderror">
                        @error('nama_lengkap') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" wire:model.defer="email" placeholder="nama@gmail.com"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-rose-500 @enderror">
                        @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[11px] text-slate-400 mt-1">Digunakan sebagai username saat masuk sistem.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            No. WhatsApp / HP Siswa <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" wire:model.defer="hp_siswa" placeholder="Contoh: 081234567890"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('hp_siswa') border-rose-500 @enderror">
                        @error('hp_siswa') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Pilihan Program Pendidikan <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                        @foreach($programs as $prog)
                            <label class="relative flex p-4 rounded-xl border cursor-pointer hover:bg-indigo-50/50 transition
                                          {{ $program_id == $prog->id ? 'border-indigo-600 bg-indigo-50 ring-2 ring-indigo-500' : 'border-slate-200 bg-white' }}">
                                <input type="radio" wire:model="program_id" value="{{ $prog->id }}" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-slate-900">{{ $prog->nama_program }}</span>
                                    <span class="block text-xs text-slate-500 mt-0.5">{{ $prog->deskripsi }}</span>
                                    <span class="inline-block mt-2 text-[11px] font-semibold text-indigo-600 bg-white px-2 py-0.5 rounded border border-indigo-200">
                                        Kuota: {{ $prog->kuota }} Siswa
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('program_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2" x-data="{ ref: @entangle('referensi_promotor') }">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Mengetahui Info Sekolah Dari <span class="text-rose-500">*</span>
                        </label>
                        <select wire:model="referensi_promotor"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('referensi_promotor') border-rose-500 @enderror">
                            <option value="">-- Pilih Referensi --</option>
                            <option value="Media Sosial (Instagram/TikTok)">Media Sosial (Instagram/TikTok)</option>
                            <option value="Alumni Sekolah">Alumni Sekolah</option>
                            <option value="Guru / Pihak Sekolah Asal">Guru / Pihak Sekolah Asal</option>
                            <option value="Brosur / Spanduk">Brosur / Spanduk</option>
                            <option value="Teman / Saudara">Teman / Saudara</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('referensi_promotor') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-show="ref !== ''" x-transition>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nama Rujukan / Akun / Keterangan Tambahan
                        </label>
                        <input type="text" wire:model.defer="detail_promotor" placeholder="Contoh: Kak Dika (Alumni 2024)"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">
                        <span wire:loading.remove wire:target="submitStep1">Lanjut ke Pembayaran Seleksi &rarr;</span>
                        <span wire:loading wire:target="submitStep1">Menyimpan data akun...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- STEP 2: FORM PEMBAYARAN SELEKSI -->
    @if($currentStep === 2)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Tahap 2 dari 5</span>
                    <h2 class="text-xl font-bold text-slate-900 mt-1">Pembayaran Biaya Formulir & Seleksi</h2>
                    <p class="text-xs text-slate-500 mt-1">Silakan transfer biaya seleksi pendaftaran sesuai nominal berikut.</p>
                </div>
                <div class="text-right bg-emerald-50 border border-emerald-200 px-4 py-2.5 rounded-xl">
                    <span class="text-xs font-semibold text-emerald-700 block">Total Tagihan Seleksi</span>
                    <span class="text-xl font-black text-emerald-800">Rp {{ number_format($nominal_seleksi, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2">
                <div class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span>Rekening Resmi Panitia PPDB 2026:</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="bg-white p-3 rounded-lg border border-slate-200">
                        <span class="text-slate-400 block text-[11px]">Bank Syariah Indonesia (BSI)</span>
                        <span class="font-mono font-bold text-sm text-slate-900">7700-1234-5678</span>
                        <span class="text-slate-500 block text-[11px]">a.n PPDB SPMB ONLINE</span>
                    </div>
                    <div class="bg-white p-3 rounded-lg border border-slate-200">
                        <span class="text-slate-400 block text-[11px]">Bank Mandiri</span>
                        <span class="font-mono font-bold text-sm text-slate-900">131-00-9876543-2</span>
                        <span class="text-slate-500 block text-[11px]">a.n PANITIA PENERIMAAN SISWA</span>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="submitStep2" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Unggah Bukti Transfer / Resi ATM / Mobile Banking <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-indigo-400 transition bg-slate-50/50">
                        <div class="space-y-2 text-center">
                            @if ($bukti_transfer)
                                <div class="text-emerald-600 font-semibold text-xs flex items-center justify-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Berkas dipilih: {{ $bukti_transfer->getClientOriginalName() }}</span>
                                </div>
                            @else
                                <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif

                            <div class="flex text-xs text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                    <span>Pilih Berkas Struk</span>
                                    <input id="file-upload" type="file" wire:model="bukti_transfer" class="sr-only" accept="image/jpeg,image/png,application/pdf">
                                </label>
                                <p class="pl-1">atau seret ke area ini</p>
                            </div>
                            <p class="text-[11px] text-slate-400">JPG, PNG, atau PDF hingga 2 MB</p>
                        </div>
                    </div>
                    @error('bukti_transfer') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Catatan Pengirim / Nama Pemilik Rekening (Opsional)
                    </label>
                    <input type="text" wire:model.defer="catatan_bayar" placeholder="Contoh: Transfer via m-BCA a.n Ibu Fatimah"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <button type="button" wire:click="goToStep(1)" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                        &larr; Kembali ke Step 1
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">
                        <span wire:loading.remove wire:target="submitStep2">Konfirmasi & Isi Biodata Siswa &rarr;</span>
                        <span wire:loading wire:target="submitStep2">Mengunggah berkas...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- STEP 3: FORM BIODATA SISWA & SELECT BERANTAI WILAYAH (ALPINE.JS) -->
    @if($currentStep === 3)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Tahap 3 dari 5</span>
                <h2 class="text-xl font-bold text-slate-900 mt-1">Biodata Calon Peserta Didik</h2>
                <p class="text-xs text-slate-500 mt-1">Lengkapi data kependudukan, domisili, dan data fisik calon siswa.</p>
            </div>

            <form wire:submit.prevent="submitStep3" class="space-y-6">
                <!-- A. Data Kependudukan & Kelahiran -->
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        <span>A. Data Kependudukan & Kelahiran</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                NIK Siswa (16 Digit) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="nik_siswa" maxlength="16" placeholder="Sesuai KTP/KK"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white @error('nik_siswa') border-rose-500 @enderror">
                            @error('nik_siswa') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                No. Kartu Keluarga (KK) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="no_kk" maxlength="16" placeholder="16 Digit No KK"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white @error('no_kk') border-rose-500 @enderror">
                            @error('no_kk') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tempat Lahir <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model.defer="tempat_lahir" placeholder="Kota Kelahiran" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('tempat_lahir') border-rose-500 @enderror">
                            @error('tempat_lahir') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                            <input type="date" wire:model.defer="tanggal_lahir" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('tanggal_lahir') border-rose-500 @enderror">
                            @error('tanggal_lahir') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kewarganegaraan <span class="text-rose-500">*</span></label>
                            <select wire:model.defer="kewarganegaraan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('kewarganegaraan') border-rose-500 @enderror">
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                            </select>
                            @error('kewarganegaraan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Agama</label>
                            <input type="text" wire:model.defer="agama" readonly class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm bg-slate-100 text-slate-500 cursor-not-allowed">
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <div class="flex items-center space-x-6 mt-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" wire:model.defer="jenis_kelamin" value="L" class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-slate-700">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" wire:model.defer="jenis_kelamin" value="P" class="w-4 h-4 text-pink-500 border-slate-300 focus:ring-pink-500">
                                    <span class="ml-2 text-sm text-slate-700">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Asal Sekolah (SMP/MTs) <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model.defer="asal_sekolah" placeholder="Nama sekolah asal" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('asal_sekolah') border-rose-500 @enderror">
                            @error('asal_sekolah') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- B. Data Domisili & Akses -->
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        <span>B. Data Domisili & Akses</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Lengkap <span class="text-rose-500">*</span></label>
                            <textarea wire:model.defer="alamat_detail" rows="2" placeholder="Nama Jalan, No. Rumah, RT/RW, Dusun" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('alamat_detail') border-rose-500 @enderror"></textarea>
                            @error('alamat_detail') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-2" x-data="wilayahSelect({{ $wilayahTree }})" x-init="initData()">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4 bg-white border border-slate-200 rounded-xl shadow-xs">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Provinsi</label>
                                    <select x-model="selectedProv" x-on:change="onProvChange()" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 bg-white">
                                        <option value="">-- Pilih Provinsi --</option>
                                        <template x-for="prov in provTree" :key="prov.id">
                                            <option :value="prov.id" x-text="prov.nama" :selected="prov.id == selectedProv"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Kab / Kota</label>
                                    <select x-model="selectedKab" x-on:change="onCityChange()" :disabled="availableCities.length === 0" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 bg-white disabled:bg-slate-100">
                                        <option value="">-- Pilih Kab/Kota --</option>
                                        <template x-for="kab in availableCities" :key="kab.id">
                                            <option :value="kab.id" x-text="kab.nama" :selected="kab.id == selectedKab"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Kecamatan</label>
                                    <select x-model="selectedKec" x-on:change="onDistrictChange()" :disabled="availableDistricts.length === 0" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 bg-white disabled:bg-slate-100">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        <template x-for="kec in availableDistricts" :key="kec.id">
                                            <option :value="kec.id" x-text="kec.nama" :selected="kec.id == selectedKec"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Desa / Kelurahan</label>
                                    <select x-model="selectedDesa" x-on:change="onVillageChange()" :disabled="availableVillages.length === 0" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 bg-white disabled:bg-slate-100">
                                        <option value="">-- Pilih Desa/Kelurahan --</option>
                                        <template x-for="desa in availableVillages" :key="desa.id">
                                            <option :value="desa.id" x-text="desa.nama" :selected="desa.id == selectedDesa"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kode Pos <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model.defer="kode_pos" maxlength="5" placeholder="Misal: 40123" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('kode_pos') border-rose-500 @enderror">
                            @error('kode_pos') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Tempat Tinggal <span class="text-rose-500">*</span></label>
                            <select wire:model.defer="status_tempat_tinggal" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('status_tempat_tinggal') border-rose-500 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Bersama Orangtua">Bersama Orangtua</option>
                                <option value="Wali">Wali</option>
                                <option value="Asrama">Asrama</option>
                                <option value="Kos">Kos</option>
                            </select>
                            @error('status_tempat_tinggal') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Transportasi ke Sekolah <span class="text-rose-500">*</span></label>
                            <select wire:model.defer="transportasi" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('transportasi') border-rose-500 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Jalan Kaki">Jalan Kaki</option>
                                <option value="Angkot">Angkot</option>
                                <option value="Diantar">Diantar</option>
                                <option value="Sepeda">Sepeda</option>
                                <option value="Motor">Motor</option>
                            </select>
                            @error('transportasi') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jarak Tempat Tinggal ke Sekolah <span class="text-rose-500">*</span></label>
                            <select wire:model.defer="jarak_ke_sekolah" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('jarak_ke_sekolah') border-rose-500 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="< 1 Km">< 1 Km</option>
                                <option value="1-3 Km">1-3 Km</option>
                                <option value="3-5 Km">3-5 Km</option>
                                <option value="5-10 Km">5-10 Km</option>
                                <option value="> 10 Km">> 10 Km</option>
                            </select>
                            @error('jarak_ke_sekolah') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Waktu Tempuh (Menit) <span class="text-rose-500">*</span></label>
                            <input type="number" wire:model.defer="waktu_tempuh" placeholder="Misal: 15" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('waktu_tempuh') border-rose-500 @enderror">
                            @error('waktu_tempuh') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                
                <!-- C. Data Fisik & Personal -->
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        <span>C. Data Fisik & Personal</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tinggi Badan (cm) <span class="text-rose-500">*</span></label>
                            <input type="number" wire:model.defer="tinggi_badan" placeholder="165" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('tinggi_badan') border-rose-500 @enderror">
                            @error('tinggi_badan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Berat Badan (kg) <span class="text-rose-500">*</span></label>
                            <input type="number" wire:model.defer="berat_badan" placeholder="55" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('berat_badan') border-rose-500 @enderror">
                            @error('berat_badan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Golongan Darah <span class="text-rose-500">*</span></label>
                            <select wire:model.defer="golongan_darah" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('golongan_darah') border-rose-500 @enderror">
                                <option value="Belum Tahu">Belum Tahu</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                            @error('golongan_darah') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <div x-data="{ hobiMode: @entangle('hobi') }">
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Hobi <span class="text-rose-500">*</span></label>
                                <select x-model="hobiMode" wire:model="hobi" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 mb-2 @error('hobi') border-rose-500 @enderror">
                                    <option value="">-- Pilih Hobi --</option>
                                    <option value="Membaca">Membaca</option>
                                    <option value="Olahraga">Olahraga</option>
                                    <option value="Kesenian">Kesenian</option>
                                    <option value="Menulis">Menulis</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div x-show="hobiMode === 'Lainnya'">
                                    <input type="text" wire:model.defer="hobi_lainnya" placeholder="Sebutkan hobi lainnya" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                                @error('hobi') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div class="sm:col-span-3">
                            <div x-data="{ citaCitaMode: @entangle('cita_cita') }">
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cita-Cita <span class="text-rose-500">*</span></label>
                                <select x-model="citaCitaMode" wire:model="cita_cita" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 mb-2 @error('cita_cita') border-rose-500 @enderror">
                                    <option value="">-- Pilih Cita-Cita --</option>
                                    <option value="PNS / TNI / POLRI">PNS / TNI / POLRI</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="Pengusaha">Pengusaha</option>
                                    <option value="Programmer / IT">Programmer / IT</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div x-show="citaCitaMode === 'Lainnya'">
                                    <input type="text" wire:model.defer="cita_cita_lainnya" placeholder="Sebutkan cita-cita lainnya" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                                @error('cita_cita') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                @if(session()->has('success_sementara'))
                    <div class="p-3 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 text-sm">
                        {{ session('success_sementara') }}
                    </div>
                @endif

                <div class="flex justify-between items-center pt-4 border-t border-slate-100 flex-wrap gap-3">
                    <button type="button" wire:click="goToStep(2)" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                        &larr; Kembali ke Pembayaran
                    </button>
                    
                    <div class="flex items-center space-x-3">
                        <button type="button" wire:click="simpanSementaraStep3" wire:loading.attr="disabled"
                                class="inline-flex items-center px-4 py-2.5 rounded-xl font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 transition">
                            <span wire:loading.remove wire:target="simpanSementaraStep3">Simpan Sementara</span>
                            <span wire:loading wire:target="simpanSementaraStep3">Menyimpan...</span>
                        </button>
                        
                        <button type="submit" wire:loading.attr="disabled"
                                class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">
                            <span wire:loading.remove wire:target="submitStep3">Lanjut ke Data Orang Tua &rarr;</span>
                            <span wire:loading wire:target="submitStep3">Menyimpan data siswa...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- STEP 4: FORM BIODATA ORANG TUA & INPUT MASKING RUPIAH (ALPINE.JS) -->
    @if($currentStep === 4)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Tahap 4 dari 5</span>
                <h2 class="text-xl font-bold text-slate-900 mt-1">Data Orang Tua / Wali</h2>
                <p class="text-xs text-slate-500 mt-1">Informasi pekerjaan dan penghasilan orang tua calon peserta didik.</p>
            </div>

            <form wire:submit.prevent="submitStep4" class="space-y-6">
                <!-- Data Ayah -->
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        <span>Data Ayah Kandung / Wali</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Nama Lengkap Ayah <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="nama_ayah" placeholder="Nama lengkap sesuai KTP/KK"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white @error('nama_ayah') border-rose-500 @enderror">
                            @error('nama_ayah') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Pekerjaan Ayah <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model.defer="pekerjaan_ayah"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white @error('pekerjaan_ayah') border-rose-500 @enderror">
                                <option value="">-- Pilih Pekerjaan --</option>
                                <option value="PNS / TNI / POLRI">PNS / TNI / POLRI</option>
                                <option value="Karyawan Swasta">Karyawan Swasta</option>
                                <option value="Wiraswasta / Pengusaha">Wiraswasta / Pengusaha</option>
                                <option value="Petani / Nelayan / Buruh">Petani / Nelayan / Buruh</option>
                                <option value="Pedagang">Pedagang</option>
                                <option value="Pensiunan">Pensiunan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('pekerjaan_ayah') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Penghasilan Bulanan Ayah <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative" x-data="{
                                rawVal: @entangle('penghasilan_ayah'),
                                displayVal: '',
                                init() { this.formatDisplay(); },
                                formatDisplay() {
                                    let num = parseInt(this.rawVal || 0);
                                    this.displayVal = num > 0 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(num) : '';
                                },
                                onInput(e) {
                                    let digits = e.target.value.replace(/\D/g, '');
                                    let num = digits ? parseInt(digits) : 0;
                                    this.rawVal = num;
                                    this.displayVal = num > 0 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(num) : '';
                                }
                            }">
                                <input type="text" x-model="displayVal" x-on:input="onInput($event)" placeholder="Rp 0"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white font-mono font-medium">
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">Otomatis terformat dengan pemisah ribuan.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. WhatsApp / HP Ayah</label>
                            <input type="text" wire:model.defer="hp_ayah" placeholder="Contoh: 081298765432"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white">
                        </div>
                    </div>
                </div>

                <!-- Data Ibu -->
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>Data Ibu Kandung</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Nama Lengkap Ibu <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="nama_ibu" placeholder="Nama lengkap sesuai KTP/KK"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white @error('nama_ibu') border-rose-500 @enderror">
                            @error('nama_ibu') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Pekerjaan Ibu <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model.defer="pekerjaan_ibu"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white @error('pekerjaan_ibu') border-rose-500 @enderror">
                                <option value="">-- Pilih Pekerjaan --</option>
                                <option value="Ibu Rumah Tangga (IRT)">Ibu Rumah Tangga (IRT)</option>
                                <option value="PNS / TNI / POLRI">PNS / TNI / POLRI</option>
                                <option value="Karyawan Swasta">Karyawan Swasta</option>
                                <option value="Wiraswasta / Pengusaha">Wiraswasta / Pengusaha</option>
                                <option value="Pedagang">Pedagang</option>
                                <option value="Petani / Buruh">Petani / Buruh</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('pekerjaan_ibu') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Penghasilan Bulanan Ibu <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative" x-data="{
                                rawVal: @entangle('penghasilan_ibu'),
                                displayVal: '',
                                init() { this.formatDisplay(); },
                                formatDisplay() {
                                    let num = parseInt(this.rawVal || 0);
                                    this.displayVal = num > 0 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(num) : '';
                                },
                                onInput(e) {
                                    let digits = e.target.value.replace(/\D/g, '');
                                    let num = digits ? parseInt(digits) : 0;
                                    this.rawVal = num;
                                    this.displayVal = num > 0 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(num) : '';
                                }
                            }">
                                <input type="text" x-model="displayVal" x-on:input="onInput($event)" placeholder="Rp 0"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white font-mono font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. WhatsApp / HP Ibu</label>
                            <input type="text" wire:model.defer="hp_ibu" placeholder="Contoh: 081311223344"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 bg-white">
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <button type="button" wire:click="goToStep(3)" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                        &larr; Kembali ke Biodata Siswa
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">
                        <span wire:loading.remove wire:target="submitStep4">Lanjut ke Nilai Rapor & Prestasi &rarr;</span>
                        <span wire:loading wire:target="submitStep4">Menyimpan data orang tua...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- STEP 5: AKADEMIK (MATRIKS NILAI RAPORT) & PRESTASI -->
    @if($currentStep === 5)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-8">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Tahap 5 dari 5</span>
                <h2 class="text-xl font-bold text-slate-900 mt-1">Nilai Rapor & Portofolio Prestasi</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Isikan nilai rapor pengetahuan Semester 1 s.d. 5 dari SMP/MTs asal (skala 0 - 100). Nilai rata-rata akan terhitung otomatis.
                </p>
            </div>

            <form wire:submit.prevent="submitStep5" class="space-y-8">
                <!-- 1. MATRIKS NILAI RAPORT (5 MAPEL X 5 SEMESTER) -->
                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            <span>Matriks Nilai Raport Semester 1 - 5</span>
                        </h3>
                        <span class="text-[11px] text-slate-500">Skala Nilai 0 s.d. 100 (Gunakan tanda titik untuk desimal)</span>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="py-3 px-4 min-w-[190px]">Mata Pelajaran</th>
                                    @foreach($semesters as $sem)
                                        <th class="py-3 px-2.5 text-center min-w-[70px]">Sem {{ $sem }}</th>
                                    @endforeach
                                    <th class="py-3 px-4 text-center bg-indigo-50/60 text-indigo-700 min-w-[85px]">Rata-Rata</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach($subjects as $subjKey => $subjLabel)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3 px-4 font-semibold text-slate-800">
                                            {{ $subjLabel }}
                                        </td>
                                        @foreach($semesters as $sem)
                                            <td class="py-2.5 px-2 text-center">
                                                <input type="number" min="0" max="100" step="0.1"
                                                       wire:model.live.debounce.300ms="nilai_raport.{{ $subjKey }}.{{ $sem }}"
                                                       placeholder="0"
                                                       class="w-16 py-1.5 px-2 rounded-lg border border-slate-200 text-center font-mono font-medium focus:ring-2 focus:ring-indigo-500 @error("nilai_raport.{$subjKey}.{$sem}") border-rose-500 @enderror">
                                            </td>
                                        @endforeach
                                        <td class="py-2.5 px-4 text-center font-bold font-mono text-indigo-600 bg-indigo-50/30">
                                            {{ $this->getSubjectAverage($subjKey) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-50/80 border-t-2 border-slate-200 font-bold">
                                <tr>
                                    <td colspan="6" class="py-3.5 px-4 text-right text-slate-700 uppercase tracking-wider text-xs">
                                        Rata-Rata Kumulatif Seluruh Mapel:
                                    </td>
                                    <td class="py-3.5 px-4 text-center text-sm font-black text-indigo-700 bg-indigo-100/50">
                                        {{ $this->getOverallAverage() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @error('nilai_raport.*.*')
                        <p class="text-xs text-rose-600 font-medium">Harap lengkapi seluruh nilai rapor untuk 5 mata pelajaran (Semester 1 s.d. 5).</p>
                    @enderror
                </div>

                <!-- 2. DYNAMIC FORM PORTOFOLIO PRESTASI -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                <span>Portofolio Prestasi & Kejuaraan (Opsional)</span>
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Sertakan piagam/sertifikat kejuaraan akademik, sains, seni, olahraga, atau tahfidz selama jenjang SMP/MTs.
                            </p>
                        </div>
                        <button type="button" wire:click="addPrestasi"
                                class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 transition shadow-2xs">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>+ Tambah Prestasi</span>
                        </button>
                    </div>

                    @if(empty($prestasi))
                        <div class="text-center py-7 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50 text-slate-400 text-xs">
                            Belum ada prestasi yang ditambahkan. Klik tombol <span class="font-bold text-indigo-600">+ Tambah Prestasi</span> jika Anda memiliki piagam/penghargaan.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($prestasi as $index => $item)
                                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60 grid grid-cols-1 sm:grid-cols-12 gap-3 items-end"
                                     wire:key="prestasi-row-{{ $index }}">
                                    <!-- Kategori -->
                                    <div class="sm:col-span-3">
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                            Bidang / Kategori <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" wire:model.defer="prestasi.{{ $index }}.kategori"
                                               placeholder="e.g. Sains / Olahraga / Seni"
                                               class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-indigo-500 @error("prestasi.{$index}.kategori") border-rose-500 @enderror">
                                    </div>

                                    <!-- Perolehan -->
                                    <div class="sm:col-span-3">
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                            Perolehan Juara <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" wire:model.defer="prestasi.{{ $index }}.perolehan"
                                               placeholder="e.g. Juara 1 / Medali Emas"
                                               class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-indigo-500 @error("prestasi.{$index}.perolehan") border-rose-500 @enderror">
                                    </div>

                                    <!-- Tingkat Dropdown -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                            Tingkat <span class="text-rose-500">*</span>
                                        </label>
                                        <select wire:model.defer="prestasi.{{ $index }}.tingkat"
                                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-indigo-500">
                                            <option value="Desa">Desa / Kel.</option>
                                            <option value="Kec">Kecamatan</option>
                                            <option value="Kab">Kabupaten / Kota</option>
                                            <option value="Prov">Provinsi</option>
                                            <option value="Nasional">Nasional</option>
                                            <option value="Internasional">Internasional</option>
                                        </select>
                                    </div>

                                    <!-- Penyelenggara -->
                                    <div class="sm:col-span-3">
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                            Instansi Penyelenggara <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" wire:model.defer="prestasi.{{ $index }}.penyelenggara"
                                               placeholder="e.g. Kemendikbud / KONI"
                                               class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-indigo-500 @error("prestasi.{$index}.penyelenggara") border-rose-500 @enderror">
                                    </div>

                                    <!-- Tombol Hapus Baris -->
                                    <div class="sm:col-span-1 flex justify-end">
                                        <button type="button" wire:click="removePrestasi({{ $index }})"
                                                class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus baris">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Submit Button Step 5 -->
                <div class="flex justify-between items-center pt-5 border-t border-slate-100">
                    <button type="button" wire:click="goToStep(4)" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                        &larr; Kembali ke Data Orang Tua
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center px-7 py-3 rounded-xl font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-100 transition">
                        <span wire:loading.remove wire:target="submitStep5">&check; Selesaikan Pendaftaran PPDB 2026</span>
                        <span wire:loading wire:target="submitStep5">Memproses data pendaftaran...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- COMPLETION CELEBRATION MODAL / CARD -->
    @if($isComplete)
        <div class="mt-8 bg-white rounded-2xl border border-emerald-200 shadow-md p-6 sm:p-8 text-center space-y-4">
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl font-black shadow-xs">
                &check;
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Pendaftaran Selesai & Berhasil
                </span>
                <h2 class="text-2xl font-black text-slate-900 mt-2">Selamat, Berkas Pendaftaran Anda Lengkap!</h2>
                <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto mt-1">
                    Seluruh data akun, bukti pembayaran seleksi, biodata siswa & orang tua, serta nilai rapor semester 1–5 telah tercatat di sistem PPDB 2026.
                </p>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 max-w-md mx-auto text-left text-xs space-y-1.5 font-mono">
                <div class="flex justify-between"><span class="text-slate-500">NISN Siswa:</span><span class="font-bold text-slate-800">{{ $nisn }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Nama Lengkap:</span><span class="font-bold text-slate-800">{{ $nama_lengkap }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Rata-Rata Rapor:</span><span class="font-bold text-indigo-600">{{ $this->getOverallAverage() }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Status Saat Ini:</span><span class="font-bold text-amber-600">Menunggu Sesi Wawancara</span></div>
            </div>

            <div class="pt-2 flex flex-wrap justify-center gap-3">
                <a href="{{ route('siswa.dashboard') }}"
                   class="inline-flex items-center px-6 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    Buka Panel Dashboard Siswa &rarr;
                </a>
            </div>
        </div>
    @endif

    <!-- Script Alpine.js Stepper & Cascading Wilayah -->
    <script>
        function stepperAlpine() {
            return {
                wilayahTree: @js($wilayahTree),
                selectedProv: @entangle('provinsi_id'),
                selectedKota: @entangle('kota_kab_id'),
                selectedKec: @entangle('kecamatan_id'),
                selectedDesa: @entangle('desa_id'),
                availableCities: [],
                availableDistricts: [],
                availableVillages: [],

                init() {
                    this.restoreState();
                },

                restoreState() {
                    if (this.selectedProv) {
                        let prov = this.wilayahTree.find(p => p.id == this.selectedProv);
                        this.availableCities = prov ? (prov.children || []) : [];

                        if (this.selectedKota) {
                            let city = this.availableCities.find(c => c.id == this.selectedKota);
                            this.availableDistricts = city ? (city.children || []) : [];

                            if (this.selectedKec) {
                                let dist = this.availableDistricts.find(d => d.id == this.selectedKec);
                                this.availableVillages = dist ? (dist.children || []) : [];
                            }
                        }
                    }
                },

                onProvinceChange() {
                    let prov = this.wilayahTree.find(p => p.id == this.selectedProv);
                    this.availableCities = prov ? (prov.children || []) : [];
                    this.selectedKota = null;
                    this.availableDistricts = [];
                    this.selectedKec = null;
                    this.availableVillages = [];
                    this.selectedDesa = null;
                },

                onCityChange() {
                    let city = this.availableCities.find(c => c.id == this.selectedKota);
                    this.availableDistricts = city ? (city.children || []) : [];
                    this.selectedKec = null;
                    this.availableVillages = [];
                    this.selectedDesa = null;
                },

                onDistrictChange() {
                    let dist = this.availableDistricts.find(d => d.id == this.selectedKec);
                    this.availableVillages = dist ? (dist.children || []) : [];
                    this.selectedDesa = null;
                },

                onVillageChange() {
                    // Desa dipilih
                }
            };
        }
    </script>
</div>
