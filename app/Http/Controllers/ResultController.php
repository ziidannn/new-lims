<?php

namespace App\Http\Controllers;

use App\Models\FieldCondition;
use App\Models\HeatStress;
use App\Models\Institute;
use App\Models\InstituteRegulation;
use App\Models\InstituteSubject;
use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\RegulationStandardCategory;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Models\Sampling;
use App\Models\Subject;
use App\Models\SamplingTimeRegulation;
use Illuminate\Support\Facades\DB;
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

    public function addAmbientAir(Request $request, $id){
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN UNTUK METHOD POST (VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // Aksi 1: Menyimpan data header (info sampling)
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'no_sample' => 'required|string|max:255',
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Sample data has been saved successfully!',
                    'sampling_id' => $sampling->id // Kirim kembali ID sampling jika dibutuhkan
                ]);
            }

            // Aksi 2: Menyimpan hasil per baris input (parameter + sampling time)
            if ($action === 'save_single_result') {
                $validated = $request->validate([
                    'parameter_id' => 'required|exists:parameters,id',
                    'sampling_time_id' => 'required|exists:sampling_times,id',
                    'regulation_standard_id' => 'required|exists:regulation_standards,id',
                    'testing_result' => 'nullable|string|max:255',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                Result::updateOrCreate(
                    [
                        'sampling_id' => $sampling->id,
                        'parameter_id' => $validated['parameter_id'],
                        'sampling_time_id' => $validated['sampling_time_id'],
                        'regulation_standard_id' => $validated['regulation_standard_id'],
                    ],
                    ['testing_result' => $validated['testing_result']]
                );

                $parameterName = Parameter::find($validated['parameter_id'])->name;
                return response()->json(['success' => true, 'message' => "Result for '{$parameterName}' has been saved."]);
            }

            // Aksi 3: Menyimpan Field Conditions
            if ($action === 'save_field_conditions') {
                $validated = $request->validate([
                    'coordinate' => 'nullable|string', 'temperature' => 'nullable|string',
                    'pressure' => 'nullable|string', 'humidity' => 'nullable|string',
                    'wind_speed' => 'nullable|string', 'wind_direction' => 'nullable|string',
                    'weather' => 'nullable|string',
                ]);

                FieldCondition::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json(['success' => true, 'message' => 'Field conditions has been saved.']);
            }

            if ($action === 'save_logo_preference') {
                $validated = $request->validate([
                    'show_logo' => 'required|boolean',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $sampling->update(['show_logo' => $validated['show_logo']]);

                return response()->json(['success' => true, 'message' => 'Logo preference has been saved.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN UNTUK METHOD GET (SAAT HALAMAN DIBUKA) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();
        $parameters = Parameter::where('subject_id', $subject->id)->orderBy('id')->get();
        $fieldCondition = FieldCondition::where('institute_subject_id', $instituteSubject->id)->firstOrNew();

        // ✅ Eager load relasi dengan nama TUNGGAL yang sudah kita perbaiki di Model
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parameters->pluck('id'))
            ->with(['samplingTime', 'regulationStandards'])
            ->get()->groupBy('parameter_id');

        $results = Result::where('sampling_id', $samplings->id)->get()->keyBy(function ($item) {
            return "{$item->parameter_id}-{$item->sampling_time_id}";
        });

        $regulations = $instituteSubject->regulations;

        return view('result.ambient_air.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'parameters', 'samplingTimeRegulations', 'results', 'regulations', 'fieldCondition'
        ));
    }

    public function addWorkplace(Request $request, $id)
    {
       $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN UNTUK METHOD POST (VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');
            $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

            // Aksi 1: Menyimpan data header (info sampling)
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'no_sample' => 'required|string|max:255',
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Sample data has been saved successfully!',
                    'sampling_id' => $sampling->id // Kirim kembali ID sampling jika dibutuhkan
                ]);
            }

            // Aksi 2: Menyimpan hasil per parameter
            if ($action === 'save_single_parameter') {
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }
                $validated = $request->validate([
                    'parameter_id' => 'required|exists:parameters,id',
                    'testing_result' => 'nullable|string|max:255',
                ]);
                Result::updateOrCreate(
                    ['sampling_id' => $sampling->id, 'parameter_id' => $validated['parameter_id']],
                    ['testing_result' => $validated['testing_result']]
                );
                $parameterName = Parameter::find($validated['parameter_id'])->name;
                return response()->json(['success' => true, 'message' => "Result for '{$parameterName}' has been saved."]);
            }

            // Aksi 3: Menyimpan Field Conditions
            if ($action === 'save_field_conditions') {
                $validated = $request->validate([
                    'temperature' => 'nullable|string',
                    'humidity' => 'nullable|string'
                ]);
                FieldCondition::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );
                return response()->json(['success' => true, 'message' => 'Field conditions has been saved.']);
            }

            // Aksi 4: Menyimpan pilihan logo
            if ($action === 'save_logo_preference') {
                $validated = $request->validate([
                    'show_logo' => 'required|boolean',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $sampling->update(['show_logo' => $validated['show_logo']]);

                return response()->json(['success' => true, 'message' => 'Logo preference has been saved.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN UNTUK METHOD GET (SAAT HALAMAN DIBUKA) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();
        $parameters = Parameter::where('subject_id', $subject->id)->orderBy('id')->get();
        $fieldCondition = FieldCondition::where('institute_subject_id', $instituteSubject->id)->firstOrNew();

        // ✅ Eager load relasi dengan nama TUNGGAL yang sudah kita perbaiki di Model
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parameters->pluck('id'))
            ->with(['samplingTime', 'regulationStandards'])
            ->get()->groupBy('parameter_id');

        $results = Result::where('sampling_id', $samplings->id)->get()->keyBy(function ($item) {
            return "{$item->parameter_id}-{$item->sampling_time_id}";
        });

        $regulations = $instituteSubject->regulations;

        return view('result.workplace.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'parameters', 'samplingTimeRegulations', 'results', 'regulations', 'fieldCondition'
        ));
    }

    public function addNoise(Request $request, $id){
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN METHOD POST (VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // Aksi 1: Menyimpan data header DAN pilihan template
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Sample data has been saved successfully!',
                    'sampling_id' => $sampling->id // Kirim kembali ID sampling jika dibutuhkan
                ]);
            }

            // Aksi 2: Menyimpan hasil per baris untuk Template Standard
            if ($action === 'save_standard_result') {
                // Cari atau buat record Sampling secara otomatis
                $sampling = Sampling::firstOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    ['institute_id' => $institute->id] // Atribut tambahan saat membuat record baru
                );

                $validated = $request->validate([
                    'result_id'         => 'nullable|exists:results,id',
                    'parameter_id'      => 'required|exists:parameters,id',
                    'location'          => 'required|string',
                    'testing_result'    => 'nullable|string',
                    'time'              => 'nullable|string',
                ]);

                // ... sisa kode penyimpanan (updateOrCreate Result) tidak perlu diubah
                $result = Result::updateOrCreate(
                    ['id' => $validated['result_id']],
                    [
                        'sampling_id'       => $sampling->id, // Gunakan ID dari record yg dicari/dibuat
                        'parameter_id'      => $validated['parameter_id'],
                        'location'          => $validated['location'],
                        'testing_result'    => $validated['testing_result'],
                        'time'              => $validated['time']
                    ]
                );
                return response()->json(['success' => true, 'message' => 'Result for location (' . e($validated['location']) . ') saved.', 'new_result_id' => $result->id]);
            }

            // Aksi 3: Menyimpan hasil Template 24 Jam
            if ($action === 'save_24h_location_result') {
                // Cari atau buat record Sampling secara otomatis
                $sampling = Sampling::firstOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    ['institute_id' => $institute->id] // Atribut tambahan saat membuat record baru
                );

                $validated = $request->validate([
                    'result_id'    => 'nullable|exists:results,id',
                    'parameter_id' => 'required|exists:parameters,id',
                    'location'     => 'required|string',
                    'leq'          => 'required|array|size:7',
                    'ls'           => 'nullable|string',
                    'lm'           => 'nullable|string',
                    'lsm'          => 'nullable|string',
                ]);

                // ... sisa kode penyimpanan (updateOrCreate Result) tidak perlu diubah
                $result = Result::updateOrCreate(
                    ['id' => $validated['result_id']],
                    [
                        'sampling_id'       => $sampling->id, // Gunakan ID dari record yg dicari/dibuat
                        'parameter_id'      => $validated['parameter_id'],
                        'location'          => $validated['location'],
                        'leq'               => implode(',', $validated['leq']),
                        'ls'                => $validated['ls'],
                        'lm'                => $validated['lm'],
                        'lsm'               => $validated['lsm'],
                    ]
                );

                return response()->json(['success' => true, 'message' => '24 Hours results for ('.e($validated['location']).') saved.', 'new_result_id' => $result->id]);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN METHOD GET (MENYIAPKAN DATA UNTUK VIEW) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();
        $noiseParameters = Parameter::where('subject_id', $subject->id)->get();//buat ambil unit metode
        $standardParameter = $noiseParameters->where('name', '!=', 'Sulfur Dioxide (SO₂)*')->first();
        $param24h = $noiseParameters->where('name', '!=','Sulfur Dioxide (SO₂)*')->first();

        $standardResults = Result::where('sampling_id', $samplings->id)->where('parameter_id', $standardParameter->id ?? null)->get();
        $results24h = Result::where('sampling_id', $samplings->id)->where('parameter_id', $param24h->id ?? null)->get();

        $regulations = $instituteSubject->regulations;

        return view('result.noise.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'standardParameter', 'param24h', 'standardResults', 'results24h', 'regulations'
        ));
    }

    public function addOdor(Request $request, $id) {
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN UNTUK METHOD POST (VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');
            $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

            // Aksi 1: Menyimpan data header (info sampling)
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'no_sample' => 'required|string|max:255',
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Sample data has been saved successfully!',
                    'sampling_id' => $sampling->id // Kirim kembali ID sampling jika dibutuhkan
                ]);
            }

            // Aksi 2: Menyimpan hasil per parameter
            if ($action === 'save_single_parameter') {
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }
                $validated = $request->validate([
                    'parameter_id' => 'required|exists:parameters,id',
                    'testing_result' => 'nullable|string|max:255',
                ]);
                Result::updateOrCreate(
                    ['sampling_id' => $sampling->id, 'parameter_id' => $validated['parameter_id']],
                    ['testing_result' => $validated['testing_result']]
                );
                $parameterName = Parameter::find($validated['parameter_id'])->name;
                return response()->json(['success' => true, 'message' => "Result for '{$parameterName}' has been saved."]);
            }

            // Aksi 3: Menyimpan Field Conditions
            if ($action === 'save_field_conditions') {
                $validated = $request->validate([
                    'coordinate' => 'nullable|string', 'temperature' => 'nullable|string',
                    'pressure' => 'nullable|string', 'humidity' => 'nullable|string',
                    'wind_speed' => 'nullable|string', 'wind_direction' => 'nullable|string',
                    'weather' => 'nullable|string',
                ]);

                FieldCondition::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json(['success' => true, 'message' => 'Field conditions has been saved.']);
            }

            // Aksi 4: Menyimpan pilihan logo
            if ($action === 'save_logo_preference') {
                $validated = $request->validate([
                    'show_logo' => 'required|boolean',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $sampling->update(['show_logo' => $validated['show_logo']]);

                return response()->json(['success' => true, 'message' => 'Logo preference has been saved.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN UNTUK METHOD GET (SAAT HALAMAN DIBUKA) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();
        $parameters = Parameter::where('subject_id', $subject->id)->orderBy('id')->get();
        $fieldCondition = FieldCondition::where('institute_subject_id', $instituteSubject->id)->firstOrNew();

        // ✅ Eager load relasi dengan nama TUNGGAL yang sudah kita perbaiki di Model
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parameters->pluck('id'))
            ->with(['samplingTime', 'regulationStandards'])
            ->get()->groupBy('parameter_id');

        $results = Result::where('sampling_id', $samplings->id)->get()->keyBy(function ($item) {
            return "{$item->parameter_id}-{$item->sampling_time_id}";
        });

        $regulations = $instituteSubject->regulations;

        return view('result.odor.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'parameters', 'samplingTimeRegulations', 'results', 'regulations', 'fieldCondition'
        ));
    }

    public function addIllumination(Request $request, $id){
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN METHOD POST (VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // Aksi 1: Menyimpan data header (info sampling)
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id, 'no_sample' => $institute->no_coa]
                );
                return response()->json(['success' => true, 'message' => 'Sample data has been saved successfully!']);
            }

            // Aksi 2: Menyimpan hasil per baris (parameter + lokasi)
            if ($action === 'save_illumination_result') {
                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $validated = $request->validate([
                    'result_id' => 'nullable|exists:results,id',
                    'parameter_id' => 'required|exists:parameters,id',
                    'location' => 'required|string',
                    'testing_result' => 'nullable|string',
                    'time' => 'nullable|string',
                    'regulatory_standard' => 'nullable|string',
                ]);

                $result = Result::updateOrCreate(
                    ['id' => $validated['result_id']],
                    [
                        'sampling_id' => $sampling->id,
                        'parameter_id' => $validated['parameter_id'],
                        'sampling_location' => $validated['location'],
                        'testing_result' => $validated['testing_result'],
                        'time' => $validated['time'],
                        'regulatory_standard' => $validated['regulatory_standard'],
                    ]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Result for location ' . e($validated['location']) . ' saved.',
                    'new_result_id' => $result->id // Kirim ID baru untuk baris yang baru dibuat
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN METHOD GET (SAAT HALAMAN DIBUKA) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();

        // Asumsi hanya ada 1 parameter utama untuk Illumination
        $illuminationParameter = Parameter::where('subject_id', $subject->id)->first();

        // Ambil semua baris hasil yang terkait dengan sampling ini
        $results = Result::where('sampling_id', $samplings->id)->get();

        $regulations = $instituteSubject->regulations;

        return view('result.illumination.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'illuminationParameter', 'results', 'regulations'
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
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN UNTUK METHOD POST (VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');
            $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

            // Aksi 1: Menyimpan data header (info sampling)
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'no_sample' => 'required|string|max:255',
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Sample data has been saved successfully!',
                    'sampling_id' => $sampling->id // Kirim kembali ID sampling jika dibutuhkan
                ]);
            }

            // Aksi 2: Menyimpan hasil per parameter
            if ($action === 'save_single_parameter') {
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }
                $validated = $request->validate([
                    'parameter_id' => 'required|exists:parameters,id',
                    'testing_result' => 'nullable|string|max:255',
                ]);
                Result::updateOrCreate(
                    ['sampling_id' => $sampling->id, 'parameter_id' => $validated['parameter_id']],
                    ['testing_result' => $validated['testing_result']]
                );
                $parameterName = Parameter::find($validated['parameter_id'])->name;
                return response()->json(['success' => true, 'message' => "Result for '{$parameterName}' has been saved."]);
            }

            // Aksi 3: Menyimpan Field Conditions
            if ($action === 'save_field_conditions') {
                $validated = $request->validate([
                    'coordinate' => 'nullable|string', 'temperature' => 'nullable|string',
                    'pressure' => 'nullable|string', 'humidity' => 'nullable|string',
                    'wind_speed' => 'nullable|string', 'wind_direction' => 'nullable|string',
                    'weather' => 'nullable|string',
                ]);

                FieldCondition::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json(['success' => true, 'message' => 'Field conditions has been saved.']);
            }

            // Aksi 4: Menyimpan pilihan logo
            if ($action === 'save_logo_preference') {
                $validated = $request->validate([
                    'show_logo' => 'required|boolean',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $sampling->update(['show_logo' => $validated['show_logo']]);

                return response()->json(['success' => true, 'message' => 'Logo preference has been saved.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN UNTUK METHOD GET (SAAT HALAMAN DIBUKA) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();
        $parameters = Parameter::where('subject_id', $subject->id)->orderBy('id')->get();
        $fieldCondition = FieldCondition::where('institute_subject_id', $instituteSubject->id)->firstOrNew();

        // ✅ Eager load relasi dengan nama TUNGGAL yang sudah kita perbaiki di Model
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parameters->pluck('id'))
            ->with(['samplingTime', 'regulationStandards'])
            ->get()->groupBy('parameter_id');

        $results = Result::where('sampling_id', $samplings->id)->get()->keyBy(function ($item) {
            return "{$item->parameter_id}-{$item->sampling_time_id}";
        });

        $regulations = $instituteSubject->regulations;

        return view('result.stationary_stack.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'parameters', 'samplingTimeRegulations', 'results', 'regulations', 'fieldCondition'
        ));
    }

    public function addWasteWater(Request $request, $id){
        // Cari data utama berdasarkan ID yang dilewatkan di URL
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN UNTUK METHOD POST (SAAT FORM DISUBMIT VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // Aksi 1: Menyimpan data header (info sampling) - Tidak ada perubahan
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'no_sample' => 'required|string|max:255',
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json(['success' => true, 'message' => 'Sample data has been saved successfully!']);
            }

            // Aksi 2: Menyimpan hasil per parameter (Disederhanakan untuk Wastewater)
            if ($action === 'save_single_parameter') {
                $validated = $request->validate([
                    'parameter_id' => 'required|exists:parameters,id',
                    'testing_result' => 'nullable|string|max:255',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                // Logika updateOrCreate disederhanakan, tidak ada lagi regulation_standard_id
                Result::updateOrCreate(
                    ['sampling_id' => $sampling->id, 'parameter_id' => $validated['parameter_id']],
                    ['testing_result' => $validated['testing_result']]
                );

                $parameterName = Parameter::find($validated['parameter_id'])->name;
                return response()->json(['success' => true, 'message' => "Result for '{$parameterName}' has been saved."]);
            }

            // Aksi 3: Menyimpan pilihan logo (Tidak ada perubahan)
            if ($action === 'save_logo_preference') {
                $validated = $request->validate([
                    'show_logo' => 'required|boolean',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $sampling->update(['show_logo' => $validated['show_logo']]);

                return response()->json(['success' => true, 'message' => 'Logo preference has been saved.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN UNTUK METHOD GET (SAAT HALAMAN DIBUKA) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();

        // Ambil hanya parameter yang relevan untuk subject ini
        $parameters = Parameter::where('subject_id', $subject->id)->orderBy('id')->get();

        // Ambil hasil tes yang sudah ada
        $results = Result::where('sampling_id', $samplings->id)->get()->keyBy('parameter_id');

        // Kelompokkan parameter
        $groupedParameters = [
            'Physical Parameters'  => $parameters->filter(fn($p) => in_array($p->name, ['Temperature', 'Total Suspended Solids (TSS)', 'Total Dissolved Solids (TDS)', 'Color'])),
            'Chemistry Parameters' => $parameters->filter(fn($p) => !in_array($p->name, ['Temperature', 'Total Suspended Solids (TSS)', 'Total Dissolved Solids (TDS)', 'Color'])),
        ];

        // Ambil regulasi yang terhubung dengan institute_subject ini untuk ditampilkan di header
        $regulations = $instituteSubject->regulations;

        return view('result.waste_water.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'groupedParameters', 'results', 'regulations'
        ));
    }

    public function addCleanWater(Request $request, $id)
    {
        // Cari data utama berdasarkan ID yang dilewatkan di URL
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;
        $subject = $instituteSubject->subject;

        // --- BAGIAN UNTUK METHOD POST (SAAT FORM DISUBMIT VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // Aksi 1: Menyimpan data header (info sampling) - Tidak ada perubahan
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'no_sample' => 'required|string|max:255',
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json(['success' => true, 'message' => 'Sample data has been saved successfully!']);
            }

            // Aksi 2: Menyimpan hasil per parameter (Disederhanakan untuk Wastewater)
            if ($action === 'save_single_parameter') {
                $validated = $request->validate([
                    'parameter_id' => 'required|exists:parameters,id',
                    'testing_result' => 'nullable|string|max:255',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                // Logika updateOrCreate disederhanakan, tidak ada lagi regulation_standard_id
                Result::updateOrCreate(
                    ['sampling_id' => $sampling->id, 'parameter_id' => $validated['parameter_id']],
                    ['testing_result' => $validated['testing_result']]
                );

                $parameterName = Parameter::find($validated['parameter_id'])->name;
                return response()->json(['success' => true, 'message' => "Result for '{$parameterName}' has been saved."]);
            }

            // Aksi 3: Menyimpan pilihan logo (Tidak ada perubahan)
            if ($action === 'save_logo_preference') {
                $validated = $request->validate([
                    'show_logo' => 'required|boolean',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $sampling->update(['show_logo' => $validated['show_logo']]);

                return response()->json(['success' => true, 'message' => 'Logo preference has been saved.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN UNTUK METHOD GET (SAAT HALAMAN DIBUKA) ---
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();

        // Ambil hanya parameter yang relevan untuk subject ini
        $parameters = Parameter::where('subject_id', $subject->id)->orderBy('id')->get();

        // Ambil hasil tes yang sudah ada
        $results = Result::where('sampling_id', $samplings->id)->get()->keyBy('parameter_id');

        // Kelompokkan parameter
        $groupedParameters = [
            'Physical Parameters'  => $parameters->filter(fn($p) => in_array($p->name, ['Temperature', 'Total Suspended Solids (TSS)', 'Total Dissolved Solids (TDS)', 'Color'])),
            'Chemistry Parameters' => $parameters->filter(fn($p) => !in_array($p->name, ['Temperature', 'Total Suspended Solids (TSS)', 'Total Dissolved Solids (TDS)', 'Color'])),
        ];

        // Ambil regulasi yang terhubung dengan institute_subject ini untuk ditampilkan di header
        $regulations = $instituteSubject->regulations;

        return view('result.clean_water.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'groupedParameters', 'results', 'regulations'
        ));
    }

    public function addSurfaceWater(Request $request, $id){
        // Cari data utama berdasarkan ID yang dilewatkan di URL
        $instituteSubject = InstituteSubject::with('institute', 'subject')->findOrFail($id);
        $institute = $instituteSubject->institute;

        // --- BAGIAN UNTUK METHOD POST (SAAT FORM DISUBMIT VIA AJAX) ---
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // Aksi 1: Menyimpan data header (info sampling)
            if ($action === 'save_header') {
                $validated = $request->validate([
                    'no_sample' => 'required|string|max:255',
                    'sampling_location' => 'required|string|max:255',
                    'sampling_date' => 'required|date',
                    'sampling_time' => 'required|string|max:255',
                    'sampling_method' => 'required|string|max:255',
                    'date_received' => 'required|date',
                    'itd_start' => 'required|date',
                    'itd_end' => 'required|date|after_or_equal:itd_start',
                ]);

                $sampling = Sampling::updateOrCreate(
                    ['institute_subject_id' => $instituteSubject->id],
                    $validated + ['institute_id' => $institute->id]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Sample data has been saved successfully!',
                    'sampling_id' => $sampling->id // Kirim kembali ID sampling jika dibutuhkan
                ]);
            }

            // Aksi 2: Menyimpan hasil per parameter
            if ($action === 'save_single_parameter') {
                $validated = $request->validate([
                    'parameter_id' => 'required|exists:parameters,id',
                    'testing_result' => 'nullable|string|max:255',
                ]);

                // Pertama, pastikan data sampling sudah ada
                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);
                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                // Simpan atau update hasil untuk satu parameter
                Result::updateOrCreate(
                    [
                        'sampling_id' => $sampling->id,
                        'parameter_id' => $validated['parameter_id'],
                    ],
                    [
                        'testing_result' => $validated['testing_result'],
                    ]
                );

                $parameterName = Parameter::find($validated['parameter_id'])->name;
                return response()->json(['success' => true, 'message' => "Result for '{$parameterName}' has been saved."]);
            }

            if ($action === 'save_logo_preference') {
                $validated = $request->validate([
                    'show_logo' => 'required|boolean',
                ]);

                $sampling = Sampling::firstWhere('institute_subject_id', $instituteSubject->id);

                if (!$sampling) {
                    return response()->json(['success' => false, 'message' => 'Please save the sample data first.'], 400);
                }

                $sampling->update(['show_logo' => $validated['show_logo']]);

                return response()->json(['success' => true, 'message' => 'Logo preference has been saved.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // --- BAGIAN UNTUK METHOD GET (SAAT HALAMAN DIBUKA) ---
        // Logika ini tetap sama untuk menyiapkan data saat halaman pertama kali dimuat
        // (Kode dari prompt sebelumnya, sudah benar)
        $subject = $instituteSubject->subject;
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)->firstOrNew();
        $parameters = Parameter::where('subject_id', $subject->id)->orderBy('id')->get();
        $parameterIds = $parameters->pluck('id');
        $regStandards = RegulationStandardCategory::whereIn('parameter_id', $parameterIds)->get()->groupBy('parameter_id');
        $regStandardsByParameter = [];
        foreach ($regStandards as $paramId => $standards) {
            $regStandardsByParameter[$paramId] = $standards->pluck('regulation_standard_id', 'code');
        }
        $results = Result::where('sampling_id', $samplings->id)->get()->keyBy('parameter_id');
        $groupedParameters = [
            'Physical Parameters' => $parameters->filter(fn($p) => in_array($p->name, ['Temperature', 'Total Dissolved Solids (TDS)', 'Total Suspended Solid (TSS)', 'Clarity', 'Color'])),
            'Chemistry Parameters' => $parameters->filter(fn($p) => !in_array($p->name, ['Temperature', 'Total Dissolved Solids (TDS)', 'Total Suspended Solid (TSS)', 'Clarity', 'Color'])),
        ];
        $regulations = $subject->regulations ?? collect();

        return view('result.surface_water.add', compact(
            'instituteSubject', 'institute', 'subject', 'samplings',
            'groupedParameters', 'regStandardsByParameter', 'results', 'regulations'
        ));
    }

    public function addVibration(Request $request, $id)
    {
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
        return view('result.vibration.add', compact(
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
