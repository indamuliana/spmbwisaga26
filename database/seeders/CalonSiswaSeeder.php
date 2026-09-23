<?php

namespace Database\Seeders;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Models\CalonSiswa;
use App\Models\Jurusan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class CalonSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaUser = User::where('email', 'siswa@ppdb.test')->first();
        $unggulan = Program::where('nama_program', 'Unggulan')->first();
        $rpl = Jurusan::where('kode_jurusan', 'RPL')->first();

        if ($siswaUser) {
            CalonSiswa::updateOrCreate(
                ['user_id' => $siswaUser->id],
                [
                    'nisn' => '0081234567',
                    'nik_siswa' => '3273010101080001',
                    'nama_lengkap' => $siswaUser->name,
                    'asal_sekolah' => 'SMP Negeri 1 Bandung',
                    'program_id' => $unggulan?->id,
                    'jurusan_id' => $rpl?->id,
                    'hp_siswa' => '0812-3456-7890',     // Otomatis dinormalisasi menjadi 6281234567890
                    'hp_ayah' => '+6281298765432',     // Otomatis dinormalisasi menjadi 6281298765432
                    'hp_ibu' => '081311223344',        // Otomatis dinormalisasi menjadi 6281311223344
                    'nama_ayah' => 'Bambang Sutrisno',
                    'pekerjaan_ayah' => 'KARYAWAN SWASTA',
                    'penghasilan_ayah' => 2200000,
                    'nama_ibu' => 'Endang Sulastri',
                    'pekerjaan_ibu' => 'MENGURUS RUMAH TANGGA',
                    'penghasilan_ibu' => 0,
                    'jumlah_tanggungan' => 3,
                    'rata_rata_raport' => 87.50,
                    'nilai_raport' => [
                        'matematika' => [1 => 88, 2 => 85, 3 => 90, 4 => 86, 5 => 88],
                        'b_indo' => [1 => 86, 2 => 88, 3 => 87, 4 => 89, 5 => 90],
                        'b_inggris' => [1 => 84, 2 => 85, 3 => 88, 4 => 87, 5 => 86],
                        'pai' => [1 => 90, 2 => 92, 3 => 91, 4 => 93, 5 => 92],
                        'ipa' => [1 => 85, 2 => 86, 3 => 87, 4 => 85, 5 => 86],
                    ],
                    'prestasi' => [
                        [
                            'kategori' => 'Sains & Robotik',
                            'perolehan' => 'Juara 2 Lomba Karya Ilmiah Remaja',
                            'tingkat' => 'Prov',
                            'penyelenggara' => 'Dinas Pendidikan Provinsi Jawa Barat',
                        ],
                    ],
                    'referensi_promotor' => 'Alumni',
                    'detail_promotor' => 'Kak Fikri (Alumni Angkatan 2024)',
                    'status_pendaftaran' => StatusPendaftaran::MENUNGGU_WAWANCARA,
                    'status_kelulusan' => StatusKelulusan::PENDING,
                ]
            );
        }
    }
}
