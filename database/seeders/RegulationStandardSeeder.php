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
            ["id" => "1", "title" => "150"],
            ["id" => "2", "title" => "1000"],
            ["id" => "3", "title" => "75"],
            ["id" => "4", "title" => "450"]
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
