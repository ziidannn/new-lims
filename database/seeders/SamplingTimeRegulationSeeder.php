<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SamplingTimeRegulation;

class SamplingTimeRegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
// --------------------------------------------S U J E C T  C O D E  0 1--------------------------------------------
            // parameter 1
            [ 
                "id" => "1",
                "parameter_id" => "1",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "2",
                "parameter_id" => "1",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [ 
                "id" => "3",
                "parameter_id" => "1",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "5",
            ],
            // parameter 2
            [ 
                "id" => "4",
                "parameter_id" => "2",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "16",
            ],
            [ 
                "id" => "5",
                "parameter_id" => "2",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "15",
            ],
            // parameter 3
            [ 
                "id" => "6",
                "parameter_id" => "3",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "7",
                "parameter_id" => "3",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "8",
                "parameter_id" => "3",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "6",
            ],
            // parameter 4
            [ 
                "id" => "9",
                "parameter_id" => "4",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "10",
                "parameter_id" => "4",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "10",
            ],
            [ 
                "id" => "11",
                "parameter_id" => "4",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "3",
            ],
            // parameter 5
            [ 
                "id" => "12",
                "parameter_id" => "5",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            // parameter 6
            [ 
                "id" => "13",
                "parameter_id" => "6",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [ 
                "id" => "14",
                "parameter_id" => "6",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            // parameter 7
            [ 
                "id" => "15",
                "parameter_id" => "7",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [ 
                "id" => "16",
                "parameter_id" => "7",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "4",
            ],
            // parameter 8
            [ 
                "id" => "17",
                "parameter_id" => "8",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "7",
            ],
            [ 
                "id" => "18",
                "parameter_id" => "8",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            // parameter 9
            [ 
                "id" => "19",
                "parameter_id" => "9",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            // parameter 10
            [ 
                "id" => "20",
                "parameter_id" => "10",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "18",
            ],
            // parameter 11
            [ 
                "id" => "21",
                "parameter_id" => "11",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "19",
            ],
// --------------------------------------------S U J E C T  C O D E  0 2--------------------------------------------
            // parameter 12
            [ 
                "id" => "22",
                "parameter_id" => "12",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "46",
            ],
            // parameter 13
            [ 
                "id" => "23",
                "parameter_id" => "13",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "47",
            ],
            // parameter 14
            [ 
                "id" => "24",
                "parameter_id" => "14",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "38",
            ],
            // parameter 15
            [ 
                "id" => "25",
                "parameter_id" => "15",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "39",
            ],
            // parameter 16
            [ 
                "id" => "26",
                "parameter_id" => "16",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "41",
            ],
            // parameter 17
            [ 
                "id" => "27",
                "parameter_id" => "17",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "42",
            ],
            // parameter 18
            [ 
                "id" => "28",
                "parameter_id" => "18",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "43",
            ],
            // parameter 19
            [ 
                "id" => "29",
                "parameter_id" => "19",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "33",
            ],
            // parameter 20
            [ 
                "id" => "30",
                "parameter_id" => "20",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "40",
            ],
            // parameter 21
            [ 
                "id" => "31",
                "parameter_id" => "21",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "44",
            ],
            // parameter 22
            [ 
                "id" => "32",
                "parameter_id" => "22",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "20",
            ],
// --------------------------------------------S U J E C T  C O D E  0 3--------------------------------------------
            // parameter 23
            [ 
                "id" => "33",
                "parameter_id" => "23",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "52",
            ],
            // parameter 24
            [ 
                "id" => "34",
                "parameter_id" => "24",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "53",
            ],
// --------------------------------------------S U J E C T  C O D E  0 4--------------------------------------------
            // parameter 25
            [ 
                "id" => "35",
                "parameter_id" => "25",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "30",
            ],
            // parameter 26
            [ 
                "id" => "36",
                "parameter_id" => "26",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "54",
            ],
            // parameter 27
            [ 
                "id" => "37",
                "parameter_id" => "27",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "55",
            ],
            // parameter 28
            [ 
                "id" => "38",
                "parameter_id" => "28",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "10",
            ],
            // parameter 29
            [ 
                "id" => "39",
                "parameter_id" => "29",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "55",
            ],
            // parameter 30
            [ 
                "id" => "40",
                "parameter_id" => "30",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "56",
            ],
            // parameter 31
            [ 
                "id" => "41",
                "parameter_id" => "31",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "55",
            ],
            // parameter 32
            [ 
                "id" => "42",
                "parameter_id" => "32",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "61",
            ],
            // parameter 33
            [ 
                "id" => "43",
                "parameter_id" => "33",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "57",
            ],
            // parameter 34
            [ 
                "id" => "44",
                "parameter_id" => "34",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "58",
            ],
            // parameter 35
            [ 
                "id" => "45",
                "parameter_id" => "35",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "59",
            ],
            // parameter 36
            [ 
                "id" => "46",
                "parameter_id" => "36",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "60",
            ],
// --------------------------------------------S U J E C T  C O D E  0 5--------------------------------------------
            // parameter 37
            [
                "id" => "47",
                "parameter_id" => "37",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "17",
            ],
            // parameter 38
            [
                "id" => "48",
                "parameter_id" => "38",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "17",
            ],
            // parameter 39
            [
                "id" => "49",
                "parameter_id" => "39",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "17",
            ],
// --------------------------------------------S U J E C T  C O D E  07 --------------------------------------------
            // parameter 40
            [
                "id" => "50",
                "parameter_id" => "40",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "14",
            ],
            // parameter 41
            [
                "id" => "51",
                "parameter_id" => "41",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "62",
            ],
            // parameter 42
            [
                "id" => "52",
                "parameter_id" => "42",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "63",
            ],
            // parameter 43
            [
                "id" => "53",
                "parameter_id" => "43",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "55",
            ],
            // parameter 44
            [
                "id" => "54",
                "parameter_id" => "44",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "17",
            ],
            
        ];
        foreach ($data as $x) {
            if(!SamplingTimeRegulation::where('id', $x['id'])->first()){
                $m = new SamplingTimeRegulation();
                $m->id = $x['id'];
                $m->parameter_id = $x['parameter_id'];
                $m->sampling_time_id = $x['sampling_time_id'];
                $m->regulation_standard_id = $x['regulation_standard_id'];
                $m->save();
            }
        }
    }
}
