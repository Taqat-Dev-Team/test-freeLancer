<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\Http\Controllers\Controller;
use App\ApiResponseTrait;
use App\Http\Requests\Front\Freelancer\StorePortfolioRequest;
use App\Http\Requests\Front\Freelancer\UpdatePortfolioRequest;
use App\Http\Resources\PortfolioResource;
use App\Models\FreelancerPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PortfolioController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $portfolios = Auth::user()->freelancer->portfolios()->latest()->get();
        return $this->apiResponse(
            PortfolioResource::collection($portfolios),
            __('messages.portfolios_retrieved'),
            true,
            200
        );
    }

    public function store(StorePortfolioRequest $request)
    {
        $portfolio = FreelancerPortfolio::create([
            'title' => $request->title,
            'tags' => $request->tags ?? '',
            'freelancer_id' => Auth::user()->freelancer->id,
            'content' => [],
        ]);

        if ($request->hasFile('main_image')) {
            $portfolio->addMediaFromRequest('main_image')
                ->usingFileName(Str::random(20) . '.' . $request->file('main_image')->getClientOriginalExtension())
                ->toMediaCollection('main_images', 'Portfolio');
        }

        $processedContent = $this->processContentBlocks($request, $portfolio);
        if ($processedContent instanceof \Illuminate\Http\JsonResponse) return $processedContent;

        $portfolio->update(['content' => $processedContent]);

        return $this->apiResponse(
            new PortfolioResource($portfolio),
            __('messages.portfolio_added'),
            true,
            201
        );
    }

    public function show($id)
    {
        $portfolio = Auth::user()->freelancer->portfolios()->find($id);

        if (!$portfolio) {
            return $this->apiResponse([], __('messages.portfolio_not_found'), false, 404);
        }

        return $this->apiResponse(new PortfolioResource($portfolio), __('messages.portfolio_retrieved'), true, 200);
    }

    public function update(UpdatePortfolioRequest $request, $id)
    {
        $portfolio = Auth::user()->freelancer->portfolios()->find($id);

        if (!$portfolio) {
            return $this->apiResponse([], __('messages.portfolio_not_found'), false, 404);
        }

        $portfolio->update([
            'title' => $request->title,
            'tags' => $request->tags ?? '',
        ]);

        if ($request->hasFile('main_image')) {
            $portfolio->clearMediaCollection('main_images');
            $portfolio->addMediaFromRequest('main_image')
                ->usingFileName(Str::random(20) . '.' . $request->file('main_image')->getClientOriginalExtension())
                ->toMediaCollection('main_images', 'Portfolio');
        }

        $processedContent = $this->processContentBlocks($request, $portfolio);
        if ($processedContent instanceof \Illuminate\Http\JsonResponse) return $processedContent;

        $portfolio->update(['content' => $processedContent]);

        return $this->apiResponse(
            new PortfolioResource($portfolio),
            __('messages.portfolio_updated'),
            true,
            200
        );
    }

    public function destroy($id)
    {
        $portfolio = Auth::user()->freelancer->portfolios()->find($id);

        if (!$portfolio) {
            return $this->apiResponse([], __('messages.portfolio_not_found'), false, 404);
        }

        $portfolio->clearMediaCollection('main_images');
        $portfolio->clearMediaCollection('content_images');
        $portfolio->delete();

        return $this->apiResponse([], __('messages.portfolio_deleted'), true, 200);
    }

    public function deleteContentBlock(Request $request, $projectId)
    {
        $request->validate(['block_index' => 'required|integer']);
        $portfolio = Auth::user()->freelancer->portfolios()->find($projectId);

        if (!$portfolio) {
            return $this->apiResponse([], __('messages.portfolio_not_found'), false, 404);
        }

        $content = $portfolio->content;
        $index = $request->block_index;

        if (!isset($content[$index])) {
            return $this->apiResponse([], __('messages.content_block_not_found'), false, 404);
        }

        $block = $content[$index];
        if ($block['type'] === 'image' && isset($block['media_id'])) {
            $media = Media::find($block['media_id']);
            if ($media) $media->delete();
        }

        unset($content[$index]);
        $portfolio->update(['content' => array_values($content)]);

        return $this->apiResponse(
            new PortfolioResource($portfolio),
            __('messages.block_deleted'),
            true,
            200
        );
    }

    private function processContentBlocks(Request $request, FreelancerPortfolio $portfolio)
    {
        $processedContent = [];

        foreach ($request->input('content_blocks', []) as $index => $block) {
            if ($block['type'] === 'text') {
                if (empty($block['value'])) {
                    return $this->apiResponse([], __('messages.text_required'), false, 422);
                }

                $processedContent[] = [
                    'type' => 'text',
                    'value' => $block['value'],
                ];
            }

            if ($block['type'] === 'image') {
                $fileKey = "content_blocks.$index.file";

                if (!$request->hasFile($fileKey)) {
                    return $this->apiResponse([], __('messages.image_required') . ' #' . ($index + 1), false, 422);
                }

                $imageFile = $request->file($fileKey);

                $mediaItem = $portfolio->addMedia($imageFile)
                    ->usingFileName(Str::random(20) . '.' . $imageFile->getClientOriginalExtension())
                    ->toMediaCollection('content_images', 'Portfolio');

                $processedContent[] = [
                    'type' => 'image',
                    'media_id' => $mediaItem->id,
                ];
            }
        }

        return $processedContent;
    }
}
