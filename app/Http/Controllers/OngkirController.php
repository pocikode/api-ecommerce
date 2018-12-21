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
        $origin     = $req->get('origin'); # origin city
        $destination= $req->get('destination'); # destination city
        $weight     = $req->get('weight'); # wight in gram
        $courier    = $req->get('courier'); # courier

        $cost = $this->rajaOngkir->getCost(
            ['city' => $origin], # origin city
            ['city' => $destination], # destination city
            $weight, # wight in gram
            $courier # courier
        );

        return response()->json($cost);
    }

    public function courier(Request $req)
    {
        $destination = $req->get('destination'); # destination city
        $weight = $req->get('weight'); # wight in gram

        $data = [
            'origin'        => env('WAREHOUSE_LOCATION'),
            'destination'   => $destination,
            'weight'        => $weight . ' grams',
        ];

        $couriers = \App\Resources\CourierResources::get($destination, $weight);

        $merge = array_merge($data, $couriers);

        return response()->json($merge);
    }
}
