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

    public function previewPdf($id)
    {
        // Mengambil data institute beserta relasi subjects dan customer
        $institute = Institute::with(['subjects', 'customer'])->findOrFail($id);

        // Ambil semua subject dari institute
        $instituteSubjects = InstituteSubject::where('institute_id', $id)
        ->with('subject')
        ->get();

        // Cek apakah salah satu subject adalah 'noise' (berdasarkan slug atau name)
       $isNoise = $instituteSubjects->pluck('subject.slug')->contains('Noise*'); // Ganti 'slug' dengan 'name' jika perlu


        // Mengirim semua data sampling
        $samplings = Sampling::where('institute_id', $id)
        ->with('instituteSubject.subject')
        ->get();

        $sampling = $samplings->first(); // Mengambil data sampling pertama jika ada

        // Mengambil parameter yang terkait langsung dengan daftar subject_id
        $parameters = Parameter::whereIn('subject_id', $instituteSubjects->pluck('subject_id'))->get();
        // Mengambil data SamplingTimeRegulation yang berkaitan dengan parameter yang telah difilter
        $samplingTimeRegulations = SamplingTimeRegulation::whereIn('parameter_id', $parameters->pluck('id'))
            ->with(['samplingTime', 'regulationStandards', 'parameter'])
            ->get()
            ->sortBy('parameter.name'); // Mengurutkan berdasarkan nama parameter

        // Mengambil data hasil (Result) berdasarkan parameter_id dan sampling_time_id serta sampling_id
        // $results = Result::whereIn('parameter_id', $parameters->pluck('id'))
        //     ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
        //     ->whereIn('sampling_id', $samplings->pluck('id'))
        //     ->get()
        //     ->groupBy(fn($item) => "{$item->parameter_id}-{$item->sampling_time_id}-{$item->sampling_id}");

            $results = Result::all()->groupBy(function ($item) {
                if (is_null($item->parameter_id) && is_null($item->sampling_time_id)) {
                    // Ini untuk data noise
                    return "Noise*-{$item->sampling_id}";
                }
                // Untuk data biasa
                return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->sampling_id}";
            });
            

        // Mengambil ID regulation yang terkait dengan InstituteSubject
        $regulationsIds = InstituteRegulation::whereIn('institute_subject_id', $instituteSubjects->pluck('id'))
            ->pluck('regulation_id')
            ->unique();
        // Mengambil data regulasi berdasarkan regulation_id yang telah difilter
        $regulations = Regulation::whereIn('id', $regulationsIds)->get();

         // Mengambil kondisi lapangan berdasarkan institute_id dan institute_subject_id
        $fieldCondition = FieldCondition::where('institute_id', $id)
        ->whereIn('institute_subject_id', $instituteSubjects->pluck('id'))
        ->first();
        // Mengambil kondisi lapangan dari hasil pertama jika ada
        $fieldCondition = optional($results->flatten()->first())->fieldCondition;

        $pdf = Pdf::loadView('pdf.preview_pdf', compact(
            'institute', 'parameters', 'samplingTimeRegulations', 'results',
            'instituteSubjects', 'sampling', 'fieldCondition', 'samplings', 'regulations','isNoise'
        ));

        // Mengaktifkan opsi PHP di dalam tampilan PDF
        $pdf->set_option("isPhpEnabled", true);
        return $pdf->stream("Preview_Pdf_Report{$id}.pdf");
    }
}