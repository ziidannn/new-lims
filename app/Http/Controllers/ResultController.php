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
                $message = "Data Coa ({$institute->no_coa}.{$request->no_sample}) updated successfully!";
                $alertType = 'warning'; // Notifikasi warna kuning untuk update
            } else {
                // Jika belum ada → CREATE baru
                Sampling::create($validatedData);
                $message = "Data Coa ({$institute->no_coa}.{$request->no_sample}) saved successfully!";
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

    public function add_sample_new(Request $request, $id) {
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

            // Tambahkan institute_id dari URL
            $validatedData['institute_id'] = $id;

            // **Buat data baru di tabel samplings (tidak update, selalu tambah data baru)**
            Sampling::create($validatedData);

            return back()->with(['msg' => "Data Coa ({$request->institute->no_coa}).({$request->no_sample}) saved successfully!", 'alertType' => 'success']);
        }

        // **Bagian GET request**
        $samplings = Sampling::where('institute_id', $id)->get();
        $institute = Institute::findOrFail($id);
        $subjects = Subject::orderBy('name')->get();
        $parameters = Parameter::orderBy('name')->get();
        $instituteSubjects = InstituteSubject::where('institute_id', $id)->get();

        return view('result.add_result', compact(
            'samplings', 'institute', 'subjects', 'parameters', 'instituteSubjects'
        ));
    }

    public function addAmbientAir(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->latest('id')
                ->first(); // Ensure this doesn't return null

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
                            'sampling_id' => $samplings->id,
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

            $parameterNames = Parameter::whereIn('id', $parameters)->pluck('name')->toArray();
            $parameterNamesList = implode(', ', $parameterNames);

             return redirect()->back()->with('msg', "Results saved successfully for Parameters: $parameterNamesList");
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

        return view('result.ambient_air.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling',
        ));
    }

    public function addAmbientAirNew(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        // ✅ Periksa apakah ada data Sampling dengan institute_subject_id terkait
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->latest()->first();

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
                            'sampling_id' => $sampling->id,
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

            $parameterNames = Parameter::whereIn('id', $parameters)->pluck('name')->toArray();
            $parameterNamesList = implode(', ', $parameterNames);

            return redirect()->back()->with('msg', "Results saved successfully for Parameters: $parameterNamesList");
        }

        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $sampling = Sampling::where('institute_subject_id', $id)->latest()->first(); // Ambil data terbaru
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $results = Result::whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id'))
        ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id'))
        ->orderBy('id', 'desc') // Ambil data terbaru berdasarkan ID
        ->get()
        ->groupBy(function ($item) {
            return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
        });

        return view('result.ambient_air.add_loc', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addNoise(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();
        $noiseInstituteSubject = InstituteSubject::where('subject_id', 3)->first();

        if ($noiseInstituteSubject) {
            $samplingNoise = Sampling::where('institute_subject_id', $noiseInstituteSubject->id)
                ->orderBy('id', 'desc')
                ->first();
        } else {
            return redirect()->back()->with('error', 'No noise sampling ID found.');
        }

        if ($request->isMethod('POST')) {
            $request->validate([
                'testing_result.*.*' => 'nullable|string',
                'unit.*.*' => 'nullable|string',
                'method.*.*' => 'nullable|string',
                'noise' => 'nullable|string',
                'time.*.*' => 'nullable|string',
                'leq.*.*' => 'nullable|string',
                'ls' => 'nullable|string',
                'lm' => 'nullable|string',
                'lsm' => 'nullable|string',
                'regulatory_standard.*.*' => 'nullable|string',
                'location.*' => 'nullable|string'
            ]);

            $samplingId = $samplingNoise->id;
            $locations = ['Upwind', 'Downwind'];
            $l_values = range(1, 7);
            $t_values = range(1, 7);

            foreach ($locations as $locIndex => $location) {
                foreach ($l_values as $lIndex => $l) {
                    foreach ($t_values as $tIndex => $t) {
                        $uniqueId = ($lIndex * 7) + $tIndex + 1;
                        Result::create([
                            'sampling_id' => $samplingId,
                            'testing_result' => $request->input("testing_result.$locIndex.$lIndex.$tIndex") ?? null,
                            'unit' => $request->input("unit.$locIndex.$lIndex.$tIndex") ?? null,
                            'method' => $request->input("method.$locIndex.$lIndex.$tIndex") ?? null,
                            'time' => $request->input("time.$locIndex.$lIndex.$tIndex") ?? null,
                            'noise' => $request->input('noise') ?? null,
                            'leq' => $request->input("leq.$locIndex.$lIndex.$tIndex") ?? null,
                            'ls' => $request->input('ls') ?? null,
                            'lm' => $request->input('lm') ?? null,
                            'lsm' => $request->input('lsm') ?? null,
                            'regulatory_standard' => $request->input("regulatory_standard.$locIndex.$lIndex.$tIndex") ?? null,
                            'location' => $location,
                        ]);
                    }
                }
            }

            return redirect()->back()->with('msg', "Results saved successfully");
        }

        $subject = Subject::find($instituteSubject->subject_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $results = $samplingNoise ? Result::where('sampling_id', $samplingNoise->id)->get() : collect();

        return view('result.noise.add', compact(
            'institute', 'parameters', 'regulations',
            'samplingTimeRegulations', 'results', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addWorkplaceAir(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);

            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->latest('id')
                ->first();

            foreach ($parameters as $parameterId) {
                // Ambil regulation_standard_id berdasarkan parameter_id
                $regulationStandardId = SamplingTimeRegulation::where('parameter_id', $parameterId)
                    ->value('regulation_standard_id');

                if ($regulationStandardId) {
                    $result = Result::updateOrCreate(
                        [
                            'sampling_id' => $samplings->id,
                            'parameter_id' => $parameterId,
                            'regulation_standard_id' => $regulationStandardId
                        ],
                        [
                            'testing_result' => $request->input("testing_result.$parameterId"),
                            'unit' => $request->input("unit.$parameterId"),
                            'method' => $request->input("method.$parameterId"),
                        ]
                    );
                }
            }

            return redirect()->route('result.list_result', $institute->id)
            ->with('msg', 'Results saved successfully');
        }

        // Ambil data untuk view
        $subject = Subject::find($instituteSubject->subject_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        // Ambil standar regulasi terkait dengan parameter
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        // Ambil semua hasil berdasarkan sampling_id dan parameter_id
        $results = Result::whereIn('parameter_id', $parametersIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->parameter_id . '-' . $item->regulation_standard_id;
            });

        $resultIds = $results->pluck('id'); // Ambil semua result_id

        return view('result.workplace.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addOdor(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->latest('id')
                ->first();

            foreach ($parameters as $parameterId) {
                // Ambil regulation_standard_id berdasarkan parameter_id
                $regulationStandardId = SamplingTimeRegulation::where('parameter_id', $parameterId)
                    ->value('regulation_standard_id');

                if ($regulationStandardId) {
                    // Simpan atau update Result berdasarkan regulation_standard_id
                    $result = Result::updateOrCreate(
                        [
                            'sampling_id' => $samplings->id,
                            'parameter_id' => $parameterId,
                            'regulation_standard_id' => $regulationStandardId
                        ],
                        [
                            'testing_result' => $request->input("testing_result.$parameterId"),
                            'time' => $request->input("time.$parameterId"),
                            'unit' => $request->input("unit.$parameterId"),
                            'method' => $request->input("method.$parameterId"),
                        ]
                    );
                }
            }
            return redirect()->route('result.list_result', $institute->id)
            ->with('msg', 'Results saved successfully');
        }

        // Ambil data untuk view
        $subject = Subject::find($instituteSubject->subject_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        // Ambil standar regulasi terkait dengan parameter
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        // Ambil semua hasil berdasarkan sampling_id dan parameter_id
        $results = Result::whereIn('parameter_id', $parametersIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->parameter_id . '-' . $item->regulation_standard_id;
            });

        $resultIds = $results->pluck('id'); // Ambil semua result_id

        return view('result.odor.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addIllumination(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->latest('id')
                ->first();

            foreach ($parameters as $parameterId) {
                // Ambil regulation_standard_id berdasarkan parameter_id
                $regulationStandardId = SamplingTimeRegulation::where('parameter_id', $parameterId)
                    ->value('regulation_standard_id');

                if ($regulationStandardId) {
                    // Simpan atau update Result berdasarkan regulation_standard_id
                    $result = Result::updateOrCreate(
                        [
                            'sampling_id' => $samplings->id,
                            'parameter_id' => $parameterId,
                            'regulation_standard_id' => $regulationStandardId
                        ],
                        [
                            'testing_result' => $request->input("testing_result.$parameterId"),
                            'unit' => $request->input("unit.$parameterId"),
                            'method' => $request->input("method.$parameterId"),
                        ]
                    );
                }
            }
            return redirect()->route('result.list_result', $institute->id)
            ->with('msg', 'Results saved successfully');
        }

        // Ambil data untuk view
        $subject = Subject::find($instituteSubject->subject_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        // Ambil standar regulasi terkait dengan parameter
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        // Ambil semua hasil berdasarkan sampling_id dan parameter_id
        $results = Result::whereIn('parameter_id', $parametersIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->parameter_id . '-' . $item->regulation_standard_id;
            });

        $resultIds = $results->pluck('id'); // Ambil semua result_id

        return view('result.illumination.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'fieldConditions'
        ));
    }

    public function addHeatStress(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->latest('id')
                ->first();

            foreach ($parameters as $parameterId) {
                // Ambil regulation_standard_id berdasarkan parameter_id
                $regulationStandardId = SamplingTimeRegulation::where('parameter_id', $parameterId)
                    ->value('regulation_standard_id');

                if ($regulationStandardId) {
                    // Simpan atau update Result berdasarkan regulation_standard_id
                    $result = Result::updateOrCreate(
                        [
                            'sampling_id' => $samplings->id,
                            'parameter_id' => $parameterId,
                            'regulation_standard_id' => $regulationStandardId
                        ],
                        [
                            'testing_result' => $request->input("testing_result.$parameterId"),
                            'unit' => $request->input("unit.$parameterId"),
                            'method' => $request->input("method.$parameterId"),
                        ]
                    );
                }
            }
            return redirect()->route('result.list_result', $institute->id)
            ->with('msg', 'Results saved successfully');
        }

        // Ambil data untuk view
        $subject = Subject::find($instituteSubject->subject_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        // Ambil standar regulasi terkait dengan parameter
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        // Ambil semua hasil berdasarkan sampling_id dan parameter_id
        $results = Result::whereIn('parameter_id', $parametersIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->parameter_id . '-' . $item->regulation_standard_id;
            });

        $resultIds = $results->pluck('id'); // Ambil semua result_id

        return view('result.heat_stress.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'fieldConditions'
        ));
    }

    public function addStationaryStack(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->latest('id')
                ->first();

            foreach ($parameters as $parameterId) {
                // Ambil regulation_standard_id berdasarkan parameter_id
                $regulationStandardId = SamplingTimeRegulation::where('parameter_id', $parameterId)
                    ->value('regulation_standard_id');

                if ($regulationStandardId) {
                    // Simpan atau update Result berdasarkan regulation_standard_id
                    $result = Result::updateOrCreate(
                        [
                            'sampling_id' => $samplings->id,
                            'parameter_id' => $parameterId,
                            'regulation_standard_id' => $regulationStandardId
                        ],
                        [
                            'testing_result' => $request->input("testing_result.$parameterId"),
                            'unit' => $request->input("unit.$parameterId"),
                            'method' => $request->input("method.$parameterId"),
                        ]
                    );
                }
            }
            return redirect()->route('result.list_result', $institute->id)
            ->with('msg', 'Results saved successfully');
        }

        // Ambil data untuk view
        $subject = Subject::find($instituteSubject->subject_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');

        // Ambil standar regulasi terkait dengan parameter
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        // Ambil semua hasil berdasarkan sampling_id dan parameter_id
        $results = Result::whereIn('parameter_id', $parametersIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->parameter_id . '-' . $item->regulation_standard_id;
            });

        $resultIds = $results->pluck('id'); // Ambil semua result_id

        return view('result.stationary_stack.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'fieldConditions'
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
}
