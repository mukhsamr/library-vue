<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Staff;
use App\Models\Unit;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitController extends Controller
{
    use HasTryCatch;

    public function index()
    {
        return Inertia::render('Unit/Daftar', [
            'unit' => Unit::withCount('staff')->get()
        ]);
    }

    public function tambah()
    {
        return Inertia::render('Unit/Form', [
            'judul' => 'Tambah Unit',
        ]);
    }

    public function edit(Unit $unit)
    {
        return Inertia::render('Unit/Form', [
            'judul' => 'Edit Unit ' . $unit->unit,
            'unit' => $unit
        ]);
    }

    public function store(UnitRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Unit::create($request->validated()),
            message: "tambah unit $request->unit"
        );

        return back()->with('alert', $alert);
    }

    public function update(UnitRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Unit::where('id', $request->id)->update($request->validated()),
            message: "edit unit $request->unit"
        );

        return back()->with('alert', $alert);
    }

    public function hapus(Unit $unit)
    {
        $alert = $this::execute(
            try: fn () => $unit->delete(),
            message: "hapus unit $unit->unit"
        );

        return back()->with('alert', $alert);
    }

    public function trash()
    {
        return Inertia::render('Unit/Trash', [
            'unit' => Unit::withCount('staff')->onlyTrashed()->get()
        ]);
    }

    public function restore(Unit $unit)
    {
        $alert = $this::execute(
            try: fn () => $unit->restore(),
            message: "pulihkan unit: $unit->unit"
        );

        return back()->with('alert', $alert);
    }

    public function destroy(Unit $unit)
    {
        $alert = $this::execute(
            try: fn () => $unit->forceDelete(),
            message: "hapus permanen unit: $unit->unit"
        );

        return back()->with('alert', $alert);
    }

    public function list(Unit $unit)
    {
        return Inertia::render('Unit/List', [
            'judul' => 'Karyawan unit ' . $unit->unit,
            'staff' => $unit->staff()->select('id', 'nama', 'nik')->get(),
            'unit' => Unit::select('id', 'unit')->get()->except($unit->id)
        ]);
    }

    public function updatelist(Request $request)
    {
        $alert = $this::execute(
            try: fn () => Staff::whereIn('id', $request->staff)->update(['unit_id' => $request->unit]),
            message: 'update unit karyawan'
        );

        return back()->with('alert', $alert);
    }
}
