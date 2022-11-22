<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Models\Staff;
use App\Models\Unit;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    use HasTryCatch;

    public function index(Request $request)
    {
        return Inertia::render('Staff/Daftar', [
            'unit' => Unit::all(),
            'staff' => Staff::has('unit')
                ->with('unit')
                ->select('id', 'nama', 'nik', 'unit_id')
                ->when(
                    $request->unit,
                    fn ($query) => $query->where('unit_id', $request->unit)
                )
                ->when(
                    $request->keyword,
                    fn ($query) => $query->where('nama', 'like', "%$request->keyword%")
                        ->orWhere('nik', 'like', "%$request->keyword%")
                )
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString(),
            'cari' => $request->unit,
            'keyword' => $request->keyword
        ]);
    }

    public function form(Request $request)
    {
        return Inertia::render('Staff/Form', [
            'staffList' => Staff::has('unit')->select('nik', 'nama')->orderBy('nama')->get(),
            'nik' => $request->nik,
            'staff' => Staff::with('unit')->firstWhere('nik', $request->nik) ?? [],
            'unit' => Unit::all()
        ]);
    }

    public function store(StaffRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Staff::create($request->validated()),
            message: "tambah staff: $request->nama"
        );

        return back()->with('alert', $alert);
    }

    public function update(StaffRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Staff::where('id', $request->id)->update($request->validated()),
            message: "edit staff: $request->nama"
        );

        return back()->with('alert', $alert);
    }

    public function nonaktif(Staff $staff)
    {
        $alert = $this::execute(
            try: fn () => $staff->delete(),
            message: "nonaktifkan $staff->nama"
        );

        return back()->with('alert', $alert);
    }

    public function trash(Request $request)
    {
        return Inertia::render('Staff/Trash', [
            'staff' => Staff::has('unit')
                ->with('unit')
                ->select('id', 'nama', 'nik', 'unit_id', 'deleted_at')
                ->onlyTrashed()
                ->when($request->cari, function ($query) use ($request) {
                    $query->where('nama', 'like', "%$request->cari%")
                        ->orWhere('nik', 'like', "%$request->cari%");
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

    public function restore(Staff $staff)
    {
        $alert = $this::execute(
            try: fn () => $staff->restore(),
            message: "pulihkan: $staff->nama"
        );

        return back()->with('alert', $alert);
    }
}
