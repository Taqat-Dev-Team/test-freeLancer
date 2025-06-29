<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEducationLevelRequest;
use App\Http\Requests\Admin\UpdateEducationLevelRequest;
use App\Models\EducationLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EducationLevelController extends Controller
{

    public function index()
    {

        return view('admin.management.education_levels.index');
    }


    public function getData(Request $request)
    {
        $levels = EducationLevel::query();

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $levels = $levels->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"]);
            });
        }


        return DataTables::of($levels)
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-level" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-level btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function show($id)
    {
        $level = EducationLevel::findOrFail($id);
        return response()->json([
            'id' => $level->id,
            'name_en' => $level->getTranslation('name', 'en'),
            'name_ar' => $level->getTranslation('name', 'ar'),
        ]);
    }


    public function store(StoreEducationLevelRequest $request)
    {
        $level = new EducationLevel();
        $level->setTranslation('name', 'en', $request->name_en);
        $level->setTranslation('name', 'ar', $request->name_ar);

        $level->save();

        return response()->json(['success' => true, 'message' => 'Level created successfully']);
    }


    public function update(UpdateEducationLevelRequest $request, $id)
    {
        try {
            $level = EducationLevel::findOrFail($id);
            $level->setTranslation('name', 'en', $request->name_en);
            $level->setTranslation('name', 'ar', $request->name_ar);
            $level->save();

            return response()->json(['success' => true, 'message' => 'Level updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Education level not found.'], 404);
        }
    }


public
function destroy($id)
{
    try {
        $level = EducationLevel::findOrFail($id);
        $level->delete();
        return response()->json(['success' => true, 'message' => 'Education level deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Education level not found.'], 404);
    }
}

}
