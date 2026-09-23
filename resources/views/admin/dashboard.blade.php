@extends('layouts.app')

@section('content')

<style>
/* Admin Dashboard Styles */
.admin-dash { font-family: 'Inter', sans-serif; }

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
    background: #eef2ff;
    color: #4f46e5;
    border-color: #c7d2fe;
    text-decoration: none;
}
.master-nav-item.active {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 3px 10px rgba(99,102,241,0.3);
}
.master-nav-item.warning {
    background: #fffbeb;
    color: #92400e;
    border-color: #fcd34d;
}
.master-nav-item.warning:hover {
    background: #fef3c7;
    color: #78350f;
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
.tahap-card:hover { box-shadow: 0 8px 20px rgba(0,0,0,0.06); border-color: #c7d2fe; }
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
    background: linear-gradient(90deg, #6366f1, #818cf8);
    transition: width 1s ease;
}

/* ── TABLE ── */
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table thead th {
    background: #f8faff;
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
.dash-table tbody tr:hover { background: #f8faff; }
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
.table-scroll {
    overflow-x: auto;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
}
</style>

<div class="admin-dash space-y-6">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Dashboard Administrator</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manajemen & Rekapitulasi PPDB SMK Wikrama 1 Garut — 2026/2027</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse inline-block"></span>
                Super Administrator
            </span>
            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                🕐 {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- ── NAVIGASI MASTER (Horizontal Menu Bar) ── --}}
    <div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5">Navigasi Master Data</p>
        <div class="master-nav-bar">
            <a href="{{ route('admin.dashboard') }}" class="master-nav-item active" id="nav-dashboard">
                🏠 Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="master-nav-item" id="nav-users">
                👥 Manajemen Pengguna
            </a>
            <a href="{{ route('admin.gelombang') }}" class="master-nav-item" id="nav-gelombang">
                📅 Gelombang PPDB
            </a>
            <a href="{{ route('admin.jurusan') }}" class="master-nav-item" id="nav-jurusan">
                🎓 Master Jurusan
            </a>
            <a href="{{ route('admin.penugasan-wawancara') }}" class="master-nav-item warning" id="nav-wawancara">
                <span class="nav-dot nav-pulse"></span>
                Penugasan Wawancara
            </a>
            <a href="{{ route('admin.pengumuman') }}" class="master-nav-item" id="nav-pengumuman">
                📣 Kelola Pengumuman
            </a>
            <a href="{{ route('admin.laporan') }}" class="master-nav-item" id="nav-laporan">
                📊 Laporan & Export
            </a>
        </div>
    </div>

    {{-- ── STATS CARDS ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff;">📋</div>
            <div>
                <div class="stat-label">Total Pendaftar</div>
                <div class="stat-number" style="color:#4f46e5;">{{ $stats['total'] }}</div>
                <div class="stat-sub">Semua status</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ecfdf5;">✅</div>
            <div>
                <div class="stat-label">Diterima</div>
                <div class="stat-number" style="color:#059669;">{{ $stats['diterima'] }}</div>
                <div class="stat-sub">Lulus seleksi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">⏳</div>
            <div>
                <div class="stat-label">Cadangan</div>
                <div class="stat-number" style="color:#d97706;">{{ $stats['cadangan'] }}</div>
                <div class="stat-sub">Waiting list</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff1f2;">❌</div>
            <div>
                <div class="stat-label">Ditolak</div>
                <div class="stat-number" style="color:#e11d48;">{{ $stats['ditolak'] }}</div>
                <div class="stat-sub">Tidak lolos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">👤</div>
            <div>
                <div class="stat-label">Pengguna Sistem</div>
                <div class="stat-number" style="color:#16a34a;">{{ $stats['pengguna'] }}</div>
                <div class="stat-sub">Semua role</div>
            </div>
        </div>
    </div>

    {{-- ── REKAP PENDAFTAR PER TAHAP ── --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-black text-slate-900">Rekap Pendaftar per Tahap</h2>
                <p class="text-xs text-slate-500 mt-0.5">Distribusi calon siswa berdasarkan tahapan alur pendaftaran</p>
            </div>
            @php $totalForBar = max($stats['total'], 1); @endphp
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($rekapTahap as $i => $tahap)
            @php
                $pct = round(($tahap['jumlah'] / $totalForBar) * 100);
                $colors = [
                    'bg:#f1f5f9;color:#475569', 'bg:#eff6ff;color:#2563eb',
                    'bg:#eff6ff;color:#1d4ed8', 'bg:#eff6ff;color:#1e40af',
                    'bg:#eff6ff;color:#1e3a8a', 'bg:#fef9c3;color:#92400e',
                    'bg:#e0e7ff;color:#4338ca', 'bg:#faf5ff;color:#7c3aed',
                    'bg:#ecfdf5;color:#065f46',
                ];
                $colorParts = explode(';', $colors[$i] ?? 'bg:#f1f5f9;color:#475569');
                $bgColor = str_replace('bg:', '', $colorParts[0]);
                $txtColor = str_replace('color:', '', $colorParts[1] ?? 'color:#475569');
            @endphp
            <div class="tahap-card">
                <div style="flex:1; min-width:0;">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="badge-sm" style="background:{{ $bgColor }};color:{{ $txtColor }};border-color:transparent;">
                            Tahap {{ $i + 1 }}
                        </span>
                    </div>
                    <div class="font-semibold text-slate-800 text-sm leading-tight truncate" title="{{ $tahap['label'] }}">{{ $tahap['label'] }}</div>
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
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-10 bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition rounded-lg">
                    📥 Export Data
                </a>
            </div>
        </div>

        <div class="table-scroll" style="border:none;border-radius:0;">
            @if($pendaftars->count() > 0)
            <table class="dash-table">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>No. Pendaftar</th>
                        <th>Nama Lengkap</th>
                        <th>Jurusan Pilihan</th>
                        <th>Tahap Pendaftaran</th>
                        <th>Status Kelulusan</th>
                        <th>Terdaftar</th>
                        <th style="width:80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftars as $idx => $p)
                    <tr>
                        <td class="text-slate-400 font-mono text-xs">{{ $idx + 1 }}</td>
                        <td>
                            <span class="font-mono font-bold text-indigo-600 text-xs">{{ $p->nomor_pendaftar ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="font-semibold text-slate-800">{{ $p->nama_lengkap }}</div>
                            <div class="text-xs text-slate-400">{{ $p->user?->email ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="text-xs text-slate-600">{{ $p->jurusan?->nama_jurusan ?? '—' }}</span>
                        </td>
                        <td>
                            @php
                                $sp = $p->status_pendaftaran;
                                $badgeSP = $sp ? $sp->badgeClasses() : 'bg-slate-100 text-slate-700 border-slate-200';
                                $labelSP = $sp ? $sp->label() : '-';
                            @endphp
                            <span class="badge-sm {{ $badgeSP }}">{{ $labelSP }}</span>
                        </td>
                        <td>
                            @php
                                $sk = $p->status_kelulusan;
                                $badgeSK = $sk ? $sk->badgeClasses() : 'bg-slate-100 text-slate-700 border-slate-200';
                                $labelSK = $sk ? $sk->value : '-';
                            @endphp
                            <span class="badge-sm {{ $badgeSK }}">{{ $labelSK }}</span>
                        </td>
                        <td class="text-xs text-slate-400">
                            {{ $p->created_at?->format('d/m/Y') ?? '-' }}
                        </td>
                        <td>
                            <button class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold transition">Detail</button>
                        </td>
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
