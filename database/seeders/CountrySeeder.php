<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::firstOrCreate([
            'code' => 'PS',
            'number_code' => '+970',
        ], [
            'name' => ['en' => 'Palestine', 'ar' => 'فلسطين'],
        ]);

        Country::firstOrCreate([
            'code' => 'JO',
            'number_code' => '+962',
        ], [
            'name' => ['en' => 'Jordan', 'ar' => 'الأردن'],
        ]);

        Country::firstOrCreate([
            'code' => 'EG',
            'number_code' => '+20',
        ], [
            'name' => ['en' => 'Egypt', 'ar' => 'مصر'],
        ]);

        Country::firstOrCreate([
            'code' => 'SA',
            'number_code' => '+966',
        ], [
            'name' => ['en' => 'Saudi Arabia', 'ar' => 'السعودية'],
        ]);

        Country::firstOrCreate([
            'code' => 'AE',
            'number_code' => '+971',
        ], [
            'name' => ['en' => 'United Arab Emirates', 'ar' => 'الإمارات'],
        ]);

        Country::firstOrCreate([
            'code' => 'LB',
            'number_code' => '+961',
        ], [
            'name' => ['en' => 'Lebanon', 'ar' => 'لبنان'],
        ]);

        Country::firstOrCreate([
            'code' => 'SY',
            'number_code' => '+963',
        ], [
            'name' => ['en' => 'Syria', 'ar' => 'سوريا'],
        ]);

        Country::firstOrCreate([
            'code' => 'IQ',
            'number_code' => '+964',
        ], [
            'name' => ['en' => 'Iraq', 'ar' => 'العراق'],
        ]);

        Country::firstOrCreate([
            'code' => 'KW',
            'number_code' => '+965',
        ], [
            'name' => ['en' => 'Kuwait', 'ar' => 'الكويت'],
        ]);

        Country::firstOrCreate([
            'code' => 'QA',
            'number_code' => '+974',
        ], [
            'name' => ['en' => 'Qatar', 'ar' => 'قطر'],
        ]);


    }
}
