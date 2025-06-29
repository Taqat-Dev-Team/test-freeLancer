<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
            'category_id' => 1,
            'slug' => 'web-development',

        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Mobile Development', 'ar' => 'تطوير الهواتف المحمولة'],
            'category_id' => 1,
            'slug' => 'mobile-development',
        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Graphic Design', 'ar' => 'تصميم الجرافيك'],
            'category_id' => 2,
            'slug' => 'graphic-design',
        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Content Writing', 'ar' => 'كتابة المحتوى'],
            'category_id' => 3,
            'slug' => 'content-writing',
        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Digital Marketing', 'ar' => 'التسويق الرقمي'],
            'category_id' => 4,
            'slug' => 'digital-marketing',
        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Data Analysis', 'ar' => 'تحليل البيانات'],
            'category_id' => 5,
            'slug' => 'data-analysis',
        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'SEO Services', 'ar' => 'خدمات تحسين محركات البحث'],
            'category_id' => 6,
            'slug' => 'seo-services',
        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Virtual Assistance', 'ar' => 'المساعدة الافتراضية'],
            'category_id' => 7,
            'slug' => 'virtual-assistance',
        ]);

        \App\Models\SubCategory::firstOrCreate([
            'name' => ['en' => 'Social Media Management', 'ar' => 'إدارة وسائل التواصل الاجتماعي'],
            'category_id' => 8,
            'slug' => 'social-media-management',
        ]);
    }
}
