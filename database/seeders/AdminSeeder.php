<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users
        User::truncate();

        // Create Admin user
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'role' => 'ADMIN',
            'password' => Hash::make('admin'),
        ]);

        // Create Kepala Desa user
        User::create([
            'name' => 'Kepala Desa',
            'username' => 'kepala_desa',
            'role' => 'KEPALA_DESA',
            'password' => Hash::make('kepala_desa'),
        ]);

        // Create Masyarakat user
        User::create([
            'name' => 'Masyarakat',
            'username' => 'masyarakat',
            'role' => 'MASYARAKAT',
            'password' => Hash::make('masyarakat'),
        ]);

        $this->command->info('Users created successfully!');
        $this->command->info('Admin credentials: username: admin, password: admin');
        $this->command->info('Kepala Desa credentials: username: kepala_desa, password: kepala_desa');
        $this->command->info('Masyarakat credentials: username: masyarakat, password: masyarakat');
    }
}
