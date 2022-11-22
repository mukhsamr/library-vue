<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    use HasTryCatch;

    public function index()
    {
        return Inertia::render('User', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $alert = $this::execute(
            try: function () use ($request) {

                $update = $request->password
                    ? $request->only(['nama', 'password'])
                    : $request->only(['nama']);

                // Cek jika ada foto
                if ($file = $request->file('foto')) {

                    $name = str($request->nama)->slug()->append('.' . $file->extension());
                    Image::make($file)->save(Storage::path('images/' . $name->value()));

                    $update = array_merge($update, ['foto' => $name->value()]);
                }

                User::find($request->id)->update($update);
            },
            message: 'update profil'
        );

        return back()->with('alert', $alert);
    }
}
