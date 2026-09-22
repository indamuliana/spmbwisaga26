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

    <!-- Header Banner -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-sm font-bold shadow-xs">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Tahap Akhir: Daftar Ulang & Checkout Seragam
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Lengkapi komitmen pembayaran awal, pemilihan ukuran seragam sekolah, kelengkapan berkas susulan, dan unduh Surat Kesepahaman bermaterai.
            </p>
        </div>

        <!-- Tombol Cetak PDF Dokumen Kesepahaman -->
        <a
            href="{{ route('dokumen-kesepahaman.cetak') }}"
            target="_blank"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-800 bg-amber-100 hover:bg-amber-200 border border-amber-300 shadow-2xs transition shrink-0"
        >
            <svg class="w-4 h-4 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.04.14-2.17.96-2.99a3.992 3.992 0 012.83-1.17c1.06 0 2.07.42 2.83 1.17.82.82 1.2 1.95.96 2.99m-7.58 0A4.004 4.004 0 007 18h10a4 4 0 00.42-7.979m-7.58 3.808L12 11.5m0 0l2.14 2.329M12 11.5V20" />
            </svg>
            <span>Cetak Surat Kesepahaman (PDF)</span>
        </a>
    </div>

    @if ($calonSiswa)
        <form wire:submit="submitDaftarUlang" class="space-y-6">
            <!-- SECTION 1: Kesanggupan Nominal Bayar Awal -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="pb-3 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-bold">1</span>
                            Kesanggupan Nominal Pembayaran Awal
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Tentukan nominal yang sanggup dibayarkan saat daftar ulang (dapat dicicil sesuai kesepahaman).</p>
                    </div>
                </div>

                <div class="max-w-md" x-data="{
                    nominal: @entangle('nominal_kesanggupan_awal'),
                    formatRupiah(val) {
                        if (!val) return 'Rp 0';
                        return 'Rp ' + Number(val).toLocaleString('id-ID');
                    }
                }">
                    <label for="nominal_bayar" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nominal Kesanggupan Awal (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 font-bold text-xs">Rp</span>
                        </div>
                        <input
                            id="nominal_bayar"
                            type="number"
                            min="0"
                            step="50000"
                            wire:model.live.debounce.300ms="nominal_kesanggupan_awal"
                            class="w-full rounded-xl border-slate-300 pl-10 pr-4 py-2.5 text-sm font-bold text-slate-900 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="1500000"
                        />
                    </div>
                    <p class="text-xs text-emerald-700 font-semibold mt-1.5" x-text="formatRupiah(nominal)"></p>
                    @error('nominal_kesanggupan_awal') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION 2: Checkout Seragam Sekolah -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-bold">2</span>
                            Checkout Paket Seragam Sekolah
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Item bertanda <em>Wajib</em> terkunci otomatis. Pilih ukuran baju/celana yang sesuai.</p>
                    </div>

                    <!-- Total Biaya Seragam -->
                    <div class="px-4 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-right">
                        <span class="text-[10px] uppercase font-bold text-emerald-700 tracking-wider">Total Biaya Seragam</span>
                        <p class="text-base font-black text-emerald-900">Rp {{ number_format($totalSeragam, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">Pilih</th>
                                <th class="py-3 px-4">Item Seragam</th>
                                <th class="py-3 px-4">Sifat Item</th>
                                <th class="py-3 px-4">Pilihan Ukuran (S - XXL)</th>
                                <th class="py-3 px-4 text-right">Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($seragams as $item)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <!-- Checkbox (Item wajib sekolah otomatis tercentang & di-disable uncheck-nya) -->
                                    <td class="py-3.5 px-4 text-center">
                                        @if ($item->wajib_sekolah)
                                            <!-- Checkbox tercentang dan disabled -->
                                            <input
                                                type="checkbox"
                                                checked
                                                disabled
                                                class="rounded border-slate-300 text-emerald-600 bg-slate-100 cursor-not-allowed"
                                            />
                                        @else
                                            <input
                                                type="checkbox"
                                                wire:model.live="selectedSeragam.{{ $item->id }}"
                                                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                            />
                                        @endif
                                    </td>

                                    <!-- Nama Item -->
                                    <td class="py-3.5 px-4 font-semibold text-slate-900">
                                        {{ $item->nama_item }}
                                        <span class="text-[10px] text-slate-400 block font-normal capitalize">Kategori: {{ $item->kategori_gender }}</span>
                                    </td>

                                    <!-- Sifat Wajib / Pilihan -->
                                    <td class="py-3.5 px-4">
                                        @if ($item->wajib_sekolah)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                                Wajib Sekolah
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                Opsional / Tambahan
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Opsi Ukuran Dropdown (S, M, L, XL, XXL) -->
                                    <td class="py-3.5 px-4">
                                        <select
                                            wire:model="ukuranSeragam.{{ $item->id }}"
                                            class="rounded-lg border-slate-300 text-xs py-1.5 px-2.5 font-semibold text-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-2xs {{ empty($selectedSeragam[$item->id]) && !$item->wajib_sekolah ? 'bg-slate-100 opacity-50 cursor-not-allowed' : 'bg-white' }}"
                                            {{ empty($selectedSeragam[$item->id]) && !$item->wajib_sekolah ? 'disabled' : '' }}
                                        >
                                            <option value="S">Ukuran S (Small)</option>
                                            <option value="M">Ukuran M (Medium)</option>
                                            <option value="L">Ukuran L (Large)</option>
                                            <option value="XL">Ukuran XL (Extra Large)</option>
                                            <option value="XXL">Ukuran XXL (Double XL)</option>
                                        </select>
                                    </td>

                                    <!-- Harga -->
                                    <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-800">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 3: Loker Berkas (Upload Dokumen Susulan) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="pb-3 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-bold">3</span>
                        Loker Berkas (Dokumen Persyaratan Susulan)
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Unggah salinan dokumen resmi (Format: PDF, JPG, PNG &bull; Maks. 2MB).</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- 1. Ijazah / SKL -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-800">1. Ijazah SMP / Surat Keterangan Lulus (SKL)</label>
                            @if (!empty($lokerBerkas['ijazah']))
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">&check; Terunggah</span>
                            @endif
                        </div>
                        <input
                            type="file"
                            wire:model="upload_ijazah"
                            class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer"
                        />
                        @if (!empty($lokerBerkas['ijazah']))
                            <p class="text-[11px] text-slate-500 font-mono truncate">Berkas: {{ basename($lokerBerkas['ijazah']) }}</p>
                        @endif
                        @error('upload_ijazah') <p class="text-rose-600 text-[11px]">{{ $message }}</p> @enderror
                    </div>

                    <!-- 2. Kartu Keluarga (KK) -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-800">2. Kartu Keluarga (KK)</label>
                            @if (!empty($lokerBerkas['kk']))
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">&check; Terunggah</span>
                            @endif
                        </div>
                        <input
                            type="file"
                            wire:model="upload_kk"
                            class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer"
                        />
                        @if (!empty($lokerBerkas['kk']))
                            <p class="text-[11px] text-slate-500 font-mono truncate">Berkas: {{ basename($lokerBerkas['kk']) }}</p>
                        @endif
                        @error('upload_kk') <p class="text-rose-600 text-[11px]">{{ $message }}</p> @enderror
                    </div>

                    <!-- 3. Akta Kelahiran -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-800">3. Akta Kelahiran</label>
                            @if (!empty($lokerBerkas['akta']))
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">&check; Terunggah</span>
                            @endif
                        </div>
                        <input
                            type="file"
                            wire:model="upload_akta"
                            class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer"
                        />
                        @if (!empty($lokerBerkas['akta']))
                            <p class="text-[11px] text-slate-500 font-mono truncate">Berkas: {{ basename($lokerBerkas['akta']) }}</p>
                        @endif
                        @error('upload_akta') <p class="text-rose-600 text-[11px]">{{ $message }}</p> @enderror
                    </div>

                    <!-- 4. Berkas Tambahan (KIP / Sertifikat) -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-800">4. KIP / PKH / Piagam Tambahan (Opsional)</label>
                            @if (!empty($lokerBerkas['tambahan']))
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">&check; Terunggah</span>
                            @endif
                        </div>
                        <input
                            type="file"
                            wire:model="upload_tambahan"
                            class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer"
                        />
                        @if (!empty($lokerBerkas['tambahan']))
                            <p class="text-[11px] text-slate-500 font-mono truncate">Berkas: {{ basename($lokerBerkas['tambahan']) }}</p>
                        @endif
                        @error('upload_tambahan') <p class="text-rose-600 text-[11px]">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button Card -->
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500">
                    Setelah menyimpan, status pendaftaran Anda akan resmi diperbarui menjadi <strong>Daftar Ulang</strong>.
                </div>
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition disabled:opacity-50"
                >
                    <span wire:loading.remove>Simpan & Selesaikan Daftar Ulang</span>
                    <span wire:loading>Menyimpan Data...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </button>
            </div>
        </form>
    @else
        <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center shadow-xs">
            <p class="text-sm font-semibold text-slate-600">Profil calon siswa tidak ditemukan.</p>
        </div>
    @endif
</div>
