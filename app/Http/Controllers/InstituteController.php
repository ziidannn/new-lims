<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use App\Models\Location;
use App\Models\Institute;
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
                'sample_taken_by' => ['required'],
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
                'sample_taken_by' => $request->sample_taken_by,
                'sample_receive_date' => $request->sample_receive_date,
                'sample_analysis_date' => $request->sample_analysis_date,
                'report_date' => $request->report_date,
            ]);

            // Simpan subject_id ke tabel pivot
            if ($request->has('subject_id')) {
                $Institute->Subjects()->attach($request->subject_id);
            }

            return redirect()->route('institute.index')->with('msg', 'Data berhasil ditambahkan');
        }

        $data = Institute::all();
        $description = Subject::orderBy('name')->get();
        return view('institute.create', compact('data', 'description'));
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
