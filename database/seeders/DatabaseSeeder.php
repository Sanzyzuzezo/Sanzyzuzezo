<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UserSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CustomerGroupSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CourierSeeder::class);
        $this->call(LocationSeeder::class);
        // jika seed permissions aktif komen seeder module supaya tidak double 
        // untuk acces modulnya karena di permission juga terdapat modulenya
        // $this->call(ModuleSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(SettingsCompanySeeder::class);

        //JANGAN DI NYALAKAN
        // $this->call(DeleteOrderSeeder::class);
        // $this->call(KecamatanSeeder::class);
    }
}
