<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    public function definition()
    {
        return [
            'nama' => fake()->name(),
            'nik' => fake()->unique()->nik(),
            'unit_id' => Unit::inRandomOrder()->first()->id
        ];
    }
}
