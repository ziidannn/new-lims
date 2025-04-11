<?php

namespace App\Http\Controllers;

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

    public function addWorkplaceAir(Request $request, $id) {
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
        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)
            ->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
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

    public function addNoise(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $samplingNoise = InstituteSubject::where('subject_id', 3)->first();

        if (!$samplingNoise) {
            return redirect()->back()->with('error', 'No noise sampling ID found.');
        }

        $samplingNoise = Sampling::where('institute_subject_id', $samplingNoise->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($request->isMethod('POST')) {
            $request->validate([
                'testing_result.*.*' => 'nullable|string',
                'unit.*' => 'nullable|string',
                'method.*' => 'nullable|string',
                'noise.*.*' => 'nullable|string',
                'time.*.*' => 'nullable|string',
                'leq.*.*' => 'nullable|string',
                'ls' => 'nullable|string',
                'lm' => 'nullable|string',
                'lsm' => 'nullable|string',
                'regulatory_standard.*' => 'nullable|string',
                'location.*' => 'nullable|string'
            ]);

            $messages = [];

            foreach ($request->location as $locIndex => $location) {
                foreach ($request->noise[$locIndex] as $i => $noiseValue) {
                    $parameterId = $request->parameter_id[$locIndex] ?? null;
                    $timeValue = $request->time[$locIndex][$i] ?? null;

                    // Pastikan query juga mempertimbangkan noise dan time
                    $existingResult = Result::where([
                        'sampling_id' => $samplingNoise->id,
                        'parameter_id' => $parameterId,
                        'location' => $location,
                        'noise' => $noiseValue,
                        'time' => $timeValue
                    ])->first();

                    if ($existingResult) {
                        // Update data jika sudah ada
                        $existingResult->update([
                            'testing_result' => $request->testing_result[$locIndex][$i] ?? null,
                            'unit' => $request->unit[$parameterId] ?? null,
                            'method' => $request->method[$parameterId] ?? null,
                            'leq' => $request->leq[$locIndex][$i] ?? null,
                            'ls' => $request->ls ?? null,
                            'lm' => $request->lm ?? null,
                            'lsm' => $request->lsm ?? null,
                            'regulatory_standard' => $request->regulatory_standard[$locIndex] ?? null,
                        ]);
                    } else {
                        // Buat data baru jika belum ada
                        Result::create([
                            'sampling_id' => $samplingNoise->id,
                            'parameter_id' => $parameterId,
                            'testing_result' => $request->testing_result[$locIndex][$i] ?? null,
                            'unit' => $request->unit[$parameterId] ?? null,
                            'method' => $request->method[$parameterId] ?? null,
                            'time' => $timeValue,
                            'noise' => $noiseValue,
                            'leq' => $request->leq[$locIndex][$i] ?? null,
                            'ls' => $request->ls ?? null,
                            'lm' => $request->lm ?? null,
                            'lsm' => $request->lsm ?? null,
                            'regulatory_standard' => $request->regulatory_standard[$locIndex] ?? null,
                            'location' => $location,
                        ]);
                    }

                    // Simpan hanya satu pesan per lokasi
                    $messages["$location"] = "Data untuk lokasi $location telah diperbarui/dibuat.";
                }
            }

            // Gabungkan pesan-pesan menjadi satu
            return redirect()->back()->with('msg', implode(' ', array_values($messages)));
        }

        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->get();
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
        $results = $samplingNoise
            ? Result::where('sampling_id', $samplingNoise->id)
                ->whereIn('parameter_id', $parametersIds)
                ->get()
            : collect();

            if ($regulations->contains(fn($regulation) =>
            in_array($regulation->id, [13, 15]) ||
            ($regulation->subject && ($regulation->subject->id == 3 || $regulation->subject->code == '03'))
        )) {
            $view = 'result.noise.add_new';
        } elseif ($regulations->contains(fn($regulation) =>
            in_array($regulation->id, [12, 14]) ||
            ($regulation->subject && ($regulation->subject->id == 3 || $regulation->subject->code == '03'))
        )) {
            $view = 'result.noise.add';
        } else {
            abort(404, 'Halaman tidak ditemukan');
        }

        return view($view, compact(
            'institute', 'parameters', 'regulations', 'subjects', 'samplingTimeRegulations',
            'results', 'subject', 'instituteSubject', 'samplingNoise', 'samplings'
        ));
    }

    public function addNoiseNew(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $samplings = InstituteSubject::where('subject_id', 3)->latest()->first();
        $samplingNoise = Sampling::where('institute_subject_id', $samplings->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($request->isMethod('POST')) {
            $request->validate([
                'testing_result.*.*' => 'nullable|string',
                'unit.*' => 'nullable|string',
                'method.*' => 'nullable|string',
                'noise.*.*' => 'nullable|string',
                'time.*.*' => 'nullable|string',
                'leq.*.*' => 'nullable|string',
                'ls' => 'nullable|string',
                'lm' => 'nullable|string',
                'lsm' => 'nullable|string',
                'regulatory_standard.*' => 'nullable|string',
                'location.*' => 'nullable|string'
            ]);

            $messages = [];

            foreach ($request->input('testing_result', []) as $index => $testingResult) {
                $location = $request->input('location')[$index] ?? null;
                $parameterId = $request->parameter_id[$index] ?? null;
                if ($location) {
                    $existingResult = Result::where('sampling_id', $samplingNoise->id)
                        ->where('location', $location)
                        ->first();

                    if ($existingResult) {
                        $existingResult->update([
                            'testing_result' => $testingResult,
                            'unit' => $request->input[$parameterId] ?? null,
                            'method' => $request->input[$parameterId] ?? null,
                            'time' => $request->input('time')[$index] ?? null,
                            'noise' => $request->input('noise') ?? null,
                            'leq' => $request->input('leq')[$index] ?? null,
                            'ls' => $request->input('ls') ?? null,
                            'lm' => $request->input('lm') ?? null,
                            'lsm' => $request->input('lsm') ?? null,
                            'regulatory_standard' => $request->input('regulatory_standard')[$index] ?? null,
                        ]);
                        $messages[] = "Data for location $location updated successfully.";
                    } else {
                        Result::create([
                            'sampling_id' => $samplingNoise->id,
                            'parameter_id' => $parameterId,
                            'testing_result' => $testingResult,
                            'unit' => $request->input[$parameterId] ?? null,
                            'method' => $request->input[$parameterId] ?? null,
                            'time' => $request->input('time')[$index] ?? null,
                            'noise' => $request->input('noise') ?? null,
                            'leq' => $request->input('leq')[$index] ?? null,
                            'ls' => $request->input('ls') ?? null,
                            'lm' => $request->input('lm') ?? null,
                            'lsm' => $request->input('lsm') ?? null,
                            'regulatory_standard' => $request->input('regulatory_standard')[$index] ?? null,
                            'location' => $location,
                        ]);
                        $messages[] = "Data for location $location created successfully.";
                    }
                }
            }

            return redirect()->back()->with('msg', implode(' ', $messages));
        }

        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
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
        $results = Result::where('sampling_id', $samplings->id)->get();

        if ($regulations->contains(fn($regulation) =>
            in_array($regulation->id, [13, 15]) ||
            ($regulation->subject && ($regulation->subject->id == 3 || $regulation->subject->code == '03'))
        )) {
            $view = 'result.noise.add_new';
        } elseif ($regulations->contains(fn($regulation) =>
            in_array($regulation->id, [12, 14]) ||
            ($regulation->subject && ($regulation->subject->id == 3 || $regulation->subject->code == '03'))
        )) {
            $view = 'result.noise.add';
        } else {
            abort(404, 'Halaman tidak ditemukan');
        }

        return view($view, compact(
            'institute', 'parameters', 'regulations', 'subjects',
            'samplingTimeRegulations', 'results', 'subject', 'instituteSubject'
        ));
    }

    public function addOdor(Request $request, $id) {
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
        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)
            ->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
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
            'regulations', 'subject', 'instituteSubject'
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
        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)
            ->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
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
            'regulations', 'subject', 'instituteSubject'
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
        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)
            ->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
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
            'regulations', 'subject', 'instituteSubject'
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
        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $subjectsIds = InstituteSubject::where('institute_id', $institute->id)
            ->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectsIds)->get();
        $parameters = Parameter::whereIn('subject_id', $subjectsIds)->get();
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
            'regulations', 'subject', 'instituteSubject'
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
