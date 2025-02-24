<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePdf($customerId)
    {
        $resume = Resume::where('id', $customerId)->get();
        $data = [
            'title' => 'Resume Limses',
            'date' => date('m/d/y'),
            'resume' => $resume // Ensure this key matches the variable used in the view
        ];
        $pdf = Pdf::loadView('pdf.resume_generate_pdf', $data);
        return $pdf->download('resume_limses.pdf');
    }

    public function previewPdf($customerId)
    {
        $resume = Resume::where('id', $customerId)->get();
        $data = [
            'title' => 'Resume Limses',
            'date' => date('m/d/y'),
            'resume' => $resume // Ensure this key matches the variable used in the view
        ];
        $pdf = Pdf::loadView('pdf.resume_generate_pdf', $data);
        return $pdf->stream('resume_limses.pdf'); // Display PDF in the browser
    }
}


