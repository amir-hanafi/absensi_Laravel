<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;


class GuruFactory extends Factory
{
    protected $model = Guru::class;

    public function definition(): array
    {
        return [
            'kode_guru' => 'GR-' . fake()->unique()->numerify('####'),
            'nama'      => fake()->name(),
            'no_hp'     => fake()->phoneNumber(),
            'user_id'   => User::factory()->create([
                'role' => 'guru',
            ])->id,
        ];
    }
}
