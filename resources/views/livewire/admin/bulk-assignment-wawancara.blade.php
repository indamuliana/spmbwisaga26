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

    <!-- Header & Info -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shadow-xs">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.375 12.375 0 0110.375 21c-2.34 0-4.527-.643-6.375-1.765z" />
                    </svg>
                </span>
                Bulk Assignment Sesi Wawancara
            </h1>
            <p class="text-xs text-slate-500 mt-1">Penugasan jadwal dan pewawancara secara masal untuk siswa berstatus <em>Menunggu Wawancara</em>.</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                {{ $totalWaiting }} Calon Siswa Antre
            </span>
        </div>
    </div>

    <!-- Bulk Action Card (Active when checkboxes are checked) -->
    <div class="p-5 rounded-2xl border transition-all duration-200 {{ count($selected) > 0 ? 'bg-indigo-900 text-white border-indigo-800 shadow-lg' : 'bg-slate-50 text-slate-400 border-slate-200' }}">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg flex items-center justify-center font-bold text-xs {{ count($selected) > 0 ? 'bg-amber-400 text-slate-900' : 'bg-slate-200 text-slate-500' }}">
                    {{ count($selected) }}
                </span>
                <div>
                    <h2 class="text-sm font-bold {{ count($selected) > 0 ? 'text-white' : 'text-slate-600' }}">
                        Panel Penugasan Masal (Bulk Assignment)
                    </h2>
                    <p class="text-[11px] {{ count($selected) > 0 ? 'text-indigo-200' : 'text-slate-400' }}">
                        @if (count($selected) > 0)
                            Tentukan pewawancara dan jadwal untuk {{ count($selected) }} siswa yang dicentang di bawah.
                        @else
                            Centang kotak pada tabel di bawah untuk mengaktifkan aksi penugasan masal.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Form Controls -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Select Pewawancara -->
                <div class="w-full sm:w-auto">
                    <select
                        wire:model="pewawancara_id"
                        class="w-full rounded-xl text-xs py-2 px-3 border font-medium focus:ring-amber-500 focus:border-amber-500 {{ count($selected) > 0 ? 'bg-indigo-800/80 text-white border-indigo-700' : 'bg-white text-slate-400 border-slate-300' }}"
                        {{ count($selected) === 0 ? 'disabled' : '' }}
                    >
                        <option value="" class="text-slate-800">-- Pilih Pewawancara --</option>
                        @foreach ($pewawancaraList as $p)
                            <option value="{{ $p->id }}" class="text-slate-800">
                                {{ $p->name }} ({{ $p->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Jadwal -->
                <div class="w-full sm:w-auto">
                    <input
                        type="datetime-local"
                        wire:model="jadwal"
                        class="w-full rounded-xl text-xs py-2 px-3 border font-medium focus:ring-amber-500 focus:border-amber-500 {{ count($selected) > 0 ? 'bg-indigo-800/80 text-white border-indigo-700' : 'bg-white text-slate-400 border-slate-300' }}"
                        {{ count($selected) === 0 ? 'disabled' : '' }}
                    />
                </div>

                <!-- Link Meet -->
                <div class="w-full sm:w-auto">
                    <input
                        type="url"
                        wire:model="link_meet"
                        placeholder="Link Google Meet / Zoom..."
                        class="w-full sm:w-48 rounded-xl text-xs py-2 px-3 border font-medium focus:ring-amber-500 focus:border-amber-500 {{ count($selected) > 0 ? 'bg-indigo-800/80 text-white border-indigo-700 placeholder-indigo-300' : 'bg-white text-slate-400 border-slate-300' }}"
                        {{ count($selected) === 0 ? 'disabled' : '' }}
                    />
                </div>

                <!-- Button Submit -->
                <button
                    type="button"
                    wire:click="assignBulk"
                    wire:loading.attr="disabled"
                    {{ count($selected) === 0 ? 'disabled' : '' }}
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2 rounded-xl text-xs font-bold transition shadow-xs {{ count($selected) > 0 ? 'bg-amber-400 hover:bg-amber-500 text-slate-900 cursor-pointer' : 'bg-slate-200 text-slate-400 cursor-not-allowed' }}"
                >
                    <span wire:loading.remove>Tugaskan Terpilih ({{ count($selected) }})</span>
                    <span wire:loading>Memproses...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="mt-3 pt-3 border-t border-indigo-700/60 text-xs text-rose-300">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <!-- Search bar & Selection Info -->
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-slate-500">
                Menampilkan calon siswa berstatus <strong>Menunggu Wawancara</strong>.
            </div>

            <!-- Search -->
            <div class="w-full sm:w-72">
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari nama, NISN, atau sekolah..."
                        class="w-full rounded-xl border-slate-300 pl-9 pr-4 py-2 text-xs shadow-xs focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">
                            <input
                                type="checkbox"
                                wire:model.live="selectAll"
                                class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                            />
                        </th>
                        <th class="py-3.5 px-4">Calon Siswa</th>
                        <th class="py-3.5 px-4">Program Pilihan</th>
                        <th class="py-3.5 px-4">Rata-rata Rapor</th>
                        <th class="py-3.5 px-4">Prestasi</th>
                        <th class="py-3.5 px-4">Status Penugasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($calonList as $calon)
                        <tr class="hover:bg-slate-50/70 transition {{ in_array($calon->id, $selected) ? 'bg-indigo-50/40' : '' }}">
                            <!-- Checkbox -->
                            <td class="py-3.5 px-4 text-center">
                                <input
                                    type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $calon->id }}"
                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                />
                            </td>

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

                            <!-- Nilai Rapor -->
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-indigo-700 text-xs">
                                    {{ number_format($calon->rata_rata_raport ?? 0, 2) }}
                                </span>
                            </td>

                            <!-- Prestasi -->
                            <td class="py-3.5 px-4">
                                @if (!empty($calon->prestasi) && is_array($calon->prestasi))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-amber-100 text-amber-800">
                                        {{ count($calon->prestasi) }} Prestasi
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">-</span>
                                @endif
                            </td>

                            <!-- Status Penugasan -->
                            <td class="py-3.5 px-4">
                                @if ($calon->wawancara && $calon->wawancara->pewawancara)
                                    <div class="space-y-0.5">
                                        <div class="flex items-center gap-1.5 font-semibold text-slate-800 text-xs">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span>{{ $calon->wawancara->pewawancara->name }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 font-mono">
                                            {{ $calon->wawancara->jadwal?->format('d/m/Y H:i') }} WIB
                                        </p>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Belum Ditugaskan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-300 mx-auto flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Tidak ada antrean calon siswa</p>
                                <p class="text-xs text-slate-400 mt-0.5">Semua siswa di tahap ini telah diproses atau belum ada yang menyelesaikan Step 5.</p>
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
</div>
