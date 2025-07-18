<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FieldCondition;
use App\Models\Institute;
use App\Models\InstituteRegulation;
use App\Models\InstituteSubject;
use App\Models\Regulation;
use App\Models\Sampling;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InstituteController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $subjects = Subject::all();
        return view('institute.index', compact('data', 'subjects'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'no_coa' => ['required'],
                'customer_id' => ['required'],
                'subject_id' => ['required', 'array'],
                'regulation_id' => ['required', 'array'],
                'sample_receive_date' => ['required'],
                'sample_analysis_date' => ['required'],
                'report_date' => ['required']
            ]);

            $Institute = Institute::create([
                'no_coa' => $request->no_coa,
                'customer_id' => $request->customer_id,
                'sample_receive_date' => $request->sample_receive_date,
                'sample_analysis_date' => $request->sample_analysis_date,
                'report_date' => $request->report_date,
            ]);

            // Setiap subject_id boleh masuk meskipun duplikat
            foreach ($request->subject_id as $key => $subjectId) {
                $instituteSubject = InstituteSubject::create([
                    'institute_id' => $Institute->id,
                    'subject_id' => $subjectId,
                ]);

                if (!empty($request->regulation_id[$key])) {
                    $regulationId = $request->regulation_id[$key];
                    $isValidRegulation = Regulation::where('id', $regulationId)
                        ->where('subject_id', $subjectId)
                        ->exists();

                    if ($isValidRegulation) {
                        InstituteRegulation::create([
                            'institute_subject_id' => $instituteSubject->id,
                            'regulation_id' => $regulationId,
                        ]);
                    }
                }
            }

            return redirect()->route('institute.index')->with('msg', 'Data ' . $request->no_coa . ' added successfully');
        }

        $data = Institute::all();
        $customer = Customer::orderBy('name')->get();
        $description = Subject::orderBy('name')->get();
        $regulation = Regulation::orderBy('title')->get();

        return view('institute.create', compact('data', 'description', 'regulation', 'customer'));
    }

    public function getRegulationBySubjectIds(Request $request)
    {
        $subjectIds = $request->input('ids'); // Ambil subject_id atau array kosong

        $regulations = Regulation::whereIn('subject_id', $subjectIds)->get();
        return response()->json($regulations);
    }

    //Edit institute
    public function edit(Request $request, $id)
    {
        $data = Institute::with('customer', 'Subjects.instituteRegulations.regulation')->findOrFail($id);
        $description = Subject::orderBy('subject_code')->get();
        $customer = Customer::all();

        if ($request->has('subject_id')) {
            // Ambil data subject lama dari DB
            $existingSubjects = InstituteSubject::where('institute_id', $data->id)->get()->keyBy('subject_id');

            foreach ($request->subject_id as $index => $subjectId) {
                if ($existingSubjects->has($subjectId)) {
                    $instituteSubject = $existingSubjects[$subjectId];
                    // Hapus regulasi lama
                    InstituteRegulation::where('institute_subject_id', $instituteSubject->id)->delete();
                } else {
                    $instituteSubject = InstituteSubject::create([
                        'institute_id' => $data->id,
                        'subject_id' => $subjectId,
                    ]);
                }

                // Ambil regulation_id berdasarkan index
                $regulationIds = $request->input('regulations')[$index] ?? [];
                if (!is_array($regulationIds)) {
                    $regulationIds = [$regulationIds];
                }
                foreach ($regulationIds as $regulationId) {
                    if (!empty($regulationId)) {
                        InstituteRegulation::create([
                            'institute_subject_id' => $instituteSubject->id,
                            'regulation_id' => $regulationId,
                        ]);
                    }
                }
            }

            return redirect()->route('institute.index')->with('msg', 'Data ' . $request->no_coa . ' updated successfully');
        }

        // Ambil regulasi berdasarkan subject yang sudah ada di institute
        $regulation = Regulation::whereIn('subject_id', $data->Subjects->pluck('id')->toArray())->get();

        return view('institute.edit', compact(
            'data', 'description', 'regulation', 'customer'
        ));
    }

    public function delete(Request $request)
    {
        $data = Institute::findOrFail($request->id);

        if ($data) {
            // Hapus data terkait pada setiap institute_subjects
            foreach ($data->institute_subjects as $subject) {
                // Hapus institute_regulations terkait
                $subject->instituteRegulations()->delete();
                // Hapus sampling terkait
                $subject->samplings()->delete();
            }
            // Hapus institute_subjects setelah data terkait terhapus
            $data->institute_subjects()->delete();
            // Hapus institute
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete! Data not found'
        ]);
    }

    //Data institute
    public function data(Request $request)
    {
        // Mulai dengan query builder, jangan gunakan ->get()
        $data = Institute::with([
            'Subjects' => function ($query) {
                $query->select('subjects.id', 'subjects.name');
            },
            'customer'
        ])
        ->select('*')
        ->orderBy("id");

        // Menambahkan filter pencarian (search)
        return DataTables::of($data)
            ->filter(function ($query) use ($request) {
                // Filter berdasarkan 'select_subject'
                if (!empty($request->get('select_subject'))) {
                    $query->whereHas('Subjects', function ($q) use ($request) {
                        $q->where('subjects.id', $request->get('select_subject'));
                    });
                }

                // Filter pencarian berdasarkan no_coa dan nama customer
                if (!empty($request->get('search')['value'])) {
                    $search = $request->get('search')['value'];
                    $query->where(function ($q) use ($search) {
                        // Filter no_coa
                        $q->where('no_coa', 'LIKE', "%$search%")
                        // Filter nama customer
                        ->orWhereHas('customer', function ($qc) use ($search) {
                            $qc->where('name', 'LIKE', "%$search%");
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
