<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Freelancer\AbouteRequest;
use App\Http\Requests\Front\Freelancer\LanguagesRequest;
use App\Http\Requests\Front\Freelancer\SaveDataRequest;
use App\Http\Requests\Front\Freelancer\SkillsRequest;
use App\Http\Requests\Front\Freelancer\SocialsRequest;
use App\Http\Requests\Front\Freelancer\SummaryRequest;
use App\Http\Resources\ProfileCompleteResource;
use App\Http\Resources\SummaryResource;
use App\Http\Resources\UserResource;
use App\Models\FreeLancerSocialMedia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class ProfileController extends Controller
{
    use ApiResponseTrait;

    public function profileComplete()
    {
        try {
            $user = Auth::user();
            return $this->apiResponse(
                new ProfileCompleteResource($user),
                __('messages.success'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error get user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.failed'), false, 500);


        }
    }

    public function saveData(SaveDataRequest $request)
    {
        $user = Auth::user();
        $token = $this->extractBearerToken($request);

        if ($user->save_data) {
            return $this->apiResponse(
                ['save_data' => 1],
                __('messages.Access Denied, already saved data'),
                false,
                401
            );
        }

        try {


            $user->fill([
                'name' => $request->name,
                'bio' => $request->bio ?? '',
                'birth_date' => $request->birth_date,
                'country_id' => $request->country_id,
                'gender' => $request->gender,
                'save_data' => 1,
                'mobile' => $request->mobile,
            ]);

            if ($request->hasFile('photo')) {
                $user->clearMediaCollection('photo');
                $user->addMediaFromRequest('photo')
                    ->usingFileName(Str::random(20) . '.' . $request->file('photo')->getClientOriginalExtension())
                    ->toMediaCollection('photo', 'freelancers');
            }

            // تحديث بيانات الفريلانسر المرتبطة
            $freelancer = $user->freelancer;
            $freelancer->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'available_hire' => $request->available_hire ?? false,
                'hourly_rate' => $request->hourly_rate ?? null,
            ]);

            if ($request->has('skills')) {
                $skills = $request->input('skills');
                if (is_string($skills)) {
                    $skills = json_decode($skills, true);
                }

                $freelancer->skills()->sync($skills);
            }

            $user->save();

            $user->load([
                'freelancer.skills',
                'freelancer.category',
                'freelancer.subCategory'
            ]);

            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);
        }
    }

    public function updateAbout(AbouteRequest $request)
    {
        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);
            $freelancer = $user->freelancer;

            $user->update(['country_id' => $request->country_id]);

            $freelancer->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'available_hire' => $request->available_hire ?? false,
                'hourly_rate' => $request->hourly_rate ?? null,

            ]);


            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );

        } catch (Exception $e) {
            Log::error('Error saving user data.', ['user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }
    }


    public function updateSkills(SkillsRequest $request)
    {

        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);

            $freelancer = $user->freelancer;
            $skills = $request->input('skills');

            if (is_string($skills)) {
                $skills = json_decode($skills, true);
            }

            if (is_array($skills)) {
                $freelancer->skills()->sync($skills);
            }


            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }
    }


    public function updateLanguages(LanguagesRequest $request)
    {

        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);

            $freelancer = $user->freelancer;

            foreach ($request->languages as $lang) {
                $languageData[$lang['language_id']] = ['level' => $lang['level']];
            }

            $freelancer->languages()->sync($languageData);


            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }
    }

    public function updateSocials(SocialsRequest $request)
    {

        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);
            $freelancer = $user->freelancer;


            foreach ($request->socials as $social) {
                $Data[$social['social_id']] = ['link' => $social['link']];
            }

            $freelancer->socials()->sync($Data);

            if ($request->has('custom')) {
                foreach ($request->custom as $custom) {
                    FreeLancerSocialMedia::create([
                        'freelancer_id' => $freelancer->id,
                        'link' => $custom['link'],
                        'title' => $custom['title'] ?? null,
                    ]);
                }
            }

            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }
    }


    public function Summary()
    {
        try {
            $user = Auth::user();
            return $this->apiResponse(
                new SummaryResource($user),
                __('messages.success'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error get user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.failed'), false, 500);


        }
    }

    public function updateSummary(SummaryRequest $request)
    {
        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);
            $freelancer = $user->freelancer;

            $user->update([
                'bio' => $request->bio,
                'video' => $request->video,
                'video_title' => $request->video_title,
                'images_title' => $request->images_title,
            ]);



            // معالجة الصور
            if ($request->hasFile('images')) {
                // احذف الصور السابقة إن وجدت
                $freelancer->clearMediaCollection('images');

                foreach ($request->file('images') as $image) {
                    $freelancer->addMedia($image)
                        ->usingFileName(Str::random(20) . '.' . $image->getClientOriginalExtension())
                        ->toMediaCollection('images', 'freelancersImages'); // استخدم disk الصحيح
                }
            }


            return $this->apiResponse(
                new SummaryResource($user),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);


        }
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);


            if ($request->hasFile('photo')) {
                $user->clearMediaCollection('photo');
                $user->addMediaFromRequest('photo')
                    ->usingFileName(Str::random(20) . '.' . $request->file('photo')->getClientOriginalExtension())
                    ->toMediaCollection('photo', 'freelancers');
            }

            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user image.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);
        }

    }

    public function deleteImageSummary($id)
    {
        try {
            $user = Auth::user();
            $freelancer = $user->freelancer;

            $media = Media::findOrFail($id);

            // التأكد أن الوسيط يخص الفريلانسر الحالي
            if ($media->model_type === get_class($freelancer) && $media->model_id === $freelancer->id) {
                $media->delete();

                return $this->apiResponse([], __('messages.Image deleted successfully'), true, 200);
            } else {
                return $this->apiResponse([], __('messages.Unauthorized'), false, 403);
            }

        } catch (\Exception $e) {
            Log::error('Error deleting image', [
                'user_id' => Auth::id(),
                'image_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return $this->apiResponse([], __('messages.Image delete failed'), false, 500);
        }

    }
}
