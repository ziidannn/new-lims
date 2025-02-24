<?php

namespace Database\Seeders;

use App\Models\Regulation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "sample_description_id" => 1 ,"title" => "PPRI No. 22 tahun 2021 Lamp VII"],
            ["id" => "2", "sample_description_id" => 2 ,"title" => "KepGub DKI Jakarta No. 551 Tahun 2001"],
            ["id" => "3", "sample_description_id" => 1 ,"title" => "PermenLHK No 11 Tahun 2021 Lamp I -  101 - 500 KW"],
            ["id" => "4", "sample_description_id" => 3 ,"title" => "Permenlhk P.15/MENLHK/SETJEN/KUM.1/4/2019 Lampiran IA - ISOKINETIK"]
        ];

        foreach ($data as $x) {
            if(!Regulation::where('id', $x['id'])->first()){
                $m = new Regulation();
                $m->id = $x['id'];
                $m->sample_description_id = $x['sample_description_id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
    }
}
