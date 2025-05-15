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
   public function ambientAirPdf($id)
    {
        // Mengambil data institute beserta relasi subjects dan customer
        $institute = Institute::with(['subjects', 'customer'])->findOrFail($id);

        // Mengambil semua data sampling yang terkait dengan institute_id tertentu
        $samplings = Sampling::where('institute_id', $id)->with('instituteSubject.subject')->get();
        $sampling = $samplings->first(); // Mengambil data sampling pertama jika ada

        // Mengambil semua InstituteSubject yang memiliki subject bernama 'Ambient Air'
        $instituteSubjects = InstituteSubject::where('institute_id', $id)
            ->whereHas('subject', fn($q) => $q->where('name', 'Ambient Air'))
            ->with('subject')
            ->get();

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

        // Mengambil kondisi lapangan dari hasil pertama jika ada
        $fieldCondition = optional($results->flatten()->first())->fieldCondition;

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

}
