<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use App\Models\Location;
use App\Models\Institute;
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
                'customer' => ['required'],
                'address' => ['required'],
                'contact_name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'subject_id' => ['required', 'array'], // Pastikan ini array
                'sample_receive_date' => ['required'],
                'sample_analysis_date' => ['required'],
                'report_date' => ['required']
            ]);

            // Buat Institute baru
            $Institute = Institute::create([
                'customer' => $request->customer,
                'address' => $request->address,
                'contact_name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'sample_receive_date' => $request->sample_receive_date,
                'sample_analysis_date' => $request->sample_analysis_date,
                'report_date' => $request->report_date,
            ]);

            // Simpan subject_id ke tabel pivot
            if ($request->has('subject_id')) {
                foreach ($request->subject_id as $subjectId) {
                    // Simpan subject_id ke tabel pivot
                    $Institute->Subjects()->attach($subjectId);

                    // Ambil regulation_id berdasarkan subject_id
                    $regulationIds = Regulation::where('subject_id', $subjectId)->pluck('id')->toArray();

                    // Simpan regulation_id ke tabel pivot institute_subjects
                    foreach ($regulationIds as $regulationId) {
                        InstituteSubject::create([
                            'institute_id' => $Institute->id,
                            'subject_id' => $subjectId,
                            'regulation_id' => $regulationId,
                        ]);
                    }
                }
            }

            return redirect()->route('institute.index')->with('msg', 'Data berhasil ditambahkan');
        }

        $data = Institute::all();
        $description = Subject::orderBy('name')->get();
        $regulation = Regulation::orderBy('title')->get();
        return view('institute.create', compact('data', 'description', 'regulation'));
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
        $data = Institute::find($id);
        $description = Subject::orderBy('name')->get();
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'customer' => ['required'],
                'address' => ['required'],
                'contact_name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'subject_id' => ['required', 'array'], // Pastikan ini array
                'sample_receive_date' => ['required'],
                'sample_analysis_date' => ['required'],
                'report_date' => ['required']
            ]);

            // Update Institute
            $data->update([
                'customer' => $request->customer,
                'address' => $request->address,
                'contact_name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'sample_receive_date' => $request->sample_receive_date,
                'sample_analysis_date' => $request->sample_analysis_date,
                'report_date' => $request->report_date,
            ]);

            // Update subject_id ke tabel pivot
            if ($request->has('subject_id')) {
                $data->Subjects()->sync($request->subject_id);
                // Update regulation_id based on subject_id
                $regulationIds = Regulation::whereIn('subject_id', $request->subject_id)->pluck('id')->toArray();
                $data->Regulations()->sync($regulationIds);
            }

            return redirect()->route('institute.index')->with('msg', 'Data berhasil diubah');
        }

        $regulation = Regulation::whereIn('subject_id', $data->Subjects->pluck('id')->toArray())->get();

        return view('institute.edit', compact('data', 'description', 'regulation'));
    }

    public function delete(Request $request)
    {
        $data = Institute::find($request->id);

        if ($data) {
            // Hapus entri terkait di in$instituteSubject
            $instituteSubjects = InstituteSubject::where('institute_id', $data->id)->get();

            foreach ($instituteSubjects as $instituteSubject) {
                // Hapus Observasi yang terkait dengan in$instituteSubject
                Sampling::where('institute_subject_id', $instituteSubject->id)->delete();
            }

            // Hapus in$instituteSubject
            InstituteSubject::where('institute_id', $data->id)->delete();

            // Hapus Observasi yang terkait dengan AuditPlan
            Sampling::where('institute_id', $data->id)->delete();

            // Hapus regulations yang terkait dengan Institute
            $data->Regulations()->detach();

            // Hapus AuditPlan itu sendiri
            $data->delete();

        // Email Pembatalan Auditing

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus! Data tidak ditemukan.'
            ]);
        }
    }

    //Data institute
    public function data(Request $request)
    {
        $data = Institute::with(['Subjects' => function ($query) {
                $query->select('subjects.id', 'subjects.name');
            }])
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
