<?php

namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BookImport implements ToModel, WithValidation, WithHeadingRow, WithUpserts, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        return new Book([
            'tanggal' => $row['tanggal'],
            'nik' => $row['nik'],
            'judul' => $row['judul'],
            'pengarang' => $row['pengarang'],
            'kota_penerbit' => $row['kota_penerbit'],
            'penerbit' => $row['penerbit'],
            'edisi_cetakan' => $row['edisi_cetakan'],
            'tahun_terbit' => $row['tahun_terbit'],
            'isbn' => $row['isbn'],
            'sumber' => $row['sumber'],
            'klasifikasi' => $row['klasifikasi'],
            'lokasi_penyimpanan' => $row['lokasi_penyimpanan'],
            'jenis' => $row['jenis'],
            'jumlah_halaman' => $row['jumlah_halaman'],
            'jumlah_buku' => $row['jumlah_buku'],
            'deskripsi' => $row['deskripsi'],
        ]);
    }

    public function uniqueBy()
    {
        return 'nik';
    }

    public function rules(): array
    {
        return [
            'tanggal' => 'required|string',
            'nik' => 'required|string',
            'judul' => 'required|string',
            'pengarang' => 'string|nullable',
            'kota_penerbit' => 'string|nullable',
            'penerbit' => 'string|nullable',
            'edisi_cetakan' => 'string|nullable',
            'tahun_terbit' => 'integer|nullable',
            'isbn' => 'string|nullable',
            'sumber' => 'string|nullable',
            'klasifikasi' => 'string|nullable',
            'lokasi_penyimpanan' => 'string|nullable',
            'jenis' => 'string|nullable',
            'jumlah_halaman' => 'integer|nullable',
            'jumlah_buku' => 'integer|nullable',
            'deskripsi' => 'string|nullable',
        ];
    }

    public function prepareForValidation($data)
    {
        $data['tanggal'] = Carbon::instance(Date::excelToDateTimeObject($data['tanggal']))->toDateString();
        $data['nik'] = strval($data['nik']);
        $data['judul'] = strval($data['judul']);
        $data['pengarang'] = strval($data['pengarang']) ?: null;
        $data['kota_penerbit'] = strval($data['kota_penerbit']) ?: null;
        $data['penerbit'] = strval($data['penerbit']) ?: null;
        $data['edisi_cetakan'] = strval($data['edisi_cetakan']) ?: null;
        $data['tahun_terbit'] = intval($data['tahun_terbit']) ?: null;
        $data['isbn'] = strval($data['isbn']) ?: null;
        $data['sumber'] = strval($data['sumber']) ?: null;
        $data['klasifikasi'] = strval($data['klasifikasi']) ?: null;
        $data['lokasi_penyimpanan'] = strval($data['lokasi_penyimpanan']) ?: null;
        $data['jenis'] = strval($data['jenis']) ?: null;
        $data['jumlah_halaman'] = intval($data['jumlah_halaman']) ?: null;
        $data['jumlah_buku'] = intval($data['jumlah_buku']) ?: null;
        $data['deskripsi'] = strval($data['deskripsi']) ?: null;

        return $data;
    }
}
