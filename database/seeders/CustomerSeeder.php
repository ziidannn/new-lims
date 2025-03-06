<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '1',
                'name' => 'PT Delta Indonesia Laboratory',
                'contact_name' => 'Nidia',
                'email' => 'deltaindonesia@gmail.com',
                'phone' => '0211234567',
                'address' => 'Bekasi, Indonesia 16483',
            ],
            [
                'id' => '2',
                'name' => 'PT Alpha Sejahtera',
                'contact_name' => 'Ivan Saputra',
                'email' => 'alphaindonesia@gmail.com',
                'phone' => '0217654321',
                'address' => 'Jakarta, Indonesia 12345',
            ],
            [
                'id' => '3',
                'name' => 'PT Beta Kreatif',
                'contact_name' => 'Komang Surya',
                'email' => 'betalaboratory@gmail.com',
                'phone' => '0274534567',
                'address' => 'Depok, Indonesia 67890',
            ],
            [
                'id' => '4',
                'name' => 'PT Gamma Abadi Jaya',
                'contact_name' => 'Hendra Wijaya',
                'email' => 'gammalaboratory@gmail.com',
                'phone' => '02867434567',
                'address' => 'Bogor, Indonesia 54321',
            ]
        ];
        foreach ($data as $x) {
            if(!Customer::where('id', $x['id'])->first()){
                $m = new Customer();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->contact_name = $x['contact_name'];
                $m->email = $x['email'];
                $m->phone = $x['phone'];
                $m->address = $x['address'];
                $m->save();
            }
        }
    }
}
