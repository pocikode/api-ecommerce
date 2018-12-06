<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function index()
    {
        $banks = Bank::all();
        if (!$banks) {
            return response()->json(['message' => 'Data Bank is Empty, please create one']);
        }

        return response()->json($banks);
    }

    public function show($id)
    {
        $bank = Bank::find($id);
        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found!'
            ], 404);
        }

        return response()->json($bank);
    }

    public function create(Request $req)
    {
        $this->validate($req, [
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name'   => 'required'
        ]);

        $bank = Bank::create($req->all());
        return response()->json([
            'success' => true,
            'message' => 'New Bank has been created!',
            'date'    => $bank
        ]);
    }

    public function update(Request $req, $id)
    {
        $bank = Bank::find($id);
        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found!'
            ], 404);
        }

        $this->validate($req, [
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required'
        ]);

        $bank->update($req->all());
        return response()->json([
            'success' => true,
            'message' => 'Data bank has been updated!'
        ]);
    }

    public function delete($id)
    {
        $bank = Bank::find($id);
        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found!'
            ], 404);
        }

        $bank->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data bank successfully deleted'
        ]);
    }
}
