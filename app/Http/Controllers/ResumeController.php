<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use App\Models\Sampling;
use App\Models\SampleDescription;
use Yajra\DataTables\Facades\DataTables;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $description = SampleDescription::orderBy('name')->get();
        return view('resume.index', compact('data', 'description'));
    }

    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'no_sample' => ['required'],
                'sampling_location' => ['required'],
                'date' => ['required'],
                'time' => ['required'],
                'method' => ['required'],
                'date_received' => ['required'],
                'itd_start' => ['required'],
                'itd_end' => ['required'],
            ]);

            $data = Sampling::create([
                'no_sample' => $request->no_sample,
                'sampling_location' => $request->sampling_location,
                'sample_description_id' => 1, // Master Data dengan ID 1
                'date' => $request->date,
                'time' => $request->time,
                'method' => $request->method,
                'date_received' => $request->date_received,
                'itd_start' => $request->itd_start,
                'itd_end' => $request->itd_end,
            ]);

            if ($data) {
                return redirect()->route('ambient_air.index')->with('msg', 'Data ('.$request->no_sample.') added successfully');
            }
        }

        $data = Sampling::all();
        return view('ambient_air.add', compact('data'));
    }

    public function create(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'testing_result.*' => ['required'], // Validasi array input
            ]);

            foreach ($request->testing_result as $id => $result) {
                Resume::where('id', $id)->update([
                    'testing_result' => $result,
                    'sample_description_id' => $request->sample_description_id[$id] ??'',
                ]);
            }

            return redirect()->route('resume.index')->with('msg', 'Data added successfully');
        }

        $data = Resume::all();
        $description = SampleDescription::orderBy('name')->get();
        return view('resume.create', compact('data','description'));
    }

    public function data(Request $request)
    {
        $data = Resume::with(['sampleDescriptions' => function ($query) {
                $query->select('sample_descriptions.id', 'sample_descriptions.name');
            }])
            ->select('*')
            ->orderBy("id")
            ->get();

        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_description'))) {
                    $instance->whereHas('sampleDescriptions', function ($q) use ($request) {
                        $q->where('sample_descriptions.id', $request->get('select_description'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where(function ($w) use ($search) {
                        $w->orWhere('no_sample', 'LIKE', "%$search%")
                            ->orWhere('date', 'LIKE', "%$search%")
                            ->orWhereHas('sampleDescriptions', function ($q) use ($search) {
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
    //     $resume = Resume::find($id);

    //     if ($resume) {
    //         $resume->delete();
    //         return response()->json(['message' => 'Resume deleted'], 200);
    //     } else {
    //         return response()->json(['message' => 'Resume not found'], 404);
    //     }
    // }
}
