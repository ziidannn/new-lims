<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use App\Models\Location;
use App\Models\Resume;
use App\Models\Sampling;
use App\Models\SampleDescription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $description = SampleDescription::all();
        return view('coa.regulation.index', compact('data', 'description'));
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
                return redirect()->route('coa.index')->with('msg', 'Data ('.$request->no_sample.') added successfully');
            }
        }

        $data = Sampling::all();
        return view('coa.add', compact('data'));
    }

    public function create(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'testing_result.*' => ['required'], // Validasi array input
            ]);

            foreach ($request->testing_result as $id => $result) {
                AmbientAir::where('id', $id)->update([
                    'testing_result' => $result,
                    'sample_description_id' => $request->sample_description_id[$id] ?? 1,
                ]);
            }

            return redirect()->route('coa.index')->with('msg', 'Data added successfully');
        }

        $data = AmbientAir::all();
        return view('coa.create', compact('data'));
    }

    public function add_description(Request $request, $id)
    {
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
                'resume_lims_id' => 1,
                'date' => $request->date,
                'time' => $request->time,
                'method' => $request->method,
                'date_received' => $request->date_received,
                'itd_start' => $request->itd_start,
                'itd_end' => $request->itd_end,
            ]);

            if ($data) {
                return redirect()->route('coa.index')->with('msg', 'Data ('.$request->no_sample.') added successfully');
            }
        }

        $data = Resume::findOrFail($id);
        $description = SampleDescription::all();
        // dd($description);
        return view('coa.add_sampling', compact('data','description'));
    }

    public function parameter(Request $request)
    {
        $data = Sampling::all();
        $description = SampleDescription::all();
        return view('coa.parameter.index', compact('data', 'description'));
    }

    //data_regulation
    public function data_regulation(Request $request)
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

    public function datatables()
    {
        $data = Sampling::select('*');
        return DataTables::of($data)->make(true);
    }
}
