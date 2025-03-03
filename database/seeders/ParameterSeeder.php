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
            [
                "id" => "1",
                "regulation_id" => "1",
                "name" => "Sulfur Dioxide (SO₂)*",
                "unit" => "ug/m³",
                "method" => "Lamp VII"
            ],
            [
                "id" => "2",
                "regulation_id" => "2",
                "name" => "Nitrogen Dioxide (NO₂)*",
                "unit" => "ug/m³",
                "method" => "No. 551 Tahun 2001"
            ],
            [
                "id" => "3",
                "regulation_id" => "3",
                "name" => "24 Hours Noise",
                "unit" => "ug/m³",
                "method" => "101 - 500 KW"
            ],
            [
                "id" => "4",
                "regulation_id" => "4",
                "name" => "Total Solid Particulate (TSP)",
                "unit" => "ug/m³",
                "method" => "MENLHK/SETJEN"
            ]
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
