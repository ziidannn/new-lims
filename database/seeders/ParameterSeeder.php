<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
// --------------------------------------------S U J E C T  C O D E  0 1--------------------------------------------
            // Parameter 1
            [
                "id" => "1",
                "subject_id" => "1",
                "name" => "Sulfur Dioxide (SO₂)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-7:2017"
            ],
            // Parameter 2
            [
                "id" => "2",
                "subject_id" => "1",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            // Parameter 3
            [
                "id" => "3",
                "subject_id" => "1",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            // Parameter 4
            [
                "id" => "4",
                "subject_id" => "1",
                "name" => "Oxidant (Ox)* ",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            // Parameter 5
            [
                "id" => "5",
                "subject_id" => "1",
                "name" => "Hydrocarbon Non Methane (NMHC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            // Parameter 6
            [
                "id" => "6",
                "subject_id" => "1",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            // Parameter 7
            [
                "id" => "7",
                "subject_id" => "1",
                "name" => "PM10 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            // Parameter 8
            [
                "id" => "8",
                "subject_id" => "1",
                "name" => "PM2.5 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            // Parameter 9
            [
                "id" => "9",
                "subject_id" => "1",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
            // Parameter 10
            [
                "id" => "10",
                "subject_id" => "1",
                "name" => "Ammonia (NH3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.1-2005"
            ],
            // Parameter 11
            [
                "id" => "11",
                "subject_id" => "1",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "µg/Nm3",
                "method" => "IK-7.4.22 (Spectrophotometry)"
            ],
// --------------------------------------------S U J E C T  C O D E  0 2--------------------------------------------
            // Parameter 12
            [
                "id" => "12",
                "subject_id" => "2",
                "name" => "Temperature",
                "unit" => "°C",
                "method" => "Direct Reading"
            ],
            // Parameter 13
            [
                "id" => "13",
                "subject_id" => "2",
                "name" => "Relative Humidity (%RH)",
                "unit" => "%",
                "method" => "Direct Reading"
            ],
            // Parameter 14
            [
                "id" => "14",
                "subject_id" => "2",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "mg/m3 (PSD/KTD)",
                "method" => "IK-7.4.3 (Spectrophotometry)"
            ],
            // Parameter 15
            [
                "id" => "15",
                "subject_id" => "2",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "BDS",
                "method" => "IK-7.4.2 (Spectrophotometry)"
            ],
            // Parameter 16
            [
                "id" => "16",
                "subject_id" => "2",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/m3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            // Parameter 17
            [
                "id" => "17",
                "subject_id" => "2",
                "name" => "Ammonia (NH3)",
                "unit" => "BDS",
                "method" => "IK-7.4.1 (Spectrophotometry)"
            ],
            // Parameter 18
            [
                "id" => "18",
                "subject_id" => "2",
                "name" => "Oxidant (Ox)",
                "unit" => "BDS",
                "method" => "SNI 7119-8:2017"
            ],
            // Parameter 19
            [
                "id" => "19",
                "subject_id" => "2",
                "name" => "Hydrogen Sulfide (H2S)*",
                "unit" => "BDS",
                "method" => "SNI 8605:2018"
            ],
            // Parameter 20
            [
                "id" => "20",
                "subject_id" => "2",
                "name" => "Hydrocarbon (HC)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 21
            [
                "id" => "21",
                "subject_id" => "2",
                "name" => "Lead (Pb)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            // Parameter 22
            [
                "id" => "22",
                "subject_id" => "2",
                "name" => "Total Suspended Particulates (TSP) ",
                "unit" => "mg/m3",
                "method" => "SNI 16-7058-2004"
            ],
// --------------------------------------------S U J E C T  C O D E  0 3--------------------------------------------
            // Parameter 23
            [
                "id" => "23",
                "subject_id" => "3",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 8427:2017"
            ],
            // Parameter 24
            [
                "id" => "24",
                "subject_id" => "3",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 7231:2009"
            ],
// --------------------------------------------S U J E C T  C O D E  0 4--------------------------------------------
            // Parameter 25
            [
                "id" => "25",
                "subject_id" => "4",
                "name" => "Ethyl Acetate",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 26
            [
                "id" => "26",
                "subject_id" => "4",
                "name" => "Benzene",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 27
            [
                "id" => "27",
                "subject_id" => "4",
                "name" => "Toluene",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 28
            [
                "id" => "28",
                "subject_id" => "4",
                "name" => "Xylene",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 29
            [
                "id" => "29",
                "subject_id" => "4",
                "name" => "Methyl Ethyl Ketone (C4H8O)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 30
            [
                "id" => "30",
                "subject_id" => "4",
                "name" => "Aceton (C3H6O)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 31
            [
                "id" => "31",
                "subject_id" => "4",
                "name" => "Toluene (C7H8)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            // Parameter 32
            [
                "id" => "32",
                "subject_id" => "4",
                "name" => "Ammonia (NH3)*",
                "unit" => "ppm",
                "method" => "SNI 7119.1-2005"
            ],
            // Parameter 33
            [
                "id" => "33",
                "subject_id" => "4",
                "name" => "Methyl Mercaptan (CH3SH)",
                "unit" => "ppm",
                "method" => "NIOSH 2542"
            ],
            // Parameter 34
            [
                "id" => "34",
                "subject_id" => "4",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "ppm",
                "method" => "IK-7.4.22 (Spectrophotometry)"
            ],
            // Parameter 35
            [
                "id" => "35",
                "subject_id" => "4",
                "name" => "Methyl Sulfide ((CH3)2)S",
                "unit" => "ppm",
                "method" => "OSHA PV2210"
            ],
            // Parameter 36
            [
                "id" => "36",
                "subject_id" => "4",
                "name" => "Styrene (C6H5CHCH2)",
                "unit" => "ppm",
                "method" => "Gas Chromatography"
            ],
// --------------------------------------------S U J E C T  C O D E  0 5--------------------------------------------
            // Parameter 37
            [
                "id" => "37",
                "subject_id" => "5",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
            // Parameter 38
            [
                "id" => "38",
                "subject_id" => "5",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
            // Parameter 39
            [
                "id" => "39",
                "subject_id" => "5",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
// --------------------------------------------S U J E C T  C O D E  0 6--------------------------------------------
// --------------------------------------------S U J E C T  C O D E  0 7--------------------------------------------
            // Parameter 40
            [
                "id" => "40",
                "subject_id" => "7",
                "name" => "Parameters",
                "unit" => "Unit",
                "method" => "Methods"
            ],
            // Parameter 41
            [
                "id" => "41",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/m3",
                "method" => "SNI 7117.17:2009"
            ],
            // Parameter 42
            [
                "id" => "42",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/m3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 43
            [
                "id" => "43",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)",
                "unit" => "mg/m3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 44
            [
                "id" => "44",
                "subject_id" => "7",
                "name" => "Opacity",
                "unit" => "%",
                "method" => "SNI 19-7117.11-2005"
            ],
            // Parameter 45
            [
                "id" => "45",
                "subject_id" => "7",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/m3",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 46
            [
                "id" => "46",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/m3",
                "method" => "SNI 7117.17:2009"
            ],
            // Parameter 47
            [
                "id" => "47",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/m3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 48
            [
                "id" => "48",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)",
                "unit" => "mg/m3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 49
            [
                "id" => "49",
                "subject_id" => "7",
                "name" => "Opacity",
                "unit" => "%",
                "method" => "SNI 19-7117.11-2005"
            ],
            // Parameter 50
            [
                "id" => "50",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 51
            [
                "id" => "51",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/m3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 52
            [
                "id" => "52",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)",
                "unit" => "mg/m3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 53
            [
                "id" => "53",
                "subject_id" => "7",
                "name" => "Hydrogen Chloride (HCl)*",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.8-2005"
            ],
            // Parameter 54
            [
                "id" => "54",
                "subject_id" => "7",
                "name" => "Chlorine (Cl2)*",
                "unit" => "mg/m3",
                "method" => "IK.7.4.25 (Spectrophotometry)"
            ],
            // Parameter 55
            [
                "id" => "55",
                "subject_id" => "7",
                "name" => "Ammonia (NH3)*",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.6-2005"
            ],
            // Parameter 56
            [
                "id" => "56",
                "subject_id" => "7",
                "name" => "Hydrogen Fluoride (HF)",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.9-2005"
            ],
            // Parameter 57
            [
                "id" => "57",
                "subject_id" => "7",
                "name" => "Opacity",
                "unit" => "%",
                "method" => "SNI 19-7117.11-2005"
            ],
            // Parameter 58
            [
                "id" => "58",
                "subject_id" => "7",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "mg/m3",
                "method" => "SNI 06-7117.7-2005"
            ],
            // Parameter 59
            [
                "id" => "59",
                "subject_id" => "7",
                "name" => "Mercury (Hg)",
                "unit" => "mg/m3",
                "method" => "Atomic Fluorescence Spectrophotometry"
            ],
            // Parameter 60
            [
                "id" => "60",
                "subject_id" => "7",
                "name" => "Arsenic (As)",
                "unit" => "mg/m3",
                "method" => "Atomic Fluorescence Spectrophotometry"
            ],
            // Parameter 61
            [
                "id" => "61",
                "subject_id" => "7",
                "name" => "Antimony (Sb)",
                "unit" => "mg/m3",
                "method" => "Atomic Fluorescence Spectrophotometry"
            ],
            // Parameter 62
            [
                "id" => "62",
                "subject_id" => "7",
                "name" => "Cadmium (Cd)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            // Parameter 63
            [
                "id" => "63",
                "subject_id" => "7",
                "name" => "Zinc (Zn)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            // Parameter 64
            [
                "id" => "64",
                "subject_id" => "7",
                "name" => "Lead (Pb)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            // Parameter 65
            [
                "id" => "65",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/m3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 66
            [
                "id" => "66",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)",
                "unit" => "mg/m3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 67
            [
                "id" => "67",
                "subject_id" => "7",
                "name" => "Particulate*",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 68
            [
                "id" => "68",
                "subject_id" => "7",
                "name" => "Ammonia (NH3)*",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.6-2005"
            ],
            // Parameter 69
            [
                "id" => "69",
                "subject_id" => "7",
                "name" => "Chlorine (Cl2)*",
                "unit" => "mg/m3",
                "method" => "IK.7.4.25 (Spectrophotometry)"
            ],
            // Parameter 70
            [
                "id" => "70",
                "subject_id" => "7",
                "name" => "Hydrogen Chloride (HCl)*",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.8-2005"
            ],
            // Parameter 71
            [
                "id" => "71",
                "subject_id" => "7",
                "name" => "Hydrogen Fluoride (HF)",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.9-2005"
            ],
            // Parameter 72
            [
                "id" => "72",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)",
                "unit" => "mg/m3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 73
            [
                "id" => "73",
                "subject_id" => "7",
                "name" => "Opacity",
                "unit" => "%",
                "method" => "SNI 19-7117.11-2005"
            ],
            // Parameter 74
            [
                "id" => "74",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 75
            [
                "id" => "75",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/m3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 76
            [
                "id" => "76",
                "subject_id" => "7",
                "name" => "Total Lead (Pb)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            // Parameter 77
            [
                "id" => "77",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 78
            [
                "id" => "78",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NOx)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 79
            [
                "id" => "79",
                "subject_id" => "7",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/Nm3",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 80
            [
                "id" => "80",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/Nm3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 81
            [
                "id" => "81",
                "subject_id" => "7",
                "name" => "Opacity",
                "unit" => "%",
                "method" => "SNI 19-7117.11-2005"
            ],
            // Parameter 82
            [
                "id" => "82",
                "subject_id" => "7",
                "name" => "Nitrogen Oxides (NOx)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 83
            [
                "id" => "83",
                "subject_id" => "7",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/Nm3",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 84
            [
                "id" => "84",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 85
            [
                "id" => "85",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/Nm3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 86
            [
                "id" => "86",
                "subject_id" => "7",
                "name" => "Oxygen (O2)*",
                "unit" => "%",
                "method" => "SNI 19-7117.10-2005"
            ],
            // Parameter 87
            [
                "id" => "87",
                "subject_id" => "7",
                "name" => "Percent (%) of Isokinetic*",
                "unit" => "%",
                "method" => "SNI 7117.17-2009"
            ],
            // Parameter 88
            [
                "id" => "88",
                "subject_id" => "7",
                "name" => "Volumetric Flow Rate*",
                "unit" => "m3/s",
                "method" => "SNI 7117.14-2009"
            ],
            // Parameter 89
            [
                "id" => "89",
                "subject_id" => "7",
                "name" => "Number Of Traverse Point*",
                "unit" => "-",
                "method" => "SNI 7117.13-2009"
            ],
            // Parameter 90
            [
                "id" => "90",
                "subject_id" => "7",
                "name" => "Nitrogen Oxides (NOx)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 91
            [
                "id" => "91",
                "subject_id" => "7",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/Nm3",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 92
            [
                "id" => "92",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 93
            [
                "id" => "93",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/Nm3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 94
            [
                "id" => "94",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/Nm3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 95
            [
                "id" => "95",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 96
            [
                "id" => "96",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 97
            [
                "id" => "97",
                "subject_id" => "7",
                "name" => "Opacity",
                "unit" => "%",
                "method" => "SNI 19-7117.11-2005"
            ],
            // Parameter 98
            [
                "id" => "98",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NOx)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 99
            [
                "id" => "99",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/Nm3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 100
            [
                "id" => "100",
                "subject_id" => "7",
                "name" => "Nitrogen Oxide (NOx)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 101
            [
                "id" => "101",
                "subject_id" => "7",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/Nm3",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 102
            [
                "id" => "102",
                "subject_id" => "7",
                "name" => "Oxygen (O2)*",
                "unit" => "%",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 103
            [
                "id" => "103",
                "subject_id" => "7",
                "name" => "Nitrogen Oxide (NOx)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.18 (Direct Reading)"
            ],
            // Parameter 104
            [
                "id" => "104",
                "subject_id" => "7",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/Nm3",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 105
            [
                "id" => "105",
                "subject_id" => "7",
                "name" => "Particulate*",
                "unit" => "mg/Nm3",
                "method" => "SNI 7117.17:2009"
            ],
            // Parameter 106
            [
                "id" => "106",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO2)*",
                "unit" => "mg/Nm3",
                "method" => "IK–6.4.19 (Direct Reading)"
            ],
            // Parameter 107
            [
                "id" => "107",
                "subject_id" => "7",
                "name" => "Particulate*",
                "unit" => "mg/m3",
                "method" => "SNI 7117.17:2009"
            ],
            // Parameter 108
            [
                "id" => "108",
                "subject_id" => "7",
                "name" => "Oxygen (O2)*",
                "unit" => "%",
                "method" => "SNI 19.7117.10-2005"
            ],
            // Parameter 109
            [
                "id" => "109",
                "subject_id" => "7",
                "name" => "Percent (%) of Isokinetic*",
                "unit" => "%",
                "method" => "SNI 7117.17-2009"
            ],
            // Parameter 110
            [
                "id" => "110",
                "subject_id" => "7",
                "name" => "Volumetric Flow Rate*",
                "unit" => "m3/s",
                "method" => "SNI 7117.14-2009"
            ],
            // Parameter 111
            [
                "id" => "111",
                "subject_id" => "7",
                "name" => "Number Of Traverse Point*",
                "unit" => "-",
                "method" => "SNI 7117.13-2009"
            ],
        ];

        foreach ($data as $x) {
            if(!Parameter::where('id', $x['id'])->first()){
                $m = new Parameter();
                $m->id = $x['id'];
                $m->subject_id = $x['subject_id'];
                $m->name = $x['name'];
                $m->unit = $x['unit'];
                $m->method = $x['method'];
                $m->save();
            }
        }
    }
}
