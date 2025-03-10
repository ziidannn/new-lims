<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\InstituteRegulation;
use App\Models\InstituteSubject;
use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\RegulationStandard;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Models\Sampling;
use App\Models\Subject;
use App\Models\SamplingTime;
use App\Models\SamplingTimeRegulation;
use Yajra\DataTables\Facades\DataTables;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $subjects = Subject::orderBy('name')->get();
        return view('result.index', compact('data', 'subjects'));
    }

    public function list_result(Request $request, $id)
    {
        // Ambil data institute berdasarkan ID yang dikirim
        $institute = Institute::findOrFail($id);

        // Ambil data yang berelasi dari tabel institute_sample_subjectss
        $institute_subject = InstituteSubject::where('institute_id', $id)->get();

        return view('result.list_result', compact('institute', 'institute_subject'));
    }

    public function getDataResult($id)
    {
        $data = InstituteRegulation::whereHas('instituteSubject', function ($query) use ($id) {
                $query->where('institute_id', $id);
            })
            ->with(['instituteSubject.subject', 'regulation']) // Memuat relasi yang dibutuhkan
            ->get()
            ->unique(function ($item) {
                return $item->institute_subject_id . '-' . $item->regulation_id;
            }) // Menghapus data yang duplikat berdasarkan kombinasi subject & regulation
            ->values(); // Reset index array

        return response()->json(['data' => $data]);
    }

    public function add_sample(Request $request, $id) {
        if ($request->isMethod('POST')) {
            // Cek apakah institute_id valid
            $institute = Institute::findOrFail($id);

            // Validasi data (buat institute_subject_id nullable)
            $validatedData = $request->validate([
                'no_sample' => ['required'],
                'sampling_location' => ['required'],
                'institute_subject_id' => ['required', 'integer'],
                'sampling_date' => ['required', 'date'],
                'sampling_time' => ['required'],
                'sampling_method' => ['required'],
                'date_received' => ['required', 'date'],
                'itd_start' => ['required'],
                'itd_end' => ['required'],
            ]);

            // Periksa apakah institute_subject_id valid atau tidak
            if ($request->filled('institute_subject_id')) {
                $instituteSubject = InstituteSubject::where('id', $request->institute_subject_id)
                    ->where('institute_id', $id)
                    ->exists();

                if ($instituteSubject) {
                    $validatedData['institute_subject_id'] = $request->institute_subject_id;
                }
            }

            // Tambahkan institute_id dari URL
            $validatedData['institute_id'] = $id;

            // **Cek apakah data sudah ada di tabel samplings untuk institute ini**
            $existingSample = Sampling::where('institute_id', $id)
                ->where('no_sample', $request->no_sample)
                ->first();

            if ($existingSample) {
                // Jika data sudah ada → UPDATE
                $existingSample->update($validatedData);
                $message = "Data Coa ({$request->no_sample}) updated successfully!";
                $alertType = 'warning'; // Notifikasi warna kuning untuk update
            } else {
                // Jika belum ada → CREATE baru
                Sampling::create($validatedData);
                $message = "Data Coa ({$request->no_sample}) saved successfully!";
                $alertType = 'success'; // Notifikasi warna hijau untuk create baru
            }
            // dd($validatedData);

            // Flash message untuk notifikasi
            return back()->with(['msg' => $message, 'alertType' => $alertType]);
        }

        // Data untuk ditampilkan di view
        $samplings = Sampling::where('institute_id', $id)->get();
        $institute = Institute::findOrFail($id);
        $subjects = Subject::orderBy('name')->get();
        $parameters = Parameter::orderBy('name')->get();

        return view('result.add_result', compact('samplings', 'institute', 'subjects', 'parameters'));
    }

    public function addAmbientAir(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::where('subject_id', $id)->first();

        if (!$instituteSubject) {
            return abort(404, 'Institute Subject not found');
        }

        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);

            foreach ($parameters as $parameterId) {
                if (!isset($request->sampling_time_id[$parameterId])) {
                    continue;
                }

                foreach ($request->sampling_time_id[$parameterId] as $index => $samplingTimeId) {
                    $regulationStandardId = $request->regulation_standard_id[$parameterId][$index] ?? null;
                    $testingResult = $request->testing_result[$parameterId][$index] ?? null;

                    if ($regulationStandardId === null || $testingResult === null) {
                        continue;
                    }

                    Result::updateOrCreate(
                        [
                            'sampling_id' => $id,
                            'parameter_id' => $parameterId,
                            'sampling_time_id' => $samplingTimeId,
                            'regulation_standard_id' => $regulationStandardId
                        ],
                        [
                            'testing_result' => $testingResult,
                            'unit' => $request->unit[$parameterId] ?? null,
                            'method' => $request->method[$parameterId] ?? null,
                        ]
                    );
                }
            }

            return redirect()->route('result.ambient_air', $institute->id)->with('msg', 'Results saved successfully!');
        }

        // Ambil regulation_id yang hanya berelasi dengan institute_subject yang sesuai
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();

        // Ambil parameter hanya yang sesuai dengan regulation_id yang valid
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        // Ambil SamplingTimeRegulation hanya yang berkaitan dengan parameter_id terkait
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        $result = Result::where('sampling_id', $instituteSubject->id)->get();

        return view('result.ambient_air', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'result','regulations'
        ));
    }

    public function addNoise(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::where('subject_id', $id)->first();

        if (!$instituteSubject) {
            return abort(404, 'Institute Subject not found');
        }

        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            if ($request->has('testing_result')) {
                foreach ($request->input('testing_result') as $key => $result) {
                    Result::updateOrCreate(
                        [
                            'sampling_id' => $instituteSubject->id,
                            'name_parameter' => $request->input('parameters')[$key] ?? null,
                        ],
                        [
                            'sampling_time' => $request->input('sampling_times')[$key] ?? null,
                            'testing_result' => $result,
                            'regulation' => $request->input('regulations')[$key] ?? null,
                            'unit' => $request->input('units')[$key] ?? null,
                            'method' => $request->input('methods')[$key] ?? null,
                        ]
                    );
                }
            }

            return back()->with('msg', 'Data Result saved successfully');
        }

        // Ambil regulation_id yang hanya berelasi dengan institute_subject yang sesuai
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');

        // Ambil parameter hanya yang sesuai dengan regulation_id yang valid
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        // Ambil SamplingTimeRegulation hanya yang berkaitan dengan parameter_id terkait
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        $result = Result::where('sampling_id', $instituteSubject->id)->get();

        return view('result.noise', compact(
            'institute', 'samplingTimes', 'regulationStandards', 'parameters',
            'regulations', 'samplings', 'samplingTimeRegulations', 'result'
        ));
    }

    public function addWasteWater(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::where('subject_id', $id)->first();

        if (!$instituteSubject) {
            return abort(404, 'Institute Subject not found');
        }

        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            if ($request->has('testing_result')) {
                foreach ($request->input('testing_result') as $key => $result) {
                    Result::updateOrCreate(
                        [
                            'sampling_id' => $instituteSubject->id,
                            'name_parameter' => $request->input('parameters')[$key] ?? null,
                        ],
                        [
                            'sampling_time' => $request->input('sampling_times')[$key] ?? null,
                            'testing_result' => $result,
                            'regulation' => $request->input('regulations')[$key] ?? null,
                            'unit' => $request->input('units')[$key] ?? null,
                            'method' => $request->input('methods')[$key] ?? null,
                        ]
                    );
                }
            }

            return back()->with('msg', 'Data Result saved successfully');
        }

        $samplingTimes = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();
        $regulations = Regulation::where('subject_id', $id)->get();
        $regulationsIds = $regulations->pluck('id');

        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        $instituteSamples = InstituteSubject::where('institute_id', $id)->get();
        $instituteSamplesIds = $instituteSamples->pluck('id');

        $samplings = Sampling::whereIn('institute_subject_id', $instituteSamplesIds)->get();
        $samplingsIds = $samplings->pluck('subject_id');

        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
        ->with(['samplingTime', 'regulationStandards'])
        ->get();

        return view('result.waste_water', compact(
            'institute', 'samplingTimes', 'regulationStandards', 'parameters',
            'regulations', 'samplings', 'samplingTimeRegulations'
        ));
    }

    public function data(Request $request)
    {
        $data = Result::with(['Subjects' => function ($query) {
                $query->select('sample_subjectss.id', 'sample_subjectss.name');
            }])
            ->select('*')
            ->orderBy("id")
            ->get();

        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_subjects'))) {
                    $instance->whereHas('Subjects', function ($q) use ($request) {
                        $q->where('sample_subjectss.id', $request->get('select_subjects'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where(function ($w) use ($search) {
                        $w->orWhere('no_sample', 'LIKE', "%$search%")
                            ->orWhere('date', 'LIKE', "%$search%")
                            ->orWhereHas('Subjects', function ($q) use ($search) {
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
    //     $result = Result::find($id);

    //     if ($result) {
    //         $result->delete();
    //         return response()->json(['message' => 'Result deleted'], 200);
    //     } else {
    //         return response()->json(['message' => 'Result not found'], 404);
    //     }
    // }
}
