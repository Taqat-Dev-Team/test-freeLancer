<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialMedia::create([
            'name' => ['en' => 'Instagram', 'ar' => 'انستجرام'],
            'icon' => 'fa-brands fa-instagram',
        ]);

        SocialMedia::create([
            'name' => ['en' => 'Facebook', 'ar' => 'فيسبوك'],
            'icon' => 'fa-brands fa-facebook',
        ]);

        SocialMedia::create([
            'name' => ['en' => 'Twitter', 'ar' => 'تويتر'],
            'icon' => 'fa-brands fa-twitter',
        ]);

        SocialMedia::create([
            'name' => ['en' => 'LinkedIn', 'ar' => 'لينكد ان'],
            'icon' => 'fa-brands fa-linkedin',
        ]);

        SocialMedia::create([
            'name' => ['en' => 'YouTube', 'ar' => 'يوتيوب'],
            'icon' => 'fa-brands fa-youtube',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'GitHub', 'ar' => 'جيت هاب'],
            'icon' => 'fa-brands fa-github',
        ]);

        SocialMedia::create([
            'name' => ['en' => 'WhatsApp', 'ar' => 'واتساب'],
            'icon' => 'fa-brands fa-whatsapp',
        ]);

        SocialMedia::create([
            'name' => ['en' => 'Telegram', 'ar' => 'تيليجرام'],
            'icon' => 'fa-brands fa-telegram',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Snapchat', 'ar' => 'سناب شات'],
            'icon' => 'fa-brands fa-snapchat',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'TikTok', 'ar' => 'تيك توك'],
            'icon' => 'fa-brands fa-tiktok',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Pinterest', 'ar' => 'بينتيريست'],
            'icon' => 'fa-brands fa-pinterest',
        ]);

        SocialMedia::create([
            'name' => ['en' => 'Reddit', 'ar' => 'ريدت'],
            'icon' => 'fa-brands fa-reddit',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Tumblr', 'ar' => 'تمبلر'],
            'icon' => 'fa-brands fa-tumblr',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Flickr', 'ar' => 'فليكر'],
            'icon' => 'fa-brands fa-flickr',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Vimeo', 'ar' => 'فيميو'],
            'icon' => 'fa-brands fa-vimeo',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Discord', 'ar' => 'ديسكورد'],
            'icon' => 'fa-brands fa-discord',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Quora', 'ar' => 'كورا'],
            'icon' => 'fa-brands fa-quora',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'Medium', 'ar' => 'ميديوم'],
            'icon' => 'fa-brands fa-medium',
        ]);
        SocialMedia::create([
            'name' => ['en' => 'WhatsApp Business', 'ar' => 'واتساب بيزنس'],
            'icon' => 'fa-brands fa-whatsapp',
        ]);


    }
}
