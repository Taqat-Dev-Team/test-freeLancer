<?php

namespace App\Http\Controllers\Admin\Management;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubCategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class SubCategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('admin.management.subcategories.index', ['categories' => $categories]);
    }

    public function getData(Request $request)
    {
        $categories = SubCategory::with('category');

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $categories = $categories->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($request->has('category_id') && is_array($request->category_id) && count(array_filter($request->category_id))) {
            $categories = $categories->whereIn('category_id', $request->category_id);
        }


        return DataTables::of($categories)
            // Enable ordering by category name (in JSON)
            ->editColumn('category', fn($row) => '<span class="badge badge-light-primary">' . $row->category->getTranslation('name', 'en') . ' -- ' . $row->category->getTranslation('name', 'ar') . '</span>')
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-subcategory" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-subcategory btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['icon', 'actions', 'category'])
            ->make(true);
    }


    public function show($id)
    {
        $category = SubCategory::findOrFail($id);
        return response()->json([
            'id' => $category->id,
            'category_id' => $category->category_id,
            'name_en' => $category->getTranslation('name', 'en'),
            'name_ar' => $category->getTranslation('name', 'ar'),
        ]);
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $subcategory = new SubCategory();
        $subcategory->setTranslation('name', 'en', $request->name_en);
        $subcategory->setTranslation('name', 'ar', $request->name_ar);
        $subcategory->setTranslation('slug', 'en', Str::slug($request->name_en));
        $subcategory->setTranslation('slug', 'ar', Str::slug($request->name_ar));
        $subcategory->category_id = $request->category_id;
        $subcategory->save();

        return response()->json(['success' => true, 'message' => 'SubCategory created successfully']);
    }

    public function update(UpdateSubCategoryRequest $request, $id)
    {

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->setTranslation('name', 'en', $request->name_en);
        $subcategory->setTranslation('name', 'ar', $request->name_ar);
        $subcategory->setTranslation('slug', 'en', Str::slug($request->name_en));
        $subcategory->setTranslation('slug', 'ar', Str::slug($request->name_ar));
        $subcategory->category_id = $request->category_id;
        $subcategory->save();

        return response()->json(['success' => true, 'message' => 'SubCategory updated successfully']);
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();

        return response()->json(['success' => true, 'message' => 'SubCategory deleted successfully']);
    }


}
