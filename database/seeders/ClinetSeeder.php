<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'user_id' => 4,
            'website' => 'https://example.com',
        ]);

        Client::create([
            'user_id' => 5,
            'website' => 'https://example2.com',
        ]);

        Client::create([
            'user_id' => 6,
            'website' => 'https://example3.com',
        ]);

        Client::create([
            'user_id' => 7,
            'website' => 'https://example4.com',
        ]);
        Client::create([
            'user_id' => 8,
            'website' => 'https://example5.com',
        ]);
    }
}
