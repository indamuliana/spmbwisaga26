<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Administrator');
    }

    public function test_siswa_cannot_access_admin_dashboard(): void
    {
        $siswa = User::factory()->create([
            'role' => UserRole::SISWA,
        ]);

        $response = $this->actingAs($siswa)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_bendahara_can_access_bendahara_dashboard(): void
    {
        $bendahara = User::factory()->create([
            'role' => UserRole::BENDAHARA,
        ]);

        $response = $this->actingAs($bendahara)->get('/bendahara/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Bendahara');
    }

    public function test_pewawancara_can_access_pewawancara_dashboard(): void
    {
        $pewawancara = User::factory()->create([
            'role' => UserRole::PEWAWANCARA,
        ]);

        $response = $this->actingAs($pewawancara)->get('/pewawancara/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Pewawancara');
    }

    public function test_siswa_can_access_siswa_dashboard(): void
    {
        $siswa = User::factory()->create([
            'role' => UserRole::SISWA,
        ]);

        \App\Models\CalonSiswa::create([
            'user_id' => $siswa->id,
            'nama_lengkap' => $siswa->name,
            'nisn' => '1234567890',
            'asal_sekolah' => 'SMP Test',
        ]);

        $response = $this->actingAs($siswa)->get('/siswa/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Selamat datang, ' . $siswa->name);
    }

    public function test_kepsek_can_access_kepsek_dashboard(): void
    {
        $kepsek = User::factory()->create([
            'role' => UserRole::KEPSEK,
        ]);

        $response = $this->actingAs($kepsek)->get('/kepsek/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Kepala Sekolah');
    }

    public function test_dashboard_redirector_works_for_each_role(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($admin)->get('/dashboard')->assertRedirect('/admin/dashboard');

        $siswa = User::factory()->create(['role' => UserRole::SISWA]);
        $this->actingAs($siswa)->get('/dashboard')->assertRedirect('/siswa/dashboard');
    }
}
