<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal')->nullable();
            $table->string('nik')->unique();
            $table->string('judul');
            $table->string('pengarang')->nullable();
            $table->string('kota_penerbit')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('edisi_cetakan')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('isbn')->nullable();
            $table->string('sumber')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('lokasi_penyimpanan')->nullable();
            $table->string('jenis')->nullable();
            $table->unsignedInteger('jumlah_halaman')->nullable();
            $table->unsignedInteger('jumlah_buku')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('sampul')->unique()->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
