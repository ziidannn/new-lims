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
use Illuminate\Support\Facades\DB;

class NoiseController extends Controller
{
    public function noise_sample(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            // Ambil data InstituteSubject berdasarkan ID yang dikirim
            $instituteSubject = InstituteSubject::findOrFail($id);
            $institute = Institute::findOrFail($instituteSubject->institute_id);

            // Validasi input
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

            // Masukkan institute_id dan institute_subject_id yang valid
            $validatedData['institute_id'] = $institute->id;
            $validatedData['institute_subject_id'] = $instituteSubject->id;

            // Cek apakah sudah ada data sampling dengan no_sample yang sama
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

            return back()->with(['msg' => $message, 'alertType' => $alertType]);
        }

        // GET REQUEST → panggil data
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);

        $subjects = Subject::orderBy('name')->get();
        $parameters = Parameter::orderBy('name')->get();
        $instituteSubjects = InstituteSubject::where('institute_id', $institute->id)->get();

        // Ambil dua sampling: paling awal dan paling akhir
        $firstSampling = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->orderBy('created_at', 'asc')
            ->first();

        $latestSampling = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('result.noise.add', compact(
            'firstSampling',      // untuk noise (LOC 1)
            'latestSampling',     // untuk noise_new (LOC 2)
            'institute',
            'subjects',
            'parameters',
            'instituteSubjects',
            'instituteSubject'
        ));
    }

    // public function noise_sample_new(Request $request, $id) {
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
    //             $message = "Data Coa ({$institute->no_coa}.{$request->no_sample}) updated successfully!";
    //             $alertType = 'warning'; // Notifikasi warna kuning untuk update
    //         } else {
    //             // Jika belum ada → CREATE baru
    //             Sampling::create($validatedData);
    //             $message = "Data Coa ({$institute->no_coa}.{$request->no_sample}) saved successfully!";
    //             $alertType = 'success'; // Notifikasi warna hijau untuk create baru
    //         }

    //         return back()->with(['msg' => $message, 'alertType' => $alertType]);
    //     }

    //     // Ini asumsinya $id adalah institute_subject_id
    //     $institute = Institute::findOrFail($id);
    //     $instituteSubjects = InstituteSubject::where('institute_id', $institute->id)->get();

    //     // Cari sampling TERAKHIR untuk institute_subject_id itu
    //     $samplings = Sampling::where('institute_id', $id)
    //     ->where('institute_subject_id', $instituteSubjects->id) // Tambahkan ini
    //     ->first(); // <-- Pakai first() kalau satu data, atau get() kalau banyak

    //     $subjects = Subject::orderBy('name')->get();
    //     $parameters = Parameter::orderBy('name')->get();

    //     return view('result.noise.add_new', compact(
    //         'samplings', 'institute', 'subjects', 'parameters', 'instituteSubjects'
    //     ));
    // }

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
                'unit.*' => 'nullable|string',
                'method.*' => 'nullable|string',
                'noise.*.*' => 'nullable|string',
                'time.*.*' => 'nullable|string',
                'leq.*.*' => 'nullable|string',
                'ls.*' => 'nullable|string',
                'lm.*' => 'nullable|string',
                'lsm.*' => 'nullable|string',
                'regulatory_standard.*' => 'nullable|string',
                'location.*' => 'nullable|string'
            ]);

            $messages = [];

            foreach ($request->location as $locIndex => $location) {
                if (empty($location)) {
                    continue; // Skip lokasi kosong
                }

                // CEK apakah noise tersedia untuk lokasi ini
                if (!isset($request->noise[$locIndex]) || !is_array($request->noise[$locIndex])) {
                    continue; // Skip kalau noise untuk location ini tidak ada
                }

                foreach ($request->noise[$locIndex] as $i => $noiseValue) {
                    if (empty($noiseValue)) {
                        continue; // Skip noise kosong
                    }

                    $parameterId = $parameters[$locIndex]->id ?? null;
                    $timeValue = $request->time[$locIndex][$i] ?? null; // optional

                    $existingResult = Result::where([
                        'sampling_id' => $samplingNoise->id,
                        'parameter_id' => $parameterId,
                        'location' => $location,
                        'noise' => $noiseValue,
                        'time' => $timeValue
                    ])->first();

                    if ($existingResult) {
                        $existingResult->update([
                            'unit' => $request->unit[$locIndex] ?? null,
                            'method' => $request->method[$locIndex] ?? null,
                            'leq' => $request->leq[$locIndex][$i] ?? null,
                            'ls' => $request->ls[$locIndex] ?? null,
                            'lm' => $request->lm[$locIndex] ?? null,
                            'lsm' => $request->lsm[$locIndex] ?? null,
                            'regulatory_standard' => $request->regulatory_standard[$locIndex] ?? null,
                        ]);
                    } else {
                        Result::create([
                            'sampling_id' => $samplingNoise->id,
                            'parameter_id' => $parameterId,
                            'unit' => $request->unit[$locIndex] ?? null,
                            'method' => $request->method[$locIndex] ?? null,
                            'time' => $timeValue,
                            'noise' => $noiseValue,
                            'leq' => $request->leq[$locIndex][$i] ?? null,
                            'ls' => $request->ls[$locIndex] ?? null,
                            'lm' => $request->lm[$locIndex] ?? null,
                            'lsm' => $request->lsm[$locIndex] ?? null,
                            'regulatory_standard' => $request->regulatory_standard[$locIndex] ?? null,
                            'location' => $location,
                        ]);
                    }

                    $messages["$location"] = "Data untuk lokasi $location telah diperbarui/dibuat.";
                }
            }

            return redirect()->back()->with('msg', implode(' ', array_values($messages)));
        }

        $subject = Subject::where('id', $instituteSubject->subject_id)->first();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
        ->latest('id')
        ->first();
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
        $results = DB::table('results')
            ->select('location', DB::raw('GROUP_CONCAT(leq ORDER BY id) as leq_values'), 'ls', 'lm', 'lsm', 'regulatory_standard')
            ->groupBy('location', 'ls', 'lm', 'lsm', 'regulatory_standard')
            ->get();

        return view('result.noise.add',compact(
            'institute', 'parameters', 'regulations', 'subjects', 'samplingTimeRegulations',
            'results', 'subject', 'instituteSubject', 'samplings'
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
                'time.*.*' => 'nullable|string',
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
                            'testing_result' => $request->testing_result[$index] ?? null,
                            'unit' => $request->unit[$parameterId] ?? null,
                            'method' => $request->method[$parameterId] ?? null,
                            'time' => $request->time[$index] ?? null,
                            'regulatory_standard' => $request->regulatory_standard[$index] ?? null,
                            'location' => $location,
                        ]);
                        $messages[] = "Data for location $location updated successfully.";
                    } else {
                        Result::create([
                            'sampling_id' => $samplingNoise->id,
                            'parameter_id' => $parameterId,
                            'testing_result' => $request->testing_result[$index] ?? null,
                            'unit' => $request->unit[$parameterId] ?? null,
                            'method' => $request->method[$parameterId] ?? null,
                            'time' => $request->time[$index] ?? null,
                            'regulatory_standard' => $request->regulatory_standard[$index] ?? null,
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

        $results = Result::where('sampling_id', $samplings->id)
            ->with('parameter') // tambahkan ini
            ->get();
        return view('result.noise.add_new',compact(
            'institute', 'parameters', 'regulations', 'subjects',
            'samplingTimeRegulations', 'results', 'subject', 'instituteSubject'
        ));
    }
}
