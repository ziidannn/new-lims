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
use App\Models\FieldCondition; // Import FieldCondition model
use App\Models\InstituteRegulation;
use App\Models\Customer;
use Dompdf\Options;
use Dompdf\FontMetrics; // Pastikan ini diimpor


class PDFController extends Controller
{

    // public function ambientAirPdf($id)
    // {
    //     // Ambil data Sampling berdasarkan institute_id  
    //     $samplings = Sampling::where('institute_id', $id)
    //         ->with(['instituteSubject.subject'])
    //         ->get();
    
    //     $customer = Institute::find($id)->customer; // Retrieve customer from the institute relationship
    //     $institute = Institute::with('subjects')->find($id);
    
    //     if (!$institute) {
    //         return redirect()->back()->with('error', 'Institute not found.');
    //     }
    
    //     // Hanya mengambil InstituteSubject dengan subject "Ambient Air"
    //     $instituteSubjects = InstituteSubject::where('institute_id', $id)
    //         ->whereHas('subject', function ($query) {
    //             $query->where('name', 'Ambient Air'); // Sesuaikan dengan nama subject di database
    //         })
    //         ->with('subject')
    //         ->get();
    
    //     // Ambil sampling pertama (jika ada)
    //     $sampling = Sampling::where('institute_id', $id)
    //         ->with(['instituteSubject.subject'])
    //         ->first();
    
    //     // Ambil Regulation ID hanya untuk "Ambient Air"
    //     $regulationsIds = InstituteRegulation::whereHas('instituteSubject', function ($query) use ($id) {
    //         $query->where('institute_id', $id)
    //             ->whereHas('subject', function ($q) {
    //                 $q->where('name', 'Ambient Air');
    //             });
    //     })->pluck('regulation_id')->unique();
    
    //     // Ambil parameter berdasarkan regulation yang sudah difilter
    //     $parameters = Parameter::whereIn('regulation_id', $regulationsIds)->get();
    
    //     // Ambil SamplingTimeRegulation yang sesuai dengan parameter "Ambient Air"
    //     $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', 
    //     Parameter::whereIn('regulation_id', $regulationsIds)->pluck('id')
    //     )->with(['samplingTime', 'regulationStandards', 'parameter'])
    //     ->get()
    //     ->sortBy('parameter.name'); // Mengurutkan berdasarkan nama parameter
    
    //     // Ambil hasil testing yang sesuai
    //     $results = Result::whereIn('parameter_id', $parameters->pluck('id'))
    //         ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
    //         ->get()
    //         ->groupBy(function ($item) {
    //             return "{$item->parameter_id}-{$item->sampling_time_id}";
    //         });
    
    //     // Ambil FieldCondition jika ada
    //     $firstResult = $results->flatten()->first();
    //     $fieldCondition = $firstResult ? FieldCondition::where('result_id', $firstResult->id)->first() : null;
    
    //     $instituteSubject = InstituteSubject::findOrFail($id);
    //     $institute = Institute::findOrFail($instituteSubject->institute_id);
    //     $regulationsIds = InstituteRegulation::where('institute_subject_id', $instituteSubject->id)
    //         ->pluck('regulation_id');
    //     $regulations = Regulation::whereIn('id', $regulationsIds)->get();
    //     $results = Result::
    //     whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id'))
    //     ->whereIn('regulation_standard_id', $samplingTimeRegulations->pluck('regulationStandards.id'))
    //     ->get()
    //     ->groupBy(function ($item) {
    //         return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->regulation_standard_id}";
    //     });

    //     // Load PDF dengan data yang sudah difilter
    //     $pdf = Pdf::loadView('pdf.ambient_air', compact(
    //         'institute', 'parameters', 'samplingTimeRegulations', 'results',
    //         'instituteSubjects', 'sampling', 'fieldCondition', 'samplings', 'customer', 'regulations'
    //     ));
    
    //     $pdf->set_option("isPhpEnabled", true); // AKTIFKAN PHP DI BLADE
    
    //     return $pdf->stream('Ambient_Air_Report' . $id . '.pdf');
    // }

    public function ambientAirPdf($id)
    {
        // Mengambil data institute beserta relasi subjects dan customer
        $institute = Institute::with(['subjects', 'customer'])->findOrFail($id);
        
        // Mengambil semua InstituteSubject yang memiliki subject bernama 'Ambient Air'
        $instituteSubjects = InstituteSubject::where('institute_id', $id)
            ->whereHas('subject', fn($q) => $q->where('name', 'Ambient Air'))
            ->with('subject')
            ->get();

        // Mengambil semua data sampling yang terkait dengan institute_id tertentu
        $samplings = Sampling::where('institute_id', $id)->with('instituteSubject.subject')->get();
        $sampling = $samplings->first(); // Mengambil data sampling pertama jika ada

        // Mengambil ID regulation yang terkait dengan InstituteSubject
        $regulationsIds = InstituteRegulation::whereIn('institute_subject_id', $instituteSubjects->pluck('id'))
            ->pluck('regulation_id')
            ->unique();

        // Mengambil parameter yang terkait langsung dengan daftar subject_id
        $parameters = Parameter::whereIn('subject_id', $instituteSubjects->pluck('subject_id'))->get();
        
        // Mengambil data SamplingTimeRegulation yang berkaitan dengan parameter yang telah difilter
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parameters->pluck('id'))
            ->with(['samplingTime', 'regulationStandards', 'parameter'])
            ->get()
            ->sortBy('parameter.name'); // Mengurutkan berdasarkan nama parameter

        // Mengambil data hasil (Result) berdasarkan parameter_id dan sampling_time_id serta sampling_id
        $results = Result::whereIn('parameter_id', $parameters->pluck('id'))
            ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
            ->whereIn('sampling_id', $samplings->pluck('id'))
            ->get()
            ->groupBy(fn($item) => "{$item->parameter_id}-{$item->sampling_time_id}-{$item->sampling_id}");

        // Mengambil kondisi lapangan berdasarkan institute_id dan institute_subject_id
        $fieldCondition = FieldCondition::where('institute_id', $id)
            ->whereIn('institute_subject_id', $instituteSubjects->pluck('id'))
            ->first();

        // Mengambil data regulasi berdasarkan regulation_id yang telah difilter
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();

        $pdf = Pdf::loadView('pdf.ambient_air', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'instituteSubjects', 'sampling', 'fieldCondition', 'samplings', 'regulations'
        ));

        // Mengaktifkan opsi PHP di dalam tampilan PDF
        $pdf->set_option("isPhpEnabled", true);
        return $pdf->stream("Ambient_Air_Report{$id}.pdf");
    }


    

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

    // public function ambientAirPdf($id)
    // {
    //     // Ambil data Customer berdasarkan institute_id
    //     $customer = Customer::find($id);
        
    //     // Ambil data institute beserta relasi subjects
    //     $institute = Institute::with('subjects')->find($id);
    //     if (!$institute) {
    //         return redirect()->back()->with('error', 'Institute not found.');
    //     }
        
    //     // Ambil data InstituteRegulation dengan filter berdasarkan institute_id melalui relasi instituteSubject
    //     $data = InstituteRegulation::whereHas('instituteSubject', function ($query) use ($id) {
    //             $query->where('institute_id', $id);
    //         })
    //         ->with(['instituteSubject.subject', 'regulation']) // Memuat relasi yang dibutuhkan
    //         ->get()
    //         ->unique(function ($item) {
    //             return $item->institute_subject_id . '-' . $item->regulation_id;
    //         }) 
    //         ->values(); // Reset index array
        
    //     // Ambil daftar regulation_id yang digunakan oleh InstituteRegulation
    //     $regulationIds = $data->pluck('regulation_id')->unique()->toArray();

    //     // Ambil data Parameter yang terkait dengan regulation_id yang digunakan
    //     $parameter = Parameter::whereIn('regulation_id', $regulationIds)->get();

    //     // Ambil data InstituteSubject berdasarkan institute_id
    //     $instituteSubjects = InstituteSubject::where('institute_id', $id)
    //     ->with('subject') // Load relasi subject
    //     ->get();
        
    //     // Ambil data Sampling berdasarkan institute_id                                                                                                                                                                                                                                                     
    //     $samplings = Sampling::where('institute_id', $id)
    //     ->with(['instituteSubject.subject']) // Load relasi jika diperlukan
    //     ->get();
        
    //     // Generate PDF menggunakan view 'pdf.ambient_air'
    //     $pdf = Pdf::loadView('pdf.ambient_air', compact('data', 'institute', 'samplings', 'instituteSubjects', 'customer'));
    //     return $pdf->stream('Ambient_Air_Report' . $id . '.pdf');
    // }

    

}
