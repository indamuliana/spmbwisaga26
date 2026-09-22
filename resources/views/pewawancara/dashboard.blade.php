@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Pewawancara</h1>
            <p class="text-sm text-slate-500 mt-1">Pengujian wawancara, tes minat bakat, dan baca Al-Qur'an calon siswa.</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
            Hak Akses: Pewawancara / Tim Uji
        </span>
    </div>

    @php
        $jadwalHariIni = \App\Models\Wawancara::whereDate('jadwal', today())->count();
        $sudahDinilai = \App\Models\Wawancara::count();
        $menungguGiliran = \App\Models\CalonSiswa::where('status_pendaftaran', \App\Enums\StatusPendaftaran::MENUNGGU_WAWANCARA)->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Jadwal Hari Ini</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ $jadwalHariIni }}</p>
            <p class="text-xs text-slate-500 mt-1">Sesi Wawancara Hari Ini</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Sudah Dinilai</p>
            <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $sudahDinilai }}</p>
            <p class="text-xs text-slate-500 mt-1">Nilai & Observasi Selesai</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Belum Ujian</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $menungguGiliran }}</p>
            <p class="text-xs text-slate-500 mt-1">Menunggu Giliran Wawancara</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <h2 class="text-base font-bold text-slate-900 mb-4">Aksi Tim Pewawancara</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('pewawancara.jadwal') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-amber-50 hover:border-amber-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-amber-700">Jadwal Sesi Wawancara</span>
                <p class="text-xs text-slate-500 mt-1">Lihat urutan antrean & ruang wawancara</p>
            </a>
            <a href="{{ route('pewawancara.penilaian') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-amber-50 hover:border-amber-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-amber-700">Form Input Nilai & Catatan</span>
                <p class="text-xs text-slate-500 mt-1">Penilaian aspek minat, bakat, kepribadian & keagamaan</p>
            </a>
        </div>
    </div>
</div>
@endsection
