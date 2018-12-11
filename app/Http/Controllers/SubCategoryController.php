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
    public function showCategory($catId)
    {
        $category = Category::find($catId);
        $subCategory = SubCategory::where('category_id', $catId)->get()->all();
        if (!$subCategory) {
            return response()->json([
                'success' => false,
                'message' => 'No Data, add subcategory first!'
            ], 200);
        }

        $data = new \stdClass();
        $data->category_id   = $category->category_id;
        $data->category_name = $category->name;
        $data->sub_total     = count($subCategory);
        $data->datasub       = $subCategory;

        return response()->json($data);
    }

    # store sub category
    public function create(Request $req)
    {
        $this->validate($req, [
            'name' => 'required|string',
            'category_id' => 'required',
            'image'=> 'required|string'
        ]);
        
        # check category
        $category = Category::find($req->category_id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category Not Found!'
            ], 404);
        }

        # create data
        $subCategory = SubCategory::create([
            'category_id'   => $req->category_id,
            'category_name' => $category->name,
            'name'  => $req->name,
            'icon'  => $req->image
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
        $this->validate($req, [
            'category_id' => 'required',
            'name' => 'required|string',
            'image'=> 'required|string'
        ]);

        # check if sub category exists
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found!'], 404);
        }

        # check category
        $category = Category::find($req->category_id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category Not Found!'
            ], 404);
        }

        $update = $subCategory->update([
            'category_id' => $req->category_id,
            'category_name' => $category->name,
            'name' => $req->name,
            'image'=> $req->image,
        ]);
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

    # upload sub category image
    public function uploadImage(Request $req)
    {
        $this->validate($req, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        $imageName = 'subcategory' . str_random(6) . '.' . $req->image->getClientOriginalExtension();
        $req->image->move('./images/subcategory/', $imageName);

        return response()->json([
            'success' => true,
            'url'     => url('images/subcategory/' . $imageName)
        ]);
    }
}
