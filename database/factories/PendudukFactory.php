<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penduduk>
 */
class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'),
            'nama_lengkap' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat' => $this->faker->address(),
            'desa' => $this->faker->randomElement(['Desa Suka Makmur', 'Desa Mulya Jaya', 'Desa Sejahtera', 'Desa Harmoni', 'Desa Makmur']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'status_kawin' => $this->faker->randomElement(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati']),
            'pekerjaan' => $this->faker->randomElement(['Petani', 'Wiraswasta', 'PNS', 'Guru', 'Buruh', 'Mahasiswa', 'Ibu Rumah Tangga', 'Nelayan']),
            'no_hp' => $this->faker->phoneNumber(),
            'user_id' => null, // Will be set explicitly when creating
        ];
    }
}
