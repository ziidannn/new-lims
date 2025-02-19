<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume; 
use App\Models\Sampling;
use App\Models\SampleDescription;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        $data = Sampling::all();
        $description = SampleDescription::all();
        return view('resume.index', compact('data', 'description'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'customer' => ['required'],
                'contact_name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'sample_description_id' => ['required'],
                'sample_taken_by' => ['required'],
                'sample_receive_date' => ['required'],
                'sample_analysis_date' => ['required'],
                'report_date' => ['required']
            ]);

            $data = Resume::create([
                'customer' => $request->customer,
                'contact_name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'sample_description_id' => $request->sample_description_id,
                'sample_taken_by' => $request->sample_taken_by,
                'sample_receive_date' => $request->sample_receive_date,
                'sample_analysis_date' => $request->sample_analysis_date,
                'report_date' => $request->report_date,
            ]);

            if ($data) {
                return redirect()->route('resume.index')->with('msg', 'Data customer (' . $request->Resume . ') added successfully');
            }
        }
        $data = Resume::all();
        $description = SampleDescription::orderBy('name')->get();
        return view('resume.create', compact('data', 'description'));
    }

    public function delete(Request $request)
    {
        $id = $request->input('id'); // Get the ID to delete
        $resume = Resume::find($id);

        if ($resume) {
            $resume->delete();
            return response()->json(['message' => 'Resume deleted'], 200);
        } else {
            return response()->json(['message' => 'Resume not found'], 404);
        }
    }
}