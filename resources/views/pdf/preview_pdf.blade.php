<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $institute->customer->name ?? 'N/A' }} - {{ $institute->subjects->pluck('name')->implode(', ') ?? 'N/A' }}</title>
    <link rel="stylesheet" href="('assets/css/bootstrap_mpdf.css') ?>" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body, p, td, th {
            font-family: 'Arial Narrow', Arial, sans-serif;
        }
        .page_break {
            page-break-before: always;
        }
        table {
            font-size: 11px;
        }
        .table-bordered th, .table-bordered td {
            padding: 1px!important;
            line-height: 13px!important;
            border: 1px solid black;
        }
        .no-padding {
            padding-top: 1px!important;
        }
        .table-no-bordered tr td, .no-border {
            border: none;
        }
        p {
            line-height: 16px!important;
        }
        td {
            padding-top: 5px!important;
        }
        .certificate-container {
            margin-top: 100px;
            margin-left: 200px;
        }
        .certificate-title {
            font-size: 20px;
            font-weight: bold;
        }
        header, footer {
            position: fixed;
            width: 100%;
            left: 0;
        }
        header {
            top: 0;
            padding: 10px 0;
        }
        footer {
            bottom: 0;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            text-align: center;
            padding: 10px;
        }
        body {
            margin-top: 100px;
            margin-bottom: 110px;
        }
        @page {
        margin: 50px;
        @bottom-center {
            content: "This Certificate of Analysis consists of " counter(page) " of " counter(pages) " pages";
            font-size: 12px;
        }
    }
    </style>
</head>
<body>
{{-- Header --}}
<header>
        <div style="width: 100%;">
            <div align="left" style="width: 50%; float: left;">
                <img src="{{ public_path('assets/img/company_profile/logo/logo.png') }}" alt="" width="150px">
            </div>
            <div align="right" style="width: 50%; float: right;">
                <div>
                @if($sampling && $sampling->show_logo)
                    <img src="{{ public_path('assets/img/kan.png') }}" alt="KAN Logo" width="100px" style="float: right;">
                    <div style="clear: right;"></div>
                    <p style="font-size: 9px; font-weight: bold; text-align:right; margin: -5px;">
                        SK-KLHK No 00161/LPJ/Labling-1/LRK/KLHK
                    </p>
                @endif
                    <p style="font-size: 8px; text-align:right; margin: -5px;">
                        7.8.1/DIL/VII/2018/FORM REV . 2
                    </p>
                    <p style="font-size: 8px; text-align:right; margin: -5px;">
                        {PAGE_NUM} of {PAGE_COUNT}
                    </p>
                </div>
            </div>
        </div>
</header>
{{-- End Header --}}
{{--  Footer --}}
<footer>
    <table style="width: 100%; font-size: 8px;">
        <tr>
            <!-- Kolom kiri: Alamat -->
            <td style="width: 50%; text-align: left; vertical-align: bottom;">
                <p style="font-weight: bold; margin: -5;">Ruko Prima Orchard No.C 2</p>
                <p style="font-weight: bold; margin: -5;">Prima Harapan Regency Bekasi Utara,</p>
                <p style="font-weight: bold; margin: -5;">Kota Bekasi 17123, Provinsi Jawa Barat</p>
                <p style="font-weight: bold; margin: -5;">Telp: 021-88382018</p>
                <p style="color: blue; text-decoration: underline; margin: -5;">
                    <a href="http://www.deltaindonesialab.com" style="color: blue;">www.deltaindonesialab.com</a>
                </p>
            </td>   
            <!-- Kolom kanan: Logo DIL -->
            <td style="width: 50%; text-align: right; vertical-align: bottom;">
            </td>
        </tr>
    </table>
    <!-- Pesan bawah -->
    <table style="width: 100%; margin-top: 5px;">
        <tr>
            <td colspan="2" style="font-size: 8px; text-align: center;">
                *This result(s) relate only to the sample(s) tested and the test report/certificate shall not be reproduced except in full, without written approval of PT Delta Indonesia Laboratory
            </td>
        </tr>
    </table>
</footer>
{{-- End Footer --}}

{{-- Start Resume --}}
<div class="text-center certificate-container" style="margin-top: 45px;">
    <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
    <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
</div>

<div class="col-xs-110" style="margin-top: 30px; margin-left: 70px;">
    <table class="mt-2 table" style="font-size: 12px;">
        <tr>
            <td width="150px">Customer</td>
            <td>:</td>
            <td colspan="2" style="font-weight: bold;">{{$institute->customer->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>:</td>
            <td colspan="2">{{ $institute->customer->address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Contact Name</td>
            <td>:</td>
            <td colspan="2">{{ $institute->customer->contact_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td colspan="2"><a href="mailto:{{ $institute->customer->email ?? 'N/A' }}" style="color: blue; text-decoration: underline;">{{ $institute->customer->email ?? 'N/A' }}</a></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>:</td>
            <td colspan="2">{{ $institute->customer->phone ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Subject</td>
            <td>:</td>
            <td style="margin-top: 10px" colspan="5">
            <ul style="list-style-type: none; padding-left: 0;">
                @foreach($instituteSubjects->groupBy('subject_id') as $instituteSubject)
                <li>- {{ $instituteSubject->first()->subject->name ?? 'N/A' }}</li>
                @endforeach
            </ul>
            </td>
        </tr>
        <tr>
            <td>Sample taken by</td>
            <td>:</td>
            <td colspan="5">
                <li> PT. Delta Indonesia Laboratory</li>
                <li> Customer</li>
                <li> Third Party</li>
            </td>
        </tr>
        <tr>
            <td>Sample Receive Date</td>
            <td>:</td>
            <td colspan="2">{{ \Carbon\Carbon::parse($institute->sample_receive_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="padding-right: 50px;">Sample Analysis Date</td>
            <td style="padding-right: 10px;">:</td>
            <td colspan="2">{{ \Carbon\Carbon::parse($institute->sample_analysis_date)->translatedFormat('d F, Y') ?? 'N/A' }} to {{ \Carbon\Carbon::parse($institute->report_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Report Date</td>
            <td>:</td>
            <td colspan="2">{{ \Carbon\Carbon::parse($institute->report_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
        </tr>
    </table>
</div>

<div style="width: 100%; margin-top: 50px;">
    <div align="left" style="width: 50%;float: left;"></div>
    <div style="width: 50%; float: right;">
        <div style="text-align: right;">
            <p style="font-size: 12px;">This Certificate of Analysis of ... pages</p>
            <p style="font-size: 12px;">Bekasi, {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
            <img src="assets/img/company_profile/stamp/cap_dil.png" alt="" width="150px" height="100px">
            <br>
            @php
                use Illuminate\Support\Facades\DB;
                $presidentDirector = DB::table('directors')->first(); // ambil satu data pertama
            @endphp
            <p style="font-size: 12px; font-weight: bold; text-decoration: underline; margin-bottom: -2px;">{{ $presidentDirector->name }}</p>
            <p style="font-size: 12px; font-weight: bold; margin-right: 40px;">President Director</p>
        </div>
    </div>
</div>
{{-- End Resume --}}

{{--============================================== AMBIENT AIR =====================================================--}}
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Ambient Air')
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                    <tr>
                        <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->translatedFormat('d F, Y') ?? 'N/A' }} <br> to
                                                    <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">NO</td>
                    <td style="border: 1px solid; font-weight: bold;">Parameters</td>
                    <td style="border: 1px solid; font-weight: bold;">Sampling Time</td>
                    <td style="border: 1px solid; font-weight: bold;">Testing Result</td>
                    <td style="border: 1px solid; font-weight: bold;">Regulatory <br> Standard**</td>
                    <td style="border: 1px solid; font-weight: bold;">Unit</td>
                    <td style="border: 1px solid; font-weight: bold;">Methods</td>
                </tr>

                @php $no = 1; @endphp

                @foreach(collect($samplingTimeRegulations)->pluck('parameter')->unique()->sortBy('id') as $parameter)
                    @php
                        $samplingTimes = $samplingTimeRegulations->where('parameter_id', $parameter->id);
                        $rowspan = $samplingTimes->count();
                        $firstRow = true;
                    @endphp

                    @foreach ($samplingTimes as $samplingTime)
                        @php
                            $resultKey = "{$parameter->id}-{$samplingTime->samplingTime->id}-{$sampling->id}";
                            $resultData = $results->get($resultKey) ?? collect();
                            $regulationStandard = $samplingTime->regulationStandards ?? null;
                        @endphp

                    @if ($resultData->isNotEmpty())
                    <tr>
                        @if ($firstRow)
                        <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $no++ }}</td>
                        <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $parameter->name }}</td>
                        @endif
                        <td style="border: 1px solid;">{{ $samplingTime->samplingTime->time }}</td>
                        <td style="border: 1px solid;">{{ $resultData->pluck('testing_result')->implode(', ') }}</td>
                        <td style="border: 1px solid;">{{ $regulationStandard ? $regulationStandard->title : '-' }}</td>
                        @if ($firstRow)
                        <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $parameter->unit ?? '-' }}</td>
                        <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $parameter->method ?? '-' }}</td>
                        @endif
                        </tr>
                        @php
                            $firstRow = false;
                        @endphp
                    @endif
                @endforeach
                @endforeach
            </table>
        </div>
        {{-- End Parameters --}}
        {{-- Start Condition  --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            @php
                $ambientFieldCondition = $fieldCondition->firstWhere('institute_subject_id', optional($instituteSubjects->firstWhere('subject.name', 'Ambient Air'))->id);
            @endphp
            @if($ambientFieldCondition)
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Ambient Environmental Condition <br></td>
                    <td style="width: 70%;">:</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;"></td>
                    <td style="width: 70%;"></td>
                </tr>
                @if ($ambientFieldCondition?->coordinate)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Coordinate</td>
                    <td style="width: 70%;">: {{ $ambientFieldCondition->coordinate }}</td>
                </tr>
                @endif

                @if ($ambientFieldCondition?->temperature)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Temperature</td>
                    <td style="width: 70%;">: {{ $ambientFieldCondition->temperature }} °C</td>
                </tr>
                @endif

                @if ($ambientFieldCondition?->pressure)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Pressure</td>
                    <td style="width: 70%;">: {{ $ambientFieldCondition->pressure }} mmHg</td>
                </tr>
                @endif

                @if ($ambientFieldCondition?->humidity)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Humidity</td>
                    <td style="width: 70%;">: {{ $ambientFieldCondition->humidity }} %RH</td>
                </tr>
                @endif

                @if ($ambientFieldCondition?->wind_speed)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Speed</td>
                    <td style="width: 70%;">: {{ $ambientFieldCondition->wind_speed }} m/s</td>
                </tr>
                @endif

                @if ($ambientFieldCondition?->wind_direction)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Direction</td>
                    <td style="width: 70%;">: {{ $ambientFieldCondition->wind_direction }}</td>
                </tr>
                @endif

                @if ($ambientFieldCondition?->weather)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Weather</td>
                    <td style="width: 70%;">: {{ $ambientFieldCondition->weather }}</td>
                </tr>
                @endif
            </table>
            @endif
        </div>
        {{-- End Condition  --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> &lt; </td>
                    <td style="width: 100%;">Less Than MDL (Method Detection Limit) </td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 3)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '' : '*' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
@endforeach
{{--============================================== END AMBIEN AIR =====================================================--}}

{{--============================================== NOISE* =====================================================--}}
{{-------------------------------------------- Template Noise 1 ---------------------------------------------------}}
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Noise*')
    
    @php
        // Deteksi apakah ada satupun data valid
        $hasValidNoiseData = false;

        foreach ($noiseResults as $samplingId => $locations) {
            $relatedSampling = $samplings->firstWhere('id', $samplingId);
            if (is_null($relatedSampling)) {
                continue;
            }

            $subjectName = strtolower(optional($relatedSampling?->instituteSubject?->subject)->name ?? '');
            if (!Str::contains($subjectName, 'noise')) {
                continue;
            }

            foreach ($locations as $locationData) {
                $leqArray = explode(',', $locationData->leq_values);
                $validLeq = collect($leqArray)->filter(function ($val) {
                    return trim($val) !== '';
                });

                if (
                    !empty($locationData->ls) &&
                    !empty($locationData->lm) &&
                    !empty($locationData->lsm) &&
                    !empty($locationData->regulatory_standard) &&
                    !empty($locationData->unit) &&
                    !empty($locationData->method) &&
                    $validLeq->isNotEmpty()
                ) {
                    $hasValidNoiseData = true;
                    break 2; // cukup temukan satu saja, langsung keluar loop
                }
            }
        }
    @endphp
    @if ($hasValidNoiseData)
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                <tr>
                    <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->format('F d, Y') ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->format('F d, Y') ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->format('F d, Y') ?? 'N/A' }} <br> to
                                                <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->format('F d, Y')  ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
                <tr>
                    <th style="border: 1px solid;">No</th>
                    <th style="border: 1px solid;">Sampling<br>Location</th>
                    <th style="border: 1px solid;">Noise</th>
                    <th style="border: 1px solid;">Time</th>
                    <th style="border: 1px solid;">Leq</th>
                    <th style="border: 1px solid;">Ls</th>
                    <th style="border: 1px solid;">Lm</th>
                    <th style="border: 1px solid;">Lsm</th>
                    <th style="border: 1px solid;">Regulatory<br>Standard**</th>
                    <th style="border: 1px solid;">Unit</th>
                    <th style="border: 1px solid;">Methods</th>
                </tr>

                @php
                    $noises = [
                        ['L1', 'T1', 'q1'],
                        ['L2', 'T2', 'q1'],
                        ['L3', 'T3', 'q1'],
                        ['L4', 'T4', 'q1'],
                        ['L5', 'T5', 'q1'],
                        ['L6', 'T6', 'q1'],
                        ['L7', 'T7', 'q1'],
                    ];
                    $rowNumber = 1;
                @endphp

                @foreach ($noiseResults as $samplingId => $locations)
                    @php
                        $relatedSampling = $samplings->firstWhere('id', $samplingId);
                    @endphp

                    @if (is_null($relatedSampling))
                        @continue
                    @endif

                    @php
                        $subjectName = strtolower(optional($relatedSampling?->instituteSubject?->subject)->name ?? '');
                    @endphp

                    @if (Str::contains($subjectName, 'noise'))
                        @foreach ($locations as $locationData)

                            @foreach ($noises as $i => $noise)
                                @php
                                    $leq = isset($leqArray[$i]) && trim($leqArray[$i]) !== '' ? $leqArray[$i] : '-';
                                @endphp
                                <tr>
                                    @if ($i === 0)
                                        <td style="border: 1px solid;" rowspan="7">{{ $rowNumber++ }}</td>
                                        <td style="border: 1px solid;" rowspan="7">{{ $locationData->location }}</td>
                                    @endif

                                    <td style="border: 1px solid;">{{ $noise[0] }}</td>
                                    <td style="border: 1px solid;">{{ $noise[1] }}</td>
                                    <td style="border: 1px solid;">{{ $leq }}</td>

                                    @if ($i === 0)
                                        <td style="border: 1px solid;" rowspan="7">{{ $locationData->ls }}</td>
                                        <td style="border: 1px solid;" rowspan="7">{{ $locationData->lm }}</td>
                                        <td style="border: 1px solid;" rowspan="7">{{ $locationData->lsm }}</td>
                                        <td style="border: 1px solid;" rowspan="7">{{ $locationData->regulatory_standard }}</td>
                                        <td style="border: 1px solid;" rowspan="7">{{ $locationData->unit }}</td>
                                        <td style="border: 1px solid;" rowspan="7">{{ $locationData->method }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                @endforeach
            </table>
        </div>
        {{-- End Parameters --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 3)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '***' : '**' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
    @endif
@endforeach
{{-------------------------------------------- End Template Noise 1 ---------------------------------------------------}}
{{-------------------------------------------- Template Noise 2 ---------------------------------------------------}}
@php
    // Cek apakah ada testing_result yang valid (tidak null atau kosong)
    $hasNoiseData = collect($noiseResults)
    ->flatten(1)
    ->filter(function ($item) {
        return !empty($item->testing_result);
    })->isNotEmpty();
    @endphp
@if($hasNoiseData)
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Noise*')
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                <tr>
                    <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->translatedFormat('d F, Y') ?? 'N/A' }} <br> to
                                                <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;">
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
                <tr>
                    <th style="border: 1px solid;">No</th>
                    <th style="border: 1px solid;">Sampling<br>Location</th>
                    <th style="border: 1px solid;">Testing Result</th>
                    <th style="border: 1px solid;">Time</th>
                    <th style="border: 1px solid;">Regulatory<br>Standard**</th>
                    <th style="border: 1px solid;">Unit</th>
                    <th style="border: 1px solid;">Methods</th>
                </tr>
        
                @php $rowNumber = 1; @endphp
                @foreach ($parameterResults as $samplingId => $items)
                    @foreach ($items as $result)
                        <tr>
                            <td style="border: 1px solid;">{{ $rowNumber++ }}</td>
                            <td style="border: 1px solid;">{{ $result->location }}</td>
                            <td style="border: 1px solid;">{{ $result->testing_result ?? '-' }}</td>
                            <td style="border: 1px solid;">{{ $result->time ?? '-' }}</td>
                            <td style="border: 1px solid;">{{ $result->regulatory_standard ?? '-' }}</td>
                            <td style="border: 1px solid;">{{ $result->unit ?? '-' }}</td>
                            <td style="border: 1px solid;">{{ $result->method ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
        
        {{-- End Parameters --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 3)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '***' : '**' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
@endforeach
@endif
{{-------------------------------------------- End Template Noise 2 ---------------------------------------------------}}
{{--============================================== END NOISE* =====================================================--}}

{{--============================================== WORKPLACE AIR =====================================================--}}
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Workplace Air')
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                    <tr>
                        <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->translatedFormat('d F, Y') ?? 'N/A' }} <br> to
                                                    <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
                <tr>
                    <th style="border: 1px solid;">No</th>
                    <th style="border: 1px solid;">Parameters</th>
                    <th style="border: 1px solid;">Testing Result</th>
                    <th style="border: 1px solid;">Regulatory<br>Standard**</th>
                    <th style="border: 1px solid;">Unit</th>
                    <th style="border: 1px solid;">Methods</th>
                </tr>
            
                @php $no = 1; @endphp
            
                @foreach(collect($samplingTimeRegulations)->pluck('parameter')->unique()->sortBy('id') as $parameter)
                    @php
                        $subject = optional($sampling->subject)->subject_type ?? 'unknown';
                        $resultKey = "{$sampling->id}|{$subject}|{$parameter->id}";
                        $resultData = $results->get($resultKey) ?? collect();
                        $regulationStandard = optional(
                            $samplingTimeRegulations->where('parameter_id', $parameter->id)->first()
                        )->regulationStandards;
                    @endphp
            
                    @if ($resultData->isNotEmpty())
                    <tr>
                        <td style="border: 1px solid;">{{ $no++ }}</td>
                        <td style="border: 1px solid;">{{ $parameter->name }}</td>
                        <td style="border: 1px solid;">{{ $resultData->pluck('testing_result')->implode(', ') }}</td>
                        <td style="border: 1px solid;">{{ $regulationStandard ? $regulationStandard->title : '-' }}</td>
                        <td style="border: 1px solid;">{{ $parameter->unit ?? '-' }}</td>
                        <td style="border: 1px solid;">{{ $parameter->method ?? '-' }}</td>
                    </tr>
                    @endif
                @endforeach
            </table>
        </div>
        {{-- End Parameters --}}
        {{-- Start Condition  --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            @php
                $workplaceFieldCondition = $fieldCondition->firstWhere('institute_subject_id', optional($instituteSubjects->firstWhere('subject.name', 'Workplace Air'))->id);
            @endphp
            @if($workplaceFieldCondition)
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Workplace Air Environment Condition </td>
                    <td style="width: 70%;">:</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;"></td>
                    <td style="width: 70%;">:</td>
                </tr>
                @if ($workplaceFieldCondition?->coordinate)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Coordinate</td>
                    <td style="width: 70%;">: {{ $workplaceFieldCondition->coordinate }}</td>
                </tr>
                @endif

                @if ($workplaceFieldCondition?->temperature)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Temperature</td>
                    <td style="width: 70%;">: {{ $workplaceFieldCondition->temperature }} °C</td>
                </tr>
                @endif

                @if ($workplaceFieldCondition?->pressure)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Pressure</td>
                    <td style="width: 70%;">: {{ $workplaceFieldCondition->pressure }} mmHg</td>
                </tr>
                @endif

                @if ($workplaceFieldCondition?->humidity)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Humidity</td>
                    <td style="width: 70%;">: {{ $workplaceFieldCondition->humidity }} %RH</td>
                </tr>
                @endif

                @if ($workplaceFieldCondition?->wind_speed)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Speed</td>
                    <td style="width: 70%;">: {{ $workplaceFieldCondition->wind_speed }} m/s</td>
                </tr>
                @endif

                @if ($workplaceFieldCondition?->wind_direction)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Direction</td>
                    <td style="width: 70%;">: {{ $workplaceFieldCondition->wind_direction }}</td>
                </tr>
                @endif

                @if ($workplaceFieldCondition?->weather)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Weather</td>
                    <td style="width: 70%;">: {{ $workplaceFieldCondition->weather }}</td>
                </tr>
                @endif
            </table>
            @endif
        </div>
        {{-- End Condition  --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 2)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '***' : '**' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
@endforeach
{{--============================================== END WORKPLACE AIR =====================================================--}}

{{--============================================== ODOR =====================================================--}}
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Odor')
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                    <tr>
                        <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->translatedFormat('d F, Y') ?? 'N/A' }} <br> to
                                                    <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
                <tr>
                    <th style="border: 1px solid;">No</th>
                    <th style="border: 1px solid;">Parameters</th>
                    <th style="border: 1px solid;">Testing Result</th>
                    <th style="border: 1px solid;">Regulatory<br>Standard**</th>
                    <th style="border: 1px solid;">Unit</th>
                    <th style="border: 1px solid;">Methods</th>
                </tr>
            
                @php $no = 1; @endphp
            
                @foreach(collect($samplingTimeRegulations)->pluck('parameter')->unique()->sortBy('id') as $parameter)
                    @php
                        $subject = optional($sampling->subject)->subject_type ?? 'unknown';
                        $resultKey = "{$sampling->id}|{$subject}|{$parameter->id}";
                        $resultData = $results->get($resultKey) ?? collect();
                        $regulationStandard = optional(
                            $samplingTimeRegulations->where('parameter_id', $parameter->id)->first()
                        )->regulationStandards;
                    @endphp
            
                    @if ($resultData->isNotEmpty())
                    <tr>
                        <td style="border: 1px solid;">{{ $no++ }}</td>
                        <td style="border: 1px solid;">{{ $parameter->name }}</td>
                        <td style="border: 1px solid;">{{ $resultData->pluck('testing_result')->implode(', ') }}</td>
                        <td style="border: 1px solid;">{{ $regulationStandard ? $regulationStandard->title : '-' }}</td>
                        <td style="border: 1px solid;">{{ $parameter->unit ?? '-' }}</td>
                        <td style="border: 1px solid;">{{ $parameter->method ?? '-' }}</td>
                    </tr>
                    @endif
                @endforeach
            </table>
        </div>
        {{-- End Parameters --}}
        {{-- Start Condition  --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            @php
                $odorFieldCondition = $fieldCondition->firstWhere('institute_subject_id', optional($instituteSubjects->firstWhere('subject.name', 'Odor'))->id);
            @endphp
            @if($odorFieldCondition)
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Odor Environment Condition </td>
                    <td style="width: 70%;">:</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;"></td>
                    <td style="width: 70%;">:</td>
                </tr>
                @if ($odorFieldCondition?->coordinate)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Coordinate</td>
                    <td style="width: 70%;">: {{ $odorFieldCondition->coordinate }}</td>
                </tr>
                @endif

                @if ($odorFieldCondition?->temperature)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Temperature</td>
                    <td style="width: 70%;">: {{ $odorFieldCondition->temperature }} °C</td>
                </tr>
                @endif

                @if ($odorFieldCondition?->pressure)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Pressure</td>
                    <td style="width: 70%;">: {{ $odorFieldCondition->pressure }} mmHg</td>
                </tr>
                @endif

                @if ($odorFieldCondition?->humidity)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Humidity</td>
                    <td style="width: 70%;">: {{ $odorFieldCondition->humidity }} %RH</td>
                </tr>
                @endif

                @if ($odorFieldCondition?->wind_speed)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Speed</td>
                    <td style="width: 70%;">: {{ $odorFieldCondition->wind_speed }} m/s</td>
                </tr>
                @endif

                @if ($odorFieldCondition?->wind_direction)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Direction</td>
                    <td style="width: 70%;">: {{ $odorFieldCondition->wind_direction }}</td>
                </tr>
                @endif

                @if ($odorFieldCondition?->weather)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Weather</td>
                    <td style="width: 70%;">: {{ $odorFieldCondition->weather }}</td>
                </tr>
                @endif
            </table>
            @endif
        </div>
        {{-- End Condition  --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 4)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '***' : '**' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
@endforeach
{{--============================================== END ODOR =====================================================--}}

{{--============================================== ILUMIATION* =====================================================--}}
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Illumination*')
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                    <tr>
                        <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->translatedFormat('d F, Y') ?? 'N/A' }} <br> to
                                                    <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
                <tr>
                    <th style="border: 1px solid;">No</th>
                    <th style="border: 1px solid;">Sampling Location</th>
                    <th style="border: 1px solid;">Testing Result</th>
                    <th style="border: 1px solid;">Time</th>
                    <th style="border: 1px solid;">Regulatory<br>Standard**</th>
                    <th style="border: 1px solid;">Unit</th>
                    <th style="border: 1px solid;">Methods</th>
                </tr>
            
                @php $no = 1; @endphp
            
                @foreach ($ilumiResults as $samplingId => $locations)
                    @php
                        $relatedSampling = $samplings->firstWhere('id', $samplingId);
                        $subjectName = strtolower(optional($relatedSampling->instituteSubject->subject)->name ?? 'illumination');
                    @endphp
            
                    {{-- Hanya untuk subject Ilumination* --}}
                    @if (Str::contains($subjectName, 'illumination'))
                        @foreach ($locations as $locationData)
                            <tr>
                                <td style="border: 1px solid;">{{ $no++ }}</td>
                                <td style="border: 1px solid;">{{ $locationData->location ?? '-' }}</td>
                                <td style="border: 1px solid;">{{ $locationData->testing_result ?? '-' }}</td>
                                <td style="border: 1px solid;">{{ $locationData->time ?? '-' }}</td>
                                <td style="border: 1px solid;">{{ $locationData->regulatory_standard ?? '-' }}</td>
                                <td style="border: 1px solid;">{{ $locationData->unit ?? '-' }}</td>
                                <td style="border: 1px solid;">{{ $locationData->method ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </table>
        </div>
        {{-- End Parameters --}}
        {{-- Start Condition  --}}
        @if ($resultData->isNotEmpty())
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Workplace Environment Condition :</td>
                    <td style="width: 70%;"></td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Coordinate</td>
                    <td style="width: 70%;">: {{ $fieldCondition['coordinate'] ?? 'N/A' }}</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Temperature</td>
                    <td style="width: 70%;">: {{ $fieldCondition['temperature'] ?? 'N/A' }} °C</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Pressure</td>
                    <td style="width: 70%;">: {{ $fieldCondition['pressure'] ?? 'N/A' }} mmHg</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Humidity</td>
                    <td style="width: 70%;">: {{ $fieldCondition['humidity'] ?? 'N/A' }} %RH</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Speed</td>
                    <td style="width: 70%;">: {{ $fieldCondition['wind_speed'] ?? 'N/A' }} m/s</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Direction</td>
                    <td style="width: 70%;">: {{ $fieldCondition['wind_direction'] ?? 'N/A' }}</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Weather</td>
                    <td style="width: 70%;">: {{ $fieldCondition['weather'] ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        @endif
        {{-- End Condition  --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 5)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '***' : '**' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
@endforeach
{{--============================================== END ILUMIATIO =====================================================--}}

{{--============================================== HEAT STRESS* =====================================================--}}
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Heat Stress')
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                    <tr>
                        <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->translatedFormat('d F, Y') ?? 'N/A' }} <br> to
                                                    <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            @foreach ($htsResults as $samplingId => $rows)
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
                <tr>
                    <th style="border: 1px solid;" rowspan="2">Sampling Location</th>
                    <th style="border: 1px solid;" rowspan="2">Time</th>
                    <th style="border: 1px solid;" rowspan="2">Humidity (%)</th>
                    <th style="border: 1px solid;" colspan="3">Temperature (°C)</th>
                    <th style="border: 1px solid;" rowspan="2">WBGT INDEX</th>
                    <th style="border: 1px solid;" rowspan="2">Methods</th>
                </tr>
                <tr>
                    <th style="border: 1px solid;">Wet</th>
                    <th style="border: 1px solid;">Dew</th>
                    <th style="border: 1px solid;">Globe</th>
                </tr>
                @foreach ($rows as $row)
                <tr>
                    <td style="border: 1px solid;">{{ $row->sampling_location }}</td>
                    <td style="border: 1px solid;">{{ $row->time }}</td>
                    <td style="border: 1px solid;">{{ $row->humidity }}</td>
                    <td style="border: 1px solid;">{{ $row->wet }}</td>
                    <td style="border: 1px solid;">{{ $row->dew }}</td>
                    <td style="border: 1px solid;">{{ $row->globe }}</td>
                    <td style="border: 1px solid;">{{ $row->wbgt_index }}</td>
                    <td style="border: 1px solid;">{{ $row->methods ?? 'SNI 16-7063-2004' }}</td>
                </tr>
                @endforeach
            </table>
            <br>
            @endforeach

        </div >
        <div style="margin-top: 20px;">
            <table style="font-size: 10px; width: 100%; border-collapse: collapse; border: 1px solid black; text-align: center;">
                <thead>
                    <tr>
                        <th rowspan="3" style="border: 1px solid black; vertical-align: middle; padding: 5px;">
                            Hourly Working Time Setting
                        </th>
                        <th colspan="4" style="border: 1px solid black; padding: 5px;"><b>WBGT INDEX</b></th>
                    </tr>
                    <tr>
                        <th colspan="4" style="border: 1px solid black; padding: 5px;"><b>Workload</b></th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px;"><b>Light</b></th>
                        <th style="border: 1px solid black; padding: 5px;"><b>Medium</b></th>
                        <th style="border: 1px solid black; padding: 5px;"><b>Heavy</b></th>
                        <th style="border: 1px solid black; padding: 5px;"><b>Very Heavy</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black; padding: 5px;">75% - 100%</td>
                        <td style="border: 1px solid black; padding: 5px;">31.0</td>
                        <td style="border: 1px solid black; padding: 5px;">28.0</td>
                        <td style="border: 1px solid black; padding: 5px;">-</td>
                        <td style="border: 1px solid black; padding: 5px;">-</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 5px;">50% - 75%</td>
                        <td style="border: 1px solid black; padding: 5px;">31.0</td>
                        <td style="border: 1px solid black; padding: 5px;">29.0</td>
                        <td style="border: 1px solid black; padding: 5px;">27.5</td>
                        <td style="border: 1px solid black; padding: 5px;">-</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 5px;">25% - 50%</td>
                        <td style="border: 1px solid black; padding: 5px;">32.0</td>
                        <td style="border: 1px solid black; padding: 5px;">30.0</td>
                        <td style="border: 1px solid black; padding: 5px;">29.0</td>
                        <td style="border: 1px solid black; padding: 5px;">28.0</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 5px;">0% - 25%</td>
                        <td style="border: 1px solid black; padding: 5px;">32.2</td>
                        <td style="border: 1px solid black; padding: 5px;">31.1</td>
                        <td style="border: 1px solid black; padding: 5px;">30.5</td>
                        <td style="border: 1px solid black; padding: 5px;">30.0</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        {{-- End Parameters --}}
        {{-- Start Condition  --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            @php
                $heatFieldCondition = $fieldCondition->firstWhere('institute_subject_id', optional($instituteSubjects->firstWhere('subject.name', 'Heat Stress'))->id);
            @endphp
            @if($heatFieldCondition)
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Heat Stress Environment Condition </td>
                    <td style="width: 70%;">:</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;"></td>
                    <td style="width: 70%;">:</td>
                </tr>
                @if ($heatFieldCondition?->coordinate)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Coordinate</td>
                    <td style="width: 70%;">: {{ $heatFieldCondition->coordinate }}</td>
                </tr>
                @endif

                @if ($heatFieldCondition?->temperature)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Temperature</td>
                    <td style="width: 70%;">: {{ $heatFieldCondition->temperature }} °C</td>
                </tr>
                @endif

                @if ($heatFieldCondition?->pressure)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Pressure</td>
                    <td style="width: 70%;">: {{ $heatFieldCondition->pressure }} mmHg</td>
                </tr>
                @endif

                @if ($heatFieldCondition?->humidity)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Humidity</td>
                    <td style="width: 70%;">: {{ $heatFieldCondition->humidity }} %RH</td>
                </tr>
                @endif

                @if ($heatFieldCondition?->wind_speed)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Speed</td>
                    <td style="width: 70%;">: {{ $heatFieldCondition->wind_speed }} m/s</td>
                </tr>
                @endif

                @if ($heatFieldCondition?->wind_direction)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Direction</td>
                    <td style="width: 70%;">: {{ $heatFieldCondition->wind_direction }}</td>
                </tr>
                @endif

                @if ($heatFieldCondition?->weather)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Weather</td>
                    <td style="width: 70%;">: {{ $heatFieldCondition->weather }}</td>
                </tr>
                @endif
            </table>
            @endif
        </div>
        {{-- End Condition  --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 6)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '***' : '**' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
    @endforeach
{{--============================================== END HEAT STRESS* =====================================================--}}

{{--============================================== Stationary Stack Source Emission =====================================================--}}
@foreach($samplings->whereNotNull('sampling_location') as $sampling)
    @if($sampling->instituteSubject && $sampling->instituteSubject->subject && $sampling->instituteSubject->subject->name === 'Stationary Stack Source Emission')
    <div class="page_break"></div>
    <div>
        <div class="text-center certificate-container" style="margin-top: 20px;">
            <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
            <div class="text-center" style="font-size: 12px; margin-left: 50px; margin-top: -10px;">Certificate No. DIL-{{ $institute->no_coa ?? 'N/A' }}COA</div>
        </div>
        <div style="margin-top: 5px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="border: 1px solid; font-weight: bold;">SAMPEL NO</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING LOCATION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DESCRIPTION</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING DATE</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING TIME</td>
                    <td style="border: 1px solid; font-weight: bold;">SAMPLING METHODS</td>
                    <td style="border: 1px solid; font-weight: bold;">DATE RECEIVED</td>
                    <td style="border: 1px solid; font-weight: bold;">INTERVAL TESTING DATE</td>
                </tr>
                    <tr>
                        <td style="border: 1px solid;">{{ $institute->no_coa ?? 'N/A' }}.{{ $sampling->no_sample ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                        <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->translatedFormat('d F, Y') ?? 'N/A' }} <br> to
                                                    <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->translatedFormat('d F, Y') ?? 'N/A' }}</td>
                    </tr>
            </table>
        </div>
        {{-- Start Parameters --}}
        <div style="margin-top: 20px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto; width: 100%; border-collapse: collapse; text-align: center;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black;">No</th>
                        <th style="border: 1px solid black;">Parameters</th>
                        <th style="border: 1px solid black;">Testing Result</th>
                        <th style="border: 1px solid black;">Regulatory<br>Standard**</th>
                        <th style="border: 1px solid black;">Unit</th>
                        <th style="border: 1px solid black;">Methods</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach(collect($samplingTimeRegulations)->pluck('parameter')->unique()->sortBy('id') as $parameter)
                        @php
                            $subject = optional($sampling->subject)->subject_type ?? 'unknown';
                            $resultKey = "{$sampling->id}|{$subject}|{$parameter->id}";
                            $resultData = $results->get($resultKey) ?? collect();
                            $regulationStandard = optional(
                                $samplingTimeRegulations->where('parameter_id', $parameter->id)->first()
                            )->regulationStandards;
                        @endphp
            
                        @if ($resultData->isNotEmpty())
                            <tr>
                                <td style="border: 1px solid black;">{{ $no++ }}</td>
                                <td style="border: 1px solid black; text-align: left;">{{ $parameter->name }}</td>
                                <td style="border: 1px solid black;">{{ $resultData->pluck('testing_result')->implode(', ') }}</td>
                                <td style="border: 1px solid black;">{{ $regulationStandard ? $regulationStandard->title : '-' }}</td>
                                <td style="border: 1px solid black;">{{ $parameter->unit ?? '-' }}</td>
                                <td style="border: 1px solid black; text-align: left;">{{ $parameter->method ?? '-' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
                <tr>
                    <td style="width: 100px;">Coordinate</td>
                    <td>: ...................................................</td>
                </tr>
                <tr>
                    <td>Velocity</td>
                    <td>: .................... <span style="margin-left: 10px;">m/s</span></td>
                </tr>
            </table>                    
        </div>
        {{-- End Parameters --}}
        {{-- Start Condition  --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            @php
                $stationaryFieldCondition = $fieldCondition->firstWhere('institute_subject_id', optional($instituteSubjects->firstWhere('subject.name', 'Stationary Stack Source Emission'))->id);
            @endphp
            @if($stationaryFieldCondition)
            <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Heat Stress Environment Condition </td>
                    <td style="width: 70%;">:</td>
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 30%;"></td>
                    <td style="width: 70%;"></td>
                </tr>
                @if ($stationaryFieldCondition?->coordinate)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Coordinate</td>
                    <td style="width: 70%;">: {{ $stationaryFieldCondition->coordinate }}</td>
                </tr>
                @endif

                @if ($stationaryFieldCondition?->temperature)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Temperature</td>
                    <td style="width: 70%;">: {{ $stationaryFieldCondition->temperature }} °C</td>
                </tr>
                @endif

                @if ($stationaryFieldCondition?->pressure)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Pressure</td>
                    <td style="width: 70%;">: {{ $stationaryFieldCondition->pressure }} mmHg</td>
                </tr>
                @endif

                @if ($stationaryFieldCondition?->humidity)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Humidity</td>
                    <td style="width: 70%;">: {{ $stationaryFieldCondition->humidity }} %RH</td>
                </tr>
                @endif

                @if ($stationaryFieldCondition?->wind_speed)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Speed</td>
                    <td style="width: 70%;">: {{ $stationaryFieldCondition->wind_speed }} m/s</td>
                </tr>
                @endif

                @if ($stationaryFieldCondition?->wind_direction)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Wind Direction</td>
                    <td style="width: 70%;">: {{ $stationaryFieldCondition->wind_direction }}</td>
                </tr>
                @endif

                @if ($stationaryFieldCondition?->weather)
                <tr style="line-height: 1;">
                    <td style="width: 30%;">Weather</td>
                    <td style="width: 70%;">: {{ $stationaryFieldCondition->weather }}</td>
                </tr>
                @endif
            </table>
            @endif
        </div>
        {{-- End Condition  --}}
        {{-- Start Notes and Regulation --}}
        <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
            <table style="font-size: 10px; margin: 0 auto;  border-collapse: collapse; text-align: left; width: 100%;">
                <tr style="line-height: 1;">
                    <td style="width: 10%; font-weight: bold;">Notes:</td>
                    {{-- <td style="width: 90%;">: Xxxxxx</td> --}}
                </tr>
                <tr style="line-height: 1;">
                    <td style="width: 0%;"> * </td>
                    <td style="width: 95%;">Accredited Parameters </td>
                </tr>
                @foreach ($regulations as $regulation)
                @if ($regulation->subject_id == 7)
                    <tr style="line-height: 1;">
                        <td style="width: 5%;">{{ $loop->count > 2 ? '***' : '**' }}</td>
                        <td style="width: 95%;">{{ $regulation->title ?? 'No Name Available' }}</td>
                    </tr>
                @endif
                @endforeach
            </table>
        </div>
        {{-- End Notes and Regulation --}}
    </div>
    @endif
    @endforeach
{{--============================================== END Stationary Stack Source Emission =====================================================--}}

</body>
</html>
