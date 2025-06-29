<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\Http\Controllers\Controller;
use App\ApiResponseTrait;
use App\Http\Requests\Front\Freelancer\WorkExperienceRequest;
use App\Http\Resources\WorkExperienceResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkExperienceController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            $workExperiences = Auth::user()->freelancer->workExperiences()->latest()->get();

            return $this->apiResponse(
                WorkExperienceResource::collection($workExperiences),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error fetching work experiences: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public function store(WorkExperienceRequest $request)
    {
        try {
            $data = $this->formatDates($request->validated());

            $workExperience = Auth::user()->freelancer->workExperiences()->create($data);

            return $this->apiResponse(
                new WorkExperienceResource($workExperience),
                __('messages.success'),
                true,
                201
            );
        } catch (\Throwable $e) {
            Log::error('Error creating work experience: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public function show($id)
    {
        try {
            $workExperience = Auth::user()->freelancer->workExperiences()->find($id);

            if (!$workExperience) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            return $this->apiResponse(
                new WorkExperienceResource($workExperience),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error fetching work experience: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public function update(WorkExperienceRequest $request, $id)
    {
        try {
            $workExperience = Auth::user()->freelancer->workExperiences()->find($id);

            if (!$workExperience) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            $data = $this->formatDates($request->validated());
            $workExperience->update($data);

            return $this->apiResponse(
                new WorkExperienceResource($workExperience),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error updating work experience: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $workExperience = Auth::user()->freelancer->workExperiences()->find($id);

            if (!$workExperience) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            $workExperience->delete();

            return $this->apiResponse([], __('messages.success'), true, 200);
        } catch (\Throwable $e) {
            Log::error('Error deleting work experience: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    /**
     * Format date fields from 'm-Y' to full date.
     *
     * @param array $data
     * @return array
     */
    private function formatDates(array $data): array
    {
        $data['start_date'] = Carbon::createFromFormat('m-Y', $data['start_date'])->startOfMonth();

        if (!empty($data['end_date'])) {
            $data['end_date'] = Carbon::createFromFormat('m-Y', $data['end_date'])->startOfMonth();
        } else {
            $data['end_date'] = null;
        }

        return $data;
    }
}
