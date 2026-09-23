@extends('layouts.app')

@section('content')

<style>
/* Bendahara Dashboard Styles */
.bendahara-dash { font-family: 'Inter', sans-serif; }

/* ── NAVIGASI MASTER (horizontal tab bar) ── */
.master-nav-bar {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 10px 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.master-nav-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    white-space: nowrap;
}
.master-nav-item:hover {
    background: #ecfdf5;
    color: #059669;
    border-color: #a7f3d0;
    text-decoration: none;
}
.master-nav-item.active {
    background: linear-gradient(135deg, #059669, #10b981);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 3px 10px rgba(16,185,129,0.35);
}
.master-nav-item.alert-item {
    background: #fffbeb;
    color: #92400e;
    border-color: #fcd34d;
}
.master-nav-item.alert-item:hover {
    background: #fef3c7;
}
.nav-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; display: inline-block; }
.nav-pulse { animation: pulse-dot 1.5s ease-in-out infinite; }
@keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:0.3} }

/* ── STATS CARDS ── */
.stat-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e8edf5;
    padding: 22px 24px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    transition: all 0.25s ease;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.07); }
.stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.stat-number { font-size: 2rem; font-weight: 900; line-height: 1; }
.stat-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em; color: #94a3b8; margin-bottom: 4px; }
.stat-sub { font-size: 0.75rem; color: #94a3b8; margin-top: 4px; }

/* ── TAHAP REKAP ── */
.tahap-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 14px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    transition: all 0.25s ease;
}
.tahap-card:hover { box-shadow: 0 8px 20px rgba(0,0,0,0.06); border-color: #a7f3d0; }
.tahap-number {
    font-size: 1.5rem;
    font-weight: 900;
    min-width: 48px;
    text-align: right;
}
.tahap-bar {
    height: 6px;
    border-radius: 3px;
    background: #e2e8f0;
    margin-top: 6px;
    overflow: hidden;
}
.tahap-bar-fill {
    height: 100%;
    border-radius: 3px;
    background: linear-gradient(90deg, #059669, #34d399);
    transition: width 1s ease;
}

/* ── TABLE ── */
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table thead th {
    background: #f0fdf4;
    padding: 12px 14px;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #94a3b8;
    border-bottom: 1px solid #e2e8f0;
}
.dash-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
}
.dash-table tbody tr:hover { background: #f0fdf4; }
.dash-table tbody td {
    padding: 12px 14px;
    font-size: 0.83rem;
    color: #334155;
    vertical-align: middle;
}
.dash-table tbody tr:last-child { border-bottom: none; }

.badge-sm {
    display: inline-block;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 0.69rem;
    font-weight: 700;
    border: 1px solid transparent;
}
</style>

<div class="bendahara-dash space-y-6">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Dashboard Bendahara</h1>
            <p class="text-sm text-slate-500 mt-0.5">Verifikasi pembayaran & rekapitulasi keuangan PPDB 2026/2027</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse inline-block"></span>
                Bendahara Keuangan
            </span>
            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                🕐 {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- ── NAVIGASI MENU BAR ── --}}
    <div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5">Menu Keuangan</p>
        <div class="master-nav-bar">
            <a href="{{ route('bendahara.dashboard') }}" class="master-nav-item active" id="nav-dashboard">
                🏠 Dashboard
            </a>
            <a href="{{ route('bendahara.verifikasi') }}" class="master-nav-item alert-item" id="nav-verifikasi">
                <span class="nav-dot nav-pulse"></span>
                Verifikasi Pembayaran
                @if($stats['menunggu_verifikasi'] > 0)
                    <span style="background:#ef4444;color:#fff;border-radius:999px;padding:1px 7px;font-size:0.65rem;font-weight:800;">{{ $stats['menunggu_verifikasi'] }}</span>
                @endif
            </a>
            <a href="{{ route('bendahara.rekap') }}" class="master-nav-item" id="nav-rekap">
                📊 Rekapitulasi Keuangan
            </a>
        </div>
    </div>

    {{-- ── STATS CARDS ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff;">📋</div>
            <div>
                <div class="stat-label">Total Pendaftar</div>
                <div class="stat-number" style="color:#4f46e5;">{{ $stats['total'] }}</div>
                <div class="stat-sub">Semua calon siswa</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ecfdf5;">✅</div>
            <div>
                <div class="stat-label">Sudah Bayar</div>
                <div class="stat-number" style="color:#059669;">{{ $stats['sudah_bayar'] }}</div>
                <div class="stat-sub">Lanjut ke tahap berikutnya</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">⏳</div>
            <div>
                <div class="stat-label">Menunggu Verifikasi</div>
                <div class="stat-number" style="color:#d97706;">{{ $stats['menunggu_verifikasi'] }}</div>
                <div class="stat-sub">Bukti sudah diunggah</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff1f2;">⚠️</div>
            <div>
                <div class="stat-label">Belum Bayar</div>
                <div class="stat-number" style="color:#e11d48;">{{ $stats['belum_bayar'] }}</div>
                <div class="stat-sub">Belum unggah bukti</div>
            </div>
        </div>
    </div>

    {{-- ── REKAP PENDAFTAR PER TAHAP ── --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <div class="mb-5">
            <h2 class="text-base font-black text-slate-900">Rekap Pendaftar per Tahap</h2>
            <p class="text-xs text-slate-500 mt-0.5">Distribusi calon siswa berdasarkan tahapan alur pendaftaran</p>
        </div>

        @php $totalForBar = max($stats['total'], 1); @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($rekapTahap as $i => $tahap)
            @php
                $pct = round(($tahap['jumlah'] / $totalForBar) * 100);
                $txtColor = match($i) {
                    0 => '#475569', 1 => '#d97706', 2,3,4 => '#2563eb',
                    5 => '#92400e', 6 => '#4338ca', 7 => '#7c3aed', default => '#065f46',
                };
                $bgColor = match($i) {
                    0 => '#f1f5f9', 1 => '#fffbeb', 2,3,4 => '#eff6ff',
                    5 => '#fef9c3', 6 => '#e0e7ff', 7 => '#faf5ff', default => '#ecfdf5',
                };
            @endphp
            <div class="tahap-card">
                <div style="flex:1; min-width:0;">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="badge-sm" style="background:{{ $bgColor }};color:{{ $txtColor }};">Tahap {{ $i + 1 }}</span>
                    </div>
                    <div class="font-semibold text-slate-800 text-sm leading-tight" title="{{ $tahap['label'] }}">{{ $tahap['label'] }}</div>
                    <div class="tahap-bar mt-2">
                        <div class="tahap-bar-fill" style="width:{{ $pct }}%;background:linear-gradient(90deg,{{ $txtColor }},{{ $txtColor }}88);"></div>
                    </div>
                    <div class="text-xs text-slate-400 mt-1">{{ $pct }}% dari total</div>
                </div>
                <div class="tahap-number" style="color:{{ $txtColor }};">{{ $tahap['jumlah'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── TABEL SELURUH PENDAFTAR ── --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-base font-black text-slate-900">Daftar Seluruh Pendaftar</h2>
                <p class="text-xs text-slate-500 mt-0.5">Total {{ $pendaftars->count() }} calon peserta didik terdaftar</p>
            </div>
            <a href="{{ route('bendahara.verifikasi') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition">
                ✅ Verifikasi Pembayaran
            </a>
        </div>

        <div style="overflow-x:auto;">
            @if($pendaftars->count() > 0)
            <table class="dash-table">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>No. Pendaftar</th>
                        <th>Nama Lengkap</th>
                        <th>Jurusan</th>
                        <th>Status Pembayaran</th>
                        <th>Nominal Transfer</th>
                        <th>Tahap Saat Ini</th>
                        <th>Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftars as $idx => $p)
                    @php
                        $sp = $p->status_pendaftaran;
                        $isPaid = $sp && $sp->stepNumber() > 2;
                        $hasBukti = !is_null($p->bukti_bayar_seleksi);
                    @endphp
                    <tr>
                        <td class="text-slate-400 font-mono text-xs">{{ $idx + 1 }}</td>
                        <td>
                            <span class="font-mono font-bold text-emerald-600 text-xs">{{ $p->nomor_pendaftar ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="font-semibold text-slate-800">{{ $p->nama_lengkap }}</div>
                            <div class="text-xs text-slate-400">{{ $p->user?->email ?? '-' }}</div>
                        </td>
                        <td class="text-xs text-slate-600">{{ $p->jurusan?->nama_jurusan ?? '—' }}</td>
                        <td>
                            @if($isPaid)
                                <span class="badge-sm bg-emerald-100 text-emerald-800 border-emerald-200">✓ Lunas</span>
                            @elseif($hasBukti)
                                <span class="badge-sm bg-amber-100 text-amber-800 border-amber-200">⏳ Menunggu Verifikasi</span>
                            @else
                                <span class="badge-sm bg-slate-100 text-slate-600 border-slate-200">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="font-mono text-xs text-slate-700">
                            @if($p->nominal_transfer_seleksi)
                                Rp {{ number_format($p->nominal_transfer_seleksi, 0, ',', '.') }}
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td>
                            @if($sp)
                                <span class="badge-sm {{ $sp->badgeClasses() }}">{{ $sp->label() }}</span>
                            @else
                                <span class="text-slate-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="text-xs text-slate-400">{{ $p->created_at?->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="py-16 text-center">
                <div style="font-size:3rem;">📋</div>
                <div class="mt-3 font-semibold text-slate-600">Belum ada pendaftar</div>
                <div class="text-sm text-slate-400 mt-1">Data pendaftar akan tampil di sini setelah ada yang mendaftar.</div>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
