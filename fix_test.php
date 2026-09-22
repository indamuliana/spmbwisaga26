<?php

$file = 'tests/Feature/StudentRegistrationStepperTest.php';
$content = file_get_contents($file);

$fields = <<<PHP
->set('nik_siswa', '3273010101080005')
            ->set('no_kk', '3273010101080005')
            ->set('tempat_lahir', 'Bandung')
            ->set('tanggal_lahir', '2008-05-15')
            ->set('jenis_kelamin', 'L')
            ->set('kewarganegaraan', 'WNI')
            ->set('agama', 'Islam')
            ->set('asal_sekolah', 'SMPN 1 Bandung')
            ->set('alamat_detail', 'Jl. Merdeka No 123')
            ->set('kode_pos', '40111')
            ->set('status_tempat_tinggal', 'Bersama Orangtua')
            ->set('transportasi', 'Motor')
            ->set('jarak_ke_sekolah', '1-3 Km')
            ->set('waktu_tempuh', 15)
            ->set('tinggi_badan', 165)
            ->set('berat_badan', 55)
            ->set('golongan_darah', 'O')
            ->set('hobi', 'Membaca')
            ->set('cita_cita', 'Programmer / IT')
PHP;

$content = preg_replace("/->set\('nik_siswa', '3273010101080005'\).*?->set\('alamat_detail', 'Jl\. Merdeka No 123'\)/s", $fields, $content);

$fields2 = <<<PHP
->set('nik_siswa', '3273010101089999')
            ->set('no_kk', '3273010101089999')
            ->set('tempat_lahir', 'Jakarta')
            ->set('tanggal_lahir', '2008-08-08')
            ->set('jenis_kelamin', 'P')
            ->set('kewarganegaraan', 'WNI')
            ->set('agama', 'Islam')
            ->set('asal_sekolah', 'SMPN 2 Jakarta')
            ->set('alamat_detail', 'Jl. Sudirman No 12')
            ->set('kode_pos', '12345')
            ->set('status_tempat_tinggal', 'Bersama Orangtua')
            ->set('transportasi', 'Jalan Kaki')
            ->set('jarak_ke_sekolah', '< 1 Km')
            ->set('waktu_tempuh', 5)
            ->set('tinggi_badan', 160)
            ->set('berat_badan', 50)
            ->set('golongan_darah', 'A')
            ->set('hobi', 'Olahraga')
            ->set('cita_cita', 'Dokter')
PHP;

$content = preg_replace("/->set\('nik_siswa', '3273010101089999'\).*?->set\('alamat_detail', 'Jl\. Sudirman No 12'\)/s", $fields2, $content);

file_put_contents($file, $content);
echo "Done";

