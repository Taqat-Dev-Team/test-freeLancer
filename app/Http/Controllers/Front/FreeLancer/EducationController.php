<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\Http\Controllers\Controller;
use App\ApiResponseTrait;
use App\Http\Requests\Front\Freelancer\EducationRequest;
use App\Http\Resources\EducationResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EducationController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            $education = Auth::user()->freelancer->educations()->latest()->get();

            return $this->apiResponse(
                EducationResource::collection($education),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error fetching Education: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public function store(EducationRequest $request)
    {
        try {
            $data = $this->formatDates($request->validated());

            $education = Auth::user()->freelancer->educations()->create($data);

            return $this->apiResponse(
                new EducationResource($education),
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
            $education = Auth::user()->freelancer->educations()->find($id);

            if (!$education) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            return $this->apiResponse(
                new EducationResource($education),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error fetching work education: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public function update(EducationRequest $request, $id)
    {
        try {
            $education = Auth::user()->freelancer->educations()->find($id);

            if (!$education) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            $data = $this->formatDates($request->validated());
            $education->update($data);

            return $this->apiResponse(
                new EducationResource($education),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error updating  educations : ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }


    public function destroy($id)
    {
        try {
            $education = Auth::user()->freelancer->educations()->find($id);

            if (!$education) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            $education->delete();

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
