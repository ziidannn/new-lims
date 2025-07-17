<?php

namespace Database\Seeders;

use App\Models\RegulationStandardCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegulationStandardCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "id" => "1",
                "parameter_id" => "70",
                "code" => "I",
                "value" => "100"
            ],
            [
                "id" => "2",
                "parameter_id" => "70",
                "code" => "II",
                "value" => "50"
            ],
            [
                "id" => "3",
                "parameter_id" => "70",
                "code" => "III",
                "value" => "1000"
            ],
            [
                "id" => "4",
                "parameter_id" => "70",
                "code" => "IV",
                "value" => "150"
            ],
            [
                "id" => "5",
                "parameter_id" => "71",
                "code" => "I",
                "value" => "90"
            ],
            [
                "id" => "6",
                "parameter_id" => "71",
                "code" => "II",
                "value" => "1"
            ],
            [
                "id" => "7",
                "parameter_id" => "71",
                "code" => "III",
                "value" => "26000"
            ],
            [
                "id" => "8",
                "parameter_id" => "71",
                "code" => "I",
                "value" => "9000"
            ],
            [
                "id" => "9",
                "parameter_id" => "72",
                "code" => "II",
                "value" => "1000"
            ],
            [
                "id" => "10",
                "parameter_id" => "72",
                "code" => "III",
                "value" => "1500"
            ],
            [
                "id" => "11",
                "parameter_id" => "72",
                "code" => "IV",
                "value" => "2000"
            ],
            [
                "id" => "12",
                "parameter_id" => "73",
                "code" => "I",
                "value" => "1000"
            ],
            [
                "id" => "13",
                "parameter_id" => "73",
                "code" => "II",
                "value" => "1500"
            ],
            [
                "id" => "14",
                "parameter_id" => "73",
                "code" => "III",
                "value" => "2000"
            ],
            [
                "id" => "15",
                "parameter_id" => "73",
                "code" => "IV",
                "value" => "120"
            ],
            [
                "id" => "16",
                "parameter_id" => "74",
                "code" => "I",
                "value" => "1000"
            ],
            [
                "id" => "17",
                "parameter_id" => "74",
                "code" => "II",
                "value" => "1500"
            ],
            [
                "id" => "18",
                "parameter_id" => "74",
                "code" => "III",
                "value" => "2000"
            ],
            [
                "id" => "19",
                "parameter_id" => "74",
                "code" => "IV",
                "value" => "120"
            ],
            [   "id" => "20",
                "parameter_id" => "75",
                "code" => "I",
                "value" => "1000"
            ],
            [   "id" => "21",
                "parameter_id" => "75",
                "code" => "II",
                "value" => "1500"
            ],
            [   "id" => "22",
                "parameter_id" => "75",
                "code" => "III",
                "value" => "2000"
            ],
            [   "id" => "23",
                "parameter_id" => "75",
                "code" => "IV",
                "value" => "120"
            ],
            [   "id" => "24",
                "parameter_id" => "76",
                "code" => "I",
                "value" => "1000"
            ],
            [   "id" => "25",
                "parameter_id" => "76",
                "code" => "II",
                "value" => "1500"
            ],
            [   "id" => "26",
                "parameter_id" => "76",
                "code" => "III",
                "value" => "2000"
            ],
            [   "id" => "27",
                "parameter_id" => "76",
                "code" => "IV",
                "value" => "120"
            ],
            [   "id" => "28",
                "parameter_id" => "77",
                "code" => "I",
                "value" => "1000"
            ],
            [   "id" => "29",
                "parameter_id" => "77",
                "code" => "II",
                "value" => "1500"
            ],
            [   "id" => "30",
                "parameter_id" => "77",
                "code" => "III",
                "value" => "2000"
            ],
            [   "id" => "31",
                "parameter_id" => "77",
                "code" => "IV",
                "value" => "120"
            ],
        ];

        foreach ($data as $x) {
            if (!RegulationStandardCategory::where('id', $x['id'])->first()) {
                $m = new RegulationStandardCategory();
                $m->id = $x['id'];
                $m->parameter_id = $x['parameter_id'];
                $m->code = $x['code'];
                $m->value = $x['value'];
                $m->save();
            }
        }
    }
}
