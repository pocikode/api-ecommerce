<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.admin', ['only' => ['create', 'update', 'delete']]);
    }

    # show all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    # show by id
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success'   => false,
                'message'   => 'Category Not Found!',
                'data'      => ''
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    # create category
    public function create(Request $req)
    {
        $this->validate($req, ['name' => 'required']);

        $category = Category::create([
            'name'  => $req->name
        ]);

        if ($category) {
            return response()->json([
                'success'   => true,
                'message'   => 'New category has been created',
                'data'      => $category
            ]);
        }
    }

    # update category
    public function update(Request $req, $id)
    {
        $this->validate($req, ['name' => 'required']);

        $category   = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category Not Found'], 404);
        }

        $update     = $category->update(['name' => $req->name]);

        return response()->json([
            'success' => true,
            'message' => 'Category updated!',
        ]);
    }

    # delete category
    public function delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category Not Found'], 404);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted!']);
    }
}
