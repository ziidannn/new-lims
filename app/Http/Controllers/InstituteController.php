<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        $description = Subject::all();
        return view('institute.index', compact('data', 'description'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'no_coa' => ['required'],
                'customer_id' => ['required'],
                'subject_id' => ['required', 'array'], // Pastikan subject_id adalah array
                'sample_receive_date' => ['required'],
                'sample_analysis_date' => ['required'],
                'report_date' => ['required']
            ]);

            // Buat entri baru di tabel `institutes`
            $Institute = Institute::create([
                'no_coa' => $request->no_coa,
                'customer_id' => $request->customer_id,
                'sample_receive_date' => $request->sample_receive_date,
                'sample_analysis_date' => $request->sample_analysis_date,
                'report_date' => $request->report_date,
            ]);

            // Simpan subject_id ke tabel institute_subjects dan regulation_id ke institute_regulations
            if ($request->has('subject_id')) {
                foreach ($request->subject_id as $subjectId) {
                    // Simpan subject_id ke tabel institute_subjects
                    $instituteSubject = InstituteSubject::create([
                        'institute_id' => $Institute->id,
                        'subject_id' => $subjectId,
                    ]);

                    // Ambil regulation_id berdasarkan subject_id
                    $regulationIds = Regulation::where('subject_id', $subjectId)->pluck('id')->toArray();

                    // Simpan regulation_id ke tabel institute_regulations
                    foreach ($regulationIds as $regulationId) {
                        InstituteRegulation::create([
                            'institute_subject_id' => $instituteSubject->id,
                            'regulation_id' => $regulationId,
                        ]);
                    }
                }
            }

            return redirect()->route('institute.index')->with('msg', 'Data berhasil ditambahkan');
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
        $data = Institute::with('customer', 'Subjects')->findOrFail($id);
        $description = Subject::orderBy('name')->get();
        $customer = Customer::all();

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'no_coa' => ['required'],
                'customer_id' => ['required'],
                'subject_id' => ['required', 'array'], // Pastikan ini array
                'sample_receive_date' => ['required'],
                'sample_analysis_date' => ['required'],
                'report_date' => ['required']
            ]);

            // Update data di tabel institute
            $data->update([
                'no_coa' => $request->no_coa,
                'customer_id' => $request->customer_id,
                'sample_receive_date' => $request->sample_receive_date,
                'sample_analysis_date' => $request->sample_analysis_date,
                'report_date' => $request->report_date,
            ]);

            // **1. Hapus data lama di institute_regulations dulu**
            InstituteRegulation::whereIn(
                'institute_subject_id',
                InstituteSubject::where('institute_id', $data->id)->pluck('id')
            )->delete();

            // **2. Setelah institute_regulations dihapus, hapus institute_subjects**
            InstituteSubject::where('institute_id', $data->id)->delete();

            if ($request->has('subject_id')) {
                foreach ($request->subject_id as $subjectId) {
                    // Simpan subject_id ke tabel institute_subjects
                    $instituteSubject = InstituteSubject::create([
                        'institute_id' => $data->id,
                        'subject_id' => $subjectId,
                    ]);

                    // Ambil regulation_id berdasarkan subject_id
                    $regulationIds = Regulation::where('subject_id', $subjectId)->pluck('id')->toArray();

                    // Simpan regulation_id ke tabel institute_regulations
                    foreach ($regulationIds as $regulationId) {
                        InstituteRegulation::create([
                            'institute_subject_id' => $instituteSubject->id,
                            'regulation_id' => $regulationId,
                        ]);
                    }
                }
            }

            return redirect()->route('institute.index')->with('msg', 'Data berhasil diubah');
        }

        // Ambil regulasi berdasarkan subject yang sudah ada di institute
        $regulation = Regulation::whereIn('subject_id', $data->Subjects->pluck('id')->toArray())->get();

        return view('institute.edit', compact(
            'data', 'description', 'regulation', 'customer'));
    }


    public function delete(Request $request)
    {
        $data = Institute::findOrFail($request->id);

        if ($data) {
            // **1. Hapus institute_regulations terlebih dahulu**
            InstituteRegulation::whereIn(
                'institute_subject_id',
                InstituteSubject::where('institute_id', $data->id)->pluck('id')
            )->delete();

            // **2. Hapus institute_subjects setelah institute_regulations terhapus**
            InstituteSubject::where('institute_id', $data->id)->delete();

            // **3. Hapus data utama Institute**
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
    $data = Institute::with(['Subjects' => function ($query) {
            $query->select('subjects.id', 'subjects.name');
        }, 'customer']) // Tambahkan relasi customer
        ->select('*')
        ->orderBy("id")
        ->get();

    return DataTables::of($data)
        ->filter(function ($instance) use ($request) {
            if (!empty($request->get('select_description'))) {
                $instance->whereHas('Subjects', function ($q) use ($request) {
                    $q->where('subjects.id', $request->get('select_description'));
                });
            }
            if (!empty($request->get('search'))) {
                $search = $request->get('search');
                $instance->where(function ($w) use ($search) {
                    $w->orWhere('no_sample', 'LIKE', "%$search%")
                        ->orWhere('date', 'LIKE', "%$search%")
                        ->orWhereHas('Subjects', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('customer', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%$search%"); // Filter berdasarkan nama customer
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
