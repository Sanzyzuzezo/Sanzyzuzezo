<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'customer_group_id' => '1',
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'address' => 'Bandung',
            'phone' => '082120023274',
            'password' => Hash::make('adminadmin'),
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'company_id' => 0
        ]);
    }
}
