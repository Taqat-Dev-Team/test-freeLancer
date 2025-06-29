<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'Software Engineering', 'ar' => ' هندسة البرمجيات'],
            'slug' => 'software-engineering',
        ]);

        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'Graphic Design', 'ar' => 'تصميم الجرافيك'],
            'slug' => 'graphic-design',
        ]);

        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'Content Creation', 'ar' => 'إنشاء المحتوى'],
            'slug' => 'content-creation',
        ]);


        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'Digital Marketing', 'ar' => 'التسويق الرقمي'],
            'slug' => 'digital-marketing',
        ]);

        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'Data Science', 'ar' => 'علوم البيانات'],
            'slug' => 'data-science',
        ]);

        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'SEO Services', 'ar' => 'خدمات تحسين محركات البحث'],
            'slug' => 'seo-services',
        ]);

        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'Virtual Assistance', 'ar' => 'المساعدة الافتراضية'],
            'slug' => 'virtual-assistance',
        ]);

        \App\Models\Category::firstOrCreate([
            'name' => ['en' => 'Translation Services', 'ar' => 'خدمات الترجمة'],
            'slug' => 'translation-services',
        ]);


    }
}
