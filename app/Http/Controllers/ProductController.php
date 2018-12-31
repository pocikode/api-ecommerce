<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Cloudinary\Uploader;
use PhpOffice\PhpSpreadsheet\Reader;

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
        if (isset($_GET['search'])) {
            $products = \DB::table('products')->where('name', 'like', "%{$_GET['search']}%")
                                               ->orWhere('name', 'like', "%". strtoupper($_GET['search']) ."%")
                                               ->orWhere('name', 'like', "%". strtolower($_GET['search']) ."%")
                                               ->orWhere('name', 'like', "%". ucwords($_GET['search']) ."%")
                                               ->where('status', true)->get();
        } else {
            $products = Product::where('status', true)->get();
        }

        # encode size & stocks
        $dummyProd = [];
        foreach ($products as $product) {
            $product->sizes = json_decode($product->sizes);
            $product->stocks = json_decode($product->stocks);
            $dummyProd[] = $product;
        }

        return response($dummyProd);
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
        $product->stocks= json_decode($product->stocks);

        return response()->json($product);
    }

    # show product, sort by category and sub category
    public function sort(Request $req, int $idCategory)
    {
        # get id sub category
        $idSub = $req->get('idSub') ?? null;

        if (!$idSub) {
            # if id sub category is exists
            $products = Product::where('category_id', $idCategory)->get()->all();
        } else {
            # if id sub category is not exists
            $products = Product::where('category_id', $idCategory)->where('sub_category_id', $idSub)->get()->all();
        }

        $dummyProd = [];
        foreach ($products as $product) {
            $product->sizes = json_decode($product->sizes);
            $product->stocks= json_decode($product->stocks);
            $dummyProd[] = $product;
        }

        return response()->json($dummyProd);
    }

    # create product
    public function create(Request $req)
    {
        $this->validateForm($req);

        $category = Category::find($req->category_id);
        $subcategory = SubCategory::find($req->sub_category_id);

        $data = Product::create([
            'code'              => $req->code,
            'name'              => $req->name,
            'category_id'       => $req->category_id,
            'category_name'     => $category->name,
            'sub_category_id'   => $req->sub_category_id,
            'sub_category_name' => $subcategory->name,
            'price'             => $req->price,
            'weight'            => $req->weight,
            'image'             => $req->image,
            'description'       => $req->description,
            'sizes'             => json_encode($req->size),
            'stocks'            => json_encode($req->stock),
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
        $this->validate($req, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        $imageName = date('Ymd') . str_random(6);

        # Upload to Cloudinary
        $image = Uploader::upload($req->file('image')->getRealPath(), [
            'public_id' => $imageName,
            'folder'    => 'products'
        ]);

        return response()->json([
            'success' => true,
            'url' => $image['secure_url']
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
            
            exit();
        }

        $category = Category::find($req->category_id);
        $subcategory = SubCategory::find($req->sub_category_id);

        $update = $product->update([
            'code'              => $req->code,
            'name'              => $req->name,
            'category_id'       => $req->category_id,
            'category_name'     => $category->name,
            'sub_category_id'   => $req->sub_category_id,
            'sub_category_name' => $subcategory->name,
            'price'             => $req->price,
            'weight'            => $req->weight,
            'image'             => $req->image,
            'description'       => $req->description,
            'sizes'             => json_encode($req->size),
            'stocks'            => json_encode($req->stock),
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
            'code'              => 'required|max:100',
            'name'              => 'required|max:100',
            'category_id'       => 'integer|required',
            'sub_category_id'   => 'integer|required',
            'price'             => 'integer|required',
            'weight'            => 'integer|required',
            'image'             => 'required|string',
            'description'       => 'required',
            'size'              => 'required|array',
            'stock'             => 'required|array',
        ]);
    }

    # upload from excel
    public function import(Request $req)
    {
        # validate form 
        $this->validate($req, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        
        # get file extension
        $type = $req->file->getClientOriginalExtension();
        if ($type == 'xlsx') {
            $reader = new Reader\Xlsx();
        } elseif ($type == 'xls') {
            $reader = new Reader\Xls();
        }

        # load file
        $spreadsheet = $reader->load($req->file);

        # convert to array
        $data = $spreadsheet->getActiveSheet()->toArray();

        for ($i=1; $i < count($data); $i++) { 
            $insert = [
                'code'              => $data[$i][0],
                'name'              => $data[$i][1],
                'category_id'       => $data[$i][2],
                'category_name'     => Category::find($data[$i][2])->name,
                'sub_category_id'   => $data[$i][3],
                'sub_category_name' => SubCategory::find($data[$i][3])->name,
                'price'             => $data[$i][4],
                'weight'            => $data[$i][5],
                'image'             => $data[$i][6],
                'description'       => $data[$i][7],
                'sizes'             => $data[$i][8],
                'stocks'            => $data[$i][9],
            ];

            Product::insert($insert);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data uploaded!'
        ]);
    }
}
