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
            [
                "id" => "37",
                "subject_id" => "5",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
            [
                "id" => "38",
                "subject_id" => "5",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
            [
                "id" => "39",
                "subject_id" => "5",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],

            // Parameter 40
            [
                "id" => "40",
                "subject_id" => "7",
                "name" => "Sulfur Dioxide (SO₂)*",
                "unit" => "mg/m3",
                "method" => "IK-6.4.19 (Direct Reading)"
            ],
            // Parameter 41
            [
                "id" => "41",
                "subject_id" => "7",
                "name" => "Particulate",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.12-2005"
            ],
            // Parameter 3
            [
                "id" => "42",
                "subject_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "mg/m3",
                "method" => "IK-6.4.18 (Direct Reading)"
            ],
            // Parameter 4
            [
                "id" => "43",
                "subject_id" => "7",
                "name" => "Hydrogen Chloride (HCl)*",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.8-2005"
            ],
            // Parameter 5
            [
                "id" => "44",
                "subject_id" => "7",
                "name" => "Chlorine (Cl2)*",
                "unit" => "mg/m3",
                "method" => "IK.7.4.25 (Spectrophotometry)"
            ],
            [
                "id" => "45",
                "subject_id" => "7",
                "name" => "Ammonia (NH3)*",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.6-2005"
            ],
            [
                "id" => "46",
                "subject_id" => "7",
                "name" => "Hydrogen Fluoride (HF)",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.9-2005"
            ],
            [
                "id" => "47",
                "subject_id" => "7",
                "name" => "Opacity",
                "unit" => "mg/m3",
                "method" => "SNI 19-7117.11-2005"
            ],
            [
                "id" => "48",
                "subject_id" => "7",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "mg/m3",
                "method" => "SNI 06-7117.7-2005"
            ],
            [
                "id" => "49",
                "subject_id" => "7",
                "name" => "Mercury (Hg)",
                "unit" => "mg/m3",
                "method" => "Atomic Fluorescence Spectrophotometry"
            ],
            [
                "id" => "50",
                "subject_id" => "7",
                "name" => "Arsenic (As)",
                "unit" => "mg/m3",
                "method" => "Atomic Fluorescence Spectrophotometry"
            ],
            [
                "id" => "51",
                "subject_id" => "7",
                "name" => "Antimony (Sb)",
                "unit" => "mg/m3",
                "method" => "Atomic Fluorescence Spectrophotometry"
            ],
            [
                "id" => "52",
                "subject_id" => "7",
                "name" => "Cadmium (Cd)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "53",
                "subject_id" => "7",
                "name" => "Zinc (Zn)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "54",
                "subject_id" => "7",
                "name" => "Lead (Pb)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
//             // Parameter for Regulation code 011
//             [
//                 "id" => "1",
//                 "regulation_id" => "1",
//                 "name" => "Sulfur Dioxide (SO₂)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-7:2017"
//             ],
//             [
//                 "id" => "2",
//                 "regulation_id" => "1",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "3",
//                 "regulation_id" => "1",
//                 "name" => "Nitrogen Dioxide (NO₂)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "4",
//                 "regulation_id" => "1",
//                 "name" => "Oxidant (Ox)* ",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "5",
//                 "regulation_id" => "1",
//                 "name" => "Hydrocarbon Non Methane (NMHC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "6",
//                 "regulation_id" => "1",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "7",
//                 "regulation_id" => "1",
//                 "name" => "PM10 (Particulate Matters)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "8",
//                 "regulation_id" => "1",
//                 "name" => "PM2.5 (Particulate Matters)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "9",
//                 "regulation_id" => "1",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
// // Parameter for Regulation code 012
//             [
//                 "id" => "10",
//                 "regulation_id" => "2",
//                 "name" => "Sulfur Dioxide (SO₂)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-7:2017"
//             ],
//             [
//                 "id" => "11",
//                 "regulation_id" => "2",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "12",
//                 "regulation_id" => "2",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "13",
//                 "regulation_id" => "2",
//                 "name" => "Oxidant (Ox)* ",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "14",
//                 "regulation_id" => "2",
//                 "name" => "Hydrocarbon Non Methane (NMHC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "15",
//                 "regulation_id" => "2",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "16",
//                 "regulation_id" => "2",
//                 "name" => "PM10 (Particulate Matters)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "17",
//                 "regulation_id" => "2",
//                 "name" => "PM2.5 (Particulate Matters)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "18",
//                 "regulation_id" => "2",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
// // Parameter for Regulation code 013
//             [
//                 "id" => "19",
//                 "regulation_id" => "3",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "20",
//                 "regulation_id" => "3",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "21",
//                 "regulation_id" => "3",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "22",
//                 "regulation_id" => "3",
//                 "name" => "Oxidant (Ox)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "23",
//                 "regulation_id" => "3",
//                 "name" => "Hydrocarbon Non Methane (NMHC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "24",
//                 "regulation_id" => "3",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "25",
//                 "regulation_id" => "3",
//                 "name" => "PM10 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "26",
//                 "regulation_id" => "3",
//                 "name" => "PM2.5 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "27",
//                 "regulation_id" => "3",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
//             [
//                 "id" => "28",
//                 "regulation_id" => "3",
//                 "name" => "Ammonia (NH3)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.1-2005"
//             ],
//             [
//                 "id" => "29",
//                 "regulation_id" => "3",
//                 "name" => "Hydrogen Sulfide (H2S)",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK-7.4.22(Spectrophotometry)"
//             ],
// // Parameter for Regulation code 014
//             [
//                 "id" => "30",
//                 "regulation_id" => "4",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "31",
//                 "regulation_id" => "4",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "32",
//                 "regulation_id" => "4",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "33",
//                 "regulation_id" => "4",
//                 "name" => "Oxidant (Ox)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "34",
//                 "regulation_id" => "4",
//                 "name" => "Hydrocarbon Non Methane (NMHC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "35",
//                 "regulation_id" => "4",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "36",
//                 "regulation_id" => "4",
//                 "name" => "PM10 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "37",
//                 "regulation_id" => "4",
//                 "name" => "PM2.5 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "38",
//                 "regulation_id" => "4",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
//             [
//                 "id" => "39",
//                 "regulation_id" => "4",
//                 "name" => "Ammonia (NH3)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.1-2005"
//             ],
//             [
//                 "id" => "40",
//                 "regulation_id" => "4",
//                 "name" => "Hydrogen Sulfide (H2S)",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK-7.4.22(Spectrophotometry)"
//             ],
// // Parameter for Regulation code 015
//             [
//                 "id" => "41",
//                 "regulation_id" => "5",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "42",
//                 "regulation_id" => "5",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "43",
//                 "regulation_id" => "5",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-7:2017"
//             ],
//             [
//                 "id" => "44",
//                 "regulation_id" => "5",
//                 "name" => "Hydrogen Sulfide (H2S)",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK-7.4.22 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "45",
//                 "regulation_id" => "5",
//                 "name" => "Hydrocarbon (HC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "46",
//                 "regulation_id" => "5",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "47",
//                 "regulation_id" => "5",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
//             [
//                 "id" => "48",
//                 "regulation_id" => "5",
//                 "name" => "Ammonia (NH3)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.1-2005"
//             ],
//             [
//                 "id" => "49",
//                 "regulation_id" => "5",
//                 "name" => "Oxidant (Ox)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
// // Parameter for Regulation code 016
//             [
//                 "id" => "50",
//                 "regulation_id" => "6",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-7:2017"
//             ],
//             [
//                 "id" => "51",
//                 "regulation_id" => "6",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "52",
//                 "regulation_id" => "6",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "53",
//                 "regulation_id" => "6",
//                 "name" => "Oxidant (O3)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "54",
//                 "regulation_id" => "6",
//                 "name" => "Hydrocarbon (HC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "55",
//                 "regulation_id" => "6",
//                 "name" => "PM10 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "56",
//                 "regulation_id" => "6",
//                 "name" => "PM2.5 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "57",
//                 "regulation_id" => "6",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "58",
//                 "regulation_id" => "6",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
// // Parameter for Regulation code 017
//             [
//                 "id" => "59",
//                 "regulation_id" => "7",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-7:2017"
//             ],
//             [
//                 "id" => "60",
//                 "regulation_id" => "7",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "61",
//                 "regulation_id" => "7",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "62",
//                 "regulation_id" => "7",
//                 "name" => "Oxidant (O3)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "63",
//                 "regulation_id" => "7",
//                 "name" => "Hydrocarbon (HC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "64",
//                 "regulation_id" => "7",
//                 "name" => "PM10 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "65",
//                 "regulation_id" => "7",
//                 "name" => "PM2.5 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "66",
//                 "regulation_id" => "7",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "67",
//                 "regulation_id" => "7",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
// // Parameter for Regulation code 018
//             [
//                 "id" => "68",
//                 "regulation_id" => "8",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-7:2017"
//             ],
//             [
//                 "id" => "69",
//                 "regulation_id" => "8",
//                 "name" => "Carbon Monoxide (CO)* ",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "70",
//                 "regulation_id" => "8",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.2-2005"
//             ],
//             [
//                 "id" => "71",
//                 "regulation_id" => "8",
//                 "name" => "Oxidant (O3)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "72",
//                 "regulation_id" => "8",
//                 "name" => "Hydrocarbon (HC)",
//                 "unit" => "µg/Nm3",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "73",
//                 "regulation_id" => "8",
//                 "name" => "PM10 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "74",
//                 "regulation_id" => "8",
//                 "name" => "PM2.5 (Particulate Matters) ",
//                 "unit" => "µg/Nm3",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "75",
//                 "regulation_id" => "8",
//                 "name" => "Total Suspended Particulates (TSP)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 7119.3:2017"
//             ],
//             [
//                 "id" => "76",
//                 "regulation_id" => "8",
//                 "name" => "Lead (Pb)",
//                 "unit" => "µg/Nm3",
//                 "method" => "ICP-OES"
//             ],
//             [
//                 "id" => "77",
//                 "regulation_id" => "8",
//                 "name" => "Ammonia (NH3)*",
//                 "unit" => "µg/Nm3",
//                 "method" => "SNI 19-7119.1-2005"
//             ],
//             [
//                 "id" => "78",
//                 "regulation_id" => "8",
//                 "name" => "Hydrogen Sulfide (H2S)",
//                 "unit" => "µg/Nm3",
//                 "method" => "IK-7.4.22 (Spectrophotometry)"
//             ],
// // Parameter for Regulation code 021
//             [
//                 "id" => "79",
//                 "regulation_id" => "9",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "mg/m3 (PSD/KTD)",
//                 "method" => "IK-7.4.3 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "80",
//                 "regulation_id" => "9",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "BDS",
//                 "method" => "IK-7.4.2 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "81",
//                 "regulation_id" => "9",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "mg/m3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "82",
//                 "regulation_id" => "9",
//                 "name" => "Ammonia (NH3)",
//                 "unit" => "BDS",
//                 "method" => "IK-7.4.1 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "83",
//                 "regulation_id" => "9",
//                 "name" => "Oxidant (Ox)",
//                 "unit" => "BDS",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "84",
//                 "regulation_id" => "9",
//                 "name" => "Hydrogen Sulfide (H2S)*",
//                 "unit" => "BDS",
//                 "method" => "SNI 8605:2018"
//             ],
//             [
//                 "id" => "85",
//                 "regulation_id" => "9",
//                 "name" => "Hydrocarbon (HC)",
//                 "unit" => "BDS",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "86",
//                 "regulation_id" => "9",
//                 "name" => "Lead (Pb)",
//                 "unit" => "mg/m3",
//                 "method" => "ICP-OES"
//             ],
//             [
//                 "id" => "87",
//                 "regulation_id" => "9",
//                 "name" => "Total Suspended Particulates (TSP) ",
//                 "unit" => "mg/m3",
//                 "method" => "SNI 16-7058-2004"
//             ],
// // Parameter for Regulation code 022
//             [
//                 "id" => "88",
//                 "regulation_id" => "10",
//                 "name" => "Temperature",
//                 "unit" => "°C",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "89",
//                 "regulation_id" => "10",
//                 "name" => "Relative Humidity (%RH)",
//                 "unit" => "%",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "90",
//                 "regulation_id" => "10",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "mg/m3 (PSD/KTD)",
//                 "method" => "IK-7.4.3 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "91",
//                 "regulation_id" => "10",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "BDS",
//                 "method" => "IK-7.4.2 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "92",
//                 "regulation_id" => "10",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "mg/m3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "93",
//                 "regulation_id" => "10",
//                 "name" => "Ammonia (NH3)",
//                 "unit" => "BDS",
//                 "method" => "IK-7.4.1 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "94",
//                 "regulation_id" => "10",
//                 "name" => "Oxidant (Ox)",
//                 "unit" => "BDS",
//                 "method" => "SNI 7119-8:2017"
//             ],
//             [
//                 "id" => "95",
//                 "regulation_id" => "10",
//                 "name" => "Hydrogen Sulfide (H2S)*",
//                 "unit" => "BDS",
//                 "method" => "SNI 8605:2018"
//             ],
//             [
//                 "id" => "96",
//                 "regulation_id" => "10",
//                 "name" => "Hydrocarbon (HC)",
//                 "unit" => "BDS",
//                 "method" => "Gas Chromatography"
//             ],
//             [
//                 "id" => "97",
//                 "regulation_id" => "10",
//                 "name" => "Lead (Pb)",
//                 "unit" => "mg/m3",
//                 "method" => "ICP-OES"
//             ],
//             [
//                 "id" => "98",
//                 "regulation_id" => "10",
//                 "name" => "Total Suspended Particulates (TSP) ",
//                 "unit" => "mg/m3",
//                 "method" => "SNI 16-7058-2004"
//             ],
// // Parameter for Regulation code 023
//             [
//                 "id" => "99",
//                 "regulation_id" => "11",
//                 "name" => "Temperature",
//                 "unit" => "°C",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "100",
//                 "regulation_id" => "11",
//                 "name" => "Humidity",
//                 "unit" => "%RH",
//                 "method" => "Direct Reading"
//             ],
//             [
//                 "id" => "101",
//                 "regulation_id" => "11",
//                 "name" => "Total Suspended Particulates (TSP) ",
//                 "unit" => "mg/m3",
//                 "method" => "SNI 16-7058-2004"
//             ],
//             [
//                 "id" => "102",
//                 "regulation_id" => "11",
//                 "name" => "Hydrogen Sulfide (H2S)*",
//                 "unit" => "ppm",
//                 "method" => "SNI 8605:2018"
//             ],
//             [
//                 "id" => "103",
//                 "regulation_id" => "11",
//                 "name" => "Ammonia (NH3)",
//                 "unit" => "ppm",
//                 "method" => "IK-7.4.1 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "104",
//                 "regulation_id" => "11",
//                 "name" => "Carbon Monoxide (CO)*",
//                 "unit" => "mg/m3",
//                 "method" => "IK 7.4.19 (Direct Reading)"
//             ],
//             [
//                 "id" => "105",
//                 "regulation_id" => "11",
//                 "name" => "Nitrogen Dioxide (NO2)*",
//                 "unit" => "ppm",
//                 "method" => "IK-7.4.2 (Spectrophotometry)"
//             ],
//             [
//                 "id" => "106",
//                 "regulation_id" => "11",
//                 "name" => "Sulphur Dioxide (SO2)*",
//                 "unit" => "mg/m3",
//                 "method" => "IK-7.4.3 (Spectrophotometry)"
//             ],
// // Parameter for Regulation code 031
//             [
//                 "id" => "107",
//                 "regulation_id" => "12",
//                 "name" => "",
//                 "unit" => "dBA",
//                 "method" => "SNI 8427:2017"
//             ],
//             // [
//             //     "id" => "108",
//             //     "regulation_id" => "12",
//             //     "name" => "",
//             //     "unit" => "dBA",
//             //     "method" => "SNI 8427:2017"
//             // ],
// // Parameter for Regulation code 032
//             [
//                 "id" => "109",
//                 "regulation_id" => "13",
//                 "name" => "",
//                 "unit" => "dBA",
//                 "method" => "SNI 8427:2017"
//             ],
// // Parameter for Regulation code 033
//             [
//                 "id" => "110",
//                 "regulation_id" => "14",
//                 "name" => "",
//                 "unit" => "dBA",
//                 "method" => "SNI 8427:2017"
//             ],
//             // [
//             //     "id" => "111",
//             //     "regulation_id" => "14",
//             //     "name" => "",
//             //     "unit" => "dBA",
//             //     "method" => "SNI 8427:2017"
//             // ],
// // Parameter for Regulation code 033
//             [
//                 "id" => "112",
//                 "regulation_id" => "15",
//                 "name" => "",
//                 "unit" => "dBA",
//                 "method" => "SNI 7231:2009"
//             ],
// Parameter for Regulation code 061
            // [
            //     "id" => "",
            //     "regulation_id" => "22",
            //     "name" => "",
            //     "unit" => "",
            //     "method" => ""
            // ],
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
