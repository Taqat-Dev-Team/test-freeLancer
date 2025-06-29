<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSocialRequest;
use App\Http\Requests\Admin\UpdateSocialRequest;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class SocialMediaController extends Controller
{
    public function index()
    {
        return view('admin.management.social_media.index');

    }

    public function getData(Request $request)
    {
        $socials = SocialMedia::query();

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $socials = $socials->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"]);
            });
        }

        return DataTables::of($socials)

            ->addColumn('actions', function ($row) {

                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-social" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-social btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['icon','actions'])
            ->make(true);
    }

    public function store(StoreSocialRequest $request)
    {
        try {
            $social = new SocialMedia();
            $social->setTranslation('name', 'en', $request->name_en);
            $social->setTranslation('name', 'ar', $request->name_ar);
            $social->icon = $request->icon;
            $social->save();

            return response()->json(['message' => 'Social added successfully.']);
        } catch (\Exception $e) {
            Log::error("Social creation error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }

    public function show($id)
    {
        $social = SocialMedia::findOrFail($id);
        return response()->json([
            'id' => $social->id,
            'name_en' => $social->getTranslation('name', 'en'),
            'name_ar' => $social->getTranslation('name', 'ar'),
            'icon' => $social->icon,
        ]);
    }
    public function update(UpdateSocialRequest $request, $id)
    {
        try {
            $social = SocialMedia::findOrFail($id);
            $social->setTranslation('name', 'en', $request->name_en);
            $social->setTranslation('name', 'ar', $request->name_ar);
            $social->icon = $request->icon;
            $social->save();

            return response()->json(['message' => 'Social updated successfully.']);
        } catch (\Exception $e) {
            Log::error("Social update error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }

    public function destroy($id)
    {
        $social = SocialMedia::findOrFail($id);
        $social->delete();
        return response()->json(['success' => true, 'message' => 'Social media deleted successfully.']);

    }
}
