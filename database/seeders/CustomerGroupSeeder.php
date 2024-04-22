<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_groups')->insert([
            'name' => 'Customer Group 1',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'company_id' => 0
        ]);
    }
}
