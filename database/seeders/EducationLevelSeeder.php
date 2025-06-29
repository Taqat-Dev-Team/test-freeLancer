<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        EducationLevel::firstOrCreate([
            'name' => ['en' => 'Bachelor Degree', 'ar' => 'بكالوريوس'],
        ]);

        EducationLevel::firstOrCreate([
            'name' => ['en' => 'Master Degree', 'ar' => 'ماجستير'],
        ]);
        EducationLevel::firstOrCreate([
            'name' => ['en' => 'PhD', 'ar' => 'دكتوراه'],
        ]);

        EducationLevel::firstOrCreate([
            'name' => ['en' => 'High School', 'ar' => 'ثانوية عامة'],
        ]);
        EducationLevel::firstOrCreate([
            'name' => ['en' => 'Diploma', 'ar' => 'دبلوم'],
        ]);

        EducationLevel::firstOrCreate([
            'name' => ['en' => 'Associate Degree', 'ar' => 'درجة الزمالة'],
        ]);

        EducationLevel::firstOrCreate([
            'name' => ['en' => 'No Formal Education', 'ar' => 'لا يوجد تعليم رسمي'],
        ]);


    }
}
