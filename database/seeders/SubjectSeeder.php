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
            ["id" => "1", "name" => "Ambient Outdoor Air Quality"],
            ["id" => "2", "name" => "Workplace Air Quality"],
            ["id" => "3", "name" => "Noise"],
            ["id" => "4", "name" => "Waste Water"]
        ];

        foreach ($data as $x) {
            if(!Subject::where('id', $x['id'])->first()){
                $m = new Subject();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->save();
            }
        }
    }
}
