@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Kepala Sekolah</h1>
            <p class="text-sm text-slate-500 mt-1">Monitoring statistik PPDB, rekapitulasi nilai, dan pengesahan kelulusan.</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 border border-purple-200">
            Hak Akses: Kepala Sekolah (Eksekutif)
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Total Kuota Tersedia</p>
            <p class="text-3xl font-extrabold text-slate-900 mt-2">180</p>
            <p class="text-xs text-slate-500 mt-1">Target 6 Rombongan Belajar</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Pendaftar Masuk</p>
            <p class="text-3xl font-extrabold text-indigo-600 mt-2">1</p>
            <p class="text-xs text-slate-500 mt-1">Persentase Keterisian: 0.5%</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Menunggu SK Kelulusan</p>
            <p class="text-3xl font-extrabold text-purple-600 mt-2">0</p>
            <p class="text-xs text-slate-500 mt-1">Siap Disahkan</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <h2 class="text-base font-bold text-slate-900 mb-4">Aksi Pengesahan & Laporan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('kepsek.statistik') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-purple-50 hover:border-purple-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-purple-700">Statistik Komprehensif PPDB</span>
                <p class="text-xs text-slate-500 mt-1">Grafik asal sekolah, persebaran jurusan & gender pendaftar</p>
            </a>
            <a href="{{ route('kepsek.approval') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-purple-50 hover:border-purple-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-purple-700">Approval & Pengesahan Hasil Kelulusan</span>
                <p class="text-xs text-slate-500 mt-1">Validasi keputusan akhir penerimaan calon peserta didik</p>
            </a>
        </div>
    </div>
</div>
@endsection
