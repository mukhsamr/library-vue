<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Models\Student;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeController extends Controller
{
    use HasTryCatch;

    public function index()
    {
        return Inertia::render('Kelas/Daftar', [
            'kelas' => Grade::withCount('students')->get()
        ]);
    }

    public function tambah()
    {
        return Inertia::render('Kelas/Form', [
            'judul' => 'Tambah Kelas',
        ]);
    }

    public function edit(Grade $kelas)
    {
        return Inertia::render('Kelas/Form', [
            'judul' => 'Edit Kelas ' . $kelas->kelas,
            'kelas' => $kelas,
        ]);
    }

    public function store(GradeRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Grade::create($request->validated()),
            message: "tambah kelas $request->kelas"
        );

        return back()->with('alert', $alert);
    }

    public function update(GradeRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Grade::where('id', $request->id)->update($request->validated()),
            message: "edit kelas $request->kelas"
        );

        return back()->with('alert', $alert);
    }

    public function hapus(Grade $kelas)
    {
        $alert = $this::execute(
            try: fn () => $kelas->delete(),
            message: "hapus kelas $kelas->kelas"
        );

        return back()->with('alert', $alert);
    }

    public function trash()
    {
        return Inertia::render('Kelas/Trash', [
            'kelas' => Grade::withCount('students')->onlyTrashed()->get()
        ]);
    }

    public function restore(Grade $kelas)
    {
        $alert = $this::execute(
            try: fn () => $kelas->restore(),
            message: "pulihkan kelas: $kelas->kelas"
        );

        return back()->with('alert', $alert);
    }

    public function destroy(Grade $kelas)
    {
        $alert = $this::execute(
            try: fn () => $kelas->forceDelete(),
            message: "hapus permanen kelas: $kelas->kelas"
        );

        return back()->with('alert', $alert);
    }

    public function list(Grade $kelas)
    {
        return Inertia::render('Kelas/List', [
            'judul' => 'Siswa kelas ' . $kelas->kelas,
            'siswa' => $kelas->students()->select('id', 'nama', 'nis')->get(),
            'kelas' => Grade::select('id', 'kelas')->get()->except($kelas->id)
        ]);
    }

    public function updatelist(Request $request)
    {
        $alert = $this::execute(
            try: fn () => Student::whereIn('id', $request->siswa)->update(['grade_id' => $request->kelas]),
            message: 'update kelas siswa'
        );

        return back()->with('alert', $alert);
    }
}
