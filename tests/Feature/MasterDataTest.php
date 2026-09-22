<?php

namespace Tests\Feature;

use App\Models\Beasiswa;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\Program;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\MasterDataSeeder::class);
    }

    public function test_wilayah_hierarchy_and_cascading_relations(): void
    {
        // 1. Get Provinsi Jawa Barat
        $jabar = Wilayah::where('kode', '32')->first();
        $this->assertNotNull($jabar);
        $this->assertEquals('provinsi', $jabar->level);
        $this->assertNull($jabar->parent_id);

        // 2. Test children / kotaKab relation
        $kotaKabList = $jabar->kotaKab;
        $this->assertGreaterThanOrEqual(2, $kotaKabList->count());
        $this->assertTrue($kotaKabList->contains('nama', 'Kota Bandung'));

        // 3. Test parent relation from child
        $kotaBandung = Wilayah::where('kode', '32.73')->first();
        $this->assertNotNull($kotaBandung);
        $this->assertEquals($jabar->id, $kotaBandung->parent->id);
        $this->assertEquals('Jawa Barat', $kotaBandung->parent->nama);

        // 4. Test kecamatan & desa cascading
        $coblong = $kotaBandung->kecamatan()->where('nama', 'Kecamatan Coblong')->first();
        $this->assertNotNull($coblong);

        $desaList = $coblong->desa;
        $this->assertGreaterThanOrEqual(2, $desaList->count());
        $this->assertTrue($desaList->contains('nama', 'Kelurahan Dago'));

        // 5. Test cascading query scopes
        $provinsiScoped = Wilayah::provinsi()->get();
        $this->assertTrue($provinsiScoped->contains('kode', '32'));
        $this->assertTrue($provinsiScoped->contains('kode', '31'));

        $kotaKabScoped = Wilayah::filterKotaKab($jabar->id)->get();
        $this->assertTrue($kotaKabScoped->contains('nama', 'Kota Bandung'));
        $this->assertFalse($kotaKabScoped->contains('nama', 'Kota Jakarta Selatan'));

        // Test childOf scope
        $childOfScoped = Wilayah::childOf($jabar->id, 'kota_kab')->get();
        $this->assertTrue($childOfScoped->contains('nama', 'Kota Bandung'));
    }

    public function test_program_and_jurusan_many_to_many_relation(): void
    {
        $reguler = Program::where('nama_program', 'Reguler')->first();
        $unggulan = Program::where('nama_program', 'Unggulan')->first();
        $rpl = Jurusan::where('kode_jurusan', 'RPL')->first();

        $this->assertNotNull($reguler);
        $this->assertNotNull($unggulan);
        $this->assertNotNull($rpl);

        // Check Program -> Jurusans
        $this->assertCount(3, $reguler->jurusans);
        $this->assertCount(2, $unggulan->jurusans);

        // Check Pivot kuota
        $rplReguler = $reguler->jurusans()->where('jurusan_id', $rpl->id)->first();
        $this->assertEquals(40, $rplReguler->pivot->kuota);

        // Check Jurusan -> Programs
        $this->assertCount(2, $rpl->programs);
        $this->assertTrue($rpl->programs->contains('nama_program', 'Reguler'));
        $this->assertTrue($rpl->programs->contains('nama_program', 'Unggulan'));
    }

    public function test_gelombang_model_and_attributes(): void
    {
        $gelombang1 = Gelombang::where('nama', 'Gelombang 1 - Early Bird')->first();

        $this->assertNotNull($gelombang1);
        $this->assertEquals(15.00, $gelombang1->diskon_persen);
        $this->assertEquals(500000, $gelombang1->diskon_nominal);
        $this->assertInstanceOf(Carbon::class, $gelombang1->tgl_mulai);
        $this->assertInstanceOf(Carbon::class, $gelombang1->tgl_selesai);
    }

    public function test_beasiswa_model_and_attributes(): void
    {
        $tahfidz = Beasiswa::where('nama_beasiswa', 'like', '%Tahfidz%')->first();

        $this->assertNotNull($tahfidz);
        $this->assertEquals(2500000, $tahfidz->potongan_nominal);
        $this->assertEquals(100.00, $tahfidz->potongan_persen);
        $this->assertTrue($tahfidz->is_active);
    }
}
