<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\InstituteSubject;
use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\RegulationStandard;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Models\Sampling;
use App\Models\Subject;
use App\Models\SamplingTime;
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
        $data = InstituteSubject::where('institute_id', $id)
            ->with('Subject') // Pastikan relasi ke sample_subjects dimuat
            ->get();

        return response()->json(['data' => $data]);
    }

    public function add_sample(Request $request, $id) {
        if ($request->isMethod('POST')) {
            $institute = Institute::findOrFail($id);
            $sampling = Sampling::where('institute_id', $id)->get();

            $validatedData = $request->validate([
                'no_sample' => ['required'],
                'sampling_location' => ['required'],
                'institute_subject_id' => ['required', 'integer'],
                'sampling_date' => ['required'],
                'sampling_time' => ['required'],
                'sampling_method' => ['required'],
                'date_received' => ['required'],
                'itd_start' => ['required'],
                'itd_end' => ['required'],
            ]);

            $validatedData['institute_id'] = $id;

            if ($sampling->isNotEmpty()) {
                foreach ($sampling as $sample) {
                    $sample->update($validatedData);
                }
                $message = "Data Sample ({$request->no_sample}) updated successfully";
            } else {
                $sampling = Sampling::create($validatedData);
                $message = "Data Sample ({$request->no_sample}) saved successfully";
            }

            return back()->with('msg', $message);
        }

        $samplings = Sampling::all();
        $institute = Institute::findOrFail($id);
        $subjects = Subject::orderBy('name')->get();
        $parameters = Parameter::orderBy('name')->get();
        return view('result.add_result', compact('samplings','institute', 'subjects','parameters'));
    }

    public function add_result(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $institute = Institute::findOrFail($id);
            $samplings = Sampling::where('institute_id', $id)->get();

            if ($request->has('testing_result')) {
                foreach ($request->testing_result as $key => $result) {
                    Result::updateOrCreate(
                        [
                            'sampling_id' => $id,
                            'subject_id' => $request->subject_id[$key] ?? null,
                            'name_parameter' => $request->parameters[$key] ?? null,
                        ],
                        [
                            'sampling_time' => $request->sampling_times[$key] ?? null,
                            'testing_result' => $result,
                            'regulation' => $request->regulations[$key] ?? null,
                            'unit' => $request->units[$key] ?? null,
                            'method' => $request->methods[$key] ?? null,
                        ]
                    );
                }
            }

            return back()->with('msg', 'Data Result (' . $request->no_sample . ') saved successfully');
        }

        $samplingTimes = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();

        $parameters = Parameter::whereHas('regulation', function ($query) use ($id) {
            $query->where('subject_id', $id);
        })->get();
        $parametersIds = $parameters->pluck('id');

        $regulations = Regulation::where('subject_id', $id)->get();
        $regulationsIds = $regulations->pluck('id');

        $instituteSamples = InstituteSubject::where('institute_id', $id)->get();
        $instituteSamplesIds = $instituteSamples->pluck('id');

        $samplings = Sampling::whereIn('institute_subject_id', $instituteSamplesIds)->get();
        $samplingsIds = $samplings->pluck('subject_id');
        $samps = Sampling::whereIn('id', $samplingsIds)
            ->with('regulations.parameters', 'sampling_times.regulation_standards')
            ->get();

        $institute = Institute::findOrFail($id);
        $subjects = Subject::orderBy('name')->get();

        // Debugging data
        // dd(compact('institute', 'subjects', 'samplingTimes', 'regulationStandards', 'regulations', 'parameters', 'instituteSamples', 'samplings', 'samps'));

        return view('result.add_result', compact('institute', 'subjects', 'samplingTimes',
        'regulationStandards', 'parameters', 'regulations', 'instituteSamples', 'samplings','samps'));
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
