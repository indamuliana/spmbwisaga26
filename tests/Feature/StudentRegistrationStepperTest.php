<?php

namespace Tests\Feature;

use App\Enums\StatusPendaftaran;
use App\Livewire\StudentRegistrationStepper;
use App\Models\CalonSiswa;
use App\Models\Program;
use App\Models\User;
use App\Models\Wilayah;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class StudentRegistrationStepperTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->seed(TagihanDinamisSeeder::class);
    }

    public function test_pendaftaran_page_is_accessible_and_contains_livewire_component(): void
    {
        $response = $this->get('/daftar');
        $response->assertStatus(200);
        $response->assertSeeLivewire('siswa.register-siswa');
    }

    public function test_step_1_creates_user_and_calon_siswa_and_authenticates(): void
    {
        $program = Program::where('nama_program', 'Reguler')->first();

        Livewire::test(StudentRegistrationStepper::class)
            ->set('nisn', '0098765432')
            ->set('nama_lengkap', 'Rizky Ramadhan')
            ->set('email', 'rizky.ramadhan@example.test')
            ->set('program_id', $program->id)
            ->set('referensi_promotor', 'Media Sosial (Instagram/TikTok)')
            ->set('detail_promotor', '@ppdb_school')
            ->set('hp_siswa', '081234567899')
            ->call('submitStep1')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 2);

        // 1. Verifikasi akun User terbuat dengan password = NISN
        $user = User::where('email', 'rizky.ramadhan@example.test')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Rizky Ramadhan', $user->name);
        $this->assertEquals('siswa', $user->role->value);
        $this->assertTrue(Hash::check('0098765432', $user->password));

        // 2. Verifikasi CalonSiswa terbuat dengan status Bayar_Seleksi
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->first();
        $this->assertNotNull($calonSiswa);
        $this->assertEquals('0098765432', $calonSiswa->nisn);
        $this->assertEquals('6281234567899', $calonSiswa->hp_siswa); // Terverifikasi mutator 628...
        $this->assertEquals(StatusPendaftaran::BAYAR_SELEKSI, $calonSiswa->status_pendaftaran);

        // 3. Verifikasi otomatis login
        $this->assertAuthenticatedAs($user);
    }

    public function test_step_2_uploads_receipt_and_stays_at_bayar_seleksi(): void
    {
        Storage::fake('public');

        $program = Program::where('nama_program', 'Reguler')->first();

        $file = UploadedFile::fake()->create('bukti_transfer.jpg', 500, 'image/jpeg');

        $component = Livewire::test(StudentRegistrationStepper::class)
            // Step 1
            ->set('nisn', '0011223344')
            ->set('nama_lengkap', 'Siti Nurhaliza')
            ->set('email', 'siti@example.test')
            ->set('program_id', $program->id)
            ->set('referensi_promotor', 'Alumni Sekolah')
            ->set('hp_siswa', '081399887766')
            ->call('submitStep1')
            // Step 2
            ->set('bukti_transfer', $file)
            ->set('catatan_bayar', 'Transfer via Mobile Banking BCA a.n Siti')
            ->call('submitStep2')
            ->assertHasNoErrors();

        $user = User::where('email', 'siti@example.test')->first();
        $calon = $user->calonSiswa;

        $this->assertNotNull($calon->bukti_bayar_seleksi);
        $this->assertEquals('Transfer via Mobile Banking BCA a.n Siti', $calon->catatan_bayar);
        // BUG FIX: Harus tetap BAYAR_SELEKSI, menunggu ACC Bendahara
        $this->assertEquals(StatusPendaftaran::BAYAR_SELEKSI, $calon->status_pendaftaran);

        Storage::disk('public')->assertExists($calon->bukti_bayar_seleksi);
    }

    public function test_step_3_and_4_saves_biodata_and_advances_to_step_5(): void
    {
        Storage::fake('public');
        $program = Program::where('nama_program', 'Reguler')->first();
        $jabar = Wilayah::where('kode', '32')->first();

        $file = UploadedFile::fake()->create('bukti.png', 300, 'image/png');

        Livewire::test(StudentRegistrationStepper::class)
            // Step 1
            ->set('nisn', '0055443322')
            ->set('nama_lengkap', 'Fajar Pratama')
            ->set('email', 'fajar@example.test')
            ->set('program_id', $program->id)
            ->set('referensi_promotor', 'Brosur / Spanduk')
            ->set('hp_siswa', '085712345678')
            ->call('submitStep1')
            // Step 2
            ->set('bukti_transfer', $file)
            ->call('submitStep2');

        // Simulasi ACC Bendahara: ubah status ke ISI_BIODATA_SISWA
        $user = User::where('email', 'fajar@example.test')->first();
        $user->calonSiswa->update(['status_pendaftaran' => StatusPendaftaran::ISI_BIODATA_SISWA]);

        // Muat ulang stepper (seperti siswa membuka halaman setelah ACC)
        Livewire::actingAs($user)->test(StudentRegistrationStepper::class)
            // Step 3 (Biodata Siswa)
            ->set('nik_siswa', '3273010101080005')
            ->set('no_kk', '3273010101080005')
            ->set('tempat_lahir', 'Bandung')
            ->set('tanggal_lahir', '2008-05-15')
            ->set('jenis_kelamin', 'L')
            ->set('kewarganegaraan', 'WNI')
            ->set('agama', 'Islam')
            ->set('asal_sekolah', 'SMP Negeri 5 Bandung')
            ->set('provinsi_id', $jabar?->id)
            ->set('alamat_detail', 'Jl. Sukajadi No. 45')
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
            ->call('submitStep3')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 4)
            // Step 4 (Biodata Ortu)
            ->set('nama_ayah', 'Hendro Siswanto')
            ->set('pekerjaan_ayah', 'Wiraswasta / Pengusaha')
            ->set('penghasilan_ayah', 7500000)
            ->set('hp_ayah', '081288776655')
            ->set('nama_ibu', 'Sri Wahyuni')
            ->set('pekerjaan_ibu', 'Ibu Rumah Tangga (IRT)')
            ->set('penghasilan_ibu', 0)
            ->set('hp_ibu', '081299001122')
            ->call('submitStep4')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 5);

        $user = User::where('email', 'fajar@example.test')->first();
        $calon = $user->calonSiswa->fresh();

        // Verifikasi Step 3
        $this->assertEquals('3273010101080005', $calon->nik_siswa);
        $this->assertEquals('Bandung', $calon->tempat_lahir);
        $this->assertEquals('2008-05-15', $calon->tanggal_lahir->format('Y-m-d'));
        $this->assertEquals('L', $calon->jenis_kelamin);
        $this->assertEquals('SMP Negeri 5 Bandung', $calon->asal_sekolah);

        // Verifikasi Step 4
        $this->assertEquals('Hendro Siswanto', $calon->nama_ayah);
        $this->assertEquals(7500000, $calon->penghasilan_ayah);
        $this->assertEquals('Sri Wahyuni', $calon->nama_ibu);
        $this->assertEquals(StatusPendaftaran::ISI_RAPORT, $calon->status_pendaftaran);
    }

    public function test_step_5_matrix_raport_and_dynamic_prestasi_completes_registration(): void
    {
        Storage::fake('public');
        $program = Program::where('nama_program', 'Reguler')->first();
        $file = UploadedFile::fake()->create('bukti.png', 300, 'image/png');

        $component = Livewire::test(StudentRegistrationStepper::class)
            // Step 1
            ->set('nisn', '0099887766')
            ->set('nama_lengkap', 'Ahmad Dahlan')
            ->set('email', 'dahlan@example.test')
            ->set('program_id', $program->id)
            ->set('referensi_promotor', 'Website Resmi')
            ->set('hp_siswa', '081234112233')
            ->call('submitStep1')
            // Step 2
            ->set('bukti_transfer', $file)
            ->call('submitStep2');

        // Simulasi ACC Bendahara
        $user = User::where('email', 'dahlan@example.test')->first();
        $user->calonSiswa->update(['status_pendaftaran' => StatusPendaftaran::ISI_BIODATA_SISWA]);

        // Muat ulang stepper (seperti siswa membuka halaman setelah ACC)
        $component = Livewire::actingAs($user)->test(StudentRegistrationStepper::class)
            // Step 3
            ->set('nik_siswa', '3273010101089999')
            ->set('no_kk', '3273010101089999')
            ->set('tempat_lahir', 'Jakarta')
            ->set('tanggal_lahir', '2008-08-08')
            ->set('jenis_kelamin', 'P')
            ->set('kewarganegaraan', 'WNI')
            ->set('agama', 'Islam')
            ->set('asal_sekolah', 'SMPN 2 Jakarta')
            ->set('alamat_detail', 'Jl. Sudirman No. 12')
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
            ->call('submitStep3')
            // Step 4
            ->set('nama_ayah', 'Dahlan Senior')
            ->set('pekerjaan_ayah', 'PNS')
            ->set('penghasilan_ayah', 8000000)
            ->set('nama_ibu', 'Siti Aminah')
            ->set('pekerjaan_ibu', 'Guru')
            ->set('penghasilan_ibu', 5000000)
            ->call('submitStep4')
            ->assertSet('currentStep', 5);

        // Test Dynamic Prestasi (Add & Remove row)
        $component->call('addPrestasi')
            ->assertCount('prestasi', 1)
            ->call('addPrestasi')
            ->assertCount('prestasi', 2)
            ->call('removePrestasi', 1)
            ->assertCount('prestasi', 1);

        // Isi Prestasi baris pertama
        $component->set('prestasi.0.kategori', 'Sains / Robotik')
            ->set('prestasi.0.perolehan', 'Juara 1')
            ->set('prestasi.0.tingkat', 'Prov')
            ->set('prestasi.0.penyelenggara', 'Dinas Pendidikan Jawa Barat');

        // Isi Matriks Nilai Raport: 5 Mapel x 5 Semester dengan nilai rata-rata 88.0
        $mapels = ['matematika', 'b_indo', 'b_inggris', 'pai', 'ipa'];
        foreach ($mapels as $mapel) {
            for ($sem = 1; $sem <= 5; $sem++) {
                $component->set("nilai_raport.{$mapel}.{$sem}", 88);
            }
        }

        // Verifikasi kalkulasi rata-rata reaktif Livewire
        $this->assertEquals(88.0, $component->instance()->getSubjectAverage('matematika'));
        $this->assertEquals(88.0, $component->instance()->getOverallAverage());

        // Submit Step 5
        $component->call('submitStep5')
            ->assertHasNoErrors()
            ->assertSet('isComplete', true);

        // Verifikasi penyimpanan di basis data
        $user = User::where('email', 'dahlan@example.test')->first();
        $calon = $user->calonSiswa->fresh();

        $this->assertEquals(StatusPendaftaran::MENUNGGU_WAWANCARA, $calon->status_pendaftaran);
        $this->assertEquals(88.00, (float) $calon->rata_rata_raport);
        $this->assertIsArray($calon->nilai_raport);
        $this->assertEquals(88, $calon->nilai_raport['matematika'][1]);
        $this->assertCount(1, $calon->prestasi);
        $this->assertEquals('Sains / Robotik', $calon->prestasi[0]['kategori']);
        $this->assertEquals('Juara 1', $calon->prestasi[0]['perolehan']);
    }
}
