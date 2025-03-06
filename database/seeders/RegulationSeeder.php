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
            // Ambient Air Regulation
            [
                "id" => "1",
                "regulation_code" => "011",                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No.22 of 2021 Regarding Implementation of Environmental Protection and Management Appendix VII"
            ],
            [
                "id" => "2",
                "regulation_code" => "012",                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No.22 of 2021 Regarding Implementation of Environmental Protection and Management Appendix VII 
                            Minister of Environmental Decree of Republic of Indonesia Regarding Odor Level Standard (KEP-50/MENLH/11/1996)"
            ],
            [
                "id" => "3",
                "regulation_code" => "013",                "subject_id" => 1,
                "title" => "Governor Decree No. 660.31/SK/624/BKPMD/82, Air Ambient Quality Standard in West Java (Primary Category)"
            ],
            [
                "id" => "4",
                "regulation_code" => "014",                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No. 41 Year 1999"
            ],
            [
                "id" => "5",
                "regulation_code" => "015",                "subject_id" => 1,
                "title" => "Governor of DKI Jakarta Decree No. 551 of 2001 Regarding Ambient Air Quality Standards in DKI Jakarta"
            ],
            [
                "id" => "6",    
                "regulation_code" => "016",                "subject_id" => 1,
                "title" => "GGovernor of DKI Jakarta Decree No. 551 of 2001 Regarding Ambient Air Quality Standards in DKI Jakarta\"
                            Minister of Environmental Decree of Republic of Indonesia Regarding Odor Level Standard (KEP-50/MENLH/11/1996)"
            ],
            // Workplace Air
            [
                "id" => "7",
                "regulation_code" => "021",                "subject_id" => 2,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018"
            ],
            [
                "id" => "8",
                "regulation_code" => "022",                "subject_id" => 2,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018."
            ],
            [
                "id" => "9",
                "regulation_code" => "023",                "subject_id" => 2,
                "title" => "Minister of Health Decree of Republic Indonesia No. 1405/MENKES/SK/XI/2002 Appendix I"
            ],
            // Noise*
            [
                "id" => "10",
                "regulation_code" => "031",
                "subject_id" => 2 ,
                "title" => "Government Regulation of Republic Indonesia No. 48 /MENLH/XI/1996 for Noise Standard Regulation
                            Industri (70)\"
                            Perdagangan dan Perkantoran (65)\"
                            Perdagangan dan Jasa (70)"
            ],
            [
                "id" => "11",
                "regulation_code" => "032",
                "subject_id" => 3 ,
                "title" => "Government Regulation of Republic Indonesia No. 48 /MENLH/XI/1996 for Noise Standard Regulation"
            ],
            [
                "id" => "12",
                "regulation_code" => "033",
                "subject_id" => 3 ,
                "title" => "Governor of DKI Jakarta Decree No. 551 of 2001 Regarding Noise Standards in DKI Jakarta"
            ],
            [
                "id" => "13",
                "regulation_code" => "034",
                "subject_id" => 3 ,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018"
            ],
            // Odor
            [
                "id" => "14",
                "regulation_code" => "041",
                "subject_id" => 4 ,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018"
            ],
            [
                "id" => "15",
                "regulation_code" => "042",
                "subject_id" => 4 ,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018."
            ],
            // Illumination*
        ];

        foreach ($data as $x) {
            if(!Regulation::where('id', $x['id'])->first()){
                $m = new Regulation();
                $m->id = $x['id'];
                $m->regulation_code = $x['regulation_code'];
                $m->subject_id = $x['subject_id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
    }
}
