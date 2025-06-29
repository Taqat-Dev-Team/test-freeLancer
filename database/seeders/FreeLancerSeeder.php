<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FreeLancerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\FreeLancer::firstOrCreate([
            'user_id' => 1,
            'cv' => 'cv.pdf',
            'cv_view_count' => 0,
            'category_id' => 1,
            'sub_category_id' => 1,
        ]);


        \App\Models\FreeLancer::firstOrCreate([
            'user_id' => 2,
            'cv' => 'cv.pdf',
            'cv_view_count' => 0,
            'category_id' => 2,
            'sub_category_id' => 3,
        ]);

        \App\Models\FreeLancer::firstOrCreate([
            'user_id' => 3,
            'cv' => 'cv.pdf',
            'cv_view_count' => 0,
            'category_id' => 3,
            'sub_category_id' => 4,
        ]);

    }
}
