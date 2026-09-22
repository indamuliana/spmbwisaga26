<div class="space-y-6">
    <!-- Flash Notification -->
    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="font-semibold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Header & Candidate Selector -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-sm font-bold shadow-xs">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </span>
                Form Penilaian Wawancara & Observasi
            </h1>
            <p class="text-xs text-slate-500 mt-1">Uji kelayakan calon santri/siswa, observasi fisik, kemampuan membaca Al-Qur'an, dan rekomendasi beasiswa.</p>
        </div>

        <div class="flex items-center gap-3">
            <label for="select-calon" class="text-xs font-medium text-slate-600 whitespace-nowrap">Pilih Calon Siswa:</label>
            <select
                id="select-calon"
                wire:model.live="calon_siswa_id"
                class="rounded-xl border-slate-300 text-sm font-medium text-slate-800 shadow-xs focus:ring-amber-500 focus:border-amber-500 py-2 pl-3 pr-8 min-w-[260px]"
            >
                <option value="">-- Pilih Antrean Calon Siswa --</option>
                @foreach ($candidates as $candidate)
                    <option value="{{ $candidate->id }}">
                        {{ $candidate->nama_lengkap }} (NISN: {{ $candidate->nisn ?? '-' }}) - {{ $candidate->status_pendaftaran->label() }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($calonSiswa)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Student Dossier & Beasiswa Score Preview -->
            <div class="space-y-6 lg:col-span-1">
                <!-- Biodata Ringkas -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Biodata Calon Siswa
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $calonSiswa->status_pendaftaran === \App\Enums\StatusPendaftaran::SELESAI_WAWANCARA ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $calonSiswa->status_pendaftaran->label() }}
                        </span>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Nama Lengkap</span>
                            <span class="font-bold text-slate-800">{{ $calonSiswa->nama_lengkap }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">NISN</span>
                            <span class="font-mono font-semibold text-slate-700">{{ $calonSiswa->nisn ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Program / Jurusan</span>
                            <span class="font-semibold text-slate-800">
                                {{ $calonSiswa->program?->nama_program ?? '-' }}
                                @if($calonSiswa->jurusan)
                                    ({{ $calonSiswa->jurusan->nama_jurusan }})
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Asal Sekolah</span>
                            <span class="text-slate-700">{{ $calonSiswa->asal_sekolah }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Kontak WhatsApp</span>
                            <span class="font-mono text-emerald-600 font-semibold">{{ $calonSiswa->hp_siswa }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Rata-rata Rapor</span>
                            <span class="font-bold text-indigo-600 text-sm">{{ number_format($calonSiswa->rata_rata_raport ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Tanggungan Anak</span>
                            <span class="font-semibold text-slate-800">{{ $calonSiswa->jumlah_tanggungan ?? 1 }} Anak</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-slate-500">Penghasilan Ortu</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format(($calonSiswa->penghasilan_ayah ?? 0) + ($calonSiswa->penghasilan_ibu ?? 0), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Prestasi Badges -->
                    @if (!empty($calonSiswa->prestasi) && is_array($calonSiswa->prestasi))
                        <div class="pt-2 border-t border-slate-100">
                            <p class="text-xs font-semibold text-slate-700 mb-2">Prestasi Tercatat:</p>
                            <div class="space-y-1.5">
                                @foreach ($calonSiswa->prestasi as $p)
                                    <div class="p-2 rounded-lg bg-amber-50/70 border border-amber-200/60 text-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-amber-900">{{ $p['perolehan'] ?? '-' }}</span>
                                            <span class="px-1.5 py-0.5 rounded bg-amber-200 text-amber-900 font-semibold text-[10px]">Tingkat {{ $p['tingkat'] ?? '-' }}</span>
                                        </div>
                                        <p class="text-[11px] text-amber-800 mt-0.5">{{ $p['kategori'] ?? '-' }} - {{ $p['penyelenggara'] ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Live Beasiswa Scoring Card -->
                <div class="bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 p-5 rounded-2xl text-white shadow-md space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-indigo-200">Kalkulator Skor Beasiswa</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30">
                            Otomatis (Service)
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between pt-1">
                        <div>
                            <span class="text-3xl font-black text-amber-300">{{ number_format($skorBeasiswa ?? 0, 1) }}</span>
                            <span class="text-sm text-indigo-300 font-medium"> / 100</span>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-white/10 text-white border border-white/10 text-right max-w-[170px] truncate">
                            {{ $scoreBreakdown['kategori'] ?? '-' }}
                        </span>
                    </div>

                    <!-- Breakdown Components -->
                    <div class="space-y-2 pt-2 border-t border-indigo-700/60 text-xs">
                        <div>
                            <div class="flex justify-between text-indigo-200 text-[11px] mb-1">
                                <span>Penghasilan Ortu (50%)</span>
                                <span class="font-semibold text-white">{{ $scoreBreakdown['penghasilan']['weighted_score'] ?? 0 }} pts</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-indigo-950 overflow-hidden">
                                <div class="h-full bg-emerald-400 rounded-full" style="width: {{ ($scoreBreakdown['penghasilan']['raw_score'] ?? 0) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-indigo-200 text-[11px] mb-1">
                                <span>Tanggungan Anak (25%)</span>
                                <span class="font-semibold text-white">{{ $scoreBreakdown['tanggungan']['weighted_score'] ?? 0 }} pts</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-indigo-950 overflow-hidden">
                                <div class="h-full bg-cyan-400 rounded-full" style="width: {{ ($scoreBreakdown['tanggungan']['raw_score'] ?? 0) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-indigo-200 text-[11px] mb-1">
                                <span>Rapor & Prestasi (25%)</span>
                                <span class="font-semibold text-white">{{ $scoreBreakdown['akademik']['weighted_score'] ?? 0 }} pts</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-indigo-950 overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width: {{ ($scoreBreakdown['akademik']['raw_score'] ?? 0) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Wawancara Input -->
            <div class="lg:col-span-2">
                <form wire:submit="submitWawancara" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                    <!-- Session & Schedule Info -->
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            1. Informasi Jadwal & Media Wawancara
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="jadwal" class="block text-xs font-semibold text-slate-700 mb-1">Waktu Sesi Wawancara <span class="text-rose-500">*</span></label>
                                <input
                                    id="jadwal"
                                    type="datetime-local"
                                    wire:model="jadwal"
                                    class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:ring-amber-500 focus:border-amber-500"
                                />
                                @error('jadwal') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="link_meet" class="block text-xs font-semibold text-slate-700 mb-1">Link Virtual Meeting (Google Meet / Zoom)</label>
                                <input
                                    id="link_meet"
                                    type="url"
                                    wire:model="link_meet"
                                    placeholder="https://meet.google.com/xyz-abcd-efg"
                                    class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:ring-amber-500 focus:border-amber-500"
                                />
                                @error('link_meet') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Physical Appearance & Uniform Observation (INPUT TYPE="COLOR") -->
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            2. Observasi Fisik & Kerapian (Color Indicator)
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Warna Rambut -->
                            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                                <label for="nilai_fisik_rambut" class="block text-xs font-bold text-slate-800">
                                    Observasi Fisik Rambut <span class="text-rose-500">*</span>
                                </label>
                                <p class="text-[11px] text-slate-500">Pilih palet warna rambut siswa untuk mencatat kealamian warna & kepatuhan tata tertib.</p>

                                <div class="flex items-center gap-3">
                                    <input
                                        id="nilai_fisik_rambut"
                                        type="color"
                                        wire:model.live="nilai_fisik_rambut"
                                        class="w-14 h-12 rounded-lg border-2 border-slate-300 cursor-pointer p-0.5 bg-white shadow-xs"
                                    />
                                    <div class="flex-1">
                                        <span class="font-mono font-bold text-sm text-slate-800 uppercase px-2 py-1 bg-white border border-slate-200 rounded-md">
                                            {{ $nilai_fisik_rambut }}
                                        </span>
                                        <p class="text-[10px] text-slate-400 mt-1">Standar sekolah: Hitam Natural (#1a1a1a)</p>
                                    </div>
                                </div>

                                <!-- Preset Quick Buttons -->
                                <div class="flex items-center gap-1.5 pt-1">
                                    <span class="text-[10px] text-slate-400">Pilihan Cepat:</span>
                                    <button type="button" wire:click="$set('nilai_fisik_rambut', '#1a1a1a')" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-800 text-white hover:bg-slate-900">Hitam (#1a1a1a)</button>
                                    <button type="button" wire:click="$set('nilai_fisik_rambut', '#3e2723')" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-[#3e2723] text-white">Coklat (#3e2723)</button>
                                    <button type="button" wire:click="$set('nilai_fisik_rambut', '#d4af37')" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-[#d4af37] text-slate-900">Pirang (#d4af37)</button>
                                </div>
                                @error('nilai_fisik_rambut') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Warna / Kerapian Seragam -->
                            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                                <label for="nilai_fisik_seragam" class="block text-xs font-bold text-slate-800">
                                    Observasi Fisik Seragam <span class="text-rose-500">*</span>
                                </label>
                                <p class="text-[11px] text-slate-500">Pilih palet warna/kebersihan seragam saat sesi wawancara berlangsung.</p>

                                <div class="flex items-center gap-3">
                                    <input
                                        id="nilai_fisik_seragam"
                                        type="color"
                                        wire:model.live="nilai_fisik_seragam"
                                        class="w-14 h-12 rounded-lg border-2 border-slate-300 cursor-pointer p-0.5 bg-white shadow-xs"
                                    />
                                    <div class="flex-1">
                                        <span class="font-mono font-bold text-sm text-slate-800 uppercase px-2 py-1 bg-white border border-slate-200 rounded-md">
                                            {{ $nilai_fisik_seragam }}
                                        </span>
                                        <p class="text-[10px] text-slate-400 mt-1">Standar sekolah: Putih Bersih (#ffffff)</p>
                                    </div>
                                </div>

                                <!-- Preset Quick Buttons -->
                                <div class="flex items-center gap-1.5 pt-1">
                                    <span class="text-[10px] text-slate-400">Pilihan Cepat:</span>
                                    <button type="button" wire:click="$set('nilai_fisik_seragam', '#ffffff')" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-white border border-slate-300 text-slate-800">Putih (#ffffff)</button>
                                    <button type="button" wire:click="$set('nilai_fisik_seragam', '#1e3a8a')" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-[#1e3a8a] text-white">Biru SMP (#1e3a8a)</button>
                                    <button type="button" wire:click="$set('nilai_fisik_seragam', '#15803d')" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-[#15803d] text-white">Batik (#15803d)</button>
                                </div>
                                @error('nilai_fisik_seragam') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Al-Qur'an Competency -->
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            3. Pengujian Bacaan & Hafalan Al-Qur'an
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="kemampuan_quran" class="block text-xs font-semibold text-slate-700 mb-1">Tingkat Kemampuan Membaca <span class="text-rose-500">*</span></label>
                                <select
                                    id="kemampuan_quran"
                                    wire:model="kemampuan_quran"
                                    class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:ring-amber-500 focus:border-amber-500"
                                >
                                    <option value="Iqro">Iqro (Mengenal Huruf & Mengeja)</option>
                                    <option value="Tahsin">Tahsin (Tartil, Tajwid & Makhraj Teratur)</option>
                                    <option value="Tahfidz">Tahfidz (Hafidz / Menghafal Al-Qur'an)</option>
                                </select>
                                @error('kemampuan_quran') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="jumlah_juz" class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Juz Hafalan (0 - 30 Juz) <span class="text-rose-500">*</span></label>
                                <input
                                    id="jumlah_juz"
                                    type="number"
                                    min="0"
                                    max="30"
                                    wire:model="jumlah_juz"
                                    class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:ring-amber-500 focus:border-amber-500"
                                />
                                @error('jumlah_juz') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Confidential Notes -->
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            4. Catatan Rahasia Penguji (Confidential)
                        </h2>
                        <div>
                            <label for="catatan_rahasia" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Aspek Karakter, Minat Bakat, & Rekomendasi Khusus</label>
                            <textarea
                                id="catatan_rahasia"
                                rows="3"
                                wire:model="catatan_rahasia"
                                placeholder="Tuliskan catatan objektif penguji mengenai komitmen siswa, kepribadian, motivasi belajar, dan catatan keluarga yang hanya dapat diakses oleh tim pewawancara dan kepala sekolah..."
                                class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:ring-amber-500 focus:border-amber-500"
                            ></textarea>
                            @error('catatan_rahasia') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Submit Action -->
                    <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                        <span class="text-xs text-slate-500">
                            * Menyimpan penilaian akan otomatis memperbarui status calon siswa menjadi <strong>Selesai Wawancara</strong>.
                        </span>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl font-bold text-sm text-white bg-amber-600 hover:bg-amber-700 transition shadow-sm disabled:opacity-50"
                        >
                            <span wire:loading.remove>Simpan Hasil Wawancara</span>
                            <span wire:loading>Menyimpan...</span>
                            <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center shadow-xs">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800">Tidak Ada Calon Siswa Terpilih</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                Silakan pilih salah satu calon siswa pada dropdown di atas atau pastikan calon siswa telah menyelesaikan tahapan pengisian formulir hingga berstatus <em>Menunggu Wawancara</em>.
            </p>
        </div>
    @endif
</div>
