<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DeleteOrderSeeder extends Seeder {

    public function run() {
        DB::table('orders')->delete();
        DB::table('order_items')->delete();
        DB::table('order_billings')->delete();
        DB::table('order_shippings')->delete();
    }
}
