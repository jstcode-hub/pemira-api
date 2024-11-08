<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Ballot;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seeder untuk events
        $event = Event::create([
            'title' => 'Pemilihan Ketua Himpunan 2024',
            'description' => 'Pemilihan Ketua dan Wakil Ketua Himpunan untuk periode 2024.',
            'logo' => 'logo.png',
            'open_election_at' => now(),
            'close_election_at' => now()->addDays(7),
        ]);

        // Seeder untuk users dan ballots
        for ($i = 1; $i <= 10; $i++) {
            $npm = '23081010' . str_pad($i, 2, '0', STR_PAD_LEFT); // Format npm

            // Buat user
            $user = User::create([
                'npm' => $npm,
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('password'),
                'role' => 0, // Sebagai mahasiswa biasa
                'provider_id' => null,
                'picture' => null,
            ]);

            // Buat ballot terkait untuk user
            Ballot::create([
                'event_id' => $event->id,
                'npm' => $user->npm,
                'ktm_picture' => 'ktm' . $i . '.jpg',
                'verification_picture' => 'verification' . $i . '.jpg',
                'accepted' => rand(0, 1),
                'accepted_at' => now(),
                'accepted_by' => 'Admin',
            ]);
        }
    }
}
