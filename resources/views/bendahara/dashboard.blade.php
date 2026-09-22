@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Bendahara</h1>
            <p class="text-sm text-slate-500 mt-1">Verifikasi pembayaran biaya formulir pendaftaran dan daftar ulang.</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
            Hak Akses: Bendahara Keuangan
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Menunggu Konfirmasi</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-2">Rp 0</p>
            <p class="text-xs text-slate-500 mt-1">0 Bukti Transfer Diunggah</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Total Pembayaran Masuk</p>
            <p class="text-3xl font-extrabold text-emerald-600 mt-2">Rp 0</p>
            <p class="text-xs text-slate-500 mt-1">Status: Terverifikasi Lunas</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <p class="text-xs font-semibold uppercase text-slate-400">Pembayaran Ditolak</p>
            <p class="text-3xl font-extrabold text-rose-600 mt-2">0</p>
            <p class="text-xs text-slate-500 mt-1">Bukti Transfer Tidak Sesuai</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <h2 class="text-base font-bold text-slate-900 mb-4">Aksi Cepat Keuangan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('bendahara.verifikasi') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-emerald-700">Verifikasi Pembayaran Formulir</span>
                <p class="text-xs text-slate-500 mt-1">Validasi bukti transfer dan set status lunas</p>
            </a>
            <a href="{{ route('bendahara.rekap') }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 transition group">
                <span class="font-semibold text-sm text-slate-800 group-hover:text-emerald-700">Rekapitulasi Keuangan PPDB</span>
                <p class="text-xs text-slate-500 mt-1">Laporan harian & mingguan penerimaan biaya PPDB</p>
            </a>
        </div>
    </div>
</div>
@endsection
