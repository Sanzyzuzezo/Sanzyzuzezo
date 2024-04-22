<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use DB;

class ModuleSeeder extends Seeder
{

    public function run() {

        DB::table('modules')->delete();

        $modules = [
            ['identifiers' => 'dashboard', 'name' => 'Dashboard'],
            ['identifiers' => 'item_groups', 'name' => 'Item Groups'],
            ['identifiers' => 'units', 'name' => 'Units'],
            ['identifiers' => 'warehouse', 'name' => 'Warehouse'],
            ['identifiers' => 'supplier', 'name' => 'Supplier'],
            ['identifiers' => 'unit_conversions', 'name' => 'Unit Conversions'],
            ['identifiers' => 'ingredients', 'name' => 'Ingredients'],
            ['identifiers' => 'stock_card', 'name' => 'Stock Card'],
            ['identifiers' => 'adjusment', 'name' => 'Adjusment'],
            ['identifiers' => 'brands', 'name' => 'Brands'],
            ['identifiers' => 'categories', 'name' => 'Categories'],
            ['identifiers' => 'items', 'name' => 'Items'],
            ['identifiers' => 'promo_products', 'name' => 'Promo Products'],
            ['identifiers' => 'buys', 'name' => 'Purchase'],
            ['identifiers' => 'produksi', 'name' => 'Productions'],
            ['identifiers' => 'orders', 'name' => 'Orders'],
            ['identifiers' => 'sales', 'name' => 'Sales'],
            ['identifiers' => 'delivery_note', 'name' => 'Delivery Note'],
            ['identifiers' => 'customer_groups', 'name' => 'Customer Groups'],
            ['identifiers' => 'customers', 'name' => 'Customers'],
            ['identifiers' => 'article_categories', 'name' => 'Article Categories'],
            ['identifiers' => 'article', 'name' => 'Article'],
            ['identifiers' => 'banners', 'name' => 'Banners'],
            ['identifiers' => 'visitors', 'name' => 'Visitors'],
            ['identifiers' => 'pages', 'name' => 'Pages'],
            ['identifiers' => 'menu_managements', 'name' => 'Menu Managements'],
            ['identifiers' => 'store', 'name' => 'Store'],
            ['identifiers' => 'human_resource', 'name' => 'Human Resource'],
            ['identifiers' => 'permissions', 'name' => 'Permissions'],
            ['identifiers' => 'products', 'name' => 'Products'],
            ['identifiers' => 'user_groups', 'name' => 'User Groups'],
            ['identifiers' => 'users', 'name' => 'Users'],
            ['identifiers' => 'companies', 'name' => 'Companies'],
            ['identifiers' => 'settings', 'name' => 'Settings'],
            ['identifiers' => 'payments', 'name' => 'Bank Accounts'],
            ['identifiers' => 'systems', 'name' => 'Systems'],
            ['identifiers' => 'settings_companies', 'name' => 'Settings Companies'],
        ];

        // $id = 1;

        // foreach ($modules as $key => $module) {
        //     Module::create([
        //         'id' => $id,
        //         'identifiers' => $module['identifiers'],
        //         'name' => $module['name']
        //     ]);
        //     $id++;
        // }

    }
}
