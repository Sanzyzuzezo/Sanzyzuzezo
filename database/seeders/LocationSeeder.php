<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Models\Province;
use App\Models\City;
use App\Models\Kecamatan;
use App\Service\ServiceRajaOngkir;
use DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        DB::table('provinces')->delete();
        DB::table('cities')->delete();
        $provinsi_id = 1;

        $services = new ServiceRajaOngkir;
        $province_list = json_decode($services->getProvince(), true);
        foreach ($province_list['rajaongkir']['results'] as $province) {
            Province::create([
                'id' => $provinsi_id,
                'province_id' => $province['province_id'],
                'title' => $province['province']
            ]);
            $city_list = json_decode($services->getCityByProvince($province['province_id']), true);
            foreach ($city_list['rajaongkir']['results'] as $city) {
                $region = $city['type'] . ' ' . $city['city_name'];
                City::create([
                    'id' => $city['city_id'],
                    'province_id' => $city['province_id'],
                    'city_id' => $city['city_id'],
                    'type' => $city['type'],
                    'title' => $city['city_name'],
                ]);
                // $kecamatan_list = json_decode($services->getKecamatan($city['city_id']), true);
                // foreach ($kecamatan_list['rajaongkir']['results'] as $kecamatan) {
                //     Kecamatan::create([
                //         // 'id' => $kecamatan['subdistrict_id'],
                //         'province_id' => $city['province_id'],
                //         'city_id' => $city['city_id'],
                //         'subdistrict_id' => $kecamatan['subdistrict_id'],
                //         'title' => $kecamatan['subdistrict_name'],
                //     ]);
                // }
            }
            $provinsi_id++;
        }
    }
}
