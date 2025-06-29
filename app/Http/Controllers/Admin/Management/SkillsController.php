<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillsRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Skills;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SkillsController extends Controller
{
    public function index()

    {
        $categories = Category::all();
        return view('admin.management.skills.index', ['categories' => $categories]);
    }


    public function getData(Request $request)
    {
        $skills = Skills::with('category');

        if ($request->has('category_id') && is_array($request->category_id) && count(array_filter($request->category_id))) {
            $skills = $skills->whereIn('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $skills = $skills->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                            ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"]);
                    });

            });
        }

        return DataTables::of($skills)
            ->addColumn('icon', fn($row) => '<img src="' . $row->getImageUrl() . '" class="w-50px h-50px rounded-circle">')
            ->editColumn('category', fn($row) => '<span class="badge badge-light-primary">' . $row->category->getTranslation('name', 'en') . ' -- ' . $row->category->getTranslation('name', 'ar') . '</span>')
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-skill" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-skill btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['icon', 'actions', 'category'])
            ->make(true);
    }


    public function destroy($id)
    {
        $skill = Skills::findOrFail($id);

        if ($skill->users()->count() > 0) {
            return response()->json(['message' => 'Cannot delete Skills associated with users.'], 400);
        }

        $skill->clearMediaCollection('icon');
        $skill->delete();
        $skill->delete();
        return response()->json(['success' => true, 'message' => 'Skill deleted successfully.']);

    }

    public function store(StoreSkillsRequest $request)
    {
        try {
            $skill = new Skills();
            $skill->setTranslation('name', 'en', $request->name_en);
            $skill->setTranslation('name', 'ar', $request->name_ar);
            $skill->category_id = $request->category_id;
            $skill->save();

            if ($request->hasFile('icon')) {
                $skill->addMediaFromRequest('icon')
                    ->usingFileName(Str::random(20) . '.' . $request->file('icon')->getClientOriginalExtension())
                    ->toMediaCollection('icon', 'skills');
            }

            return response()->json(['message' => 'Skill added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }


    public function show($id)
    {
        $skill = Skills::findOrFail($id);
        return response()->json([
            'id' => $skill->id,
            'category_id' => $skill->category_id,
            'name_en' => $skill->getTranslation('name', 'en'),
            'name_ar' => $skill->getTranslation('name', 'ar'),
            'icon' => $skill->getFirstMediaUrl('icon', 'thumb'),
        ]);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {

        try {

        $skill = Skills::findOrFail($id);
        $skill->setTranslation('name', 'en', $request->name_en);
        $skill->setTranslation('name', 'ar', $request->name_ar);
        $skill->category_id = $request->category_id;
        $skill->save();

        if ($request->hasFile('icon')) {
            $skill->clearMediaCollection('icon');
            $skill->addMediaFromRequest('icon')
                ->usingFileName(Str::random(20) . '.' . $request->file('icon')->getClientOriginalExtension())
                ->toMediaCollection('icon', 'skills');
        }
        return response()->json(['message' => 'Skill updated successfully.']);


    }catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }

}
