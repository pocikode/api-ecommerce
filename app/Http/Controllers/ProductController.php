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
        $this->middleware('jwt.admin', ['only' => ['create', 'update', 'delete']]);
    }

    # show all product
    public function index()
    {
        $products = Product::where('status', true)->get()->all();

        $dummyProd = [];
        foreach ($products as $product) {
            $product->sizes = json_decode($product->sizes);
            $dummyProd[] = $product;
        }

        return response()->json($dummyProd);
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

        $product->sizes = json_decode($product->sizes);

        return response()->json($product);
    }

    # show product, sort by category and sub category
    public function sort(Request $req, int $idCategory)
    {
        $idSub = $req->get('idSub') ?? null;

        if (!$idSub) {
            $products = Product::where('category_id', $idCategory)->get()->all();
        } else {
            $products = Product::where('category_id', $idCategory)->where('sub_category_id', $idSub)->get()->all();
        }

        $dummyProd = [];
        foreach ($products as $product) {
            $product->sizes = json_decode($product->sizes);
            $dummyProd[] = $product;
        }

        return response()->json($dummyProd);
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
            'sizes' => $this->createSizes($req->size, $req->stock),
        ]);

        $data->sizes = json_decode($data->sizes);

        return response()->json([
            'success' => true,
            'message' => 'Product created!',
            'data'    => $data
        ]);
    }

    public function uploadImage(Request $req)
    {
        $imageName = date('Ymd') . str_random(6) . '.' . $req->image->getClientOriginalExtension();
        $req->image->move('./images/products/', $imageName);

        return response()->json([
            'success' => true,
            'url' => url('images/products/' . $imageName)
        ]);
    }

    # update product
    public function update(Request $req, $id)
    {
        $this->validateForm($req);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ], 404);
        }

        $update = $product->update([
            'code' => $req->code,
            'name' => $req->name,
            'category_id' => $req->category_id,
            'sub_category_id' => $req->sub_category_id,
            'price' => $req->price,
            'weight' => $req->weight,
            'image' => $req->image,
            'description' => $req->description,
            'sizes' => $this->createSizes($req->size, $req->stock),
        ]);

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
            'price' => 'integer|required',
            'weight'=> 'integer|required',
            'image' => 'required|string',
            'description' => 'required',
            'size'  => 'required|array',
            'stock' => 'required|array',
        ]);
    }

    # create sizes from size and stock
    private function createSizes(array $size, array $stock)
    {
        $sizes = [];

        for ($i = 0; $i < min(count($size), count($stock)); $i++) {
            $sizes[$size[$i]] = $stock[$i];
        }

        return json_encode($sizes, JSON_UNESCAPED_SLASHES);
    }
}
