<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use App\Models\Location;
use App\Models\Sampling;
use App\Models\SampleDescription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AmbientAirController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $description = SampleDescription::all();
        return view('ambient_air.index', compact('data', 'description'));
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
                'testing_result' => ['required'],
                'parameter_id' => ['required'],
                'note_id' => ['required'],
            ]);

            $data = AmbientAir::create([
                'testing_result' => $request->testing_result,
                'parameter_id' => $request->parameter_id,
                'note_id' => $request->note_id,
            ]);

            if ($data) {
                return redirect()->route('ambient_air.index')->with('msg', 'Data ('.$request->no_sample.') added successfully');
            }
        }

        $data = Sampling::all();
        return view('ambient_air.create', compact('data'));
    }

    //Data AmbientAir
    public function data(Request $request)
    {
        $data = Sampling::with([
            'description' => function ($query) {
                $query->select('name');
            },
        ])->orderBy("id" )->get;
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_description'))) {
                    $instance->whereHas('description', function ($q) use ($request) {
                        $q->where('sample_description_id', $request->get('select_description'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('no_sample', 'LIKE', "%$search%")
                        ->orWhere('date', 'LIKE', "%$search%")
                        ->orWhere('description.name', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }

    public function datatables()
    {
        $data = Sampling::select('*');
        return DataTables::of($data)->make(true);
    }
}
