<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Kecamatan;
use App\Service\ServiceRajaOngkir;
use DB;

class KecamatanSeeder extends Seeder
{
    public function run() {

        DB::table('kecamatans')->delete();

        $cities = City::get();
        $services = new ServiceRajaOngkir;
        foreach ($cities as $city) {
            $kecamatan_list = json_decode($services->getKecamatan($city['city_id']), true);
            foreach ($kecamatan_list['rajaongkir']['results'] ?? [] as $kecamatan) {
                Kecamatan::create([
                    'id' => $kecamatan['subdistrict_id'] ?? '',
                    'province_id' => $city['province_id'] ?? '',
                    'city_id' => $city['city_id'] ?? '',
                    'subdistrict_id' => $kecamatan['subdistrict_id'] ?? '',
                    'title' => $kecamatan['subdistrict_name'] ?? '',
                ]);
            }
        }

    }
}
