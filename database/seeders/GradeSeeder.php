<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        Grade::insert([
            ['kelas' => '1A'],
            ['kelas' => '1B'],
            ['kelas' => '2A'],
            ['kelas' => '2B'],
            ['kelas' => '2C'],
            ['kelas' => '3A'],
            ['kelas' => '3B'],
            ['kelas' => '3C'],
            ['kelas' => '3D'],
            ['kelas' => '4A'],
            ['kelas' => '4B'],
            ['kelas' => '4C'],
            ['kelas' => '4D'],
            ['kelas' => '5A'],
            ['kelas' => '5B'],
            ['kelas' => '5C'],
            ['kelas' => '5D'],
            ['kelas' => '6A'],
            ['kelas' => '6B'],
            ['kelas' => '6C'],
            ['kelas' => '6D'],
        ]);
    }
}
