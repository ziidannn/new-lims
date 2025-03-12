<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Subject;
use App\Models\Regulation;
use App\Models\Parameter;
use App\Models\SamplingTime;
use App\Models\SamplingTimeRegulation;
use App\Models\Sampling;
use App\Models\RegulationStandard;
use App\Models\InstituteSubject;
use App\Models\Result;
use App\Models\InstituteRegulation;
use App\Models\Customer;

class PDFController extends Controller
{
    // Resume COA PDF
    // public function previewPdf($id)
    // {
    //     $institute = Institute::with('Subjects')->find($id);
    //     if (!$institute) {
    //         return redirect()->back()->with('error', 'Institute not found.');
    //     }
    //     $data = [
    //         'customer' => $institute->customer,
    //         'address' => $institute->address,
    //         'contact_name' => $institute->contact_name,
    //         'email' => $institute->email,
    //         'phone' => $institute->phone,
    //         'sample_taken_by' => $institute->sample_taken_by,
    //         'sample_receive_date' => $institute->sample_receive_date,
    //         'sample_analysis_date' => $institute->sample_analysis_date,
    //         'report_date' => $institute->report_date,
    //         'subjects' => $institute->subjects
    //     ];
    //     $pdf = Pdf::loadView('pdf.resume_coa', $data);
    //     return $pdf->stream('Resume Institute ' . $institute->customer . ".pdf");
    // }


    public function ambientAirPdf($id)
    {
        // Ambil data institute beserta relasi subjects
        $institute = Institute::with('subjects')->find($id);
        if (!$institute) {
            return redirect()->back()->with('error', 'Institute not found.');
        }
        // Ambil data InstituteRegulation dengan filter berdasarkan institute_id melalui relasi instituteSubject
        $data = InstituteRegulation::whereHas('instituteSubject', function ($query) use ($id) {
                $query->where('institute_id', $id);
            })
            ->with(['instituteSubject.subject', 'regulation']) // Memuat relasi yang dibutuhkan
            ->get()
            ->unique(function ($item) {
                return $item->institute_subject_id . '-' . $item->regulation_id;
            }) // Menghapus data yang duplikat berdasarkan kombinasi subject & regulation
            ->values(); // Reset index array
        // Ambil data InstituteSubject berdasarkan institute_id
        $instituteSubjects = InstituteSubject::where('institute_id', $id)
        ->with('subject') // Load relasi subject
        ->get();
        // Ambil data Sampling berdasarkan institute_id                                                                                                                                                                                                                                                     
        $samplings = Sampling::where('institute_id', $id)
        ->with(['instituteSubject.subject']) // Load relasi jika diperlukan
        ->get();
        // Ambil data Customer berdasarkan institute_id
        $customer = Customer::find($id);

        // Generate PDF menggunakan view 'pdf.ambient_air'
        $pdf = Pdf::loadView('pdf.ambient_air', compact('data', 'institute', 'samplings', 'instituteSubjects', 'customer'));
        return $pdf->stream('Ambient_Air_Report' . $id . '.pdf');
    }

}

