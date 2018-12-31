<?php

use Illuminate\Database\Seeder;
use Steevenz\Rajaongkir;
use App\Models\Province;
use App\Models\City;

class ProvincesAndCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->getProvinces();
        $this->getCities();
    }

    private function rajaOngkir()
    {
        return new Rajaongkir(env('RO_KEY'), env('RO_TYPE'));
    }

    private function getProvinces()
    {
        $provinces = $this->rajaOngkir()->getProvinces();
        foreach ($provinces as $province) {
            Province::create([
                'province_id'   => $province['province_id'],
                'province'      => $province['province']
            ]);
        }
    }

    private function getCities()
    {
        $cities = $this->rajaOngkir()->getCities();
        foreach ($cities as $city) {
            City::create([
                'city_id'   => $city['city_id'],
                'province_id'=> $city['province_id'],
                'province'  => $city['province'],
                'city_name' => $city['type'] .' '. $city['city_name']
            ]);
        }
    }
}
