<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\InstituteSampleDescription;
use App\Models\Parameter;
use App\Models\Resume;
use Illuminate\Http\Request;
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

    public function list_resume(Request $request, $id)
    {
        // Ambil data institute berdasarkan ID yang dikirim
        $institute = Institute::findOrFail($id);

        // Ambil data yang berelasi dari tabel institute_sample_descriptions
        $institute_description = InstituteSampleDescription::where('institute_id', $id)->get();

        return view('resume.list_resume', compact('institute', 'institute_description'));
    }

    public function getDataResume($id)
    {
        $data = InstituteSampleDescription::where('institute_id', $id)
            ->with('sampleDescription') // Pastikan relasi ke sample_description dimuat
            ->get();

        return response()->json(['data' => $data]);
    }

    public function add_sample(Request $request, $id) {
        if ($request->isMethod('POST')) {
            $institute = Institute::findOrFail($id);

            $validatedData = $request->validate([
                'no_sample' => ['required'],
                'sampling_location' => ['required'],
                'sample_description_id' => ['required', 'integer'], // Pastikan hanya menerima integer
                'date' => ['required'],
                'time' => ['required'],
                'method' => ['required'],
                'date_received' => ['required'],
                'itd_start' => ['required'],
                'itd_end' => ['required'],
                'testing_results.*' => ['required'], // Validasi untuk inputan testing result
            ]);

            // Tambahkan institute_id secara manual sebelum menyimpan
            $validatedData['institute_id'] = $id;

            // Simpan data ke tabel Sampling
            $sampling = Sampling::create($validatedData);

            return back()->with('msg', 'Data Sample (' . $request->no_sample . ') and Resume saved successfully');
        }

        $samplings = Sampling::all();
        $institute = Institute::findOrFail($id);
        $description = SampleDescription::orderBy('name')->get();
        $parameters = Parameter::orderBy('name')->get();
        return view('resume.add_resume', compact('samplings','institute', 'description','parameters'));
    }

    public function add_resume(Request $request, $id) {
        if ($request->isMethod('POST')) {
            $institute = Institute::findOrFail($id);

            $validatedData = $request->validate([
                'no_sample' => ['required'],
                'sampling_location' => ['required'],
                'sample_description_id' => ['required', 'integer'], // Pastikan hanya menerima integer
                'date' => ['required'],
                'time' => ['required'],
                'method' => ['required'],
                'date_received' => ['required'],
                'itd_start' => ['required'],
                'itd_end' => ['required'],
                'testing_results.*' => ['required'], // Validasi untuk inputan testing result
            ]);

            // Tambahkan institute_id secara manual sebelum menyimpan
            $validatedData['institute_id'] = $id;

            // Simpan data ke tabel Sampling
            $sampling = Sampling::create($validatedData);

            // Simpan data ke tabel Resumes berdasarkan Sampling ID
            if ($request->has('testing_results')) {
                foreach ($request->testing_results as $key => $result) {
                    Resume::create([
                        'sampling_id' => $sampling->id,
                        'sample_description_id' => $request->sample_description_id,
                        'name_parameter' => $request->parameters[$key] ?? null,
                        'sampling_time' => $request->sampling_times[$key] ?? null,
                        'testing_result' => $result,
                        'regulation' => $request->regulations[$key] ?? null,
                        'unit' => $request->units[$key] ?? null,
                        'method' => $request->methods[$key] ?? null,
                    ]);
                }
            }

            return back()->with('msg', 'Data Resume (' . $request->no_sample . ') saved successfully');
        }

        $samplings = Sampling::all();
        $resumes = Resume::all();
        $institute = Institute::findOrFail($id);
        $description = SampleDescription::orderBy('name')->get();
        return view('resume.add_resume', compact('samplings','resumes','institute', 'description'));
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
