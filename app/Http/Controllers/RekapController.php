<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use PDF;

class RekapController extends Controller
{
    public function siswa(Request $request)
    {
        return Inertia::render('Rekap/Siswa', [
            'siswa' => Student::select('id', 'nis', 'nama', 'grade_id')
                ->with('grade')
                ->when(
                    $request->cari,
                    fn ($query) => $query
                        ->where('nis', 'like', "%$request->cari%")
                        ->orWhere('nama', 'like', "%$request->cari%")
                )
                ->has('grade')
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString(),

            'cari' => $request->cari,
            'kelas' => Grade::all()
        ]);
    }

    public function siswaPreview(Student $siswa)
    {
        return Inertia::render('Rekap/Preview', [
            'nama' => $siswa->nama,
            'riwayat' => $siswa
                ->loans()
                ->with('book:id,judul,pengarang')
                ->withTrashed()
                ->paginate(10)
        ]);
    }

    public function siswaExport(Student $siswa)
    {
        $pdf = PDF::loadView('exports.rekap.siswa', [
            'siswa' => $siswa->load('grade'),
            'buku' => $siswa->loans()
                ->with('book:id,judul,pengarang')
                ->withTrashed()
                ->get()
        ]);

        return $pdf->download("$siswa->nama.pdf");
    }

    public function siswaExportZip(Grade $kelas)
    {
        $siswa = Student::has('grade')
            ->where('grade_id', $kelas->id)
            ->select('id', 'nama', 'nis', 'grade_id')
            ->get();

        $path = "storage/export/$kelas->kelas";

        if (!file_exists($path)) mkdir($path);

        foreach ($siswa as $item) {
            $pdf = PDF::loadView('exports.rekap.siswa', [
                'siswa' => $item->load('grade'),
                'buku' => $item->loans()
                    ->with('book:id,judul,pengarang')
                    ->withTrashed()
                    ->get()
            ]);

            $pdf->save("$path/$item->nama.pdf");
        }

        $zip_file = "storage/export/Rekap Siswa Kelas $kelas->kelas.zip";
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $options = ['add_path' => $kelas->kelas . '/', 'remove_all_path' => TRUE];
        $zip->addGlob("$path/*.pdf", 0, $options);
        $zip->close();

        if (file_exists($zip_file)) File::cleanDirectory($path);

        return response()->download($zip_file);
    }

    // 
    public function staff(Request $request)
    {
        return Inertia::render('Rekap/Staff', [
            'staff' => Staff::select('id', 'nik', 'nama', 'unit_id')
                ->with('unit')
                ->when(
                    $request->cari,
                    fn ($query) => $query
                        ->where('nik', 'like', "%$request->cari%")
                        ->orWhere('nama', 'like', "%$request->cari%")
                )
                ->has('unit')
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString(),

            'cari' => $request->cari,
            'unit' => Unit::all()
        ]);
    }

    public function staffPreview(Staff $staff)
    {
        return Inertia::render('Rekap/Preview', [
            'nama' => $staff->nama,
            'riwayat' => $staff
                ->loans()
                ->with('book:id,judul,pengarang')
                ->withTrashed()
                ->paginate(10)
        ]);
    }

    public function staffExport(Staff $staff)
    {
        $pdf = PDF::loadView('exports.rekap.staff', [
            'staff' => $staff->load('unit'),
            'buku' => $staff->loans()
                ->with('book:id,judul,pengarang')
                ->withTrashed()
                ->get()
        ]);

        return $pdf->download("$staff->nama.pdf");
    }

    public function staffExportZip(Unit $unit)
    {
        $staff = Staff::has('unit')
            ->where('unit_id', $unit->id)
            ->select('id', 'nama', 'nik', 'unit_id')
            ->get();

        $path = "storage/export/$unit->unit";

        if (!file_exists($path)) mkdir($path);

        foreach ($staff as $item) {
            $pdf = PDF::loadView('exports.rekap.staff', [
                'staff' => $item->load('unit'),
                'buku' => $item->loans()
                    ->with('book:id,judul,pengarang')
                    ->withTrashed()
                    ->get()
            ]);

            $pdf->save("$path/$item->nama.pdf");
        }

        $zip_file = "storage/export/Rekap Karyawan Unit $unit->unit.zip";
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $options = ['add_path' => $unit->unit . '/', 'remove_all_path' => TRUE];
        $zip->addGlob("$path/*.pdf", 0, $options);
        $zip->close();

        if (file_exists($zip_file)) File::cleanDirectory($path);

        return response()->download($zip_file);
    }
}
