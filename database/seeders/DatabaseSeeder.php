<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AmbientAir;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserRolePermissionSeeder::class,
            PermissionSeeder::class,
            SampleDescriptionSeeder::class,
            ResumeSeeder::class,
            RegulationSeeder::class,
            RegulationStandardSeeder::class,
            SamplingTimeSeeder::class
        ]);
    }
}
