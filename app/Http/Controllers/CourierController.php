<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courier;

class CourierController extends Controller
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
        $couriers = Courier::all();
        if (!$couriers) {
            return response()->json([
                'message'   => 'Courier data is empty'
            ]);
        }

        return response()->json($couriers);
    }

    public function show($id)
    {
        $courier = Courier::find($id);
        if (!$courier) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $courier
        ]);
    }

    public function create(Request $req)
    {
        $this->validate($req, ['name' => 'required']);

        $courier = Courier::create(['name' => $req->name]);
        
        return response()->json([
            'success' => true,
            'message' => 'New Courier Created!',
            'data'    => $courier
        ]);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, ['name' => 'required']);

        $courier = Courier::find($id);
        if (!$courier) {
            return response()->json([
                'success' => false,
                'message' => 'COurier not found!'
            ], 404);
        }

        $courier->update(['name' => $req->name]);

        return response()->json([
            'success' => true,
            'message' => 'Data updated!'
        ]);
    }

    public function delete($id)
    {
        $courier = Courier::find($id);
        if (!$courier) {
            return response()->json([
                'success' => false,
                'message' => 'COurier not found!'
            ], 404);
        }

        $courier->delete();
        return response()->json([
            'success' => true,
            'message' => 'Courier data deleted!'
        ]);
    }
}
