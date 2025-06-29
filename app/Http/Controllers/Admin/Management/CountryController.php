<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCountryRequest;
use App\Http\Requests\Admin\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function index()
    {
        return view('admin.management.countries.index');
    }

    public function getData(Request $request)
    {
        $categories = Country::query();

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $categories = $categories->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"])
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhere('number_code', 'LIKE', "%{$search}%");

            });
        }

        return DataTables::of($categories)
            ->editColumn('status', function ($row) {
                $checked = $row->status == 1 ? 'checked' : '';
                return '<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                <label class="form-check-label">' . ($row->status ? 'Active' : 'Inactive') . '</label>
            </div>';
            })
            ->addColumn('flag', function ($row) {
                return '<img src="' . $row->flag . '"  class="w-30px h-30px rounded-circle"  alt="Flag">';
            })
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-country" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-country btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['icon', 'actions', 'flag', 'status'])
            ->make(true);
    }


    public function changeStatus(Request $request)
    {
        $category = Country::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }


    public function store(StoreCountryRequest $request)
    {
        try {
            $country = new Country();
            $country->setTranslation('name', 'en', $request->name_en);
            $country->setTranslation('name', 'ar', $request->name_ar);
            $country->code = $request->code;
            $country->number_code = $request->number_code;
            $country->save();


            return response()->json(['message' => 'Country added successfully.']);
        } catch (\Exception $e) {
            Log::error("Country creation error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }

    public function show($id)
    {
        $country = Country::findOrFail($id);
        return response()->json([
            'id' => $country->id,
            'name_en' => $country->getTranslation('name', 'en'),
            'name_ar' => $country->getTranslation('name', 'ar'),
            'code' => $country->code,
            'number_code' => $country->number_code,
        ]);
    }


    public function update(UpdateCountryRequest $request, $id)
    {
        try {
            $country = Country::findOrFail($id);

            $country->setTranslation('name', 'en', $request->name_en);
            $country->setTranslation('name', 'ar', $request->name_ar);
            $country->code = $request->code;
            $country->number_code = $request->number_code;
            $country->save();


            return response()->json(['message' => 'Country updated successfully.']);
        } catch (\Exception $e) {
            Log::error("Country update error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }


    public function destroy($id)
    {
        $category = Country::findOrFail($id);

        if ($category->users()->count() > 0) {
            return response()->json(['message' => 'Cannot delete Country with Users.'], 400);
        }

        $category->delete();

        return response()->json(['message' => 'Country deleted successfully.']);
    }
}
