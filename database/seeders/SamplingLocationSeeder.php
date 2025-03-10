<?php

namespace Database\Seeders;

use App\Models\SamplingLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SamplingLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["id" => "1", "title" => "Upwind"],
            ["id" => "2", "title" => "Downwind"],
            ["id" => "3", "title" => "WorkArea"],
            ["id" => "4", "title" => "Waste Water"]
        ];

        foreach ($data as $x) {
            if(!SamplingLocation::where('id', $x['id'])->first()){
                $m = new SamplingLocation();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
    }
}
