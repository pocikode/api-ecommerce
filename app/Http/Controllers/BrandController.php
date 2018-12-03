<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
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

    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found!'
            ], 404);
        }

        return response()->json($brand);
    }

    public function create(Request $req)
    {
        $this->validate($req, [
            'name' =>'required',
            'website' => 'required'
        ]);

        $data = Brand::create($req->all());
        return response()->json([
            'success'   => true,
            'message'   => 'New brand created!',
            'data'      => $data
        ]);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'name' => 'required',
            'website' => 'required'
        ]);

        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found!'
            ], 404);
        }

        $update = $brand->update($req->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated!'
        ]);
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found!'
            ], 404);
        }

        $brand->delete();
        return response()->json([
            'success' => true,
            'message' => 'Brand ' .$brand->name. ' deleted!' 
        ]);
    }
}
