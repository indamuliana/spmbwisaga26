<?php

namespace App\Enums;

enum StatusPendaftaran: string
{
    case REGISTER = 'Register';
    case BAYAR_SELEKSI = 'Bayar_Seleksi';
    case ISI_BIODATA_SISWA = 'Isi_Biodata_Siswa';
    case ISI_BIODATA_ORTU = 'Isi_Biodata_Ortu';
    case ISI_RAPORT = 'Isi_Raport';
    case MENUNGGU_WAWANCARA = 'Menunggu_Wawancara';
    case SELESAI_WAWANCARA = 'Selesai_Wawancara';
    case PENGUMUMAN = 'Pengumuman';
    case DAFTAR_ULANG = 'Daftar_Ulang';

    public function label(): string
    {
        return match ($this) {
            self::REGISTER => 'Pembuatan Akun Selesai',
            self::BAYAR_SELEKSI => 'Pembayaran Biaya Seleksi',
            self::ISI_BIODATA_SISWA => 'Pengisian Biodata Siswa',
            self::ISI_BIODATA_ORTU => 'Pengisian Data Orang Tua',
            self::ISI_RAPORT => 'Input Nilai Rapor & Prestasi',
            self::MENUNGGU_WAWANCARA => 'Menunggu Jadwal Wawancara',
            self::SELESAI_WAWANCARA => 'Selesai Tahap Uji Wawancara',
            self::PENGUMUMAN => 'Pengumuman Hasil Seleksi',
            self::DAFTAR_ULANG => 'Daftar Ulang & Registrasi Final',
        };
    }

    public function stepNumber(): int
    {
        return match ($this) {
            self::REGISTER => 1,
            self::BAYAR_SELEKSI => 2,
            self::ISI_BIODATA_SISWA => 3,
            self::ISI_BIODATA_ORTU => 4,
            self::ISI_RAPORT => 5,
            self::MENUNGGU_WAWANCARA => 6,
            self::SELESAI_WAWANCARA => 7,
            self::PENGUMUMAN => 8,
            self::DAFTAR_ULANG => 9,
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::REGISTER, self::BAYAR_SELEKSI => 'bg-slate-100 text-slate-700 border-slate-200',
            self::ISI_BIODATA_SISWA, self::ISI_BIODATA_ORTU, self::ISI_RAPORT => 'bg-blue-100 text-blue-800 border-blue-200',
            self::MENUNGGU_WAWANCARA => 'bg-amber-100 text-amber-800 border-amber-200',
            self::SELESAI_WAWANCARA => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            self::PENGUMUMAN => 'bg-purple-100 text-purple-800 border-purple-200',
            self::DAFTAR_ULANG => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        };
    }
}
