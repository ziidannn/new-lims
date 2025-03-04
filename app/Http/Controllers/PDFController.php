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

class PDFController extends Controller
{
    // Resume COA PDF
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

    // Ambient Air PDF
    public function ambientAirPdf($id)
    {
        $institute = Institute::with('subjects')->find($id);
        if (!$institute) {
            return redirect()->back()->with('error', 'Institute not found.');
        }
    
        // Ambil subject_id dari tabel institute_subjects yang sesuai dengan institute_id
        $instituteSamples = InstituteSubject::where('institute_id', $id)->get();
        $subjectIds = $instituteSamples->pluck('subject_id'); // Mengambil subject_id
    
        // Ambil data subjects berdasarkan subject_id yang telah diambil
        $subjects = Subject::whereIn('id', $subjectIds)->get();
    
        // Ambil data regulations terkait dengan subjects yang terpilih
        $regulations = Regulation::whereIn('subject_id', $subjectIds)->get();
        $regulationIds = $regulations->pluck('id');
    
        // Ambil data parameters terkait dengan regulations
        $parameters = Parameter::whereIn('regulation_id', $regulationIds)->orderBy('name')->get();
        $parameterIds = $parameters->pluck('id');
    
        // Data tambahan untuk tampilan
        $regulationStandards = RegulationStandard::orderBy('title')->get();
        $samplingTimes = SamplingTime::orderBy('time')->get();
    
        // Ambil data sampling berdasarkan institute_subjects
        $instituteSamplesIds = $instituteSamples->pluck('id');
        $samplings = Sampling::whereIn('institute_subject_id', $instituteSamplesIds)->get();
        $samplingIds = $samplings->pluck('subject_id');
    
        $samps = Sampling::whereIn('id', $samplingIds)
            ->with('regulations.parameters', 'sampling_times.regulation_standards')
            ->get();
    
        // Ambil data sampling time regulations
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parameterIds)
            ->with(['samplingTime', 'regulationStandards'])
            ->get();
    
        // Ambil hasil terkait dengan sampling yang sudah ada
        $results = Result::whereIn('sampling_id', $samplingIds)->get();
        

        $pdf = Pdf::loadView('pdf.ambient_air', compact(
            'regulations', 'subjects', 'parameters', 'institute',
            'samplingTimes', 'regulationStandards', 'samplingTimeRegulations',
            'samplings', 'samps', 'results'
        ));
        return $pdf->stream('Ambient_Air_Report' . $id . '.pdf');
    }
}

