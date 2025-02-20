<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\Sampling;
use App\Models\SampleDescription;
use Yajra\DataTables\Facades\DataTables;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $description = SampleDescription::orderBy('name')->get();
        return view('resume.index', compact('data', 'description'));
    }

    public function create(Request $request)
{
    if ($request->isMethod('POST')) {
        $this->validate($request, [
            'customer' => ['required'],
            'address' => ['required'],
            'contact_name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'sample_description_id' => ['required', 'array'], // Pastikan ini array
            'sample_taken_by' => ['required'],
            'sample_receive_date' => ['required'],
            'sample_analysis_date' => ['required'],
            'report_date' => ['required']
        ]);

        // Buat Resume baru
        $resume = Resume::create([
            'customer' => $request->customer,
            'address' => $request->address,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sample_taken_by' => $request->sample_taken_by,
            'sample_receive_date' => $request->sample_receive_date,
            'sample_analysis_date' => $request->sample_analysis_date,
            'report_date' => $request->report_date,
        ]);

        // Simpan sample_description_id ke tabel pivot
        if ($request->has('sample_description_id')) {
            $resume->sampleDescriptions()->attach($request->sample_description_id);
        }

        return redirect()->route('resume.index')->with('msg', 'Data berhasil ditambahkan');
    }

    $data = Resume::all();
    $description = SampleDescription::orderBy('name')->get();
    return view('resume.create', compact('data', 'description'));
}

    public function data(Request $request)
    {
        $data = Resume::with(['sampleDescriptions' => function ($query) {
                $query->select('sample_descriptions.id', 'sample_descriptions.name');
            }])
            ->select('*')
            ->orderBy("id")
            ->get();

        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_description'))) {
                    $instance->whereHas('sampleDescriptions', function ($q) use ($request) {
                        $q->where('sample_descriptions.id', $request->get('select_description'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where(function ($w) use ($search) {
                        $w->orWhere('no_sample', 'LIKE', "%$search%")
                            ->orWhere('date', 'LIKE', "%$search%")
                            ->orWhereHas('sampleDescriptions', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    });
                }
            })
            ->make(true);
    }


    // public function delete(Request $request)
    // {
    //     $id = $request->input('id'); // Get the ID to delete
    //     $resume = Resume::find($id);

    //     if ($resume) {
    //         $resume->delete();
    //         return response()->json(['message' => 'Resume deleted'], 200);
    //     } else {
    //         return response()->json(['message' => 'Resume not found'], 404);
    //     }
    // }
}
