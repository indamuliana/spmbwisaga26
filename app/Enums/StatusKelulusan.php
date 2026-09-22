<?php

namespace App\Enums;

enum StatusKelulusan: string
{
    case PENDING = 'Pending';
    case DITERIMA = 'Diterima';
    case CADANGAN = 'Cadangan';
    case DITOLAK = 'Ditolak';
    case MENGUNDURKAN_DIRI = 'Mengundurkan_Diri';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Sedang Diproses',
            self::DITERIMA => 'Selamat, Anda Diterima!',
            self::CADANGAN => 'Cadangan (Waiting List)',
            self::DITOLAK => 'Mohon Maaf, Belum Lulus',
            self::MENGUNDURKAN_DIRI => 'Mengundurkan Diri',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::PENDING => 'bg-slate-100 text-slate-700 border-slate-200',
            self::DITERIMA => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            self::CADANGAN => 'bg-amber-100 text-amber-800 border-amber-200',
            self::DITOLAK => 'bg-rose-100 text-rose-800 border-rose-200',
            self::MENGUNDURKAN_DIRI => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
