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
                "name" => "PPRI No. 22 tahun 2021 Lamp VII",
                "unit" => "ug/m³",
                "method" => "Lamp VII"
            ],
            [
                "id" => "2",
                "regulation_id" => "1",
                "name" => "KepGub DKI Jakarta No. 551 Tahun 2001",
                "unit" => "ug/m³",
                "method" => "No. 551 Tahun 2001"
            ],
            [
                "id" => "3",
                "regulation_id" => "1",
                "name" => "PermenLHK No 11 Tahun 2021 Lamp I -  101 - 500 KW",
                "unit" => "ug/m³",
                "method" => "Lamp I -  101 - 500 KW"
            ],
            [
                "id" => "4",
                "regulation_id" => "1",
                "name" => "Permenlhk P.15/MENLHK/SETJEN/KUM.1/4/2019 Lampiran IA - ISOKINETIK",
                "unit" => "ug/m³",
                "method" => "MENLHK/SETJEN/KUM.1/4/2019"
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
