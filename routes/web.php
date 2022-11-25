<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Login
Route::prefix('login')->controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->middleware('guest')->name('login');
    Route::post('/', 'authenticate');
    Route::get('logout', 'logout')->name('logout');
});

// User
Route::middleware('auth')->prefix('user')->name('user')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('.index');
    Route::patch('update', 'update')->name('.update');
});

// Beranda
Route::middleware('auth')->controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('beranda');
});

// Buku
Route::middleware('auth')->prefix('buku')->name('buku')->controller(BookController::class)->group(function () {
    Route::get('daftar', 'daftar')->name('.daftar');
    Route::get('detail', 'detail')->name('.detail');
});

// Form
Route::middleware('auth')->prefix('form')->name('form')->controller(FormController::class)->group(function () {
    Route::get('upload', 'upload')->name('.upload');
    Route::get('tambah', 'tambah')->name('.tambah');
    Route::get('edit', 'edit')->name('.edit');
    Route::get('hapus', 'hapus')->name('.hapus');
    Route::get('trash', 'trash')->name('.trash');

    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::post('checkUpload', 'checkUpload')->name('.checkUpload');
    Route::post('import', 'import')->name('.import');
    Route::delete('remove/{buku}', 'remove')->name('.remove');
    Route::patch('restore/{buku}', 'restore')->name('.restore')->withTrashed();
    Route::delete('destroy/{buku}', 'destroy')->name('.destroy')->withTrashed();
});

// Peminjaman
Route::middleware('auth')->prefix('peminjaman')->name('peminjaman')->controller(LoanController::class)->group(function () {
    Route::get('form', 'form')->name('.form');
    Route::get('riwayat', 'riwayat')->name('.riwayat');
    Route::get('export', 'export')->name('.export');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::patch('restore/{loan}', 'restore')->name('.restore')->withTrashed();
    Route::delete('selesai/{loan}', 'selesai')->name('.selesai');
    Route::delete('destroy/{loan}', 'destroy')->name('.destroy')->withTrashed();
});

// Print
Route::middleware('auth')->prefix('print')->name('print')->controller(PrintController::class)->group(function () {
    Route::get('buku', 'buku')->name('.buku');
    Route::get('siswa', 'siswa')->name('.siswa');
    Route::get('staff', 'staff')->name('.staff');
});

// Rekap
Route::middleware('auth')->prefix('rekap')->name('rekap')->controller(RekapController::class)->group(function () {
    Route::get('siswa', 'siswa')->name('.siswa');
    Route::get('siswa/{siswa}', 'siswaExport')->name('.siswaExport');
    Route::get('siswaPreview/{siswa}', 'siswaPreview')->name('.siswaPreview');
    Route::get('siswaZip/{kelas}', 'siswaExportZip')->name('.siswaExportZip');

    Route::get('staff', 'staff')->name('.staff');
    Route::get('staff/{staff}', 'staffExport')->name('.staffExport');
    Route::get('staffPreview/{staff}', 'staffPreview')->name('.staffPreview');
    Route::get('staffZip/{unit}', 'staffExportZip')->name('.staffExportZip');
});


// ==============


// Siswa
Route::middleware(['auth', 'level:3'])->prefix('siswa')->name('siswa')->controller(StudentController::class)->group(function () {
    Route::get('/', 'index')->name('.index');
    Route::get('form', 'form')->name('.form');
    Route::get('trash', 'trash')->name('.trash');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('nonaktif/{siswa}', 'nonaktif')->name('.nonaktif');
    Route::patch('restore/{siswa}', 'restore')->name('.restore')->withTrashed();
    Route::delete('destroy/{siswa}', 'destroy')->name('.destroy')->withTrashed();
});

// Staff
Route::middleware(['auth', 'level:3'])->prefix('staff')->name('staff')->controller(StaffController::class)->group(function () {
    Route::get('/', 'index')->name('.index');
    Route::get('form', 'form')->name('.form');
    Route::get('trash', 'trash')->name('.trash');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('nonaktif/{staff}', 'nonaktif')->name('.nonaktif');
    Route::patch('restore/{staff}', 'restore')->name('.restore')->withTrashed();
    Route::delete('destroy/{staff}', 'destroy')->name('.destroy')->withTrashed();
});

// Kelas
Route::middleware(['auth', 'level:3'])->prefix('kelas')->name('kelas')->controller(GradeController::class)->group(function () {
    Route::get('/', 'index')->name('.index');
    Route::get('tambah', 'tambah')->name('.tambah');
    Route::get('edit/{kelas}', 'edit')->name('.edit');
    Route::get('trash', 'trash')->name('.trash');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('hapus/{kelas}', 'hapus')->name('.hapus');
    Route::patch('restore/{kelas}', 'restore')->name('.restore')->withTrashed();
    Route::delete('destroy/{kelas}', 'destroy')->name('.destroy')->withTrashed();

    Route::get('list/{kelas}', 'list')->name('.list');
    Route::patch('updateList', 'updateList')->name('.updateList');
});

// Unit
Route::middleware(['auth', 'level:3'])->prefix('unit')->name('unit')->controller(UnitController::class)->group(function () {
    Route::get('/', 'index')->name('.index');
    Route::get('tambah', 'tambah')->name('.tambah');
    Route::get('edit/{unit}', 'edit')->name('.edit');
    Route::get('trash', 'trash')->name('.trash');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('hapus/{unit}', 'hapus')->name('.hapus');
    Route::patch('restore/{unit}', 'restore')->name('.restore')->withTrashed();
    Route::delete('destroy/{unit}', 'destroy')->name('.destroy')->withTrashed();

    Route::get('list/{unit}', 'list')->name('.list');
    Route::patch('updateList', 'updateList')->name('.updateList');
});
