<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GradeSeeder::class,
            UnitSeeder::class
        ]);

        Book::factory(1000)->create();
        Student::factory(100)->create();
        Staff::factory(100)->create();
    }
}
