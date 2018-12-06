<?php

namespace App\Http\Controllers;

use Steevenz\Rajaongkir;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;

/**
 * Data city, province, and get ongkir
 */
class OngkirController extends Controller
{
    private $rajaOngkir;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rajaOngkir = new Rajaongkir(env('RO_KEY'), env('RO_TYPE'));
    }

    public function province(Request $req)
    {
        # get province_id
        $idProvince = $req->get('id');
        if (!$idProvince) {
            # if no province_id
            $province = Province::all();
        } else {
            # if province_id exists
            $province = Province::find($idProvince);
        }

        return response()->json($province);
    }

    public function city(Request $req)
    {
        $idCity = $req->get('id');
        $idProvince = $req->get('province');

        if (!$idCity && !$idProvince) {
            $city = City::all();
        } elseif (!$idCity && $idProvince) {
            $city = City::where('province_id', $idProvince)->get()->all();
        } elseif ($idCity && !$idProvince) {
            $city = City::find($idCity);
        }

        return response()->json($city);
    }

    public function cost(Request $req)
    {
        $cost = $this->rajaOngkir->getCost(
            ['city' => $req->get('origin')], # origin city
            ['city' => $req->get('destination')], # destination city
            $req->get('weight'), # wight in gram
            $req->get('courier') # courier
        );

        return response()->json($cost);
    }
}
