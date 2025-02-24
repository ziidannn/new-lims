<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use App\Models\Location;
use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\RegulationStandard;
use App\Models\Resume;
use App\Models\Sampling;
use App\Models\SampleDescription;
use App\Models\SamplingTime;
use App\Models\SamplingTimeRegulation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{
    //regulation
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'title' => ['required'],
                'sample_description_id' => ['required'],
            ]);

            $data = Regulation::create([
                'title' => $request->title,
                'sample_description_id' => $request->sample_description_id, // Tambahkan regulation_id
            ]);

            if ($data) {
                return redirect()->route('coa.regulation.index')->with('msg', 'Data ('.$request->title.') added successfully');
            }
        }

        $data = Regulation::all();
        $description = SampleDescription::orderBy('name')->get();
        return view('coa.regulation.index', compact('data', 'description'));
    }

    public function edit_regulation(Request $request, $id){
        $data = Regulation::findOrFail($id);
        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'title'    => 'string', 'max:191',
            'sample_description_id' => 'string'
        ]);

        $data->update([
            'title'=> $request->title,
            'sample_description_id'=> $request->sample_description_id,
        ]);
            return redirect()->route('coa.regulation.index')->with('msg', 'Regulation updated successfully.');
        }

        $description = SampleDescription::orderBy('name')->get();
        return view('coa.regulation.edit', compact('data', 'description'));
    }

    public function delete_regulation(Request $request){
        $data = Regulation::find($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete! Data not found'
            ]);
        }
    }

    //data_regulation
    public function data_regulation(Request $request)
    {
        $data = Regulation::with(['description' => function ($query) {
            $query->select('id','name');
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

    //----------------------------------------------- P A R A M E T E R ----------------------------------------------------//

    public function parameter(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'name' => 'required',
                'sampling_time_id' => 'required|array',
                'regulation_standard_id' => 'required|array',
                'unit' => 'required',
                'method' => 'required',
                'regulation_id' => 'required'
            ]);

            // Simpan parameter utama
            $parameter = Parameter::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'method' => $request->method,
                'regulation_id' => $request->regulation_id
            ]);

            // Simpan multiple sampling_time_id dan regulation_standard_id
            foreach ($request->sampling_time_id as $key => $samplingTimeId) {
                SamplingTimeRegulation::create([
                    'parameter_id' => $parameter->id,
                    'sampling_time_id' => $samplingTimeId,
                    'regulation_standard_id' => $request->regulation_standard_id[$key]
                ]);
            }

            return redirect()->route('coa.parameter.index')->with('msg', 'Data berhasil ditambahkan');
        }

        $data = Parameter::all();
        $regulation = Regulation::orderBy('title')->get();
        $sampling_times = SamplingTime::orderBy('time')->get();
        $regulation_standards = RegulationStandard::orderBy('title')->get();

        return view('coa.parameter.index', compact(
            'data', 'regulation', 'sampling_times', 'regulation_standards'
        ));
    }

    public function add_parameter(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'name' => 'required',
                'sampling_time_id' => 'required|array',
                'regulation_standard_id' => 'required|array',
                'unit' => 'required',
                'method' => 'required',
                'regulation_id' => 'required'
            ]);

            // Simpan data utama ke tabel `parameters`
            $parameter = Parameter::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'method' => $request->method,
                'regulation_id' => $request->regulation_id
            ]);

            // Simpan data multiple input ke tabel `sampling_time_regulations`
            foreach ($request->sampling_time_id as $key => $samplingTimeId) {
                SamplingTimeRegulation::create([
                    'parameter_id' => $parameter->id,
                    'sampling_time_id' => $samplingTimeId,
                    'regulation_standard_id' => $request->regulation_standard_id[$key]
                ]);
            }

            return redirect()->route('coa.parameter.index')->with('msg', 'Parameter created successfully.');
        }

        // Ambil data untuk dropdown
        $regulation = Regulation::orderBy('title')->get();
        $sampling_times = SamplingTime::orderBy('time')->get();
        $regulation_standards = RegulationStandard::orderBy('title')->get();

        return view('coa.parameter.add_parameter', compact(
            'regulation', 'sampling_times', 'regulation_standards'
        ));
    }

    public function edit_parameter(Request $request, $id)
    {
        $data = Parameter::findOrFail($id);

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'name' => 'required',
                'sampling_time_id' => 'required|array',
                'regulation_standard_id' => 'required|array',
                'unit' => 'required',
                'method' => 'required',
                'regulation_id' => 'required'
            ]);

            // Update data utama di tabel `parameters`
            $data->update([
                'name' => $request->name,
                'unit' => $request->unit,
                'method' => $request->method,
                'regulation_id' => $request->regulation_id
            ]);

            // Hapus data lama di tabel `sampling_time_regulations`
            SamplingTimeRegulation::where('parameter_id', $id)->delete();

            // Simpan data baru dari multiple input sampling_time_id dan regulation_standard_id
            foreach ($request->sampling_time_id as $key => $samplingTimeId) {
                SamplingTimeRegulation::create([
                    'parameter_id' => $data->id,
                    'sampling_time_id' => $samplingTimeId,
                    'regulation_standard_id' => $request->regulation_standard_id[$key]
                ]);
            }

            return redirect()->route('coa.parameter.index')->with('msg', 'Parameter updated successfully.');
        }

        // Ambil semua data terkait untuk dropdown
        $regulation = Regulation::orderBy('title')->get();
        $sampling_times = SamplingTime::orderBy('time')->get();
        $regulation_standards = RegulationStandard::orderBy('title')->get();

        // Ambil data yang sudah ada dari tabel `sampling_time_regulations`
        $existingSamplingTimes = SamplingTimeRegulation::where('parameter_id', $id)->get();

        return view('coa.parameter.edit', compact(
            'data', 'regulation', 'sampling_times', 'regulation_standards', 'existingSamplingTimes'
        ));
    }

    //data_parameter
    public function data_parameter(Request $request)
    {
        $data = Parameter::with([
            'regulation:id,title',
            'samplingTimeRegulations.samplingTime:id,time',
            'samplingTimeRegulations.regulationStandard:id,title'
        ])->select('*')->orderBy("id")->get();

        return DataTables::of($data)
            ->addColumn('sampling_times', function ($row) {
                $samplingTimes = $row->samplingTimeRegulations->pluck('samplingTime.time')->toArray();
                return !empty($samplingTimes) ? implode(', ', $samplingTimes) : '-';
            })
            ->addColumn('regulation_standards', function ($row) {
                $regulationStandards = $row->samplingTimeRegulations->pluck('regulationStandard.title')->toArray();
                return !empty($regulationStandards) ? implode(', ', $regulationStandards) : '-';
            })
            ->rawColumns(['sampling_times', 'regulation_standards'])
            ->make(true);
    }

    //----------------------------------- S A M P L I N G  T I M E ------------------------------------------//

    //sampling_time
    public function sampling_time(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'time' => ['required'],
            ]);

            $data = SamplingTime::create([
                'time' => $request->time,
            ]);

            if ($data) {
                return redirect()->route('coa.sampling_time.index')->with('msg', 'Data ('.$request->time.') added successfully');
            }
        }

        $data = SamplingTime::all();
        return view('coa.sampling_time.index', compact('data'));
    }

    public function edit_sampling_time(Request $request, $id){

        $data = SamplingTime::findOrFail($id);

        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'time'    => 'string', 'max:191',
        ]);

        $data->update([
            'time'=> $request->time,
        ]);
            if ($data) {
                return redirect()->route('coa.sampling_time.index')->with('msg', 'Data Sampling Time ('.$request->time.') added successfully');
            }
        }

        return view('coa.sampling_time.edit', compact('data'));
    }

    //data_sampling_time
    public function data_sampling_time(Request $request)
    {
        $data = SamplingTime::select('*')
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

    //----------------------------------- R E G U L A T I O N  S T A N D A R D ------------------------------------------//

    public function regulation_standard(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'title' => ['required'],
            ]);

            $data = RegulationStandard::create([
                'title' => $request->title,
            ]);

            if ($data) {
                return redirect()->route('coa.regulation_standard.index')->with('msg', 'Data ('.$request->title.') added successfully');
            }
        }

        $data = RegulationStandard::all();
        return view('coa.regulation_standard.index', compact('data'));
    }

    public function edit_regulation_standard(Request $request, $id)
    {
        $data = RegulationStandard::findOrFail($id);

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'title' => 'required|string|max:191',
            ]);

            $data->update([
                'title' => $request->title,
            ]);

            return redirect()->route('coa.regulation_standard.index')->with('msg', 'Regulation Standard updated successfully.');
        }

        return view('coa.regulation_standard.edit', compact('data'));
    }

    //data_regulation
    public function data_regulation_standard(Request $request)
    {
        $data = RegulationStandard::select('*')
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
