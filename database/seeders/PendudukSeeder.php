<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user to associate with penduduk records
        $admin = User::where('role', 'ADMIN')->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run AdminSeeder first.');
            return;
        }

        // Create 50 penduduk records
        Penduduk::factory()
            ->count(50)
            ->create([
                'user_id' => $admin->id,
            ]);

        $this->command->info('Successfully created 50 penduduk records.');
    }
}