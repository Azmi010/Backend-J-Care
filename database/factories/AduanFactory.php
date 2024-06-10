<?php

namespace Database\Factories;

use App\Models\Aduan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aduan>
 */
class AduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Aduan::class;
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'status_id' => \App\Models\Status::factory(),
            'judul' => $this->faker->sentence,
            'lokasi' => $this->faker->address,
            'keterangan' => $this->faker->paragraph,
            'like' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'gambar' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
