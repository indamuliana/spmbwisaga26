<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case BENDAHARA = 'bendahara';
    case PEWAWANCARA = 'pewawancara';
    case SISWA = 'siswa';
    case KEPSEK = 'kepsek';

    /**
     * Human-friendly label for each role.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::BENDAHARA => 'Bendahara',
            self::PEWAWANCARA => 'Pewawancara',
            self::SISWA => 'Calon Siswa',
            self::KEPSEK => 'Kepala Sekolah',
        };
    }

    /**
     * Tailwind badge colors.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::ADMIN => 'bg-red-100 text-red-800 border-red-200',
            self::BENDAHARA => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            self::PEWAWANCARA => 'bg-amber-100 text-amber-800 border-amber-200',
            self::SISWA => 'bg-sky-100 text-sky-800 border-sky-200',
            self::KEPSEK => 'bg-purple-100 text-purple-800 border-purple-200',
        };
    }
}
