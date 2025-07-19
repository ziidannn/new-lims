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
                "code" => "IV",
                "regulation_standard_id" => "11"
            ],
            [
                "id" => "2",
                "parameter_id" => "70",
                "code" => "II",
                "regulation_standard_id" => "51"
            ],
            [
                "id" => "3",
                "parameter_id" => "70",
                "code" => "III",
                "regulation_standard_id" => "15"
            ],
            [
                "id" => "4",
                "parameter_id" => "70",
                "code" => "IV",
                "regulation_standard_id" => "8"
            ],
            [
                "id" => "5",
                "parameter_id" => "71",
                "code" => "I",
                "regulation_standard_id" => "10"
            ],
            [
                "id" => "6",
                "parameter_id" => "71",
                "code" => "II",
                "regulation_standard_id" => "60"
            ],
            [
                "id" => "7",
                "parameter_id" => "71",
                "code" => "III",
                "regulation_standard_id" => "25"
            ],
            [
                "id" => "8",
                "parameter_id" => "71",
                "code" => "I",
                "regulation_standard_id" => "34"
            ],
            [
                "id" => "9",
                "parameter_id" => "72",
                "code" => "II",
                "regulation_standard_id" => "41"
            ],
            [
                "id" => "10",
                "parameter_id" => "72",
                "code" => "III",
                "regulation_standard_id" => "43"
            ],
            [
                "id" => "11",
                "parameter_id" => "72",
                "code" => "IV",
                "regulation_standard_id" => "20"
            ],
            [
                "id" => "12",
                "parameter_id" => "73",
                "code" => "I",
                "regulation_standard_id" => "30"
            ],
            [
                "id" => "13",
                "parameter_id" => "73",
                "code" => "II",
                "regulation_standard_id" => "26"
            ],
            [
                "id" => "14",
                "parameter_id" => "73",
                "code" => "III",
                "regulation_standard_id" => "57"
            ],
            [
                "id" => "15",
                "parameter_id" => "73",
                "code" => "IV",
                "regulation_standard_id" => "61"
            ],
            [
                "id" => "16",
                "parameter_id" => "74",
                "code" => "I",
                "regulation_standard_id" => "13"
            ],
            [
                "id" => "17",
                "parameter_id" => "74",
                "code" => "II",
                "regulation_standard_id" => "16"
            ],
            [
                "id" => "18",
                "parameter_id" => "74",
                "code" => "III",
                "regulation_standard_id" => "4"
            ],
            [
                "id" => "19",
                "parameter_id" => "74",
                "code" => "IV",
                "regulation_standard_id" => "5"
            ],
            [   "id" => "20",
                "parameter_id" => "75",
                "code" => "I",
                "regulation_standard_id" => "47"
            ],
            [   "id" => "21",
                "parameter_id" => "75",
                "code" => "II",
                "regulation_standard_id" => "19"
            ],
            [   "id" => "22",
                "parameter_id" => "75",
                "code" => "III",
                "regulation_standard_id" => "18"
            ],
            [   "id" => "23",
                "parameter_id" => "75",
                "code" => "IV",
                "regulation_standard_id" => "48"
            ],
            [   "id" => "24",
                "parameter_id" => "76",
                "code" => "I",
                "regulation_standard_id" => "31"
            ],
            [   "id" => "25",
                "parameter_id" => "76",
                "code" => "II",
                "regulation_standard_id" => "55"
            ],
            [   "id" => "26",
                "parameter_id" => "76",
                "code" => "III",
                "regulation_standard_id" => "3"
            ],
            [   "id" => "27",
                "parameter_id" => "76",
                "code" => "IV",
                "regulation_standard_id" => "66"
            ],
            [   "id" => "28",
                "parameter_id" => "77",
                "code" => "I",
                "regulation_standard_id" => "73"
            ],
            [   "id" => "29",
                "parameter_id" => "77",
                "code" => "II",
                "regulation_standard_id" => "71"
            ],
            [   "id" => "30",
                "parameter_id" => "77",
                "code" => "III",
                "regulation_standard_id" => "61"
            ],
            [   "id" => "31",
                "parameter_id" => "77",
                "code" => "IV",
                "regulation_standard_id" => "44"
            ],
        ];

        foreach ($data as $x) {
            if (!RegulationStandardCategory::where('id', $x['id'])->first()) {
                $m = new RegulationStandardCategory();
                $m->id = $x['id'];
                $m->parameter_id = $x['parameter_id'];
                $m->code = $x['code'];
                $m->regulation_standard_id = $x['regulation_standard_id'];
                $m->save();
            }
        }
    }
}
