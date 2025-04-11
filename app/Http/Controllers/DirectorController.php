<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Director;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DirectorController extends Controller
{
    public function index()
    {
        $director = Director::first();
        return view('director.index', compact('director'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ttd' => 'nullable|mimes:png,jpg,jpeg|max:12048', // Boleh kosong untuk update tanpa ganti gambar
        ]);

        // Cari director pertama (Jika sudah ada, update data ini)
        $director = Director::first();

        // Simpan tanda tangan jika ada file diunggah
        $fileName = $director->ttd ?? null; // Pakai tanda tangan lama jika tidak diubah
        if ($request->hasFile('ttd')) {
            $ext = $request->ttd->getClientOriginalExtension();
            $name = 'ttd_' . time() . '.' . $ext; // Nama unik
            $folderName = "storage/FILE/director_ttd/" . Carbon::now()->format('Y/m');
            $path = public_path($folderName);

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $request->ttd->move($path, $name);
            $fileName = $folderName . "/" . $name;
        }

        // Jika director sudah ada, update. Jika belum, buat baru.
        if ($director) {
            $director->update([
                'name' => $request->name,
                'ttd' => $fileName,
            ]);
        } else {
            $director = Director::create([
                'name' => $request->name,
                'ttd' => $fileName,
            ]);
        }

        return redirect()->route('director.index')->with('msg', 'Director berhasil disimpan!');
    }
    public function destroy($id)
    {
        $director = Director::findOrFail($id);
        if ($director->ttd) {
            Storage::delete($director->ttd);
        }
        $director->delete();

        return redirect()->route('director.index')->with('msg', 'Director berhasil dihapus!');
    }
}
