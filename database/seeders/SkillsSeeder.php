<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skills;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Skills::firstOrCreate([
            'name' => ['en' => 'Digital Marketing', 'ar' => 'التسويق الرقمي'],
            'category_id' => 1
        ]);

        Skills::firstOrCreate([
            'name' => ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
            'category_id' => 2
        ]);

        Skills::firstOrCreate([
            'name' => ['en' => 'Graphic Design', 'ar' => 'تصميم الجرافيك'],
            'category_id' => 3
        ]);
        Skills::firstOrCreate([
            'name' => ['en' => 'Content Writing', 'ar' => 'كتابة المحتوى'],
            'category_id' => 1
        ]);

        Skills::firstOrCreate([
            'name' => ['en' => 'Data Analysis', 'ar' => 'تحليل البيانات'],
            'category_id' => 2
        ]);
        Skills::firstOrCreate([
            'name' => ['en' => 'SEO Optimization', 'ar' => 'تحسين محركات البحث'],
            'category_id' => 1
        ]);
        Skills::firstOrCreate([
            'name' => ['en' => 'Mobile App Development', 'ar' => 'تطوير تطبيقات الهواتف المحمولة'],
            'category_id' => 1
        ]);
        Skills::firstOrCreate([
            'name' => ['en' => 'Social Media Management', 'ar' => 'إدارة وسائل التواصل الاجتماعي'],
            'category_id' => 1
        ]);
        Skills::firstOrCreate([
            'name' => ['en' => 'Video Editing', 'ar' => 'تحرير الفيديو'],
            'category_id' => 5
        ]);
        Skills::firstOrCreate([
            'name' => ['en' => 'UI/UX Design', 'ar' => 'تصميم واجهة المستخدم وتجربة المستخدم']
            , 'category_id' => 1
        ]);
        Skills::firstOrCreate([
            'name' => ['en' => 'Project Management', 'ar' => 'إدارة المشاريع']
            , 'category_id' => 1
        ]);

    }
}
