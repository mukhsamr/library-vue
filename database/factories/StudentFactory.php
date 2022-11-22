<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition()
    {
        return [
            'nama' => fake()->name(),
            'nis' => fake()->unique()->nik(),
            'grade_id' => Grade::inRandomOrder()->first()->id,
        ];
    }
}
