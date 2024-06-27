<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'namaproduct' => Str::random(10),
            'kodeproduct' => Str::random(10),
            'jumlah' => rand(1, 100),
            'hargamasuk' => rand(1000, 10000),
            'hargajual' => rand(1000, 10000),
            'jumlah_terjual' => rand(1, 100),
        ];
    }
}
