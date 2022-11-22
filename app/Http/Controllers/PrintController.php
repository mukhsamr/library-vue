<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrintController extends Controller
{
    public function buku(Request $request)
    {
        $baris = $request->baris ?? 10;

        return Inertia::render('Print/Buku', [
            'buku' => Book::select('id', 'judul', 'nik', 'jumlah_buku')
                ->when($request->cari, function ($query) use ($request) {
                    return $query
                        ->where('judul', 'like', "%$request->cari%")
                        ->orWhere('nik', 'like', "%$request->cari%");
                })
                ->paginate($baris)
                ->withQueryString(),

            'baris' => $baris,
            'cari' => $request->cari,

            'barcode' => Inertia::lazy(function () use ($request) {
                $buku = Book::select('nik', 'judul', 'klasifikasi', 'jumlah_buku', 'pengarang', 'jenis')
                    ->whereIn('id', $request->check ?? [])
                    ->get();

                $transform = collect();
                foreach ($buku as $item) {
                    $item->append(['barcode', 'pengarang_kode', 'judul_kode', 'jenis_warna']);

                    if ($item->jumlah_buku > 1) {
                        foreach (range(1, $item->jumlah_buku) as $value) {
                            $clone = clone $item;
                            $clone['copy'] = "C.$value";
                            $transform[] = $clone;
                        }
                    } else {
                        $transform[] = $item;
                    }
                }

                return $transform;
            })
        ]);
    }

    public function siswa(Request $request)
    {
        $baris = $request->baris ?? 10;

        return Inertia::render('Print/Siswa', [
            'siswa' => Student::with('grade')
                ->select('id', 'nama', 'nis', 'grade_id')
                ->when($request->cari, function ($query) use ($request) {
                    return $query
                        ->where('nis', 'like', "%$request->cari%")
                        ->orWhere('nama', 'like', "%$request->cari%");
                })
                ->has('grade')
                ->orderBy('nama')
                ->paginate($baris)
                ->withQueryString(),

            'baris' => $baris,
            'cari' => $request->cari,

            'barcode' => Inertia::lazy(fn () => Student::select('nis', 'nama')
                ->whereIn('id', $request->check ?? [])
                ->orderBy('nama')
                ->get()
                ->each
                ->append('barcode'))
        ]);
    }

    public function staff(Request $request)
    {
        $baris = $request->baris ?? 10;

        return Inertia::render('Print/Staff', [
            'staff' => Staff::with('unit')
                ->select('id', 'nama', 'nik', 'unit_id')
                ->when($request->cari, function ($query) use ($request) {
                    return $query
                        ->where('nik', 'like', "%$request->cari%")
                        ->orWhere('nama', 'like', "%$request->cari%");
                })
                ->has('unit')
                ->orderBy('nama')
                ->paginate($baris)
                ->withQueryString(),

            'baris' => $baris,
            'cari' => $request->cari,

            'barcode' => Inertia::lazy(fn () => Staff::select('nik', 'nama')
                ->whereIn('id', $request->check ?? [])
                ->orderBy('nama')
                ->get()
                ->each
                ->append('barcode'))
        ]);
    }
}
