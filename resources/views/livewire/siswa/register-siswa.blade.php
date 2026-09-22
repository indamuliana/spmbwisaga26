<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-slate-100 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        @if(!$isSuccess)

        {{-- Header Logo / Branding --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600 shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 14l9-5-9-5-9 5 9 5zm0 7v-6m0 0l-4-2.236M12 15l4-2.236"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">Pendaftaran PPDB</h1>
            <p class="mt-1 text-sm text-slate-500">SMK Wikrama &mdash; Tahun Pelajaran 2026/2027</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Form Header --}}
            <div class="bg-indigo-600 px-6 py-6 text-center">
                <h2 class="text-xl font-extrabold text-white">Formulir Pendaftaran Calon Siswa</h2>
                <p class="mt-1 text-indigo-200 text-sm">Isi data di bawah ini dengan benar dan lengkap.</p>
            </div>

            <form wire:submit.prevent="submit" class="p-6 sm:p-8 space-y-8">

                {{-- ============================================================ --}}
                {{-- A. Pilih Program --}}
                {{-- ============================================================ --}}
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 mb-4">
                        <span class="w-5 h-5 rounded-full bg-indigo-600 text-white text-[10px] font-black flex items-center justify-center">A</span>
                        <span>Pilih Program <span class="text-rose-500">*</span></span>
                    </h3>

                    @php
                        $programsSorted = $master_program->sortByDesc('id'); // Unggulan (id=2) dulu, Reguler (id=1) belakang
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($programsSorted as $prog)
                            @php
                                $isUnggulan = str_contains(strtolower($prog->nama_program), 'unggulan');
                                $isSelected = (string)$program_id === (string)$prog->id;
                                $nomor      = $isUnggulan ? '1' : '2';
                                $accentRing = $isUnggulan
                                    ? ($isSelected ? 'ring-2 ring-amber-500 border-amber-500 bg-amber-50' : 'border-slate-200 hover:border-amber-300 hover:bg-amber-50/50')
                                    : ($isSelected ? 'ring-2 ring-indigo-500 border-indigo-500 bg-indigo-50' : 'border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50');
                                $badgeCls   = $isUnggulan
                                    ? 'bg-amber-100 text-amber-700 border border-amber-200'
                                    : 'bg-indigo-100 text-indigo-700 border border-indigo-200';
                                $iconCls    = $isUnggulan ? 'text-amber-500' : 'text-indigo-500';
                            @endphp
                            <label class="relative flex flex-col cursor-pointer rounded-2xl border-2 p-5 transition {{ $accentRing }}">
                                <input type="radio" wire:model.live="program_id" value="{{ $prog->id }}"
                                       class="sr-only">

                                {{-- Badge Nomor --}}
                                <div class="flex items-start justify-between mb-3">
                                    <span class="text-4xl font-black {{ $iconCls }} leading-none">{{ $nomor }}</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $badgeCls }}">
                                        {{ $isUnggulan ? 'Kelas Unggulan' : 'Kelas Reguler' }}
                                    </span>
                                </div>

                                <p class="text-base font-extrabold text-slate-900 mb-1">{{ $prog->nama_program }}</p>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ $prog->deskripsi }}</p>

                                @if($prog->kuota > 0)
                                    <p class="mt-3 text-[11px] font-semibold text-slate-400">
                                        Kuota: <span class="font-bold text-slate-600">{{ $prog->kuota }} siswa</span>
                                    </p>
                                @endif

                                {{-- Centang aktif --}}
                                @if($isSelected)
                                <div class="absolute top-3 right-3">
                                    <svg class="w-5 h-5 {{ $isUnggulan ? 'text-amber-500' : 'text-indigo-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                @endif
                            </label>
                        @endforeach
                    </div>
                    @error('program_id')
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ============================================================ --}}
                {{-- B. Data Pribadi --}}
                {{-- ============================================================ --}}
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 mb-4">
                        <span class="w-5 h-5 rounded-full bg-indigo-600 text-white text-[10px] font-black flex items-center justify-center">B</span>
                        <span>Data Pribadi</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">NISN (10 Digit) <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="nisn" maxlength="10" placeholder="0051234567"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nisn') border-rose-500 @enderror">
                            @error('nisn') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <select wire:model="jenis_kelamin"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('jenis_kelamin') border-rose-500 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap (Sesuai KK) <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="nama_lengkap" placeholder="Nama sesuai kartu keluarga"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('nama_lengkap') border-rose-500 @enderror">
                            @error('nama_lengkap') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- C. Pendidikan & Kontak --}}
                {{-- ============================================================ --}}
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 mb-4">
                        <span class="w-5 h-5 rounded-full bg-indigo-600 text-white text-[10px] font-black flex items-center justify-center">C</span>
                        <span>Pendidikan &amp; Kontak</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Asal Sekolah (SMP/MTs) <span class="text-rose-500">*</span></label>
                            <select wire:model.live="pilihan_asal_sekolah"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('pilihan_asal_sekolah') border-rose-500 @enderror">
                                <option value="">-- Pilih Asal Sekolah --</option>
                                @foreach($master_asal_sekolah as $sekolah)
                                    <option value="{{ $sekolah->nama_sekolah }}">{{ $sekolah->nama_sekolah }}</option>
                                @endforeach
                                <option value="Lainnya">Lainnya (Ketik Manual)</option>
                            </select>
                            @error('pilihan_asal_sekolah') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if($pilihan_asal_sekolah === 'Lainnya')
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Sekolah Asal (Manual) <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="asal_sekolah_lainnya" placeholder="Nama sekolah asal..."
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('asal_sekolah_lainnya') border-rose-500 @enderror">
                            @error('asal_sekolah_lainnya') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Aktif <span class="text-rose-500">*</span></label>
                            <input type="email" wire:model="email" placeholder="nama@email.com"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('email') border-rose-500 @enderror">
                            <p class="text-[11px] text-slate-400 mt-1">Digunakan sebagai username untuk login ke sistem PPDB.</p>
                            @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. HP Calon Siswa (WA) <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="hp_siswa" placeholder="08..."
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('hp_siswa') border-rose-500 @enderror">
                            @error('hp_siswa') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. HP Ayah</label>
                            <input type="text" wire:model="hp_ayah" placeholder="08..."
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. HP Ibu</label>
                            <input type="text" wire:model="hp_ibu" placeholder="08..."
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- D. Referensi --}}
                {{-- ============================================================ --}}
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 mb-4">
                        <span class="w-5 h-5 rounded-full bg-indigo-600 text-white text-[10px] font-black flex items-center justify-center">D</span>
                        <span>Referensi / Mengetahui Wikrama Dari</span>
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Sumber Referensi <span class="text-rose-500">*</span></label>
                            <select wire:model.live="kategori_referensi"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('kategori_referensi') border-rose-500 @enderror">
                                <option value="">-- Pilih Referensi --</option>
                                <option value="Guru SMK Wikrama 1 Garut">Guru SMK Wikrama 1 Garut</option>
                                <option value="Guru SMK Wikrama Bogor">Guru SMK Wikrama Bogor</option>
                                <option value="Siswa SMK Wikrama Aktif">Siswa SMK Wikrama Aktif</option>
                                <option value="Alumni SMK Wikrama">Alumni SMK Wikrama</option>
                                <option value="Calon Siswa Wikrama">Calon Siswa Wikrama</option>
                                <option value="Sosial Media / Internet">Sosial Media / Internet</option>
                                <option value="Lainnya">Lainnya / Tidak Ada</option>
                            </select>
                            @error('kategori_referensi') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if(in_array($kategori_referensi, ['Guru SMK Wikrama 1 Garut', 'Guru SMK Wikrama Bogor', 'Alumni SMK Wikrama']))
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Nama {{ explode(' ', $kategori_referensi)[0] }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" wire:model="detail_referensi_nama"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('detail_referensi_nama') border-rose-500 @enderror">
                                @error('detail_referensi_nama') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                        @elseif($kategori_referensi === 'Siswa SMK Wikrama Aktif')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Siswa Aktif <span class="text-rose-500">*</span></label>
                                    <input type="text" wire:model="detail_referensi_nama"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Rayon Siswa <span class="text-rose-500">*</span></label>
                                    <select wire:model="detail_referensi_rayon"
                                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('detail_referensi_rayon') border-rose-500 @enderror">
                                        <option value="">-- Pilih Rayon --</option>
                                        <option value="Cicurug 1">Cicurug 1</option>
                                        <option value="Cicurug 2">Cicurug 2</option>
                                        <option value="Tajur 1">Tajur 1</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    @error('detail_referensi_rayon') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                        @elseif($kategori_referensi === 'Calon Siswa Wikrama')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Calon Siswa <span class="text-rose-500">*</span></label>
                                    <input type="text" wire:model="detail_referensi_nama"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor Seleksi <span class="text-rose-500">*</span></label>
                                    <input type="text" wire:model="detail_referensi_nomor"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 @error('detail_referensi_nomor') border-rose-500 @enderror">
                                    @error('detail_referensi_nomor') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                        @elseif(in_array($kategori_referensi, ['Sosial Media / Internet', 'Lainnya']))
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Keterangan Tambahan (opsional)</label>
                                <input type="text" wire:model="detail_referensi_nama" placeholder="Misal: Instagram, TikTok..."
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled"
                            class="w-full flex justify-center items-center py-3.5 px-6 rounded-2xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition focus:outline-none focus:ring-4 focus:ring-indigo-300">
                        <span wire:loading.remove wire:target="submit">
                            Proses Pendaftaran Sekarang &rarr;
                        </span>
                        <span wire:loading wire:target="submit" class="flex items-center space-x-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
                            <span>Memproses...</span>
                        </span>
                    </button>
                    <p class="text-center text-xs text-slate-400 mt-3">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Login di sini</a>
                    </p>
                </div>

            </form>
        </div>

        @else
        {{-- ============================================================ --}}
        {{-- Halaman Sukses --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-3xl shadow-lg border border-emerald-200 overflow-hidden text-center">
            <div class="bg-emerald-500 px-6 py-8">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-white">Pendaftaran Berhasil!</h2>
                <p class="mt-1 text-emerald-100 text-sm">Akun PPDB Anda telah berhasil dibuat. Simpan informasi di bawah ini.</p>
            </div>

            <div class="p-8 space-y-6">
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 text-left">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Informasi Akun Anda</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400">Nomor Pendaftar</p>
                            <p class="text-2xl font-extrabold text-slate-900 tracking-wide">{{ $generatedAccount['nomor_pendaftar'] }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Nama Lengkap</p>
                            <p class="text-base font-semibold text-slate-900">{{ $generatedAccount['nama'] }}</p>
                        </div>
                        <div class="sm:col-span-2 border-t pt-4 mt-1">
                            <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-3">Kredensial Login</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-slate-400">Username (Email)</p>
                                    <p class="text-sm font-bold text-slate-900 break-all">{{ $generatedAccount['username'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Password</p>
                                    <p class="text-sm font-bold text-slate-900">{{ $generatedAccount['password'] }}</p>
                                    <p class="text-[11px] text-slate-400 italic mt-0.5">(Sama dengan NISN Anda)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-amber-50 rounded-xl border border-amber-200">
                    <p class="text-sm text-amber-800">
                        <span class="font-bold">&#9888; Penting:</span> Harap simpan atau download informasi akun di atas sebelum meninggalkan halaman ini.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('cetak-akun', $generatedAccount['id']) }}" target="_blank"
                       class="inline-flex justify-center items-center px-5 py-3 rounded-xl font-bold text-white bg-amber-500 hover:bg-amber-600 transition shadow-sm">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download PDF Akun
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex justify-center items-center px-5 py-3 rounded-xl font-bold text-indigo-700 border-2 border-indigo-600 bg-white hover:bg-indigo-50 transition">
                        Lanjut ke Login
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
