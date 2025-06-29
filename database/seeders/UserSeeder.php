<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Create users with different countries


        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' => 1,
            'bio' => 'Freelancer Developer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmad Youssef',
            'email' => 'ahmad@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' => 2,
            'bio' => 'Full Stack Web Developer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Sara Khalil',
            'email' => 'sara@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' => 3,
            'bio' => 'UI/UX Designer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Omar Al-Farouq',
            'email' => 'omar@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' =>4,
            'bio' => 'Mobile App Developer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Layla Haddad',
            'email' => 'layla@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' =>5,
            'bio' => 'Content Creator',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Yousef Najjar',
            'email' => 'yousef@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' => 6,
            'bio' => 'Frontend Engineer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Maya Saeed',
            'email' => 'maya@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' =>7,
            'bio' => 'Illustrator & Graphic Designer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Hassan Ali',
            'email' => 'hassan@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' => 8,
            'bio' => 'Backend Developer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Fatima Nasser',
            'email' => 'fatima@example.com',
            'password' => bcrypt('123456789'),
            'status' => 1,
            'country_id' => 9,
            'bio' => 'Digital Marketer',
            'email_verified_at' => now(),
        ]);


    }
}
