<?php

namespace Database\Seeders;

use App\Models\SamplingTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SamplingTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "time" => "1 Hours"],
            ["id" => "2", "time" => "3 Hours"],
            ["id" => "3", "time" => "8 Hours"],
            ["id" => "4", "time" => "24 Hours"],
            ["id" => "5", "time" => "1 Years"],
            ["id" => "6", "time" => "30 Dyas"],
            ["id" => "7", "time" => "-"],
        ];

        foreach ($data as $x) {
            if(!SamplingTime::where('id', $x['id'])->first()){
                $m = new SamplingTime();
                $m->id = $x['id'];
                $m->time = $x['time'];
                $m->save();
            }
        }
    }
}
