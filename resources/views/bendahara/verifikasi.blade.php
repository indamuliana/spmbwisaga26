@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Verifikasi Pembayaran Biaya Seleksi</h1>
            <p class="text-sm text-slate-500 mt-1">Pemeriksaan bukti transfer bank dan persetujuan (ACC) pendaftaran siswa baru.</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
            Hak Akses: Bendahara Keuangan
        </span>
    </div>

    <livewire:bendahara.verifikasi-pembayaran />
</div>
@endsection
