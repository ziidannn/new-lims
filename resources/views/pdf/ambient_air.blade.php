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
    <header>
        <div style="width: 100%;">
            <div align="left" style="width: 50%; float: left;">
                <img src="{{ public_path('assets/img/company_profile/logo/logo.png') }}" alt="" width="150px">
            </div>
            <div align="right" style="width: 50%; float: right;">
                <div>
                    <img src="{{ public_path('assets/img/kan.png') }}" alt="" width="100px" style="float: right;">
                    <div style="clear: right;"></div>
                    <p style="font-size: 9px; font-weight: bold; text-align:right; margin: -5px;">
                        SK-KLHK No 00161/LPJ/Labling-1/LRK/KLHK
                    </p>
                    <p style="font-size: 8px; text-align:right; margin: -5px;">
                        7.8.1/DIL/VII/2018/FORM REV . 2
                    </p>
                    <p style="font-size: 8px; text-align:right; margin: -5px;">
                        Page {PAGENO} of {nbpg}
                    </p>
                </div>
            </div>
        </div>  
    </header>
<footer>
    <div style="text-align: left; padding-bottom: -5px; margin-bottom: 10;">
        <p style="font-size: 8px; margin: -5; font-weight: bold;">Ruko Prima Orchard No.C 2</p>
        <p style="font-size: 8px; margin: -5; font-weight: bold;"> Prima Harapan Regency Bekasi Utara,</p>
        <p style="font-size: 8px; margin: -5; font-weight: bold;"> Kota bekasi 17123, Provinsi Jawa Barat</p>
        <p style="font-size: 8px; margin: -5; font-weight: bold;"> Telp: 021-88382018<br></p>
        <p style="font-size: 8px; margin: -5; color: blue"><a style="text-decoration: underline;">www.deltaindonesialab.com </a></p>
    </div>
    <table style="margin: 0 auto;">
        <tr>
            <td colspan="2" style="font-size: 8px; text-align: center;">*This result (s) relate only to the sample (s) tested and the test report/certificate shall not be reproduced except in full, without written approval of PT Delta Indonesia Laboratory</td>
        </tr>
    </table>    
</footer>
{{-- End Footer --}}
<div class="text-center certificate-container" style="margin-top: 45px;">
    <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
    <div class="text-center" style="font-size: 12px; margin-left: 90px; margin-top: -10px;">Certificate No. {{ $institute->no_coa ?? 'N/A' }}</div>
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
            <td colspan="2">{{ \Carbon\Carbon::parse($institute->sample_receive_date)->format('F d, Y') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="padding-right: 50px;">Sample Analysis Date</td>
            <td style="padding-right: 10px;">:</td>
            <td colspan="2">{{ \Carbon\Carbon::parse($institute->sample_analysis_date)->format('F d, Y') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Report Date</td>
            <td>:</td>
            <td colspan="2">{{ \Carbon\Carbon::parse($institute->report_date)->format('F d, Y') ?? 'N/A' }}</td>
        </tr>
    </table>
</div>
    
<div style="width: 100%; margin-top: 50px;">
    <div align="left" style="width: 50%;float: left;"></div>
    <div style="width: 50%; float: right;">
        <div style="text-align: right;">
            <p style="font-size: 12px;">yyzzzz</p>
            <p style="font-size: 12px;">Bekasi, </p>
            <img src="assets/img/company_profile/stamp/cap_dil.png" alt="" width="150px" height="100px">
            <br>
            <p style="font-size: 12px; font-weight: bold; text-decoration: underline; margin-bottom: -2px;"></p>
            <p style="font-size: 12px; font-weight: bold; margin-right: 40px;">President Director</p>
        </div>
    </div>
</div>
{{-- End Resume --}}
{{-- Ambient Air --}}
<div class="page_break"></div>
<div>
    <div class="text-center certificate-container" style="margin-top: 20px;">
        <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
        <div class="text-center" style="font-size: 12px; margin-left: 90px; margin-top: -10px;">Certificate No. {{ $institute->no_coa ?? 'N/A' }}</div>
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
                    @foreach($samplings as $sampling)
                    <td style="border: 1px solid;">{{ $sampling->no_sample ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_location ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $instituteSubjects->where('id', $sampling->institute_subject_id)->first()->subject->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->sampling_date)->format('F d, Y') ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_time ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ $sampling->sampling_method ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->date_received)->format('F d, Y') ?? 'N/A' }}</td>
                    <td style="border: 1px solid;">{{ \Carbon\Carbon::parse($sampling->itd_start)->format('F d, Y') ?? 'N/A' }} <br> to 
                                                <br>{{ \Carbon\Carbon::parse($sampling->itd_end)->format('F d, Y')  ?? 'N/A' }}</td>
                    @endforeach
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
        
            @php 
                $counter = 1; // Nomor tetap seperti sebelumnya
            @endphp
        
            @foreach(collect($samplingTimeRegulations)->pluck('parameter')->unique()->sortBy('id') as $parameter)
                @php
                    $samplingTimes = $samplingTimeRegulations->where('parameter_id', $parameter->id);
                    $rowspan = $samplingTimes->count();
                    $firstRow = true;
                @endphp
        
                @foreach ($samplingTimes as $samplingTime)
                    @php
                        $resultKey = "{$parameter->id}-{$samplingTime->samplingTime->id}";
                        $resultData = $results->get($resultKey)?->first();
                        $regulationStandard = $samplingTime->regulationStandards ?? null;
                    @endphp
                    <tr>
                        @if ($firstRow)
                            <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $counter }}</td>
                            <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $parameter->name }}</td>
                        @endif
                        <td style="border: 1px solid;">{{ $samplingTime->samplingTime->time }}</td>
                        <td style="border: 1px solid;">{{ $resultData ? $resultData->testing_result : '-' }}</td>
                        <td style="border: 1px solid;">{{ $regulationStandard ? $regulationStandard->title : '-' }}</td>
                        @if ($firstRow)
                            <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $parameter->unit ?? '-' }}</td>
                            <td style="border: 1px solid;" rowspan="{{ $rowspan }}">{{ $parameter->method ?? '-' }}</td>
                        @endif
                    </tr>
                    @php 
                        $firstRow = false; 
                    @endphp
                @endforeach
        
                @php 
                    $counter++; // Tetap seperti sebelumnya
                @endphp
            @endforeach
        </table>
        
        
    </div>
    {{-- End Parameters --}}
    {{-- Start Condition  --}}
    <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
        <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
            <tr style="line-height: 1;">
                <td style="width: 30%;">Ambient Environmental Condition</td>
                <td style="width: 70%;"></td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Coordinate</td>
                <td style="width: 70%;">: {{ $fieldCondition->coordinate ?? 'N/A' }}</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Temperature</td>
                <td style="width: 70%;">: {{ $fieldCondition->temperature ?? 'N/A' }} °C</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Pressure</td>
                <td style="width: 70%;">: {{ $fieldCondition->pressure ?? 'N/A' }} mmHg</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Humidity</td>
                <td style="width: 70%;">: {{ $fieldCondition->humidity ?? 'N/A' }} %RH</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Wind Speed</td>
                <td style="width: 70%;">: {{ $fieldCondition->wind_speed ?? 'N/A' }} m/s</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Wind Direction</td>
                <td style="width: 70%;">: {{ $fieldCondition->wind_direction ?? 'N/A' }}</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Weather</td>
                <td style="width: 70%;">: {{ $fieldCondition->weather ?? 'N/A' }}</td>
            </tr>
        </table>
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
            @foreach ($parameters as $parameter)
            <tr style="line-height: 1;">
                <td style="width: 5%;">{{ $loop->iteration }}</td> 
                <td style="width: 95%;">{{ $parameter->title }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    {{-- End Notes and Regulation --}}
</div>
{{-- End Ambient Air --}}
</body>
</html>
