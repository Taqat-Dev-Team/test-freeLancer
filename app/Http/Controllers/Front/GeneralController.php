<?php

namespace App\Http\Controllers\Front;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\EducationLevlesResource;
use App\Http\Resources\SkillsResource;
use App\Http\Resources\SocialMediaResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Skills;
use App\Models\SocialMedia;
use App\Models\SubCategory;

class GeneralController extends Controller
{
    use ApiResponseTrait;

    public function languages()
    {
        $langs = Language::all();
        return $this->apiResponse(
            $langs,
            __('messages.success'),
            true,
            200,
        );
    }

    public function languages_levels()
    {
        $langs = languages_levels();
        return $this->apiResponse(
            $langs,
            __('messages.success'),
            true,
            200,
        );
    }


    public function categories()
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            CategoryResource:: collection($categories),
            __('messages.success'),
            true,
            200,
        );

    }


    public function countries()
    {
        $countries = Country::all();
        if ($countries->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            CountryResource:: collection($countries),
            __('messages.success'),
            true,
            200,
        );

    }

    public function skills()
    {
        $countries = Skills::all();
        if ($countries->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            SkillsResource:: collection($countries),
            __('messages.success'),
            true,
            200,
        );

    }


    public function categorySkills($id)
    {
        $countries = Skills::where('category_id', $id)->get();
        if ($countries->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            SkillsResource:: collection($countries),
            __('messages.success'),
            true,
            200,
        );

    }

    public function subCategories()
    {
        $subcategories = SubCategory::all();
        if ($subcategories->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            SubCategoryResource:: collection($subcategories),
            __('messages.success'),
            true,
            200,
        );

    }

    public function CategorySubcategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();
        if ($subcategories->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            SubCategoryResource:: collection($subcategories),
            __('messages.success'),
            true,
            200,
        );

    }

    public function education_levels()
    {
        $levels = EducationLevel::all();
        if ($levels->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            EducationLevlesResource::collection($levels),
            __('messages.success'),
            true,
            200,
        );

    }

    public function grade()
    {
        $levels =AcademicGrade();
        if ($levels->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            $levels,
            __('messages.success'),
            true,
            200,
        );

    }

    public function work_type()
    {
        $type = work_type();
        return $this->apiResponse(
            $type,
            __('messages.success'),
            true,
            200,
        );
    }

    public function social()
    {
        $social = SocialMedia::all();
        if ($social->isEmpty()) {
            return $this->apiResponse(
                null,
                __('messages.success'),
                true,
                200,
            );
        }
        return $this->apiResponse(
            SocialMediaResource::collection($social),
            __('messages.success'),
            true,
            200,
        );

    }

    public function policies()
    {
        $data = '  <p>نحن في [اسم الموقع] نولي أهمية كبيرة لخصوصيتك. تهدف سياسة الخصوصية هذه إلى شرح كيفية جمع معلوماتك الشخصية واستخدامها ومشاركتها عند زيارة موقعنا.</p>

  <h2>1. المعلومات التي نجمعها</h2>
  <p>قد نقوم بجمع معلومات شخصية مثل الاسم، البريد الإلكتروني، رقم الهاتف، وعنوان IP عند التسجيل أو استخدام خدماتنا.</p>

  <h2>2. كيفية استخدام المعلومات</h2>
  <p>نستخدم المعلومات لتحسين تجربتك، الرد على الاستفسارات، إرسال التحديثات، وتحليل استخدام الموقع.</p>

  <h2>3. مشاركة المعلومات</h2>
  <p>لا نقوم ببيع أو تأجير معلوماتك الشخصية لأطراف خارجية. قد نشاركها مع مزودي الخدمات الذين يساعدوننا في تشغيل الموقع.</p>

  <h2>4. ملفات تعريف الارتباط (Cookies)</h2>
  <p>نستخدم ملفات تعريف الارتباط لتحسين أداء الموقع وتخصيص المحتوى.</p>

  <h2>5. حقوقك</h2>
  <p>يحق لك الوصول إلى معلوماتك الشخصية وتصحيحها أو طلب حذفها.</p>

  <h2>6. التغييرات على السياسة</h2>
  <p>قد نقوم بتحديث هذه السياسة من وقت لآخر. سيتم نشر أي تغييرات على هذه الصفحة.</p>

  <h2>7. الاتصال بنا</h2>
  <p>لأي استفسارات حول سياسة الخصوصية، يرجى الاتصال بنا على: [البريد الإلكتروني].</p>';

        return $this->apiResponse(
            $data,
            __('messages.success'),
            true,
            200,

        );

    }

}
