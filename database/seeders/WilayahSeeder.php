<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    /**
     * Sumber data: cahyadsn/wilayah
     * Standar Kepmendagri terbaru (seluruh Indonesia sampai Desa/Kelurahan).
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('=== IMPORT DATA WILAYAH INDONESIA LENGKAP (KEPMENDAGRI) ===');
        $this->command->info('Sumber: https://raw.githubusercontent.com/cahyadsn/wilayah/master/db/wilayah.sql');
        $this->command->info('');

        $localSql = storage_path('wilayah.sql');

        if (! file_exists($localSql) || filesize($localSql) < 1000000) {
            $this->command->info('Mengunduh master data wilayah.sql (±12 MB) ...');
            $url = 'https://raw.githubusercontent.com/cahyadsn/wilayah/master/db/wilayah.sql';
            $fp = fopen($localSql, 'w+');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $this->command->info('Unduhan selesai: ' . round(filesize($localSql) / 1024 / 1024, 2) . ' MB.');
        } else {
            $this->command->info('Menggunakan file cache local: ' . round(filesize($localSql) / 1024 / 1024, 2) . ' MB.');
        }

        $this->command->warn('Mengosongkan tabel wilayah & mereset referensi di calon_siswa...');
        DB::statement('PRAGMA foreign_keys = OFF');
        DB::table('calon_siswa')->update([
            'provinsi_id'  => null,
            'kota_kab_id'  => null,
            'kecamatan_id' => null,
            'desa_id'      => null,
        ]);
        DB::table('wilayah')->delete();
        DB::statement('PRAGMA foreign_keys = ON');

        $this->command->info('Membaca & memproses baris data...');

        $fp = fopen($localSql, 'r');
        if (! $fp) {
            $this->command->error('Gagal membuka file ' . $localSql);
            return;
        }

        // Peta memory: kode string => database integer ID
        // Contoh: '11' => 1, '11.01' => 2, '11.01.01' => 3
        $kodeMap = [];
        $totalProv = 0;
        $totalKab  = 0;
        $totalKec  = 0;
        $totalDesa = 0;

        $batch = [];
        $now = now();

        DB::beginTransaction();

        while (($line = fgets($fp)) !== false) {
            $line = trim($line);
            if (! str_starts_with($line, "('")) {
                continue;
            }

            // Pola: ('11.01.01.2001','Keude Bakongan'), atau baris terakhir dengan ';'
            $line = rtrim($line, ';,');
            $line = trim($line, '()');

            // Pisahkan kode dan nama
            // ('kode', 'nama')
            $parts = explode("','", $line, 2);
            if (count($parts) < 2) {
                continue;
            }

            $kode = trim($parts[0], "' ");
            $nama = strtoupper(trim(trim($parts[1], "' "), '"'));
            // Tangani escape single quote SQL \' atau ''
            $nama = str_replace(["''", "\\'"], "'", $nama);

            $dots = substr_count($kode, '.');

            if ($dots === 0) {
                // PROVINSI (misal: 11)
                $level = 'provinsi';
                $parentId = null;
                $totalProv++;
            } elseif ($dots === 1) {
                // KOTA / KABUPATEN (misal: 11.01)
                $level = 'kota_kab';
                $parentKode = substr($kode, 0, strrpos($kode, '.'));
                $parentId = $kodeMap[$parentKode] ?? null;
                $totalKab++;
            } elseif ($dots === 2) {
                // KECAMATAN (misal: 11.01.01)
                $level = 'kecamatan';
                $parentKode = substr($kode, 0, strrpos($kode, '.'));
                $parentId = $kodeMap[$parentKode] ?? null;
                $totalKec++;
            } else {
                // DESA / KELURAHAN (misal: 11.01.01.2001)
                $level = 'desa';
                $parentKode = substr($kode, 0, strrpos($kode, '.'));
                $parentId = $kodeMap[$parentKode] ?? null;
                $totalDesa++;
            }

            // Insert single row for parent levels agar mendapat insert ID
            // Untuk desa bisa di-batch
            if ($level !== 'desa') {
                $id = DB::table('wilayah')->insertGetId([
                    'parent_id'  => $parentId,
                    'level'      => $level,
                    'kode'       => $kode,
                    'nama'       => $nama,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $kodeMap[$kode] = $id;
            } else {
                $batch[] = [
                    'parent_id'  => $parentId,
                    'level'      => 'desa',
                    'kode'       => $kode,
                    'nama'       => $nama,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                if (count($batch) >= 1000) {
                    DB::table('wilayah')->insert($batch);
                    $batch = [];
                }
            }
        }

        if (! empty($batch)) {
            DB::table('wilayah')->insert($batch);
        }

        DB::commit();
        fclose($fp);

        $this->command->info('');
        $this->command->info('=== IMPORT SELESAI DENGAN SUKSES! ===');
        $this->command->info("Provinsi       : {$totalProv}");
        $this->command->info("Kabupaten/Kota : {$totalKab}");
        $this->command->info("Kecamatan      : {$totalKec}");
        $this->command->info("Desa/Kelurahan : {$totalDesa}");
        $this->command->info('');
    }
}
