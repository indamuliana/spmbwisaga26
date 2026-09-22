<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wawancara extends Model
{
    use HasFactory;

    protected $table = 'wawancara';

    protected $fillable = [
        'pewawancara_id',
        'calon_siswa_id',
        'jadwal',
        'link_meet',
        'nilai_fisik_rambut',
        'nilai_fisik_seragam',
        'kemampuan_quran',
        'jumlah_juz',
        'catatan_rahasia',
    ];

    protected function casts(): array
    {
        return [
            'jadwal' => 'datetime',
            'jumlah_juz' => 'integer',
        ];
    }

    /**
     * Relasi ke User bertindak sebagai Pewawancara
     */
    public function pewawancara(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pewawancara_id');
    }

    /**
     * Relasi ke Calon Siswa yang diwawancarai
     */
    public function calonSiswa(): BelongsTo
    {
        return $this->belongsTo(CalonSiswa::class, 'calon_siswa_id');
    }
}
