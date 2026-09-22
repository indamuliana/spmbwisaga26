<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    use HasFactory;

    protected $table = 'gelombang';

    protected $fillable = [
        'nama',
        'tgl_mulai',
        'tgl_selesai',
        'diskon_persen',
        'diskon_nominal',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tgl_mulai' => 'date',
            'tgl_selesai' => 'date',
            'diskon_persen' => 'float',
            'diskon_nominal' => 'float',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Cek apakah gelombang sedang aktif dan tanggalnya berlaku hari ini.
     */
    public function isActiveNow(): bool
    {
        $today = Carbon::today();

        return $this->is_active &&
               $today->greaterThanOrEqualTo($this->tgl_mulai) &&
               $today->lessThanOrEqualTo($this->tgl_selesai);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrentlyOpen(Builder $query): Builder
    {
        $today = Carbon::today()->toDateString();

        return $query->where('is_active', true)
            ->whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_selesai', '>=', $today);
    }
}
