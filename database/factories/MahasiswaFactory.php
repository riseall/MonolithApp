<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'foto' => $this->faker->image(null, 640, 480),
            'nama' => $this->faker->name(),
            'nim' => $this->faker->randomNumber(8, true),
            'kelas' => $this->faker->word(),
            'telepon' => $this->faker->PhoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'alamat' => $this->faker->address()
        ];
    }
}