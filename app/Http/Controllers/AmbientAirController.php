<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\InstituteRegulation;
use App\Models\InstituteSubject;
use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\Result;
use App\Models\Sampling;
use App\Models\Subject;
use App\Models\SamplingTimeRegulation;

class AmbientAirController extends Controller
{
    public function add_sample(Request $request, $id, $sampleNo)
    {
        if ($request->isMethod('POST')) {
            $instituteSubject = InstituteSubject::findOrFail($id);
            $institute = Institute::findOrFail($instituteSubject->institute_id);

            // Validasi data
            $validatedData = $request->validate([
                'sampling_location' => ['required'],
                'institute_subject_id' => ['required', 'integer'],
                'sampling_date' => ['required', 'date'],
                'sampling_time' => ['required'],
                'sampling_method' => ['required'],
                'date_received' => ['required', 'date'],
                'itd_start' => ['required'],
                'itd_end' => ['required'],
            ]);

            // Set nilai no_sample berdasarkan fungsi
            $validatedData['no_sample'] = $sampleNo;
            $validatedData['institute_id'] = $id;

            // Periksa apakah institute_subject_id valid
            if ($request->filled('institute_subject_id')) {
                $instituteSubjectExists = InstituteSubject::where('id', $request->institute_subject_id)
                    ->where('institute_id', $id)
                    ->exists();

                if ($instituteSubjectExists) {
                    $validatedData['institute_subject_id'] = $request->institute_subject_id;
                }
            }

            // Cek apakah data sudah ada
            $existingSample = Sampling::where('institute_id', $id)
                ->where('institute_subject_id', $request->institute_subject_id)
                ->where('no_sample', $sampleNo)
                ->first();

            if ($existingSample) {
                $existingSample->update($validatedData);
                $message = "Data Coa ({$institute->no_coa}.{$sampleNo}) updated successfully!";
                $alertType = 'warning'; // Notifikasi warna kuning untuk update
            } else {
                Sampling::create($validatedData);
                $message = "Data Coa ({$institute->no_coa}.{$sampleNo}) saved successfully!";
                $alertType = 'success'; // Notifikasi warna hijau untuk create baru
            }

            return back()->with(['msg' => $message, 'alertType' => $alertType]);
        }

        // **Bagian GET request**
        $institute = Institute::findOrFail($id);
        $instituteSubjects = InstituteSubject::where('institute_id', $institute->id)->get();
        $sampling = Sampling::where('institute_id', $id)
        ->where('no_sample', $sampleNo) // Ambil data berdasarkan no_sample
        ->first();
        return view('result.add_result', compact(
            'samplings', 'institute', 'subjects',
            'parameters', 'instituteSubjects', 'sampling'
        ));
    }

    // Fungsi khusus untuk 01
    public function add_sample_1(Request $request, $id)
    {
        return $this->add_sample($request, $id, '01');
    }

    // Fungsi khusus untuk 02
    public function add_sample_2(Request $request, $id)
    {
        return $this->add_sample($request, $id, '02');
    }

    // Fungsi khusus untuk 03
    public function add_sample_3(Request $request, $id)
    {
        return $this->add_sample($request, $id, '03');
    }

    // Fungsi khusus untuk 04
    public function add_sample_4(Request $request, $id)
    {
        return $this->add_sample($request, $id, '04');
    }

    // Fungsi khusus untuk 05
    public function add_sample_5(Request $request, $id)
    {
        return $this->add_sample($request, $id, '05');
    }

    // Fungsi khusus untuk 06
    public function add_sample_6(Request $request, $id)
    {
        return $this->add_sample($request, $id, '06');
    }

    // Fungsi khusus untuk 07
    public function add_sample_7(Request $request, $id)
    {
        return $this->add_sample($request, $id, '07');
    }

    // Fungsi khusus untuk 08
    public function add_sample_8(Request $request, $id)
    {
        return $this->add_sample($request, $id, '08');
    }

    // Fungsi khusus untuk 09
    public function add_sample_9(Request $request, $id)
    {
        return $this->add_sample($request, $id, '09');
    }

    // Fungsi khusus untuk 010
    public function add_sample_10(Request $request, $id)
    {
        return $this->add_sample($request, $id, '010');
    }

    public function addAmbientAir_1(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '01')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '01')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_1', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_2(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '02')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_2', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_3(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '03')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_3', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_4(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '04')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_4', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_5(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '05')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_5', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_6(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '06')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_6', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_7(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '07')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_7', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_8(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '08')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_8', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_9(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '09')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_9', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }

    public function addAmbientAir_10(Request $request, $id)
    {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        if ($request->isMethod('POST')) {
            $parameters = $request->input('parameter_id', []);
            $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
                ->where('no_sample', '010')
                ->latest()
                ->first();

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
        $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
            ->pluck('regulation_id');
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();
        $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
        $parametersIds = $parameters->pluck('id');
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parametersIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '02')
            ->latest()
            ->first();
        $results = collect();
        if ($samplings) {
            $results = Result::where('sampling_id', $samplings->id)
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.ambient_air.add_10', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling'
        ));
    }
}
