<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator PPDB',
                'email' => 'admin@ppdb.test',
                'role' => UserRole::ADMIN,
                'phone' => '081234567890',
            ],
            [
                'name' => 'Bendahara PPDB',
                'email' => 'bendahara@ppdb.test',
                'role' => UserRole::BENDAHARA,
                'phone' => '081234567891',
            ],
            [
                'name' => 'Tim Penguji Wawancara',
                'email' => 'pewawancara@ppdb.test',
                'role' => UserRole::PEWAWANCARA,
                'phone' => '081234567892',
            ],
            [
                'name' => 'Ahmad Calon Siswa',
                'email' => 'siswa@ppdb.test',
                'role' => UserRole::SISWA,
                'phone' => '081234567893',
            ],
            [
                'name' => 'Drs. H. Kepala Sekolah, M.Pd',
                'email' => 'kepsek@ppdb.test',
                'role' => UserRole::KEPSEK,
                'phone' => '081234567894',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'phone' => $userData['phone'],
                    'role' => $userData['role'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
