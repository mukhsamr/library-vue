<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        Unit::insert([
            ['unit' => 'TK'],
            ['unit' => 'SD'],
            ['unit' => 'SMP'],
            ['unit' => 'Supporting'],
            ['unit' => 'Office Boy'],
            ['unit' => 'Security'],
        ]);
    }
}
