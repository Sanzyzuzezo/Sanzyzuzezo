<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Category 1',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'company_id' => 0
        ]);
    }
}
