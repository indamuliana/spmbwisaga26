<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Welcome -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Selamat datang, {{ $calonSiswa->nama_lengkap }}!</h1>
                <p class="text-slate-500 mt-1">Portal Pendaftaran Peserta Didik Baru SMK Wikrama 1 Garut</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    No: {{ $calonSiswa->nomor_pendaftar }}
                </span>
                
                @php
                    $badgeColor = match($calonSiswa->status_kelulusan->value) {
                        'Pending' => 'bg-amber-100 text-amber-800',
                        'Diterima' => 'bg-emerald-100 text-emerald-800',
                        'Cadangan' => 'bg-purple-100 text-purple-800',
                        'Ditolak', 'Mengundurkan Diri' => 'bg-red-100 text-red-800',
                        default => 'bg-slate-100 text-slate-800'
                    };
                @endphp
                <span class="inline-flex px-3 py-2 rounded-full text-sm font-bold shadow-xs border border-white/50 {{ $badgeColor }}">
                    Kelulusan: {{ $calonSiswa->status_kelulusan->value }}
                </span>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-6 items-start">
            
            <!-- Sidebar Panel: Navigasi Tahapan -->
            <div class="w-full md:w-1/4 shrink-0">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-4 space-y-2 sticky top-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest px-3 mb-4 mt-2">Tahapan PPDB</h3>
                    
                    @php
                        $stepNumber = $calonSiswa->status_pendaftaran->stepNumber();
                    @endphp

                    <!-- 1. Menu Pembayaran -->
                    @php 
                        $isBayarAllowed = $stepNumber >= 1;
                        $isBayarActive = $activeTab === 'pembayaran';
                    @endphp
                    <button wire:click="setTab('pembayaran')" @class([
                        'w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm font-semibold transition-all',
                        'bg-indigo-50 text-indigo-700 shadow-inner' => $isBayarActive,
                        'hover:bg-slate-50 text-slate-700' => !$isBayarActive && $isBayarAllowed,
                        'opacity-50 cursor-not-allowed text-slate-400' => !$isBayarAllowed,
                    ]) @disabled(!$isBayarAllowed)>
                        <div @class([
                            'w-8 h-8 rounded-full flex items-center justify-center shrink-0',
                            'bg-indigo-600 text-white' => $isBayarActive,
                            'bg-slate-200 text-slate-500' => !$isBayarActive && $stepNumber <= 2,
                            'bg-emerald-500 text-white' => $stepNumber > 2 && !$isBayarActive,
                        ])>
                            @if($stepNumber > 2 && !$isBayarActive) &check; @else 1 @endif
                        </div>
                        <span>Pembayaran Seleksi</span>
                    </button>

                    <!-- 2. Menu Biodata -->
                    @php 
                        $isBiodataAllowed = $stepNumber >= 3;
                        $isBiodataActive = $activeTab === 'biodata';
                    @endphp
                    <button wire:click="setTab('biodata')" @class([
                        'w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm font-semibold transition-all',
                        'bg-indigo-50 text-indigo-700 shadow-inner' => $isBiodataActive,
                        'hover:bg-slate-50 text-slate-700' => !$isBiodataActive && $isBiodataAllowed,
                        'opacity-50 cursor-not-allowed text-slate-400' => !$isBiodataAllowed,
                    ]) @disabled(!$isBiodataAllowed)>
                        <div @class([
                            'w-8 h-8 rounded-full flex items-center justify-center shrink-0',
                            'bg-indigo-600 text-white' => $isBiodataActive,
                            'bg-slate-200 text-slate-500' => !$isBiodataActive && $stepNumber <= 5,
                            'bg-emerald-500 text-white' => $stepNumber > 5 && !$isBiodataActive,
                        ])>
                            @if($stepNumber > 5 && !$isBiodataActive) &check; @else 2 @endif
                        </div>
                        <span>Isi Biodata & Raport</span>
                    </button>

                    <!-- 3. Menu Wawancara -->
                    @php 
                        $isWawancaraAllowed = $stepNumber >= 6;
                        $isWawancaraActive = $activeTab === 'wawancara';
                    @endphp
                    <button wire:click="setTab('wawancara')" @class([
                        'w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm font-semibold transition-all',
                        'bg-indigo-50 text-indigo-700 shadow-inner' => $isWawancaraActive,
                        'hover:bg-slate-50 text-slate-700' => !$isWawancaraActive && $isWawancaraAllowed,
                        'opacity-50 cursor-not-allowed text-slate-400' => !$isWawancaraAllowed,
                    ]) @disabled(!$isWawancaraAllowed)>
                        <div @class([
                            'w-8 h-8 rounded-full flex items-center justify-center shrink-0',
                            'bg-indigo-600 text-white' => $isWawancaraActive,
                            'bg-slate-200 text-slate-500' => !$isWawancaraActive && $stepNumber <= 7,
                            'bg-emerald-500 text-white' => $stepNumber > 7 && !$isWawancaraActive,
                        ])>
                            @if($stepNumber > 7 && !$isWawancaraActive) &check; @else 3 @endif
                        </div>
                        <span>Jadwal Wawancara</span>
                    </button>

                    <!-- 4. Menu Daftar Ulang -->
                    @php 
                        $isDaftarUlangAllowed = $stepNumber >= 9;
                        $isDaftarUlangActive = $activeTab === 'daftar_ulang';
                    @endphp
                    <button wire:click="setTab('daftar_ulang')" @class([
                        'w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm font-semibold transition-all',
                        'bg-indigo-50 text-indigo-700 shadow-inner' => $isDaftarUlangActive,
                        'hover:bg-slate-50 text-slate-700' => !$isDaftarUlangActive && $isDaftarUlangAllowed,
                        'opacity-50 cursor-not-allowed text-slate-400' => !$isDaftarUlangAllowed,
                    ]) @disabled(!$isDaftarUlangAllowed)>
                        <div @class([
                            'w-8 h-8 rounded-full flex items-center justify-center shrink-0',
                            'bg-indigo-600 text-white' => $isDaftarUlangActive,
                            'bg-slate-200 text-slate-500' => !$isDaftarUlangActive,
                        ])>
                            4
                        </div>
                        <span>Daftar Ulang</span>
                    </button>
                    
                    @if(session()->has('error_tab'))
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl text-center">
                            {{ session('error_tab') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Content Panel -->
            <div class="w-full md:w-3/4">
                
                <!-- TAMPILAN PEMBAYARAN -->
                @if($activeTab === 'pembayaran')
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                        <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-white">Pembayaran Biaya Seleksi</h2>
                            @if($stepNumber > 2)
                                <span class="bg-emerald-400 text-emerald-900 text-xs font-bold px-3 py-1 rounded-full shadow-xs">Selesai / Lunas</span>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            @if(session()->has('message'))
                                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @if($calonSiswa->keterangan_tolak_bayar)
                                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                                    <h3 class="text-red-800 font-bold">Pembayaran Ditolak oleh Bendahara</h3>
                                    <p class="text-red-700 mt-1">Alasan: {{ $calonSiswa->keterangan_tolak_bayar }}</p>
                                    <p class="text-red-700 text-sm mt-2">Silakan perbaiki data dan unggah ulang bukti transfer yang benar.</p>
                                </div>
                            @endif

                            @if($stepNumber > 2)
                                <div class="text-center py-8">
                                    <div class="mx-auto w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900">Pembayaran Telah Diverifikasi</h3>
                                    <p class="mt-2 text-slate-500">Terima kasih, pembayaran Anda telah diterima. Silakan lanjutkan ke menu Biodata di panel sebelah kiri.</p>
                                </div>
                            @elseif($calonSiswa->bukti_bayar_seleksi && !$calonSiswa->keterangan_tolak_bayar)
                                <!-- State: Menunggu Verifikasi -->
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-16 w-16 text-amber-500 animate-pulse mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-xl font-bold text-slate-900">Menunggu Validasi Bendahara</h3>
                                    <p class="mt-2 text-slate-500 max-w-lg mx-auto">Sistem mengunci tahapan selanjutnya sampai Bendahara melakukan ACC pembayaran Anda. Silakan cek secara berkala.</p>
                                </div>
                            @else
                                <!-- State: Form Pembayaran -->
                                <form wire:submit.prevent="kirimVerifikasi" class="space-y-6">
                                    
                                    <!-- Informasi Tagihan -->
                                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 mb-6">
                                        <h3 class="font-bold text-slate-800 mb-4">Informasi Tagihan & Rekening</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-slate-500">Nominal Pembayaran</p>
                                                <p class="text-2xl font-black text-indigo-600">Rp {{ number_format($tagihanSeleksi, 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Nomor Rekening Sekolah (Read-only)</p>
                                                <p class="text-lg font-bold text-slate-800">BSI - 7123456789</p>
                                                <p class="text-xs text-slate-500">a.n SMK Wikrama 1 Garut</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Tanggal Transfer *</label>
                                            <input type="date" wire:model="tanggal_transfer" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            @error('tanggal_transfer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Nominal yang Dikirim *</label>
                                            <div class="relative mt-1">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-500 sm:text-sm">Rp</span>
                                                </div>
                                                <input type="number" wire:model="nominal_transfer" class="block w-full pl-10 rounded-xl border-slate-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
                                            </div>
                                            @error('nominal_transfer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-slate-700">Nama Rekening Pengirim *</label>
                                            <input type="text" wire:model="nama_rekening" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Budi Santoso / Mandiri">
                                            @error('nama_rekening') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-slate-700">Upload Bukti Transfer (JPG/PNG/PDF) *</label>
                                            <input type="file" wire:model="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            @error('bukti_transfer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            
                                            <div wire:loading wire:target="bukti_transfer" class="text-sm text-indigo-600 mt-2">Mengunggah file...</div>
                                            
                                            @if ($calonSiswa->bukti_bayar_seleksi && !$bukti_transfer)
                                                <p class="text-sm text-emerald-600 mt-2 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    File lama sudah tersimpan. Unggah baru jika ingin mengganti.
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="pt-4 flex flex-col sm:flex-row gap-4 border-t border-slate-100">
                                        <button type="button" wire:click="simpanSementara" class="w-full sm:w-1/2 flex justify-center py-3 px-4 border-2 border-indigo-600 rounded-xl shadow-sm text-base font-bold text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                            Simpan Sementara
                                        </button>
                                        <button type="submit" class="w-full sm:w-1/2 flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                            Kirim Verifikasi
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
                
                <!-- TAMPILAN BIODATA -->
                @if($activeTab === 'biodata')
                    @if($stepNumber === 3)
                        <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-2xl mb-6 flex items-start">
                            <svg class="h-6 w-6 text-emerald-600 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h3 class="text-emerald-800 font-bold">Pembayaran Seleksi telah di-ACC!</h3>
                                <p class="text-emerald-700 text-sm mt-1">Silakan lanjutkan pengisian biodata, data orang tua, dan nilai raport.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Embed Stepper untuk Biodata & Raport -->
                    <livewire:student-registration-stepper />
                @endif

                <!-- TAMPILAN WAWANCARA -->
                @if($activeTab === 'wawancara')
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900">Jadwal Wawancara Anda</h2>
                        <p class="text-slate-500 mt-2 max-w-lg mx-auto">
                            @if($stepNumber === 6)
                                Anda sedang menunggu penjadwalan wawancara oleh Admin. Mohon periksa secara berkala halaman ini.
                            @elseif($stepNumber === 7)
                                Anda telah melaksanakan wawancara. Tunggu pengumuman selanjutnya.
                            @else
                                Tahap wawancara telah selesai.
                            @endif
                        </p>
                    </div>
                @endif

                <!-- TAMPILAN DAFTAR ULANG -->
                @if($activeTab === 'daftar_ulang')
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900">Daftar Ulang & Registrasi Final</h2>
                        <p class="text-slate-500 mt-2 max-w-lg mx-auto">
                            Selamat, Anda telah lulus! Silakan lakukan prosedur daftar ulang dan lengkapi berkas tambahan.
                        </p>
                        <!-- Form / link daftar ulang bisa disisipkan disini -->
                        <div class="mt-6">
                            <a href="/siswa/daftar-ulang" class="inline-flex px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow hover:bg-indigo-700 transition">Mulai Daftar Ulang</a>
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
        
    </div>
</div>
