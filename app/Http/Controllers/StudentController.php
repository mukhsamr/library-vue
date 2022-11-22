<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Grade;
use App\Models\Student;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    use HasTryCatch;

    public function index(Request $request)
    {
        return Inertia::render('Siswa/Daftar', [
            'kelas' => Grade::all(),
            'siswa' => Student::has('grade')
                ->with('grade')
                ->select('id', 'nama', 'nis', 'grade_id')
                ->when(
                    $request->kelas,
                    fn ($query) => $query->where('grade_id', $request->kelas)
                )
                ->when(
                    $request->keyword,
                    fn ($query) => $query->where('nama', 'like', "%$request->keyword%")
                        ->orWhere('nis', 'like', "%$request->keyword%")
                )
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString(),
            'cari' => $request->kelas,
            'keyword' => $request->keyword
        ]);
    }

    public function form(Request $request)
    {
        return Inertia::render('Siswa/Form', [
            'siswaList' => Student::has('grade')->select('nis', 'nama')->orderBy('nama')->get(),
            'nis' => $request->nis,
            'siswa' => Student::with('grade')->firstWhere('nis', $request->nis) ?? [],
            'kelas' => Grade::all()
        ]);
    }

    public function store(StudentRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Student::create($request->validated()),
            message: "tambah siswa: $request->nama"
        );

        return back()->with('alert', $alert);
    }

    public function update(StudentRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Student::where('id', $request->id)->update($request->validated()),
            message: "edit siswa: $request->nama"
        );

        return back()->with('alert', $alert);
    }

    public function nonaktif(Student $siswa)
    {
        $alert = $this::execute(
            try: fn () => $siswa->delete(),
            message: "nonaktifkan $siswa->nama"
        );

        return back()->with('alert', $alert);
    }

    public function trash(Request $request)
    {
        return Inertia::render('Siswa/Trash', [
            'siswa' => Student::has('grade')
                ->with('grade')
                ->select('id', 'nama', 'nis', 'grade_id', 'deleted_at')
                ->onlyTrashed()
                ->when($request->cari, function ($query) use ($request) {
                    $query->where('nama', 'like', "%$request->cari%")
                        ->orWhere('nis', 'like', "%$request->cari%");
                })
                ->paginate(10)
                ->withQueryString()
                ->through(function ($item) {
                    $item->append('dihapus');
                    return $item;
                }),

            'cari' => $request->cari
        ]);
    }

    public function restore(Student $siswa)
    {
        $alert = $this::execute(
            try: fn () => $siswa->restore(),
            message: "pulihkan: $siswa->nama"
        );

        return back()->with('alert', $alert);
    }
}
