<?php

namespace Tests\Feature;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Livewire\Admin\BulkAssignmentWawancara;
use App\Models\CalonSiswa;
use App\Models\User;
use App\Models\Wawancara;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BulkAssignmentWawancaraTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $pewawancara;
    protected CalonSiswa $calon1;
    protected CalonSiswa $calon2;
    protected CalonSiswa $calonNotWaiting;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->seed(TagihanDinamisSeeder::class);

        $this->admin = User::where('email', 'admin@ppdb.test')->first();
        $this->pewawancara = User::where('email', 'pewawancara@ppdb.test')->first();

        $user1 = User::factory()->create(['role' => 'siswa', 'email' => 'siswa1@test.com']);
        $user2 = User::factory()->create(['role' => 'siswa', 'email' => 'siswa2@test.com']);
        $user3 = User::factory()->create(['role' => 'siswa', 'email' => 'siswa3@test.com']);

        // 2 Siswa di tahap MENUNGGU_WAWANCARA
        $this->calon1 = CalonSiswa::create([
            'user_id' => $user1->id,
            'nisn' => '0011223344',
            'nama_lengkap' => 'Calon Pertama Menunggu',
            'asal_sekolah' => 'SMP 1',
            'rata_rata_raport' => 85.00,
            'status_pendaftaran' => StatusPendaftaran::MENUNGGU_WAWANCARA,
            'status_kelulusan' => StatusKelulusan::PENDING,
        ]);

        $this->calon2 = CalonSiswa::create([
            'user_id' => $user2->id,
            'nisn' => '0022334455',
            'nama_lengkap' => 'Calon Kedua Menunggu',
            'asal_sekolah' => 'SMP 2',
            'rata_rata_raport' => 89.00,
            'status_pendaftaran' => StatusPendaftaran::MENUNGGU_WAWANCARA,
            'status_kelulusan' => StatusKelulusan::PENDING,
        ]);

        // 1 Siswa masih di tahap ISI_BIODATA_SISWA (tidak boleh muncul di list antrean)
        $this->calonNotWaiting = CalonSiswa::create([
            'user_id' => $user3->id,
            'nisn' => '0033445566',
            'nama_lengkap' => 'Calon Belum Raport',
            'asal_sekolah' => 'SMP 3',
            'status_pendaftaran' => StatusPendaftaran::ISI_BIODATA_SISWA,
            'status_kelulusan' => StatusKelulusan::PENDING,
        ]);
    }

    public function test_admin_can_access_penugasan_wawancara_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/penugasan-wawancara');
        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.bulk-assignment-wawancara');
        $response->assertSee('Bulk Assignment Sesi Wawancara');
    }

    public function test_component_only_lists_students_waiting_for_interview(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(BulkAssignmentWawancara::class)
            ->assertSee('Calon Pertama Menunggu')
            ->assertSee('Calon Kedua Menunggu')
            ->assertDontSee('Calon Belum Raport');
    }

    public function test_select_all_toggles_checkboxes_properly(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(BulkAssignmentWawancara::class)
            ->set('selectAll', true)
            ->assertCount('selected', 2)
            ->assertSet('selected', [$this->calon1->id, $this->calon2->id])
            ->set('selectAll', false)
            ->assertCount('selected', 0);
    }

    public function test_assign_bulk_requires_selection_and_pewawancara(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(BulkAssignmentWawancara::class)
            ->set('selected', [])
            ->call('assignBulk')
            ->assertHasErrors(['selected', 'pewawancara_id']);
    }

    public function test_assign_bulk_successfully_creates_wawancara_for_selected_students(): void
    {
        $this->actingAs($this->admin);

        $schedule = now()->addDays(2)->format('Y-m-d\TH:i');

        Livewire::test(BulkAssignmentWawancara::class)
            ->set('selected', [$this->calon1->id, $this->calon2->id])
            ->set('pewawancara_id', $this->pewawancara->id)
            ->set('jadwal', $schedule)
            ->set('link_meet', 'https://meet.google.com/bulk-test')
            ->call('assignBulk')
            ->assertHasNoErrors()
            ->assertCount('selected', 0)
            ->assertSet('selectAll', false);

        // Verifikasi tabel wawancara terisi untuk calon1 dan calon2
        $wawancara1 = Wawancara::where('calon_siswa_id', $this->calon1->id)->first();
        $this->assertNotNull($wawancara1);
        $this->assertEquals($this->pewawancara->id, $wawancara1->pewawancara_id);
        $this->assertEquals('https://meet.google.com/bulk-test', $wawancara1->link_meet);

        $wawancara2 = Wawancara::where('calon_siswa_id', $this->calon2->id)->first();
        $this->assertNotNull($wawancara2);
        $this->assertEquals($this->pewawancara->id, $wawancara2->pewawancara_id);
        $this->assertEquals('https://meet.google.com/bulk-test', $wawancara2->link_meet);
    }
}
