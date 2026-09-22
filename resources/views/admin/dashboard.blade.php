@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Administrator</h1>
            <p class="text-sm text-slate-500 mt-1">Selamat datang di panel kontrol manajemen PPDB 2026/2027.</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
            Hak Akses: Super Administrator
        </span>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Total Pendaftar</p>
            <p class="text-3xl font-extrabold text-slate-900 mt-2">1</p>
            <p class="text-xs text-emerald-600 mt-1">&uarr; Gelombang 1 Aktif</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Menunggu Verifikasi</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-2">1</p>
            <p class="text-xs text-slate-500 mt-1">Berkas & Pembayaran</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Lulus Seleksi</p>
            <p class="text-3xl font-extrabold text-indigo-600 mt-2">0</p>
            <p class="text-xs text-slate-500 mt-1">Hasil Akhir PPDB</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Total Pengguna Sistem</p>
            <p class="text-3xl font-extrabold text-slate-900 mt-2">5</p>
            <p class="text-xs text-slate-500 mt-1">5 Role Aktif</p>
        </div>
    </div>

    <!-- Menu Quick Action -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <h2 class="text-base font-bold text-slate-900 mb-4">Navigasi Master Data</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-indigo-600">Manajemen Pengguna</span>
                <p class="text-xs text-slate-500 mt-1">Kelola akun panitia dan siswa</p>
            </a>
            <a href="{{ route('admin.gelombang') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-indigo-600">Gelombang PPDB</span>
                <p class="text-xs text-slate-500 mt-1">Atur jadwal & kuota seleksi</p>
            </a>
            <a href="{{ route('admin.jurusan') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-indigo-600">Master Jurusan</span>
                <p class="text-xs text-slate-500 mt-1">Daftar peminatan/jurusan</p>
            </a>
            <a href="{{ route('admin.penugasan-wawancara') }}" class="p-4 rounded-xl border border-amber-100 bg-amber-50/50 hover:bg-amber-100/60 hover:border-amber-300 transition group">
                <span class="font-semibold text-sm text-amber-900 group-hover:text-amber-800 flex items-center justify-between">
                    <span>Penugasan Wawancara</span>
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                </span>
                <p class="text-xs text-amber-700/80 mt-1">Bulk assignment jadwal & pewawancara</p>
            </a>
            <a href="{{ route('admin.laporan') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-indigo-600">Laporan Rekapitulasi</span>
                <p class="text-xs text-slate-500 mt-1">Export data pendaftar & grafik</p>
            </a>
            <a href="{{ route('admin.pengumuman') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-indigo-600">Kelola Pengumuman</span>
                <p class="text-xs text-slate-500 mt-1">Atur slider pengumuman di halaman awal</p>
            </a>
        </div>
    </div>
</div>
@endsection
