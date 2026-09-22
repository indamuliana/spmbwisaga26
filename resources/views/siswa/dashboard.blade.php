@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Halo, {{ auth()->user()->name }}!</h1>
            <p class="text-sm text-slate-500 mt-1">Selamat datang di portal pendaftaran calon siswa PPDB 2026/2027.</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-800 border border-sky-200">
            Nomor Registrasi: #REG-2026-0001
        </span>
    </div>

    <!-- Stepper Status Pendaftaran -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <h2 class="text-base font-bold text-slate-900 mb-4">Progres Pendaftaran Anda</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl border border-indigo-200 bg-indigo-50/50">
                <div class="flex items-center space-x-2 text-indigo-700 font-bold text-sm">
                    <span class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs">1</span>
                    <span>Buat Akun</span>
                </div>
                <p class="text-xs text-indigo-600/80 mt-1 font-medium">&check; Selesai</p>
            </div>
            <div class="p-4 rounded-xl border border-slate-200 bg-white">
                <div class="flex items-center space-x-2 text-slate-700 font-bold text-sm">
                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-xs">2</span>
                    <span>Isi Biodata</span>
                </div>
                <p class="text-xs text-amber-600 mt-1 font-medium">Belum Lengkap</p>
            </div>
            <div class="p-4 rounded-xl border border-slate-200 bg-white">
                <div class="flex items-center space-x-2 text-slate-700 font-bold text-sm">
                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-xs">3</span>
                    <span>Upload Berkas</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">KK, Akta, Rapor</p>
            </div>
            <div class="p-4 rounded-xl border border-slate-200 bg-white">
                <div class="flex items-center space-x-2 text-slate-700 font-bold text-sm">
                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-xs">4</span>
                    <span>Verifikasi & Ujian</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Tahap Wawancara</p>
            </div>
        </div>
    </div>

    <!-- Quick Action Links -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <a href="{{ route('siswa.biodata') }}" class="bg-white p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-md transition group">
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600">Lengkapi Biodata</h3>
            <p class="text-xs text-slate-500 mt-1">Data diri, alamat, asal sekolah & data wali</p>
        </a>
        <a href="{{ route('siswa.dokumen') }}" class="bg-white p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-md transition group">
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600">Upload Dokumen Persyaratan</h3>
            <p class="text-xs text-slate-500 mt-1">Upload scan berkas format PDF/JPG</p>
        </a>
        <a href="{{ route('siswa.pembayaran') }}" class="bg-white p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-md transition group">
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600">Bukti Pembayaran</h3>
            <p class="text-xs text-slate-500 mt-1">Upload bukti transfer pendaftaran</p>
        </a>
        <a href="{{ route('siswa.status') }}" class="bg-white p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-md transition group">
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600">Status Kelulusan</h3>
            <p class="text-xs text-slate-500 mt-1">Cek hasil seleksi penerimaan</p>
        </a>
        <a href="{{ route('siswa.cetak-kartu') }}" class="bg-white p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-md transition group">
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600">Cetak Kartu Ujian</h3>
            <p class="text-xs text-slate-500 mt-1">Download kartu tanda peserta tes</p>
        </a>
    </div>
</div>
@endsection
