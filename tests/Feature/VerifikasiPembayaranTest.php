<?php

namespace Tests\Feature;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Livewire\Bendahara\VerifikasiPembayaran;
use App\Models\CalonSiswa;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VerifikasiPembayaranTest extends TestCase
{
    use RefreshDatabase;

    protected User $bendahara;
    protected User $siswaUser;
    protected CalonSiswa $calonBayar;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->seed(TagihanDinamisSeeder::class);

        $this->bendahara = User::where('email', 'bendahara@ppdb.test')->first();
        $this->siswaUser = User::where('email', 'siswa@ppdb.test')->first();

        // Buat calon siswa yang sudah upload bukti transfer dan menunggu ACC (status BAYAR_SELEKSI)
        $this->calonBayar = CalonSiswa::updateOrCreate(
            ['user_id' => $this->siswaUser->id],
            [
                'nisn' => '0077889911',
                'nama_lengkap' => 'Budi Sudarsono',
                'asal_sekolah' => 'SMP Negeri 3 Surabaya',
                'bukti_bayar_seleksi' => 'bukti_transfer/sample_receipt.jpg',
                'nama_rekening_pengirim' => 'Budi Sudarsono',
                'nominal_transfer_seleksi' => 250000,
                'status_pendaftaran' => StatusPendaftaran::BAYAR_SELEKSI,
                'status_kelulusan' => StatusKelulusan::PENDING,
            ]
        );
    }

    public function test_bendahara_can_access_verifikasi_pembayaran_page(): void
    {
        $response = $this->actingAs($this->bendahara)->get('/bendahara/verifikasi-bayar');
        $response->assertStatus(200);
        $response->assertSeeLivewire('bendahara.verifikasi-pembayaran');
        $response->assertSee('Verifikasi Pembayaran Biaya Seleksi');
    }

    public function test_siswa_cannot_access_bendahara_verifikasi_page(): void
    {
        $response = $this->actingAs($this->siswaUser)->get('/bendahara/verifikasi-bayar');
        $response->assertStatus(403);
    }

    public function test_verifikasi_pembayaran_displays_calon_with_receipt(): void
    {
        $this->actingAs($this->bendahara);

        Livewire::test(VerifikasiPembayaran::class)
            ->assertSee('Budi Sudarsono')
            ->assertSee('0077889911')
            ->assertSee('Rp 250.000')
            ->assertSee('Menunggu ACC');
    }

    public function test_acc_pembayaran_advances_student_state_to_isi_biodata_siswa(): void
    {
        $this->actingAs($this->bendahara);

        Livewire::test(VerifikasiPembayaran::class)
            ->call('accPembayaran', $this->calonBayar->id)
            ->assertHasNoErrors();

        // Verifikasi state pendaftaran telah berubah ke ISI_BIODATA_SISWA
        $this->calonBayar->refresh();
        $this->assertEquals(StatusPendaftaran::ISI_BIODATA_SISWA, $this->calonBayar->status_pendaftaran);
    }

    public function test_tolak_pembayaran_clears_receipt_and_keeps_bayar_seleksi(): void
    {
        $this->actingAs($this->bendahara);

        Livewire::test(VerifikasiPembayaran::class)
            ->call('openRejectModal', $this->calonBayar->id)
            ->set('alasanTolak', 'Struk tidak terbaca')
            ->call('confirmTolak')
            ->assertHasNoErrors();

        $this->calonBayar->refresh();
        $this->assertNull($this->calonBayar->bukti_bayar_seleksi);
        $this->assertEquals('Struk tidak terbaca', $this->calonBayar->keterangan_tolak_bayar);
        $this->assertEquals(StatusPendaftaran::BAYAR_SELEKSI, $this->calonBayar->status_pendaftaran);
    }
}
