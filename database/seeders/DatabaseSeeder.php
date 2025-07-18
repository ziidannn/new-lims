<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AmbientAir;
use App\Models\Director;
use App\Models\Parameter;
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
            SubjectSeeder::class,
            RegulationSeeder::class,
            SamplingTimeSeeder::class,
            RegulationStandardSeeder::class,
            ParameterCategorySeeder::class,
            ParameterSeeder::class,
            CustomerSeeder::class,
            SamplingTimeRegulationSeeder::class,
            DirectorSeeder::class,
            RegulationStandardCategorySeeder::class,
        ]);
    }
}
