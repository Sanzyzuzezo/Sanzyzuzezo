<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'name' => 'Brand 1',
            'image' => '',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'company_id' => 0
        ]);
    }
}
