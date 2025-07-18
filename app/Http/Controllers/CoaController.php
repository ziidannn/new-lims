<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Regulation;
use App\Models\RegulationStandard;
use App\Models\RegulationStandardCategory;
use App\Models\Sampling;
use App\Models\Subject;
use App\Models\SamplingTime;
use App\Models\SamplingTimeRegulation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{
    // Subject
    public function subject(){
        $subjects = Subject::all();
        return view('coa.subject.index', compact('subjects'));
    }

    // Create_Subject
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
    public function data_subject(Request $request){
        // 1. Mulai dengan Query Builder, bukan ->all()
        $query = Subject::query();

        // 2. Terapkan filter dari dropdown "Select Subjects"
        if ($request->filled('select_description')) {
            $query->where('id', $request->input('select_description'));
        }

        // 3. Terapkan filter dari kotak pencarian utama DataTables
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($w) use ($search) {
                $w->orWhere('subject_code', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        // 4. Kirim query yang sudah difilter ke DataTables
        return DataTables::of($query)
        ->addIndexColumn() // <-- Cukup tambahkan baris ini
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
    public function data_regulation(Request $request){
        // 1. Mulai dengan Query Builder, JANGAN gunakan ->get() dulu
        $query = Regulation::with(['subjects' => function ($query) {
            $query->select('subjects.id', 'subjects.name'); // Lebih spesifik untuk menghindari ambiguitas
        }]);

        // 2. Terapkan filter dari dropdown "Select Subjects"
        // Menggunakan whereHas untuk memfilter berdasarkan relasi
        if ($request->filled('select_subjects')) {
            $query->whereHas('subjects', function ($q) use ($request) {
                $q->where('subjects.id', $request->input('select_subjects'));
            });
        }

        // 3. Terapkan filter dari kotak pencarian utama DataTables
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($w) use ($search) {
                $w->orWhere('regulation_code', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->orWhereHas('subjects', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        // 4. Kirim query yang sudah difilter ke DataTables dan tambahkan kolom nomor
        return DataTables::of($query)
            ->addIndexColumn() // Menambahkan kolom nomor urut yang konsisten
            ->make(true);
    }

    //----------------------------------------------- P A R A M E T E R ----------------------------------------------------//
    // Parameter
    public function parameter(Request $request)
    {
        $data = Parameter::all();
        $subjects = Subject::orderBy('name')->get();
        $samplingTime = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();

        return view('coa.parameter.index', compact(
            'data','subjects', 'samplingTime', 'regulationStandards'
        ));
    }
    // Add Parameter
    public function add_parameter(Request $request){
        if ($request->isMethod('POST')) {
            // 1. Tentukan aturan validasi dasar
            $rules = [
                'subject_id' => ['required'],
                'name' => ['required', 'string', 'max:175'],
                'unit' => ['required', 'string'],
                'method' => ['required', 'string'],
            ];

            // 2. Tambahkan aturan validasi kondisional
            $subject = Subject::find($request->subject_id);
            if ($subject && $subject->subject_code === '01') {
                $rules['sampling_time_id'] = ['required', 'array'];
                $rules['regulation_standard_id'] = ['required', 'array'];
            }

            // 3. Jalankan validasi
            $this->validate($request, $rules);

            // 4. Validasi kustom untuk regulation class (jika diperlukan)
            $regClasses = $request->input('regulation_class');
            if ($subject && in_array($subject->subject_code, ['08', '10'])) {
                // Cek jika semua input regulation_class kosong
                if (!collect($regClasses)->filter()->count()) {
                    return redirect()->back()
                        ->withErrors(['regulation_class' => 'Untuk subject ini, minimal satu isian Regulation Standard Class diperlukan.'])
                        ->withInput();
                }
            }

            // ... sisa logika Anda untuk menyimpan data sudah benar ...

            $parameter = Parameter::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'method' => $request->method,
                'subject_id' => $request->subject_id,
            ]);

            if ($subject && $subject->subject_code === '01') {
                foreach ($request->sampling_time_id as $key => $samplingTimeId) {
                    if(!empty($samplingTimeId) && !empty($request->regulation_standard_id[$key])) {
                        SamplingTimeRegulation::create([
                            'parameter_id' => $parameter->id,
                            'sampling_time_id' => $samplingTimeId,
                            'regulation_standard_id' => $request->regulation_standard_id[$key],
                        ]);
                    }
                }
            }

            if ($request->has('regulation_class')) {
                foreach ($request->regulation_class as $code => $value) {
                    if (!empty($value)) {
                        RegulationStandardCategory::create([
                            'parameter_id' => $parameter->id,
                            'code' => $code,
                            'value' => $value
                        ]);
                    }
                }
            }

            return redirect()->route('coa.parameter.index')->with('msg', 'Parameter (' . $request->name . ') added successfully');
        }

        $data = Parameter::all();
        $subjects = Subject::orderBy('subject_code')->get();
        $samplingTime = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();

        return view('coa.parameter.add_parameter', compact('data', 'subjects', 'samplingTime', 'regulationStandards'));
    }

    // Edit Parameter
    public function edit_parameter(Request $request, $id){
        $data = Parameter::with('subjects', 'regulationStandardCategories')->findOrFail($id);

        if ($request->isMethod('POST')) {
            // === VALIDASI KONDISIONAL ===
            $rules = [
                'name' => ['required', 'string', 'max:175'],
                'unit' => ['required', 'string'],
                'method' => ['required', 'string'],
                'subject_id' => ['required'],
            ];

            // Validasi kondisional berdasarkan Subject yang DIPILIH di form
            $subject = Subject::find($request->subject_id);
            if ($subject && $subject->subject_code === '01') {
                $rules['sampling_time_id'] = ['required', 'array', 'min:1'];
                $rules['regulation_standard_id'] = ['required', 'array', 'min:1'];
            }

            if ($subject && in_array($subject->subject_code, ['08', '10'])) {
                $regClasses = $request->input('regulation_class');
                if (!collect($regClasses)->filter()->count()) {
                    return redirect()->back()
                        ->withErrors(['regulation_class' => 'Untuk subject ini, minimal satu isian Regulation Standard Class diperlukan.'])
                        ->withInput();
                }
            }
            $this->validate($request, $rules);

            // === PROSES UPDATE ===
            $data->update($request->only(['name', 'unit', 'method', 'subject_id']));

            // 1. Update Sampling Time & Regulation Standard (jika subject '01')
            SamplingTimeRegulation::where('parameter_id', $id)->delete(); // Hapus yang lama dulu
            if ($subject && $subject->subject_code === '01') {
                if ($request->has('sampling_time_id')) {
                    foreach ($request->sampling_time_id as $key => $samplingTimeId) {
                        if (!empty($samplingTimeId) && !empty($request->regulation_standard_id[$key])) {
                            SamplingTimeRegulation::create([
                                'parameter_id' => $data->id,
                                'sampling_time_id' => $samplingTimeId,
                                'regulation_standard_id' => $request->regulation_standard_id[$key],
                            ]);
                        }
                    }
                }
            }

            // 2. Update Regulation Standard per Class
            RegulationStandardCategory::where('parameter_id', $id)->delete(); // Hapus yang lama dulu
            if ($request->has('regulation_class')) {
                foreach ($request->regulation_class as $code => $value) {
                    if (!empty($value)) {
                        RegulationStandardCategory::create([
                            'parameter_id' => $data->id,
                            'code' => $code,
                            'value' => $value
                        ]);
                    }
                }
            }

            return redirect()->route('coa.parameter.index')->with('msg', 'Parameter (' . $data->name . ') updated successfully.');
        }

        // === MENGIRIM DATA KE VIEW ===
        $subjects = Subject::orderBy('subject_code')->get();
        $samplingTime = SamplingTime::orderBy('time')->get();
        $regulationStandards = RegulationStandard::orderBy('title')->get();
        $existingSamplingTimes = SamplingTimeRegulation::where('parameter_id', $id)->get();

        // Ambil data Regulation Class yang sudah ada dan ubah menjadi array asosiatif
        $existingRegClasses = $data->regulationStandardCategories->pluck('value', 'code')->toArray();

        return view('coa.parameter.edit', compact(
            'data',
            'subjects',
            'samplingTime',
            'regulationStandards',
            'existingSamplingTimes',
            'existingRegClasses' // Kirim data ini ke view
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
    public function data_parameter(Request $request){
        // Mulai dengan query dasar
        $query = Parameter::with([
            'subjects:id,name,subject_code',
            'samplingTimeRegulations.samplingTime:id,time',
            'samplingTimeRegulations.regulationStandards:id,title'
        ]);

        // Tambahkan filter jika subject dipilih dari dropdown
        if ($request->filled('select_description')) {
            $query->where('subject_id', $request->select_description);
        }

        // Eksekusi query
        $data = $query->select('*')->orderBy("id")->get();

        return DataTables::of($data)
            ->addColumn('samplingTime', function ($row) {
                $samplingTimes = $row->samplingTimeRegulations->pluck('samplingTime.time')->filter()->unique()->toArray();
                return !empty($samplingTimes) ? implode(', ', $samplingTimes) : '-';
            })
            ->addColumn('regulationStandards', function ($row) {
                $regulationStandards = $row->samplingTimeRegulations->pluck('regulationStandards.title')->filter()->unique()->toArray();
                return !empty($regulationStandards) ? implode(', ', $regulationStandards) : '-';
            })
            ->rawColumns(['samplingTime', 'regulationStandards'])
            ->make(true);
    }

    //----------------------------------- S A M P L I N G  T I M E ------------------------------------------//

    //sampling_time
    public function sampling_time(Request $request){
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
