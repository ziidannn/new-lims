<?php

namespace App\Http\Controllers;

use App\Models\FieldCondition;
use App\Models\HeatStress;
use App\Models\Institute;
use App\Models\InstituteRegulation;
use App\Models\InstituteSubject;
use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Models\Sampling;
use App\Models\Subject;
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
        $institute = Institute::findOrFail($id);
        $subjects = Subject::orderBy('name')->get();
        $parameters = Parameter::orderBy('name')->get();
        $instituteSubjects = InstituteSubject::where('institute_id', $id)->get();
        $instituteSubjectIds = $instituteSubjects->pluck('id'); // Ambil semua ID-nya
        $samplings = Sampling::where('institute_id', $id)
            ->whereIn('institute_subject_id', $instituteSubjectIds)
            ->first(); // get() karena mungkin ada lebih dari satu sampling


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

    // public function addWorkplaceAir(Request $request, $id) {
    //     $instituteSubject = InstituteSubject::findOrFail($id);
    //     $institute = Institute::findOrFail($instituteSubject->institute_id);
    //     $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

    //     if ($request->isMethod('POST')) {
    //         $parameters = $request->input('parameter_id', []);

    //         $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
    //             ->latest('id')
    //             ->first();

    //         foreach ($parameters as $parameterId) {
    //             // Ambil regulation_standard_id berdasarkan parameter_id
    //             $regulationStandardId = SamplingTimeRegulation::where('parameter_id', $parameterId)
    //                 ->value('regulation_standard_id');

    //             if ($regulationStandardId) {
    //                 $result = Result::updateOrCreate(
    //                     [
    //                         'sampling_id' => $samplings->id,
    //                         'parameter_id' => $parameterId,
    //                         'regulation_standard_id' => $regulationStandardId
    //                     ],
    //                     [
    //                         'testing_result' => $request->input("testing_result.$parameterId"),
    //                         'unit' => $request->input("unit.$parameterId"),
    //                         'method' => $request->input("method.$parameterId"),
    //                     ]
    //                 );
    //             }
    //         }

    //         return redirect()->back()->with('msg', "Results saved successfully");
    //     }

    //     // Ambil data untuk view
    //     $subject = Subject::where('id', $instituteSubject->subject_id)->first();
    //     $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
    //         ->pluck('regulation_id');
    //     $regulations = Regulation::whereIn('id', $regulationsIds)->get();
    //     $subjectsIds = InstituteSubject::where('institute_id', $institute->id)
    //         ->pluck('subject_id');
    //     $subjects = Subject::whereIn('id', $subjectsIds)->get();
    //     $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
    //     $parametersIds = $parameters->pluck('id');

    //     // Ambil standar regulasi terkait dengan parameter
    //     $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
    //         ->with(['samplingTime', 'regulationStandards'])
    //         ->get();

    //     // Ambil semua hasil berdasarkan sampling_id dan parameter_id
    //     $results = Result::whereIn('parameter_id', $parametersIds)
    //         ->get()
    //         ->keyBy(function ($item) {
    //             return $item->parameter_id . '-' . $item->regulation_standard_id;
    //         });

    //     $resultIds = $results->pluck('id'); // Ambil semua result_id

    //     return view('result.workplace.add', compact(
    //         'institute', 'parameters', 'samplingTimeRegulations', 'results',
    //         'regulations', 'subject', 'instituteSubject', 'sampling'
    //     ));
    // }

    public function addOdor(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // ✅ STEP 1: Handle Add Sample (Gabungan dari add_sample_workplace)
            if ($action === 'add_sample') {
                $validatedData = $request->validate([
                    'no_sample' => ['required'],
                    'sampling_location' => ['required'],
                    'sampling_date' => ['required', 'date'],
                    'sampling_time' => ['required'],
                    'sampling_method' => ['required'],
                    'date_received' => ['required', 'date'],
                    'itd_start' => ['required', 'date'],
                    'itd_end' => ['required', 'date'],
                ]);

                $validatedData['institute_id'] = $institute->id;
                $validatedData['institute_subject_id'] = $instituteSubject->id;

                $samplingId = $request->input('sampling_id');

                if ($samplingId) {
                    // Mode UPDATE (edit existing sample)
                    $sample = Sampling::find($samplingId);

                    if ($sample) {
                        $sample->update($validatedData);
                        $message = "Data CoA ({$institute->no_coa}.{$request->no_sample}) updated successfully!";
                        $alertType = 'warning';
                    } else {
                        $message = "Data tidak ditemukan untuk diedit.";
                        $alertType = 'danger';
                    }

                } else {
                    // Mode CREATE (new sample)
                    $existingSample = Sampling::where('institute_id', $institute->id)
                        ->where('institute_subject_id', $instituteSubject->id)
                        ->where('no_sample', $request->no_sample)
                        ->first();

                    if ($existingSample) {
                        $existingSample->update($validatedData);
                        $message = "Data CoA ({$institute->no_coa}.{$request->no_sample}) updated successfully!";
                        $alertType = 'warning';
                    } else {
                        Sampling::create($validatedData);
                        $message = "Data CoA ({$institute->no_coa}.{$request->no_sample}) saved successfully!";
                        $alertType = 'success';
                    }
                }

                return back()->with(['msg' => $message, 'alertType' => $alertType]);
            }

            // ✅ STEP 2: Handle Result Input
            if ($action === 'save_parameter') {
                $parameters = $request->input('parameter_id', []);

                foreach ($parameters as $parameterId) {
                    $regulationStandardId = $request->regulation_standard_id[$parameterId] ?? null;
                    $testingResult = $request->testing_result[$parameterId] ?? null;

                    if ($regulationStandardId === null || $testingResult === null) {
                        continue;
                    }

                    // Temukan sampling ID berdasarkan parameter dan institute_subject
                    $sampling = Sampling::where('institute_id', $institute->id)
                        ->where('institute_subject_id', $instituteSubject->id)
                        ->first(); // Kalau logicnya bisa multiple sampling, sesuaikan di sini

                    if (!$sampling) {
                        continue; // Lewati jika tidak ada sampling
                    }

                    Result::updateOrCreate(
                        [
                            'sampling_id' => $sampling->id,
                            'parameter_id' => $parameterId,
                            'regulation_standard_id' => $regulationStandardId,
                        ],
                        [
                            'testing_result' => $testingResult,
                            'unit' => $request->unit[$parameterId] ?? null,
                            'method' => $request->method[$parameterId] ?? null,
                        ]
                    );
                }

                $parameterNames = Parameter::whereIn('id', $parameters)->pluck('name')->toArray();
                $parameterNamesList = implode(', ', $parameterNames);

                return redirect()->back()->with('msg', "Results saved successfully for Parameters: $parameterNamesList");
            }

            // ✅ STEP 3: Save Logo + Field Condition
            if ($action === 'save_all') {
                Sampling::updateOrCreate(
                    [
                        'institute_subject_id' => $instituteSubject->id,
                    ],
                    [
                        'show_logo' => $request->input('show_logo', false),
                    ]
                );

                FieldCondition::updateOrCreate(
                    [
                        'institute_id' => $institute->id,
                        'institute_subject_id' => $instituteSubject->id,
                    ],
                    [
                        'coordinate' => $request->input('coordinate'),
                        'temperature' => $request->input('temperature'),
                        'pressure' => $request->input('pressure'),
                        'humidity' => $request->input('humidity'),
                        'wind_speed' => $request->input('wind_speed'),
                        'wind_direction' => $request->input('wind_direction'),
                        'weather' => $request->input('weather'),
                        'velocity' => $request->input('velocity'),
                    ]
                );

                return redirect()->route('result.list_result', $institute->id)
                    ->with('msg', 'Data and Logo saved successfully!');
            }
        }

        // Bagian GET
        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
        $parametersIds = $parameters->pluck('id');

        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->first();

        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->get()
                ->groupBy('parameter_id'); // ✅ hanya berdasarkan parameter_id
        }

        return view('result.odor.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'subjects', 'samplings'
        ));
    }

    public function addIllumination(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $samplingNoiseSubject = InstituteSubject::where('subject_id', 5)->first();

        $samplingNoise = Sampling::where('institute_subject_id', $samplingNoiseSubject->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            $request->validate([
                'testing_result.*' => 'nullable|string',
                'unit.*' => 'nullable|string',
                'method.*' => 'nullable|string',
                'time.*' => 'nullable|string',
                'regulatory_standard.*' => 'nullable|string',
                'location.*' => 'nullable|string'
            ]);

            $messages = [];

            // Save per location
            foreach ($request->input('testing_result', []) as $index => $testingResult) {
                $location = $request->input('location')[$index] ?? null;
                $parameterId = $request->parameter_id[$index] ?? null;

                if ($location) {
                    $existingResult = Result::where('sampling_id', $samplingNoise->id)
                        ->where('location', $location)
                        ->first();

                    $data = [
                        'sampling_id' => $samplingNoise->id,
                        'parameter_id' => $parameterId,
                        'testing_result' => $testingResult ?? null,
                        'unit' => $request->unit[$parameterId] ?? null,
                        'method' => $request->method[$parameterId] ?? null,
                        'time' => $request->time[$index] ?? null,
                        'regulatory_standard' => $request->regulatory_standard[$index] ?? null,
                        'location' => $location,
                    ];

                    if ($existingResult) {
                        $existingResult->update($data);
                        $messages[] = "Data for location $location updated successfully.";
                    } else {
                        Result::create($data);
                        $messages[] = "Data for location $location created successfully.";
                    }
                }
            }

            // ✅ Simpan logo jika tombol Save All ditekan
            if ($action === 'save_all') {
                Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    ['show_logo' => $request->input('show_logo', false)]
                );

                return redirect()->route('result.list_result', $institute->id)
                    ->with('msg', 'Data and Logo saved successfully!');
            }

            return redirect()->back()->with('msg', implode(' ', $messages));
        }

        // View data
        $subject = Subject::find($instituteSubject->subject_id);
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)
            ->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
        $parametersIds = $parameters->pluck('id');

        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->latest('id')
            ->first();

        $results = $samplings
            ? Result::where('sampling_id', $samplings->id)->with('parameter')->get()
            : collect();

        return view('result.illumination.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'samplings'
        ));
    }

    public function addHeatStress(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            $samplingNoiseSubject = InstituteSubject::where('subject_id', 6)->first();

            if (!$samplingNoiseSubject) {
                return redirect()->back()->with('error', 'No heat stress sampling subject found.');
            }

            $samplingNoise = Sampling::where('institute_subject_id', $samplingNoiseSubject->id)
                ->orderBy('id', 'desc')
                ->first();

            // ✅ Simpan Logo terlebih dahulu jika "Save All"
            if ($action === 'save_all') {
                Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    ['show_logo' => $request->input('show_logo', false)]
                );

                return redirect()->route('result.list_result', $institute->id)
                    ->with('msg', 'Logo saved successfully!');
            }

            // ✅ Validasi input
            $request->validate([
                'sampling_location.*' => 'nullable|string',
                'time.*' => 'nullable|string',
                'humidity.*' => 'nullable|numeric',
                'wet.*' => 'nullable|numeric',
                'dew.*' => 'nullable|numeric',
                'globe.*' => 'nullable|numeric',
                'wbgt_index.*' => 'nullable|numeric',
                'methods.*' => 'nullable|string',
            ]);

            $heatStressIds = $request->input('heat_stress_id', []);
            $locations = $request->input('sampling_location', []);
            $times = $request->input('time', []);
            $humidities = $request->input('humidity', []);
            $wets = $request->input('wet', []);
            $dews = $request->input('dew', []);
            $globes = $request->input('globe', []);
            $wbgt_indexes = $request->input('wbgt_index', []);
            $methods = $request->input('methods', []);

            foreach ($locations as $index => $location) {
                $time = $times[$index] ?? null;
                if (empty($location) || empty($time)) {
                    continue;
                }

                $heatStressId = $heatStressIds[$index] ?? null;

                $data = [
                    'sampling_location' => $location,
                    'time' => $time,
                    'humidity' => $humidities[$index] ?? null,
                    'wet' => $wets[$index] ?? null,
                    'dew' => $dews[$index] ?? null,
                    'globe' => $globes[$index] ?? null,
                    'wbgt_index' => $wbgt_indexes[$index] ?? null,
                    'methods' => $methods[$index] ?? null,
                ];

                if ($heatStressId) {
                    $existing = HeatStress::find($heatStressId);
                    if ($existing) {
                        $existing->update($data);
                    }
                } else {
                    $data['sampling_id'] = $samplingNoise->id;
                    HeatStress::create($data);
                }
            }

            return redirect()->back()->with('msg', 'Heat Stress data saved successfully');
        }

        // GET method - load view
        $existingHeatStress = [];
        $samplingNoiseSubject = InstituteSubject::where('subject_id', 6)->first();
        if ($samplingNoiseSubject) {
            $samplingNoise = Sampling::where('institute_subject_id', $samplingNoiseSubject->id)
                ->orderBy('id', 'desc')
                ->first();
            if ($samplingNoise) {
                $existingHeatStress = HeatStress::where('sampling_id', $samplingNoise->id)->get();
            }
        }

        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->latest('id')
            ->first();
        $subject = Subject::find($instituteSubject->subject_id);
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
        $parametersIds = $parameters->pluck('id');

        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        $results = Result::whereIn('parameter_id', $parametersIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->parameter_id . '-' . $item->regulation_standard_id;
            });

        return view('result.heat_stress.add', compact(
            'samplings', 'institute', 'parameters',
            'samplingTimeRegulations', 'results', 'regulations',
            'subject', 'instituteSubject', 'existingHeatStress'
        ));
    }

    public function addStationaryStack(Request $request, $id){
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // ✅ STEP 1: Handle Add Sample (Gabungan dari add_sample_workplace)
            if ($action === 'add_sample') {
                $validatedData = $request->validate([
                    'no_sample' => ['required'],
                    'sampling_location' => ['required'],
                    'sampling_date' => ['required', 'date'],
                    'sampling_time' => ['required'],
                    'sampling_method' => ['required'],
                    'date_received' => ['required', 'date'],
                    'itd_start' => ['required', 'date'],
                    'itd_end' => ['required', 'date'],
                ]);

                $validatedData['institute_id'] = $institute->id;
                $validatedData['institute_subject_id'] = $instituteSubject->id;

                $samplingId = $request->input('sampling_id');

                if ($samplingId) {
                    // Mode UPDATE (edit existing sample)
                    $sample = Sampling::find($samplingId);

                    if ($sample) {
                        $sample->update($validatedData);
                        $message = "Data CoA ({$institute->no_coa}.{$request->no_sample}) updated successfully!";
                        $alertType = 'warning';
                    } else {
                        $message = "Data tidak ditemukan untuk diedit.";
                        $alertType = 'danger';
                    }

                } else {
                    // Mode CREATE (new sample)
                    $existingSample = Sampling::where('institute_id', $institute->id)
                        ->where('institute_subject_id', $instituteSubject->id)
                        ->where('no_sample', $request->no_sample)
                        ->first();

                    if ($existingSample) {
                        $existingSample->update($validatedData);
                        $message = "Data CoA ({$institute->no_coa}.{$request->no_sample}) updated successfully!";
                        $alertType = 'warning';
                    } else {
                        Sampling::create($validatedData);
                        $message = "Data CoA ({$institute->no_coa}.{$request->no_sample}) saved successfully!";
                        $alertType = 'success';
                    }
                }

                return back()->with(['msg' => $message, 'alertType' => $alertType]);
            }

            // ✅ STEP 2: Handle Result Input
            if ($action === 'save_parameter') {
                $parameters = $request->input('parameter_id', []);

                foreach ($parameters as $parameterId) {
                    $regulationStandardId = $request->regulation_standard_id[$parameterId] ?? null;
                    $testingResult = $request->testing_result[$parameterId] ?? null;

                    if ($regulationStandardId === null || $testingResult === null) {
                        continue;
                    }

                    // Temukan sampling ID berdasarkan parameter dan institute_subject
                    $sampling = Sampling::where('institute_id', $institute->id)
                        ->where('institute_subject_id', $instituteSubject->id)
                        ->first(); // Kalau logicnya bisa multiple sampling, sesuaikan di sini

                    if (!$sampling) {
                        continue; // Lewati jika tidak ada sampling
                    }

                    Result::updateOrCreate(
                        [
                            'sampling_id' => $sampling->id,
                            'parameter_id' => $parameterId,
                            'regulation_standard_id' => $regulationStandardId,
                        ],
                        [
                            'testing_result' => $testingResult,
                            'unit' => $request->unit[$parameterId] ?? null,
                            'method' => $request->method[$parameterId] ?? null,
                        ]
                    );
                }

                $parameterNames = Parameter::whereIn('id', $parameters)->pluck('name')->toArray();
                $parameterNamesList = implode(', ', $parameterNames);

                return redirect()->back()->with('msg', "Results saved successfully for Parameters: $parameterNamesList");
            }

            // ✅ STEP 3: Save Logo + Field Condition
            if ($action === 'save_all') {
                Sampling::updateOrCreate(
                    [
                        'institute_subject_id' => $instituteSubject->id,
                    ],
                    [
                        'show_logo' => $request->input('show_logo', false),
                    ]
                );

                FieldCondition::updateOrCreate(
                    [
                        'institute_id' => $institute->id,
                        'institute_subject_id' => $instituteSubject->id,
                    ],
                    [
                        'coordinate' => $request->input('coordinate'),
                        'temperature' => $request->input('temperature'),
                        'pressure' => $request->input('pressure'),
                        'humidity' => $request->input('humidity'),
                        'wind_speed' => $request->input('wind_speed'),
                        'wind_direction' => $request->input('wind_direction'),
                        'weather' => $request->input('weather'),
                        'velocity' => $request->input('velocity'),
                    ]
                );

                return redirect()->route('result.list_result', $institute->id)
                    ->with('msg', 'Data and Logo saved successfully!');
            }
        }

        // Bagian GET
        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
        $parametersIds = $parameters->pluck('id');

        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();

        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->first();

        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->get()
                ->groupBy('parameter_id'); // ✅ hanya berdasarkan parameter_id
        }

        return view('result.stationary_stack.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'subjects', 'samplings'
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
