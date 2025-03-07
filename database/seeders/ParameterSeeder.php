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
// Parameter for Regulation code 011 
            [
                "id" => "1",
                "regulation_id" => "1",
                "name" => "Sulfur Dioxide (SO₂)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-7:2017"
            ],
            [
                "id" => "2",
                "regulation_id" => "1",
                "name" => "Sulphur Dioxide (SO₂)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "3",
                "regulation_id" => "1",
                "name" => "Nitrogen Dioxide (NO₂)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "4",
                "regulation_id" => "1",
                "name" => "Oxidant (Ox)* ",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "5",
                "regulation_id" => "1",
                "name" => "Hydrocarbon Non Methane (NMHC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "6",
                "regulation_id" => "1",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "7",
                "regulation_id" => "1",
                "name" => "PM10 (Particulate Matters)",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "8",
                "regulation_id" => "1",
                "name" => "PM2.5 (Particulate Matters)",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "9",
                "regulation_id" => "1",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
// Parameter for Regulation code 012
            [
                "id" => "10",
                "regulation_id" => "2",
                "name" => "Sulfur Dioxide (SO₂)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-7:2017"
            ],
            [
                "id" => "11",
                "regulation_id" => "2",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "12",
                "regulation_id" => "2",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "13",
                "regulation_id" => "2",
                "name" => "Oxidant (Ox)* ",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "14",
                "regulation_id" => "2",
                "name" => "Hydrocarbon Non Methane (NMHC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "15",
                "regulation_id" => "2",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "16",
                "regulation_id" => "2",
                "name" => "PM10 (Particulate Matters)",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "17",
                "regulation_id" => "2",
                "name" => "PM2.5 (Particulate Matters)",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "18",
                "regulation_id" => "2",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
// Parameter for Regulation code 013 
            [
                "id" => "19",
                "regulation_id" => "3",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "20",
                "regulation_id" => "3",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "21",
                "regulation_id" => "3",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "22",
                "regulation_id" => "3",
                "name" => "Oxidant (Ox)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "23",
                "regulation_id" => "3",
                "name" => "Hydrocarbon Non Methane (NMHC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "24",
                "regulation_id" => "3",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "25",
                "regulation_id" => "3",
                "name" => "PM10 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "26",
                "regulation_id" => "3",
                "name" => "PM2.5 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "27",
                "regulation_id" => "3",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "28",
                "regulation_id" => "3",
                "name" => "Ammonia (NH3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.1-2005"
            ],
            [
                "id" => "29",
                "regulation_id" => "3",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "µg/Nm3",
                "method" => "IK-7.4.22(Spectrophotometry)"
            ],
// Parameter for Regulation code 014
            [
                "id" => "30",
                "regulation_id" => "4",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "31",
                "regulation_id" => "4",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "32",
                "regulation_id" => "4",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "33",
                "regulation_id" => "4",
                "name" => "Oxidant (Ox)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "34",
                "regulation_id" => "4",
                "name" => "Hydrocarbon Non Methane (NMHC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "35",
                "regulation_id" => "4",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "36",
                "regulation_id" => "4",
                "name" => "PM10 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "37",
                "regulation_id" => "4",
                "name" => "PM2.5 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "38",
                "regulation_id" => "4",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "39",
                "regulation_id" => "4",
                "name" => "Ammonia (NH3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.1-2005"
            ],
            [
                "id" => "40",
                "regulation_id" => "4",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "µg/Nm3",
                "method" => "IK-7.4.22(Spectrophotometry)"
            ],
// Parameter for Regulation code 015
            [
                "id" => "41",
                "regulation_id" => "5",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "42",
                "regulation_id" => "5",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "43",
                "regulation_id" => "5",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-7:2017"
            ],
            [
                "id" => "44",
                "regulation_id" => "5",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "µg/Nm3",
                "method" => "IK-7.4.22 (Spectrophotometry)"
            ],
            [
                "id" => "45",
                "regulation_id" => "5",
                "name" => "Hydrocarbon (HC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "46",
                "regulation_id" => "5",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "47",
                "regulation_id" => "5",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "48",
                "regulation_id" => "5",
                "name" => "Ammonia (NH3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.1-2005"
            ],
            [
                "id" => "49",
                "regulation_id" => "5",
                "name" => "Oxidant (Ox)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
// Parameter for Regulation code 016
            [
                "id" => "50",
                "regulation_id" => "6",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-7:2017"
            ],
            [
                "id" => "51",
                "regulation_id" => "6",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "52",
                "regulation_id" => "6",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "53",
                "regulation_id" => "6",
                "name" => "Oxidant (O3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "54",
                "regulation_id" => "6",
                "name" => "Hydrocarbon (HC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "55",
                "regulation_id" => "6",
                "name" => "PM10 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "56",
                "regulation_id" => "6",
                "name" => "PM2.5 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "57",
                "regulation_id" => "6",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "58",
                "regulation_id" => "6",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
// Parameter for Regulation code 017
            [
                "id" => "59",
                "regulation_id" => "7",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-7:2017"
            ],
            [
                "id" => "60",
                "regulation_id" => "7",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "61",
                "regulation_id" => "7",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "62",
                "regulation_id" => "7",
                "name" => "Oxidant (O3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "63",
                "regulation_id" => "7",
                "name" => "Hydrocarbon (HC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "64",
                "regulation_id" => "7",
                "name" => "PM10 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "65",
                "regulation_id" => "7",
                "name" => "PM2.5 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "66",
                "regulation_id" => "7",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "67",
                "regulation_id" => "7",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
// Parameter for Regulation code 018
            [
                "id" => "68",
                "regulation_id" => "8",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-7:2017"
            ],
            [
                "id" => "69",
                "regulation_id" => "8",
                "name" => "Carbon Monoxide (CO)* ",
                "unit" => "µg/Nm3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "70",
                "regulation_id" => "8",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.2-2005"
            ],
            [
                "id" => "71",
                "regulation_id" => "8",
                "name" => "Oxidant (O3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "72",
                "regulation_id" => "8",
                "name" => "Hydrocarbon (HC)",
                "unit" => "µg/Nm3",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "73",
                "regulation_id" => "8",
                "name" => "PM10 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "74",
                "regulation_id" => "8",
                "name" => "PM2.5 (Particulate Matters) ",
                "unit" => "µg/Nm3",
                "method" => "Direct Reading"
            ],
            [
                "id" => "75",
                "regulation_id" => "8",
                "name" => "Total Suspended Particulates (TSP)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 7119.3:2017"
            ],
            [
                "id" => "76",
                "regulation_id" => "8",
                "name" => "Lead (Pb)",
                "unit" => "µg/Nm3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "77",
                "regulation_id" => "8",
                "name" => "Ammonia (NH3)*",
                "unit" => "µg/Nm3",
                "method" => "SNI 19-7119.1-2005"
            ],
            [
                "id" => "78",
                "regulation_id" => "8",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "µg/Nm3",
                "method" => "IK-7.4.22 (Spectrophotometry)"
            ],
// Parameter for Regulation code 021
            [
                "id" => "79",
                "regulation_id" => "9",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "mg/m3 (PSD/KTD)",
                "method" => "IK-7.4.3 (Spectrophotometry)"
            ],
            [
                "id" => "80",
                "regulation_id" => "9",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "BDS",
                "method" => "IK-7.4.2 (Spectrophotometry)"
            ],
            [
                "id" => "81",
                "regulation_id" => "9",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/m3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "82",
                "regulation_id" => "9",
                "name" => "Ammonia (NH3)",
                "unit" => "BDS",
                "method" => "IK-7.4.1 (Spectrophotometry)"
            ],
            [
                "id" => "83",
                "regulation_id" => "9",
                "name" => "Oxidant (Ox)",
                "unit" => "BDS",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "84",
                "regulation_id" => "9",
                "name" => "Hydrogen Sulfide (H2S)*",
                "unit" => "BDS",
                "method" => "SNI 8605:2018"
            ],
            [
                "id" => "85",
                "regulation_id" => "9",
                "name" => "Hydrocarbon (HC)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "86",
                "regulation_id" => "9",
                "name" => "Lead (Pb)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "87",
                "regulation_id" => "9",
                "name" => "Total Suspended Particulates (TSP) ",
                "unit" => "mg/m3",
                "method" => "SNI 16-7058-2004"
            ],
// Parameter for Regulation code 022
            [
                "id" => "88",
                "regulation_id" => "10",
                "name" => "Temperature",
                "unit" => "°C",
                "method" => "Direct Reading"
            ],
            [
                "id" => "89",
                "regulation_id" => "10",
                "name" => "Relative Humidity (%RH)",
                "unit" => "%",
                "method" => "Direct Reading"
            ],
            [
                "id" => "90",
                "regulation_id" => "10",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "mg/m3 (PSD/KTD)",
                "method" => "IK-7.4.3 (Spectrophotometry)"
            ],
            [
                "id" => "91",
                "regulation_id" => "10",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "BDS",
                "method" => "IK-7.4.2 (Spectrophotometry)"
            ],
            [
                "id" => "92",
                "regulation_id" => "10",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/m3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "93",
                "regulation_id" => "10",
                "name" => "Ammonia (NH3)",
                "unit" => "BDS",
                "method" => "IK-7.4.1 (Spectrophotometry)"
            ],
            [
                "id" => "94",
                "regulation_id" => "10",
                "name" => "Oxidant (Ox)",
                "unit" => "BDS",
                "method" => "SNI 7119-8:2017"
            ],
            [
                "id" => "95",
                "regulation_id" => "10",
                "name" => "Hydrogen Sulfide (H2S)*",
                "unit" => "BDS",
                "method" => "SNI 8605:2018"
            ],
            [
                "id" => "96",
                "regulation_id" => "10",
                "name" => "Hydrocarbon (HC)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "97",
                "regulation_id" => "10",
                "name" => "Lead (Pb)",
                "unit" => "mg/m3",
                "method" => "ICP-OES"
            ],
            [
                "id" => "98",
                "regulation_id" => "10",
                "name" => "Total Suspended Particulates (TSP) ",
                "unit" => "mg/m3",
                "method" => "SNI 16-7058-2004"
            ],
// Parameter for Regulation code 023
            [
                "id" => "99",
                "regulation_id" => "11",
                "name" => "Temperature",
                "unit" => "°C",
                "method" => "Direct Reading"
            ],
            [
                "id" => "100",
                "regulation_id" => "11",
                "name" => "Humidity",
                "unit" => "%RH",
                "method" => "Direct Reading"
            ],
            [
                "id" => "101",
                "regulation_id" => "11",
                "name" => "Total Suspended Particulates (TSP) ",
                "unit" => "mg/m3",
                "method" => "SNI 16-7058-2004"
            ],
            [
                "id" => "102",
                "regulation_id" => "11",
                "name" => "Hydrogen Sulfide (H2S)*",
                "unit" => "ppm",
                "method" => "SNI 8605:2018"
            ],
            [
                "id" => "103",
                "regulation_id" => "11",
                "name" => "Ammonia (NH3)",
                "unit" => "ppm",
                "method" => "IK-7.4.1 (Spectrophotometry)"
            ],
            [
                "id" => "104",
                "regulation_id" => "11",
                "name" => "Carbon Monoxide (CO)*",
                "unit" => "mg/m3",
                "method" => "IK 7.4.19 (Direct Reading)"
            ],
            [
                "id" => "105",
                "regulation_id" => "11",
                "name" => "Nitrogen Dioxide (NO2)*",
                "unit" => "ppm",
                "method" => "IK-7.4.2 (Spectrophotometry)"
            ],
            [
                "id" => "106",
                "regulation_id" => "11",
                "name" => "Sulphur Dioxide (SO2)*",
                "unit" => "mg/m3",
                "method" => "IK-7.4.3 (Spectrophotometry)"
            ],
// Parameter for Regulation code 031
            [
                "id" => "107",
                "regulation_id" => "12",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 8427:2017"
            ],
            [
                "id" => "108",
                "regulation_id" => "12",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 8427:2017"
            ],
// Parameter for Regulation code 032
            [
                "id" => "109",
                "regulation_id" => "13",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 8427:2017"
            ],
// Parameter for Regulation code 033
            [
                "id" => "110",
                "regulation_id" => "14",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 8427:2017"
            ],
            [
                "id" => "111",
                "regulation_id" => "14",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 8427:2017"
            ],
// Parameter for Regulation code 033
            [
                "id" => "112",
                "regulation_id" => "15",
                "name" => "",
                "unit" => "dBA",
                "method" => "SNI 7231:2009"
            ],
// Parameter for Regulation code 041
            [
                "id" => "113",
                "regulation_id" => "16",
                "name" => "Ethyl Acetate",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "114",
                "regulation_id" => "16",
                "name" => "Benzene",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "115",
                "regulation_id" => "16",
                "name" => "Toluene",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "116",
                "regulation_id" => "16",
                "name" => "Xylene",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
// Parameter for Regulation code 042
            [
                "id" => "117",
                "regulation_id" => "17",
                "name" => "Methyl Ethyl Ketone (C4H8O)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "118",
                "regulation_id" => "17",
                "name" => "Aceton (C3H6O)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
            [
                "id" => "119",
                "regulation_id" => "17",
                "name" => "Toluene (C7H8)",
                "unit" => "BDS",
                "method" => "Gas Chromatography"
            ],
// Parameter for Regulation code 043
            [
                "id" => "120",
                "regulation_id" => "18",
                "name" => "Ammonia (NH3)*",
                "unit" => "ppm",
                "method" => "SNI 7119.1-2005"
            ],
            [
                "id" => "121",
                "regulation_id" => "18",
                "name" => "Methyl Mercaptan (CH3SH)",
                "unit" => "ppm",
                "method" => "NIOSH 2542"
            ],
            [
                "id" => "122",
                "regulation_id" => "18",
                "name" => "Hydrogen Sulfide (H2S)",
                "unit" => "ppm",
                "method" => "IK-7.4.22 (Spectrophotometry)"
            ],
            [
                "id" => "123",
                "regulation_id" => "18",
                "name" => "Methyl Sulfide ((CH3)2)S",
                "unit" => "ppm",
                "method" => "OSHA PV2210"
            ],
            [
                "id" => "124",
                "regulation_id" => "18",
                "name" => "Styrene (C6H5CHCH2)",
                "unit" => "ppm",
                "method" => "Gas Chromatography"
            ],
// Parameter for Regulation code 051
            [
                "id" => "125",
                "regulation_id" => "19",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
// Parameter for Regulation code 052
            [
                "id" => "126",
                "regulation_id" => "20",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
// Parameter for Regulation code 053
            [
                "id" => "127",
                "regulation_id" => "21",
                "name" => "",
                "unit" => "Lux",
                "method" => "SNI 7062:2019"
            ],
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
                $m->regulation_id = $x['regulation_id'];
                $m->name = $x['name'];
                $m->unit = $x['unit'];
                $m->method = $x['method'];
                $m->save();
            }
        }
    }
}
