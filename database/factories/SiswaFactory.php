<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nis'       => fake()->unique()->numerify('########'),
            'nama'      => fake()->name(),
            'kelas_id'  => null, // isi manual saat test
            'user_id'   => null,
        ];
    }

}
