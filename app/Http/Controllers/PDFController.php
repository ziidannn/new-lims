<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePdf($customerId)
    {
        $institute = Institute::find($customerId);
        $data = [
            'title' => 'Resume Limses',
            'title' => 'Resume LIMS',
            'institute' => $institute
        ];
        $pdf = Pdf::loadView('pdf.resume_generate_pdf', $data);
            return $pdf->download('resume_limses.pdf');
        }

    public function previewPdf($id)
    {
        $institute = Institute::with('Subjects')->find($id);
        if (!$institute) {
            return redirect()->back()->with('error', 'Institute not found.');
        }
        $data = [
            'customer' => $institute->customer,
            'address' => $institute->address,
            'contact_name' => $institute->contact_name,
            'email' => $institute->email,
            'phone' => $institute->phone,
            'sample_taken_by' => $institute->sample_taken_by,
            'sample_receive_date' => $institute->sample_receive_date,
            'sample_analysis_date' => $institute->sample_analysis_date,
            'report_date' => $institute->report_date,
            'subjects' => $institute->subjects
        ];
        $pdf = Pdf::loadView('pdf.resume_coa', $data);
        return $pdf->stream('Resume Institute ' . $institute->customer . ".pdf");
    }
}