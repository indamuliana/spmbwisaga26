<?php

namespace Database\Seeders;

use App\Models\DokumenKesepahaman;
use App\Models\KomponenBiaya;
use App\Models\Program;
use App\Models\Seragam;
use Illuminate\Database\Seeder;

class TagihanDinamisSeeder extends Seeder
{
    public function run(): void
    {
        $reguler = Program::where('nama_program', 'Reguler')->first();
        $unggulan = Program::where('nama_program', 'Unggulan')->first();

        $gelombang1 = \App\Models\Gelombang::where('nama', 'like', '%1%')->first();
        $gelombang2 = \App\Models\Gelombang::where('nama', 'like', '%2%')->first();
        $gelombang3 = \App\Models\Gelombang::where('nama', 'like', '%3%')->first();

        // 1. Komponen Biaya (Universal vs Program Tertentu)
        $biayaList = [
            // Seleksi berlaku universal (program_id = null, jurusan_id = null, gelombang_id = null)
            [
                'nama_biaya' => 'Biaya Seleksi & Tes Masuk',
                'program_id' => null,
                'jurusan_id' => null,
                'gelombang_id' => null,
                'nominal' => 250000,
                'keterangan' => 'Wajib untuk seluruh calon siswa pendaftar PPDB.',
            ],
            
            // DSP Reguler Gelombang 1
            [
                'nama_biaya' => 'DSP Reguler (Gelombang 1)',
                'program_id' => $reguler?->id,
                'jurusan_id' => null,
                'gelombang_id' => $gelombang1?->id,
                'nominal' => 3000000, // Diskon 500k dari Gelombang 1
                'keterangan' => 'DSP Reguler Khusus Pendaftar Gelombang 1 (Early Bird).',
            ],
            // DSP Reguler Gelombang 2
            [
                'nama_biaya' => 'DSP Reguler (Gelombang 2)',
                'program_id' => $reguler?->id,
                'jurusan_id' => null,
                'gelombang_id' => $gelombang2?->id,
                'nominal' => 3500000,
                'keterangan' => 'DSP Reguler Pendaftar Gelombang 2.',
            ],
            // DSP Reguler Gelombang 3
            [
                'nama_biaya' => 'DSP Reguler (Gelombang 3)',
                'program_id' => $reguler?->id,
                'jurusan_id' => null,
                'gelombang_id' => $gelombang3?->id,
                'nominal' => 4000000,
                'keterangan' => 'DSP Reguler Pendaftar Gelombang 3.',
            ],

            // DSP Unggulan Gelombang 1
            [
                'nama_biaya' => 'DSP Unggulan (Gelombang 1)',
                'program_id' => $unggulan?->id,
                'jurusan_id' => null,
                'gelombang_id' => $gelombang1?->id,
                'nominal' => 4500000,
                'keterangan' => 'DSP Unggulan Khusus Pendaftar Gelombang 1 (Early Bird).',
            ],
            // DSP Unggulan Gelombang 2
            [
                'nama_biaya' => 'DSP Unggulan (Gelombang 2)',
                'program_id' => $unggulan?->id,
                'jurusan_id' => null,
                'gelombang_id' => $gelombang2?->id,
                'nominal' => 5000000,
                'keterangan' => 'DSP Unggulan Pendaftar Gelombang 2.',
            ],
            // DSP Unggulan Gelombang 3
            [
                'nama_biaya' => 'DSP Unggulan (Gelombang 3)',
                'program_id' => $unggulan?->id,
                'jurusan_id' => null,
                'gelombang_id' => $gelombang3?->id,
                'nominal' => 5500000,
                'keterangan' => 'DSP Unggulan Pendaftar Gelombang 3.',
            ],

            // SPP Bulan Pertama Reguler
            [
                'nama_biaya' => 'SPP Bulan Pertama (Reguler)',
                'program_id' => $reguler?->id,
                'jurusan_id' => null,
                'gelombang_id' => null,
                'nominal' => 350000,
                'keterangan' => 'Iuran operasional bulanan pertama.',
            ],
            // SPP Bulan Pertama Unggulan
            [
                'nama_biaya' => 'SPP Bulan Pertama (Unggulan)',
                'program_id' => $unggulan?->id,
                'jurusan_id' => null,
                'gelombang_id' => null,
                'nominal' => 600000,
                'keterangan' => 'Iuran operasional bulanan kelas unggulan & sertifikasi.',
            ],
            // Asrama hanya untuk Unggulan
            [
                'nama_biaya' => 'Biaya Asrama & Makan (Bulan Pertama)',
                'program_id' => $unggulan?->id,
                'jurusan_id' => null,
                'gelombang_id' => null,
                'nominal' => 1200000,
                'keterangan' => 'Khusus Program Unggulan Berasrama (Boarding School).',
            ],
        ];

        foreach ($biayaList as $b) {
            KomponenBiaya::updateOrCreate(
                [
                    'nama_biaya' => $b['nama_biaya'],
                    'program_id' => $b['program_id'],
                    'gelombang_id' => $b['gelombang_id'] ?? null,
                ],
                [
                    'jurusan_id' => $b['jurusan_id'],
                    'nominal' => $b['nominal'],
                    'keterangan' => $b['keterangan'],
                    'is_active' => true,
                ]
            );
        }

        // 2. Data Master Seragam
        $seragamList = [
            [
                'nama_item' => 'Seragam Putih Abu-abu (Putra)',
                'kategori_gender' => 'L',
                'wajib_sekolah' => true,
                'harga' => 175000,
            ],
            [
                'nama_item' => 'Seragam Putih Abu-abu (Putri)',
                'kategori_gender' => 'P',
                'wajib_sekolah' => true,
                'harga' => 195000,
            ],
            [
                'nama_item' => 'Seragam Pramuka Lengkap (Putra)',
                'kategori_gender' => 'L',
                'wajib_sekolah' => true,
                'harga' => 185000,
            ],
            [
                'nama_item' => 'Seragam Pramuka Lengkap (Putri)',
                'kategori_gender' => 'P',
                'wajib_sekolah' => true,
                'harga' => 205000,
            ],
            [
                'nama_item' => 'Batik Khas Sekolah',
                'kategori_gender' => 'unisex',
                'wajib_sekolah' => true,
                'harga' => 150000,
            ],
            [
                'nama_item' => 'Pakaian Olahraga Sekolah',
                'kategori_gender' => 'unisex',
                'wajib_sekolah' => true,
                'harga' => 160000,
            ],
            [
                'nama_item' => 'Jas Almamater Sekolah',
                'kategori_gender' => 'unisex',
                'wajib_sekolah' => true,
                'harga' => 175000,
            ],
            [
                'nama_item' => 'Jilbab / Kerudung Sekolah (Set 3 Pcs)',
                'kategori_gender' => 'P',
                'wajib_sekolah' => false,
                'harga' => 100000,
            ],
        ];

        foreach ($seragamList as $s) {
            Seragam::updateOrCreate(
                ['nama_item' => $s['nama_item']],
                [
                    'kategori_gender' => $s['kategori_gender'],
                    'wajib_sekolah' => $s['wajib_sekolah'],
                    'harga' => $s['harga'],
                ]
            );
        }

        // 3. Dokumen Kesepahaman
        $kesepahamanList = [
            [
                'program_id' => null, // Universal
                'butir_pernyataan' => 'Bersedia mentaati seluruh tata tertib, kode etik, dan peraturan akademik yang berlaku di sekolah.',
                'urutan' => 1,
            ],
            [
                'program_id' => null, // Universal
                'butir_pernyataan' => 'Sanggup melunasi seluruh kewajiban administrasi keuangan pendaftaran dan daftar ulang tepat pada waktu yang ditentukan.',
                'urutan' => 2,
            ],
            [
                'program_id' => null, // Universal
                'butir_pernyataan' => 'Menjaga nama baik almamater, bapak/ibu guru, dan sesama peserta didik baik di lingkungan internal maupun eksternal sekolah.',
                'urutan' => 3,
            ],
            [
                'program_id' => $unggulan?->id, // Khusus Unggulan
                'butir_pernyataan' => 'Bersedia tinggal di asrama sekolah (Boarding School) serta mengikuti seluruh rangkaian disiplin kepesantrenan dan pembinaan karakter.',
                'urutan' => 4,
            ],
            [
                'program_id' => $unggulan?->id, // Khusus Unggulan
                'butir_pernyataan' => 'Wajib menggunakan bahasa pengantar internasional (Bahasa Inggris dan Bahasa Arab) dalam komunikasi harian di asrama sesuai zona hari yang ditetapkan.',
                'urutan' => 5,
            ],
        ];

        foreach ($kesepahamanList as $k) {
            DokumenKesepahaman::updateOrCreate(
                [
                    'program_id' => $k['program_id'],
                    'urutan' => $k['urutan'],
                ],
                [
                    'butir_pernyataan' => $k['butir_pernyataan'],
                    'is_active' => true,
                ]
            );
        }
    }
}
