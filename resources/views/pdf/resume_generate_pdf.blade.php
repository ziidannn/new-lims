<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nama Institusi</title>
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
    </style>
</head>
<body>
<header >
    <div style="width: 100%;">
        <div align="left" style="width: 50%;float: left;">
            <img src="assets/img/company_profile/logo/logo.png" alt="" width="150px">
        </div>
        <div align="right" style="width: 50%; float: right;">
            <div>
                <img src="assets/img/kan.png" alt="" width="100px" style="float: right;">
                <div style="clear: right;"></div>
                <p style="font-size: 9px; font-weight: bold; text-align:right; margin: -5px;">SK-KLHK No 00161/LPJ/Labling-1/LRK/KLHK</p>
                <p style="font-size: 8px; text-align: margin: -5px; right;">7.8.1/DIL/VII/2018/FORM REV . 2</p>
                <p style="font-size: 8px; text-align: margin: -5px; right;">Page {PAGENO} of {nbpg}</p>
            </div>
        </div>
    </div>  
</header>
{{-- End Header --}}
{{-- <style>
    body {
        margin-top: 120px; /* Adjusted margin-top to reduce the gap */
        margin-bottom: 90px;
    }
</style> --}}
{{-- Footer --}}
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
    <div class="text-center" style="font-size: 12px; margin-left: 90px; margin-top: -10px;">Certificate No.</div>
</div>
<div class="col-xs-110" style="margin-top: 10px; margin-left: 70px;">
    <table class="mt-2 table" style="font-size: 12px;">
        <tr>
            <td width="150px">Customer</td>
            <td>:</td>
            <td colspan="2" width="150px" style="font-weight: bold;"></td>
        </tr>
        <tr>
            <td>Address</td>
            <td>:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Contact Name</td>
            <td>:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td colspan="2"><a href="mailto:" style="color: blue; text-decoration: underline;"></a></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>:</td>
            <td colspan="2">+62</td>
        </tr>
        <tr>
            <td>Subject</td>
            <td>:</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Sample taken by</td>
            <td>:</td>
            <td colspan="2">PT. Delta Indonesia Laboratory</td>
        </tr>
        <tr>
            <td>Sample Receive Date</td>
            <td>:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="padding-right: 50px;">Sample Analysis Date</td>
            <td style="padding-right: 10px;">:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Report Date</td>
            <td>:</td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>
<div style="width: 100%; margin-top: 50px;">
    <div align="left" style="width: 50%;float: left;"></div>
    <div style="width: 50%; float: right;">
        <div style="text-align: right;">
            <p style="font-size: 12px;">This Certificate of Analysis consist of {nb} pages</p>
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
        <div class="text-center" style="font-size: 12px; margin-left: 90px; margin-top: -10px;">Certificate No.</div>
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
                <td style="border: 1px solid;">001</td>
                <td style="border: 1px solid;">Location A</td>
                <td style="border: 1px solid;">Ambient Air</td>
                <td style="border: 1px solid;">2023-01-01</td>
                <td style="border: 1px solid;">10:00 AM</td>
                <td style="border: 1px solid;">Grab / 42 Hours</td>
                <td style="border: 1px solid;">2023-01-02</td>
                <td style="border: 1px solid;">January 20, 2025<br>  to<br>   February 04, 2025</td>
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
            <tr>
                <td style="border: 1px solid;">1</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">2</td>
                <td style="border: 1px solid;">Carbon Monoxide (CO)*</td>
                <td style="border: 1px solid;">1 Hours<br>8 Hours</td>
                <td style="border: 1px solid;"> < 1437<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">3</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">4</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">5</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">6</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">7</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">8</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            <tr>
                <td style="border: 1px solid;">9</td>
                <td style="border: 1px solid;">Sulphur Dioxide (SO2)*</td>
                <td style="border: 1px solid;">1 Hours<br>24 Hours<br>1 Year</td>
                <td style="border: 1px solid;">< 0.22<br>-<br>-</td>
                <td style="border: 1px solid;">150<br>75<br>45</td>
                <td style="border: 1px solid;">µg/m3</td>
                <td style="border: 1px solid;">SNI 7119-7:2017</td>
            </tr>
            
        </table>
    </div>
    {{-- End Parameters --}}
    {{-- Start Condition  --}}
    <div class="" style="margin-top: 3px;"> <!-- Adjusted margin-top to add space between the title and the table -->
        <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: left; width: 100%;">
            <tr style="line-height: 1;">
                <td style="width: 30%;">Ambient Environmental Condition</td>
                <td style="width: 70%;">: Xxxxxx</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Coordinate</td>
                <td style="width: 70%;">: Xxxxxx</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Temperature</td>
                <td style="width: 70%;">: Xxxxxx °C</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Pressure</td>
                <td style="width: 70%;">: Xxxxxx mmHg</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Humidity</td>
                <td style="width: 70%;">: Xxxxxx %RH</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Wind Speed</td>
                <td style="width: 70%;">: Xxxxxx m/s</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Wind Direction</td>
                <td style="width: 70%;">: Xxxxxx</td>
            </tr>
            <tr style="line-height: 1;">
                <td style="width: 30%;">Weather</td>
                <td style="width: 70%;">: Xxxxxx</td>
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
            <tr style="line-height: 1;">
                <td style="width: 0%;">**</td>
                <td style="width: 95%;">Govemment Regulation of Republic Indonesia No.22 of 2021 Regarding Implementation of Environmental 
Protection and Management Appendix VII</td>
            </tr>
        </table>
    </div>
    {{-- End Notes and Regulation --}}
</div>
{{-- End Ambient Air --}}
{{-- Start Noise* --}}
<div class="page_break"></div>
<div>
    <div class="text-center certificate-container" style="margin-top: 20px;">
        <p class="certificate-title">CERTIFICATE OF ANALYSIS (COA)</p>
        <div class="text-center" style="font-size: 12px; margin-left: 90px; margin-top: -10px;">Certificate No.</div>
    </div>
    <div style="margin-top: 15px;"> <!-- Adjusted margin-top to add space between the title and the table -->
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
                <td style="border: 1px solid;">001</td>
                <td style="border: 1px solid;">Noise*</td>
                <td style="border: 1px solid;">Description A</td>
                <td style="border: 1px solid;">January 17,<br> 2025</td>
                <td style="border: 1px solid;">(See Table)</td>
                <td style="border: 1px solid;">24 Hours</td>
                <td style="border: 1px solid;">January 20,<br> 2025</td>
                <td style="border: 1px solid;">January 20, 2025<br>  to<br>   February 04, 2025</td>
            </tr>
        </table>
    </div>
    {{-- Start Parameters --}}
    <div style="margin-top: 20px;">
        <table style="font-size: 10px; margin: 0 auto; border: 1px solid black; border-collapse: collapse; text-align: center; width: 100%;">
            <tr>
                <td style="border: 1px solid; font-weight: bold;">NO</td>
                <td style="border: 1px solid; font-weight: bold;">Sampling Location</td>
                <td style="border: 1px solid; font-weight: bold;">Noise</td>
                <td style="border: 1px solid; font-weight: bold;">Time</td>
                <td style="border: 1px solid; font-weight: bold;">Leq</td>
                <td style="border: 1px solid; font-weight: bold;">Ls</td>
                <td style="border: 1px solid; font-weight: bold;">Lm</td>
                <td style="border: 1px solid; font-weight: bold;">Lsm</td>
                <td style="border: 1px solid; font-weight: bold;">Regulatory<br> Standard**</td>
                <td style="border: 1px solid; font-weight: bold;">Unit</td>
                <td style="border: 1px solid; font-weight: bold;">Methods</td>
            </tr>    
            <tr>
                <td style="border: 1px solid;">1</td>
                <td style="border: 1px solid;">Upwind <br>S 6* 23"15.56 <br>E  6* 23"15.56 </td>
                <td style="border: 1px solid;">L2<br> L2<br> L3<br> L4<br> L5<br> L6<br> L7<br></td>
                <td style="border: 1px solid;">07.13<br>08.00<br>09.30<br>10.45<br>12.00<br>13.15<br>14.30<br></td>
                <td style="border: 1px solid;">78.12<br>80.45<br>82.30<br>79.50<br>81.20<br>77.90<br>83.10<br></td>
                <td style="border: 1px solid;">65,4</td>
                <td style="border: 1px solid;">59,4</td>
                <td style="border: 1px solid;">64,2</td>
                <td style="border: 1px solid;">70</td>
                <td style="border: 1px solid;">dBA</td>
                <td style="border: 1px solid;">SNI 8427:2017</td>
            </tr>
        </table>
    </div>
    {{-- End Parameters --}}
</div>
{{-- End Noise* --}}
</body>
</html>
