<?php

namespace App\Http\Controllers;

use App\Models\FieldCondition;
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
            $instituteSubject = InstituteSubject::findOrFail($id);
            $institute = Institute::findOrFail($instituteSubject->institute_id);

            // Validasi data
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
                $instituteSubjectExists = InstituteSubject::where('id', $request->institute_subject_id)
                    ->where('institute_id', $id)
                    ->exists();

                if ($instituteSubjectExists) {
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

            return back()->with(['msg' => $message, 'alertType' => $alertType]);
        }

        // **Bagian GET request** (tidak membutuhkan `$instituteSubject`)
        $samplings = Sampling::where('institute_id', $id)->get();
        $institute = Institute::findOrFail($id);
        $subjects = Subject::orderBy('name')->get();
        $parameters = Parameter::orderBy('name')->get();
        $instituteSubjects = InstituteSubject::where('institute_id', $id)->get();

        return view('result.add_result', compact(
            'samplings', 'institute', 'subjects',
            'parameters', 'instituteSubjects'));
    }

    // public function add_sample_new(Request $request, $id) {
    //     if ($request->isMethod('POST')) {
    //         $instituteSubject = InstituteSubject::findOrFail($id);
    //         $institute = Institute::findOrFail($instituteSubject->institute_id);

    //         // Validasi data
    //         $validatedData = $request->validate([
    //             'no_sample' => ['required'],
    //             'sampling_location' => ['required'],
    //             'institute_subject_id' => ['required', 'integer'],
    //             'sampling_date' => ['required', 'date'],
    //             'sampling_time' => ['required'],
    //             'sampling_method' => ['required'],
    //             'date_received' => ['required', 'date'],
    //             'itd_start' => ['required'],
    //             'itd_end' => ['required'],
    //         ]);

    //         // Periksa apakah institute_subject_id valid atau tidak
    //         if ($request->filled('institute_subject_id')) {
    //             $instituteSubjectExists = InstituteSubject::where('id', $request->institute_subject_id)
    //                 ->where('institute_id', $id)
    //                 ->exists();

    //             if ($instituteSubjectExists) {
    //                 $validatedData['institute_subject_id'] = $request->institute_subject_id;
    //             }
    //         }

    //         // Tambahkan institute_id dari URL
    //         $validatedData['institute_id'] = $id;

    //         // **Cek apakah data sudah ada di tabel samplings untuk institute ini**
    //         $existingSample = Sampling::where('institute_id', $id)
    //             ->where('no_sample', $request->no_sample)
    //             ->first();

    //         if ($existingSample) {
    //             // Jika data sudah ada → UPDATE
    //             $existingSample->update($validatedData);
    //             $message = "Data Coa ({$request->no_sample}) updated successfully!";
    //             $alertType = 'warning'; // Notifikasi warna kuning untuk update
    //         } else {
    //             // Jika belum ada → CREATE baru
    //             Sampling::create($validatedData);
    //             $message = "Data Coa ({$request->no_sample}) saved successfully!";
    //             $alertType = 'success'; // Notifikasi warna hijau untuk create baru
    //         }

    //         return back()->with(['msg' => $message, 'alertType' => $alertType]);
    //     }

    //     // **Bagian GET request** (tidak membutuhkan `$instituteSubject`)
    //     $samplings = Sampling::where('institute_id', $id)->get();
    //     $institute = Institute::findOrFail($id);
    //     $subjects = Subject::orderBy('name')->get();
    //     $parameters = Parameter::orderBy('name')->get();
    //     $instituteSubjects = InstituteSubject::where('institute_id', $id)->get();

    //     return view('result.add_result', compact(
    //         'samplings', 'institute', 'subjects',
    //         'parameters', 'instituteSubjects'));
    // }


    public function addAmbientAir(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        // ✅ Periksa apakah ada data Sampling dengan institute_subject_id terkait
        // $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();

        // if (!$sampling) {
        //     return back()->withErrors(['msg' => 'Sampling belum tersedia untuk institute_subject ini.']);
        // }

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

                    // ✅ Simpan atau update Result
                    $result = Result::updateOrCreate(
                        [
                            'sampling_id' => $instituteSubject->id,
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

                    if ($result && isset($result->id)) { // Pastikan $result tidak null dan memiliki ID
                        // ✅ Ambil hanya satu FieldCondition berdasarkan result_id
                        $fieldCondition = FieldCondition::where('result_id', $result->id)->first();

                        if ($fieldCondition) {
                            // 🔹 Jika sudah ada, update datanya
                            $fieldCondition->update([
                                'coordinate' => $request->coordinate ?? $fieldCondition->coordinate,
                                'temperature' => $request->temperature ?? $fieldCondition->temperature,
                                'pressure' => $request->pressure ?? $fieldCondition->pressure,
                                'humidity' => $request->humidity ?? $fieldCondition->humidity,
                                'wind_speed' => $request->wind_speed ?? $fieldCondition->wind_speed,
                                'wind_direction' => $request->wind_direction ?? $fieldCondition->wind_direction,
                                'weather' => $request->weather ?? $fieldCondition->weather,
                            ]);
                        } else {
                            // 🔹 Jika belum ada, buat baru dengan hanya satu result_id
                            FieldCondition::create([
                                'result_id' => $result->id, // Hanya gunakan satu result_id
                                'coordinate' => $request->coordinate ?? null,
                                'temperature' => $request->temperature ?? null,
                                'pressure' => $request->pressure ?? null,
                                'humidity' => $request->humidity ?? null,
                                'wind_speed' => $request->wind_speed ?? null,
                                'wind_direction' => $request->wind_direction ?? null,
                                'weather' => $request->weather ?? null,
                            ]);
                        }
                    } else {
                        return back()->with('error', 'Data result tidak ditemukan.');
                    }
                }
            }

            $parameterNames = Parameter::whereIn('id', $parameters)->pluck('name')->toArray();
            $parameterNamesList = implode(', ', $parameterNames);

            return redirect()->route('result.ambient_air', $institute->id)
                ->with('msg', "Results saved successfully for Parameters: $parameterNamesList");
        }

        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
            $results = Result::
            whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id'))
            ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id'))
            ->get()
            ->groupBy(function ($item) {
                return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
            });

        // ✅ Ambil hanya satu result_id dari hasil query
        $firstResult = $results->flatten()->first(); // Ambil satu data dari collection

        $fieldCondition = null; // Default jika tidak ada result

        if ($firstResult) {
            $fieldCondition = FieldCondition::where('result_id', $firstResult->id)->first();
        }
        return view('result.ambient_air', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'fieldCondition'
        ));
    }

    // public function addAmbientAirNew(Request $request, $id)
    // {
    //     $instituteSubject = InstituteSubject::findOrFail($id);
    //     $institute = Institute::findOrFail($instituteSubject->institute_id);

    //     // ✅ Periksa apakah ada data Sampling dengan institute_subject_id terkait
    //     // $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();

    //     // if (!$sampling) {
    //     //     return back()->withErrors(['msg' => 'Sampling belum tersedia untuk institute_subject ini.']);
    //     // }

    //     if ($request->isMethod('POST')) {
    //         $parameters = $request->input('parameter_id', []);

    //         foreach ($parameters as $parameterId) {
    //             if (!isset($request->sampling_time_id[$parameterId])) {
    //                 continue;
    //             }

    //             foreach ($request->sampling_time_id[$parameterId] as $index => $samplingTimeId) {
    //                 $regulationStandardId = $request->regulation_standard_id[$parameterId][$index] ?? null;
    //                 $testingResult = $request->testing_result[$parameterId][$index] ?? null;

    //                 if ($regulationStandardId === null || $testingResult === null) {
    //                     continue;
    //                 }

    //                 // ✅ Simpan atau update Result
    //                 $result = Result::updateOrCreate(
    //                     [
    //                         'sampling_id' => $instituteSubject->id,
    //                         'parameter_id' => $parameterId,
    //                         'sampling_time_id' => $samplingTimeId,
    //                         'regulation_standard_id' => $regulationStandardId
    //                     ],
    //                     [
    //                         'testing_result' => $testingResult,
    //                         'unit' => $request->unit[$parameterId] ?? null,
    //                         'method' => $request->method[$parameterId] ?? null,
    //                     ]
    //                 );

    //                 if ($result && isset($result->id)) { // Pastikan $result tidak null dan memiliki ID
    //                     // ✅ Ambil hanya satu FieldCondition berdasarkan result_id
    //                     $fieldCondition = FieldCondition::where('result_id', $result->id)->first();

    //                     if ($fieldCondition) {
    //                         // 🔹 Jika sudah ada, update datanya
    //                         $fieldCondition->update([
    //                             'coordinate' => $request->coordinate ?? $fieldCondition->coordinate,
    //                             'temperature' => $request->temperature ?? $fieldCondition->temperature,
    //                             'pressure' => $request->pressure ?? $fieldCondition->pressure,
    //                             'humidity' => $request->humidity ?? $fieldCondition->humidity,
    //                             'wind_speed' => $request->wind_speed ?? $fieldCondition->wind_speed,
    //                             'wind_direction' => $request->wind_direction ?? $fieldCondition->wind_direction,
    //                             'weather' => $request->weather ?? $fieldCondition->weather,
    //                         ]);
    //                     } else {
    //                         // 🔹 Jika belum ada, buat baru dengan hanya satu result_id
    //                         FieldCondition::create([
    //                             'result_id' => $result->id, // Hanya gunakan satu result_id
    //                             'coordinate' => $request->coordinate ?? null,
    //                             'temperature' => $request->temperature ?? null,
    //                             'pressure' => $request->pressure ?? null,
    //                             'humidity' => $request->humidity ?? null,
    //                             'wind_speed' => $request->wind_speed ?? null,
    //                             'wind_direction' => $request->wind_direction ?? null,
    //                             'weather' => $request->weather ?? null,
    //                         ]);
    //                     }
    //                 } else {
    //                     return back()->with('error', 'Data result tidak ditemukan.');
    //                 }
    //             }
    //         }

    //         $parameterNames = Parameter::whereIn('id', $parameters)->pluck('name')->toArray();
    //         $parameterNamesList = implode(', ', $parameterNames);

    //         return redirect()->route('result.ambient_air', $institute->id)
    //             ->with('msg', "Results saved successfully for Parameters: $parameterNamesList");
    //     }

    //     $subject = Subject::where('id', $instituteSubject->subject_id)->first();
    //     $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
    //     $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
    //         ->pluck('regulation_id');
    //     $regulations = Regulation::whereIn('id', $regulationsIds)->get();
    //     $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
    //     $parametersIds = $parameters->pluck('id');
    //     $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
    //         ->with(['samplingTime', 'regulationStandards'])
    //         ->get();
    //         $results = Result::
    //         whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id'))
    //         ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id'))
    //         ->get()
    //         ->groupBy(function ($item) {
    //             return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
    //         });

    //     // ✅ Ambil hanya satu result_id dari hasil query
    //     $firstResult = $results->flatten()->first(); // Ambil satu data dari collection

    //     $fieldCondition = null; // Default jika tidak ada result

    //     if ($firstResult) {
    //         $fieldCondition = FieldCondition::where('result_id', $firstResult->id)->first();
    //     }
    //     return view('result.ambient_air', compact(
    //         'institute', 'parameters', 'samplingTimeRegulations', 'results',
    //         'regulations', 'subject', 'instituteSubject', 'sampling', 'fieldCondition'
    //     ));
    // }


    public function addNoise(Request $request, $id)
    {
    $instituteSubject = InstituteSubject::findOrFail($id);
    $institute = Institute::findOrFail($instituteSubject->institute_id);

    // Ambil satu regulation yang sesuai dengan institute_subject_id
    $regulation = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
        ->with('regulation') // Pastikan ada relasi ke Regulation
        ->first();

    if ($request->isMethod('POST')) {
        $request->validate([
            'testing_result.*' => 'nullable|string',
            'unit.*' => 'nullable|string',
            'method.*' => 'nullable|string',
            'time.*' => 'nullable|string',
            'noise' => 'nullable|string',
            'leq.*' => 'nullable|string',
            'ls' => 'nullable|string',
            'lm' => 'nullable|string',
            'lsm' => 'nullable|string',
            'regulatory_standard.*' => 'nullable|string',
            'location.*' => 'nullable|string'
        ]);

        Result::updateOrCreate(
            [
                'sampling_id' => $instituteSubject->id,
            ],
            [
                'testing_result' => json_encode($request->input('testing_result')),
                'unit' => json_encode($request->input('unit')),
                'method' => json_encode($request->input('method')),
                'time' => json_encode($request->input('time')),
                'noise' => $request->input('noise'),
                'leq' => json_encode($request->input('leq')),
                'ls' => $request->input('ls'),
                'lm' => $request->input('lm'),
                'lsm' => $request->input('lsm'),
                'regulatory_standard' => json_encode($request->input('regulatory_standard')),
                'location' => json_encode($request->input('location')),
            ]
        );

        return redirect()->route('result.list_result', $institute->id)
            ->with('msg', 'Results saved successfully');
    }

    $subject = Subject::find($instituteSubject->subject_id);

    // Ambil data Sampling berdasarkan institute_subject_id
    $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();

    // Ambil hanya regulation_id pertama yang berelasi dengan institute_subject
    $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
        ->limit(1) // Pastikan hanya mengambil satu regulation_id
        ->pluck('regulation_id');

    $regulations = Regulation::whereIn('id', $regulationsIds)->get();

    // Ambil parameter hanya untuk regulation_id yang valid
    $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
    $parametersIds = $parameters->pluck('id');

    // Ambil SamplingTimeRegulation hanya untuk parameter_id terkait
    $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
        ->with(['samplingTime', 'regulationStandards'])
        ->get();

    $results = Result::where('sampling_id', $instituteSubject->id)->get();

    // Decode JSON hanya jika data tidak null
    foreach ($results as $result) {
        $result->location = !is_null($result->location) ? json_decode($result->location, true) : [];
        $result->testing_result = !is_null($result->testing_result) ? json_decode($result->testing_result, true) : [];
        $result->unit = !is_null($result->unit) ? json_decode($result->unit, true) : [];
        $result->method = !is_null($result->method) ? json_decode($result->method, true) : [];
        $result->time = !is_null($result->time) ? json_decode($result->time, true) : [];
        $result->regulatory_standard = !is_null($result->regulatory_standard) ? json_decode($result->regulatory_standard, true) : [];
    }

    return view('result.noise', compact(
        'institute', 'parameters', 'regulations',
        'samplingTimeRegulations', 'results', 'subject', 'instituteSubject', 'sampling'
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
