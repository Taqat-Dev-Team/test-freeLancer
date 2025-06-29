<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLanguageRequest;
use App\Http\Requests\Admin\UpdateLanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class languageController extends Controller
{

    public function index()
    {
        return view('admin.management.languages.index');
    }

    public function getData(Request $request)
    {
        $badges = Language::query();

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $badges = $badges->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"]);
            });
        }

        return DataTables::of($badges)
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-language" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-language btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(StoreLanguageRequest $request)
    {
        try {
            $language = new Language();
            $language->setTranslation('name', 'en', $request->name_en);
            $language->setTranslation('name', 'ar', $request->name_ar);

            $language->save();


            return response()->json(['message' => 'Language added successfully.']);
        } catch (\Exception $e) {
            Log::error("Language creation error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }


    public function show($id)
    {
        $lang = Language::findOrFail($id);
        return response()->json([
            'id' => $lang->id,
            'name_en' => $lang->getTranslation('name', 'en'),
            'name_ar' => $lang->getTranslation('name', 'ar'),
        ]);
    }


    public function update(UpdateLanguageRequest $request, $id)
    {

        try {
            $language = Language::findOrFail($id);
            $language->setTranslation('name', 'en', $request->name_en);
            $language->setTranslation('name', 'ar', $request->name_ar);
            $language->save();

            return response()->json(['message' => 'Language updated successfully.']);
        } catch (\Exception $e) {
            Log::error("Language update error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }

    }

    public function destroy($id)
    {
        $badge = Language::findOrFail($id);
        $badge->delete();
        return response()->json(['message' => 'Language deleted successfully.']);
    }


}
