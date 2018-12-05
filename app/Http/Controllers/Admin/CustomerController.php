<?php

namespace App\Http\Controllers\Admin;

use Laravel\Lumen\Routing\Controller;
use App\Models\Customer;

class CUstomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin', ['only' => ['index']]);
    }

    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }
}