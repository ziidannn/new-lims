<?php

namespace Database\Seeders;

use App\Models\RegulationStandard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegulationStandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "title" => "2"],
            ["id" => "2", "title" => "15"],
            ["id" => "3", "title" => "35"],
            ["id" => "4", "title" => "40"],
            ["id" => "5", "title" => "45"],
            ["id" => "6", "title" => "50"],
            ["id" => "7", "title" => "55"],
            ["id" => "8", "title" => "65"],
            ["id" => "9", "title" => "75"],
            ["id" => "10", "title" => "100"],
            ["id" => "11", "title" => "150"],
            ["id" => "12", "title" => "160"],
            ["id" => "13", "title" => "200"],
            ["id" => "14", "title" => "230"],
            ["id" => "15", "title" => "4000"],
            ["id" => "16", "title" => "10000"],
            ["id" => "100", "title" => "-"],
        ];

        foreach ($data as $x) {
            if(!RegulationStandard::where('id', $x['id'])->first()){
                $m = new RegulationStandard();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
    }
}
