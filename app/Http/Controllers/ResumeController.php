<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume; // Assuming you have a Resume model

class ResumeController extends Controller
{
    public function index()
    {
        return view('resume.index'); // Return the view for the resume list
    }

    public function data(Request $request)
    {
        // Handle DataTables or similar AJAX requests for data
        $resumes = Resume::all(); // Or apply filters, sorting, pagination based on request
        return response()->json($resumes); // Return data as JSON
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

    public function create()
    {
        return view('resume.create'); // Return the form for creating a new resume
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'customer' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'sample_description_id' => 'required|exists:sample_descriptions,id', // Assuming you have a sample_descriptions table
            'sample_taken_by' => 'required|string|max:255',
            'sample_receive_date' => 'required|date',
            'sample_analysis_date' => 'required|date',
            'report_date' => 'required|date',
            // Add other fields as needed
        ]);

        // Create the Resume record
        $resume = Resume::create($validatedData);

        return redirect()->route('resume.index')->with('success', 'Resume created successfully!');
    }
}