<div class="space-y-6">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="font-semibold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            <div>
                <p class="font-semibold text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Header & Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Menunggu ACC Bendahara</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ $totalMenunggu }}</p>
            <p class="text-xs text-slate-500 mt-1">Calon siswa butuh verifikasi bukti transfer</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Sudah Di-ACC / Lanjut</p>
            <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $totalDiverifikasi }}</p>
            <p class="text-xs text-slate-500 mt-1">Status aktif mengisi biodata s.d. selesai</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Nominal Biaya Seleksi</p>
            <p class="text-2xl font-black text-slate-800 mt-2">Rp {{ number_format($nominalSeleksi, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-1">Standar biaya formulir & administrasi</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <!-- Controls: Search & Filter Tabs -->
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Filter Tabs -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button
                    type="button"
                    wire:click="$set('filterStatus', 'all')"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition {{ $filterStatus === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Semua Berkas
                </button>
                <button
                    type="button"
                    wire:click="$set('filterStatus', 'menunggu')"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition {{ $filterStatus === 'menunggu' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Menunggu ACC ({{ $totalMenunggu }})
                </button>
                <button
                    type="button"
                    wire:click="$set('filterStatus', 'terverifikasi')"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition {{ $filterStatus === 'terverifikasi' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Sudah Di-ACC ({{ $totalDiverifikasi }})
                </button>
            </div>

            <!-- Search Bar -->
            <div class="w-full sm:w-72">
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari nama, NISN, atau sekolah..."
                        class="w-full rounded-xl border-slate-300 pl-9 pr-4 py-2 text-xs shadow-xs focus:ring-emerald-500 focus:border-emerald-500"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Calon Siswa</th>
                        <th class="py-3.5 px-4">Program Pilihan</th>
                        <th class="py-3.5 px-4">Bukti Transfer</th>
                        <th class="py-3.5 px-4">Catatan Siswa</th>
                        <th class="py-3.5 px-4">Status Pendaftaran</th>
                        <th class="py-3.5 px-4 text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($calonList as $calon)
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- Calon Siswa -->
                            <td class="py-3.5 px-4">
                                <p class="font-bold text-slate-900 text-sm">{{ $calon->nama_lengkap }}</p>
                                <div class="flex items-center gap-2 mt-0.5 text-slate-500">
                                    <span>NISN: <strong class="font-mono text-slate-700">{{ $calon->nisn ?? '-' }}</strong></span>
                                    <span>&bull;</span>
                                    <span>{{ $calon->asal_sekolah }}</span>
                                </div>
                            </td>

                            <!-- Program -->
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $calon->program?->nama_program ?? 'Universal' }}
                                </span>
                            </td>

                            <!-- Bukti Transfer -->
                            <td class="py-3.5 px-4">
                                @if ($calon->bukti_bayar_seleksi)
                                    <button
                                        type="button"
                                        wire:click="showPreview({{ $calon->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 font-medium text-xs shadow-2xs transition"
                                    >
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat Struk
                                    </button>
                                @else
                                    <span class="text-slate-400 italic">Belum unggah</span>
                                @endif
                            </td>

                            <!-- Pengirim & Nominal -->
                            <td class="py-3.5 px-4 text-slate-600">
                                <p class="font-bold text-slate-800">{{ $calon->nama_rekening_pengirim ?: '-' }}</p>
                                <p class="text-xs">Rp {{ number_format($calon->nominal_transfer_seleksi, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-slate-400">{{ $calon->tanggal_transfer_seleksi?->format('d M Y') ?: '-' }}</p>
                            </td>

                            <!-- Status Pendaftaran -->
                            <td class="py-3.5 px-4">
                                @if ($calon->status_pendaftaran === \App\Enums\StatusPendaftaran::BAYAR_SELEKSI)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Menunggu ACC
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        {{ $calon->status_pendaftaran->label() }}
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    @if ($calon->status_pendaftaran === \App\Enums\StatusPendaftaran::BAYAR_SELEKSI)
                                        <!-- Tombol ACC -->
                                        <button
                                            type="button"
                                            wire:click="accPembayaran({{ $calon->id }})"
                                            wire:confirm="Yakin ingin menyetujui (ACC) pembayaran seleksi untuk {{ $calon->nama_lengkap }}?"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-xs transition"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            ACC
                                        </button>
                                        
                                        <!-- Tombol Tolak -->
                                        <button
                                            type="button"
                                            wire:click="openRejectModal({{ $calon->id }})"
                                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition"
                                        >
                                            Tolak
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400 font-medium italic">Sudah di-ACC</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-300 mx-auto flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Tidak ada data bukti pembayaran</p>
                                <p class="text-xs text-slate-400 mt-0.5">Siswa yang mengunggah struk transfer akan muncul pada daftar ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($calonList->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $calonList->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Preview Bukti Transfer -->
    @if ($previewCalon)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-200 animate-in fade-in zoom-in duration-150">
                <!-- Modal Header -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Bukti Transfer Pembayaran</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $previewCalon->nama_lengkap }} (NISN: {{ $previewCalon->nisn ?? '-' }})</p>
                    </div>
                    <button
                        type="button"
                        wire:click="closePreview"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Detail Info Pembayaran -->
                <div class="bg-slate-50 p-4 border-b border-slate-100 flex gap-4 text-sm">
                    <div class="flex-1">
                        <p class="text-slate-500 text-xs">Rekening Pengirim</p>
                        <p class="font-bold text-slate-800">{{ $previewCalon->nama_rekening_pengirim ?: '-' }}</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-slate-500 text-xs">Nominal Transfer</p>
                        <p class="font-bold text-slate-800">Rp {{ number_format($previewCalon->nominal_transfer_seleksi, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-slate-500 text-xs">Tanggal</p>
                        <p class="font-bold text-slate-800">{{ $previewCalon->tanggal_transfer_seleksi?->format('d M Y') ?: '-' }}</p>
                    </div>
                </div>

                <!-- Modal Body: Image / PDF Preview -->
                <div class="p-5 bg-slate-100 flex flex-col items-center justify-center min-h-[200px] max-h-[350px] overflow-auto">
                    @php
                        $fileUrl = asset('storage/' . $previewCalon->bukti_bayar_seleksi);
                        $isPdf = str_ends_with(strtolower($previewCalon->bukti_bayar_seleksi), '.pdf');
                    @endphp

                    @if ($isPdf)
                        <div class="text-center py-6">
                            <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 mx-auto flex items-center justify-center mb-3">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-800">Berkas Dokumen PDF</p>
                            <a
                                href="{{ $fileUrl }}"
                                target="_blank"
                                class="inline-flex items-center gap-1 mt-3 px-4 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-xs transition"
                            >
                                Buka Berkas PDF di Tab Baru &rarr;
                            </a>
                        </div>
                    @else
                        <img
                            src="{{ $fileUrl }}"
                            alt="Bukti Transfer {{ $previewCalon->nama_lengkap }}"
                            class="max-h-[300px] w-auto object-contain rounded-xl border border-slate-200 shadow-xs"
                        />
                    @endif
                </div>

                <!-- Modal Footer with Form Tolak -->
                <div class="p-4 border-t border-slate-100 bg-white">
                    @if ($previewCalon->status_pendaftaran === \App\Enums\StatusPendaftaran::BAYAR_SELEKSI)
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-medium italic">Pastikan dana telah masuk mutasi.</span>
                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="openRejectModal({{ $previewCalon->id }})" class="px-4 py-2 rounded-xl text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 transition">Tolak Pembayaran</button>
                                <button type="button" wire:click="closePreview" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Tutup</button>
                                <button type="button" wire:click="accPembayaran({{ $previewCalon->id }})" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-xs transition">&check; ACC Valid</button>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-medium">Siswa ini telah diverifikasi.</span>
                            <button type="button" wire:click="closePreview" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Tutup</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Penolakan -->
    @if ($rejectingCalonId)
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-2xl border border-slate-200 animate-in fade-in zoom-in duration-150">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-rose-700">Tolak Pembayaran</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $rejectingCalon?->nama_lengkap }} (NISN: {{ $rejectingCalon?->nisn ?? '-' }})</p>
                    </div>
                    <button type="button" wire:click="closeRejectModal" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-5 bg-slate-50">
                    <p class="text-sm text-slate-600 mb-3">Tuliskan pesan / alasan yang jelas kepada siswa mengapa bukti bayar ditolak (misalnya: struk buram, nominal kurang, atau dana belum masuk mutasi rekening). Siswa akan diminta untuk mengunggah ulang.</p>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alasan Penolakan *</label>
                    <textarea wire:model="alasanTolak" rows="3" placeholder="Contoh: Bukti transfer terpotong, mohon foto ulang struk secara utuh." class="w-full rounded-xl text-sm border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"></textarea>
                    @error('alasanTolak') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div class="p-4 border-t border-slate-100 bg-white flex justify-end gap-2">
                    <button type="button" wire:click="closeRejectModal" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                    <button type="button" wire:click="confirmTolak" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition">Kirim Penolakan</button>
                </div>
            </div>
        </div>
    @endif
</div>
