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
                "regulation_code" => "011",                
                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No.22 of 2021 Regarding Implementation of Environmental Protection and Management Appendix VII"
            ],
            [
                "id" => "2",
                "regulation_code" => "012",                
                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No.22 of 2021 Regarding Implementation of Environmental Protection and Management Appendix VII"
            ],
            [
                "id" => "3",
                "regulation_code" => "013",                
                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No.22 of 2021 Regarding Implementation of Environmental Protection and Management Appendix VII\"
                            Minister of Environmental Decree of Republic of Indonesia Regarding Odor Level Standard (KEP-50/MENLH/11/1996)"
            ],
            [
                "id" => "4",
                "regulation_code" => "014",                
                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No.22 of 2021 Regarding Implementation of Environmental Protection and Management Appendix VII\"
                            Minister of Environmental Decree of Republic of Indonesia Regarding Odor Level Standard (KEP-50/MENLH/11/1996)"
            ],
            [
                "id" => "5",
                "regulation_code" => "015",                
                "subject_id" => 1,
                "title" => "Governor Decree No. 660.31/SK/624/BKPMD/82, Air Ambient Quality Standard in West Java (Primary Category)"
            ],
            [
                "id" => "6",
                "regulation_code" => "016",                
                "subject_id" => 1,
                "title" => "Government Regulation of Republic Indonesia No. 41 Year 1999"
            ],
            [
                "id" => "7",
                "regulation_code" => "017",                
                "subject_id" => 1,
                "title" => "Governor of DKI Jakarta Decree No. 551 of 2001 Regarding Ambient Air Quality Standards in DKI Jakarta"
            ],
            [
                "id" => "8",    
                "regulation_code" => "018",                
                "subject_id" => 1,
                "title" => "GGovernor of DKI Jakarta Decree No. 551 of 2001 Regarding Ambient Air Quality Standards in DKI Jakarta\"
                            Minister of Environmental Decree of Republic of Indonesia Regarding Odor Level Standard (KEP-50/MENLH/11/1996)"
            ],
            // Workplace Air
            [
                "id" => "9",
                "regulation_code" => "021",                
                "subject_id" => 2,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018"
            ],
            [
                "id" => "10",
                "regulation_code" => "022",                
                "subject_id" => 2,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018."
            ],
            [
                "id" => "11",
                "regulation_code" => "023",                
                "subject_id" => 2,
                "title" => "Minister of Health Decree of Republic Indonesia No. 1405/MENKES/SK/XI/2002 Appendix I"
            ],
            // Noise*
            [
                "id" => "12",
                "regulation_code" => "031",
                "subject_id" => 3 ,
                "title" => "Government Regulation of Republic Indonesia No. 48 /MENLH/XI/1996 for Noise Standard Regulation
                            Industri (70)\"
                            Perdagangan dan Perkantoran (65)\"
                            Perdagangan dan Jasa (70)"
            ],
            [
                "id" => "13",
                "regulation_code" => "032",
                "subject_id" => 3 ,
                "title" => "Government Regulation of Republic Indonesia No. 48 /MENLH/XI/1996 for Noise Standard Regulation"
            ],
            [
                "id" => "14",
                "regulation_code" => "033",
                "subject_id" => 3 ,
                "title" => "Governor of DKI Jakarta Decree No. 551 of 2001 Regarding Noise Standards in DKI Jakarta"
            ],
            [
                "id" => "15",
                "regulation_code" => "034",
                "subject_id" => 3 ,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018"
            ],
            // Odor
            [
                "id" => "16",
                "regulation_code" => "041",
                "subject_id" => 4 ,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018"
            ],
            [
                "id" => "17",
                "regulation_code" => "042",
                "subject_id" => 4 ,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018"
            ],
            [
                "id" => "18",
                "regulation_code" => "043",
                "subject_id" => 4 ,
                "title" => "Minister of Manpower Regulation No. 05 Year 2018."
            ],
            // Illumination*
            [
                "id" => "19",
                "regulation_code" => "051",
                "subject_id" => 5 ,
                "title" => "Minimum Value, Minister of Manpower Regulation No. 05 Year 2018 : > Lux"
            ],
            [
                "id" => "20",
                "regulation_code" => "052",
                "subject_id" => 5 ,
                "title" => "Minister of Health Decree of Republic Indonesia No. 1405/MENKES/SK/XI/2002: > Lux"
            ],
            [
                "id" => "21",
                "regulation_code" => "053",
                "subject_id" => 5 ,
                "title" => "Minimum Value, Minister of Health Regulation No. 70 Year 2016 : > Lux"
            ],
            // Heat Stress
            [
                "id" => "22",
                "regulation_code" => "061",
                "subject_id" => 6 ,
                "title" => "WBGT INDEX Quality Standards, Minister of Manpower Regulation No. 05 Year 2018"
            ],
            // Stationary Stack Source Emission
            [
                "id" => "23",
                "regulation_code" => "071",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 7 of 2007 Appendix IV. Volume Under Standard Conditions (25°C and 1 atm pressure)"
            ],
            [
                "id" => "23",
                "regulation_code" => "072",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 7 of 2007 Appendix V. Volume Under Standard Conditions (25°C and 1 atm pressure)"
            ],
            [
                "id" => "24",
                "regulation_code" => "073",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 7 of 2007 (Appendix III) (Stationary Source for Biomass Fueled Steam Boilers)"
            ],
            [
                "id" => "25",
                "regulation_code" => "074",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 07/MENLH/V/2007, Regarding Quality Standards for Stationary Sources for Steam Boilers Using Gas Fuel (Appendix VI) Gas Volume under Standard Conditions (25°C and 1 atm pressure)"
            ],
            [
                "id" => "26",
                "regulation_code" => "075",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 07/MENLH/V/2007, Regarding Quality Standards for Stationary Sources for Steam Boilers Using Oil Fuel (Appendix V) Gas Volume under Standard Conditions (25°C and 1 atm pressure)"
            ],
            [
                "id" => "27",
                "regulation_code" => "076",
                "subject_id" => 7 ,
                "title" => "Governor of DKI Jakarta Decree No. 670 of 2000 Regarding Air Emission Quality Standards (Appendix III)"
            ],
            [
                "id" => "28",
                "regulation_code" => "077",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 13/MENLH/3/1995 Annex VB Gas Volume Under Standard Conditions (25°C and 1 atm pressure)"
            ],
            [
                "id" => "29",
                "regulation_code" => "078",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental and Forestry of Republic Indonesia Decree No. P.15/MENLHK/SETJEN/KUM.1/4/2019 Regarding Quality Standardsfor Thermal Power Generation Emissions (Appendix III A)"
            ],
            [
                "id" => "30",
                "regulation_code" => "079",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental and Forestry of Republic Indonesia Decree No. P.15/MENLHK/SETJEN/KUM.1/4/2019
                            Regarding Quality Standardsfor Thermal Power Generation Emissions (Appendix IX A) "
            ],
            [
                "id" => "31",
                "regulation_code" => "080",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental and Forestry of Republic Indonesia Decree No. P.15/MENLHK/SETJEN/KUM.1/4/2019
                            Regarding Quality Standardsfor Thermal Power Generation Emissions (Appendix IX B) "
            ],
            [
                "id" => "32",
                "regulation_code" => "081",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 21 of 2008 Regarding Quality Standards for Emissions from Stationary Sources for PLTD (Appendix IVA) Gas volume is measured under standard conditions (25°C and pressure 1 atm)"
            ],
            [
                "id" => "33",
                "regulation_code" => "082",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 21 of 2008 Regarding Quality Standards for Emissions from Stationary Sources for PLTD (Appendix III A) Gas volume is measured under standard conditions (25°C and pressure 1 atm)"
            ],
            [
                "id" => "34",
                "regulation_code" => "083",
                "subject_id" => 7 ,
                "title" => "Regulation of the Minister of Environment and Forestry of the Republic of Indonesia No. 11 of 2021 Concerning Emission Quality Standards for  Internal Combustion Engines or Generator (Appendix I No.1). Volume is measured under standard conditions (25°C and pressure 1 atm)Parameters NOx and CO were corrected by 15% O2 in dry condition. Nitrogen Oxide is defined as NO2 + NO"
            ],
            [
                "id" => "35",
                "regulation_code" => "084",
                "subject_id" => 7 ,
                "title" => "Minister of Environment and Forestry of the Republic of Indonesia No. 11 of 2021 Concerning Emission Quality Standards for  Internal Combustion Engines or Generator (Appendix I No.2). Volume is measured under standard conditions (25°C and pressure 1 atm)Parameters NOx, CO, Particulates and SO2 were corrected by 15% O2 in dry condition. Nitrogen Oxide is defined as NO2 + NO"             
            ],
            [
                "id" => "35",
                "regulation_code" => "085",
                "subject_id" => 7 ,
                "title" => "Minister of Environment and Forestry of the Republic of Indonesia No. 11 of 2021 Concerning Emission Quality Standards for  Internal Combustion Engines or Generator (Appendix I No.1). Volume is measured under standard conditions (25°C and pressure 1 atm)Parameters NOx and CO were corrected by 15% O2 in dry condition. Nitrogen Oxide is defined as NO2 + NO"             
            ],
            [
                "id" => "36",
                "regulation_code" => "086",
                "subject_id" => 7 ,
                "title" => "Minister of Environmental Decree of Republic Indonesia No. 7 of 2007 Appendix V. Volume Under Standard Conditions (25°C and 1 atm pressure)Parameters Particulate is corrected by 3% O2."             
            ],

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
