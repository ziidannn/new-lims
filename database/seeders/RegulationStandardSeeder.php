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
            ["id" => "17", "title" => "-"],
            ["id" => "18", "title" => "2.0***"],
            ["id" => "19", "title" => "0.02***"],
            ["id" => "20", "title" => "10"],
            ["id" => "21", "title" => "80"],
            ["id" => "22", "title" => "265"],
            ["id" => "23", "title" => "24"],
            ["id" => "24", "title" => "260"],
            ["id" => "25", "title" => "1.5"],
            ["id" => "26", "title" => "900"],
            ["id" => "27", "title" => "365"],
            ["id" => "28", "title" => "60"],
            ["id" => "29", "title" => "30000"],
            ["id" => "30", "title" => "400"],
            ["id" => "31", "title" => "235"],
            ["id" => "32", "title" => "90"],
            ["id" => "33", "title" => "1"],
            ["id" => "34", "title" => "26000"],
            ["id" => "35", "title" => "9000"],
            ["id" => "36", "title" => "92.5"],
            ["id" => "37", "title" => "30"],
            ["id" => "38", "title" => "0.25"],
            ["id" => "39", "title" => "0.2"],
            ["id" => "40", "title" => "1000"],
            ["id" => "41", "title" => "29"],
            ["id" => "42", "title" => "25"],
            ["id" => "43", "title" => "0.08"],
            ["id" => "44", "title" => "0.05"],
            ["id" => "45", "title" => "10"],
            ["id" => "46", "title" => "23 - 26"],
            ["id" => "47", "title" => "40 - 60"],
            ["id" => "48", "title" => "18 - 28"],
            ["id" => "49", "title" => "0.15"],
            ["id" => "50", "title" => "3.0"],
            ["id" => "51", "title" => "5.2"],
            ["id" => "52", "title" => "70"],
            ["id" => "53", "title" => "85"],
            ["id" => "54", "title" => "0.5"],
            ["id" => "55", "title" => "20"],
            ["id" => "56", "title" => "250"],
            ["id" => "57", "title" => "0.002"],
            ["id" => "58", "title" => "0.02"],
            ["id" => "59", "title" => "0.01"],
            ["id" => "60", "title" => "0.1"],
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
