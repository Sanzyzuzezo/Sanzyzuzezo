<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'brand_id' => '1',
            'category_id' => '1',
            'name' => 'Product 1',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'company_id' => 0
        ]);
        
        DB::table('product_variants')->insert([
            'product_id' => '1',
            'sku' => '001',
            'name' => 'Variant 1',
            'price' => '100000',
            'minimal_stock' => '10',
            'weight' => '100.00',
            'dimensions' => '{"length":"10","width":"3","height":"2"}',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
