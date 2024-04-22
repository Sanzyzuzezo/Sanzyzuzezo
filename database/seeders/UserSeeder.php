<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_group_id' => 0,
            'name' => 'Diantara',
            'email' => 'dev@diantara.net',
            'password' => Hash::make('programmer'),
            'created_at' => date('Y-m-d H:i:s'),
            'company_id' => 0,
        ]);
    }
}
