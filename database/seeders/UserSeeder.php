<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'nama' => 'Admin',
                'password' => bcrypt('Admin123'),
                'level' => 3,
                'foto' => null
            ],
            [
                'nama' => 'Operator',
                'password' => bcrypt('Operator123'),
                'level' => 2,
                'foto' => null
            ],
            [
                'nama' => 'User',
                'password' => bcrypt('User123'),
                'level' => 1,
                'foto' => null
            ],
        ]);
    }
}
