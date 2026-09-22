<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesananSeragam extends Model
{
    use HasFactory;

    protected $table = 'pesanan_seragam';

    protected $fillable = [
        'calon_siswa_id',
        'seragam_id',
        'ukuran',
        'harga_saat_pesan',
    ];

    protected function casts(): array
    {
        return [
            'harga_saat_pesan' => 'float',
        ];
    }

    public function seragam(): BelongsTo
    {
        return $this->belongsTo(Seragam::class, 'seragam_id');
    }

    public function calonSiswa(): BelongsTo
    {
        return $this->belongsTo(CalonSiswa::class, 'calon_siswa_id');
    }
}
