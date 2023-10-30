<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([   
            EventSeeder::class,
            WhiteListSeeder::class,
            UserSeeder::class,
            EventOrganizersSeeder::class,
            DivisionSeeder::class,
            CandidateSeeder::class,
            BallotSeeder::class,
            BallotDetailSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
