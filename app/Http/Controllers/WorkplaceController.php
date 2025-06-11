<?php

namespace App\Http\Controllers;

use App\Models\FieldCondition;
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

class WorkplaceController extends Controller
{
    // public function add_sample_workplace(Request $request, $instituteId, $instituteSubjectId, $sampleIndex = null)
    // {
    //     $institute = Institute::findOrFail($instituteId);
    //     $instituteSubject = InstituteSubject::findOrFail($instituteSubjectId);

    //     if ($request->isMethod('POST')) {
    //         $validatedData = $request->validate([
    //             'sampling_location' => ['required'],
    //             'sampling_date' => ['required', 'date'],
    //             'sampling_time' => ['required'],
    //             'sampling_method' => ['required'],
    //             'date_received' => ['required', 'date'],
    //             'itd_start' => ['required'],
    //             'itd_end' => ['required'],
    //         ]);

    //         // Hitung jumlah sample yang sudah ada untuk subject tersebut
    //         $existingSamplesCount = Sampling::where('institute_subject_id', $instituteSubjectId)->count();
    //         $nextSampleNumber = str_pad($existingSamplesCount + 1, 2, '0', STR_PAD_LEFT);

    //         // Jika sampleIndex disediakan (saat edit), pakai itu
    //         $no_sample = $sampleIndex ?? $nextSampleNumber;

    //         $samplingData = $validatedData + [
    //             'no_sample' => $no_sample,
    //             'institute_id' => $instituteId,
    //             'institute_subject_id' => $instituteSubjectId,
    //         ];

    //         $existingSample = Sampling::where('institute_id', $instituteId)
    //             ->where('institute_subject_id', $instituteSubjectId)
    //             ->where('no_sample', $no_sample)
    //             ->first();

    //         if ($existingSample) {
    //             $existingSample->update($samplingData);
    //             $message = "Sample {$no_sample} updated!";
    //         } else {
    //             Sampling::create($samplingData);
    //             $message = "Sample {$no_sample} created!";
    //         }

    //         return back()->with('msg', $message);
    //     }

    //     $sampling = null;
    //     if ($sampleIndex) {
    //         $sampling = Sampling::where('institute_id', $instituteId)
    //             ->where('institute_subject_id', $instituteSubjectId)
    //             ->where('no_sample', $sampleIndex)
    //             ->first();
    //     }

    //     return view('result.add_result', compact('institute', 'instituteSubject', 'sampling'));
    // }

    // // Fungsi khusus untuk 01
    // public function add_sample_1(Request $request, $id) {
    //     return $this->add_sample($request, $id, '01');
    // }

    // // Fungsi khusus untuk 02
    // public function add_sample_2(Request $request, $id) {
    //     return $this->add_sample($request, $id, '02');
    // }

    // // Fungsi khusus untuk 03
    // public function add_sample_3(Request $request, $id) {
    //     return $this->add_sample($request, $id, '03');
    // }

    // // Fungsi khusus untuk 04
    // public function add_sample_4(Request $request, $id) {
    //     return $this->add_sample($request, $id, '04');
    // }

    // // Fungsi khusus untuk 05
    // public function add_sample_5(Request $request, $id) {
    //     return $this->add_sample($request, $id, '05');
    // }

    // // Fungsi khusus untuk 06
    // public function add_sample_6(Request $request, $id) {
    //     return $this->add_sample($request, $id, '06');
    // }

    // // Fungsi khusus untuk 07
    // public function add_sample_7(Request $request, $id) {
    //     return $this->add_sample($request, $id, '07');
    // }

    // // Fungsi khusus untuk 08
    // public function add_sample_8(Request $request, $id) {
    //     return $this->add_sample($request, $id, '08');
    // }

    // // Fungsi khusus untuk 09
    // public function add_sample_9(Request $request, $id) {
    //     return $this->add_sample($request, $id, '09');
    // }

    // // Fungsi khusus untuk 010
    // public function add_sample_10(Request $request, $id) {
    //     return $this->add_sample($request, $id, '010');
    // }

    public function addWorkplace(Request $request, $id)
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
                ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
                ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id')->flatten()->filter())
                ->get()
                ->groupBy(function ($item) {
                    return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
                });
        }

        return view('result.workplace.add', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'subjects', 'samplings'
        ));
    }

    public function addWorkplace_2(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '02',
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

        return view('result.workplace.add_2', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_3(Request $request, $id){
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '03',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '03')
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

        return view('result.workplace.add_3', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_4(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '04',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '04')
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

        return view('result.workplace.add_4', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_5(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            if ($action === 'save_parameter') {
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

            // Cek jika tombol 'save_all' ditekan
            if ($action === 'save_all') {
                // Menyimpan data field condition dan show logo
                Sampling::updateOrCreate(
                    [
                        'institute_subject_id' => $instituteSubject->id,
                        'no_sample' => '05',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '05')
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

        return view('result.workplace.add_5', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_6(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Check if the request has 'save_all' parameter
        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '06',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '06')
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

        return view('result.workplace.add_6', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_7(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '07',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '07')
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

        return view('result.workplace.add_7', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_8(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '08',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '08')
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

        return view('result.workplace.add_8', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_9(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '09',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '09')
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

        return view('result.workplace.add_9', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }

    public function addWorkplace_10(Request $request, $id) {
        $instituteSubject = InstituteSubject::findOrFail($id);
        $institute = Institute::findOrFail($instituteSubject->institute_id);
        $sampling = Sampling::where('institute_subject_id', $instituteSubject->id)->get();

        // Handle POST request
        if ($request->isMethod('POST')) {
            $action = $request->input('action');

        if ($action === 'save_parameter') {
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

        // Cek jika tombol 'save_all' ditekan
        if ($action === 'save_all') {
            // Menyimpan data field condition dan show logo
            Sampling::updateOrCreate(
                [
                    'institute_subject_id' => $instituteSubject->id,
                    'no_sample' => '010',
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
        $samplings = Sampling::where('institute_subject_id', $instituteSubject->id)
            ->where('no_sample', '010')
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

        return view('result.workplace.add_10', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'regulations', 'subject', 'instituteSubject', 'sampling', 'subjects'
        ));
    }
}
