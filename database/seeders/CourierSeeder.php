<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Models\Courier;
use App\Models\ServiceCourier;
use DB;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('couriers')->delete();
        DB::table('service_courier')->delete();

        $data = [
            ['id'=> 1, 'code' => 'jne', 'title' => 'JNE'],
            ['id'=> 2, 'code' => 'pos', 'title' => 'POS Indonesia'],
            ['id'=> 3, 'code' => 'tiki', 'title' => 'TIKI'],
            ['id'=> 4, 'code' => 'sicepat', 'title' => 'SiCepat'],
            ['id'=> 5, 'code' => 'jnt', 'title' => 'JNT']
        ];
        Courier::insert($data);

        $service = [
            ['courier_id'=> 1, 'code' => 'REG', 'title' => 'Reguler'],
            ['courier_id'=> 1, 'code' => 'OKE', 'title' => 'Ongkos Kirim Ekonomis'],
            ['courier_id'=> 2, 'code' => 'Paket Kilat Khusus', 'title' => 'Paket Kilat Khusus'],
            ['courier_id'=> 3, 'code' => 'REG', 'title' => 'Reguler'],
            ['courier_id'=> 4, 'code' => 'REG', 'title' => 'Reguler'],
            ['courier_id'=> 4, 'code' => 'SIUNT', 'title' => 'SiUntung'],
            // ['courier_id'=> 4, 'code' => 'GOKIL', 'title' => 'Cargo (Minimal 10kg)'],
            ['courier_id'=> 5, 'code' => 'EZ', 'title' => 'Reguler'],
        ];
        ServiceCourier::insert($service);
    }
}
