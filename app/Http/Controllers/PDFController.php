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
use Illuminate\Support\Facades\DB;

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

        $groupedByParameter = $samplingTimeRegulations->groupBy('parameter_id');

            // ✅ Ambil semua result BIASA
            $results = Result::whereNotNull('parameter_id')
            ->whereNotNull('sampling_time_id')
            ->get()
            ->groupBy(function ($item) {
                return "{$item->parameter_id}-{$item->sampling_time_id}-{$item->sampling_id}";
            });
            //  dd($results->toArray());

            // Ambil semua result yang tidak pakai sampling_time_id (misal: untuk air, tanah, dll)
            $resultsGeneral = Result::whereNotNull('parameter_id')
            ->whereNull('sampling_time_id')
            ->whereNotNull('sampling_id')
            ->get()
            ->groupBy(function ($item) {
                $subject = optional($item->sampling)->subject_type ?? 'unknown';
                return "{$item->sampling_id}|{$subject}|{$item->parameter_id}";
            });
            // Gabungkan ke $results utama
            $results = $results->mergeRecursive($resultsGeneral);
        // dd($resultsGeneral->toArray());

            // ✅ Ambil khusus NOISE pakai query yang kamu mau
            $noiseResults = DB::table('results')
            ->select(
                'sampling_id',
                'location',
                DB::raw('GROUP_CONCAT(leq ORDER BY id) as leq_values'),
                'ls', 'lm', 'lsm', 'unit', 'method', 'regulatory_standard')
            ->whereNull('parameter_id')
            ->whereNull('sampling_time_id')
            ->groupBy('sampling_id', 'location', 'ls', 'lm', 'lsm', 'unit', 'method', 'regulatory_standard')
            ->get()
            ->groupBy('sampling_id');
            // dd($noiseResults->toArray());

            // ✅ Ambil khusus  & ILUMIATION* pakai query yang kamu mau
            $ilumiResults = DB::table('results')
            ->select('sampling_id', 'time', 'testing_result', 'location', 'unit', 'method', 'regulatory_standard')
            ->whereNull('parameter_id')
            ->whereNull('sampling_time_id')
            ->groupBy('sampling_id', 'time', 'testing_result', 'location', 'unit', 'method', 'regulatory_standard')
            ->get()
            ->groupBy('sampling_id');
            // dd($ilumiResults->toArray());

            //query  khusus utk HEAT STRESS
            $htsResults = DB::table('heat_stresses')
            ->select('sampling_id','sampling_location','time', 'humidity', 'wet', 'dew', 'globe', 'wbgt_index', 'methods')
            ->whereIn('sampling_id', function ($query) use ($id) {
                $query->select('id')->from('samplings')->where('institute_id', $id);
            })
            ->get()
            ->groupBy('sampling_id');


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
            'institute', 'parameters', 'samplingTimeRegulations', 'results','noiseResults', 'ilumiResults', 'htsResults',
            'instituteSubjects', 'sampling', 'fieldCondition', 'samplings', 'regulations','isNoise', 'groupedByParameter'
        ));

        // Mengaktifkan opsi PHP di dalam tampilan PDF
        $pdf->set_option("isPhpEnabled", true);
        return $pdf->stream("Preview_Pdf_Report{$id}.pdf");
    }
}


// Mengambil data hasil (Result) berdasarkan parameter_id dan sampling_time_id serta sampling_id
        // $results = Result::whereIn('parameter_id', $parameters->pluck('id'))
        //     ->whereIn('sampling_time_id', $samplingTimeRegulations->pluck('samplingTime.id')->filter())
        //     ->whereIn('sampling_id', $samplings->pluck('id'))
        //     ->get()
        //     ->groupBy(fn($item) => "{$item->parameter_id}-{$item->sampling_time_id}-{$item->sampling_id}");
