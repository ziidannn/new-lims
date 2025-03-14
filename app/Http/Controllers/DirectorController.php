<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Import Carbon
use Illuminate\Support\Facades\File; // Import File
use App\Models\Director;

use Illuminate\Http\Request;

class DirectorController extends Controller
{

    public function index()
    {
        $data = Director::all();
        return view('director.index', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $director = Director::findOrFail($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'ttd' => ['nullable', 'mimes:png', 'max:2048'], // hanya PNG, max 2MB
        ]);

        $fileName = $director->ttd; // Default ke ttd lama jika tidak ada update

        if ($request->hasFile('ttd')) {
            $ext = $request->ttd->extension();
            $name = 'ttd_' . $id . '.' . $ext; // Format nama file: ttd_ID.png
            $folderName = "storage/FILE/director_ttd/" . Carbon::now()->format('Y/m');
            $path = public_path() . "/" . $folderName;

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $upload = $request->ttd->move($path, $name);
            if ($upload) {
                $fileName = $folderName . "/" . $name;
            }
        }

        $director->update([
            'name' => $request->name,
            'ttd' => $fileName,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('director.edit', $id)->with('msg', 'Data Director telah diperbarui!');
    }


}
