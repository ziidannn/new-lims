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
// parameter 1-9 regulation code 011
            [ // 1
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
            [ // 2
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
            [ // 3
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
            [ // 4
                "id" => "9",
                "parameter_id" => "4",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "10",
                "parameter_id" => "4",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "10",
            ],
            [ 
                "id" => "11",
                "parameter_id" => "4",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "3",
            ],
            [ // 5
                "id" => "12",
                "parameter_id" => "5",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "13",
                "parameter_id" => "6",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "100",
            ],
            [ 
                "id" => "14",
                "parameter_id" => "6",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ // 7
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
            [ // 8
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
            [ // 9
                "id" => "19",
                "parameter_id" => "9",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
// parameter 1-9 regulation code 012
            [ // 1
                "id" => "20",
                "parameter_id" => "10",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [
                "id" => "21",
                "parameter_id" => "10",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [
                "id" => "22",
                "parameter_id" => "10",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "5",
            ],
            [ // 2
                "id" => "23",
                "parameter_id" => "11",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "16",
            ],
            [
                "id" => "24",
                "parameter_id" => "11",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "15",
            ],
            [ // 3
                "id" => "25",
                "parameter_id" => "12",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "26",
                "parameter_id" => "12",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "27",
                "parameter_id" => "12",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "6",
            ],
            [ // 4
                "id" => "28",
                "parameter_id" => "13",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "29",
                "parameter_id" => "13",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "10",
            ],
            [ 
                "id" => "30",
                "parameter_id" => "13",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "3",
            ],
            [ // 5
                "id" => "31",
                "parameter_id" => "14",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "32",
                "parameter_id" => "15",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ // 7
                "id" => "33",
                "parameter_id" => "16",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [ 
                "id" => "34",
                "parameter_id" => "16",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "4",
            ],
            [ // 8
                "id" => "35",
                "parameter_id" => "17",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "7",
            ],
            [ 
                "id" => "36",
                "parameter_id" => "17",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 9
                "id" => "37",
                "parameter_id" => "18",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
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
