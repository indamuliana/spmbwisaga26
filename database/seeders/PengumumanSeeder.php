<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengumuman::create([
            'judul' => 'Pendaftaran Gelombang 1 Dibuka!',
            'konten' => 'Segera daftarkan diri Anda sebelum kuota penuh. Dapatkan potongan biaya untuk 50 pendaftar pertama.',
            'is_aktif' => true,
        ]);
        
        Pengumuman::create([
            'judul' => 'Ujian Seleksi PPDB',
            'konten' => 'Siapkan diri Anda! Ujian wawancara dan tes akademik akan dilaksanakan pada bulan depan.',
            'is_aktif' => true,
        ]);
        
        Pengumuman::create([
            'judul' => 'Pilih Jurusan Masa Depanmu',
            'konten' => 'SMK Wikrama memiliki jurusan unggulan: PPLG, MPLB, HTL, DKV, KLN, dan BDP. Temukan passion Anda!',
            'is_aktif' => true,
        ]);
    }
}
