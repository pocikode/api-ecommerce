<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;

class SubCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        # set middleware
        $this->middleware('jwt.admin', ['only' => ['create', 'update', 'delete']]);
    }

    # show all sub categories
    public function index()
    {
        $subCategories = SubCategory::all();
        return response()->json($subCategories);
    }

    # show sub category by id
    public function show($id)
    {
        $subCategory = SubCategory::find($id);
        
        # if data is null
        if (!$subCategory) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found!'], 404);
        }

        return response()->json($subCategory);
    }

    # show sub category by category id
    public function showCategory(Request $req, $catID = null)
    {
        $catID = $req->get('catId');
        $subCategory = Category::where('category_id', $catID)->get()->all();
        if (!$subCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not FOund!'
            ], 404);
        }

        return response()->json($catID);
    }

    # store sub category
    public function create(Request $req)
    {
        $this->validateData($req); # validate form data

        # validate category
        if (!$this->checkCategory($req->category_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Category Not Found!'
            ], 400);
        }

        # create data
        $subCategory = SubCategory::create([
            'category_id'   => $req->category_id,
            'name'  => $req->name,
            'icon'  => 'null'
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'New Sub Category has created!',
            'data'      => $subCategory
        ]);
    }

    # update sub category
    public function update(Request $req, $id)
    {
        $this->validateData($req); # validate form data

        # validate category
        if (!$this->checkCategory($req->category_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Category Not Found!'
            ], 400);
        }

        # check if sub category exists
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found!'], 404);
        }

        $update = $subCategory->update($req->all());
        return response()->json(['success' => true, 'message' => 'Data Updated!']);
    }

    # delete sub category
    public function delete($id)
    {
        # check if sub category exists
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found!'], 404);
        }

        $subCategory->delete();
        return response()->json(['success' => true, 'message' => 'Data Deleted!']);
    }

    # validate form data
    private function validateData(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'category_id' => 'required',
            // 'icon' => 'required'
        ]);
    }

    # CHECK CATEGORY
    private function checkCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            return true;
        }
    }
}
