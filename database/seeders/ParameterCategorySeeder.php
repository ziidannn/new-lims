<?php

namespace Database\Seeders;

use App\Models\ParameterCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParameterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "id" => "1",
                "name" => "Physiology Parameters:"
            ],
            [
                "id" => "2",
                "name" => "Microbiology Parameters:"
            ],
            [
                "id" => "3",
                "name" => "Chemistry Parameters:"
            ],
            [
                "id" => "4",
                "name" => "-"
            ],
        ];

        foreach ($data as $x) {
            if(!ParameterCategory::where('id', $x['id'])->first()){
                $m = new ParameterCategory();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->save();
            }
        }
    }
}
