<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use App\Models\Location;
use App\Models\Resume;
use App\Models\Sampling;
use App\Models\SampleDescription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InstituteController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $description = SampleDescription::all();
        return view('institute.index', compact('data', 'description'));
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

            return redirect()->route('institute.index')->with('msg', 'Data added successfully');
        }

        $data = AmbientAir::all();
        $description = SampleDescription::orderBy('name')->get();
        return view('institute.create', compact('data','description'));
    }


    //Data institute
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

    public function datatables()
    {
        $data = Sampling::select('*');
        return DataTables::of($data)->make(true);
    }
}
