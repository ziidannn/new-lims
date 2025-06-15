<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
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
                "subject_code" => "01",
                "name" => "Ambient Air"
            ],
            [
                "id" => "2",
                "subject_code" => "02",
                "name" => "Workplace Air"
            ],
            [
                "id" => "3",
                "subject_code" => "03",
                "name" => "Noise*"
            ],
            [
                "id" => "4",
                "subject_code" => "04",
                "name" => "Odor"
            ],
            [
                "id" => "5",
                "subject_code" => "05",
                "name" => "Illumination*"
            ],
            [
                "id" => "6",
                "subject_code" => "06",
                "name" => "Heat Stress"
            ],
            [
                "id" => "7",
                "subject_code" => "07",
                "name" => "Stationary Stack Source Emission"
            ],
            // [
            //     "id" => "8",
            //     "subject_code" => "08",
            //     "name" => "Wastewater"
            // ],
            // [
            //     "id" => "9",
            //     "subject_code" => "09",
            //     "name" => "Clean Water"
            // ],
            // [
            //     "id" => "10",
            //     "subject_code" => "10",
            //     "name" => "Surface Water"
            // ],
            // [
            //     "id" => "11",
            //     "subject_code" => "11",
            //     "name" => "Vibration"
            // ]
        ];

        foreach ($data as $x) {
            if(!Subject::where('id', $x['id'])->first()){
                $m = new Subject();
                $m->id = $x['id'];
                $m->subject_code = $x['subject_code'];
                $m->name = $x['name'];
                $m->save();
            }
        }
    }
}
