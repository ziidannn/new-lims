<?php

namespace Database\Seeders;

use App\Models\Resume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
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
                "sample_description_id" => "1",
                "name_parameter" => "Ambient Outdoor Air Quality",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "naufnasjifnai"
            ],
            [
                "id" => "2",
                "sample_description_id" => "1",
                "name_parameter" => "Workplace Air Quality",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "nasjjfnasjifnas"
            ],
            [
                "id" => "3",
                "sample_description_id" => "1",
                "name_parameter" => "Noise",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "gassfsjifnaijf"
            ],
            [
                "id" => "4",
                "sample_description_id" => "1",
                "name_parameter" => "Waste Water",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "hasuydhasydha"

            ],
            [
                "id" => "1",
                "sample_description_id" => "1",
                "name_parameter" => "Ambient Outdoor Air Quality",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "wqmrqwjrmsa"
            ],
            [
                "id" => "2",
                "sample_description_id" => "1",
                "name_parameter" => "Workplace Air Quality",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "cvnf snaasj"
            ],
            [
                "id" => "3",
                "sample_description_id" => "1",
                "name_parameter" => "Noise",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "askdiajd"
            ],
            [
                "id" => "4",
                "sample_description_id" => "1",
                "name_parameter" => "Waste Water",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "woiew f  "
            ],
            [
                "id" => "4",
                "sample_description_id" => "1",
                "name_parameter" => "Waste Water",
                "sampling_time" =>  "1 Hours, 24Hours, 1 Years",
                "regulation" => "150,74,1000,10",
                "unit" => "ug/m³",
                "method" => "wijrqwirwq"
            ]

        ];

        foreach ($data as $x) {
            if(!Resume::where('id', $x['id'])->first()){
                $m = new Resume();
                $m->id = $x['id'];
                $m->sample_description_id = $x['sample_description_id'];
                $m->name_parameter = $x['name_parameter'];
                $m->sampling_time = $x['sampling_time'];
                $m->regulation = $x['regulation'];
                $m->unit = $x['unit'];
                $m->method = $x['method'];
                $m->save();
            }
        }
    }
}
