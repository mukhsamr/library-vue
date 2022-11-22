<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition()
    {
        return [
            'tanggal' => fake()->date(),
            'nik' =>  fake()->unique()->nik(),
            'judul' => fake()->words(rand(1, 5), true),
            'pengarang' => fake()->name(),
            'kota_penerbit' => fake()->city(),
            'penerbit' => fake()->company(),
            'edisi_cetakan' => rand(1, 20),
            'tahun_terbit' => fake()->year(),
            'isbn' => fake()->numerify('###-###-###-#'),
            'sumber' => fake()->randomElement(['Beli', 'Wakaf']),
            'klasifikasi' => null,
            'lokasi_penyimpanan' => 'Perpustakaan',
            'jenis' => fake()->randomElement(['Anak', 'Dewasa']),
            'jumlah_halaman' => rand(50, 2000),
            'jumlah_buku' => rand(1, 10),
            'deskripsi' => null,
            'sampul' => null,
            'catatan' => null
        ];
    }
}
