<?php

namespace Database\Seeders;

use App\Models\Director;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "id" => "1",
                "name" => "Drs. H. Soekardin Rachman, M.Si",
                "ttd" => ""
            ],
        ];
        foreach ($data as $x) {
            if(!Director::where('id', $x['id'])->first()){
                $m = new Director();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->ttd = $x['ttd'];
                $m->save();
            }
        }
    }
}
