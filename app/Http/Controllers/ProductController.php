<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    # show all product
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    #show product info
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ], 404);
        }

        return response()->json($product);
    }

    # show product, sort by category and sub category
    public function sort(Request $req, int $idCategory, int $idSub = null)
    {
        $idSub = $req->get('idSub') ?? null;

        if (!$idSub) {
            $products = Product::where('category_id', $idCategory)->get()->all();
            return response()->json($products);
        } else {
            $products = Product::where('category_id', $idCategory)->where('sub_category_id', $idSub)->get()->all();
            return response()->json($products);
        }
    }

    # create product
    public function create(Request $req)
    {
        $this->validateForm($req);

        $data = Product::create([
            'code'  => $req->code,
            'name'  => $req->name,
            'category_id' => $req->category_id,
            'sub_category_id' => $req->sub_category_id,
            'price' => $req->price,
            'weight'=> $req->weight,
            'image' => $req->image,
            'description' => $req->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created!',
            'data'    => $data
        ]);
    }

    # update product
    public function update(Request $req, $id)
    {
        $this->validateForm();

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ], 404);
        }

        $update = $product->update($req->all());
        return response()->json([
            'success' => true,
            'message' => 'Product updated!'
        ]);
    }

    # delete product
    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ], 404);
        }

        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted!'
        ]);
    }

    # validate form-data
    private function validateForm(Request $req)
    {
        $this->validate($req, [
            'code' => 'required|max:100',
            'name' => 'required|max:100',
            'category_id' => 'integer|required',
            'sub_category_id' => 'integer|required',
            // 'brand_id' => 'integer|required',
            // 'point' => 'integer|required',
            'price' => 'integer|required',
            'weight'=> 'integer|required',
            'image'=> 'string|required',
            'description' => 'required'
        ]);
    }
}
