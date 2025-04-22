<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\RegulationStandard;
use App\Models\Sampling;
use App\Models\Subject;
use App\Models\SamplingTime;
use App\Models\SamplingTimeRegulation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{

    // Subject
    public function subject()
    {
        $data = Subject::all();
        return view('coa.subject.index', compact('data'));
    }

    public function create_subject(Request $request)
    {
        if ($request->isMethod('post')) { // 'post' harus dalam lowercase
            $this->validate($request, [
                'subject_code' => 'required',
                'name' => 'required',
            ]);

            $data = Subject::create([
                'subject_code' => $request->subject_code,
                'name' => $request->name,
            ]);

            return redirect()->route('coa.subject.index')->with('msg', 'Subject (' . $request->name . ') added successfully');
        }

        return view('coa.subject.index'); // Tidak perlu mengirimkan $data ke view
    }

    // Edit_Subject
    public function edit_subject(Request $request, $id)
    {
        $subject = Subject::findOrFail($id); // atau model kamu sendiri
        $subject->update([
            'subject_code' => $request->subject_code,
            'name' => $request->name,
        ]);

        return response()->json(['success' => true]);
    }

    // Delete_Subject
    public function delete_subject(Request $request){
        $data = Subject::find($request->id);
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

    // Data_Subject
    public function data_subject(Request $request)
    {
        $data = Subject::all();
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where(function ($w) use ($search) {
                        $w->orWhere('subject_code', 'LIKE', "%$search%")
                            ->orWhere('name', 'LIKE', "%$search%");
                    });
                }
            })
            ->make(true);
    }

    //----------------------------------------------- R E G U L A T I O N ----------------------------------------------------//
    //regulation
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'title' => ['required'],
                'regulation_code' => ['required'],
                'subject_id' => ['required'],
            ]);

            $data = Regulation::create([
                'title' => $request->title,
                'regulation_code' => $request->regulation_code,
                'subject_id' => $request->subject_id, // Tambahkan subject_id
            ]);

            if ($data) {
                return redirect()->route('coa.regulation.index')->with('msg', 'Data ('.$request->title.') added successfully');
            }
        }

        $data = Regulation::all();
        $subjects = Subject::all();
        return view('coa.regulation.index', compact('data', 'subjects'));
    }

    // Edit Regulation
    public function edit_regulation(Request $request, $id){
        $data = Regulation::with('subjects')->findOrFail($id);
        $subjects = Subject::all();

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'title'    => 'string|max:191',
                'regulation_code' => 'string',
                'subject_id' => 'string'
            ]);

            $data->update([
                'title'=> $request->title,
                'regulation_code'=> $request->regulation_code,
                'subject_id'=> $request->subject_id,
            ]);

            return redirect()->route('coa.regulation.index')
                ->with('msg', 'Regulation updated successfully.');
        }

        return view('coa.regulation.edit', compact('data', 'subjects'));
    }

    // Delete Regulation
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
        $data = Regulation::with(['subjects' => function ($query) {
            $query->select('id','name');
        }])
        ->select('*')
        ->orderBy("id")
        ->get();
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_subjects'))) {
                    $instance->whereHas('Subjects', function ($q) use ($request) {
                        $q->where('sample_subjects.id', $request->get('select_subjects'));
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

    //----------------------------------------------- P A R A M E T E R ----------------------------------------------------//
    // Parameter
    public function parameter(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'name' => 'required',
                'sampling_time_id' => 'required|array',
                'regulation_standard_id' => 'required|array',
                'unit' => 'required',
                'method' => 'required',
                'subject_id' => 'required'
            ]);

            // Simpan parameter utama
            $parameter = Parameter::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'method' => $request->method,
                'subject_id' => $request->subject_id, // Tambahkan subject_id
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
        $subjects = Subject::orderBy('name')->get();
        $samplingTime = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();

        return view('coa.parameter.index', compact(
            'data','subjects', 'samplingTime', 'regulationStandards'
        ));
    }
    // Add Parameter
    public function add_parameter(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'unit' => ['required'],
                'method' => ['required'],
                'subject_id' => ['required'],
            ]);

            // Cek apakah subject yang dipilih adalah '01' (misalnya Ambient Air)
            $subject = Subject::find($request->subject_id);

            if ($subject && $subject->subject_code === '01') {
                $request->validate([
                    'name' => ['required'],
                    'sampling_time_id' => ['required', 'array'],
                    'regulation_standard_id' => ['required', 'array'],
                ]);
            }

            $parameter = Parameter::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'method' => $request->method,
                'subject_id' => $request->subject_id,
            ]);

            if ($subject && $subject->subject_code === '01') {
                foreach ($request->sampling_time_id as $key => $samplingTimeId) {
                    SamplingTimeRegulation::create([
                        'parameter_id' => $parameter->id,
                        'sampling_time_id' => $samplingTimeId,
                        'regulation_standard_id' => $request->regulation_standard_id[$key],
                    ]);
                }
            }

            return redirect()->route('coa.parameter.index')->with('msg', 'Parameter (' . $request->name . ') added successfully');
        }

        $data = Parameter::all();
        $subjects = Subject::orderBy('name')->get();
        $samplingTime = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();

        return view('coa.parameter.add_parameter', compact('data', 'subjects', 'samplingTime', 'regulationStandards'));
    }

    // Edit Parameter
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
                // 'regulation_id' => 'required'
            ]);

            // Update data utama di tabel `parameters`
            $data->update([
                'name' => $request->name,
                'unit' => $request->unit,
                'method' => $request->method,
                // 'regulation_id' => $request->regulation_id
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
        // $regulation = Regulation::orderBy('title')->get();
        $samplingTime = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();

        // Ambil data yang sudah ada dari tabel `sampling_time_regulations`
        $existingSamplingTimes = SamplingTimeRegulation::where('parameter_id', $id)->get();

        return view('coa.parameter.edit', compact(
            'data', 'samplingTime', 'regulationStandards', 'existingSamplingTimes'
        ));
    }

    // Delete Parameter
    public function delete_parameter(Request $request){
        $data = Parameter::find($request->id);
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

    //data_parameter
    public function data_parameter(Request $request)
    {
        $data = Parameter::with([
            'subjects:id,name,subject_code',
            'samplingTimeRegulations.samplingTime:id,time',
            'samplingTimeRegulations.regulationStandards:id,title'
        ])->select('*')->orderBy("id")->get();

        return DataTables::of($data)
            ->addColumn('samplingTime', function ($row) {
                $samplingTimes = $row->samplingTimeRegulations->pluck('samplingTime.time')->toArray();
                return !empty($samplingTimes) ? implode(', ', $samplingTimes) : '-';
            })
            ->addColumn('regulationStandards', function ($row) {
                $regulationStandards = $row->samplingTimeRegulations->pluck('regulationStandards.title')->toArray();
                return !empty($regulationStandards) ? implode(', ', $regulationStandards) : '-';
            })
            ->rawColumns(['samplingTime', 'regulationStandards'])
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

    public function delete_sampling_time(Request $request){
        $data = SamplingTime::find($request->id);
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

    //data_sampling_time
    public function data_sampling_time(Request $request)
    {
        $data = SamplingTime::select('*')
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
        $subjects = Subject::orderBy('name')->get();
        return view('coa.regulation_standard.index', compact('data', 'subjects'));
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

    public function delete_regulation_standard(Request $request){
        $data = RegulationStandard::find($request->id);
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
    public function data_regulation_standard(Request $request)
    {
        $data = RegulationStandard::select('*')
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

    public function datatables()
    {
        $data = Sampling::select('*');
        return DataTables::of($data)->make(true);
    }
}
