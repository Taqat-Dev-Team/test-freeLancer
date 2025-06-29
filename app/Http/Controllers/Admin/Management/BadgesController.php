<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBadgeRequest;
use App\Http\Requests\Admin\UpdateBadgeRequest;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BadgesController extends Controller
{

    public function index()
    {
        return view('admin.management.badges.index');
    }

    public function getData(Request $request)
    {
        $badges = Badge::query();

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $badges = $badges->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(description, '$.ar'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(description, '$.en'))) LIKE ?", ["%{$search}%"]);
            });
        }

        return DataTables::of($badges)
            ->addColumn('icon', fn($row) => '<img src="' . $row->getImageUrl() . '" class="w-50px h-50px rounded-circle">')
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-badge" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-badge btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['icon', 'actions'])
            ->make(true);
    }

    public function store(StoreBadgeRequest $request)
    {
        try {
            $badge = new Badge();
            $badge->setTranslation('name', 'en', $request->name_en);
            $badge->setTranslation('name', 'ar', $request->name_ar);
            $badge->setTranslation('description', 'en', $request->description_en);
            $badge->setTranslation('description', 'ar', $request->description_ar);
            $badge->save();

            if ($request->hasFile('icon')) {
                $badge
                    ->addMediaFromRequest('icon')
                    ->usingFileName(Str::random(20) . '.' . $request->file('icon')->getClientOriginalExtension())
                    ->storingConversionsOnDisk('badges')
                    ->toMediaCollection('icon', 'badges');
            }

            return response()->json(['message' => 'Badges added successfully.']);
        } catch (\Exception $e) {
            Log::error("badges creation error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }


    public function show($id)
    {
        $badge = Badge::findOrFail($id);
        return response()->json([
            'id' => $badge->id,
            'name_en' => $badge->getTranslation('name', 'en'),
            'description_en' => $badge->getTranslation('description', 'en'),
            'name_ar' => $badge->getTranslation('name', 'ar'),
            'description_ar' => $badge->getTranslation('description', 'ar'),
            'icon' => $badge->getImageUrl(),
        ]);
    }


    public function update(UpdateBadgeRequest $request, $id)
    {

        try {
            $badge = Badge::findOrFail($id);

            $badge->setTranslation('name', 'en', $request->name_en);
            $badge->setTranslation('name', 'ar', $request->name_ar);
            $badge->setTranslation('description', 'en', $request->description_en);
            $badge->setTranslation('description', 'ar', $request->description_ar);
            $badge->save();

            if ($request->hasFile('icon')) {
                $badge->clearMediaCollection('icon');
                $badge->addMediaFromRequest('icon')
                    ->usingFileName(Str::random(20) . '.' . $request->file('icon')->getClientOriginalExtension())
                    ->toMediaCollection('icon', 'badges');
            }

            return response()->json(['message' => 'Badge updated successfully.']);
        } catch (\Exception $e) {
            Log::error("Badge update error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }

    }

    public function destroy($id)
    {
        $badge = Badge::withCount('freelancers')->findOrFail($id);

        if ($badge->freelancers_count > 0) {
            return response()->json([
                'message' => 'Cannot delete badge: It is assigned to one or more freelancers.'
            ], 400);
        }

        $badge->clearMediaCollection('icon');
        $badge->delete();

        return response()->json(['message' => 'Badge deleted successfully.']);
    }


}
