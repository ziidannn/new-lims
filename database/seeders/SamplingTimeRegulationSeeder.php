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
            [
                "id" => "1",
                "parameter_id" => "1",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "1",
            ],
            [
                "id" => "2",
                "parameter_id" => "1",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "2",
            ],
            [
                "id" => "3",
                "parameter_id" => "1",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "2",
            ],
            [
                "id" => "4",
                "parameter_id" => "2",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "1",
            ],
            [
                "id" => "5",
                "parameter_id" => "2",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "3",
            ],
            [
                "id" => "6",
                "parameter_id" => "3",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "2",
            ],
            [
                "id" => "7",
                "parameter_id" => "3",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "1",
            ],
            [
                "id" => "8",
                "parameter_id" => "3",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "2",
            ],
            [
                "id" => "9",
                "parameter_id" => "4",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            [
                "id" => "10",
                "parameter_id" => "4",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "3",
            ],
            [
                "id" => "11",
                "parameter_id" => "4",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "4",
            ],
            [
                "id" => "12",
                "parameter_id" => "2",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "2",
            ]
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
